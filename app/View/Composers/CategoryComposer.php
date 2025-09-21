<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\SmaCategory;

class CategoryComposer
{
    /**
     * Create a new category composer.
     */
    public function __construct()
    {
        //
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Get categories with most products (these are effectively the main categories)
        $menuCategories = SmaCategory::where(function($q) {
                $q->whereNull('parent_id')
                  ->orWhere('parent_id', '')
                  ->orWhere('parent_id', 0);
            })
            ->with(['subcategories' => function($query) {
                $query->withCount(['subcategoryProducts']) // Count products via subcategory_id
                      ->having('subcategory_products_count', '>', 0) // Only show subcategories with products
                      ->orderBy('name');
            }])
            ->withCount('products') // Count products via category_id for main categories
            ->having('products_count', '>', 0) // Only categories with products (use having for computed columns)
            ->orderBy('products_count', 'desc') // Order by most products first
            ->take(12) // Show top 12 categories
            ->get();

        $view->with('menuCategories', $menuCategories);
    }
}
