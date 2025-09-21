<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Desktop Computers',
                'slug' => 'desktop-computers',
                'description' => 'High-performance desktop computers for gaming, business, and professional use.',
                'icon' => 'desktop',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Laptops',
                'slug' => 'laptops',
                'description' => 'Portable laptops for work, gaming, and everyday computing needs.',
                'icon' => 'laptop',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Gaming PCs',
                'slug' => 'gaming-pcs',
                'description' => 'Ultimate gaming computers with cutting-edge graphics and performance.',
                'icon' => 'gamepad',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Monitors',
                'slug' => 'monitors',
                'description' => 'High-resolution displays for gaming, professional work, and entertainment.',
                'icon' => 'monitor',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Components',
                'slug' => 'components',
                'description' => 'Individual computer components for custom builds and upgrades.',
                'icon' => 'cpu',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Peripherals',
                'slug' => 'peripherals',
                'description' => 'Keyboards, mice, headsets, and other computer accessories.',
                'icon' => 'keyboard',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Servers',
                'slug' => 'servers',
                'description' => 'Enterprise-grade servers for business and data center applications.',
                'icon' => 'server',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Networking',
                'slug' => 'networking',
                'description' => 'Network equipment, routers, switches, and connectivity solutions.',
                'icon' => 'network',
                'is_active' => true,
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
