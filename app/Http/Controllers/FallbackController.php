<?php

namespace App\Http\Controllers;

use App\Models\SmaCategory;
use App\Models\SmaProduct;
use Illuminate\Http\Request;

class FallbackController extends Controller
{
    /**
     * Handle unknown URL patterns and suggest alternatives
     */
    public function handleUnknownUrl(Request $request)
    {
        $path = $request->path();
        $segments = explode('/', $path);
        
        \Log::info("FallbackController - Unknown URL: $path");
        
        // If it looks like a category/product pattern
        if (count($segments) == 2) {
            [$categorySlug, $productSlug] = $segments;
            
            // Try to find similar categories
            $similarCategories = SmaCategory::where('name', 'like', '%' . str_replace('-', ' ', $categorySlug) . '%')
                ->orWhere('slug', 'like', '%' . $categorySlug . '%')
                ->limit(5)
                ->get();
            
            // Try to find similar products
            $similarProducts = SmaProduct::where('name', 'like', '%' . str_replace('-', ' ', $productSlug) . '%')
                ->with('category')
                ->limit(5)
                ->get();
            
            return view('errors.suggest-alternatives', [
                'requestedCategory' => $categorySlug,
                'requestedProduct' => $productSlug,
                'similarCategories' => $similarCategories,
                'similarProducts' => $similarProducts,
                'path' => $path
            ]);
        }
        
        // Default 404
        abort(404);
    }
}
