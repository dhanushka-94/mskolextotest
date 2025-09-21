<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PayHere Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for PayHere payment gateway integration
    |
    */

    'merchant_id' => env('PAYHERE_MERCHANT_ID', ''),
    'merchant_secret' => env('PAYHERE_MERCHANT_SECRET', ''),
    'mode' => env('PAYHERE_MODE', 'sandbox'), // sandbox or live
    
    // PayHere URLs
    'sandbox_url' => 'https://sandbox.payhere.lk/pay/checkout',
    'live_url' => 'https://www.payhere.lk/pay/checkout',
    
    // Get the appropriate URL based on mode
    'checkout_url' => env('PAYHERE_MODE', 'sandbox') === 'live' 
        ? 'https://www.payhere.lk/pay/checkout'
        : 'https://sandbox.payhere.lk/pay/checkout',
    
    // Supported currencies
    'currency' => 'LKR',
    
    // Payment methods available
    'payment_methods' => [
        'visa' => 'Visa',
        'mastercard' => 'Mastercard',
        'amex' => 'American Express',
        'dialog' => 'Dialog eZ Cash',
        'mobitel' => 'Mobitel mCash',
        'bank_transfer' => 'Bank Transfer',
    ],
    
    // Test card numbers for sandbox
    'test_cards' => [
        'visa_success' => '4111111111111111',
        'mastercard_success' => '5555555555554444',
        'visa_declined' => '4000000000000002',
    ],
];
