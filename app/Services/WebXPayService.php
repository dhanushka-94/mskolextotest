<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Exception;

class WebXPayService
{
    private $publicKey;
    private $secretKey;
    private $checkoutUrl;
    private $apiUsername;
    private $apiPassword;
    private $encryptionMethod;
    private $cms;

    public function __construct()
    {
        $this->publicKey = config('webxpay.public_key');
        $this->secretKey = config('webxpay.secret_key');
        $this->checkoutUrl = config('webxpay.checkout_url');
        $this->apiUsername = config('webxpay.api_username');
        $this->apiPassword = config('webxpay.api_password');
        $this->encryptionMethod = config('webxpay.encryption_method');
        $this->cms = config('webxpay.cms');
    }

    /**
     * Prepare payment data for WebXPay
     */
    public function preparePayment(Order $order): array
    {
        try {
            // Prepare the plaintext for encryption: unique_order_id|total_amount
            $plaintext = $order->order_number . '|' . number_format($order->total_amount, 2, '.', '');
            
            // Encrypt the payment data using public key
            if (!openssl_public_encrypt($plaintext, $encryptedData, $this->publicKey)) {
                throw new Exception('Failed to encrypt payment data');
            }
            
            // Base64 encode the encrypted data
            $payment = base64_encode($encryptedData);
            
            // Prepare custom fields (you can customize this as needed)
            $customFields = $this->prepareCustomFields($order);
            $customFieldsEncoded = base64_encode($customFields);
            
            // Validate and format contact number
            $contactNumber = $this->formatPhoneNumber($order->customer_phone);
            
            // Validate required fields
            $firstName = $this->getFirstName($order->customer_name);
            $lastName = $this->getLastName($order->customer_name);
            $email = $order->customer_email ?: 'customer@mskcomputers.lk';
            $addressLine1 = $order->billing_address_line_1 ?: $order->shipping_address_line_1;
            $city = $order->billing_city ?: $order->shipping_city;
            
            if (empty($firstName) || empty($addressLine1) || empty($city) || empty($contactNumber)) {
                throw new Exception('Missing required customer information for WebXPay');
            }
            
            // Prepare payment form data with fallbacks for required fields
            $paymentData = [
                'checkout_url' => $this->checkoutUrl,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'contact_number' => $contactNumber,
                'address_line_one' => $addressLine1,
                'address_line_two' => $order->billing_address_line_2 ?: $order->shipping_address_line_2 ?: '',
                'city' => $city,
                'state' => $order->billing_state ?: $order->shipping_state ?: 'Western Province',
                'postal_code' => $order->billing_postal_code ?: $order->shipping_postal_code ?: '10100',
                'country' => $order->billing_country ?: $order->shipping_country ?: 'Sri Lanka',
                'process_currency' => config('webxpay.currency'),
                'cms' => $this->cms,
                'custom_fields' => $customFieldsEncoded,
                'enc_method' => $this->encryptionMethod,
                'secret_key' => $this->secretKey,
                'payment' => $payment,
            ];
            
            Log::info('WebXPay payment prepared', [
                'order_number' => $order->order_number,
                'amount' => $order->total_amount,
                'plaintext' => $plaintext,
                'checkout_url' => $paymentData['checkout_url'],
                'customer_data' => [
                    'first_name' => $paymentData['first_name'],
                    'last_name' => $paymentData['last_name'],
                    'email' => $paymentData['email'],
                    'contact_number' => $paymentData['contact_number'],
                    'address_line_one' => $paymentData['address_line_one'],
                    'city' => $paymentData['city'],
                    'state' => $paymentData['state'],
                    'country' => $paymentData['country'],
                    'process_currency' => $paymentData['process_currency'],
                    'cms' => $paymentData['cms']
                ]
            ]);
            
            return $paymentData;
            
        } catch (Exception $e) {
            Log::error('WebXPay payment preparation failed', [
                'order_number' => $order->order_number,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Process WebXPay response
     */
    public function processResponse(array $responseData): array
    {
        try {
            // Decode the response data
            $payment = base64_decode($responseData['payment']);
            $signature = base64_decode($responseData['signature']);
            $customFields = isset($responseData['custom_fields']) ? base64_decode($responseData['custom_fields']) : '';
            
            // Verify signature
            $signatureValid = $this->verifySignature($payment, $signature);
            
            if (!$signatureValid) {
                throw new Exception('Invalid signature - payment response verification failed');
            }
            
            // Parse payment response
            // Format: order_id|order_reference_number|date_time_transaction|payment_gateway_used|status_code|comment
            $responseVariables = explode('|', $payment);
            
            if (count($responseVariables) < 6) {
                throw new Exception('Invalid payment response format');
            }
            
            $result = [
                'order_id' => $responseVariables[0],
                'reference_number' => $responseVariables[1],
                'transaction_datetime' => $responseVariables[2],
                'payment_gateway' => $responseVariables[3],
                'status_code' => $responseVariables[4],
                'comment' => $responseVariables[5],
                'custom_fields' => $customFields,
                'signature_valid' => $signatureValid,
                'payment_status' => $this->mapStatusCode($responseVariables[4])
            ];
            
            Log::info('WebXPay response processed', $result);
            
            return $result;
            
        } catch (Exception $e) {
            Log::error('WebXPay response processing failed', [
                'error' => $e->getMessage(),
                'response_data' => $responseData
            ]);
            throw $e;
        }
    }

    /**
     * Update order status based on WebXPay response
     */
    public function updateOrderStatus(Order $order, array $responseData): bool
    {
        try {
            $processedResponse = $this->processResponse($responseData);
            
            // Verify order number matches
            if ($processedResponse['order_id'] !== $order->order_number) {
                throw new Exception('Order number mismatch');
            }
            
            // Update order based on payment status
            switch ($processedResponse['payment_status']) {
                case 'success':
                    $order->update([
                        'payment_status' => 'paid',
                        'payment_reference' => $processedResponse['reference_number'],
                        'payment_method' => 'webxpay'
                    ]);
                    break;
                    
                case 'pending':
                    $order->update([
                        'payment_status' => 'pending',
                        'payment_reference' => $processedResponse['reference_number'],
                        'payment_method' => 'webxpay'
                    ]);
                    break;
                    
                case 'failed':
                case 'declined':
                case 'cancelled':
                case 'expired':
                    $order->update([
                        'payment_status' => 'failed',
                        'payment_reference' => $processedResponse['reference_number'],
                        'payment_method' => 'webxpay'
                    ]);
                    break;
            }
            
            Log::info('Order status updated from WebXPay', [
                'order_number' => $order->order_number,
                'payment_status' => $processedResponse['payment_status'],
                'reference' => $processedResponse['reference_number']
            ]);
            
            return true;
            
        } catch (Exception $e) {
            Log::error('Failed to update order status from WebXPay', [
                'order_number' => $order->order_number,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Verify payment signature
     */
    private function verifySignature(string $payment, string $signature): bool
    {
        try {
            if (!openssl_public_decrypt($signature, $decryptedValue, $this->publicKey)) {
                return false;
            }
            
            return $decryptedValue === $payment;
            
        } catch (Exception $e) {
            Log::error('Signature verification failed', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Map WebXPay status codes to our internal status
     */
    private function mapStatusCode(string $statusCode): string
    {
        $statusMap = config('webxpay.status_codes');
        return $statusMap[$statusCode] ?? 'unknown';
    }

    /**
     * Prepare custom fields for the payment
     */
    private function prepareCustomFields(Order $order): string
    {
        // You can customize this to include any additional data you need
        return implode('|', [
            'msk_computers',           // cus_1: Store identifier
            $order->id,               // cus_2: Internal order ID
            $order->user_id ?? 'guest', // cus_3: User ID or guest
            date('Y-m-d H:i:s')       // cus_4: Timestamp
        ]);
    }

    /**
     * Extract first name from full name
     */
    private function getFirstName(string $fullName): string
    {
        $parts = explode(' ', trim($fullName));
        return $parts[0] ?? '';
    }

    /**
     * Extract last name from full name
     */
    private function getLastName(string $fullName): string
    {
        $parts = explode(' ', trim($fullName));
        return count($parts) > 1 ? implode(' ', array_slice($parts, 1)) : '';
    }

    /**
     * Get payment status display text
     */
    public function getStatusDisplayText(string $status): string
    {
        $statusTexts = [
            'success' => 'Payment Successful',
            'pending' => 'Payment Pending',
            'failed' => 'Payment Failed',
            'cancelled' => 'Payment Cancelled',
            'declined' => 'Payment Declined',
            'expired' => 'Payment Expired',
            'unknown' => 'Unknown Status'
        ];
        
        return $statusTexts[$status] ?? 'Unknown Status';
    }

    /**
     * Format phone number for WebXPay (Sri Lankan format)
     */
    private function formatPhoneNumber($phone): string
    {
        if (empty($phone)) {
            return '';
        }
        
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Handle different Sri Lankan phone number formats
        if (strlen($phone) == 10 && substr($phone, 0, 1) == '0') {
            // Format: 0771234567 -> 0771234567 (keep as is)
            return $phone;
        } elseif (strlen($phone) == 9 && substr($phone, 0, 1) == '7') {
            // Format: 771234567 -> 0771234567 (add leading 0)
            return '0' . $phone;
        } elseif (strlen($phone) == 12 && substr($phone, 0, 3) == '947') {
            // Format: 947712345678 -> 0771234567 (remove country code)
            return '0' . substr($phone, 3);
        } elseif (strlen($phone) == 11 && substr($phone, 0, 2) == '94') {
            // Format: 94771234567 -> 0771234567 (remove country code)
            return '0' . substr($phone, 2);
        }
        
        // Return as is if format is not recognized
        return $phone;
    }
}
