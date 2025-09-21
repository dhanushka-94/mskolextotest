<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Track order by order number (for guests)
     */
    public function track(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'order_number' => 'required|string',
                'email' => 'required|email',
            ]);

            $order = Order::where('order_number', $request->order_number)
                ->where('customer_email', $request->email)
                ->with('orderItems')
                ->first();

            if (!$order) {
                return back()->with('error', 'Order not found. Please check your order number and email address.');
            }

            return view('orders.tracking', compact('order'));
        }

        return view('orders.track');
    }

    /**
     * Show order details for guests
     */
    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('orderItems')
            ->firstOrFail();

        // For guests, check if they have access via session
        if (!Auth::check()) {
            if (session('last_order_id') !== $order->id) {
                abort(403, 'Access denied.');
            }
        } else {
            // For logged in users, check ownership
            if ($order->user_id !== Auth::id()) {
                abort(403, 'Access denied.');
            }
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Download invoice
     */
    public function invoice($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('orderItems')
            ->firstOrFail();

        // Check access permissions
        if (!Auth::check()) {
            if (session('last_order_id') !== $order->id) {
                abort(403, 'Access denied.');
            }
        } else {
            if ($order->user_id !== Auth::id() && !Auth::user()->is_admin) {
                abort(403, 'Access denied.');
            }
        }

        return view('orders.invoice', compact('order'));
    }

    /**
     * Reorder - add order items to cart
     */
    public function reorder(Order $order)
    {
        if (!Auth::check() || $order->user_id !== Auth::id()) {
            abort(403, 'Access denied.');
        }

        $addedItems = 0;

        foreach ($order->orderItems as $item) {
            // Check if product still exists and is available
            $product = \App\Models\SmaProduct::find($item->product_id);
            
            if ($product && $product->stock_quantity > 0) {
                // Add to cart
                $existingCartItem = \App\Models\Cart::where('user_id', Auth::id())
                    ->where('product_id', $product->id)
                    ->first();

                if ($existingCartItem) {
                    $newQuantity = $existingCartItem->quantity + $item->quantity;
                    if ($newQuantity <= $product->stock_quantity) {
                        $existingCartItem->update([
                            'quantity' => $newQuantity,
                            'price' => $product->final_price
                        ]);
                        $addedItems++;
                    }
                } else {
                    if ($item->quantity <= $product->stock_quantity) {
                        \App\Models\Cart::create([
                            'user_id' => Auth::id(),
                            'session_id' => session()->getId(),
                            'product_id' => $product->id,
                            'quantity' => $item->quantity,
                            'price' => $product->final_price,
                        ]);
                        $addedItems++;
                    }
                }
            }
        }

        if ($addedItems > 0) {
            return redirect()->route('cart.index')
                ->with('success', "{$addedItems} items from your previous order have been added to your cart.");
        } else {
            return back()->with('error', 'No items could be added to cart. Products may be out of stock or unavailable.');
        }
    }
}