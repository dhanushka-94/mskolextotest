<?php

namespace App\Services;

use App\Models\SmaProduct;
use App\Models\SmaCategory;

class QueryOptimizationService
{
    /**
     * Get products with optimized query for listing pages
     */
    public static function getOptimizedProducts($filters = [])
    {
        $query = SmaProduct::active()
            ->select([
                'id', 'name', 'code', 'price', 'promo_price', 
                'quantity', 'category_id', 'product_status', 
                'image', 'promotion', 'details'
            ])
            ->with([
                'category:id,name,slug',
                'photos:id,product_id,photo',
                'status:id,status_name'
            ]);

        // Apply filters
        if (isset($filters['category_id'])) {
            $query->where(function($q) use ($filters) {
                $q->where('category_id', $filters['category_id'])
                  ->orWhere('subcategory_id', $filters['category_id']);
            });
        }

        if (isset($filters['in_stock_only']) && $filters['in_stock_only']) {
            $query->where('quantity', '>', 0);
        }

        if (isset($filters['promotion_only']) && $filters['promotion_only']) {
            $query->where('promotion', 1)
                  ->where('promo_price', '>', 0);
        }

        // Apply stock-priority sorting
        $query->orderByRaw("
            CASE 
                WHEN quantity > 10 THEN 1 
                WHEN quantity > 0 THEN 2 
                ELSE 3 
            END ASC
        ");

        // Apply secondary sorting
        if (isset($filters['sort'])) {
            switch ($filters['sort']) {
                case 'price_low':
                    $query->orderByRaw('COALESCE(promo_price, price) ASC');
                    break;
                case 'price_high':
                    $query->orderByRaw('COALESCE(promo_price, price) DESC');
                    break;
                case 'name':
                    $query->orderBy('name', 'ASC');
                    break;
                default:
                    $query->orderBy('id', 'DESC');
                    break;
            }
        } else {
            $query->orderBy('id', 'DESC');
        }

        return $query;
    }

    /**
     * Get single product with optimized relationships
     */
    public static function getOptimizedProduct($id)
    {
        return SmaProduct::with([
            'category:id,name,slug',
            'subcategory:id,name,slug',
            'photos:id,product_id,photo',
            'attributes.parent:id,attribute_name',
            'status:id,status_name'
        ])->findOrFail($id);
    }

    /**
     * Get related products optimized
     */
    public static function getRelatedProducts($categoryId, $excludeId, $limit = 4)
    {
        return SmaProduct::where('category_id', $categoryId)
            ->where('id', '!=', $excludeId)
            ->active()
            ->select(['id', 'name', 'price', 'promo_price', 'quantity', 'category_id', 'product_status', 'image', 'promotion'])
            ->with([
                'category:id,name,slug',
                'photos:id,product_id,photo',
                'status:id,status_name'
            ])
            ->orderByRaw("
                CASE 
                    WHEN quantity > 10 THEN 1 
                    WHEN quantity > 0 THEN 2 
                    ELSE 3 
                END ASC
            ")
            ->orderBy('id', 'DESC')
            ->take($limit)
            ->get();
    }

    /**
     * Performance tips for database optimization
     */
    public static function getPerformanceTips()
    {
        return [
            'Always use select() to limit columns fetched',
            'Use with() for eager loading to prevent N+1 queries',
            'Cache frequently accessed data',
            'Use pagination for large datasets',
            'Apply filters before ordering',
            'Use raw queries for complex ordering',
            'Limit relationship data with select clauses',
            'Use lazy loading for images',
            'Implement browser caching',
            'Optimize database indexes (if possible)',
        ];
    }
}
