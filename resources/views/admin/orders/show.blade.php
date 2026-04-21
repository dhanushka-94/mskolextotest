@extends('admin.layout')

@section('title', 'Order Details - ' . $order->order_number)

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="space-y-6">
    
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.orders.index') }}" 
               class="text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white">{{ $order->order_number }}</h1>
                <p class="text-gray-400">Order placed on {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="flex space-x-3">
            <a href="{{ route('orders.invoice', $order->order_number) }}" 
               target="_blank"
               class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors">
                Download Invoice
            </a>
        </div>
    </div>

    <!-- Order Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Order Status</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $order->status_badge }} mt-2">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
        </div>

        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Payment Status</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $order->payment_status_badge }} mt-2">
                        {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                    </span>
                </div>
                <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </div>
        </div>

        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Order Total</p>
                    <p class="text-2xl font-bold text-[#f59e0b] mt-1">LKR {{ number_format($order->total_amount, 2) }}</p>
                </div>
                <svg class="w-8 h-8 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </div>
        </div>

        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Items</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $order->orderItems->count() }}</p>
                </div>
                <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Order Management Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Update Order Status -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <h3 class="text-lg font-medium text-white mb-4">Update Order Status</h3>
            
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Order Status</label>
                        <select id="status" name="status" required
                                class="w-full px-4 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="refunded" {{ $order->status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>

                    <div id="shipping-fields" style="{{ $order->status === 'shipped' ? '' : 'display: none;' }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="tracking_number" class="block text-sm font-medium text-gray-300 mb-2">Tracking Number</label>
                                <input type="text" 
                                       id="tracking_number" 
                                       name="tracking_number" 
                                       value="{{ old('tracking_number', $order->tracking_number) }}"
                                       class="w-full px-4 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                            </div>
                            <div>
                                <label for="courier_service" class="block text-sm font-medium text-gray-300 mb-2">Courier Service</label>
                                <input type="text" 
                                       id="courier_service" 
                                       name="courier_service" 
                                       value="{{ old('courier_service', $order->courier_service) }}"
                                       placeholder="e.g., DHL, Pronto, Kapruka"
                                       class="w-full px-4 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="admin_notes" class="block text-sm font-medium text-gray-300 mb-2">Admin Notes</label>
                        <textarea id="admin_notes" 
                                  name="admin_notes" 
                                  rows="3"
                                  placeholder="Internal notes about this status update..."
                                  class="w-full px-4 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">{{ old('admin_notes', $order->admin_notes) }}</textarea>
                    </div>

                    <button type="submit" 
                            class="w-full py-2 px-4 bg-[#f59e0b] text-black rounded-lg hover:bg-[#d97706] transition-colors font-medium">
                        Update Status
                    </button>
                </div>
            </form>
        </div>

        <!-- Update Payment Status -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <h3 class="text-lg font-medium text-white mb-4">Update Payment Status</h3>
            
            <form action="{{ route('admin.orders.update-payment', $order) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-300 mb-2">Payment Status</label>
                        <select id="payment_status" name="payment_status" required
                                class="w-full px-4 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                            <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>

                    <div>
                        <label for="payment_reference" class="block text-sm font-medium text-gray-300 mb-2">Payment Reference</label>
                        <input type="text" 
                               id="payment_reference" 
                               name="payment_reference" 
                               value="{{ old('payment_reference', $order->payment_reference) }}"
                               placeholder="Transaction ID, receipt number, etc."
                               class="w-full px-4 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                    </div>

                    <button type="submit" 
                            class="w-full py-2 px-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                        Update Payment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Order Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Order Items -->
        <div class="lg:col-span-2 bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800">
                <h3 class="text-lg font-medium text-white">Order Items</h3>
            </div>
            
            <div class="divide-y divide-gray-800">
                @foreach($order->orderItems as $item)
                    @php
                        // Get product details to check for discounts
                        $product = $item->product;
                        $hasDiscount = false;
                        $originalPrice = $item->unit_price;
                        $discountAmount = 0;
                        $discountPercentage = 0;
                        
                        if ($product) {
                            $hasDiscount = $product->price > $product->final_price;
                            $originalPrice = $product->price;
                            if ($hasDiscount) {
                                $discountAmount = $originalPrice - $item->unit_price;
                                $discountPercentage = round(($discountAmount / $originalPrice) * 100);
                            }
                        }
                    @endphp
                    
                    <div class="px-6 py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 w-16 h-16 bg-gray-800 rounded-lg overflow-hidden">
                                <img src="{{ $item->product_image_url }}" 
                                     alt="{{ $item->product_name }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                <h4 class="text-white font-medium">{{ $item->product_name }}</h4>
                                    @if($hasDiscount)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-900/50 text-red-300 border border-red-700/50">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                            {{ $discountPercentage }}% OFF
                                        </span>
                                    @endif
                                </div>
                                
                                @if($item->product_code)
                                    <p class="text-sm text-gray-400">Code: {{ $item->product_code }}</p>
                                @endif
                                
                                <!-- Pricing Information -->
                                <div class="mt-2">
                                    @if($hasDiscount)
                                        <!-- Product had discount -->
                                        <div class="space-y-1">
                                            <div class="flex items-center space-x-2 text-sm">
                                                <span class="text-gray-400">Original Price:</span>
                                                <span class="text-gray-500 line-through">LKR {{ number_format($originalPrice, 2) }}</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm">
                                                <span class="text-gray-400">Sale Price:</span>
                                                <span class="text-green-400 font-medium">LKR {{ number_format($item->unit_price, 2) }}</span>
                                                <span class="text-green-400 text-xs">(Save LKR {{ number_format($discountAmount, 2) }})</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm">
                                                <span class="text-gray-400">Quantity:</span>
                                                <span class="text-white">{{ $item->quantity }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Product had no discount -->
                                        <div class="flex items-center space-x-2 text-sm text-gray-400">
                                            <span>Quantity: {{ $item->quantity }} × LKR {{ number_format($item->unit_price, 2) }}</span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-700/50 text-gray-400">
                                                Regular Price
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                @if($hasDiscount)
                                    <!-- Show savings summary -->
                                    <div class="space-y-1">
                                        <p class="text-sm text-gray-400">Total Item Cost:</p>
                                        <p class="text-lg font-medium text-white">LKR {{ number_format($item->total_price, 2) }}</p>
                                        <p class="text-xs text-green-400">
                                            Saved: LKR {{ number_format($discountAmount * $item->quantity, 2) }}
                                        </p>
                                    </div>
                                @else
                                <p class="text-lg font-medium text-white">LKR {{ number_format($item->total_price, 2) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Complete Order Summary Breakdown -->
            <div class="px-6 py-4 border-t border-gray-800 bg-gray-800/20">
                <h4 class="text-lg font-medium text-white mb-4">💰 Order Summary Breakdown</h4>
                
                @php
                    // Calculate original subtotal (without discounts)
                    $originalSubtotal = 0;
                    $currentSubtotal = 0;
                    foreach($order->orderItems as $item) {
                        $product = $item->product;
                        if ($product) {
                            $originalSubtotal += $item->quantity * $product->price;
                            $currentSubtotal += $item->quantity * $product->final_price;
                        }
                    }
                    $totalDiscountSavings = $originalSubtotal - $currentSubtotal;
                    
                    // Calculate payment fees if applicable
                    $paymentFee = 0;
                    if ($order->payment_method === 'webxpay') {
                        $paymentFee = $order->total_amount * 0.03;
                    }
                    
                    $finalTotal = $order->total_amount + $paymentFee;
                @endphp
                
                <div class="space-y-3">
                    <!-- Product Pricing Breakdown -->
                    <div class="bg-gray-700/30 rounded-lg p-4">
                        <h5 class="text-sm font-medium text-gray-300 mb-2">🛍️ Product Pricing</h5>
                        <div class="space-y-2 text-sm">
                            @if($totalDiscountSavings > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Original Subtotal</span>
                                    <span class="text-gray-300 line-through">LKR {{ number_format($originalSubtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-green-400">💸 Product Discounts</span>
                                    <span class="text-green-400">-LKR {{ number_format($totalDiscountSavings, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-400">Subtotal (After Discounts)</span>
                                <span class="text-white font-medium">LKR {{ number_format($order->subtotal, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Charges -->
                    @if($order->shipping_cost > 0 || $order->tax_amount > 0 || $order->discount_amount > 0)
                        <div class="bg-gray-700/30 rounded-lg p-4">
                            <h5 class="text-sm font-medium text-gray-300 mb-2">📦 Additional Charges</h5>
                            <div class="space-y-2 text-sm">
                    @if($order->shipping_cost > 0)
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">🚚 Shipping Cost</span>
                                        <span class="text-white">+LKR {{ number_format($order->shipping_cost, 2) }}</span>
                        </div>
                    @endif
                    @if($order->tax_amount > 0)
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">🧾 Tax</span>
                                        <span class="text-white">+LKR {{ number_format($order->tax_amount, 2) }}</span>
                                    </div>
                                @endif
                                @if($order->discount_amount > 0)
                                    <div class="flex justify-between">
                                        <span class="text-green-400">🎫 Order Discount</span>
                                        <span class="text-green-400">-LKR {{ number_format($order->discount_amount, 2) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Payment Information -->
                    @if($paymentFee > 0 || $order->payment_method)
                        <div class="bg-gray-700/30 rounded-lg p-4">
                            <h5 class="text-sm font-medium text-gray-300 mb-2">💳 Payment Details</h5>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Payment Method</span>
                                    <span class="text-white">
                                        @if($order->payment_method === 'webxpay')
                                            💳 WebXPay (Card Payment)
                                        @elseif($order->payment_method === 'kokopay')
                                            ⏰ Koko Pay (BNPL)
                                        @elseif($order->payment_method === 'bank_transfer')
                                            🏦 Bank Transfer
                                        @else
                                            {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                        @endif
                                    </span>
                                </div>
                                @if($paymentFee > 0)
                                    <div class="flex justify-between">
                                        <span class="text-yellow-400">⚡ Payment Processing Fee (3%)</span>
                                        <span class="text-yellow-400">+LKR {{ number_format($paymentFee, 2) }}</span>
                                    </div>
                                @endif
                                @if($order->payment_reference)
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">Transaction ID</span>
                                        <span class="text-blue-400 font-mono text-xs">{{ $order->payment_reference }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Total Summary -->
                    <div class="border-t border-gray-600 pt-3">
                        <div class="bg-gradient-to-r from-orange-500/20 to-yellow-500/20 rounded-lg p-4">
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-medium text-white">Order Total</span>
                                    <span class="text-lg font-bold text-white">LKR {{ number_format($order->total_amount, 2) }}</span>
                                </div>
                                @if($paymentFee > 0)
                                    <div class="flex justify-between items-center text-sm border-t border-gray-600 pt-2">
                                        <span class="text-yellow-300 font-medium">💰 Total Paid by Customer</span>
                                        <span class="text-xl font-bold text-[#f59e0b]">LKR {{ number_format($finalTotal, 2) }}</span>
                                    </div>
                                @endif
                                @if($totalDiscountSavings > 0)
                                    <div class="text-center text-sm text-green-400 bg-green-900/20 rounded px-2 py-1">
                                        🎉 Customer saved LKR {{ number_format($totalDiscountSavings, 2) }} on this order!
                        </div>
                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer & Shipping Info -->
        <div class="space-y-6">
            
            <!-- Customer Information -->
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-medium text-white mb-4">Customer Information</h3>
                
                @if($order->user)
                    <div class="flex items-center space-x-3 mb-4">
                        <img class="w-10 h-10 rounded-full" src="{{ $order->user->avatar_url }}" alt="{{ $order->user->name }}">
                        <div>
                            <p class="text-white font-medium">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-400">Registered Customer</p>
                        </div>
                    </div>
                @endif
                
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="text-gray-400">Name:</span>
                        <span class="text-white ml-2">{{ $order->customer_name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400">Email:</span>
                        <span class="text-white ml-2">{{ $order->customer_email }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400">Phone:</span>
                        <span class="text-white ml-2">{{ $order->customer_phone }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400">Payment Method:</span>
                        <span class="text-white ml-2">{{ $order->payment_method_display ?? ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                    </div>
                    @if($order->payment_reference)
                        <div>
                            <span class="text-gray-400">Transaction ID:</span>
                            <span class="text-white ml-2 font-mono text-sm">{{ $order->payment_reference }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Information -->
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-medium text-white mb-4">Payment Information</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Payment Method</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium {{ $order->payment_method_badge }}">
                            {{ $order->payment_method_display ?? ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                        </span>
                    </div>
                    
                    <!-- Koko Pay Order ID Display -->
                    @if($order->payment_method === 'kokopay')
                        @php
                            // Get the related transaction to find Koko Pay order ID
                            $kokoPayTransaction = $order->transactions()->where('payment_method', 'kokopay')->first();
                            $kokoPayOrderId = null;
                            
                            if ($kokoPayTransaction) {
                                // Try to get from gateway_reference first, then from metadata
                                $kokoPayOrderId = $kokoPayTransaction->gateway_reference ?? 
                                                ($kokoPayTransaction->metadata['orderId'] ?? 
                                                $kokoPayTransaction->metadata['koko_pay_order_id'] ?? null);
                            }
                        @endphp
                        
                        @if($kokoPayOrderId)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400">⏰ Koko Pay Order ID</span>
                            <div class="flex items-center space-x-2">
                                <span class="bg-purple-900/30 px-3 py-1 rounded-lg text-purple-300 font-mono text-sm font-bold border border-purple-500/30">
                                    {{ $kokoPayOrderId }}
                                </span>
                                @if($kokoPayTransaction)
                                <a href="{{ route('admin.transactions.show', $kokoPayTransaction) }}" 
                                   class="text-purple-400 hover:text-purple-300 text-xs">
                                    View Transaction →
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    @elseif($order->payment_method === 'webxpay')
                        @php
                            // Get the related transaction to find WebXPay reference
                            $webxpayTransaction = $order->transactions()->where('payment_method', 'webxpay')->first();
                            $webxpayReference = null;
                            
                            if ($webxpayTransaction) {
                                $webxpayReference = $webxpayTransaction->gateway_reference ?? $webxpayTransaction->gateway_transaction_id;
                            }
                        @endphp
                        
                        @if($webxpayReference)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400">💳 WebXPay Reference</span>
                            <div class="flex items-center space-x-2">
                                <span class="bg-purple-900/30 px-3 py-1 rounded-lg text-purple-300 font-mono text-sm font-bold border border-purple-500/30">
                                    {{ $webxpayReference }}
                                </span>
                                @if($webxpayTransaction)
                                <a href="{{ route('admin.transactions.show', $webxpayTransaction) }}" 
                                   class="text-purple-400 hover:text-purple-300 text-xs">
                                    View Transaction →
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    @endif
                    
                    <!-- Transfer Slip / Attachments Display (for all payment methods) -->
                        @if($order->transfer_slip_path)
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400 font-medium">📎 Order Attachment / Transfer Slip</span>
                                <div class="flex items-center space-x-2">
                                    @if(Storage::disk('public')->exists($order->transfer_slip_path))
                                    <span class="bg-green-900/30 px-3 py-1 rounded-lg text-green-300 text-sm font-medium border border-green-500/30">
                                        ✅ Uploaded
                                    </span>
                                    @else
                                        <span class="bg-red-900/30 px-3 py-1 rounded-lg text-red-300 text-sm font-medium border border-red-500/30">
                                            ⚠️ File Not Found
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            @if(Storage::disk('public')->exists($order->transfer_slip_path))
                            <!-- Transfer Slip Preview -->
                            <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-700">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        @php
                                            $fileExtension = pathinfo($order->transfer_slip_path, PATHINFO_EXTENSION);
                                            $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                            $isPdf = strtolower($fileExtension) === 'pdf';
                                            // Use asset() for more reliable URL generation
                                            $transferSlipUrl = asset('storage/' . $order->transfer_slip_path);
                                        @endphp
                                        
                                        @if($isImage)
                                            <!-- Image Preview -->
                                            <div class="w-32 h-32 bg-gray-900 rounded-lg overflow-hidden border border-gray-600">
                                                <img src="{{ $transferSlipUrl }}" 
                                                     alt="Transfer Slip" 
                                                     class="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity"
                                                     onclick="openImageModal('{{ $transferSlipUrl }}', 'Transfer Slip - {{ $order->order_number }}')"
                                                     onerror="this.onerror=null; this.src='{{ asset('images/placeholder-image.png') }}';">
                                            </div>
                                        @elseif($isPdf)
                                            <!-- PDF Icon -->
                                            <div class="w-32 h-32 bg-red-900/20 rounded-lg border border-red-500/30 flex items-center justify-center">
                                                <div class="text-center">
                                                    <svg class="w-12 h-12 text-red-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span class="text-xs text-red-300 font-medium">PDF</span>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Generic File Icon -->
                                            <div class="w-32 h-32 bg-gray-900 rounded-lg border border-gray-600 flex items-center justify-center">
                                                <div class="text-center">
                                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    <span class="text-xs text-gray-400 font-medium">{{ strtoupper($fileExtension) }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <div class="space-y-2">
                                            <div>
                                                <div class="text-sm font-medium text-white">Transfer Receipt</div>
                                                <div class="text-xs text-gray-400">{{ basename($order->transfer_slip_path) }}</div>
                                            </div>
                                            
                                            <div class="text-xs text-gray-500">
                                                <div>File Type: {{ strtoupper($fileExtension) }}</div>
                                                @if(Storage::disk('public')->exists($order->transfer_slip_path))
                                                    @php
                                                        $fileSize = Storage::disk('public')->size($order->transfer_slip_path);
                                                        $formattedSize = $fileSize < 1024 ? $fileSize . ' B' : 
                                                                        ($fileSize < 1048576 ? round($fileSize/1024, 2) . ' KB' : 
                                                                        round($fileSize/1048576, 2) . ' MB');
                                                    @endphp
                                                    <div>Size: {{ $formattedSize }}</div>
                                                @endif
                                                <div>Uploaded: {{ $order->created_at->format('M d, Y \a\t g:i A') }}</div>
                                            </div>
                                            
                                            <!-- Action Buttons -->
                                            <div class="flex items-center space-x-2 pt-2">
                                                @php
                                                    // Use asset() for more reliable URL generation
                                                    $transferSlipUrl = asset('storage/' . $order->transfer_slip_path);
                                                    $cleanCustomerName = preg_replace('/[^A-Za-z0-9\-_]/', '_', $order->customer_name);
                                                    $cleanCustomerPhone = preg_replace('/[^0-9]/', '', $order->customer_phone);
                                                @endphp
                                                <a href="{{ $transferSlipUrl }}" 
                                                   target="_blank"
                                                   class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    View Full Size
                                                </a>
                                                
                                                <a href="{{ $transferSlipUrl }}" 
                                                   download="transfer_slip_{{ $order->order_number }}_{{ $cleanCustomerName }}_{{ $cleanCustomerPhone }}.{{ $fileExtension }}"
                                                   class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs font-medium rounded-lg hover:bg-green-700 transition-colors">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <!-- File Not Found Warning -->
                            <div class="bg-red-900/20 rounded-lg p-4 border border-red-500/30">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <div>
                                        <div class="text-sm font-medium text-red-300">File Not Found</div>
                                        <div class="text-xs text-red-400 mt-1">The transfer slip file could not be located at: {{ $order->transfer_slip_path }}</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    @elseif($order->payment_method === 'bank_transfer')
                        <!-- No Transfer Slip Uploaded for Bank Transfer -->
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400">🏦 Transfer Slip</span>
                            <span class="bg-yellow-900/30 px-3 py-1 rounded-lg text-yellow-300 text-sm font-medium border border-yellow-500/30">
                                ⏳ Not Uploaded
                            </span>
                        </div>
                    @endif
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Payment Status</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->payment_status_badge }}">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                        </span>
                    </div>
                    
                    @if($order->payment_reference)
                        <div>
                            <div class="text-gray-400 text-sm mb-1">Transaction ID</div>
                            <div class="bg-gray-800 p-2 rounded text-white font-mono text-sm break-all">
                                {{ $order->payment_reference }}
                            </div>
                        </div>
                    @endif
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Amount</span>
                        <span class="text-[#f59e0b] font-bold">LKR {{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-medium text-white mb-4">Shipping Address</h3>
                <div class="text-sm text-gray-300">
                    <p class="text-white font-medium">{{ $order->customer_name }}</p>
                    <p>{{ $order->shipping_address_line_1 }}</p>
                    @if($order->shipping_address_line_2)
                        <p>{{ $order->shipping_address_line_2 }}</p>
                    @endif
                    <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                    <p>{{ $order->shipping_country }}</p>
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-medium text-white mb-4">Order Timeline</h3>
                <div class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-[#f59e0b] rounded-full"></div>
                        <div class="text-sm">
                            <span class="text-white font-medium">Order Placed</span>
                            <span class="text-gray-400 block">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</span>
                        </div>
                    </div>
                    @if($order->shipped_at)
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-blue-400 rounded-full"></div>
                            <div class="text-sm">
                                <span class="text-white font-medium">Shipped</span>
                                <span class="text-gray-400 block">{{ $order->shipped_at->format('M d, Y \a\t g:i A') }}</span>
                            </div>
                        </div>
                    @endif
                    @if($order->delivered_at)
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                            <div class="text-sm">
                                <span class="text-white font-medium">Delivered</span>
                                <span class="text-gray-400 block">{{ $order->delivered_at->format('M d, Y \a\t g:i A') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="max-w-4xl max-h-full p-4">
        <div class="bg-gray-900 rounded-lg overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-gray-700">
                <h3 id="modalTitle" class="text-lg font-medium text-white"></h3>
                <button onclick="closeImageModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-4">
                <img id="modalImage" src="" alt="" class="max-w-full max-h-96 mx-auto">
            </div>
        </div>
    </div>
</div>

<script>
// Show/hide shipping fields based on status
document.getElementById('status').addEventListener('change', function() {
    const shippingFields = document.getElementById('shipping-fields');
    if (this.value === 'shipped') {
        shippingFields.style.display = 'block';
    } else {
        shippingFields.style.display = 'none';
    }
});

// Image modal functions
function openImageModal(imageUrl, title) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    
    modalImage.src = imageUrl;
    modalImage.alt = title;
    modalTitle.textContent = title;
    modal.classList.remove('hidden');
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeImageModal();
        }
    });
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection
