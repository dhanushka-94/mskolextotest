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
                                {{ ucfirst($order->status) }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $order->payment_status_badge }}">
                                {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                            </span>
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

            <!-- Order Summary -->
            <div class="px-6 py-4 border-t border-gray-800 bg-gray-800/20">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Price Breakdown -->
                    <div>
                        <h4 class="text-lg font-medium text-white mb-3">Price Breakdown</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Subtotal</span>
                                <span class="text-white">LKR {{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            @if($order->shipping_cost > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Shipping</span>
                                    <span class="text-white">LKR {{ number_format($order->shipping_cost, 2) }}</span>
                                </div>
                            @endif
                            @if($order->tax_amount > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Tax</span>
                                    <span class="text-white">LKR {{ number_format($order->tax_amount, 2) }}</span>
                                </div>
                            @endif
                            <div class="border-t border-gray-700 pt-2">
                                <div class="flex justify-between font-medium">
                                    <span class="text-white">Total</span>
                                    <span class="text-[#f59e0b]">LKR {{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Info -->
                    <div>
                        <h4 class="text-lg font-medium text-white mb-3">Shipping Address</h4>
                        <div class="text-sm text-gray-300">
                            <p class="font-medium text-white">{{ $order->customer_name }}</p>
                            <p>{{ $order->shipping_address_line_1 }}</p>
                            @if($order->shipping_address_line_2)
                                <p>{{ $order->shipping_address_line_2 }}</p>
                            @endif
                            <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                            <p>{{ $order->shipping_country }}</p>
                            <p class="mt-2">{{ $order->customer_phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
            @auth
                <a href="{{ route('user.orders.detail', $order->order_number) }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-black bg-gradient-to-r from-[#f59e0b] to-[#fbbf24] hover:from-[#d97706] hover:to-[#f59e0b] transition-all duration-300">
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
@endsection