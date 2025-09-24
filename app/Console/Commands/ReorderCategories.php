<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SmaCategory;
use Illuminate\Support\Facades\DB;

class ReorderCategories extends Command
{
    protected $signature = 'categories:reorder';
    protected $description = 'Reorder categories according to the logical structure';

    public function handle()
    {
        $this->info('Reordering categories according to the logical structure...');
        $this->newLine();

        // Define the category order structure
        $categoryOrder = [
            // Primary Categories (1-10)
            'PC BUILD' => 1,
            'LAPTOP' => 2,
            'PROCESSOR' => 3,
            'MOTHERBOARD' => 4,
            'MEMORY (RAM)' => 5,
            'GRAPHIC CARD (VGA)' => 6,
            'POWER SUPPLY' => 7,
            'UPS & BATTERIES' => 8,
            'STORAGE(HDD,SSD,NVME)' => 9,
            'COOLING (FAN,AIR,LIQUID)' => 10,
            'CASING' => 11,
            
            // Peripherals & Accessories (12-17)
            'MONITORS & ACCESSORIES' => 12,
            'KEYBOARD & MOUSE' => 13,
            'SPEAKERS & HEADPHONES' => 14,
            'WEB CAM & MIC' => 15,
            'GAMING CHAIRS & TABLES' => 16,
            'GAMING CONTROLLERS' => 17,
            
            // Mobile & Networking (18-20)
            'MOBILE ACCESSORIES' => 18,
            'CABLES & CONVERTORS' => 19,
            'EXPANSION CARDS AND NETWORKING' => 20,
            
            // Laptop & External (21-22)
            'LAPTOP ACCESSORIES' => 21,
            'EXTERNAL (PEN,SSD,HDD)' => 22,
            
            // Other Categories (23-30)
            'PRINTERS' => 23,
            'SOFTWARE & GAMES' => 24,
            'OPTICAL DRIVES' => 25,
            'SUBWOOFERS' => 26,
            'STUDIO & RECORDING' => 27,
            'SPORTS' => 28,
            'TOYS' => 29,
            'TELEVISION' => 30,
            'PHONES' => 31,
            'SERVICES' => 32,
            'VOUCHERS' => 33,
            'OTHER' => 34,
        ];

        // Check if we have a sort_order column, if not add it
        if (!$this->checkSortOrderColumn()) {
            $this->addSortOrderColumn();
        }

        $updatedCount = 0;
        $notFoundCategories = [];

        foreach ($categoryOrder as $categoryName => $sortOrder) {
            $category = SmaCategory::where('name', $categoryName)->first();
            
            if ($category) {
                $category->update(['sort_order' => $sortOrder]);
                $this->line("✓ Updated: {$categoryName} (Order: {$sortOrder})");
                $updatedCount++;
            } else {
                $notFoundCategories[] = $categoryName;
                $this->warn("✗ Not found: {$categoryName}");
            }
        }

        // Set default sort order for categories not in our list
        $remainingCategories = SmaCategory::whereNull('sort_order')->get();
        $nextOrder = 35;

        foreach ($remainingCategories as $category) {
            $category->update(['sort_order' => $nextOrder]);
            $this->line("→ Set default order for: {$category->name} (Order: {$nextOrder})");
            $nextOrder++;
        }

        $this->newLine();
        $this->info("Category reordering completed!");
        $this->line("✓ Updated categories: {$updatedCount}");
        $this->line("✓ Remaining categories: " . $remainingCategories->count());
        
        if (!empty($notFoundCategories)) {
            $this->newLine();
            $this->warn("Categories not found in database:");
            foreach ($notFoundCategories as $cat) {
                $this->line("  - {$cat}");
            }
        }

        $this->newLine();
        $this->info('Don\'t forget to update your model and controllers to use the sort_order field!');

        return 0;
    }

    private function checkSortOrderColumn()
    {
        try {
            return DB::connection('products_db')->getSchemaBuilder()->hasColumn('sma_categories', 'sort_order');
        } catch (\Exception $e) {
            return false;
        }
    }

    private function addSortOrderColumn()
    {
        $this->info('Adding sort_order column to sma_categories table...');
        
        try {
            DB::connection('products_db')->statement('ALTER TABLE sma_categories ADD COLUMN sort_order INT DEFAULT 999');
            $this->info('✓ sort_order column added successfully!');
        } catch (\Exception $e) {
            $this->error('Failed to add sort_order column: ' . $e->getMessage());
            $this->error('Please add the column manually: ALTER TABLE sma_categories ADD COLUMN sort_order INT DEFAULT 999');
            return false;
        }
        
        return true;
    }
}