<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use App\Models\SmaCategory;
use App\Models\SmaProduct;

class SitemapController extends Controller
{
    /**
     * Display sitemap management page
     */
    public function index()
    {
        // Get sitemap statistics
        $stats = $this->getSitemapStats();
        
        return view('admin.sitemap.index', compact('stats'));
    }

    /**
     * Regenerate all sitemaps
     */
    public function regenerate(Request $request)
    {
        try {
            // Run the sitemap generation command
            $exitCode = Artisan::call('sitemap:generate-all');
            
            if ($exitCode === 0) {
                // Get updated statistics
                $stats = $this->getSitemapStats();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Sitemaps regenerated successfully!',
                    'stats' => $stats,
                    'timestamp' => now()->format('Y-m-d H:i:s')
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to regenerate sitemaps. Please check the logs.'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get sitemap files status
     */
    public function status()
    {
        $stats = $this->getSitemapStats();
        
        return response()->json([
            'success' => true,
            'stats' => $stats,
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Download sitemap file
     */
    public function download($file)
    {
        $allowedFiles = [
            'sitemap.xml',
            'sitemap-index.xml',
            'main-sitemap.xml',
            'categories-sitemap.xml'
        ];

        // Check for product sitemap files
        if (preg_match('/^products-sitemap-\d+\.xml$/', $file)) {
            $allowedFiles[] = $file;
        }

        if (!in_array($file, $allowedFiles)) {
            abort(404, 'Sitemap file not found');
        }

        $path = $file === 'sitemap.xml' || $file === 'sitemap-index.xml' 
            ? public_path($file)
            : public_path('sitemaps/' . $file);

        if (!File::exists($path)) {
            abort(404, 'Sitemap file not found');
        }

        return response()->download($path);
    }

    /**
     * Get sitemap statistics
     */
    private function getSitemapStats()
    {
        $stats = [
            'total_pages' => 0,
            'main_pages' => 15, // Static count
            'categories' => 0,
            'products' => 0,
            'sitemap_files' => [],
            'last_generated' => null,
            'total_size' => 0
        ];

        try {
            // Count categories
            $stats['categories'] = SmaCategory::whereHas('products', function($query) {
                $query->where('hide', 0);
            })
            ->orWhereHas('subcategoryProducts', function($query) {
                $query->where('hide', 0);
            })->count();

            // Count products
            $stats['products'] = SmaProduct::where('hide', 0)
                ->whereHas('category')
                ->count();

            $stats['total_pages'] = $stats['main_pages'] + $stats['categories'] + $stats['products'];

            // Check sitemap files
            $sitemapFiles = [
                'sitemap.xml' => public_path('sitemap.xml'),
                'sitemap-index.xml' => public_path('sitemap-index.xml'),
                'main-sitemap.xml' => public_path('sitemaps/main-sitemap.xml'),
                'categories-sitemap.xml' => public_path('sitemaps/categories-sitemap.xml')
            ];

            // Check for product sitemap files
            if (File::isDirectory(public_path('sitemaps'))) {
                $productSitemaps = File::glob(public_path('sitemaps/products-sitemap-*.xml'));
                foreach ($productSitemaps as $file) {
                    $filename = basename($file);
                    $sitemapFiles[$filename] = $file;
                }
            }

            foreach ($sitemapFiles as $name => $path) {
                if (File::exists($path)) {
                    $size = File::size($path);
                    $stats['sitemap_files'][] = [
                        'name' => $name,
                        'size' => $this->formatBytes($size),
                        'size_bytes' => $size,
                        'last_modified' => File::lastModified($path),
                        'url' => $name === 'sitemap.xml' || $name === 'sitemap-index.xml' 
                            ? url($name) 
                            : url('sitemaps/' . $name)
                    ];
                    $stats['total_size'] += $size;
                }
            }

            // Get last generated time from newest file
            if (!empty($stats['sitemap_files'])) {
                $lastModified = max(array_column($stats['sitemap_files'], 'last_modified'));
                $stats['last_generated'] = date('Y-m-d H:i:s', $lastModified);
            }

            $stats['total_size_formatted'] = $this->formatBytes($stats['total_size']);

        } catch (\Exception $e) {
            // Handle gracefully if database is not accessible
        }

        return $stats;
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($size, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $unit = 0;
        
        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }
        
        return round($size, $precision) . ' ' . $units[$unit];
    }
}