<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SmaCategory;

class ReorderSubcategories extends Command
{
    protected $signature = 'subcategories:reorder';
    protected $description = 'Reorder subcategories within each main category logically';

    public function handle()
    {
        $this->info('Reordering subcategories within each main category...');
        $this->newLine();

        // Define preferred subcategory order patterns
        $subcategoryOrderPatterns = [
            // Pattern: "BRAND NEW" items should come first, then "USED" items
            'brand_new_first' => [
                'BRAND NEW' => 1,
                'USED' => 2,
            ],
            
            // Specific category ordering
            'specific_orders' => [
                'MONITORS & ACCESSORIES' => [
                    'BRAND NEW MONITORS' => 1,
                    'USED MONITORS' => 2,
                    'MONITORS ACCESSORIES' => 3,
                    'PROJECTORS' => 4,
                ],
                'KEYBOARD & MOUSE' => [
                    'KEYBOARD' => 1,
                    'MOUSE' => 2,
                    'COMBO' => 3,
                    'MOUSE PAD' => 4,
                ],
                'SPEAKERS & HEADPHONES' => [
                    'SPEAKERS' => 1,
                    'HEADPHONES' => 2,
                ],
                'WEB CAM & MIC' => [
                    'WEB CAM' => 1,
                    'MIC' => 2,
                ],
                'UPS & BATTERIES' => [
                    'UPS' => 1,
                    'UPS BATTERIES' => 2,
                ],
                'GAMING CHAIRS & TABLES' => [
                    'CHAIRS' => 1,
                    'TABLES' => 2,
                ],
                'GAMING CONTROLLERS' => [
                    'GAMING CONTROLLERS' => 1,
                    'STEERING WEEL' => 2,
                ],
                'CABLES & CONVERTORS' => [
                    'CABLES' => 1,
                    'CONVERTORS' => 2,
                ],
                'OPTICAL DRIVES' => [
                    'BRAND NEW OPTICAL DRIVES' => 1,
                    'USED OPTICAL DRIVES' => 2,
                ],
                'SOFTWARE & GAMES' => [
                    'SOFTWARES' => 1,
                    'GAMES' => 2,
                ],
                'SUBWOOFERS' => [
                    'SUBWOOFERS' => 1,
                    'PARTY BOX' => 2,
                ],
                'EXTERNAL (PEN,SSD,HDD)' => [
                    'POTRABLE HDD' => 1,
                    'PORTABLE SSD' => 2,
                    'PEN DRIVES' => 3,
                    'MEMORY CARD(SD)' => 4,
                ],
                'EXPANSION CARDS AND NETWORKING' => [
                    'BLUETOOTH ADAPTERS' => 1,
                    'WIFI ADAPERTS' => 2,
                    'ROUTERS' => 3,
                    'DOUNGLE' => 4,
                    'NETWORK SWITCHES' => 5,
                ],
                'PRINTERS' => [
                    'PRINTERS' => 1,
                    'SCANNER' => 2,
                    'CARDRIGE' => 3,
                    'TORNER' => 4,
                    'INK BOTTLE' => 5,
                    'RIBBON' => 6,
                ],
                'MOBILE ACCESSORIES' => [
                    'CHARGERS & ADAPTERS' => 1,
                    'POWER BANK' => 2,
                    'EARPHONE' => 3,
                    'EARBUD' => 4,
                    'SMART WATCH' => 5,
                    'PHONE STAND' => 6,
                    'CAR CHARGERS' => 7,
                ],
                'LAPTOP ACCESSORIES' => [
                    'LAPTOP CHARGERS' => 1,
                    'LAPTOP BATTERIES' => 2,
                    'LAPTOP KEYBOARDS' => 3,
                    'LAPTOP DISPLAYS' => 4,
                    'LAPTOP COOLIING FANS' => 5,
                    'LAPTOP COOLING PAD' => 6,
                    'LAPTOP STAND' => 7,
                    'CADDY' => 8,
                    'LAPTOP STICKER' => 9,
                ],
                'SPORTS' => [
                    'RC Products' => 1,
                    'GEL BLASTERS' => 2,
                ],
            ]
        ];

        $mainCategories = SmaCategory::mainCategories()
            ->with('subcategories')
            ->orderBy('sort_order', 'asc')
            ->get();

        $totalUpdated = 0;

        foreach ($mainCategories as $category) {
            if ($category->subcategories->count() == 0) {
                continue;
            }

            $this->line("Processing category: {$category->name}");

            $subcategoryOrder = 1;

            // Check if we have specific ordering for this category
            if (isset($subcategoryOrderPatterns['specific_orders'][$category->name])) {
                $specificOrder = $subcategoryOrderPatterns['specific_orders'][$category->name];
                
                foreach ($specificOrder as $subcatName => $order) {
                    $subcategory = $category->subcategories->where('name', $subcatName)->first();
                    if ($subcategory) {
                        $subcategory->update(['sort_order' => $order]);
                        $this->line("  ✓ {$subcatName} → Order: {$order}");
                        $totalUpdated++;
                    }
                }
                
                // Set remaining subcategories
                $nextOrder = max($specificOrder) + 1;
                foreach ($category->subcategories as $subcat) {
                    if (!isset($specificOrder[$subcat->name]) && !$subcat->sort_order) {
                        $subcat->update(['sort_order' => $nextOrder]);
                        $this->line("  → {$subcat->name} → Order: {$nextOrder}");
                        $nextOrder++;
                        $totalUpdated++;
                    }
                }
            } else {
                // Apply generic "BRAND NEW first, USED second" pattern
                $brandNewSubcategories = $category->subcategories->filter(function($subcat) {
                    return strpos($subcat->name, 'BRAND NEW') !== false;
                });
                
                $usedSubcategories = $category->subcategories->filter(function($subcat) {
                    return strpos($subcat->name, 'USED') !== false;
                });
                
                $otherSubcategories = $category->subcategories->filter(function($subcat) {
                    return strpos($subcat->name, 'BRAND NEW') === false && strpos($subcat->name, 'USED') === false;
                });

                // Order: Brand New, Others, Used
                foreach ($brandNewSubcategories as $subcat) {
                    $subcat->update(['sort_order' => $subcategoryOrder++]);
                    $this->line("  ✓ {$subcat->name} → Order: {$subcat->sort_order}");
                    $totalUpdated++;
                }
                
                foreach ($otherSubcategories as $subcat) {
                    $subcat->update(['sort_order' => $subcategoryOrder++]);
                    $this->line("  → {$subcat->name} → Order: {$subcat->sort_order}");
                    $totalUpdated++;
                }
                
                foreach ($usedSubcategories as $subcat) {
                    $subcat->update(['sort_order' => $subcategoryOrder++]);
                    $this->line("  ✓ {$subcat->name} → Order: {$subcat->sort_order}");
                    $totalUpdated++;
                }
            }

            $this->newLine();
        }

        $this->info("Subcategory reordering completed!");
        $this->line("✓ Total subcategories updated: {$totalUpdated}");

        return 0;
    }
}