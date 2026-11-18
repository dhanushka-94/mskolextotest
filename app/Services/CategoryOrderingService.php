<?php

namespace App\Services;

use App\Models\CategoryDisplayOrder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryOrderingService
{
    public const ORDER_MAP_CACHE_KEY = 'category_display_orders_map_v1';

    /**
     * Get the ordering configuration
     */
    protected static function getConfig()
    {
        return config('category-ordering');
    }

    /**
     * Cached map of category_id => sort_order from site DB.
     *
     * @return array<int, int>
     */
    public static function getDbOrderMap(): array
    {
        return Cache::remember(self::ORDER_MAP_CACHE_KEY, PerformanceCacheService::CATEGORY_CACHE_DURATION * 60, function () {
            return CategoryDisplayOrder::query()
                ->pluck('sort_order', 'category_id')
                ->mapWithKeys(fn ($order, $id) => [(int) $id => (int) $order])
                ->all();
        });
    }

    /**
     * Forget cached DB order map (call after admin reorder).
     */
    public static function clearOrderMapCache(): void
    {
        Cache::forget(self::ORDER_MAP_CACHE_KEY);
    }

    /**
     * Sort categories according to DB order, then config fallback.
     */
    public static function sortCategories(Collection $categories): Collection
    {
        $config = self::getConfig();
        $mainCategoryOrder = $config['main_categories'] ?? [];
        $dbOrders = self::getDbOrderMap();

        return $categories->sortBy(function ($category) use ($mainCategoryOrder, $dbOrders) {
            $id = (int) ($category->id ?? 0);
            if ($id && array_key_exists($id, $dbOrders)) {
                return $dbOrders[$id];
            }

            $name = $category->name ?? '';

            return 100000 + ($mainCategoryOrder[$name] ?? 999);
        })->values();
    }

    /**
     * Sort subcategories according to DB order, then config / default rules.
     */
    public static function sortSubcategories(Collection $subcategories, string $parentCategoryName): Collection
    {
        $config = self::getConfig();
        $dbOrders = self::getDbOrderMap();
        $specificOrder = $config['subcategory_ordering'][$parentCategoryName] ?? null;

        return $subcategories->sortBy(function ($subcategory) use ($dbOrders, $specificOrder, $config) {
            $id = (int) ($subcategory->id ?? 0);
            if ($id && array_key_exists($id, $dbOrders)) {
                return $dbOrders[$id];
            }

            $name = $subcategory->name ?? '';

            if (is_array($specificOrder)) {
                return 100000 + ($specificOrder[$name] ?? 999);
            }

            $rules = $config['default_rules'] ?? [];
            $brandNew = $rules['brand_new_pattern'] ?? 'BRAND NEW';
            $used = $rules['used_pattern'] ?? 'USED';

            if (str_contains($name, $brandNew)) {
                return 100000 + ($rules['brand_new_priority'] ?? 1);
            }
            if (str_contains($name, $used)) {
                return 100000 + ($rules['used_priority'] ?? 3);
            }

            return 100000 + ($rules['others_priority'] ?? 2);
        })->values();
    }

    /**
     * Apply default subcategory ordering (Brand New, Others, Used)
     */
    protected static function applyDefaultSubcategoryOrdering(Collection $subcategories): Collection
    {
        $config = self::getConfig();
        $rules = $config['default_rules'];

        return $subcategories->sortBy(function ($subcategory) use ($rules) {
            $name = $subcategory->name;

            if (str_contains($name, $rules['brand_new_pattern'])) {
                return $rules['brand_new_priority'] . '_' . $name;
            }

            if (str_contains($name, $rules['used_pattern'])) {
                return $rules['used_priority'] . '_' . $name;
            }

            return $rules['others_priority'] . '_' . $name;
        })->values();
    }

    /**
     * Sort categories with their subcategories
     */
    public static function sortCategoriesWithSubcategories(Collection $categories): Collection
    {
        $sortedCategories = self::sortCategories($categories);

        return $sortedCategories->map(function ($category) {
            if ($category->subcategories && $category->subcategories->count() > 0) {
                $category->subcategories = self::sortSubcategories(
                    $category->subcategories,
                    $category->name
                );
            }
            return $category;
        });
    }

    /**
     * Get category order number from config
     */
    public static function getCategoryOrder(string $categoryName): int
    {
        $config = self::getConfig();
        return $config['main_categories'][$categoryName] ?? 999;
    }

    /**
     * Get subcategory order number from config
     */
    public static function getSubcategoryOrder(string $subcategoryName, string $parentCategoryName): int
    {
        $config = self::getConfig();

        if (isset($config['subcategory_ordering'][$parentCategoryName])) {
            return $config['subcategory_ordering'][$parentCategoryName][$subcategoryName] ?? 999;
        }

        $rules = $config['default_rules'];

        if (str_contains($subcategoryName, $rules['brand_new_pattern'])) {
            return $rules['brand_new_priority'];
        }

        if (str_contains($subcategoryName, $rules['used_pattern'])) {
            return $rules['used_priority'];
        }

        return $rules['others_priority'];
    }

    /**
     * Persist ordered category IDs for a parent scope (null/0 = main categories).
     *
     * @param  array<int, int|string>  $orderedIds
     */
    public static function saveOrder(array $orderedIds, ?int $parentId = null): void
    {
        $orderedIds = array_values(array_map('intval', $orderedIds));

        foreach ($orderedIds as $index => $categoryId) {
            if ($categoryId <= 0) {
                continue;
            }

            CategoryDisplayOrder::updateOrCreate(
                ['category_id' => $categoryId],
                [
                    'parent_id' => $parentId && $parentId > 0 ? $parentId : null,
                    'sort_order' => $index,
                ]
            );
        }

        self::clearOrderMapCache();
        PerformanceCacheService::clearCategoryCaches();
    }

    /**
     * Remove DB overrides for main categories or for one parent's subcategories.
     */
    public static function resetOrder(?int $parentId = null): void
    {
        if ($parentId && $parentId > 0) {
            CategoryDisplayOrder::where('parent_id', $parentId)->delete();
        } else {
            CategoryDisplayOrder::whereNull('parent_id')->delete();
        }

        self::clearOrderMapCache();
        PerformanceCacheService::clearCategoryCaches();
    }

    /**
     * Remove configured MSK main categories from nav / category index (e.g. LAPTOP when Laptops menu is LaptopExpert).
     */
    public static function filterMskMainCategoriesHiddenFromMenu(Collection $categories): Collection
    {
        $excludeNames = config('laptopexpert.exclude_msk_menu_category_names', []);
        $excludeSlugs = config('laptopexpert.exclude_msk_menu_category_slugs', []);
        if (! is_array($excludeNames)) {
            $excludeNames = [];
        }
        if (! is_array($excludeSlugs)) {
            $excludeSlugs = [];
        }

        $nameSet = array_map('strtoupper', array_map('trim', $excludeNames));
        $slugSet = array_map('strtolower', array_map('trim', array_filter($excludeSlugs)));

        return $categories->filter(function ($category) use ($nameSet, $slugSet) {
            $name = strtoupper(trim($category->name ?? ''));
            if (in_array($name, $nameSet, true)) {
                return false;
            }
            $slug = strtolower(trim((string) ($category->slug ?? '')));
            if ($slug !== '' && in_array($slug, $slugSet, true)) {
                return false;
            }

            return true;
        })->values();
    }
}
