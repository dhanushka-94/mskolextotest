<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmaCategory;
use App\Models\SmaProduct;
use App\Models\SmaAttribute;

class CategoryController extends Controller
{
    public function index()
    {
        // Use cached categories with product counts for better performance
        $categories = \App\Services\PerformanceCacheService::getMainCategories();

        return view('categories.index', compact('categories'));
    }

    public function show(SmaCategory $category, Request $request)
    {
        
        // Get products query
        $productsQuery = SmaProduct::where(function($query) use ($category) {
            $query->where('category_id', $category->id)
                  ->orWhere('subcategory_id', $category->id);
        })
        ->where('hide', 0)
        ->select(['id', 'name', 'code', 'price', 'promo_price', 'quantity', 'category_id', 'subcategory_id', 'product_status', 'image', 'promotion', 'details'])
        ->with([
            'category:id,name,slug',
            'photos:id,product_id,photo',
            'attributes.parent:id,attribute_name',
            'status:id,status_name'
        ]);

        // Apply attribute filters
        $this->applyAttributeFilters($productsQuery, $request);

        // Apply price range filter
        if ($request->filled('min_price') || $request->filled('max_price')) {
            if ($request->filled('min_price')) {
                $productsQuery->where('price', '>=', $request->min_price);
            }
            if ($request->filled('max_price')) {
                $productsQuery->where('price', '<=', $request->max_price);
            }
        }

        // Apply search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $productsQuery->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('details', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('code', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Apply stock-priority sorting (out of stock products last)
        $productsQuery->orderByRaw("
            CASE 
                WHEN quantity > 10 THEN 1 
                WHEN quantity > 0 THEN 2 
                ELSE 4 
            END ASC
        ");

        // Apply secondary sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_high':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'name':
                $productsQuery->orderBy('name', 'asc');
                break;
            default: // latest
                $productsQuery->orderBy('id', 'desc');
                break;
        }

        $products = $productsQuery->paginate(12);
        
        // Debug logging for USED LAPTOP category issues
        if (stripos($category->name, 'used') !== false && stripos($category->name, 'laptop') !== false) {
            \Log::info("USED LAPTOP Debug - Category: {$category->name} (ID: {$category->id})");
            \Log::info("USED LAPTOP Debug - Total products: {$products->total()}");
            \Log::info("USED LAPTOP Debug - Current page: {$products->currentPage()}");
            \Log::info("USED LAPTOP Debug - Last page: {$products->lastPage()}");
        }
        
        // Get available attributes for this category
        $availableAttributes = $this->getCategoryAttributes($category->id);
        
        // Get price range for this category
        $priceRange = $this->getPriceRange($category->id);

        // Handle AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            // Transform products for JSON response
            $transformedProducts = $products->getCollection()->map(function ($product) {
                $product->append([
                    'main_image', 
                    'final_price',
                    'is_on_sale',
                    'stock_quantity'
                ]);
                return $product;
            });
            
            return response()->json([
                'success' => true,
                'products' => $transformedProducts,
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                    'from' => $products->firstItem(),
                    'to' => $products->lastItem(),
                ],
                'filters' => $availableAttributes,
                'priceRange' => $priceRange
            ]);
        }

        return view('categories.show', compact('category', 'products', 'availableAttributes', 'priceRange'));
    }

    /**
     * Apply attribute filters to the product query
     */
    private function applyAttributeFilters($query, $request)
    {
        if ($request->has('attributes') && is_array($request->input('attributes'))) {
            $attributeIds = [];
            
            foreach ($request->input('attributes') as $parentName => $selectedIds) {
                if (is_array($selectedIds)) {
                    $attributeIds = array_merge($attributeIds, $selectedIds);
                }
            }
            
            if (!empty($attributeIds)) {
                $query->whereHas('attributes', function($attrQuery) use ($attributeIds) {
                    $attrQuery->whereIn('sma_attributes.id', $attributeIds)
                             ->where('sma_product_attributes.status', 1);
                });
            }
        }
    }

    /**
     * Get available attributes for products in a category
     */
    private function getCategoryAttributes($categoryId)
    {
        // Get all attribute IDs used by products in this category
        $attributeIds = \DB::connection('products_db')->table('sma_product_attributes')
            ->join('sma_products', 'sma_product_attributes.product_id', '=', 'sma_products.id')
            ->where(function($query) use ($categoryId) {
                $query->where('sma_products.category_id', $categoryId)
                      ->orWhere('sma_products.subcategory_id', $categoryId);
            })
            ->where('sma_products.hide', 0)
            ->where('sma_product_attributes.status', 1)
            ->pluck('sma_product_attributes.attribute_id')
            ->unique();

        if ($attributeIds->isEmpty()) {
            return [];
        }

        // Get the attributes grouped by their parent
        $attributes = SmaAttribute::whereIn('id', $attributeIds)
            ->with('parent')
            ->where('status', 1)
            ->get()
            ->groupBy(function($attribute) {
                return $attribute->parent ? $attribute->parent->attribute_name : 'Other';
            });

        // Transform to include counts
        $result = [];
        foreach ($attributes as $parentName => $attributeGroup) {
            if ($parentName === 'Other') continue; // Skip orphaned attributes
            
            $result[$parentName] = $attributeGroup->map(function($attribute) use ($categoryId) {
                // Count products that have this attribute in this category
                $productCount = \DB::connection('products_db')->table('sma_product_attributes')
                    ->join('sma_products', 'sma_product_attributes.product_id', '=', 'sma_products.id')
                    ->where('sma_product_attributes.attribute_id', $attribute->id)
                    ->where(function($query) use ($categoryId) {
                        $query->where('sma_products.category_id', $categoryId)
                              ->orWhere('sma_products.subcategory_id', $categoryId);
                    })
                    ->where('sma_products.hide', 0)
                    ->where('sma_product_attributes.status', 1)
                    ->count();

                return [
                    'id' => $attribute->id,
                    'name' => $attribute->attribute_name,
                    'count' => $productCount
                ];
            })->sortBy('name')->values();
        }

        // Sort by most used attributes first
        return collect($result)->sortByDesc(function($attributes) {
            return $attributes->sum('count');
        })->take(6)->toArray(); // Limit to top 6 attribute categories
    }

    /**
     * Get price range for products in a category
     */
    private function getPriceRange($categoryId)
    {
        $priceData = SmaProduct::where(function($query) use ($categoryId) {
            $query->where('category_id', $categoryId)
                  ->orWhere('subcategory_id', $categoryId);
        })
        ->where('hide', 0)
        ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
        ->first();

        return [
            'min' => (float) ($priceData->min_price ?? 0),
            'max' => (float) ($priceData->max_price ?? 100000)
        ];
    }
}