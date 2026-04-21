<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\SmaProduct;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // Log cart page access for WebXPay debugging
        \Log::info('Cart page accessed', [
            'referer' => request()->header('referer'),
            'user_agent' => request()->header('user-agent'),
            'query_params' => request()->all(),
            'session_id' => session()->getId(),
            'user_id' => Auth::id(),
            'timestamp' => now()->toDateTimeString()
        ]);

        // EMERGENCY FIX: Check if this is a WebXPay redirect by looking for WebXPay parameters or referer
        $queryParams = request()->all();
        $referer = request()->header('referer', '');
        $currentUrl = request()->url();
        
        // CRITICAL: Prevent redirect loop - don't redirect if coming from our own WebXPay handlers
        $isFromOurWebXPayHandler = str_contains($referer, '/pay/webxpayResponse') || 
                                  str_contains($referer, '/payment/webxpay/return') ||
                                  str_contains($currentUrl, '/pay/webxpayResponse') ||
                                  str_contains($currentUrl, '/payment/webxpay/return');
        
        $isWebXPayRedirect = !$isFromOurWebXPayHandler && (
                           isset($queryParams['payment']) || 
                           isset($queryParams['signature']) || 
                           str_contains($referer, 'webxpay.com') ||
                           str_contains($referer, 'stagingxpay.info') ||
                           (str_contains($referer, 'xpay') && !str_contains($referer, 'mskcomputers.lk'))
                           );
        
        if ($isWebXPayRedirect) {
            \Log::error('🚨 WEBXPAY REDIRECT TO CART DETECTED!', [
                'referer' => $referer,
                'current_url' => $currentUrl,
                'query_params' => $queryParams,
                'detection_reason' => [
                    'has_payment_param' => isset($queryParams['payment']),
                    'has_signature_param' => isset($queryParams['signature']),
                    'webxpay_in_referer' => str_contains($referer, 'webxpay.com'),
                    'stagingxpay_in_referer' => str_contains($referer, 'stagingxpay.info'),
                    'external_xpay_in_referer' => (str_contains($referer, 'xpay') && !str_contains($referer, 'mskcomputers.lk'))
                ],
                'loop_prevention' => [
                    'is_from_our_handler' => $isFromOurWebXPayHandler,
                    'referer_contains_webxpayResponse' => str_contains($referer, '/pay/webxpayResponse'),
                    'referer_contains_webxpay_return' => str_contains($referer, '/payment/webxpay/return')
                ],
                'emergency_fix_activated' => true
            ]);
            
            // Try to redirect to WebXPay return handler manually
            if (isset($queryParams['payment']) && isset($queryParams['signature'])) {
                \Log::info('✅ WebXPay parameters found in cart URL - redirecting to return handler', [
                    'payment_param_length' => strlen($queryParams['payment']),
                    'signature_param_length' => strlen($queryParams['signature']),
                    'redirect_to' => 'payment.webxpay.legacy.return'
                ]);
                
                // Store parameters in session and redirect
                session(['webxpay_data' => $queryParams]);
                return redirect()->route('payment.webxpay.legacy.return');
            }
            
            // If no parameters but WebXPay referer, try to extract order info and redirect to success
            if (preg_match('/order[_-]?(?:number|id)?[=:]?([A-Z0-9-]+)/i', $referer, $matches)) {
                $orderNumber = $matches[1];
                \Log::info('🔄 WebXPay referer detected without parameters - redirecting to success page', [
                    'extracted_order_number' => $orderNumber,
                    'referer' => $referer
                ]);
                
                return redirect()->route('checkout.success', $orderNumber)
                    ->with('info', 'Payment completed! Your order has been processed.');
            }
            
            // Last resort: redirect to checkout with message
            \Log::warning('⚠️ WebXPay redirect detected but no usable parameters - redirecting to checkout', [
                'referer' => $referer,
                'available_params' => array_keys($queryParams)
            ]);
            
            return redirect()->route('checkout.index')
                ->with('error', 'Payment processing completed. Please check your email for order confirmation or contact support if you need assistance.');
        }

        // Log if we prevented a potential loop
        if ($isFromOurWebXPayHandler) {
            \Log::info('🛡️ REDIRECT LOOP PREVENTED - Request from our own WebXPay handler', [
                'referer' => $referer,
                'current_url' => $currentUrl,
                'loop_prevention_active' => true
            ]);
        }

        $cartItems = $this->getCartItems();
        $cartTotal = $cartItems->sum(function($item) {
            return $item->product->final_price * $item->quantity;
        });
        
        return view('cart.index', compact('cartItems', 'cartTotal'));
    }

    public function add(Request $request)
    {
        try {
            \Log::info('Cart add request:', $request->all());
            
            $request->validate([
                'product_id' => 'required|integer|min:1',
                'quantity' => 'required|integer|min:1',
                'catalog' => 'nullable|string|in:msk,laptopexpert',
            ]);

            $productClass = Cart::productClassFromCatalog($request->input('catalog'));
            $product = $productClass::find($request->product_id);
            \Log::info('Product found:', ['product' => $product ? $product->id : 'null']);
            
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }
        } catch (\Exception $e) {
            \Log::error('Cart add error:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
        
        // Check stock
        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available'
            ]);
        }

        $sessionId = Session::getId();
        
        // Check if item already in cart (same id can exist on MSK and LaptopExpert DBs)
        $existingItem = Cart::where('session_id', $sessionId)
                           ->where('product_id', $request->product_id)
                           ->where('product_type', $productClass)
                           ->first();

        if ($existingItem) {
            // Update quantity
            $newQuantity = $existingItem->quantity + $request->quantity;
            
            if ($product->stock_quantity < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot add more items. Stock limit reached.'
                ]);
            }
            
            $existingItem->update([
                'quantity' => $newQuantity,
                'price' => $product->final_price
            ]);
        } else {
            // Add new item
            Cart::create([
                'session_id' => $sessionId,
                'product_id' => $request->product_id,
                'product_type' => $productClass,
                'quantity' => $request->quantity,
                'price' => $product->final_price
            ]);
        }

        // Calculate cart total for response
        $cartItems = Cart::where('session_id', session()->getId())->with('product')->get();
        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $lineProduct = $item->product;
            if ($lineProduct) {
                $cartTotal += $item->quantity * $lineProduct->final_price;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_total' => number_format($cartTotal, 2)
        ]);
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $product = $cart->product;
        
        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available'
            ]);
        }

        $cart->update([
            'quantity' => $request->quantity,
            'price' => $product->final_price
        ]);

        $itemTotal = $cart->total_price;
        
        // Calculate comprehensive cart totals
        $cartTotals = $this->getComprehensiveCartTotals();

        return response()->json([
            'success' => true,
            'item_total' => number_format($itemTotal, 2),
            'cart_total' => number_format($cartTotals['cart_total'], 2),
            'original_subtotal' => number_format($cartTotals['original_subtotal'], 2),
            'total_discount' => number_format($cartTotals['total_discount'], 2),
            'has_discount' => $cartTotals['total_discount'] > 0
        ]);
    }

    public function remove(Cart $cart)
    {
        $cart->delete();

        // Calculate comprehensive cart totals
        $cartTotals = $this->getComprehensiveCartTotals();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_total' => number_format($cartTotals['cart_total'], 2),
            'original_subtotal' => number_format($cartTotals['original_subtotal'], 2),
            'total_discount' => number_format($cartTotals['total_discount'], 2),
            'has_discount' => $cartTotals['total_discount'] > 0
        ]);
    }

    public function clear()
    {
        $sessionId = Session::getId();
        Cart::where('session_id', $sessionId)
             ->orWhere(function($query) {
                 if (Auth::check()) {
                     $query->where('user_id', Auth::id());
                 }
             })
             ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully',
            'cart_total' => '0.00',
            'cart_count' => 0
        ]);
    }
    


    private function getCartItems()
    {
        $sessionId = Session::getId();
        return Cart::where('session_id', $sessionId)
                  ->with('product')
                  ->get();
    }

    private function getCartTotal()
    {
        $cartItems = $this->getCartItems();
        return $cartItems->sum(function($item) {
            return $item->product->final_price * $item->quantity;
        });
    }

    private function getComprehensiveCartTotals()
    {
        $cartItems = $this->getCartItems();
        
        $cartTotal = 0;
        $originalSubtotal = 0;
        $totalDiscount = 0;
        
        foreach ($cartItems as $item) {
            $product = $item->product;
            $quantity = $item->quantity;
            
            // Calculate totals
            $cartTotal += $product->final_price * $quantity;
            $originalSubtotal += $product->price * $quantity;
            $totalDiscount += ($product->price - $product->final_price) * $quantity;
        }
        
        return [
            'cart_total' => $cartTotal,
            'original_subtotal' => $originalSubtotal,
            'total_discount' => $totalDiscount
        ];
    }

    /**
     * Get cart summary for AJAX requests
     */
    public function summary()
    {
        try {
            $sessionId = session()->getId();
            $userId = Auth::id();

            // Get cart items
            $cartItems = Cart::where(function($query) use ($sessionId, $userId) {
                $query->where('session_id', $sessionId);
                if ($userId) {
                    $query->orWhere('user_id', $userId);
                }
            })->with('product')->get();

            $items = [];
            $total = 0;
            $originalTotal = 0;
            $count = 0;

            foreach ($cartItems as $item) {
                if ($item->product) {
                    $lineTotal = $item->quantity * $item->product->final_price;
                    $originalLineTotal = $item->quantity * $item->product->price;
                    
                    $total += $lineTotal;
                    $originalTotal += $originalLineTotal;
                    $count += $item->quantity;
                    
                    $items[] = [
                        'id' => $item->id,
                        'name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->product->final_price,
                        'original_unit_price' => $item->product->price,
                        'total' => $lineTotal,
                        'original_total' => $originalLineTotal
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'items' => $items,
                'total' => $total,
                'original_total' => $originalTotal,
                'total_discount' => $originalTotal - $total,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            \Log::error('Cart summary error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to load cart summary',
                'items' => [],
                'total' => 0,
                'count' => 0
            ]);
        }
    }

    /**
     * Get cart count for AJAX requests
     */
    public function count()
    {
        $cartItems = $this->getCartItems();
        $count = $cartItems->sum('quantity');

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}