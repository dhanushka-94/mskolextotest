<?php

namespace App\Services;

use Illuminate\Support\Collection;

class CategoryOrderingService
{
    /**
     * Get the ordering configuration
     */
    protected static function getConfig()
    {
        return config('category-ordering');
    }

    /**
     * Sort categories according to the configured order
     */
    public static function sortCategories(Collection $categories): Collection
    {
        $config = self::getConfig();
        $mainCategoryOrder = $config['main_categories'];

        return $categories->sortBy(function ($category) use ($mainCategoryOrder) {
            // Get the order from config, default to 999 if not found
            return $mainCategoryOrder[$category->name] ?? 999;
        })->values();
    }

    /**
     * Sort subcategories according to the configured order
     */
    public static function sortSubcategories(Collection $subcategories, string $parentCategoryName): Collection
    {
        $config = self::getConfig();
        
        // Check if we have specific ordering for this category
        if (isset($config['subcategory_ordering'][$parentCategoryName])) {
            $specificOrder = $config['subcategory_ordering'][$parentCategoryName];
            
            return $subcategories->sortBy(function ($subcategory) use ($specificOrder) {
                return $specificOrder[$subcategory->name] ?? 999;
            })->values();
        }

        // Apply default ordering rules
        return self::applyDefaultSubcategoryOrdering($subcategories);
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
            
            // Brand New items first
            if (str_contains($name, $rules['brand_new_pattern'])) {
                return $rules['brand_new_priority'] . '_' . $name;
            }
            
            // Used items last
            if (str_contains($name, $rules['used_pattern'])) {
                return $rules['used_priority'] . '_' . $name;
            }
            
            // Others in the middle, sorted by name
            return $rules['others_priority'] . '_' . $name;
        })->values();
    }

    /**
     * Sort categories with their subcategories
     */
    public static function sortCategoriesWithSubcategories(Collection $categories): Collection
    {
        // First sort the main categories
        $sortedCategories = self::sortCategories($categories);

        // Then sort subcategories for each category
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

        // Apply default rules
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
