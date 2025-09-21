<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmaProduct;
use App\Models\SmaCategory;

class HomeController extends Controller
{
    public function index()
    {
        // Get cached featured products for better performance
        $featuredProducts = \App\Services\PerformanceCacheService::getFeaturedProducts(8);

        // Get cached categories (limited to 6 for homepage)
        $categories = \App\Services\PerformanceCacheService::getNavigationCategories()->take(6);

        // Get cached latest products
        $latestProducts = \App\Services\PerformanceCacheService::getLatestProducts(4);

        return view('home', compact('featuredProducts', 'categories', 'latestProducts'));
    }
}
