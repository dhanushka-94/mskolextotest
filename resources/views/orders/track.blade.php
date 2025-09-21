@extends('layouts.app')

@section('title', 'Track Your Order - MSK COMPUTERS')

@section('content')
<div class="min-h-screen bg-[#0a0a0a] py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-4">Track Your Order</h1>
            <p class="text-gray-400">Enter your order details below to track your order status and delivery information</p>
        </div>

        <!-- Quick Track Section -->
        <div class="bg-[#1c1c1e] rounded-xl border border-gray-800/30 p-8 mb-8">
            <div class="flex items-center mb-6">
                <div class="bg-primary-500/10 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-white">Order Tracking</h2>
                    <p class="text-gray-400">Real-time tracking for your MSK Computers order</p>
                </div>
            </div>

            <form method="POST" action="{{ route('orders.track') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="order_number" class="block text-sm font-medium text-gray-300 mb-2">
                            Order Number <span class="text-red-400">*</span>
                        </label>
                        <input type="text" 
                               id="order_number" 
                               name="order_number" 
                               value="{{ old('order_number') }}"
                               placeholder="e.g., MSK-2024-001234"
                               class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500 @error('order_number') border-red-500 @enderror">
                        @error('order_number')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            Email Address <span class="text-red-400">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="your.email@example.com"
                               class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 px-6 rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Track Order
                </button>
            </form>
        </div>

        @auth
        <!-- Quick Access for Logged Users -->
        <div class="bg-[#1c1c1e] rounded-xl border border-gray-800/30 p-8 mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="bg-green-500/10 p-3 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-white">Your Recent Orders</h2>
                        <p class="text-gray-400">Quick access to your order history</p>
                    </div>
                </div>
                <a href="{{ route('user.orders') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition-colors">
                    View All Orders
                </a>
            </div>

            @php
                $recentOrders = Auth::user()->orders()->latest()->take(3)->get();
            @endphp

            @if($recentOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                        <div class="bg-gray-800/30 rounded-lg p-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="mr-4">
                                    <div class="text-white font-medium">{{ $order->order_number }}</div>
                                    <div class="text-gray-400 text-sm">{{ $order->created_at->format('M d, Y') }}</div>
                                </div>
                                <div class="mr-4">
                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full
                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $order->status === 'shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="text-white font-medium">Rs. {{ number_format($order->total_amount, 2) }}</div>
                                    <div class="text-gray-400 text-sm">{{ $order->orderItems->count() }} item(s)</div>
                                </div>
                            </div>
                            <a href="{{ route('user.orders.detail', $order->order_number) }}" 
                               class="text-primary-400 hover:text-primary-300 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <p class="text-gray-400">You haven't placed any orders yet</p>
                    <a href="{{ route('home') }}" class="text-primary-400 hover:text-primary-300 transition-colors">Start Shopping</a>
                </div>
            @endif
        </div>
        @endauth

        <!-- Courier Tracking Section -->
        <div class="bg-[#1c1c1e] rounded-xl border border-gray-800/30 p-8 mb-8">
            <div class="flex items-center mb-6">
                <div class="bg-white/10 p-3 rounded-lg mr-4 flex items-center justify-center">
                    <img src="{{ asset('images/promtexpress.png') }}" 
                         alt="Prompt Xpress Logo" 
                         class="w-8 h-8 object-contain">
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-white">Courier Service Tracking</h2>
                    <p class="text-gray-400">Track your package delivery through Prompt Xpress</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Prompt Xpress Tracking -->
                <div class="bg-gray-800/30 rounded-lg p-6 border border-gray-700/50 hover:border-green-500/30 transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="bg-white/10 p-2 rounded-lg mr-3 flex items-center justify-center">
                            <img src="{{ asset('images/promtexpress.png') }}" 
                                 alt="Prompt Xpress" 
                                 class="w-6 h-6 object-contain">
                        </div>
                        <h3 class="text-lg font-semibold text-white">Package Tracking</h3>
                    </div>
                    
                    <p class="text-gray-300 text-sm mb-4">
                        Track your package delivery status with your AWB/Reference number through Prompt Xpress tracking system.
                    </p>
                    
                    <a href="https://www.promptxpress.lk/TrackItem.aspx#" 
                       target="_blank" 
                       class="inline-flex items-center justify-center w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Track with Prompt Xpress
                    </a>
                </div>

                <!-- Branch Network -->
                <div class="bg-gray-800/30 rounded-lg p-6 border border-gray-700/50 hover:border-blue-500/30 transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-500/20 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Branch Network</h3>
                    </div>
                    
                    <p class="text-gray-300 text-sm mb-4">
                        Find Prompt Xpress branches across Sri Lanka with 55+ locations for pickup and delivery services.
                    </p>
                    
                    <a href="https://www.promptxpress.lk/BranchNetwork.aspx#" 
                       target="_blank" 
                       class="inline-flex items-center justify-center w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-medium transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        View Branch Locations
                    </a>
                </div>
            </div>

            <!-- Courier Information -->
            <div class="mt-6 p-4 bg-gradient-to-r from-green-500/10 to-blue-500/10 border border-green-500/20 rounded-lg">
                <div class="flex items-start">
                    <div class="bg-white/10 p-1.5 rounded-lg mr-3 mt-0.5 flex-shrink-0">
                        <img src="{{ asset('images/promtexpress.png') }}" 
                             alt="Prompt Xpress" 
                             class="w-4 h-4 object-contain">
                    </div>
                    <div>
                        <h4 class="text-green-400 font-medium text-sm mb-1">Courier Information</h4>
                        <p class="text-gray-300 text-sm">
                            All MSK Computers orders are shipped via <strong>Prompt Xpress</strong> courier service. 
                            Once your order is dispatched, you'll receive an AWB/Reference number to track your package delivery status.
                            Delivery typically takes 24-48 hours across Sri Lanka.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status Guide -->
        <div class="bg-[#1c1c1e] rounded-xl border border-gray-800/30 p-8">
            <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 text-primary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Order Status Guide
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="text-center">
                    <div class="bg-yellow-500/10 p-4 rounded-lg mb-3">
                        <svg class="w-8 h-8 text-yellow-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-white font-medium mb-2">Pending</h3>
                    <p class="text-gray-400 text-sm">Order received and being reviewed</p>
                </div>

                <div class="text-center">
                    <div class="bg-blue-500/10 p-4 rounded-lg mb-3">
                        <svg class="w-8 h-8 text-blue-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-white font-medium mb-2">Processing</h3>
                    <p class="text-gray-400 text-sm">Order confirmed and being prepared</p>
                </div>

                <div class="text-center">
                    <div class="bg-purple-500/10 p-4 rounded-lg mb-3">
                        <svg class="w-8 h-8 text-purple-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-white font-medium mb-2">Shipped</h3>
                    <p class="text-gray-400 text-sm">Order dispatched and on the way</p>
                </div>

                <div class="text-center">
                    <div class="bg-green-500/10 p-4 rounded-lg mb-3">
                        <svg class="w-8 h-8 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-white font-medium mb-2">Delivered</h3>
                    <p class="text-gray-400 text-sm">Order successfully delivered</p>
                </div>

                <div class="text-center">
                    <div class="bg-red-500/10 p-4 rounded-lg mb-3">
                        <svg class="w-8 h-8 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-white font-medium mb-2">Cancelled</h3>
                    <p class="text-gray-400 text-sm">Order has been cancelled</p>
                </div>
            </div>
        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center">
            <p class="text-gray-400 mb-4">Need help with your order?</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="tel:+94112959005" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Call Support
                </a>
                <a href="mailto:info@mskcomputers.lk" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Email Support
                </a>
                <a href="https://wa.me/94777506939" target="_blank" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.726"/>
                    </svg>
                    WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
