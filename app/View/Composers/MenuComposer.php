<?php

namespace App\View\Composers;

use App\Models\SmaCategory;
use App\Models\LaptopExpertCategory;
use Illuminate\View\View;

class MenuComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $mskCategories = SmaCategory::mainCategories()
            ->with(['subcategories' => function($query) {
                $query->withCount(['subcategoryProducts as subcategory_products_count' => function($q) {
                    $q->where('hide', 0);
                }]);
            }])
            ->withCount(['products as products_count' => function($query) {
                $query->where('hide', 0);
            }])
            ->get();

        $mskCategories = \App\Services\CategoryOrderingService::filterMskMainCategoriesHiddenFromMenu($mskCategories);

        $mskCategories = \App\Services\CategoryOrderingService::sortCategoriesWithSubcategories($mskCategories)
            ->map(function ($category) {
                $category->source = 'msk';
                return $category;
            });

        $lpConfig = config('category-ordering.laptopexpert', []);
        $lpMainOrder = $lpConfig['main_category_order'] ?? [];
        $lpSubOrder = $lpConfig['subcategory_order'] ?? [];

        $laptopExpertMenuCategories = collect();
        if (!empty($lpMainOrder)) {
            $laptopExpertMenuCategories = LaptopExpertCategory::query()
                ->whereIn('id', $lpMainOrder)
                ->with('subcategories')
                ->get()
                ->sortBy(function ($category) use ($lpMainOrder) {
                    $index = array_search((int) $category->id, $lpMainOrder, true);
                    return $index === false ? 9999 : $index;
                })
                ->values()
                ->map(function ($category) use ($lpSubOrder) {
                    $orderedIds = $lpSubOrder[(int) $category->id] ?? [];
                    if (!empty($orderedIds)) {
                        $category->setRelation(
                            'subcategories',
                            $category->subcategories->sortBy(function ($sub) use ($orderedIds) {
                                $index = array_search((int) $sub->id, $orderedIds, true);
                                return $index === false ? 9999 : $index;
                            })->values()
                        );
                    }
                    $category->source = 'laptopexpert';
                    return $category;
                });
        }

        $view->with('menuCategories', $mskCategories->values());
        $view->with('laptopExpertMenuCategories', $laptopExpertMenuCategories);
        $view->with(
            'laptopExpertMenuLabel',
            (string) (config('category-ordering.laptopexpert.menu_label') ?? 'Laptops')
        );
    }
}
