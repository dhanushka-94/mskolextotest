<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SmaProduct;
use App\Services\WebXPayService;
use App\Services\KokoPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Initiate PayHere payment
     */
    public function initiatePayment(Request $request, Order $order)
    {
        // Validate that order belongs to authenticated user or is guest order
        if ($order->user_id && $order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to order');
        }

        // PayHere configuration
        $merchantId = config('payhere.merchant_id');
        $merchantSecret = config('payhere.merchant_secret');
        $currency = 'LKR';
        $amount = number_format($order->total_amount, 2, '.', '');

        // Generate hash for security
        $hash = strtoupper(
            md5(
                $merchantId . 
                $order->order_number . 
                $amount . 
                $currency . 
                strtoupper(md5($merchantSecret))
            )
        );

        $paymentData = [
            'merchant_id' => $merchantId,
            'return_url' => route('payment.return'),
            'cancel_url' => route('payment.cancel'),
            'notify_url' => route('payment.notify'),
            'order_id' => $order->order_number,
            'items' => 'Order #' . $order->order_number,
            'amount' => $amount,
            'currency' => $currency,
            'hash' => $hash,
            'first_name' => explode(' ', $order->customer_name)[0],
            'last_name' => explode(' ', $order->customer_name)[1] ?? '',
            'email' => $order->customer_email,
            'phone' => $order->customer_phone,
            'address' => $order->shipping_address_line_1,
            'city' => $order->shipping_city,
            'country' => 'Sri Lanka',
        ];

        return view('payment.payhere', compact('paymentData', 'order'));
    }

    /**
     * Handle PayHere return
     */
    public function handleReturn(Request $request)
    {
        $orderNumber = $request->order_id;
        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found');
        }

        // Check payment status
        if ($request->payment_id && $request->payment_status == 2) {
            // Payment successful
            $order->update([
                'payment_status' => 'paid',
                'payment_reference' => $request->payment_id,
            ]);

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Payment completed successfully!');
        } else {
            // Payment failed
            return redirect()->route('checkout.index')
                ->with('error', 'Payment was not completed. Please try again.');
        }
    }

    /**
     * Handle PayHere cancel
     */
    public function handleCancel(Request $request)
    {
        $orderNumber = $request->order_id;
        
        return redirect()->route('checkout.index')
            ->with('error', 'Payment was cancelled. You can try again or choose a different payment method.');
    }

    /**
     * Handle PayHere notify (webhook)
     */
    public function handleNotify(Request $request)
    {
        // Verify the payment notification
        $merchantId = config('payhere.merchant_id');
        $merchantSecret = config('payhere.merchant_secret');
        
        $orderId = $request->order_id;
        $paymentId = $request->payment_id;
        $amount = $request->payhere_amount;
        $currency = $request->payhere_currency;
        $statusCode = $request->status_code;
        
        // Generate hash to verify authenticity
        $localHash = strtoupper(
            md5(
                $merchantId . 
                $orderId . 
                $amount . 
                $currency . 
                $statusCode . 
                strtoupper(md5($merchantSecret))
            )
        );

        if ($localHash === $request->md5sig) {
            // Valid notification
            $order = Order::where('order_number', $orderId)->first();
            
            if ($order) {
                if ($statusCode == 2) {
                    // Payment success
                    $order->update([
                        'payment_status' => 'paid',
                        'payment_reference' => $paymentId,
                    ]);
                    
                    Log::info('PayHere payment successful', [
                        'order_id' => $orderId,
                        'payment_id' => $paymentId,
                        'amount' => $amount
                    ]);
                } else {
                    // Payment failed
                    $order->update([
                        'payment_status' => 'failed',
                        'payment_reference' => $paymentId,
                    ]);
                    
                    Log::warning('PayHere payment failed', [
                        'order_id' => $orderId,
                        'payment_id' => $paymentId,
                        'status_code' => $statusCode
                    ]);
                }
            }
        } else {
            Log::error('PayHere notification hash mismatch', [
                'order_id' => $orderId,
                'received_hash' => $request->md5sig,
                'expected_hash' => $localHash
            ]);
        }

        return response('OK', 200);
    }

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
            
            foreach ($order->orderItems as $item) {
                $product = SmaProduct::find($item->product_id);
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
                'amount' => $order->total_amount,
                'transaction_fee' => $transactionFee,
                'total_with_fee' => $totalWithFee,
                'discount_calculated' => $totalDiscount
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
     * Handle WebXPay return
     */
    public function handleWebXPayReturn(Request $request)
    {
        try {
            // Validate required parameters
            if (!$request->has(['payment', 'signature'])) {
                throw new \Exception('Missing required payment response data');
            }

            $webxpayService = new WebXPayService();
            $responseData = $request->all();
            
            // Process the response
            $processedResponse = $webxpayService->processResponse($responseData);
            
            // Find the order
            $order = Order::where('order_number', $processedResponse['order_id'])->first();
            
            if (!$order) {
                throw new \Exception('Order not found: ' . $processedResponse['order_id']);
            }

            // Update order status
            $updateSuccess = $webxpayService->updateOrderStatus($order, $responseData);
            
            if (!$updateSuccess) {
                throw new \Exception('Failed to update order status');
            }

            // Redirect based on payment status
            switch ($processedResponse['payment_status']) {
                case 'success':
                    return redirect()->route('checkout.success', $order->order_number)
                        ->with('success', 'Payment completed successfully via WebXPay!');
                        
                case 'pending':
                    return redirect()->route('checkout.success', $order->order_number)
                        ->with('info', 'Payment is being processed. You will receive confirmation once completed.');
                        
                default:
                    return redirect()->route('checkout.index')
                        ->with('error', 'Payment was not completed. ' . $processedResponse['comment']);
            }

        } catch (\Exception $e) {
            Log::error('WebXPay return handling failed', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return redirect()->route('checkout.index')
                ->with('error', 'Payment processing failed. Please try again or contact support.');
        }
    }

    /**
     * Handle WebXPay cancel
     */
    public function handleWebXPayCancel(Request $request)
    {
        Log::info('WebXPay payment cancelled', $request->all());
        
        return redirect()->route('checkout.index')
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
     * Handle Koko Pay return
     */
    public function handleKokoPayReturn(Request $request)
    {
        Log::info('Koko Pay return received', $request->all());

        $orderId = session('kokopay_order_id');
        
        if (!$orderId) {
            Log::warning('No Koko Pay order ID in session');
            return redirect()->route('checkout.index')->with('error', 'Session expired. Please try again.');
        }

        $order = Order::find($orderId);
        
        if (!$order) {
            Log::error('Koko Pay return: Order not found', ['order_id' => $orderId]);
            return redirect()->route('checkout.index')->with('error', 'Order not found.');
        }

        // Check payment status from the return parameters
        $paymentStatus = $request->get('status', 'failed');
        
        if ($paymentStatus === 'success' || $paymentStatus === 'completed') {
            // Update order status
            $order->update([
                'payment_status' => 'completed',
                'payment_method' => 'kokopay',
                'payment_reference' => $request->get('reference', ''),
            ]);

            // Clear session
            session()->forget('kokopay_order_id');

            Log::info('Koko Pay payment completed successfully', [
                'order_id' => $order->id,
                'payment_reference' => $request->get('reference', '')
            ]);

            return redirect()->route('checkout.success', $order->id)
                           ->with('success', 'Payment completed successfully with Koko Pay!');
        } else {
            Log::warning('Koko Pay payment failed or cancelled', [
                'order_id' => $order->id,
                'status' => $paymentStatus,
                'request_data' => $request->all()
            ]);

            return redirect()->route('checkout.index')
                           ->with('error', 'Payment was not completed. Please try again.');
        }
    }

    /**
     * Handle Koko Pay cancel
     */
    public function handleKokoPayCancel(Request $request)
    {
        Log::info('Koko Pay payment cancelled', $request->all());

        $orderId = session('kokopay_order_id');
        
        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
                Log::info('Koko Pay payment cancelled by user', ['order_id' => $order->id]);
            }
            session()->forget('kokopay_order_id');
        }

        return redirect()->route('checkout.index')
                       ->with('warning', 'Payment was cancelled. You can try again.');
    }

    /**
     * Handle Koko Pay webhook/notification
     */
    public function handleKokoPayNotify(Request $request)
    {
        Log::info('Koko Pay webhook received', $request->all());

        try {
            // TODO: Implement webhook signature verification
            // $kokoPayService = new KokoPayService();
            // if (!$kokoPayService->verifyWebhookSignature($request->all(), $request->header('signature'))) {
            //     Log::warning('Koko Pay webhook signature verification failed');
            //     return response('Unauthorized', 401);
            // }

            $orderId = $request->get('orderId') ?: $request->get('_orderId');
            $status = $request->get('status', 'failed');
            $reference = $request->get('reference') ?: $request->get('_reference');

            if (!$orderId) {
                Log::error('Koko Pay webhook: No order ID provided');
                return response('Bad Request', 400);
            }

            $order = Order::find($orderId);
            
            if (!$order) {
                Log::error('Koko Pay webhook: Order not found', ['order_id' => $orderId]);
                return response('Order Not Found', 404);
            }

            if ($status === 'success' || $status === 'completed') {
                $order->update([
                    'payment_status' => 'completed',
                    'payment_method' => 'kokopay',
                    'payment_reference' => $reference,
                ]);

                Log::info('Koko Pay webhook: Payment completed', [
                    'order_id' => $order->id,
                    'reference' => $reference
                ]);
            } else {
                Log::warning('Koko Pay webhook: Payment failed', [
                    'order_id' => $order->id,
                    'status' => $status
                ]);
            }

            return response('OK', 200);

        } catch (\Exception $e) {
            Log::error('Koko Pay webhook processing error', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response('Internal Server Error', 500);
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
