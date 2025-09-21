<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\SmaProduct;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
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
                'quantity' => 'required|integer|min:1'
            ]);

            $product = SmaProduct::find($request->product_id);
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
        
        // Check if item already in cart
        $existingItem = Cart::where('session_id', $sessionId)
                           ->where('product_id', $request->product_id)
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
                'quantity' => $request->quantity,
                'price' => $product->final_price
            ]);
        }

        $cartCount = $this->getCartCount();

        // Calculate cart total for response
        $cartItems = Cart::where('session_id', session()->getId())->get();
        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $product = SmaProduct::find($item->product_id);
            if ($product) {
                $cartTotal += $item->quantity * $product->final_price;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => $cartCount,
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
        $cartTotal = $this->getCartTotal();
        $cartCount = $this->getCartCount();

        return response()->json([
            'success' => true,
            'item_total' => number_format($itemTotal, 2),
            'cart_total' => number_format($cartTotal, 2),
            'cart_count' => $cartCount
        ]);
    }

    public function remove(Cart $cart)
    {
        $cart->delete();

        $cartTotal = $this->getCartTotal();
        $cartCount = $this->getCartCount();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_total' => number_format($cartTotal, 2),
            'cart_count' => $cartCount
        ]);
    }

    public function clear()
    {
        $sessionId = Session::getId();
        Cart::where('session_id', $sessionId)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }
    
    public function count()
    {
        $cartCount = $this->getCartCount();
        
        // Calculate cart total
        $cartItems = Cart::where('session_id', session()->getId())->get();
        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $product = SmaProduct::find($item->product_id);
            if ($product) {
                $cartTotal += $item->quantity * $product->final_price;
            }
        }
        
        return response()->json([
            'count' => $cartCount,
            'total' => number_format($cartTotal, 2)
        ]);
    }

    public function getCartCount()
    {
        $sessionId = Session::getId();
        return Cart::where('session_id', $sessionId)->sum('quantity');
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
}