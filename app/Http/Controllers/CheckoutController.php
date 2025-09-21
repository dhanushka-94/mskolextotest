<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SmaProduct;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function index()
    {
        $cartItems = Cart::where('session_id', session()->getId())
            ->orWhere(function($query) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                }
            })
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate totals
        $subtotal = 0;
        $originalSubtotal = 0;
        $totalDiscount = 0;
        $cartProducts = [];

        foreach ($cartItems as $item) {
            $product = SmaProduct::find($item->product_id);
            if ($product) {
                $lineTotal = $item->quantity * $product->final_price;
                $originalLineTotal = $item->quantity * $product->price;
                $lineDiscount = $originalLineTotal - $lineTotal;
                
                $subtotal += $lineTotal;
                $originalSubtotal += $originalLineTotal;
                $totalDiscount += $lineDiscount;
                
                $cartProducts[] = [
                    'cart_item' => $item,
                    'product' => $product,
                    'line_total' => $lineTotal,
                    'original_line_total' => $originalLineTotal,
                    'line_discount' => $lineDiscount
                ];
            }
        }

        $shippingCost = $this->calculateShippingCost($subtotal);
        $taxAmount = $this->calculateTax($subtotal);
        $total = $subtotal + $shippingCost + $taxAmount;

        // Get user addresses if logged in
        $addresses = [];
        if (Auth::check()) {
            $addresses = Auth::user()->addresses()->get();
        }

        return view('checkout.index', compact(
            'cartProducts', 
            'subtotal', 
            'originalSubtotal',
            'totalDiscount',
            'shippingCost', 
            'taxAmount', 
            'total',
            'addresses'
        ));
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        \Log::info('Checkout process started', [
            'payment_method' => $request->payment_method,
            'customer_name' => $request->customer_name,
            'request_data' => $request->only(['payment_method', 'customer_name', 'customer_phone', 'customer_email'])
        ]);

        $validator = Validator::make($request->all(), [
            // Required customer information
            'customer_name' => 'required|string|max:255',
            'customer_phone' => ['required', 'string', 'regex:/^0[1-9][0-9]{8}$/', 'max:20'],
            
            // Optional customer information
            'customer_email' => 'nullable|email|max:255',
            
            // Required billing address fields (only Address Line 1 and City)
            'billing_address_line_1' => 'required|string|max:255',
            'billing_city' => 'required|string|max:100',
            
            // Optional billing address fields
            'billing_address_line_2' => 'nullable|string|max:255',
            'billing_state' => 'nullable|string|max:100',
            'billing_postal_code' => 'nullable|string|max:20',
            'billing_country' => 'nullable|string|max:100',
            
            // Conditional shipping address fields (required only if different from billing)
            'shipping_address_line_1' => 'nullable|string|max:255',
            'shipping_city' => 'nullable|string|max:100',
            
            // Optional shipping address fields
            'shipping_address_line_2' => 'nullable|string|max:255',
            'shipping_state' => 'nullable|string|max:100',
            'shipping_postal_code' => 'nullable|string|max:20',
            'shipping_country' => 'nullable|string|max:100',
            
            // Available payment methods
            'payment_method' => 'required|in:webxpay,kokopay,bank_transfer',
            'terms' => 'required|accepted',
        ], [
            'customer_phone.regex' => 'Please enter a valid Sri Lankan phone number (10 digits starting with 0, e.g., 0771234567)',
        ]);

        if ($validator->fails()) {
            \Log::warning('Checkout validation failed', [
                'errors' => $validator->errors()->toArray(),
                'payment_method' => $request->payment_method
            ]);
            return back()->withErrors($validator)->withInput();
        }

        \Log::info('Checkout validation passed, proceeding with order creation');

        // Get cart items
        $cartItems = Cart::where('session_id', session()->getId())
            ->orWhere(function($query) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                }
            })
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            // Calculate totals
            $subtotal = 0;
            $orderItems = [];

            foreach ($cartItems as $item) {
                $product = SmaProduct::find($item->product_id);
                if ($product) {
                    $lineTotal = $item->quantity * $product->final_price;
                    $subtotal += $lineTotal;
                    
                    $orderItems[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_code' => $product->code,
                        'product_image' => $product->main_image,
                        'quantity' => $item->quantity,
                        'unit_price' => $product->final_price,
                        'total_price' => $lineTotal,
                        'product_attributes' => [
                            'category' => $product->category->name ?? null,
                            'brand' => $product->brand ?? null,
                            'specifications' => $product->specifications ?? null,
                        ]
                    ];
                }
            }

            $shippingCost = $this->calculateShippingCost($subtotal);
            $taxAmount = $this->calculateTax($subtotal);
            $totalAmount = $subtotal + $shippingCost + $taxAmount;

            // Handle shipping address - use billing address if shipping is empty (Same as billing checkbox)
            $shippingAddressLine1 = $request->shipping_address_line_1 ?: $request->billing_address_line_1;
            $shippingAddressLine2 = $request->shipping_address_line_2 ?: $request->billing_address_line_2;
            $shippingCity = $request->shipping_city ?: $request->billing_city;
            $shippingState = $request->shipping_state ?: $request->billing_state;
            $shippingPostalCode = $request->shipping_postal_code ?: $request->billing_postal_code;
            $shippingCountry = $request->shipping_country ?: $request->billing_country ?: 'Sri Lanka';

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email ?: null,
                'customer_phone' => $request->customer_phone,
                'billing_address_line_1' => $request->billing_address_line_1,
                'billing_address_line_2' => $request->billing_address_line_2 ?: null,
                'billing_city' => $request->billing_city,
                'billing_state' => $request->billing_state ?: null,
                'billing_postal_code' => $request->billing_postal_code ?: null,
                'billing_country' => $request->billing_country ?: 'Sri Lanka',
                'shipping_address_line_1' => $shippingAddressLine1,
                'shipping_address_line_2' => $shippingAddressLine2 ?: null,
                'shipping_city' => $shippingCity,
                'shipping_state' => $shippingState ?: null,
                'shipping_postal_code' => $shippingPostalCode ?: null,
                'shipping_country' => $shippingCountry,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'shipping_cost' => $shippingCost,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            // Create order items
            foreach ($orderItems as $itemData) {
                OrderItem::create(array_merge($itemData, ['order_id' => $order->id]));
            }

            // Clear cart
            Cart::where('session_id', session()->getId())
                ->orWhere(function($query) {
                    if (Auth::check()) {
                        $query->where('user_id', Auth::id());
                    }
                })
                ->delete();

            DB::commit();

            // Handle payment method redirection
            switch ($request->payment_method) {
                case 'webxpay':
                    // Redirect to WebXPay payment form
                    return redirect()->route('payment.webxpay', ['order' => $order->id])
                        ->with('info', 'Please complete your payment through WebXPay.');

                case 'kokopay':
                    // Log the order details for debugging
                    \Log::info('Redirecting to Koko Pay payment', [
                        'order_id' => $order->id, 
                        'order_number' => $order->order_number,
                        'payment_method' => $order->payment_method,
                        'redirect_url' => route('payment.kokopay', ['order' => $order->id])
                    ]);
                    
                    // Redirect to Koko Pay payment form
                    $redirectUrl = route('payment.kokopay', ['order' => $order->id]);
                    \Log::info('Generated Koko Pay redirect URL', ['url' => $redirectUrl]);
                    
                    return redirect()->route('payment.kokopay', ['order' => $order->id])
                        ->with('info', 'Please complete your Buy Now, Pay Later payment through Koko Pay.');
                        
                case 'bank_transfer':
                default:
                    // Direct to success page for bank transfer
                    return redirect()->route('checkout.success', $order->order_number)
                        ->with('success', 'Order placed successfully! Please check your email for bank transfer details.');
            }

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Checkout Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'payment_method' => $request->payment_method,
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            return back()->with('error', 'Something went wrong. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show order success page
     */
    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        
        // Check if user can view this order
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        } elseif (!Auth::check() && session('last_order_id') !== $order->id) {
            // Store order ID in session for guest users
            session(['last_order_id' => $order->id]);
        }

        return view('checkout.success', compact('order'));
    }

    /**
     * Calculate shipping cost
     */
    private function calculateShippingCost($subtotal)
    {
        // Free shipping for orders over LKR 50,000
        if ($subtotal >= 50000) {
            return 0;
        }
        
        // Standard shipping cost
        return 500;
    }

    /**
     * Calculate tax amount
     */
    private function calculateTax($subtotal)
    {
        // No tax for now - can be implemented later
        return 0;
    }

    /**
     * Save address for logged in users
     */
    public function saveAddress(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in to save addresses.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required|in:shipping,billing',
            'name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $address = UserAddress::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'name' => $request->name,
            'contact_name' => $request->contact_name,
            'contact_phone' => $request->contact_phone,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country ?? 'Sri Lanka',
            'is_default' => $request->boolean('is_default'),
        ]);

        return response()->json([
            'success' => true,
            'address' => $address,
            'message' => 'Address saved successfully.'
        ]);
    }
}