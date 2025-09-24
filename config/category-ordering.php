<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Category Ordering Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration defines the logical ordering of categories without
    | modifying the database structure. Categories are ordered by their names
    | according to the business logic defined below.
    |
    */

    'main_categories' => [
        // Primary Categories (1-11)
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
        
        // Other Categories (23-34)
        'PRINTERS' => 23,
        'SOFTWARE & GAMES' => 24,
        'OPTICAL DRIVES' => 25,
        'SUBWOOFERS' => 26,
        'STUDIO & RECORDING' => 27,
        'SPORTS' => 28,
        'TOYS' => 29,
        'TELEVITION' => 30,
        'PHONES' => 31,
        'SERVICES' => 32,
        'VOUCHERS' => 33,
        'OTHER' => 34,
    ],

    'subcategory_ordering' => [
        // Specific subcategory orders for certain categories
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
        'UPS & BATTERIES' => [
            'UPS' => 1,
            'UPS BATTERIES' => 2,
        ],
        'EXTERNAL (PEN,SSD,HDD)' => [
            'POTRABLE HDD' => 1,
            'PORTABLE SSD' => 2,
            'PEN DRIVES' => 3,
            'MEMORY CARD(SD)' => 4,
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
        'MOBILE ACCESSORIES' => [
            'CHARGERS & ADAPTERS' => 1,
            'POWER BANK' => 2,
            'EARPHONE' => 3,
            'EARBUD' => 4,
            'SMART WATCH' => 5,
            'PHONE STAND' => 6,
            'CAR CHARGERS' => 7,
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
        'SPORTS' => [
            'RC Products' => 1,
            'GEL BLASTERS' => 2,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Ordering Rules
    |--------------------------------------------------------------------------
    |
    | These rules apply when specific ordering is not defined above
    |
    */
    'default_rules' => [
        // For categories with BRAND NEW and USED subcategories
        'brand_new_pattern' => 'BRAND NEW',
        'used_pattern' => 'USED',
        
        // Default order: Brand New (1), Others (by name), Used (last)
        'brand_new_priority' => 1,
        'others_priority' => 2,
        'used_priority' => 3,
    ],
];
