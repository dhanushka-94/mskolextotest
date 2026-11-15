<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmaProduct;
use App\Models\SmaCategory;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        // Get promotion products directly (bypassing cache for debugging)
        $promotionProducts = SmaProduct::active()
            ->select(['id', 'name', 'price', 'promo_price', 'quantity', 'category_id', 'subcategory_id', 'product_status', 'image', 'promotion'])
            ->where('promotion', 1)
            ->where('promo_price', '>', 0)
            ->where('quantity', '>', 0)
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
            })
            ->orderBy('id', 'DESC')
            ->orderByRaw('((price - promo_price) / price) DESC')
            ->orderByRaw("
                CASE 
                    WHEN quantity > 10 THEN 1 
                    WHEN quantity > 0 THEN 2 
                    ELSE 3 
                END ASC
            ")
            ->take(8)
            ->get();

        // Get cached categories (limited to 6 for homepage)
        $categories = \App\Services\PerformanceCacheService::getNavigationCategories()->take(6);

        // Get cached latest products
        $latestProducts = \App\Services\PerformanceCacheService::getLatestProducts(4);

        // Get active sliders ordered by display order
        $sliders = Slider::active()->ordered()->get();

        // Get all happy customer images from the folder
        $happyCustomerImages = [];
        $customerImagesPath = public_path('images/happy-customers');
        
        if (is_dir($customerImagesPath)) {
            $files = scandir($customerImagesPath);
            foreach ($files as $file) {
                // Only include .jpg and .jpeg files, exclude duplicates (prefer .jpg over .jpeg)
                if (preg_match('/\.(jpg|jpeg)$/i', $file)) {
                    // Skip .jpeg files if .jpg version exists
                    $baseName = pathinfo($file, PATHINFO_FILENAME);
                    $jpgFile = $baseName . '.jpg';
                    $jpegFile = $baseName . '.jpeg';
                    
                    // Only add if it's a .jpg file, or if it's a .jpeg and no .jpg exists
                    if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'jpg' || 
                        (strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'jpeg' && !in_array($jpgFile, $files))) {
                        $happyCustomerImages[] = 'images/happy-customers/' . $file;
                    }
                }
            }
            
            // Sort images naturally (so hc00 (1).jpg comes before hc00 (10).jpg)
            natsort($happyCustomerImages);
            $happyCustomerImages = array_values($happyCustomerImages);
        }

        $coreShowcase = $this->coreShowcaseCategories();
        $brandShowcase = $this->brandShowcaseCategories();

        return view('home', compact('promotionProducts', 'categories', 'latestProducts', 'sliders', 'happyCustomerImages', 'coreShowcase', 'brandShowcase'));
    }

    /**
     * Laptops & PC Builds for homepage top (SEO-friendly URLs from live categories).
     */
    private function coreShowcaseCategories(): array
    {
        $order = ['LAPTOP', 'PC BUILD'];

        $categories = SmaCategory::query()
            ->whereIn('name', $order)
            ->where(function ($q) {
                $q->whereNull('parent_id')
                    ->orWhere('parent_id', '')
                    ->orWhere('parent_id', 0);
            })
            ->with(['subcategories' => function ($q) {
                $q->select(['id', 'name', 'slug', 'parent_id'])
                    ->orderBy('name');
            }])
            ->get()
            ->keyBy(fn ($c) => strtoupper(trim($c->name)));

        $fallbacks = [
            'LAPTOP' => [
                'slug' => 'laptop',
                'id' => 381,
                'subs' => [
                    ['name' => 'Brand New Laptop', 'slug' => 'brand-new-laptop'],
                    ['name' => 'Used Laptop', 'slug' => 'used-laptop'],
                ],
            ],
            'PC BUILD' => [
                'slug' => 'pc-build',
                'id' => 380,
                'subs' => [
                    ['name' => 'Brand New PC Build', 'slug' => 'brand-new-pc-build'],
                    ['name' => 'Used PC Build', 'slug' => 'used-pc-build'],
                ],
            ],
        ];

        $preferredUrls = [
            'LAPTOP' => 'brand-new-laptop',
            'PC BUILD' => 'brand-new-pc-build',
        ];

        $result = [];
        foreach ($order as $name) {
            $cat = $categories->get($name);
            $fb = $fallbacks[$name] ?? null;
            $key = $name === 'PC BUILD' ? 'pc-build' : 'laptop';

            $url = isset($preferredUrls[$name])
                ? route('categories.show', $preferredUrls[$name])
                : ($cat
                    ? route('categories.show', $cat->slug ?: $cat->id)
                    : ($fb ? route('categories.show', $fb['slug'] ?: $fb['id']) : '#'));

            $subs = [];
            if ($cat && $cat->subcategories->isNotEmpty()) {
                foreach ($cat->subcategories as $sub) {
                    $subs[] = [
                        'name' => $sub->name,
                        'url' => route('categories.show', $sub->slug ?: $sub->id),
                    ];
                }
            } elseif ($fb && ! empty($fb['subs'])) {
                foreach ($fb['subs'] as $sub) {
                    $subs[] = [
                        'name' => $sub['name'],
                        'url' => route('categories.show', $sub['slug']),
                    ];
                }
            }

            $result[] = [
                'key' => $key,
                'name' => $cat?->name ?? $name,
                'url' => $url,
                'subcategories' => $subs,
            ];
        }

        return $result;
    }

    /**
     * Baseus & Ugreen for homepage (SEO-friendly URLs from live categories).
     */
    private function brandShowcaseCategories(): array
    {
        $order = ['BASEUS', 'UGREEN'];

        $categories = SmaCategory::query()
            ->whereIn('name', $order)
            ->where(function ($q) {
                $q->whereNull('parent_id')
                    ->orWhere('parent_id', '')
                    ->orWhere('parent_id', 0);
            })
            ->with(['subcategories' => function ($q) {
                $q->select(['id', 'name', 'slug', 'parent_id'])
                    ->orderBy('name');
            }])
            ->get()
            ->keyBy(fn ($c) => strtoupper(trim($c->name)));

        $fallbacks = [
            'BASEUS' => ['slug' => 'baseus', 'id' => 510],
            'UGREEN' => ['slug' => 'ugreen', 'id' => 512],
        ];

        $result = [];
        foreach ($order as $name) {
            $cat = $categories->get($name);
            $fb = $fallbacks[$name] ?? null;

            $key = strtolower($name);
            $url = $cat
                ? route('categories.show', $cat->slug ?: $cat->id)
                : ($fb ? route('categories.show', $fb['slug'] ?: $fb['id']) : '#');

            $subs = [];
            if ($cat && $cat->subcategories->isNotEmpty()) {
                foreach ($cat->subcategories as $sub) {
                    $subs[] = [
                        'name' => $sub->name,
                        'url' => route('categories.show', $sub->slug ?: $sub->id),
                    ];
                }
            } elseif ($name === 'UGREEN' && ! $cat) {
                $subs[] = [
                    'name' => 'Type C Cable',
                    'url' => route('categories.show', 'type-c-cable'),
                ];
            } elseif ($name === 'BASEUS' && ! $cat) {
                $subs[] = [
                    'name' => 'Power Bank',
                    'url' => route('categories.show', 'power-bank'),
                ];
            }

            $result[] = [
                'key' => $key,
                'name' => $cat?->name ?? $name,
                'url' => $url,
                'subcategories' => $subs,
            ];
        }

        return $result;
    }
}
