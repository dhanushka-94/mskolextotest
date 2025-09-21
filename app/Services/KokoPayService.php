<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class KokoPayService
{
    private $config;

    public function __construct()
    {
        $this->config = config('kokopay');
    }

    /**
     * Prepare payment data for Koko Pay
     */
    public function preparePayment($orderData)
    {
        try {
            // Generate unique reference
            $reference = $this->config['merchant_id'] . rand(111, 999) . '-' . $orderData['order_id'];
            
            // Validate required customer data
            $this->validateCustomerData($orderData);
            
            // Prepare payment parameters (matching working CodeIgniter implementation)
            $paymentData = [
                '_mId' => $this->config['merchant_id'],
                'api_key' => $this->config['api_key'],
                '_returnUrl' => $this->config['return_url'],
                '_cancelUrl' => $this->config['cancel_url'],
                '_responseUrl' => $this->config['notify_url'],
                '_amount' => $this->formatAmount($orderData['amount']),
                '_currency' => $this->config['currency'],
                '_reference' => $reference,
                '_orderId' => $orderData['order_id'],
                '_pluginName' => 'customapi',
                '_pluginVersion' => '1.0.1',
                '_firstName' => $orderData['firstName'] ?? '',
                '_lastName' => $orderData['lastName'] ?? '',
                '_email' => $orderData['email'] ?? '',
                '_description' => $orderData['description'] ?? 'Order #' . $orderData['order_id'],
                '_mobileNo' => $orderData['contactNumber'] ?? '', // Added back as per working sample
            ];

            // Generate signature
            $dataString = $this->generateDataString($paymentData);
            $signature = $this->generateSignature($dataString);

            $paymentData['dataString'] = $dataString;
            $paymentData['signature'] = $signature;

            Log::info('Koko Pay payment data prepared', [
                'order_id' => $orderData['order_id'],
                'amount' => $paymentData['_amount'],
                'reference' => $reference
            ]);

            return [
                'success' => true,
                'data' => $paymentData,
                'api_url' => $this->config['api_url']
            ];

        } catch (Exception $e) {
            Log::error('Koko Pay payment preparation failed', [
                'error' => $e->getMessage(),
                'order_id' => $orderData['order_id'] ?? 'unknown'
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Generate data string for signature (EXACT order from working CodeIgniter implementation)
     */
    private function generateDataString($paymentData)
    {
        // CRITICAL: Exact order from working sample (line 153-155)
        return $paymentData['_mId'] . 
               $paymentData['_amount'] . 
               $paymentData['_currency'] . 
               $paymentData['_pluginName'] . 
               $paymentData['_pluginVersion'] . 
               $paymentData['_returnUrl'] . 
               $paymentData['_cancelUrl'] . 
               $paymentData['_orderId'] . 
               $paymentData['_reference'] . 
               $paymentData['_firstName'] . 
               $paymentData['_lastName'] . 
               $paymentData['_email'] . 
               $paymentData['_description'] . 
               $paymentData['api_key'] . 
               $paymentData['_responseUrl'];
        // Note: _mobileNo is NOT included in dataString as per working sample
    }

    /**
     * Generate RSA signature
     */
    private function generateSignature($dataString)
    {
        $privateKey = $this->config['private_key'];
        
        if (empty($privateKey)) {
            throw new Exception('Koko Pay private key not configured');
        }

        // Get private key resource
        $pkeyid = openssl_get_privatekey($privateKey);
        
        if (!$pkeyid) {
            throw new Exception('Invalid Koko Pay private key');
        }

        // Generate signature
        if (!openssl_sign($dataString, $signature, $pkeyid, OPENSSL_ALGO_SHA256)) {
            openssl_free_key($pkeyid);
            throw new Exception('Failed to generate Koko Pay signature: ' . openssl_error_string());
        }

        openssl_free_key($pkeyid);

        // Return base64 encoded signature
        return base64_encode($signature);
    }

    /**
     * Format amount for Koko Pay (expects decimal format, not cents)
     */
    private function formatAmount($amount)
    {
        return number_format($amount, 2, '.', ''); // Format as decimal with 2 places
    }

    /**
     * Format Sri Lankan phone number
     */
    private function formatPhoneNumber($phone)
    {
        if (empty($phone)) {
            return '';
        }

        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Format to Sri Lankan standard
        if (strlen($phone) == 10 && substr($phone, 0, 1) == '0') {
            return $phone; // Already in correct format
        } elseif (strlen($phone) == 9 && substr($phone, 0, 1) == '7') {
            return '0' . $phone; // Add leading zero
        } elseif (strlen($phone) == 12 && substr($phone, 0, 3) == '947') {
            return '0' . substr($phone, 3); // Convert from +94 format
        } elseif (strlen($phone) == 11 && substr($phone, 0, 2) == '94') {
            return '0' . substr($phone, 2); // Convert from 94 format
        }

        return $phone; // Return as-is if format not recognized
    }

    /**
     * Validate required customer data
     */
    private function validateCustomerData($orderData)
    {
        $required = ['firstName', 'email', 'order_id', 'amount'];
        
        foreach ($required as $field) {
            if (empty($orderData[$field])) {
                throw new Exception("Required field '{$field}' is missing for Koko Pay payment");
            }
        }

        // Validate email format
        if (!filter_var($orderData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format for Koko Pay payment');
        }

        // Validate amount
        if ($orderData['amount'] <= 0) {
            throw new Exception('Invalid amount for Koko Pay payment');
        }
    }

    /**
     * Verify webhook signature (for future use)
     */
    public function verifyWebhookSignature($payload, $signature)
    {
        // TODO: Implement webhook signature verification
        // This would be used to verify incoming webhook notifications
        return true;
    }

    /**
     * Get current configuration for testing
     */
    public function getConfig()
    {
        return [
            'mode' => $this->config['mode'],
            'merchant_id' => $this->config['merchant_id'],
            'api_url' => $this->config['api_url'],
            'currency' => $this->config['currency'],
            'plugin_name' => $this->config['plugin_name'],
            'plugin_version' => $this->config['plugin_version'],
        ];
    }
}
