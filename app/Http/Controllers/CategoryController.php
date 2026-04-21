<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmaCategory;
use App\Models\SmaProduct;
use App\Models\LaptopExpertCategory;
use App\Models\LaptopExpertProduct;
use App\Models\LaptopExpertProductStatus;
use App\Models\SmaAttribute;

class CategoryController extends Controller
{
    public function index()
    {
        // Use cached categories with product counts for better performance
        $categories = \App\Services\PerformanceCacheService::getMainCategories();

        return view('categories.index', compact('categories'));
    }

    public function show(string $category, Request $request)
    {
        $mskCategory = SmaCategory::where('slug', $category)->orWhere('id', $category)->first();
        $lpCategory = LaptopExpertCategory::where('slug', $category)->orWhere('id', $category)->first();

        $isLaptopExpert = false;
        if ($mskCategory) {
            $category = $mskCategory;
            $productModel = SmaProduct::class;
        } elseif ($lpCategory) {
            $category = $lpCategory;
            $productModel = LaptopExpertProduct::class;
            $isLaptopExpert = true;
        } else {
            abort(404);
        }

        view()->share('catalogSource', $isLaptopExpert ? 'laptopexpert' : 'msk');
        
        // Get products query
        $productsQuery = $productModel::where(function($query) use ($category) {
            $query->where('category_id', $category->id)
                  ->orWhere('subcategory_id', $category->id);
        })
        ->where('hide', 0)
        ->select([
            'id',
            'name',
            'code',
            'price',
            'promo_price',
            'quantity',
            'track_quantity',
            'hide',
            'category_id',
            'subcategory_id',
            'product_status',
            'image',
            'promotion',
            'details',
            'slug',
        ])
        ->with([
            'category:id,name,slug',
            'photos:id,product_id,photo',
            'attributes.parent:id,attribute_name',
            'status:id,status_name'
        ]);

        // Apply product status filter (separate from attributes)
        $this->applyStatusFilters($productsQuery, $request, $productModel);

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
        $availableAttributes = $isLaptopExpert ? collect() : $this->getCategoryAttributes($category->id);
        
        // Get available product statuses for this category
        $availableStatuses = $isLaptopExpert ? collect() : $this->getCategoryStatuses($category->id);
        
        // Get price range for this category
        $priceRange = $this->getPriceRange($category->id, $productModel);

        // Handle AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            // Transform products for JSON response
            $transformedProducts = $products->getCollection()->map(function ($product) {
                $product->append([
                    'main_image',
                    'final_price',
                    'is_on_sale',
                    'stock_quantity',
                    'slug',
                ]);

                // Ensure status is loaded and included in response
                if ($product->relationLoaded('status')) {
                    if ($product->status) {
                        $product->status_data = [
                            'id' => $product->status->id,
                            'status_name' => $product->status->status_name,
                        ];
                    }
                } else {
                    $product->load('status:id,status_name');
                    if ($product->status) {
                        $product->status_data = [
                            'id' => $product->status->id,
                            'status_name' => $product->status->status_name,
                        ];
                    }
                }

                // Arrays: force stock_quantity from raw selected `quantity` only (LE + MSK; avoids accessor/cast/JSON quirks).
                $payload = $product->toArray();
                $payload['stock_quantity'] = SmaProduct::listingQuantityFromRaw($product->getAttributes()['quantity'] ?? null);

                return $payload;
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

        return view('categories.show', compact('category', 'products', 'availableAttributes', 'availableStatuses', 'priceRange'));
    }

    /**
     * Apply product status filters (Pre Order, Coming Soon, etc.)
     */
    private function applyStatusFilters($query, $request, $productModel = SmaProduct::class)
    {
        $statusNames = [];
        
        // Check if status filter is requested directly (can be array from checkboxes)
        if ($request->filled('status')) {
            $statusInput = $request->input('status');
            if (is_array($statusInput)) {
                $statusNames = array_merge($statusNames, $statusInput);
            } else {
                $statusNames[] = $statusInput;
            }
        }
        
        // Check if status filters are passed in attributes array (common mistake)
        // Look for status names in the attributes array
        if ($request->has('attributes') && is_array($request->input('attributes'))) {
            foreach ($request->input('attributes') as $parentName => $selectedIds) {
                if (is_array($selectedIds)) {
                    foreach ($selectedIds as $selectedId) {
                        // Check if the selected value is a status name (string) not an attribute ID (numeric)
                        if (is_string($selectedId) && in_array($selectedId, ['Pre Order', 'Coming Soon'])) {
                            $statusNames[] = $selectedId;
                        }
                    }
                }
            }
        }
        
        // Apply status filter if any status names were found
        if (!empty($statusNames)) {
            $statusNames = array_unique($statusNames); // Remove duplicates
            $statusModel = $productModel === LaptopExpertProduct::class
                ? LaptopExpertProductStatus::class
                : \App\Models\SmaProductStatus::class;
            $statusIds = $statusModel::whereIn('status_name', $statusNames)
                ->pluck('id')
                ->toArray();
            
            if (!empty($statusIds)) {
                $query->whereIn('product_status', $statusIds);
            }
        }
    }

    /**
     * Apply attribute filters to the product query
     * Filters are applied per parent group: products must match ALL selected groups
     * Within each group, products must have at least one of the selected attributes (OR logic)
     * Between groups, products must match all groups (AND logic)
     * Example: MANUFACTURE: MSI + VRAM: 8GB = products with (MSI) AND (8GB)
     */
    private function applyAttributeFilters($query, $request)
    {
        if ($request->has('attributes') && is_array($request->input('attributes'))) {
            $attributeGroups = [];
            
            foreach ($request->input('attributes') as $parentName => $selectedIds) {
                if (is_array($selectedIds) && !empty($selectedIds)) {
                    // Filter out status names - only include numeric attribute IDs
                    // Status names are strings like "Pre Order" or "Coming Soon"
                    // Attribute IDs should be numeric
                    $numericIds = array_filter($selectedIds, function($id) {
                        // Only include if it's numeric (attribute ID) and not a status name
                        return is_numeric($id) && !in_array($id, ['Pre Order', 'Coming Soon']);
                    });
                    
                    // Convert to integers for attribute IDs
                    $attributeIds = [];
                    foreach ($numericIds as $id) {
                        if (is_numeric($id)) {
                            $attributeIds[] = (int) $id;
                }
            }
            
                    // Only add if we have valid attribute IDs for this parent group
            if (!empty($attributeIds)) {
                        $attributeGroups[$parentName] = $attributeIds;
                    }
                }
            }
            
            // Apply filters: products must match at least one attribute from each selected group
            // This means if MANUFACTURE: MSI is selected, only show products with MSI
            if (!empty($attributeGroups)) {
                $query->where(function($groupQuery) use ($attributeGroups) {
                    foreach ($attributeGroups as $parentName => $attributeIds) {
                        // For each parent group, products must have at least one of the selected attributes
                        $groupQuery->whereHas('attributes', function($attrQuery) use ($attributeIds) {
                    $attrQuery->whereIn('sma_attributes.id', $attributeIds)
                             ->where('sma_product_attributes.status', 1);
                        });
                    }
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
     * Get available product statuses for products in a category
     */
    private function getCategoryStatuses($categoryId)
    {
        // Get statuses that exist for products in this category
        $statusIds = SmaProduct::where(function($query) use ($categoryId) {
            $query->where('category_id', $categoryId)
                  ->orWhere('subcategory_id', $categoryId);
        })
        ->where('hide', 0)
        ->whereNotNull('product_status')
        ->distinct()
        ->pluck('product_status')
        ->filter()
        ->toArray();

        if (empty($statusIds)) {
            return [];
        }

        // Get status details with product counts
        $statuses = \App\Models\SmaProductStatus::whereIn('id', $statusIds)
            ->get()
            ->map(function($status) use ($categoryId) {
                // Count products with this status in this category
                $productCount = SmaProduct::where(function($query) use ($categoryId) {
                    $query->where('category_id', $categoryId)
                          ->orWhere('subcategory_id', $categoryId);
                })
                ->where('hide', 0)
                ->where('product_status', $status->id)
                ->count();

                return [
                    'id' => $status->id,
                    'name' => $status->status_name,
                    'count' => $productCount
                ];
            })
            ->filter(function($status) {
                // Only include "Pre Order" and "Coming Soon" statuses
                return in_array($status['name'], ['Pre Order', 'Coming Soon']) && $status['count'] > 0;
            })
            ->sortBy('name')
            ->values()
            ->toArray();

        return $statuses;
    }

    /**
     * Get price range for products in a category
     */
    private function getPriceRange($categoryId, $productModel = SmaProduct::class)
    {
        $priceData = $productModel::where(function($query) use ($categoryId) {
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