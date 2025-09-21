@extends('layouts.app')

@section('title', 'Checkout - MSK COMPUTERS')
@section('description', 'Complete your purchase at MSK Computers with secure checkout and multiple payment options.')

@section('content')
<div class="min-h-screen bg-[#0f0f0f] py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
            <h1 class="text-3xl font-bold text-white mb-2">Checkout</h1>
            <p class="text-gray-400">Complete your order with secure payment</p>
                </div>
                
                @guest
                <div class="text-right">
                    <p class="text-gray-400 text-sm mb-2">Returning customer?</p>
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-black font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Login
                    </a>
                </div>
                @else
                <div class="text-right">
                    <p class="text-gray-400 text-sm">Welcome back,</p>
                    <p class="text-white font-medium">{{ Auth::user()->name }}</p>
                </div>
                @endguest
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form" novalidate>
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Checkout Form -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Customer Information -->
                    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                        <h3 class="text-lg font-medium text-white mb-4">Customer Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-300 mb-2">
                                    Full Name *
                                    <span class="text-red-400 text-xs">(Required)</span>
                                </label>
                                <input type="text" 
                                       id="customer_name" 
                                       name="customer_name" 
                                       value="{{ old('customer_name', Auth::user()->name ?? '') }}" 
                                       required
                                       placeholder="Enter your full name"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            </div>
                            
                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-gray-300 mb-2">
                                    Phone Number *
                                    <span class="text-red-400 text-xs">(Required)</span>
                                </label>
                                <input type="tel" 
                                       id="customer_phone" 
                                       name="customer_phone" 
                                       value="{{ old('customer_phone', Auth::user()->phone ?? '') }}" 
                                       required
                                       placeholder="Enter your phone number (e.g., 0771234567)"
                                       pattern="^0[1-9][0-9]{8}$"
                                       title="Please enter a valid Sri Lankan phone number (10 digits starting with 0)"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                                <div class="flex items-center mt-2 text-xs text-gray-400">
                                    <svg class="w-4 h-4 mr-1 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    We'll use this number to send SMS order notifications and delivery updates
                                </div>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="customer_email" class="block text-sm font-medium text-gray-300 mb-2">
                                    Email Address
                                    <span class="text-gray-500 text-xs">(Optional - for order updates)</span>
                                </label>
                                <input type="email" 
                                       id="customer_email" 
                                       name="customer_email" 
                                       value="{{ old('customer_email', Auth::user()->email ?? '') }}" 
                                       placeholder="Enter your email address (optional)"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                        <h3 class="text-lg font-medium text-white mb-4">Billing Address</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="billing_address_line_1" class="block text-sm font-medium text-gray-300 mb-2">
                                    Address Line 1 *
                                    <span class="text-red-400 text-xs">(Required)</span>
                                </label>
                                <input type="text" 
                                       id="billing_address_line_1" 
                                       name="billing_address_line_1" 
                                       value="{{ old('billing_address_line_1') }}" 
                                       required
                                       placeholder="Enter your street address, house number"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="billing_address_line_2" class="block text-sm font-medium text-gray-300 mb-2">
                                    Address Line 2
                                    <span class="text-gray-500 text-xs">(Optional - apartment, suite, etc.)</span>
                                </label>
                                <input type="text" 
                                       id="billing_address_line_2" 
                                       name="billing_address_line_2" 
                                       value="{{ old('billing_address_line_2') }}"
                                       placeholder="Apartment, suite, building (optional)"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            </div>
                            
                            <div>
                                <label for="billing_city" class="block text-sm font-medium text-gray-300 mb-2">
                                    City *
                                    <span class="text-red-400 text-xs">(Required)</span>
                                </label>
                                <input type="text" 
                                       id="billing_city" 
                                       name="billing_city" 
                                       value="{{ old('billing_city') }}" 
                                       required
                                       placeholder="Enter your city"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            </div>
                            
                            <div>
                                <label for="billing_state" class="block text-sm font-medium text-gray-300 mb-2">
                                    State/Province
                                    <span class="text-gray-500 text-xs">(Optional)</span>
                                </label>
                                <input type="text" 
                                       id="billing_state" 
                                       name="billing_state" 
                                       value="{{ old('billing_state') }}" 
                                       placeholder="State or province (optional)"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            </div>
                            
                            <div>
                                <label for="billing_postal_code" class="block text-sm font-medium text-gray-300 mb-2">
                                    Postal Code
                                    <span class="text-gray-500 text-xs">(Optional)</span>
                                </label>
                                <input type="text" 
                                       id="billing_postal_code" 
                                       name="billing_postal_code" 
                                       value="{{ old('billing_postal_code') }}" 
                                       placeholder="Postal code (optional)"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            </div>
                            
                            <div>
                                <label for="billing_country" class="block text-sm font-medium text-gray-300 mb-2">
                                    Country
                                    <span class="text-gray-500 text-xs">(Optional)</span>
                                </label>
                                <input type="text" 
                                       id="billing_country" 
                                       name="billing_country" 
                                       value="{{ old('billing_country', 'Sri Lanka') }}"
                                       placeholder="Country (optional)"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-white">Shipping Address</h3>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       id="same_as_billing" 
                                       checked
                                       class="h-4 w-4 text-[#f59e0b] focus:ring-[#f59e0b] border-gray-700 rounded bg-[#0f0f0f]">
                                <span class="ml-2 text-sm text-gray-300">Same as billing address</span>
                            </label>
                        </div>
                        
                        <div id="shipping-address-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="shipping_address_line_1" class="block text-sm font-medium text-gray-300 mb-2">
                                    Address Line 1
                                    <span class="text-gray-500 text-xs">(Required only if different from billing)</span>
                                </label>
                                <input type="text" 
                                       id="shipping_address_line_1" 
                                       name="shipping_address_line_1" 
                                       value="{{ old('shipping_address_line_1') }}" 
                                       placeholder="Enter delivery street address, house number"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="shipping_address_line_2" class="block text-sm font-medium text-gray-300 mb-2">
                                    Address Line 2
                                    <span class="text-gray-500 text-xs">(Optional - apartment, suite, etc.)</span>
                                </label>
                                <input type="text" 
                                       id="shipping_address_line_2" 
                                       name="shipping_address_line_2" 
                                       value="{{ old('shipping_address_line_2') }}"
                                       placeholder="Apartment, suite, building (optional)"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            </div>
                            
                            <div>
                                <label for="shipping_city" class="block text-sm font-medium text-gray-300 mb-2">
                                    City
                                    <span class="text-gray-500 text-xs">(Required only if different from billing)</span>
                                </label>
                                <input type="text" 
                                       id="shipping_city" 
                                       name="shipping_city" 
                                       value="{{ old('shipping_city') }}" 
                                       placeholder="Enter delivery city"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            </div>
                            
                            <div>
                                <label for="shipping_state" class="block text-sm font-medium text-gray-300 mb-2">
                                    State/Province
                                    <span class="text-gray-500 text-xs">(Optional)</span>
                                </label>
                                <input type="text" 
                                       id="shipping_state" 
                                       name="shipping_state" 
                                       value="{{ old('shipping_state') }}" 
                                       placeholder="State or province (optional)"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            </div>
                            
                            <div>
                                <label for="shipping_postal_code" class="block text-sm font-medium text-gray-300 mb-2">
                                    Postal Code
                                    <span class="text-gray-500 text-xs">(Optional)</span>
                                </label>
                                <input type="text" 
                                       id="shipping_postal_code" 
                                       name="shipping_postal_code" 
                                       value="{{ old('shipping_postal_code') }}" 
                                       placeholder="Postal code (optional)"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            </div>
                            
                            <div>
                                <label for="shipping_country" class="block text-sm font-medium text-gray-300 mb-2">
                                    Country
                                    <span class="text-gray-500 text-xs">(Optional)</span>
                                </label>
                                <input type="text" 
                                       id="shipping_country" 
                                       name="shipping_country" 
                                       value="{{ old('shipping_country', 'Sri Lanka') }}"
                                       placeholder="Country (optional)"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Shipping/Delivery Information -->
                    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                        <div class="flex items-center mb-4">
                            <svg class="w-5 h-5 text-primary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                            </svg>
                            <h3 class="text-lg font-medium text-white">Shipping/Delivery Information</h3>
                        </div>
                        
                        <div class="bg-amber-900/20 border border-amber-700/50 rounded-lg p-4">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-amber-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h4 class="text-amber-400 font-medium text-sm mb-2">Important Notice - Delivery Charges</h4>
                                    <p class="text-amber-300 text-sm mb-3">
                                        Kindly note that delivery charges are due at the time of parcel receipt.
                                    </p>
                                    <p class="text-amber-300 text-sm font-medium">
                                        පාර්සලය ලැබුණු අවස්ථාවේදී බෙදා හැරීමේ ගාස්තු ගෙවිය යුතු බව කරුණාවෙන් සලකන්න.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Transaction Fee Notice (shown only when Credit/Debit Card is selected) -->
                        <div class="bg-blue-900/20 border border-blue-700/50 rounded-lg p-4 webxpay-notice" style="display: none;">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h4 class="text-blue-400 font-medium text-sm mb-2">Card Payment Processing Fee</h4>
                                    <p class="text-blue-300 text-sm mb-3">
                                        A standard transaction fee of 3% will be applied for secure card payment processing.
                                    </p>
                                    <p class="text-blue-300 text-sm font-medium">
                                        ✓ SSL Encrypted • ✓ PCI Compliant • ✓ Instant Processing
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Koko Pay BNPL Notice (shown only when Koko Pay is selected) -->
                    <div class="bg-purple-900/20 border border-purple-700/50 rounded-lg p-4 kokopay-notice" style="display: none;">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-purple-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                            <div>
                                <h4 class="text-purple-400 font-medium text-sm mb-2">Buy Now, Pay Later with Koko Pay</h4>
                                <p class="text-purple-300 text-sm mb-3">
                                    Split your payment into 3 easy installments. Pay only 1/3 today, remaining in 30 & 60 days.
                                </p>
                                
                                <!-- 3-Split Payment Breakdown -->
                                <div class="grid grid-cols-3 gap-2 mb-3">
                                    <div class="text-center p-2 bg-purple-800/20 rounded-lg">
                                        <div class="text-xs text-purple-300 mb-1">Today</div>
                                        <div class="text-sm font-semibold text-white kokopay-split-1">LKR 0.00</div>
                                    </div>
                                    <div class="text-center p-2 bg-blue-800/20 rounded-lg">
                                        <div class="text-xs text-blue-300 mb-1">30 Days</div>
                                        <div class="text-sm font-semibold text-white kokopay-split-2">LKR 0.00</div>
                                    </div>
                                    <div class="text-center p-2 bg-green-800/20 rounded-lg">
                                        <div class="text-xs text-green-300 mb-1">60 Days</div>
                                        <div class="text-sm font-semibold text-white kokopay-split-3">LKR 0.00</div>
                                    </div>
                                </div>
                                <p class="text-purple-300 text-sm font-medium">
                                    කොකෝ පේ සමඟ දැන් මිලදී ගෙන පසුව ගෙවන්න. වාරික 3කින් ගෙවන්න.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                        <div class="bg-gradient-to-r from-primary-500/10 to-purple-500/10 border border-primary-500/30 rounded-lg p-4 mb-6">
                            <div class="flex items-center space-x-2 mb-2">
                                <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                <h3 class="text-lg font-semibold text-white">Choose Your Payment Method</h3>
                            </div>
                            <p class="text-gray-300 text-sm">Select how you'd like to pay for your order. All payments are secured with SSL encryption.</p>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Credit/Debit Card Payment - Primary Payment Option -->
                            <label class="flex items-center p-4 border-2 border-primary-500 bg-gradient-to-r from-primary-900/20 to-primary-800/20 rounded-lg hover:border-primary-400 transition-colors cursor-pointer relative">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="webxpay" 
                                       checked
                                       class="h-4 w-4 text-primary-500 focus:ring-primary-500 border-gray-700 bg-[#0f0f0f]">
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center space-x-2">
                                        <div class="text-sm font-medium text-white">Credit or Debit Card Payment</div>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-500 text-black">
                                            Secure & Instant
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-400">Secure online payment • Credit Cards, Debit Cards, Online Banking, Mobile Wallets</div>
                                </div>
                                <div class="flex items-center space-x-2 text-primary-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3-3v8a3 3 0 003 3z"/>
                                    </svg>
                                </div>
                            </label>

                            <!-- Koko Pay - BNPL Option -->
                            <label class="flex items-center p-4 border-2 border-purple-500 bg-gradient-to-r from-purple-900/20 to-blue-900/20 rounded-lg hover:border-purple-400 transition-colors cursor-pointer relative">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="kokopay"
                                       class="h-4 w-4 text-purple-500 focus:ring-purple-500 border-gray-700 bg-[#0f0f0f]">
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center space-x-2">
                                        <div class="text-sm font-medium text-white">Koko Pay</div>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-purple-500 to-blue-500 text-white">
                                            Buy Now, Pay Later
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-400">Split into 3 easy payments • 10% transaction fee applies</div>
                                </div>
                                <div class="flex items-center space-x-2 text-purple-400">
                                    <img src="{{ asset('images/kokopay-logo.png') }}" alt="Koko Pay" class="h-6 w-auto">
                                </div>
                            </label>
                            
                            <!-- Bank Transfer -->
                            <label class="flex items-center p-4 border border-gray-700 rounded-lg hover:border-[#f59e0b] transition-colors cursor-pointer">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="bank_transfer"
                                       class="h-4 w-4 text-[#f59e0b] focus:ring-[#f59e0b] border-gray-700 bg-[#0f0f0f]">
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center space-x-2">
                                    <div class="text-sm font-medium text-white">Bank Transfer</div>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-600 text-white">
                                            No Fees
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-400">Direct transfer to our bank account • Manual verification required</div>
                                </div>
                                <div class="flex items-center space-x-2 text-[#f59e0b]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m11 0a2 2 0 01-2 2H7a2 2 0 01-2-2m14 0V9a2 2 0 00-2-2M9 7h6m-6 4h6m-6 4h6m-6 4h6"/>
                                    </svg>
                                </div>
                            </label>
                            
                            <!-- Bank Transfer Details (shown only when Bank Transfer is selected) -->
                            <div class="bg-green-900/20 border border-green-700/50 rounded-lg p-4 bank-transfer-notice" style="display: none;">
                                <div class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m11 0a2 2 0 01-2 2H7a2 2 0 01-2-2m14 0V9a2 2 0 00-2-2M9 7h6m-6 4h6m-6 4h6m-6 4h6"/>
                                    </svg>
                                    <div class="flex-1">
                                        <h4 class="text-green-400 font-medium text-sm mb-3">Bank Transfer Details</h4>
                                        
                                        <div class="bg-black/30 rounded-lg p-4 mb-4">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                                <div>
                                                    <div class="text-gray-400 mb-1">Bank Name:</div>
                                                    <div class="text-white font-medium">Commercial Bank of Ceylon PLC</div>
                                                </div>
                                                <div>
                                                    <div class="text-gray-400 mb-1">Account Name:</div>
                                                    <div class="text-white font-medium">MSK Computers (Pvt) Ltd</div>
                                                </div>
                                                <div>
                                                    <div class="text-gray-400 mb-1">Account Number:</div>
                                                    <div class="text-white font-medium">8001234567890</div>
                                                </div>
                                                <div>
                                                    <div class="text-gray-400 mb-1">Branch:</div>
                                                    <div class="text-white font-medium">Colombo Main Branch</div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="space-y-2 text-sm">
                                            <p class="text-green-300 font-medium">
                                                📝 Important Instructions:
                                            </p>
                                            <ul class="text-green-200 space-y-1 text-xs ml-4">
                                                <li>• Please include your <strong>Order Number</strong> in the transfer reference</li>
                                                <li>• Send the payment slip/screenshot to <strong>payments@mskcomputers.lk</strong></li>
                                                <li>• Your order will be processed within 1-2 business days after payment confirmation</li>
                                                <li>• Keep your payment receipt for tracking purposes</li>
                                            </ul>
                                        </div>
                                        
                                        <div class="mt-4 p-3 bg-[#f59e0b]/10 border border-[#f59e0b]/20 rounded-lg">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                </svg>
                                                <div>
                                                    <div class="text-[#f59e0b] text-xs font-medium">Need Help?</div>
                                                    <div class="text-[#f59e0b] text-xs">Call: 0112 95 9005 | Email: info@mskcomputers.lk</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                        <h3 class="text-lg font-medium text-white mb-4">Order Notes (Optional)</h3>
                        <textarea id="notes" 
                                  name="notes" 
                                  rows="3" 
                                  placeholder="Any special instructions for your order..."
                                  class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6 sticky top-8">
                        <h3 class="text-lg font-medium text-white mb-4">Order Summary</h3>
                        
                        <!-- Cart Items -->
                        <div class="space-y-4 mb-6">
                            @foreach($cartProducts as $cartProduct)
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0 w-12 h-12 bg-gray-800 rounded-lg overflow-hidden">
                                        <img src="{{ $cartProduct['product']->main_image }}" 
                                             alt="{{ $cartProduct['product']->name }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-white truncate">{{ $cartProduct['product']->name }}</p>
                                        <p class="text-sm text-gray-400">Qty: {{ $cartProduct['cart_item']->quantity }}</p>
                                    </div>
                                    <p class="text-sm font-medium text-white">LKR {{ number_format($cartProduct['line_total'], 2) }}</p>
                                </div>
                            @endforeach
                        </div>

                        <!-- Price Breakdown -->
                        <div class="border-t border-gray-700 pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Subtotal</span>
                                <span class="text-white">LKR {{ number_format($originalSubtotal > 0 ? $originalSubtotal : $subtotal, 2) }}</span>
                            </div>
                            
                            <!-- Discount Section -->
                            @if($totalDiscount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-green-400">
                                    Discount
                                    <span class="text-xs text-gray-500 block">You save</span>
                                </span>
                                <span class="text-green-400">-LKR {{ number_format($totalDiscount, 2) }}</span>
                            </div>
                            
                            <!-- Subtotal after discount -->
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Subtotal (after discount)</span>
                                <span class="text-white">LKR {{ number_format($subtotal, 2) }}</span>
                            </div>
                            @endif
                            
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Shipping</span>
                                <span class="text-amber-400 text-xs">
                                    Pay on delivery
                                </span>
                            </div>
                            
                            @if($taxAmount > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Tax</span>
                                    <span class="text-white">LKR {{ number_format($taxAmount, 2) }}</span>
                                </div>
                            @endif
                            
                            <!-- Transaction Fee (shown only when WebXPay is selected) -->
                            <div class="flex justify-between text-sm webxpay-fee" style="display: none;">
                                <span class="text-gray-400">
                                    Transaction Fee (3%)
                                    <span class="text-xs text-blue-400 block">Payment processing</span>
                                </span>
                                <span class="text-blue-400 webxpay-fee-amount">
                                    LKR 0.00
                                </span>
                            </div>

                            <!-- Koko Pay Transaction Fee (shown only when Koko Pay is selected) -->
                            <div class="flex justify-between text-sm kokopay-fee" style="display: none;">
                                <span class="text-gray-400">
                                    Transaction Fee (10%)
                                    <span class="text-xs text-purple-400 block">BNPL processing</span>
                                </span>
                                <span class="text-purple-400 kokopay-fee-amount">
                                    LKR 0.00
                                </span>
                            </div>
                            
                            <div class="border-t border-gray-700 pt-2">
                                <div class="flex justify-between">
                                    <span class="text-lg font-medium text-white">Order Total</span>
                                    <span class="text-lg font-bold text-[#f59e0b] order-total">LKR {{ number_format($total, 2) }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">+ Shipping charges on delivery</p>
                            </div>
                        </div>

                        <!-- Terms and Submit -->
                        <div class="mt-6 space-y-4">
                            <label class="flex items-start">
                                <input type="checkbox" 
                                       name="terms" 
                                       required
                                       class="h-4 w-4 text-[#f59e0b] focus:ring-[#f59e0b] border-gray-700 rounded bg-[#0f0f0f] mt-0.5">
                                <span class="ml-3 text-sm text-gray-300">
                                    I agree to the <a href="{{ route('terms-of-service') }}" target="_blank" class="text-[#f59e0b] hover:text-[#d97706] underline">Terms of Service</a> and 
                                    <a href="{{ route('privacy-policy') }}" target="_blank" class="text-[#f59e0b] hover:text-[#d97706] underline">Privacy Policy</a>
                                </span>
                            </label>
                            
                            <button type="submit" 
                                    class="w-full py-4 px-6 border border-transparent text-lg font-medium rounded-lg text-black bg-gradient-to-r from-[#f59e0b] to-[#fbbf24] hover:from-[#d97706] hover:to-[#f59e0b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#f59e0b] transition-all duration-300 transform hover:scale-105">
                                Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
console.log('Checkout JavaScript loaded - script is running');
console.log('Current URL:', window.location.href);
console.log('Document ready state:', document.readyState);

// Check CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]');
console.log('CSRF token found:', csrfToken ? 'Yes' : 'No');
if (csrfToken) {
    console.log('CSRF token value:', csrfToken.getAttribute('content'));
}

// Test if basic JavaScript is working
try {
    console.log('JavaScript test: Basic functionality working');
    window.checkoutDebug = true;
    
    // Add a simple click test
    document.body.addEventListener('click', function(e) {
        console.log('Body clicked at:', e.target.tagName, e.target.className);
    });
    
} catch (error) {
    console.error('JavaScript error in basic test:', error);
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - starting checkout initialization');
    
    // Check if form exists
    const checkoutForm = document.getElementById('checkout-form');
    console.log('Checkout form found:', checkoutForm ? 'Yes' : 'No');
    
    // Add form submission logging
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            console.log('🚀 Form submission started');
            console.log('Form data being submitted:', new FormData(checkoutForm));
            console.log('Selected payment method:', document.querySelector('input[name="payment_method"]:checked')?.value);
        });
    }
    
    // Transaction fee calculation and display
    const baseOrderTotal = {{ $total }};
    
    function formatCurrency(amount) {
        return 'LKR ' + parseFloat(amount).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
    
    function updatePaymentFees() {
        const webxpayRadio = document.querySelector('input[name="payment_method"][value="webxpay"]');
        const kokopayRadio = document.querySelector('input[name="payment_method"][value="kokopay"]');
        const bankTransferRadio = document.querySelector('input[name="payment_method"][value="bank_transfer"]');
        
        // Payment method elements
        const webxpayNotice = document.querySelector('.webxpay-notice');
        const webxpayFeeRow = document.querySelector('.webxpay-fee');
        const webxpayFeeAmount = document.querySelector('.webxpay-fee-amount');
        
        // Koko Pay elements
        const kokopayNotice = document.querySelector('.kokopay-notice');
        const kokopayFeeRow = document.querySelector('.kokopay-fee');
        const kokopayFeeAmount = document.querySelector('.kokopay-fee-amount');
        
        // Koko Pay 3-split breakdown elements
        const kokopaySplit1 = document.querySelector('.kokopay-split-1');
        const kokopaySplit2 = document.querySelector('.kokopay-split-2');
        const kokopaySplit3 = document.querySelector('.kokopay-split-3');
        
        // Bank Transfer elements
        const bankTransferNotice = document.querySelector('.bank-transfer-notice');
        
        const orderTotalElement = document.querySelector('.order-total');
        
        // Hide all notices and fee rows by default
        if (webxpayNotice) webxpayNotice.style.display = 'none';
        if (webxpayFeeRow) webxpayFeeRow.style.display = 'none';
        if (kokopayNotice) kokopayNotice.style.display = 'none';
        if (kokopayFeeRow) kokopayFeeRow.style.display = 'none';
        if (bankTransferNotice) bankTransferNotice.style.display = 'none';
        
        if (webxpayRadio && webxpayRadio.checked) {
            // Show WebXPay transaction fee notice and row
            if (webxpayNotice) webxpayNotice.style.display = 'block';
            if (webxpayFeeRow) webxpayFeeRow.style.display = 'flex';
            
            // Calculate 3% transaction fee
            const transactionFee = baseOrderTotal * 0.03;
            const newTotal = baseOrderTotal + transactionFee;
            
            // Update amounts with proper formatting
            if (webxpayFeeAmount) webxpayFeeAmount.textContent = formatCurrency(transactionFee);
            if (orderTotalElement) orderTotalElement.textContent = formatCurrency(newTotal);
            
            console.log('WebXPay selected - Transaction Fee: ' + formatCurrency(transactionFee) + ', New Total: ' + formatCurrency(newTotal));
            
        } else if (kokopayRadio && kokopayRadio.checked) {
            // Show Koko Pay BNPL notice and transaction fee row
            if (kokopayNotice) kokopayNotice.style.display = 'block';
            if (kokopayFeeRow) kokopayFeeRow.style.display = 'flex';
            
            // Calculate 10% transaction fee for Koko Pay
            const transactionFee = baseOrderTotal * 0.10;
            const newTotal = baseOrderTotal + transactionFee;
            
            // Calculate 3-split breakdown (total with fee divided by 3)
            const splitAmount = newTotal / 3;
            
            // Update amounts with proper formatting
            if (kokopayFeeAmount) kokopayFeeAmount.textContent = formatCurrency(transactionFee);
            if (orderTotalElement) orderTotalElement.textContent = formatCurrency(newTotal);
            
            // Update 3-split breakdown
            if (kokopaySplit1) kokopaySplit1.textContent = formatCurrency(splitAmount);
            if (kokopaySplit2) kokopaySplit2.textContent = formatCurrency(splitAmount);
            if (kokopaySplit3) kokopaySplit3.textContent = formatCurrency(splitAmount);
            
            console.log('Koko Pay selected - Transaction Fee: ' + formatCurrency(transactionFee) + ', New Total: ' + formatCurrency(newTotal));
            
        } else if (bankTransferRadio && bankTransferRadio.checked) {
            // Show Bank Transfer details
            if (bankTransferNotice) bankTransferNotice.style.display = 'block';
            
            // Reset to original total (no fees for bank transfer)
            if (orderTotalElement) orderTotalElement.textContent = formatCurrency(baseOrderTotal);
            
            console.log('Bank Transfer selected - No fees applied, Total: ' + formatCurrency(baseOrderTotal));
        } else {
            // Reset to original total for no selection
            if (orderTotalElement) orderTotalElement.textContent = formatCurrency(baseOrderTotal);
            
            console.log('No payment method selected - Total: ' + formatCurrency(baseOrderTotal));
        }
    }
    
    // Listen for payment method changes
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    paymentRadios.forEach(radio => {
        radio.addEventListener('change', updatePaymentFees);
    });
    
    // Initialize on page load
    updatePaymentFees();
    
    // Same as billing address functionality
    const sameAsBillingCheckbox = document.getElementById('same_as_billing');
    const shippingFields = document.getElementById('shipping-address-fields');
    
    console.log('Same as billing checkbox found:', sameAsBillingCheckbox ? 'Yes' : 'No');
    console.log('Shipping fields found:', shippingFields ? 'Yes' : 'No');
    
    // Initialize the shipping fields state based on default checkbox state
    if (sameAsBillingCheckbox && sameAsBillingCheckbox.checked) {
        console.log('Initializing: Same as billing is checked by default');
        // Disable shipping fields and set labels initially
        shippingFields.style.opacity = '0.5';
        shippingFields.style.pointerEvents = 'none';
        
        const shippingLine1Label = document.querySelector('label[for="shipping_address_line_1"]');
        const shippingCityLabel = document.querySelector('label[for="shipping_city"]');
        
        if (shippingLine1Label) {
            shippingLine1Label.innerHTML = 'Address Line 1 <span class="text-gray-500 text-xs">(Copied from billing address)</span>';
        }
        if (shippingCityLabel) {
            shippingCityLabel.innerHTML = 'City <span class="text-gray-500 text-xs">(Copied from billing address)</span>';
        }
    }
    
    sameAsBillingCheckbox.addEventListener('change', function() {
        console.log('Same as billing checkbox changed:', this.checked);
        
        if (this.checked) {
            // Copy billing address to shipping address
            const billingLine1 = document.getElementById('billing_address_line_1').value;
            const billingLine2 = document.getElementById('billing_address_line_2').value;
            const billingCity = document.getElementById('billing_city').value;
            const billingState = document.getElementById('billing_state').value;
            const billingPostal = document.getElementById('billing_postal_code').value;
            const billingCountry = document.getElementById('billing_country').value;
            
            console.log('Copying billing to shipping:', {
                line1: billingLine1,
                line2: billingLine2,
                city: billingCity,
                state: billingState,
                postal: billingPostal,
                country: billingCountry
            });
            
            document.getElementById('shipping_address_line_1').value = billingLine1;
            document.getElementById('shipping_address_line_2').value = billingLine2;
            document.getElementById('shipping_city').value = billingCity;
            document.getElementById('shipping_state').value = billingState;
            document.getElementById('shipping_postal_code').value = billingPostal;
            document.getElementById('shipping_country').value = billingCountry;
            
            // Update labels to show fields are not required when same as billing
            const shippingLine1Label = document.querySelector('label[for="shipping_address_line_1"]');
            const shippingCityLabel = document.querySelector('label[for="shipping_city"]');
            
            if (shippingLine1Label) {
                shippingLine1Label.innerHTML = 'Address Line 1 <span class="text-gray-500 text-xs">(Copied from billing address)</span>';
            }
            if (shippingCityLabel) {
                shippingCityLabel.innerHTML = 'City <span class="text-gray-500 text-xs">(Copied from billing address)</span>';
            }
            
            console.log('Shipping fields will use billing address - no validation needed');
            
            // Disable shipping fields
            shippingFields.style.opacity = '0.5';
            shippingFields.style.pointerEvents = 'none';
        } else {
            console.log('Enabling shipping fields - different from billing address');
            
            // Update labels to show fields are required when different from billing
            const shippingLine1Label = document.querySelector('label[for="shipping_address_line_1"]');
            const shippingCityLabel = document.querySelector('label[for="shipping_city"]');
            
            if (shippingLine1Label) {
                shippingLine1Label.innerHTML = 'Address Line 1 * <span class="text-red-400 text-xs">(Required)</span>';
            }
            if (shippingCityLabel) {
                shippingCityLabel.innerHTML = 'City * <span class="text-red-400 text-xs">(Required)</span>';
            }
            
            // Add required attribute to key shipping fields when user wants different shipping address
            const shippingAddressLine1 = document.getElementById('shipping_address_line_1');
            const shippingCity = document.getElementById('shipping_city');
            
            if (shippingAddressLine1) {
                shippingAddressLine1.setAttribute('required', '');
                console.log('Added required to shipping_address_line_1');
            }
            
            if (shippingCity) {
                shippingCity.setAttribute('required', '');
                console.log('Added required to shipping_city');
            }
            
            // Enable shipping fields
            shippingFields.style.opacity = '1';
            shippingFields.style.pointerEvents = 'auto';
        }
    });

    // Update shipping address when billing address changes (if same as billing is checked)
    const billingFields = ['billing_address_line_1', 'billing_address_line_2', 'billing_city', 'billing_state', 'billing_postal_code', 'billing_country'];
    billingFields.forEach(fieldId => {
        document.getElementById(fieldId).addEventListener('input', function() {
            if (sameAsBillingCheckbox.checked) {
                const shippingFieldId = fieldId.replace('billing_', 'shipping_');
                document.getElementById(shippingFieldId).value = this.value;
            }
        });
    });

    // Sri Lankan phone number validation
    const phoneInput = document.getElementById('customer_phone');
    console.log('Phone input found:', phoneInput ? 'Yes' : 'No');
    
    if (!phoneInput) {
        console.error('Phone input not found!');
        return;
    }
    
    const phonePattern = /^0[1-9][0-9]{8}$/;
    
    function validatePhoneNumber() {
        const phoneValue = phoneInput.value.trim();
        const isValid = phonePattern.test(phoneValue);
        
        if (phoneValue.length > 0 && !isValid) {
            phoneInput.setCustomValidity('Please enter a valid Sri Lankan phone number (10 digits starting with 0, e.g., 0771234567)');
            phoneInput.style.borderColor = '#ef4444';
        } else {
            phoneInput.setCustomValidity('');
            phoneInput.style.borderColor = '#374151';
        }
    }
    
    phoneInput.addEventListener('input', validatePhoneNumber);
    phoneInput.addEventListener('blur', validatePhoneNumber);
    
    // Format phone number as user types
    phoneInput.addEventListener('input', function() {
        // Remove any non-digit characters except for the initial input
        let value = this.value.replace(/[^\d]/g, '');
        
        // Ensure it starts with 0 and limit to 10 digits
        if (value.length > 0 && value[0] !== '0') {
            value = '0' + value;
        }
        if (value.length > 10) {
            value = value.substring(0, 10);
        }
        
        this.value = value;
    });

    // Debug form submission
    console.log('Setting up form submission handler...');
    
    if (!checkoutForm) {
        console.error('Checkout form not found! Cannot set up form submission handler.');
        return;
    }
    
    const submitButton = checkoutForm.querySelector('button[type="submit"]');
    console.log('Submit button found:', submitButton ? 'Yes' : 'No');
    
    if (!submitButton) {
        console.error('Submit button not found!');
        return;
    }
    
    // Add click event to submit button for debugging
    submitButton.addEventListener('click', function(e) {
        console.log('Submit button clicked!');
        console.log('Button disabled state:', submitButton.disabled);
        console.log('Form valid state:', checkoutForm.checkValidity());
        
        // Check form validity manually
        const invalidFields = [];
        const allFields = checkoutForm.querySelectorAll('input, select, textarea');
        allFields.forEach(field => {
            if (!field.checkValidity()) {
                invalidFields.push({
                    name: field.name || field.id,
                    type: field.type,
                    value: field.value,
                    validationMessage: field.validationMessage
                });
            }
        });
        
        if (invalidFields.length > 0) {
            console.log('Invalid fields found:', invalidFields);
        } else {
            console.log('All fields are valid');
        }
    });
    
    // Add form submit event
    checkoutForm.addEventListener('submit', function(e) {
        console.log('=== FORM SUBMISSION STARTED ===');
        console.log('Form action:', checkoutForm.action);
        console.log('Form method:', checkoutForm.method);
        
        // First check: Are there any HTML required fields that browser is validating?
        const htmlRequiredFields = checkoutForm.querySelectorAll('input[required], select[required], textarea[required]');
        console.log('HTML required fields found:', htmlRequiredFields.length);
        htmlRequiredFields.forEach(field => {
            console.log(`HTML Required: ${field.name || field.id} = "${field.value}" (Type: ${field.type})`);
        });
        
        // Smart validation: only check fields that are actually required based on form state
        let allValid = true;
        let missingFields = [];
        
        // Always required fields
        const alwaysRequiredFields = [
            'customer_name',
            'customer_phone', 
            'billing_address_line_1',
            'billing_city',
            'payment_method',
            'terms'
        ];
        
        console.log('Checking always required fields:', alwaysRequiredFields);
        
        // SIMPLIFIED: Disable complex validation temporarily for debugging
        console.log('🔥 SIMPLIFIED VALIDATION MODE - Checking basic requirements only');
        
        // Only check absolutely critical fields
        const criticalFieldsCheck = [
            {name: 'customer_name', required: true},
            {name: 'customer_phone', required: true},
            {name: 'billing_address_line_1', required: true},
            {name: 'billing_city', required: true},
            {name: 'terms', required: true, type: 'checkbox'},
            {name: 'payment_method', required: true, type: 'radio'}
        ];
        
        let criticalMissing = [];
        
        criticalFieldsCheck.forEach(field => {
            if (field.type === 'checkbox') {
                const element = document.querySelector(`[name="${field.name}"]`);
                if (!element || !element.checked) {
                    criticalMissing.push(field.name);
                }
            } else if (field.type === 'radio') {
                const radios = document.querySelectorAll(`[name="${field.name}"]`);
                const checked = Array.from(radios).some(radio => radio.checked);
                if (!checked) {
                    criticalMissing.push(field.name);
                }
            } else {
                const element = document.querySelector(`[name="${field.name}"]`);
                if (!element || !element.value.trim()) {
                    criticalMissing.push(field.name);
                }
            }
        });
        
        if (criticalMissing.length > 0) {
            console.log('❌ Critical fields missing:', criticalMissing);
            alert('Please fill in: ' + criticalMissing.join(', '));
            e.preventDefault();
            return false;
        }
        
        console.log('✅ All critical fields present, allowing submission');
        alwaysRequiredFields.forEach(fieldName => {
            if (fieldName === 'payment_method') {
                // Special handling for radio buttons
                const paymentRadios = document.querySelectorAll('[name="payment_method"]');
                const paymentSelected = Array.from(paymentRadios).some(radio => radio.checked);
                if (!paymentSelected) {
                    console.log('Missing required field:', fieldName, '(no radio button selected)');
                    missingFields.push(fieldName);
                    allValid = false;
                }
            } else if (fieldName === 'terms') {
                // Special handling for terms checkbox
                const termsField = document.querySelector('[name="terms"]');
                if (termsField && !termsField.checked) {
                    console.log('Missing required field:', fieldName, '(checkbox not checked)');
                    missingFields.push(fieldName);
                    allValid = false;
                }
            } else {
                // Regular text/email/tel fields
                const field = document.querySelector(`[name="${fieldName}"]`);
                if (field && (!field.value || !field.value.trim())) {
                    console.log('Missing required field:', fieldName, 'Value:', field.value);
                    missingFields.push(fieldName);
                    allValid = false;
                }
            }
        });
        
        // Check shipping fields only if "Same as billing address" is NOT checked
        const sameAsBilling = document.getElementById('same_as_billing');
        const shippingRequired = sameAsBilling && !sameAsBilling.checked;
        
        console.log('Same as billing checkbox found:', sameAsBilling ? 'Yes' : 'No');
        console.log('Same as billing checked:', sameAsBilling ? sameAsBilling.checked : 'N/A');
        console.log('Shipping fields required:', shippingRequired);
        
        if (shippingRequired) {
            console.log('Checking shipping fields (different from billing)...');
            const shippingRequiredFields = ['shipping_address_line_1', 'shipping_city'];
            
            shippingRequiredFields.forEach(fieldName => {
                const field = document.querySelector(`[name="${fieldName}"]`);
                if (field && (!field.value || !field.value.trim())) {
                    console.log('Missing required shipping field:', fieldName);
                    missingFields.push(fieldName);
                    allValid = false;
                }
            });
        } else {
            console.log('Skipping shipping field validation (same as billing address)');
        }
        
        console.log('Validation result - All valid:', allValid, 'Missing fields:', missingFields);
        
        if (!allValid) {
            console.log('=== VALIDATION FAILED ===');
            console.log('Missing required fields:', missingFields);
            
            // Create a more user-friendly error message
            let errorMessage = 'Please fill in the following required fields:\n\n';
            missingFields.forEach(field => {
                switch(field) {
                    case 'customer_name':
                        errorMessage += '• Full Name\n';
                        break;
                    case 'customer_phone':
                        errorMessage += '• Phone Number\n';
                        break;
                    case 'billing_address_line_1':
                        errorMessage += '• Billing Address Line 1\n';
                        break;
                    case 'billing_city':
                        errorMessage += '• Billing City\n';
                        break;
                    case 'payment_method':
                        errorMessage += '• Payment Method (select Credit/Debit Card, Koko Pay, or Bank Transfer)\n';
                        break;
                    case 'terms':
                        errorMessage += '• Terms of Service agreement (check the checkbox)\n';
                        break;
                    case 'shipping_address_line_1':
                        errorMessage += '• Shipping Address Line 1\n';
                        break;
                    case 'shipping_city':
                        errorMessage += '• Shipping City\n';
                        break;
                    default:
                        errorMessage += `• ${field}\n`;
                }
            });
            
            alert(errorMessage);
            e.preventDefault();
            return false;
        } else {
            console.log('=== VALIDATION PASSED ===');
        }
        
        // Disable submit button to prevent double submission
        submitButton.disabled = true;
        submitButton.textContent = 'Processing...';
        
        console.log('Form validation passed, submitting...');
        console.log('Form data being submitted...');
    });
});
</script>
@endsection