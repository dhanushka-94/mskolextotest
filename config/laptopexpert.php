<?php

return [

    /*
    |--------------------------------------------------------------------------
    | LaptopExpert product image base URLs
    |--------------------------------------------------------------------------
    |
    | Relative paths in the database (image / sma_product_photos.photo) are
    | prefixed with these URLs. If *_MAIN_* or *_PHOTOS_* is empty, the
    | generic LAPTOPEXPERT_PRODUCTS_IMAGE_BASE_URL is used for that part.
    |
    */

    'image_base_url' => env('LAPTOPEXPERT_PRODUCTS_IMAGE_BASE_URL'),

    'main_image_base_url' => env('LAPTOPEXPERT_PRODUCTS_MAIN_IMAGE_BASE_URL'),

    'extra_photos_base_url' => env('LAPTOPEXPERT_PRODUCTS_EXTRA_PHOTOS_BASE_URL'),

    /*
    |--------------------------------------------------------------------------
    | Hide MSK main categories from public menus (comma-separated)
    |--------------------------------------------------------------------------
    |
    | Laptop lines are listed under the separate "Laptops" menu (LaptopExpert).
    | Default removes MSK top-level "LAPTOP" from Categories dropdown / listings.
    |
    */

    'exclude_msk_menu_category_names' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) env('EXCLUDE_MSK_MENU_CATEGORY_NAMES', 'LAPTOP'))
    ))),

    'exclude_msk_menu_category_slugs' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) env('EXCLUDE_MSK_MENU_CATEGORY_SLUGS', ''))
    ))),

];
