<?php

namespace App\View\Composers;

use App\Models\SmaCategory;
use Illuminate\View\View;

class MenuComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $mskCategories = SmaCategory::mainCategories()
            ->with(['subcategories' => function ($query) {
                $query->withCount(['subcategoryProducts as subcategory_products_count' => function ($q) {
                    $q->where('hide', 0);
                }]);
            }])
            ->withCount(['products as products_count' => function ($query) {
                $query->where('hide', 0);
            }])
            ->get();

        $mskCategories = \App\Services\CategoryOrderingService::sortCategoriesWithSubcategories($mskCategories)
            ->map(function ($category) {
                $category->source = 'msk';
                return $category;
            });

        $view->with('menuCategories', $mskCategories->values());
        $view->with('laptopExpertMenuCategories', collect());
        $view->with('laptopExpertMenuLabel', 'Laptops');
    }
}
