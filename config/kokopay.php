<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Koko Pay Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Koko Pay BNPL (Buy Now, Pay Later) payment gateway
    |
    */

    'mode' => env('KOKOPAY_MODE', 'sandbox'), // sandbox or live

    'merchant_id' => env('KOKOPAY_MERCHANT_ID'),
    'api_key' => env('KOKOPAY_API_KEY'),
    
    'private_key' => env('KOKOPAY_PRIVATE_KEY'),
    'public_key' => env('KOKOPAY_PUBLIC_KEY'),
    
    'plugin_name' => env('KOKOPAY_PLUGIN_NAME', 'MSK_Computers'),
    'plugin_version' => env('KOKOPAY_PLUGIN_VERSION', '1'),
    
    'currency' => env('KOKOPAY_CURRENCY', 'LKR'),
    
    // URLs
    'sandbox_url' => 'https://qaapi.paykoko.com/api/merchants/orderCreate',
    'live_url' => 'https://prodapi.paykoko.com/api/merchants/orderCreate',
    
    'return_url' => env('KOKOPAY_RETURN_URL', env('APP_URL') . '/payment/kokopay/return'),
    'cancel_url' => env('KOKOPAY_CANCEL_URL', env('APP_URL') . '/payment/kokopay/cancel'),
    'notify_url' => env('KOKOPAY_NOTIFY_URL', env('APP_URL') . '/payment/kokopay/notify'),
    
    // Get the appropriate API URL based on mode
    'api_url' => env('KOKOPAY_MODE', 'sandbox') === 'live' 
        ? 'https://prodapi.paykoko.com/api/merchants/orderCreate'
        : 'https://qaapi.paykoko.com/api/merchants/orderCreate',
];
