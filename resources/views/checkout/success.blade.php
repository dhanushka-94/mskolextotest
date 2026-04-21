@extends('layouts.app')

@section('title', 'Order Confirmed - MSK COMPUTERS')
@section('description', 'Your order has been successfully placed at MSK Computers. Track your order and get updates on delivery.')

@section('content')
<div class="min-h-screen bg-[#0f0f0f] py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Success Header -->
        <div class="text-center mb-12">
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-white mb-4">Order Confirmed!</h1>
            <p class="text-xl text-gray-400">Thank you for your purchase from MSK Computers</p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 overflow-hidden mb-8">
            <!-- Order Header -->
            <div class="px-6 py-4 border-b border-gray-800 bg-gradient-to-r from-[#f59e0b]/10 to-[#fbbf24]/10">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white">{{ $order->order_number }}</h2>
                        <p class="text-sm text-gray-400">Placed on {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-[#f59e0b]">{{ $order->formatted_total }}</div>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $order->status_badge }}">
                                📋 {{ ucfirst($order->status) }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $order->payment_status_badge }}">
                                💳 {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                            </span>
                        </div>
                        <!-- Quick Invoice Download in Header -->
                        <div class="mt-2">
                            <a href="{{ route('orders.invoice', $order->order_number) }}" 
                               target="_blank"
                               class="inline-flex items-center px-3 py-1 text-xs font-medium text-[#f59e0b] border border-[#f59e0b]/30 rounded-lg hover:bg-[#f59e0b]/10 transition-colors">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Invoice
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="px-6 py-6">
                <h3 class="text-lg font-medium text-white mb-4">Order Items</h3>
                <div class="space-y-4">
                    @foreach($order->orderItems as $item)
                        <div class="flex items-center space-x-4 p-4 bg-gray-800/30 rounded-lg">
                            <div class="flex-shrink-0 w-16 h-16 bg-gray-800 rounded-lg overflow-hidden">
                                <img src="{{ $item->product_image_url }}" 
                                     alt="{{ $item->product_name }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white font-medium">{{ $item->product_name }}</h4>
                                @if($item->product_code)
                                    <p class="text-sm text-gray-400">Code: {{ $item->product_code }}</p>
                                @endif
                                <p class="text-sm text-gray-400">Quantity: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-white font-medium">{{ $item->formatted_unit_price }}</p>
                                <p class="text-sm text-gray-400">Total: {{ $item->formatted_total_price }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Complete Order Summary Breakdown -->
            <div class="px-6 py-4 border-t border-gray-800 bg-gray-800/20">
                <h4 class="text-lg font-medium text-white mb-4">💰 Complete Order Summary</h4>
                
                @php
                    // Calculate original subtotal and discounts for customer view
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
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column: Price Breakdown -->
                    <div class="space-y-4">
                        <!-- Product Pricing Breakdown -->
                        <div class="bg-gray-700/30 rounded-lg p-4">
                            <h5 class="text-sm font-medium text-gray-300 mb-3">🛍️ Product Pricing</h5>
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
                                <h5 class="text-sm font-medium text-gray-300 mb-3">📦 Additional Charges</h5>
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
                        <div class="bg-gray-700/30 rounded-lg p-4">
                            <h5 class="text-sm font-medium text-gray-300 mb-3">💳 Payment Details</h5>
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

                        <!-- Total Summary -->
                        <div class="bg-gradient-to-r from-orange-500/20 to-yellow-500/20 rounded-lg p-4">
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-medium text-white">Order Total</span>
                                    <span class="text-lg font-bold text-white">LKR {{ number_format($order->total_amount, 2) }}</span>
                                </div>
                                @if($paymentFee > 0)
                                    <div class="flex justify-between items-center text-sm border-t border-gray-600 pt-2">
                                        <span class="text-yellow-300 font-medium">💰 Total Paid</span>
                                        <span class="text-xl font-bold text-[#f59e0b]">LKR {{ number_format($finalTotal, 2) }}</span>
                                    </div>
                                @endif
                                @if($totalDiscountSavings > 0)
                                    <div class="text-center text-sm text-green-400 bg-green-900/20 rounded px-2 py-1">
                                        🎉 You saved LKR {{ number_format($totalDiscountSavings, 2) }} on this order!
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Delivery & Contact Info -->
                    <div class="space-y-4">
                        <!-- Shipping Address -->
                        <div class="bg-gray-700/30 rounded-lg p-4">
                            <h5 class="text-sm font-medium text-gray-300 mb-3">📍 Delivery Address</h5>
                            <div class="text-sm text-gray-300">
                                <p class="font-medium text-white">{{ $order->customer_name }}</p>
                                <p>{{ $order->shipping_address_line_1 }}</p>
                                @if($order->shipping_address_line_2)
                                    <p>{{ $order->shipping_address_line_2 }}</p>
                                @endif
                                <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                                <p>{{ $order->shipping_country }}</p>
                                <p class="mt-2 text-blue-400">📞 {{ $order->customer_phone }}</p>
                                @if($order->customer_email)
                                    <p class="text-blue-400">📧 {{ $order->customer_email }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Order Status & Timeline -->
                        <div class="bg-gray-700/30 rounded-lg p-4">
                            <h5 class="text-sm font-medium text-gray-300 mb-3">📊 Order Status</h5>
                            <div class="space-y-3">
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs {{ $order->status_badge }} px-2 py-1 rounded-full">
                                        📋 {{ ucfirst($order->status) }}
                                    </span>
                                    <span class="text-xs {{ $order->payment_status_badge }} px-2 py-1 rounded-full">
                                        💳 {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                    </span>
                                </div>
                                <div class="text-xs text-gray-400">
                                    <p>Placed: {{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                                    @if($order->payment_method === 'bank_transfer' && $order->transfer_slip_path)
                                        <p class="text-green-400 mt-1">✅ Transfer slip uploaded</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Special Instructions -->
                        @if($order->notes)
                            <div class="bg-gray-700/30 rounded-lg p-4">
                                <h5 class="text-sm font-medium text-gray-300 mb-3">📝 Special Instructions</h5>
                                <p class="text-sm text-gray-300">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Bank Transfer Instructions (only for bank transfer orders) -->
        @if($order->payment_method === 'bank_transfer')
        <div class="bg-gradient-to-br from-green-900/20 to-green-800/20 border border-green-700/50 rounded-xl p-6 mb-8">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center space-x-2">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m11 0a2 2 0 01-2 2H7a2 2 0 01-2-2m14 0V9a2 2 0 00-2-2M9 7h6m-6 4h6m-6 4h6m-6 4h6"/>
                </svg>
                <span>Complete Your Bank Transfer</span>
            </h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Bank Details -->
                <div class="bg-[#0f0f0f] rounded-lg p-4">
                    <h4 class="text-white font-medium mb-3">Bank Account Details</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Bank Name:</span>
                            <span class="text-white font-medium">Commercial Bank</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Account Name:</span>
                            <span class="text-white font-medium">MSK Computers</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Account Number:</span>
                            <span class="text-white font-medium">1000578810</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Branch:</span>
                            <span class="text-white font-medium">Ragama Branch</span>
                        </div>
                        <div class="flex justify-between border-t border-gray-700 pt-2 mt-3">
                            <span class="text-gray-400">Amount to Transfer:</span>
                            <span class="text-green-400 font-bold">LKR {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Reference:</span>
                            <span class="text-white font-medium">{{ $order->order_number }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Instructions -->
                <div class="space-y-4">
                    <div class="bg-blue-900/20 border border-blue-700/50 rounded-lg p-4">
                        <h5 class="text-blue-300 font-medium mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Important Instructions
                        </h5>
                        <ul class="text-sm text-blue-200 space-y-1">
                            <li>• Transfer the exact amount: <strong>LKR {{ number_format($order->total_amount, 2) }}</strong></li>
                            <li>• Use order number <strong>{{ $order->order_number }}</strong> as reference</li>
                            <li>• Keep your transfer receipt for records</li>
                            <li>• We'll confirm payment within 24 hours</li>
                        </ul>
                    </div>
                    
                    @if($order->transfer_slip_path)
                    <div class="bg-green-900/20 border border-green-700/50 rounded-lg p-4">
                        <h5 class="text-green-300 font-medium mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Transfer Slip Uploaded
                        </h5>
                        <p class="text-sm text-green-200">
                            ✅ Your transfer slip has been uploaded successfully. This will help us verify your payment faster.
                        </p>
                    </div>
                    @else
                    <div class="bg-yellow-900/20 border border-yellow-700/50 rounded-lg p-4">
                        <h5 class="text-yellow-300 font-medium mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            Upload Transfer Slip (Optional)
                        </h5>
                        <p class="text-sm text-yellow-200 mb-3">
                            You can upload your transfer slip to help us verify your payment faster.
                        </p>
                        <a href="mailto:info@mskcomputers.lk?subject=Transfer Slip - Order {{ $order->order_number }}&body=Please find attached my bank transfer slip for order {{ $order->order_number }}." 
                           class="inline-flex items-center px-3 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Email Transfer Slip
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- What's Next -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6 mb-8">
            <h3 class="text-lg font-medium text-white mb-4">What's Next?</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-6 h-6 bg-[#f59e0b] rounded-full flex items-center justify-center">
                            <span class="text-black text-xs font-bold">1</span>
                        </div>
                        <p class="text-gray-300">We'll prepare your order for shipping</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-6 h-6 bg-[#f59e0b] rounded-full flex items-center justify-center">
                            <span class="text-black text-xs font-bold">2</span>
                        </div>
                        <p class="text-gray-300">You'll receive a tracking number via email</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-6 h-6 bg-[#f59e0b] rounded-full flex items-center justify-center">
                            <span class="text-black text-xs font-bold">3</span>
                        </div>
                        <p class="text-gray-300">
                            @if($order->payment_method === 'cash_on_delivery')
                                Pay when you receive your order
                            @else
                                Complete your payment using the provided details
                            @endif
                        </p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-6 h-6 bg-[#f59e0b] rounded-full flex items-center justify-center">
                            <span class="text-black text-xs font-bold">4</span>
                        </div>
                        <p class="text-gray-300">Our team will contact you if we need any clarification</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <!-- Download Invoice Button - Most Prominent -->
            <a href="{{ route('orders.invoice', $order->order_number) }}" 
               target="_blank"
               class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-lg text-black bg-gradient-to-r from-[#f59e0b] to-[#fbbf24] hover:from-[#d97706] hover:to-[#f59e0b] transition-all duration-300 transform hover:scale-105 shadow-lg">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                📄 Download Invoice
            </a>

            @auth
                <a href="{{ route('user.orders.detail', $order->order_number) }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gray-700 hover:bg-gray-600 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    View Order Details
                </a>
            @endauth
            
            <a href="{{ route('orders.track') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-700 text-base font-medium rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
                Track Order
            </a>
            
            <a href="{{ route('home') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-700 text-base font-medium rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Continue Shopping
            </a>
        </div>

        <!-- Contact Info -->
        <div class="text-center mt-12 p-6 bg-gray-800/30 rounded-xl">
            <h3 class="text-lg font-medium text-white mb-2">Need Help?</h3>
            <p class="text-gray-400 mb-4">If you have any questions about your order, feel free to contact us</p>
            <div class="flex items-center justify-center space-x-6 text-sm">
                <a href="tel:0112959005" class="text-[#f59e0b] hover:text-[#d97706] transition-colors">
                    📞 0112 95 9005
                </a>
                <a href="https://wa.me/94777506939" class="text-[#f59e0b] hover:text-[#d97706] transition-colors">
                    📱 WhatsApp: +94 777 506 939
                </a>
                <a href="mailto:info@mskcomputers.lk" class="text-[#f59e0b] hover:text-[#d97706] transition-colors">
                    ✉️ info@mskcomputers.lk
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Clear cart from localStorage and session after successful order
document.addEventListener('DOMContentLoaded', function() {
    console.log('Order completed successfully - clearing cart data');
    
    // Clear localStorage cart data
    localStorage.removeItem('cartTotal');
    localStorage.removeItem('cartCount');
    localStorage.removeItem('cart');
    
    // Force update any cart displays on the page
    const cartTotalElements = document.querySelectorAll('.cart-total, [data-cart-total]');
    cartTotalElements.forEach(element => {
        element.textContent = 'LKR 0.00';
    });
    
    const cartCountElements = document.querySelectorAll('.cart-count, [data-cart-count]');
    cartCountElements.forEach(element => {
        element.textContent = '0';
        element.style.display = 'none'; // Hide cart count badges
    });
    
    // Update header cart if the function exists
    if (typeof updateHeaderCartTotal === 'function') {
        updateHeaderCartTotal('0.00');
    }
    
    // Clear any cart-related session storage as well
    try {
        sessionStorage.removeItem('cartTotal');
        sessionStorage.removeItem('cartCount');
        sessionStorage.removeItem('cart');
    } catch (e) {
        // Session storage might not be available
    }
    
    console.log('Cart data cleared from browser storage');
});
</script>
@endsection