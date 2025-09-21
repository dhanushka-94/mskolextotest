<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WebXPay Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for WebXPay payment gateway integration
    |
    */

    // API Credentials - Live Environment
    'api_username' => env('WEBXPAY_API_USERNAME', 'mskcomp'),
    'api_password' => env('WEBXPAY_API_PASSWORD', 'Bk@yFIqlG3vh'),
    'secret_key' => env('WEBXPAY_SECRET_KEY', '9187fa33-170a-4496-bd76-9e8aecfa8d62'),
    
    // Public Key for encryption
    'public_key' => env('WEBXPAY_PUBLIC_KEY', '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDfWVv08JQSdSWOIb9aa7FOeW0x
85+lbClE7CeKxry7LZuwHoyRgOKeg520412rDCezWH0uM5YOVJ+XahF3xfLZ9Gwl
Il1/8S5snEycFObmjuJuvcGBiMBzfN+E2t8tNYaLJaLO61tP2a3WKebmzu9OePW8
oZuR+DvsDJg/KOfYUQIDAQAB
-----END PUBLIC KEY-----'),

    // Environment settings
    'mode' => env('WEBXPAY_MODE', 'live'), // live or sandbox
    
    // WebXPay URLs
    'sandbox_url' => 'https://stagingxpay.info/index.php?route=checkout/billing',
    'live_url' => 'https://webxpay.com/index.php?route=checkout/billing',
    
    // Get the appropriate URL based on mode
    'checkout_url' => env('WEBXPAY_CHECKOUT_URL') ?: (env('WEBXPAY_MODE', 'live') === 'live' 
        ? 'https://webxpay.com/index.php?route=checkout/billing'
        : 'https://stagingxpay.info/index.php?route=checkout/billing'),
    
    // Supported currencies
    'currency' => 'LKR',
    'supported_currencies' => ['LKR', 'USD'],
    
    // Encryption method
    'encryption_method' => 'JCs3J+6oSz4V0LgE0zi/Bg==',
    
    // CMS identifier
    'cms' => 'Laravel',
    
    // Payment status codes
    'status_codes' => [
        '1' => 'success',
        '2' => 'pending',
        '3' => 'failed',
        '4' => 'cancelled',
        '5' => 'declined',
        '6' => 'expired',
    ],
    
    // Return URL (will be dynamically set)
    'return_url' => env('WEBXPAY_RETURN_URL', env('APP_URL') . '/payment/webxpay/return'),
    'cancel_url' => env('WEBXPAY_CANCEL_URL', env('APP_URL') . '/payment/webxpay/cancel'),
    'notify_url' => env('WEBXPAY_NOTIFY_URL', env('APP_URL') . '/payment/webxpay/notify'),
];
