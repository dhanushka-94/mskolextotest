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
        // Featured brands (top priority)
        'BASEUS' => 0,
        'UGREEN' => 1,

        // Primary Categories (2-12)
        'PC BUILD' => 2,
        'LAPTOP' => 3,
        'PROCESSOR' => 4,
        'MOTHERBOARD' => 5,
        'MEMORY (RAM)' => 6,
        'GRAPHIC CARD (VGA)' => 7,
        'POWER SUPPLY' => 8,
        'UPS & BATTERIES' => 9,
        'STORAGE(HDD,SSD,NVME)' => 10,
        'COOLING (FAN,AIR,LIQUID)' => 11,
        'CASING' => 12,
        
        // Peripherals & Accessories (13-18)
        'MONITORS & ACCESSORIES' => 13,
        'KEYBOARD & MOUSE' => 14,
        'SPEAKERS & HEADPHONES' => 15,
        'WEB CAM & MIC' => 16,
        'GAMING CHAIRS & TABLES' => 17,
        'GAMING CONTROLLERS' => 18,
        
        // Mobile & Networking (19-21)
        'MOBILE ACCESSORIES' => 19,
        'CABLES & CONVERTORS' => 20,
        'EXPANSION CARDS AND NETWORKING' => 21,
        
        // Laptop & External (22-23)
        'LAPTOP ACCESSORIES' => 22,
        'EXTERNAL (PEN,SSD,HDD)' => 23,
        
        // Other Categories (24-35)
        'PRINTERS' => 24,
        'SOFTWARE & GAMES' => 25,
        'OPTICAL DRIVES' => 26,
        'SUBWOOFERS' => 27,
        'STUDIO & RECORDING' => 28,
        'SPORTS' => 29,
        'TOYS' => 30,
        'TELEVITION' => 31,
        'PHONES' => 32,
        'SERVICES' => 33,
        'VOUCHERS' => 34,
        'OTHER' => 35,
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
        'UGREEN' => [
            'Type C Cable' => 1,
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

    /*
    |--------------------------------------------------------------------------
    | LaptopExpert Category Inclusion (Additional Catalog Source)
    |--------------------------------------------------------------------------
    */
    'laptopexpert' => [
        /** Label for the dedicated main navigation dropdown */
        'menu_label' => 'Laptops',

        // Disabled: site uses MSK products DB only
        'main_category_order' => [],
        'subcategory_order' => [],
    ],
];
