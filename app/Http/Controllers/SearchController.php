<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmaProduct;
use App\Models\SmaCategory;

class SearchController extends Controller
{
    public function suggestions(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        // Get product suggestions with category information
        $products = SmaProduct::active()
            ->with('category:id,name,slug')
            ->where('name', 'like', "%{$query}%")
            ->take(5)
            ->get(['id', 'name', 'price', 'promo_price', 'slug', 'category_id']);

        // Get category suggestions
        $categories = SmaCategory::where('name', 'like', "%{$query}%")
            ->take(3)
            ->get(['id', 'name', 'slug']);

        return response()->json([
            'products' => $products->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->final_price,
                    'slug' => $product->slug ?: $product->id,
                    'category' => $product->category ? [
                        'id' => $product->category->id,
                        'name' => $product->category->name,
                        'slug' => $product->category->slug ?: $product->category->id
                    ] : [
                        'id' => 'uncategorized',
                        'name' => 'Uncategorized',
                        'slug' => 'uncategorized'
                    ],
                    'type' => 'product'
                ];
            }),
            'categories' => $categories->map(function($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug ?: $category->id,
                    'type' => 'category'
                ];
            })
        ]);
    }
}
