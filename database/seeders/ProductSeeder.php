<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        
        $products = [
            // Gaming PCs
            [
                'name' => 'MSK Gaming Beast Pro',
                'slug' => 'msk-gaming-beast-pro',
                'description' => 'Ultimate gaming desktop with RTX 4080, Intel i7-13700K, and 32GB DDR5 RAM. Perfect for 4K gaming and streaming.',
                'specifications' => 'Intel Core i7-13700K, RTX 4080 16GB, 32GB DDR5, 1TB NVMe SSD, 750W PSU, Liquid Cooling',
                'sku' => 'MSK-GB-PRO-001',
                'price' => 2499.99,
                'sale_price' => 2199.99,
                'stock_quantity' => 15,
                'brand' => 'MSK Computers',
                'model' => 'Gaming Beast Pro',
                'images' => [
                    'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=800&q=80',
                    'https://images.unsplash.com/photo-1587831990711-23ca6441447b?w=800&q=80'
                ],
                'is_active' => true,
                'is_featured' => true,
                'warranty' => '3 Years',
                'category_id' => $categories->where('slug', 'gaming-pcs')->first()->id,
            ],
            [
                'name' => 'MSK Gaming Elite',
                'slug' => 'msk-gaming-elite',
                'description' => 'High-performance gaming PC with RTX 4070, AMD Ryzen 7 7700X, perfect for competitive gaming.',
                'specifications' => 'AMD Ryzen 7 7700X, RTX 4070 12GB, 16GB DDR5, 500GB NVMe SSD, 650W PSU',
                'sku' => 'MSK-GE-001',
                'price' => 1899.99,
                'sale_price' => null,
                'stock_quantity' => 20,
                'brand' => 'MSK Computers',
                'model' => 'Gaming Elite',
                'images' => [
                    'https://images.unsplash.com/photo-1551702651-8b1496c7ad1b?w=800&q=80'
                ],
                'is_active' => true,
                'is_featured' => true,
                'warranty' => '2 Years',
                'category_id' => $categories->where('slug', 'gaming-pcs')->first()->id,
            ],
            
            // Desktop Computers
            [
                'name' => 'MSK Business Pro Workstation',
                'slug' => 'msk-business-pro-workstation',
                'description' => 'Professional workstation for business applications, content creation, and productivity.',
                'specifications' => 'Intel Core i5-13400, 16GB DDR4, 512GB NVMe SSD, Intel UHD Graphics',
                'sku' => 'MSK-BPW-001',
                'price' => 899.99,
                'sale_price' => null,
                'stock_quantity' => 25,
                'brand' => 'MSK Computers',
                'model' => 'Business Pro',
                'images' => [
                    'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=800&q=80'
                ],
                'is_active' => true,
                'is_featured' => false,
                'warranty' => '2 Years',
                'category_id' => $categories->where('slug', 'desktop-computers')->first()->id,
            ],
            
            // Laptops
            [
                'name' => 'MSK UltraBook Pro 15',
                'slug' => 'msk-ultrabook-pro-15',
                'description' => 'Premium business laptop with Intel i7, perfect for professionals and entrepreneurs.',
                'specifications' => 'Intel Core i7-13700H, 16GB DDR5, 512GB NVMe SSD, 15.6" 4K Display',
                'sku' => 'MSK-UBP-15-001',
                'price' => 1599.99,
                'sale_price' => 1399.99,
                'stock_quantity' => 12,
                'brand' => 'MSK Computers',
                'model' => 'UltraBook Pro 15',
                'images' => [
                    'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&q=80'
                ],
                'is_active' => true,
                'is_featured' => true,
                'warranty' => '2 Years',
                'category_id' => $categories->where('slug', 'laptops')->first()->id,
            ],
            [
                'name' => 'MSK Gaming Laptop RTX',
                'slug' => 'msk-gaming-laptop-rtx',
                'description' => 'Portable gaming powerhouse with RTX 4060 and high refresh rate display.',
                'specifications' => 'Intel Core i7-13700H, RTX 4060 8GB, 16GB DDR5, 1TB NVMe SSD, 17.3" 144Hz',
                'sku' => 'MSK-GLR-001',
                'price' => 1999.99,
                'sale_price' => null,
                'stock_quantity' => 8,
                'brand' => 'MSK Computers',
                'model' => 'Gaming Laptop RTX',
                'images' => [
                    'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=800&q=80'
                ],
                'is_active' => true,
                'is_featured' => true,
                'warranty' => '2 Years',
                'category_id' => $categories->where('slug', 'laptops')->first()->id,
            ],
            
            // Monitors
            [
                'name' => 'MSK 4K Gaming Monitor 32"',
                'slug' => 'msk-4k-gaming-monitor-32',
                'description' => '32-inch 4K gaming monitor with 144Hz refresh rate and HDR support.',
                'specifications' => '32" 4K (3840x2160), 144Hz, 1ms response time, HDR400, USB-C',
                'sku' => 'MSK-4KGM-32-001',
                'price' => 799.99,
                'sale_price' => 699.99,
                'stock_quantity' => 18,
                'brand' => 'MSK Computers',
                'model' => '4K Gaming Monitor 32',
                'images' => [
                    'https://images.unsplash.com/photo-1559526324-593bc073d938?w=800&q=80'
                ],
                'is_active' => true,
                'is_featured' => true,
                'warranty' => '3 Years',
                'category_id' => $categories->where('slug', 'monitors')->first()->id,
            ],
            [
                'name' => 'MSK UltraWide Curved Monitor',
                'slug' => 'msk-ultrawide-curved-monitor',
                'description' => '34-inch ultrawide curved monitor perfect for productivity and immersive gaming.',
                'specifications' => '34" UWQHD (3440x1440), 100Hz, Curved, USB-C, KVM Switch',
                'sku' => 'MSK-UWCM-001',
                'price' => 599.99,
                'sale_price' => null,
                'stock_quantity' => 22,
                'brand' => 'MSK Computers',
                'model' => 'UltraWide Curved',
                'images' => [
                    'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&q=80'
                ],
                'is_active' => true,
                'is_featured' => false,
                'warranty' => '2 Years',
                'category_id' => $categories->where('slug', 'monitors')->first()->id,
            ],
            
            // Peripherals
            [
                'name' => 'MSK Mechanical Keyboard RGB Pro',
                'slug' => 'msk-mechanical-keyboard-rgb-pro',
                'description' => 'Premium mechanical keyboard with RGB lighting and hot-swappable switches.',
                'specifications' => 'Cherry MX Red switches, RGB backlighting, Hot-swappable, USB-C, 87 keys',
                'sku' => 'MSK-MKRGB-PRO-001',
                'price' => 199.99,
                'sale_price' => 169.99,
                'stock_quantity' => 35,
                'brand' => 'MSK Computers',
                'model' => 'Mechanical RGB Pro',
                'images' => [
                    'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&q=80'
                ],
                'is_active' => true,
                'is_featured' => true,
                'warranty' => '2 Years',
                'category_id' => $categories->where('slug', 'peripherals')->first()->id,
            ],
            [
                'name' => 'MSK Gaming Mouse Pro',
                'slug' => 'msk-gaming-mouse-pro',
                'description' => 'High-precision gaming mouse with customizable RGB and programmable buttons.',
                'specifications' => '16000 DPI, RGB lighting, 8 programmable buttons, 1000Hz polling rate',
                'sku' => 'MSK-GMP-001',
                'price' => 89.99,
                'sale_price' => null,
                'stock_quantity' => 45,
                'brand' => 'MSK Computers',
                'model' => 'Gaming Mouse Pro',
                'images' => [
                    'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&q=80'
                ],
                'is_active' => true,
                'is_featured' => false,
                'warranty' => '1 Year',
                'category_id' => $categories->where('slug', 'peripherals')->first()->id,
            ],
            
            // Components
            [
                'name' => 'MSK Custom RTX 4080 Graphics Card',
                'slug' => 'msk-custom-rtx-4080-graphics-card',
                'description' => 'High-performance graphics card with custom cooling solution.',
                'specifications' => 'RTX 4080 16GB, Triple-fan cooling, Factory overclocked, RGB lighting',
                'sku' => 'MSK-RTX4080-001',
                'price' => 1199.99,
                'sale_price' => null,
                'stock_quantity' => 10,
                'brand' => 'MSK Computers',
                'model' => 'Custom RTX 4080',
                'images' => [
                    'https://images.unsplash.com/photo-1591489296726-a3c7a5bf5158?w=800&q=80'
                ],
                'is_active' => true,
                'is_featured' => true,
                'warranty' => '3 Years',
                'category_id' => $categories->where('slug', 'components')->first()->id,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
