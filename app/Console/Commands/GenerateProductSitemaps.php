<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\SmaCategory;
use App\Models\SmaProduct;

class GenerateProductSitemaps extends Command
{
    protected $signature = 'sitemap:generate-all';
    protected $description = 'Generate comprehensive sitemaps including ALL products';

    public function handle()
    {
        $this->info('Generating comprehensive sitemaps with ALL products...');
        $this->newLine();

        // Create public/sitemaps directory if it doesn't exist
        $sitemapsDir = public_path('sitemaps');
        if (!File::isDirectory($sitemapsDir)) {
            File::makeDirectory($sitemapsDir, 0755, true);
        }

        // Generate individual sitemaps
        $this->generateMainSitemap();
        $this->generateCategoriesSitemap();
        $this->generateProductSitemaps();
        $this->generateSitemapIndex();

        $this->newLine();
        $this->info('🚀 All sitemaps generated successfully!');
        $this->line('📍 Main sitemap index: ' . url('/sitemap-index.xml'));
        $this->line('🌐 Submit this URL to Google Search Console');

        return 0;
    }

    protected function generateMainSitemap()
    {
        $this->line('📄 Generating main pages sitemap...');
        
        $sitemap = $this->getSitemapHeader();

        // Main pages with high priority
        $mainPages = [
            ['url' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => url('/categories'), 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => url('/products'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => url('/promotions'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => url('/about-us'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => url('/contact-us'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => url('/services'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => url('/e-services'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => url('/bank-details'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => url('/warranty'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => url('/track-order'), 'priority' => '0.6', 'changefreq' => 'weekly'],
            ['url' => url('/register'), 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['url' => url('/login'), 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['url' => url('/privacy-policy'), 'priority' => '0.4', 'changefreq' => 'yearly'],
            ['url' => url('/terms-of-service'), 'priority' => '0.4', 'changefreq' => 'yearly'],
        ];

        foreach ($mainPages as $page) {
            $sitemap .= $this->createUrlEntry($page['url'], $page['priority'], $page['changefreq']);
        }

        $sitemap .= $this->getSitemapFooter();
        File::put(public_path('sitemaps/main-sitemap.xml'), $sitemap);
        
        $this->line('  ✅ Main sitemap: ' . count($mainPages) . ' pages');
    }

    protected function generateCategoriesSitemap()
    {
        $this->line('📁 Generating categories sitemap...');
        
        $sitemap = $this->getSitemapHeader();

        try {
            $categories = SmaCategory::select(['id', 'name', 'slug'])
                ->whereHas('products', function($query) {
                    $query->where('hide', 0);
                })
                ->orWhereHas('subcategoryProducts', function($query) {
                    $query->where('hide', 0);
                })
                ->get();

            foreach ($categories as $category) {
                $categoryUrl = url('/categories/' . ($category->slug ?: $category->id));
                $sitemap .= $this->createUrlEntry($categoryUrl, '0.8', 'weekly');
            }

            $sitemap .= $this->getSitemapFooter();
            File::put(public_path('sitemaps/categories-sitemap.xml'), $sitemap);
            
            $this->line('  ✅ Categories sitemap: ' . $categories->count() . ' categories');

        } catch (\Exception $e) {
            $this->error('  ❌ Failed to generate categories sitemap: ' . $e->getMessage());
        }
    }

    protected function generateProductSitemaps()
    {
        $this->line('🛍️ Generating product sitemaps...');
        
        try {
            // Get all active products
            $totalProducts = SmaProduct::where('hide', 0)
                ->whereHas('category')
                ->count();

            $this->line("  📦 Found " . $totalProducts . " active products");

            // Split products into chunks of 1000 for better performance
            $chunkSize = 1000;
            $chunks = ceil($totalProducts / $chunkSize);
            $sitemapFiles = [];

            for ($i = 0; $i < $chunks; $i++) {
                $offset = $i * $chunkSize;
                $products = SmaProduct::select(['id', 'name', 'slug', 'category_id'])
                    ->where('hide', 0)
                    ->whereHas('category')
                    ->with('category:id,name,slug')
                    ->offset($offset)
                    ->limit($chunkSize)
                    ->get();

                if ($products->count() > 0) {
                    $sitemap = $this->getSitemapHeader();

                    foreach ($products as $product) {
                        $productUrl = url('/' . ($product->category->slug ?: $product->category->id) . '/' . ($product->slug ?: $product->id));
                        
                        // Higher priority for promotional products
                        $priority = $product->promotion == 1 ? '0.8' : '0.6';
                        $sitemap .= $this->createUrlEntry($productUrl, $priority, 'weekly');
                    }

                    $sitemap .= $this->getSitemapFooter();
                    
                    $filename = "products-sitemap-" . ($i + 1) . ".xml";
                    File::put(public_path('sitemaps/' . $filename), $sitemap);
                    
                    $sitemapFiles[] = $filename;
                    $this->line("  ✅ Products sitemap " . ($i + 1) . ": " . $products->count() . " products");
                }
            }

            $this->line("  📊 Generated " . $chunks . " product sitemap files");
            return $sitemapFiles;

        } catch (\Exception $e) {
            $this->error('  ❌ Failed to generate product sitemaps: ' . $e->getMessage());
            return [];
        }
    }

    protected function generateSitemapIndex()
    {
        $this->line('📑 Generating sitemap index...');
        
        $sitemapIndex = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemapIndex .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        // Add main sitemap
        $sitemapIndex .= $this->createSitemapIndexEntry(url('/sitemaps/main-sitemap.xml'));
        
        // Add categories sitemap
        $sitemapIndex .= $this->createSitemapIndexEntry(url('/sitemaps/categories-sitemap.xml'));
        
        // Add all product sitemaps
        $sitemapsDir = public_path('sitemaps');
        $productSitemaps = File::glob($sitemapsDir . '/products-sitemap-*.xml');
        
        foreach ($productSitemaps as $sitemapFile) {
            $filename = basename($sitemapFile);
            $sitemapIndex .= $this->createSitemapIndexEntry(url('/sitemaps/' . $filename));
        }
        
        $sitemapIndex .= '</sitemapindex>';

        // Save sitemap index to main public directory
        File::put(public_path('sitemap-index.xml'), $sitemapIndex);
        
        // Also update the main sitemap.xml to point to the most important content
        $this->generateMainSitemapXml();
        
        $totalSitemaps = 2 + count($productSitemaps); // main + categories + product sitemaps
        $this->line("  ✅ Sitemap index: " . $totalSitemaps . " sitemaps included");
    }

    protected function generateMainSitemapXml()
    {
        // Create a focused main sitemap.xml with most important pages and some products
        $sitemap = $this->getSitemapHeader();

        // Add most important pages
        $mainPages = [
            ['url' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => url('/categories'), 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => url('/products'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => url('/promotions'), 'priority' => '0.8', 'changefreq' => 'weekly'],
        ];

        foreach ($mainPages as $page) {
            $sitemap .= $this->createUrlEntry($page['url'], $page['priority'], $page['changefreq']);
        }

        // Add top categories
        try {
            $topCategories = SmaCategory::select(['id', 'name', 'slug'])
                ->whereHas('products', function($query) {
                    $query->where('hide', 0);
                })
                ->limit(50)
                ->get();

            foreach ($topCategories as $category) {
                $categoryUrl = url('/categories/' . ($category->slug ?: $category->id));
                $sitemap .= $this->createUrlEntry($categoryUrl, '0.8', 'weekly');
            }
        } catch (\Exception $e) {
            // Handle gracefully
        }

        // Add some promotional products for immediate indexing
        try {
            $promotionalProducts = SmaProduct::select(['id', 'name', 'slug', 'category_id'])
                ->where('hide', 0)
                ->where('promotion', 1)
                ->whereHas('category')
                ->with('category:id,name,slug')
                ->limit(100)
                ->get();

            foreach ($promotionalProducts as $product) {
                $productUrl = url('/' . ($product->category->slug ?: $product->category->id) . '/' . ($product->slug ?: $product->id));
                $sitemap .= $this->createUrlEntry($productUrl, '0.8', 'weekly');
            }
        } catch (\Exception $e) {
            // Handle gracefully
        }

        $sitemap .= $this->getSitemapFooter();
        File::put(public_path('sitemap.xml'), $sitemap);
    }

    protected function getSitemapHeader()
    {
        return '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
               '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    }

    protected function getSitemapFooter()
    {
        return '</urlset>';
    }

    protected function createUrlEntry($url, $priority, $changefreq, $lastmod = null)
    {
        $lastmod = $lastmod ?: now()->format('Y-m-d\TH:i:s\Z');
        
        $entry = "  <url>\n";
        $entry .= "    <loc>" . htmlspecialchars($url) . "</loc>\n";
        $entry .= "    <lastmod>{$lastmod}</lastmod>\n";
        $entry .= "    <changefreq>{$changefreq}</changefreq>\n";
        $entry .= "    <priority>{$priority}</priority>\n";
        $entry .= "  </url>\n";

        return $entry;
    }

    protected function createSitemapIndexEntry($url)
    {
        $entry = "  <sitemap>\n";
        $entry .= "    <loc>" . htmlspecialchars($url) . "</loc>\n";
        $entry .= "    <lastmod>" . now()->format('Y-m-d\TH:i:s\Z') . "</lastmod>\n";
        $entry .= "  </sitemap>\n";

        return $entry;
    }
}