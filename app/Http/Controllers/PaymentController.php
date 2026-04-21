<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\WebXPayService;
use App\Services\KokoPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // PayHere payment methods removed

    /**
     * Process card payment
     */
    public function processCardPayment(Request $request, Order $order)
    {
        $request->validate([
            'card_number' => 'required|string|size:16',
            'expiry_month' => 'required|string|size:2',
            'expiry_year' => 'required|string|size:2',
            'cvv' => 'required|string|size:3',
            'card_holder_name' => 'required|string|max:255',
        ]);

        // In a real implementation, you would integrate with a payment processor
        // For demo purposes, we'll simulate a successful payment
        
        try {
            // Simulate payment processing
            $paymentSuccess = $this->simulateCardPayment($request->all());
            
            if ($paymentSuccess) {
                $order->update([
                    'payment_status' => 'paid',
                    'payment_reference' => 'CARD_' . uniqid(),
                ]);

                return response()->json([
                    'success' => true,
                    'redirect_url' => route('checkout.success', $order->order_number)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment failed. Please check your card details and try again.'
                ], 422);
            }
        } catch (\Exception $e) {
            Log::error('Card payment error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Payment processing error. Please try again.'
            ], 500);
        }
    }

    /**
     * Simulate card payment (for demo purposes)
     */
    private function simulateCardPayment(array $cardData)
    {
        // Simulate different scenarios based on card number
        $cardNumber = $cardData['card_number'];
        
        // Test card numbers for demo
        if (in_array($cardNumber, ['4111111111111111', '5555555555554444'])) {
            return true; // Success
        } elseif ($cardNumber === '4000000000000002') {
            return false; // Declined
        } else {
            // Random success/failure for other cards
            return rand(1, 10) <= 8; // 80% success rate
        }
    }

    /**
     * Process mobile payment (Dialog eZ Cash, Mobitel mCash)
     */
    public function processMobilePayment(Request $request, Order $order)
    {
        $request->validate([
            'mobile_number' => 'required|string|regex:/^[0-9]{10}$/',
            'provider' => 'required|in:dialog,mobitel',
        ]);

        try {
            // In a real implementation, integrate with mobile payment APIs
            // For demo purposes, we'll simulate the process
            
            $paymentSuccess = $this->simulateMobilePayment($request->all());
            
            if ($paymentSuccess) {
                $order->update([
                    'payment_status' => 'paid',
                    'payment_reference' => strtoupper($request->provider) . '_' . uniqid(),
                ]);

                return response()->json([
                    'success' => true,
                    'redirect_url' => route('checkout.success', $order->order_number)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Mobile payment failed. Please check your mobile wallet balance and try again.'
                ], 422);
            }
        } catch (\Exception $e) {
            Log::error('Mobile payment error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Payment processing error. Please try again.'
            ], 500);
        }
    }

    /**
     * Simulate mobile payment (for demo purposes)
     */
    private function simulateMobilePayment(array $paymentData)
    {
        // Simulate payment success/failure
        return rand(1, 10) <= 9; // 90% success rate
    }

    /**
     * Check payment status
     */
    public function checkPaymentStatus(Order $order)
    {
        return response()->json([
            'order_number' => $order->order_number,
            'payment_status' => $order->payment_status,
            'payment_reference' => $order->payment_reference,
            'total_amount' => $order->total_amount,
        ]);
    }

    // ==================== WEBXPAY INTEGRATION ====================

    /**
     * Initiate WebXPay payment
     */
    public function initiateWebXPayPayment(Request $request, $order)
    {
        try {
            Log::info('WebXPay payment route accessed', [
                'order_param' => $order,
                'order_type' => gettype($order),
                'is_order_instance' => $order instanceof Order
            ]);

            // Handle both Order model and order ID
            if (!$order instanceof Order) {
                Log::info('Attempting to find order by ID', ['order_id' => $order]);
                $order = Order::findOrFail($order);
                Log::info('Order found', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number
                ]);
            }
            
            // Validate that order belongs to authenticated user or is guest order
            if ($order->user_id && $order->user_id !== auth()->id()) {
                Log::warning('Unauthorized access attempt', [
                    'order_user_id' => $order->user_id,
                    'auth_user_id' => auth()->id()
                ]);
                abort(403, 'Unauthorized access to order');
            }

            $webxpayService = new WebXPayService();
            $paymentData = $webxpayService->preparePayment($order);
            
            // Calculate discount information for order summary
            $subtotal = 0;
            $originalSubtotal = 0;
            $totalDiscount = 0;
            
            $order->loadMissing('orderItems.product');
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                if ($product) {
                    $lineTotal = $item->quantity * $product->final_price;
                    $originalLineTotal = $item->quantity * $product->price;
                    $lineDiscount = $originalLineTotal - $lineTotal;
                    
                    $subtotal += $lineTotal;
                    $originalSubtotal += $originalLineTotal;
                    $totalDiscount += $lineDiscount;
                }
            }
            
            // Calculate WebXPay transaction fee (3%)
            $transactionFee = $order->total_amount * 0.03;
            $totalWithFee = $order->total_amount + $transactionFee;
            
            Log::info('WebXPay payment initiated successfully', [
                'order_number' => $order->order_number,
                'base_amount' => $order->total_amount,
                'transaction_fee' => $transactionFee,
                'total_with_fee' => $totalWithFee,
                'discount_calculated' => $totalDiscount,
                'amount_sent_to_webxpay' => $totalWithFee
            ]);

            return view('payment.webxpay', compact('paymentData', 'order', 'subtotal', 'originalSubtotal', 'totalDiscount', 'transactionFee', 'totalWithFee'));

        } catch (\Exception $e) {
            Log::error('WebXPay payment initiation failed', [
                'order_param' => $order,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->view('errors.404', [
                'message' => 'Payment processing error: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Test WebXPay configuration
     */
    public function testWebXPay()
    {
        $config = [
            'mode' => config('webxpay.mode'),
            'checkout_url' => config('webxpay.checkout_url'),
            'sandbox_url' => config('webxpay.sandbox_url'),
            'live_url' => config('webxpay.live_url'),
            'api_username' => config('webxpay.api_username'),
            'currency' => config('webxpay.currency'),
            'cms' => config('webxpay.cms'),
            'has_public_key' => !empty(config('webxpay.public_key')),
            'has_secret_key' => !empty(config('webxpay.secret_key')),
            'return_url' => config('webxpay.return_url'),
            'cancel_url' => config('webxpay.cancel_url'),
            'notify_url' => config('webxpay.notify_url'),
        ];

        return response()->json([
            'status' => 'Configuration loaded',
            'config' => $config,
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    /**
     * Test WebXPay return URL accessibility
     */
    public function testWebXPayReturnUrl()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'WebXPay return URL is accessible',
            'url' => url('/pay/webxpayResponse'),
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    /**
     * Handle WebXPay return
     * WebXPay sends POST data with base64-encoded: payment, signature, custom_fields
     */
    public function handleWebXPayReturn(Request $request)
    {
        try {
            // CRITICAL: Prevent redirect loops by checking referer
            $referer = $request->header('referer', '');
            if (str_contains($referer, '/cart') && str_contains($referer, 'mskcomputers.lk')) {
                Log::warning('🛡️ POTENTIAL REDIRECT LOOP DETECTED - WebXPay return called from cart page', [
                    'referer' => $referer,
                    'request_url' => $request->fullUrl(),
                    'loop_prevention_active' => true
                ]);
            }
            
            // Check if data was passed from cart redirect
            $webxpayData = session('webxpay_data');
            if ($webxpayData && !$request->has('payment')) {
                Log::info('WebXPay data retrieved from cart redirect', ['webxpay_data' => $webxpayData]);
                $request->merge($webxpayData);
                session()->forget('webxpay_data');
            }

            // Enhanced logging for debugging WebXPay return issues
            // WebXPay sends POST data with base64-encoded parameters: payment, signature, custom_fields
            Log::info('🔄 WebXPay return handler called', [
                'request_method' => $request->method(),
                'request_url' => $request->fullUrl(),
                'request_data' => $request->all(),
                'query_params' => $request->query() ? $request->query()->all() : [],
                'post_params' => $request->isMethod('POST') ? $request->all() : [],
                'raw_input' => $request->getContent(),
                'has_payment' => $request->has('payment'),
                'has_signature' => $request->has('signature'),
                'has_custom_fields' => $request->has('custom_fields'),
                'payment_value_preview' => $request->input('payment') ? substr($request->input('payment'), 0, 50) . '...' : 'missing',
                'signature_value_preview' => $request->input('signature') ? substr($request->input('signature'), 0, 50) . '...' : 'missing',
                'from_cart_redirect' => !empty($webxpayData),
                'referer' => $referer,
                'user_agent' => $request->header('User-Agent'),
                'ip_address' => $request->ip(),
                'session_id' => session()->getId(),
                'content_type' => $request->header('Content-Type'),
                'timestamp' => now()->toDateTimeString()
            ]);

            // CRITICAL: WebXPay sends POST data with base64-encoded parameters
            // Check both GET (for testing) and POST (for actual WebXPay response)
            $paymentParam = $request->input('payment'); // input() checks both GET and POST
            $signatureParam = $request->input('signature');
            $customFieldsParam = $request->input('custom_fields');

            // Validate required parameters with enhanced error handling
            if (empty($paymentParam) || empty($signatureParam)) {
                Log::error('❌ WebXPay return missing required parameters', [
                    'available_keys' => array_keys($request->all()),
                    'query_keys' => $request->query() ? array_keys($request->query()->all()) : [],
                    'post_keys' => $request->isMethod('POST') ? array_keys($request->all()) : [],
                    'missing_payment' => empty($paymentParam),
                    'missing_signature' => empty($signatureParam),
                    'url' => $request->fullUrl(),
                    'referer' => $request->header('referer'),
                    'all_request_data' => $request->all(),
                    'raw_input' => $request->getContent()
                ]);
                
                // If this is a test URL without signature, redirect to home to prevent loop
                if (!empty($paymentParam) && $paymentParam === 'success') {
                    Log::warning('⚠️ WebXPay test URL detected - redirecting to home');
                    return redirect()->route('home')
                        ->with('error', 'Test URL detected. WebXPay requires both payment and signature parameters for security. Please use a real WebXPay transaction.');
                }
                
                // CRITICAL FIX: Instead of redirecting to checkout.index (which causes loop),
                // redirect to a static success page or show an error page
                // Check if we can extract order info from session or referer
                $orderNumber = session('webxpay_order_number') ?? session('payment_success_order');
                
                if ($orderNumber) {
                    Log::info('📋 Found order number in session, redirecting to success page', ['order_number' => $orderNumber]);
                    return redirect()->route('checkout.success', $orderNumber)
                        ->with('info', 'Payment processing completed. Please check your order status.');
                }
                
                // Last resort: redirect to home instead of checkout to prevent loop
                Log::error('🚫 WebXPay missing parameters - redirecting to home to prevent loop');
                return redirect()->route('home')
                    ->with('error', 'Payment verification failed. Missing required payment data. Please contact support with your order number if you completed a payment.');
            }
            
            // Prepare response data for processing
            // WebXPay sends: payment (base64), signature (base64), custom_fields (base64)
            $responseData = [
                'payment' => $paymentParam,
                'signature' => $signatureParam,
                'custom_fields' => $customFieldsParam ?? null
            ];
            
            Log::info('📦 WebXPay response data prepared for processing', [
                'has_payment' => !empty($responseData['payment']),
                'has_signature' => !empty($responseData['signature']),
                'has_custom_fields' => !empty($responseData['custom_fields']),
                'payment_length' => strlen($responseData['payment'] ?? ''),
                'signature_length' => strlen($responseData['signature'] ?? ''),
                'request_method' => $request->method()
            ]);

            $webxpayService = new WebXPayService();
            
            // Process the response (this will decode base64 and verify signature)
            $processedResponse = $webxpayService->processResponse($responseData);
            
            Log::info('WebXPay processed response', [
                'processed_response' => $processedResponse,
                'payment_status' => $processedResponse['payment_status'] ?? 'not_set'
            ]);
            
            // Find the order with enhanced error handling
            $orderNumber = $processedResponse['order_id'] ?? 'unknown';
            $order = Order::where('order_number', $orderNumber)->first();
            
            if (!$order) {
                Log::error('❌ WebXPay order not found', [
                    'order_number' => $orderNumber,
                    'processed_response' => $processedResponse,
                    'available_orders' => Order::latest()->limit(5)->pluck('order_number')->toArray()
                ]);
                
                // If payment status is success, still redirect to success page (order might be created elsewhere)
                // Store order number in session for success page access
                if (!empty($orderNumber) && $orderNumber !== 'unknown') {
                    session(['payment_success_order' => $orderNumber]);
                    return redirect()->route('checkout.success', $orderNumber)
                        ->with('warning', "Order verification pending. Order number: {$orderNumber}. Please contact support if you don't see your order.");
                }
                
                // Last resort: redirect to checkout with error
                return redirect()->route('checkout.index')
                    ->with('error', "Order not found: {$orderNumber}. Please check your order details or contact support.");
            }

            Log::info('WebXPay order found', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'current_payment_status' => $order->payment_status
            ]);

            // Update order status using service (creates/updates transactions as well)
            $updateSuccess = $webxpayService->updateOrderStatus($order, $responseData);
            
            // Fallback: if service update failed but processed response clearly indicates success,
            // force-update the order to "paid" so backend matches the thank-you page.
            if (!$updateSuccess) {
                Log::error('WebXPay failed to update order status via service, attempting fallback update', [
                    'order_number' => $order->order_number,
                    'processed_payment_status' => $processedResponse['payment_status'] ?? null,
                ]);

                $freshOrder = $order->fresh();

                if (($processedResponse['payment_status'] ?? null) === 'success' && $freshOrder && $freshOrder->payment_status !== 'paid') {
                    $freshOrder->update([
                        'payment_status' => 'paid',
                        'payment_method' => 'webxpay',
                        'payment_reference' => $processedResponse['reference_number'] ?? $freshOrder->payment_reference,
                    ]);

                    Log::info('WebXPay fallback: order forcibly marked as paid after successful gateway response', [
                        'order_number' => $freshOrder->order_number,
                        'current_payment_status' => $freshOrder->payment_status,
                    ]);
                }
            }

            Log::info('WebXPay about to redirect', [
                'payment_status' => $processedResponse['payment_status'],
                'order_number' => $order->order_number
            ]);

            // Redirect based on payment status
            switch ($processedResponse['payment_status']) {
                case 'success':
                    Log::info('WebXPay success - redirecting to success page');
                    // Store order number in session for cart clearing
                    session(['payment_success_order' => $order->order_number]);
                    
                    return redirect()->route('checkout.success', $order->order_number)
                        ->with('success', 'Payment completed successfully via WebXPay!');
                        
                case 'pending':
                    Log::info('WebXPay pending - redirecting to success page');
                    // Store order number in session for cart clearing
                    session(['payment_success_order' => $order->order_number]);
                    
                    return redirect()->route('checkout.success', $order->order_number)
                        ->with('info', 'Payment is being processed. You will receive confirmation once completed.');
                        
                default:
                    Log::warning('WebXPay non-success status', [
                        'payment_status' => $processedResponse['payment_status'],
                        'comment' => $processedResponse['comment'] ?? 'No comment',
                        'status_code' => $processedResponse['status_code'] ?? 'unknown'
                    ]);
                    
                    // Even for failed payments, redirect to success page so user can see order details
                    // This provides better UX - user can see what happened and contact support if needed
                    session(['payment_success_order' => $order->order_number]);
                    return redirect()->route('checkout.success', $order->order_number)
                        ->with('warning', 'Payment status: ' . ($processedResponse['comment'] ?? 'Unknown status') . '. Please verify your payment or contact support.');
            }

        } catch (\Exception $e) {
            Log::error('💥 WebXPay return handling failed', [
                'error' => $e->getMessage(),
                'error_line' => $e->getLine(),
                'error_file' => $e->getFile(),
                'request_data' => $request->all(),
                'order_number' => isset($order) ? $order->order_number : 'unknown',
                'stack_trace' => $e->getTraceAsString()
            ]);

            // CRITICAL: Try to extract order number from multiple sources
            $orderNumber = null;
            
            // First, try to get from order object if it exists
            if (isset($order) && $order->order_number) {
                $orderNumber = $order->order_number;
            }
            
            // Second, try to extract from payment parameter if available
            if (!$orderNumber && $request->has('payment')) {
                try {
                    $paymentParam = $request->input('payment');
                    if ($paymentParam) {
                        $decoded = base64_decode($paymentParam);
                        if ($decoded) {
                            $parts = explode('|', $decoded);
                            if (isset($parts[0]) && !empty($parts[0])) {
                                $orderNumber = $parts[0];
                            }
                        }
                    }
                } catch (\Exception $decodeError) {
                    Log::warning('Could not decode payment parameter to extract order number', [
                        'error' => $decodeError->getMessage()
                    ]);
                }
            }
            
            // Third, try session variables
            if (!$orderNumber) {
                $orderNumber = session('webxpay_order_number') ?? session('payment_success_order');
            }
            
            // If we have an order number, ALWAYS redirect to success page
            // This ensures users see the thank you page even if there's a processing error
            if ($orderNumber) {
                Log::info('📋 Redirecting to success page despite error', [
                    'order_number' => $orderNumber,
                    'error' => $e->getMessage()
                ]);
                
                // Try to find and update the order if it exists
                try {
                    $foundOrder = Order::where('order_number', $orderNumber)->first();
                    if ($foundOrder) {
                        // Mark payment as potentially completed (user can verify later)
                        if ($foundOrder->payment_status !== 'paid') {
                            $foundOrder->update([
                                'payment_status' => 'pending',
                                'payment_method' => 'webxpay'
                            ]);
                        }
                    }
                } catch (\Exception $orderError) {
                    Log::warning('Could not update order status', ['error' => $orderError->getMessage()]);
                }
                
                return redirect()->route('checkout.success', $orderNumber)
                    ->with('warning', 'Payment processing encountered an issue. Please verify your payment status or contact support.');
            }

            // Check if this is a WebXPay specific error code
            $webxpayService = new WebXPayService();
            $errorMessage = $e->getMessage();
            
            // Try to extract error code from message if present
            if (preg_match('/(\d{3})/', $errorMessage, $matches)) {
                $errorCode = $matches[1];
                $errorMessage = $webxpayService->handleWebXPayError($errorCode, $errorMessage);
            }

            // Last resort: redirect to home if we can't find order number
            Log::warning('🔄 WebXPay error - no order number found, redirecting to home');
            return redirect()->route('home')
                ->with('error', 'Payment processing failed: ' . $errorMessage . ' Please try again or contact support.');
        }
    }

    /**
     * Handle WebXPay cancel
     */
    public function handleWebXPayCancel(Request $request)
    {
        Log::info('WebXPay payment cancelled', $request->all());
        
        // CRITICAL FIX: Redirect to home instead of checkout.index to prevent redirect loop
        return redirect()->route('home')
            ->with('error', 'Payment was cancelled. You can try again or choose a different payment method.');
    }

    /**
     * Handle WebXPay notify (webhook)
     */
    public function handleWebXPayNotify(Request $request)
    {
        try {
            // Validate required parameters
            if (!$request->has(['payment', 'signature'])) {
                Log::error('WebXPay notify: Missing required parameters');
                return response('Missing parameters', 400);
            }

            $webxpayService = new WebXPayService();
            $responseData = $request->all();
            
            // Process the response
            $processedResponse = $webxpayService->processResponse($responseData);
            
            // Find the order
            $order = Order::where('order_number', $processedResponse['order_id'])->first();
            
            if (!$order) {
                Log::error('WebXPay notify: Order not found', ['order_id' => $processedResponse['order_id']]);
                return response('Order not found', 404);
            }

            // Update order status
            $updateSuccess = $webxpayService->updateOrderStatus($order, $responseData);
            
            if ($updateSuccess) {
                Log::info('WebXPay notification processed successfully', [
                    'order_number' => $order->order_number,
                    'payment_status' => $processedResponse['payment_status'],
                    'reference' => $processedResponse['reference_number']
                ]);
                
                // TODO: Send email notification to customer about payment status
                
                return response('OK', 200);
            } else {
                Log::error('WebXPay notify: Failed to update order status');
                return response('Update failed', 500);
            }

        } catch (\Exception $e) {
            Log::error('WebXPay notification processing failed', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            
            return response('Processing failed', 500);
        }
    }

    /**
     * Check WebXPay payment status
     */
    public function checkWebXPayPaymentStatus(Order $order)
    {
        return response()->json([
            'order_number' => $order->order_number,
            'payment_status' => $order->payment_status,
            'payment_reference' => $order->payment_reference,
            'payment_method' => $order->payment_method,
            'total_amount' => $order->total_amount,
        ]);
    }

    /**
     * Initiate Koko Pay payment
     */
    public function initiateKokoPayPayment(Request $request, Order $order)
    {
        try {
            // Validate that order belongs to authenticated user or is guest order
            if ($order->user_id && $order->user_id !== auth()->id()) {
                Log::warning('Unauthorized access to Koko Pay order', [
                    'order_id' => $order->id,
                    'order_user_id' => $order->user_id,
                    'auth_user_id' => auth()->id()
                ]);
                abort(403, 'Unauthorized access to order');
            }

            Log::info('Initiating Koko Pay payment', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'auth_check' => auth()->check(),
                'order_user_id' => $order->user_id
            ]);

            // Calculate order totals
            $orderItems = $order->orderItems()->with('product')->get();
            $originalSubtotal = $orderItems->sum(function($item) {
                return $item->quantity * $item->product->price;
            });
            
            $subtotal = $orderItems->sum('total_price');
            $totalDiscount = $originalSubtotal - $subtotal;
            $transactionFee = $subtotal * 0.10; // 10% transaction fee for Koko Pay
            $totalWithFee = $subtotal + $transactionFee;

            // Split customer name into first and last name
            $nameParts = explode(' ', trim($order->customer_name), 2);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';

            // Prepare customer data for Koko Pay
            $customerData = [
                'order_id' => $order->id,
                'amount' => $totalWithFee,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $order->customer_email ?: 'customer@mskcomputers.lk',
                'contactNumber' => $order->customer_phone,
                'description' => 'MSK Computers Order #' . $order->id,
            ];

            Log::info('Koko Pay customer data prepared', $customerData);

            // Initialize Koko Pay service
            $kokoPayService = new KokoPayService();
            $paymentResult = $kokoPayService->preparePayment($customerData);

            if (!$paymentResult['success']) {
                Log::error('Koko Pay payment preparation failed', [
                    'order_id' => $order->id,
                    'error' => $paymentResult['error']
                ]);
                
                return redirect()->back()->with('error', 'Payment initialization failed: ' . $paymentResult['error']);
            }

            // Store order in session for return handling
            session(['kokopay_order_id' => $order->id]);

            Log::info('Koko Pay payment initialized successfully', [
                'order_id' => $order->id,
                'reference' => $paymentResult['data']['_reference']
            ]);

            // Pass all data to the payment view
            return view('payment.kokopay', [
                'order' => $order,
                'paymentData' => $paymentResult['data'],
                'apiUrl' => $paymentResult['api_url'],
                'originalSubtotal' => $originalSubtotal,
                'totalDiscount' => $totalDiscount,
                'subtotal' => $subtotal,
                'transactionFee' => $transactionFee,
                'totalWithFee' => $totalWithFee,
            ]);

        } catch (\Exception $e) {
            Log::error('Koko Pay payment initiation error', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Payment initialization failed. Please try again.');
        }
    }

    /**
     * Handle Koko Pay Return URL (_returnUrl) - Frontend Redirection
     * 
     * When payment is successful, user is redirected here from Koko Pay.
     * URL: http://eComm.com/orders/66/returned/3
     * Parameters: orderId, trnId, status (SUCCESS)
     * 
     * This is the user-facing confirmation but not 100% secure.
     * The webhook (Response URL) provides server-to-server confirmation.
     */
    public function handleKokoPayReturn(Request $request)
    {
        // Log KokoPay return request
        Log::info('KokoPay return request received', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'data' => $request->all()
        ]);
        
        Log::info('Koko Pay return received', $request->all());

        // Get order ID from URL parameter or session
        $orderId = $request->get('orderId') ?? session('kokopay_order_id');
        
        if (!$orderId) {
            Log::warning('No Koko Pay order ID in request or session', [
                'request_params' => $request->all(),
                'session_id' => session('kokopay_order_id')
            ]);
            return redirect()->route('checkout.index')->with('error', 'Session expired. Please try again.');
        }

        $order = Order::find($orderId);
        
        if (!$order) {
            Log::error('Koko Pay return: Order not found', ['order_id' => $orderId]);
            return redirect()->route('checkout.index')->with('error', 'Order not found.');
        }

        // Check payment status from the return parameters (case-insensitive)
        $paymentStatus = strtolower($request->get('status', 'failed'));
        $transactionId = $request->get('trnId', '');
        $description = $request->get('desc', '');
        
        Log::info('Processing Koko Pay payment status', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'status' => $paymentStatus,
            'original_status' => $request->get('status'),
            'transaction_id' => $transactionId,
            'full_request_data' => $request->all()
        ]);
        
        if ($paymentStatus === 'success' || $paymentStatus === 'completed' || $paymentStatus === 'paid') {
            // Update order status
            $order->update([
                'payment_status' => 'paid',
                'payment_method' => 'kokopay',
                'payment_reference' => $transactionId,
                'status' => 'confirmed' // Update order status as well
            ]);

            // Create or find existing transaction record for admin transactions page
            $transactionRecord = \App\Models\Transaction::firstOrCreate(
                [
                    'transaction_id' => 'TXN-' . strtoupper(substr($transactionId, 0, 16)),
                ],
                [
                    'order_id' => $order->id,
                    'payment_method' => 'kokopay',
                    'status' => 'completed',
                    'amount' => $order->total_amount,
                    'currency' => 'LKR',
                    'gateway_transaction_id' => $transactionId, // trnId
                    'gateway_reference' => $request->get('orderId', ''), // orderId
                    'gateway_response' => $request->all(), // Complete raw response
                    'customer_name' => $order->customer_name,
                    'customer_email' => $order->customer_email,
                    'customer_phone' => $order->customer_phone,
                    'description' => $description ?: "Koko Pay payment for order {$order->order_number}", // desc field
                    'initiated_at' => $order->created_at,
                    'completed_at' => now(),
                    'metadata' => [
                        // KOKO PAY CORE PARAMETERS
                        'orderId' => $request->get('orderId', ''),
                        'trnId' => $transactionId,
                        'status' => $request->get('status', ''),
                        'desc' => $description,
                        
                        // KOKO PAY ADDITIONAL PARAMETERS  
                        'key' => $request->get('key', ''),
                        'frontend' => $request->get('frontend', false),
                        'wc_api' => $request->get('wc-api', ''),
                        
                        // INTERNAL TRACKING
                        'source' => 'return_url',
                        'payment_flow' => 'successful',
                        'koko_pay_order_id' => $request->get('orderId', ''), // Legacy compatibility
                        'koko_pay_transaction_id' => $transactionId, // Legacy compatibility
                    ],
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
            ]);

            // Clear session
            session()->forget('kokopay_order_id');

            // Clear cart after successful payment
            \App\Models\Cart::where('session_id', session()->getId())
                ->orWhere(function($query) {
                    if (\Illuminate\Support\Facades\Auth::check()) {
                        $query->where('user_id', \Illuminate\Support\Facades\Auth::id());
                    }
                })
                ->delete();

            Log::info('Koko Pay payment completed successfully', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'payment_reference' => $transactionId,
                'description' => $description,
                'transaction_created' => true,
                'cart_cleared' => true
            ]);

            // Log successful redirect
            Log::info('KokoPay payment successful, redirecting to success page', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'redirect_route' => route('checkout.success', $order->order_number)
            ]);

            // Store order number in session for cart clearing and access control
            session(['payment_success_order' => $order->order_number]);

            // Use order_number (not id) for success route
            return redirect()->route('checkout.success', $order->order_number)
                           ->with('success', 'Payment completed successfully with Koko Pay!');
        } else {
            // Create or find existing transaction record for failed payment
            $failedTransactionId = 'TXN-' . strtoupper(substr($transactionId ?: uniqid(), 0, 16));
            \App\Models\Transaction::firstOrCreate(
                ['transaction_id' => $failedTransactionId],
                [
                'order_id' => $order->id,
                'payment_method' => 'kokopay',
                'status' => 'failed',
                'amount' => $order->total_amount,
                'currency' => 'LKR',
                'gateway_transaction_id' => $transactionId, // trnId
                'gateway_reference' => $request->get('orderId', ''), // orderId
                'gateway_response' => $request->all(), // Complete raw response
                'customer_name' => $order->customer_name,
                'customer_email' => $order->customer_email,
                'customer_phone' => $order->customer_phone,
                'description' => $description ?: "Failed Koko Pay payment for order {$order->order_number}", // desc field
                'failure_reason' => "Payment status: {$paymentStatus}. " . ($description ? "Description: {$description}" : ''),
                'initiated_at' => $order->created_at,
                'failed_at' => now(),
                'metadata' => [
                    // KOKO PAY CORE PARAMETERS
                    'orderId' => $request->get('orderId', ''),
                    'trnId' => $transactionId,
                    'status' => $request->get('status', ''),
                    'desc' => $description,
                    
                    // KOKO PAY ADDITIONAL PARAMETERS
                    'key' => $request->get('key', ''),
                    'frontend' => $request->get('frontend', false),
                    'wc_api' => $request->get('wc-api', ''),
                    
                    // INTERNAL TRACKING
                    'source' => 'return_url',
                    'payment_flow' => 'failed',
                    'original_status' => $request->get('status'),
                    'koko_pay_order_id' => $request->get('orderId', ''), // Legacy compatibility
                    'koko_pay_transaction_id' => $transactionId, // Legacy compatibility
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                ]
            );

            Log::warning('Koko Pay payment failed or cancelled', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $paymentStatus,
                'original_status' => $request->get('status'),
                'transaction_id' => $transactionId,
                'description' => $description,
                'request_data' => $request->all(),
                'transaction_created' => true
            ]);

            return redirect()->route('checkout.index')
                           ->with('error', 'Payment was not completed. Please try again.');
        }
    }

    /**
     * Handle Koko Pay Cancel URL (_cancelUrl) - User Cancelled Payment
     * 
     * When payment fails or is cancelled, user is redirected here.
     * URL: http://eComm.com/orders/66/cancel/3
     * Parameters: orderId, trnId, status (FAILED)
     */
    public function handleKokoPayCancel(Request $request)
    {
        Log::info('Koko Pay payment cancelled', $request->all());

        $orderId = $request->get('orderId') ?? session('kokopay_order_id');
        $transactionId = $request->get('trnId', '');
        $paymentStatus = strtolower($request->get('status', 'cancelled'));
        
        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
                // Update order status
                $order->update([
                    'payment_status' => 'failed',
                    'payment_method' => 'kokopay',
                    'payment_reference' => $transactionId
                ]);
                
                // Create or find existing transaction record for cancelled payment
                $cancelledTransactionId = 'TXN-' . strtoupper(substr($transactionId ?: uniqid(), 0, 16));
                \App\Models\Transaction::firstOrCreate(
                    ['transaction_id' => $cancelledTransactionId],
                    [
                    'order_id' => $order->id,
                    'payment_method' => 'kokopay',
                    'status' => 'cancelled',
                    'amount' => $order->total_amount,
                    'currency' => 'LKR',
                    'gateway_transaction_id' => $transactionId, // trnId
                    'gateway_reference' => $orderId, // orderId
                    'gateway_response' => $request->all(), // Complete raw response
                    'customer_name' => $order->customer_name,
                    'customer_email' => $order->customer_email,
                    'customer_phone' => $order->customer_phone,
                    'description' => $request->get('desc', '') ?: "Cancelled Koko Pay payment for order {$order->order_number}", // desc field
                    'failure_reason' => "Payment cancelled by user. Status: {$paymentStatus}",
                    'initiated_at' => $order->created_at,
                    'failed_at' => now(),
                    'metadata' => [
                        // KOKO PAY CORE PARAMETERS
                        'orderId' => $orderId,
                        'trnId' => $transactionId,
                        'status' => $request->get('status', ''),
                        'desc' => $request->get('desc', ''),
                        
                        // KOKO PAY ADDITIONAL PARAMETERS
                        'key' => $request->get('key', ''),
                        'frontend' => $request->get('frontend', false),
                        'wc_api' => $request->get('wc-api', ''),
                        
                        // INTERNAL TRACKING
                        'source' => 'cancel_url',
                        'payment_flow' => 'cancelled',
                        'cancellation_reason' => 'User cancelled payment',
                        'original_status' => $request->get('status'),
                        'koko_pay_order_id' => $orderId, // Legacy compatibility
                        'koko_pay_transaction_id' => $transactionId, // Legacy compatibility
                    ],
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    ]
                );
                
                Log::info('Koko Pay payment cancelled by user', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'koko_pay_order_id' => $orderId,
                    'transaction_created' => true
                ]);
            }
            session()->forget('kokopay_order_id');
        }

        return redirect()->route('checkout.index')
                       ->with('warning', 'Payment was cancelled. You can try again.');
    }

    /**
     * Handle Koko Pay Response URL (_responseUrl) - Secure Server-to-Server Webhook
     * 
     * This is the secure backend notification from Koko Pay after payment completion.
     * Content-Type: application/x-www-form-urlencoded
     * Parameters: orderId, trnId, status (SUCCESS/FAILED), desc, signature
     * 
     * This is the authoritative source for payment confirmation.
     * Signature verification ensures the request is authentic.
     */
    public function handleKokoPayNotify(Request $request)
    {
        \Log::info('=== KOKO PAY WEBHOOK RECEIVED ===');
        \Log::info('Request URL: ' . $request->fullUrl());
        \Log::info('Request Method: ' . $request->method());
        \Log::info('Content Type: ' . $request->header('Content-Type'));
        \Log::info('All Request Data: ', $request->all());
        \Log::info('Raw Input: ' . $request->getContent());

        try {
            // Extract parameters based on Koko Pay API documentation
            $orderId = $request->get('orderId');
            $transactionId = $request->get('trnId');
            $status = $request->get('status');
            $signature = $request->get('signature');
            $description = $request->get('desc', '');

            // Validate required parameters
            if (!$orderId || !$transactionId || !$status) {
                Log::error('Koko Pay webhook: Missing required parameters', [
                    'orderId' => $orderId,
                    'trnId' => $transactionId,
                    'status' => $status
                ]);
                return response('Missing required parameters', 400);
            }

            // Find the order
            $order = Order::find($orderId);
            if (!$order) {
                Log::error('Koko Pay webhook: Order not found', ['order_id' => $orderId]);
                return response('Order not found', 404);
            }

            // TODO: Implement signature verification with Koko Pay public key
            // According to docs: decrypt signature with public key and verify against orderId+trnId+status
            if ($signature) {
                Log::info('Koko Pay webhook: Signature provided for verification', [
                    'signature_length' => strlen($signature),
                    'expected_string' => $orderId . $transactionId . $status
                ]);
                // Signature verification would go here
            } else {
                Log::warning('Koko Pay webhook: No signature provided');
            }

            $paymentStatus = strtolower($status);
            
            Log::info('Processing Koko Pay webhook', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'koko_pay_order_id' => $orderId,
                'transaction_id' => $transactionId,
                'status' => $paymentStatus,
                'description' => $description
            ]);

            // Check if transaction already exists (avoid duplicates from multiple webhook calls)
            $existingTransaction = \App\Models\Transaction::where('order_id', $order->id)
                ->where('gateway_transaction_id', $transactionId)
                ->first();

            if ($paymentStatus === 'success') {
                // Update order status
                $order->update([
                    'payment_status' => 'paid',
                    'payment_method' => 'kokopay',
                    'payment_reference' => $transactionId,
                    'status' => 'confirmed'
                ]);

                if ($existingTransaction) {
                    // Update existing transaction to mark webhook confirmation
                    $existingTransaction->update([
                        'status' => 'completed',
                        'completed_at' => now(),
                        'metadata' => array_merge($existingTransaction->metadata ?? [], [
                            'webhook_confirmed' => true,
                            'webhook_timestamp' => now()->toISOString(),
                            'webhook_signature_provided' => !empty($signature),
                        ])
                    ]);
                    Log::info('Updated existing transaction via Koko Pay webhook', [
                        'transaction_id' => $existingTransaction->transaction_id
                    ]);
                } else {
                    // Create or find existing transaction record from webhook
                    \App\Models\Transaction::firstOrCreate(
                        ['transaction_id' => 'TXN-' . strtoupper(substr($transactionId, 0, 16))],
                        [
                        'order_id' => $order->id,
                        'payment_method' => 'kokopay',
                        'status' => 'completed',
                        'amount' => $order->total_amount,
                        'currency' => 'LKR',
                        'gateway_transaction_id' => $transactionId,
                        'gateway_reference' => $orderId,
                        'gateway_response' => $request->all(),
                        'customer_name' => $order->customer_name,
                        'customer_email' => $order->customer_email,
                        'customer_phone' => $order->customer_phone,
                        'description' => "Koko Pay webhook payment for order {$order->order_number}",
                        'initiated_at' => $order->created_at,
                        'completed_at' => now(),
                        'metadata' => [
                            // KOKO PAY CORE PARAMETERS
                            'orderId' => $orderId,
                            'trnId' => $transactionId,
                            'status' => $status,
                            'desc' => $description,
                            
                            // KOKO PAY WEBHOOK SPECIFIC
                            'signature' => $signature,
                            'signature_provided' => !empty($signature),
                            
                            // INTERNAL TRACKING
                            'source' => 'webhook',
                            'payment_flow' => 'successful',
                            'webhook_confirmed' => true,
                            'webhook_timestamp' => now()->toISOString(),
                            'koko_pay_order_id' => $orderId, // Legacy compatibility
                            'koko_pay_transaction_id' => $transactionId, // Legacy compatibility
                        ],
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->header('User-Agent'),
                        ]
                    );
                    Log::info('Created new transaction via Koko Pay webhook');
                }

                Log::info('Koko Pay webhook: Payment confirmed successfully', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'koko_pay_order_id' => $orderId
                ]);

                return response('Payment confirmed', 200);

            } else {
                // Handle failed payment
                $order->update([
                    'payment_status' => 'failed',
                    'payment_method' => 'kokopay',
                    'payment_reference' => $transactionId
                ]);

                if ($existingTransaction) {
                    $existingTransaction->update([
                        'status' => 'failed',
                        'failed_at' => now(),
                        'failure_reason' => "Webhook status: {$paymentStatus}. " . ($description ? "Description: {$description}" : ''),
                        'metadata' => array_merge($existingTransaction->metadata ?? [], [
                            'webhook_confirmed' => true,
                            'webhook_timestamp' => now()->toISOString(),
                        ])
                    ]);
                } else {
                    \App\Models\Transaction::firstOrCreate(
                        ['transaction_id' => 'TXN-' . strtoupper(substr($transactionId, 0, 16))],
                        [
                        'order_id' => $order->id,
                        'payment_method' => 'kokopay',
                        'status' => 'failed',
                        'amount' => $order->total_amount,
                        'currency' => 'LKR',
                        'gateway_transaction_id' => $transactionId,
                        'gateway_reference' => $orderId,
                        'gateway_response' => $request->all(),
                        'customer_name' => $order->customer_name,
                        'customer_email' => $order->customer_email,
                        'customer_phone' => $order->customer_phone,
                        'description' => "Failed Koko Pay webhook payment for order {$order->order_number}",
                        'failure_reason' => "Webhook status: {$paymentStatus}. " . ($description ? "Description: {$description}" : ''),
                        'initiated_at' => $order->created_at,
                        'failed_at' => now(),
                        'metadata' => [
                            // KOKO PAY CORE PARAMETERS
                            'orderId' => $orderId,
                            'trnId' => $transactionId,
                            'status' => $status,
                            'desc' => $description,
                            
                            // KOKO PAY WEBHOOK SPECIFIC
                            'signature' => $signature,
                            'signature_provided' => !empty($signature),
                            
                            // INTERNAL TRACKING
                            'source' => 'webhook',
                            'payment_flow' => 'failed',
                            'webhook_confirmed' => true,
                            'webhook_timestamp' => now()->toISOString(),
                            'original_status' => $status,
                            'koko_pay_order_id' => $orderId, // Legacy compatibility
                            'koko_pay_transaction_id' => $transactionId, // Legacy compatibility
                        ],
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->header('User-Agent'),
                        ]
                    );
                }

                Log::warning('Koko Pay webhook: Payment failed', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'koko_pay_order_id' => $orderId,
                    'status' => $paymentStatus
                ]);

                return response('Payment failed', 200);
            }

        } catch (\Exception $e) {
            Log::error('Koko Pay webhook processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response('Webhook processing failed', 500);
        }
    }

    /**
     * Check Koko Pay payment status
     */
    public function checkKokoPayPaymentStatus(Request $request, Order $order)
    {
        Log::info('Koko Pay payment status check requested', ['order_id' => $order->id]);

        return response()->json([
            'order_id' => $order->id,
            'payment_status' => $order->payment_status,
            'payment_method' => $order->payment_method,
            'payment_reference' => $order->payment_reference,
        ]);
    }

    /**
     * Test Koko Pay configuration
     */
    public function testKokoPay()
    {
        $kokoPayService = new KokoPayService();
        $config = $kokoPayService->getConfig();
        
        return response()->json([
            'message' => 'Koko Pay Configuration',
            'config' => $config,
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}
