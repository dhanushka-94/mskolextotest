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

    /** Canonical public site used in sitemap <loc> (never localhost for Google). */
    protected string $seoBaseUrl = 'https://mskcomputers.lk';

    protected function seoUrl(string $path = '/'): string
    {
        return rtrim($this->seoBaseUrl, '/') . '/' . ltrim($path, '/');
    }

    public function handle()
    {
        $configured = rtrim((string) config('app.url'), '/');
        if ($configured !== '' && !str_contains($configured, '127.0.0.1') && !str_contains($configured, 'localhost')) {
            $this->seoBaseUrl = $configured;
        }

        $this->info('Generating comprehensive sitemaps with ALL products...');
        $this->line('🔗 Sitemap base URL: ' . $this->seoBaseUrl);
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
        $this->line('📍 Main sitemap index: ' . $this->seoUrl('/sitemap.xml'));
        $this->line('🌐 Submit this URL to Google Search Console');

        return 0;
    }

    protected function generateMainSitemap()
    {
        $this->line('📄 Generating main pages sitemap...');
        
        $sitemap = $this->getSitemapHeader();

        // Main pages with high priority
        $mainPages = [
            ['url' => $this->seoUrl('/'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => $this->seoUrl('/categories'), 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => $this->seoUrl('/products'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => $this->seoUrl('/promotions'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => $this->seoUrl('/about-us'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => $this->seoUrl('/contact-us'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => $this->seoUrl('/services'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => $this->seoUrl('/e-services'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => $this->seoUrl('/bank-details'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => $this->seoUrl('/warranty'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => $this->seoUrl('/track-order'), 'priority' => '0.6', 'changefreq' => 'weekly'],
            ['url' => $this->seoUrl('/register'), 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['url' => $this->seoUrl('/login'), 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['url' => $this->seoUrl('/privacy-policy'), 'priority' => '0.4', 'changefreq' => 'yearly'],
            ['url' => $this->seoUrl('/terms-of-service'), 'priority' => '0.4', 'changefreq' => 'yearly'],
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
                $categoryUrl = $this->seoUrl('/categories/' . ($category->slug ?: $category->id));
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
                        $productUrl = $this->seoUrl('/' . ($product->category->slug ?: $product->category->id) . '/' . ($product->slug ?: $product->id));
                        
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
        $sitemapIndex .= $this->createSitemapIndexEntry($this->seoUrl('/sitemaps/main-sitemap.xml'));
        
        // Add categories sitemap
        $sitemapIndex .= $this->createSitemapIndexEntry($this->seoUrl('/sitemaps/categories-sitemap.xml'));
        
        // Add all product sitemaps
        $sitemapsDir = public_path('sitemaps');
        $productSitemaps = File::glob($sitemapsDir . '/products-sitemap-*.xml');
        
        foreach ($productSitemaps as $sitemapFile) {
            $filename = basename($sitemapFile);
            $sitemapIndex .= $this->createSitemapIndexEntry($this->seoUrl('/sitemaps/' . $filename));
        }
        
        $sitemapIndex .= '</sitemapindex>';

        // Save sitemap index — also as sitemap.xml so Google discovers every product URL
        File::put(public_path('sitemap-index.xml'), $sitemapIndex);
        File::put(public_path('sitemap.xml'), $sitemapIndex);
        
        $totalSitemaps = 2 + count($productSitemaps); // main + categories + product sitemaps
        $this->line("  ✅ Sitemap index: " . $totalSitemaps . " sitemaps included");
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