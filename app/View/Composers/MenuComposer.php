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
        $menuCategories = SmaCategory::mainCategories()
            ->with(['subcategories' => function($query) {
                $query->withCount(['subcategoryProducts as subcategory_products_count' => function($q) {
                    $q->where('hide', 0);
                }])
                ->orderBy('sort_order', 'asc')
                ->orderBy('name', 'asc'); // Show all subcategories in logical order
            }])
            ->withCount(['products as products_count' => function($query) {
                $query->where('hide', 0);
            }])
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->get(); // Show all main categories in logical order

        $view->with('menuCategories', $menuCategories);
    }
}
