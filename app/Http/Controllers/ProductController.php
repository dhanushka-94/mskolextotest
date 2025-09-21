<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmaProduct;
use App\Models\SmaCategory;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = SmaProduct::active()
            ->select(['id', 'name', 'code', 'price', 'promo_price', 'quantity', 'category_id', 'product_status', 'image', 'promotion', 'details'])
            ->with([
                'category:id,name,slug',
                'photos:id,product_id,photo',
                'status:id,status_name'
            ]);

        // Filter by category
        if ($request->has('category') && $request->category) {
            $category = SmaCategory::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('details', 'like', "%{$searchTerm}%")
                  ->orWhere('code', 'like', "%{$searchTerm}%");
            });
        }

        // Apply stock-priority sorting first (in-stock first, low stock middle, out-of-stock last)
        $query->orderByRaw("
            CASE 
                WHEN quantity > 10 THEN 1 
                WHEN quantity > 0 THEN 2 
                ELSE 3 
            END ASC
        ");

        // Sort functionality (secondary sorting)
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderByRaw('COALESCE(promo_price, price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(promo_price, price) DESC');
                break;
            case 'name':
                $query->orderBy('name', 'ASC');
                break;
            case 'latest':
            default:
                $query->orderBy('id', 'DESC');
                break;
        }

        $products = $query->paginate(12);
        $categories = \App\Services\PerformanceCacheService::getNavigationCategories();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(SmaCategory $category, SmaProduct $product)
    {
        \Log::info("ProductController@show - Category: {$category->name} (ID: {$category->id}), Product: {$product->name} (ID: {$product->id}, Category: {$product->category_id})");
        
        // Verify product belongs to this category
        if ($product->category_id !== $category->id && $product->subcategory_id !== $category->id) {
            \Log::error("Product {$product->id} does not belong to category {$category->id}. Product category: {$product->category_id}, subcategory: {$product->subcategory_id}");
            abort(404, 'Product not found in this category');
        }
        
        $product->load(['category', 'photos', 'attributes.parent', 'status']);

        // Get related products from same category
        $relatedProducts = SmaProduct::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->with(['category', 'photos', 'status'])
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('q');
        
        if (!$searchTerm) {
            return redirect()->route('products.index');
        }

        // Build search query
        $query = SmaProduct::active()
            ->where('quantity', '>', 0) // Hide out of stock products
            ->where(function($subQuery) use ($searchTerm) {
                $subQuery->where('name', 'like', "%{$searchTerm}%")
                         ->orWhere('details', 'like', "%{$searchTerm}%")
                         ->orWhere('code', 'like', "%{$searchTerm}%");
            })
            ->select(['id', 'name', 'code', 'price', 'promo_price', 'quantity', 'category_id', 'product_status', 'image', 'details'])
            ->with([
                'category:id,name,slug',
                'photos:id,product_id,photo',
                'status:id,status_name'
            ]);

        // Filter by category if specified
        if ($request->has('category') && $request->category) {
            $category = SmaCategory::where(function($q) use ($request) {
                $q->where('slug', $request->category)
                  ->orWhere('id', $request->category);
            })->first();
            
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Apply sorting
        switch ($request->get('sort', 'relevance')) {
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default: // relevance
                // Apply stock-priority sorting first
                $query->orderByRaw("
                    CASE 
                        WHEN quantity > 10 THEN 1 
                        WHEN quantity > 0 THEN 2 
                        ELSE 3 
                    END ASC
                ");
                // Then sort by relevance (name match first, then description)
                $query->orderByRaw("
                    CASE 
                        WHEN name LIKE '%{$searchTerm}%' THEN 1 
                        ELSE 2 
                    END ASC
                ");
                break;
        }

        $products = $query->paginate(12);
        $categories = \App\Services\PerformanceCacheService::getNavigationCategories();

        return view('products.search', compact('products', 'categories', 'searchTerm'));
    }

    public function promotions(Request $request)
    {
        // Get category filter
        $categoryId = null;
        if ($request->has('category') && $request->category) {
            $category = SmaCategory::where('slug', $request->category)->first();
            $categoryId = $category ? $category->id : null;
        }

        // For now, use direct query for pagination support (cache optimization for later)
        $query = SmaProduct::active()
            ->select(['id', 'name', 'price', 'promo_price', 'quantity', 'category_id', 'subcategory_id', 'product_status', 'image', 'promotion', 'details'])
            ->where('promotion', 1)
            ->where('promo_price', '>', 0)
            ->where('quantity', '>', 0) // Hide out of stock products
            ->with([
                'category:id,name,slug',
                'subcategory:id,name,slug',
                'photos:id,product_id,photo',
                'status:id,status_name'
            ])
            ->where(function($q) {
                $q->whereNull('start_date')
                  ->orWhereNull('end_date')
                  ->orWhere(function($dateQuery) {
                      $dateQuery->where('start_date', '<=', now())
                               ->where('end_date', '>=', now());
                  });
            });

        // Filter by category
        if ($categoryId) {
            $query->where(function($q) use ($categoryId) {
                $q->where('category_id', $categoryId)
                  ->orWhere('subcategory_id', $categoryId);
            });
        }

        // Sort by discount percentage (highest discount first)
        $query->orderByRaw('((price - promo_price) / price) DESC');

        // Apply stock-priority sorting as secondary
        $query->orderByRaw("
            CASE 
                WHEN quantity > 10 THEN 1 
                WHEN quantity > 0 THEN 2 
                ELSE 3 
            END ASC
        ");

        $products = $query->paginate(12);
        $categories = \App\Services\PerformanceCacheService::getNavigationCategories();

        return view('products.promotions', compact('products', 'categories'));
    }
}
