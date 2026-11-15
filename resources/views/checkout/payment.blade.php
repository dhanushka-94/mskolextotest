@extends('layouts.app')

@section('title', 'Checkout Payment - MSK Computers')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#0f0f0f] via-[#1a1a1c] to-[#0f0f0f] py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center space-x-2 text-green-400 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                <h1 class="text-3xl font-bold text-white">Secure Checkout</h1>
            </div>
            <p class="text-gray-300">Complete your purchase with secure payment</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-900/20 border border-red-700/50 rounded-lg p-4 mb-6">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-red-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h4 class="text-red-400 font-medium text-sm mb-2">Please fix the following errors:</h4>
                        <ul class="text-red-300 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="payment-form" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Payment Form -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Customer Information -->
                    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Customer Information</span>
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-300 mb-2">
                                    First Name *
                                </label>
                                <input type="text" 
                                       id="first_name" 
                                       name="first_name" 
                                       value="{{ old('first_name', Auth::user() ? explode(' ', Auth::user()->name)[0] : '') }}" 
                                       required
                                       placeholder="Enter your first name"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                            
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-300 mb-2">
                                    Last Name *
                                </label>
                                <input type="text" 
                                       id="last_name" 
                                       name="last_name" 
                                       value="{{ old('last_name', Auth::user() && str_contains(Auth::user()->name, ' ') ? substr(Auth::user()->name, strpos(Auth::user()->name, ' ') + 1) : '') }}" 
                                       required
                                       placeholder="Enter your last name"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-gray-300 mb-2">
                                    Phone Number *
                                </label>
                                <input type="tel" 
                                       id="customer_phone" 
                                       name="customer_phone" 
                                       value="{{ old('customer_phone', Auth::user()->phone ?? '') }}" 
                                       required
                                       placeholder="Enter your phone number"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                            
                            <div>
                                <label for="customer_email" class="block text-sm font-medium text-gray-300 mb-2">
                                    Email Address *
                                </label>
                                <input type="email" 
                                       id="customer_email" 
                                       name="customer_email" 
                                       value="{{ old('customer_email', Auth::user()->email ?? '') }}" 
                                       required
                                       placeholder="Enter your email address"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Billing Address</span>
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="billing_address_line_1" class="block text-sm font-medium text-gray-300 mb-2">
                                    Address Line 1 *
                                </label>
                                <input type="text" 
                                       id="billing_address_line_1" 
                                       name="billing_address_line_1" 
                                       value="{{ old('billing_address_line_1') }}" 
                                       required
                                       placeholder="Enter your street address"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="billing_city" class="block text-sm font-medium text-gray-300 mb-2">
                                        City *
                                    </label>
                                    <input type="text" 
                                           id="billing_city" 
                                           name="billing_city" 
                                           value="{{ old('billing_city') }}" 
                                           required
                                           placeholder="Enter your city"
                                           class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                                
                                <div>
                                    <label for="billing_state" class="block text-sm font-medium text-gray-300 mb-2">
                                        State/Province
                                    </label>
                                    <input type="text" 
                                           id="billing_state" 
                                           name="billing_state" 
                                           value="{{ old('billing_state') }}" 
                                           placeholder="Enter your state"
                                           class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                                
                                <div>
                                    <label for="billing_postal_code" class="block text-sm font-medium text-gray-300 mb-2">
                                        Postal Code
                                    </label>
                                    <input type="text" 
                                           id="billing_postal_code" 
                                           name="billing_postal_code" 
                                           value="{{ old('billing_postal_code') }}" 
                                           placeholder="Enter postal code"
                                           class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-white flex items-center space-x-2">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                <span>Shipping Address</span>
                            </h3>
                        </div>
                        
                        <!-- Different Shipping Address Checkbox -->
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       id="different_shipping_address" 
                                       name="different_shipping_address"
                                       class="h-4 w-4 text-green-500 focus:ring-green-500 border-gray-700 rounded bg-[#0f0f0f]"
                                       onchange="toggleShippingAddress()">
                                <span class="ml-3 text-sm text-gray-300">
                                    Ship to a different address
                                </span>
                            </label>
                            <p class="text-xs text-gray-400 mt-1 ml-7">
                                By default, we'll ship to your billing address
                            </p>
                        </div>
                        
                        <!-- Shipping Address Fields (Hidden by default) -->
                        <div id="shipping-address-fields" class="space-y-4" style="display: none;">
                            <div>
                                <label for="shipping_address_line_1" class="block text-sm font-medium text-gray-300 mb-2">
                                    Address Line 1 *
                                </label>
                                <input type="text" 
                                       id="shipping_address_line_1" 
                                       name="shipping_address_line_1" 
                                       value="{{ old('shipping_address_line_1') }}" 
                                       placeholder="Enter shipping street address"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="shipping_city" class="block text-sm font-medium text-gray-300 mb-2">
                                        City *
                                    </label>
                                    <input type="text" 
                                           id="shipping_city" 
                                           name="shipping_city" 
                                           value="{{ old('shipping_city') }}" 
                                           placeholder="Enter shipping city"
                                           class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                                
                                <div>
                                    <label for="shipping_state" class="block text-sm font-medium text-gray-300 mb-2">
                                        State/Province
                                    </label>
                                    <input type="text" 
                                           id="shipping_state" 
                                           name="shipping_state" 
                                           value="{{ old('shipping_state') }}" 
                                           placeholder="Enter shipping state"
                                           class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                                
                                <div>
                                    <label for="shipping_postal_code" class="block text-sm font-medium text-gray-300 mb-2">
                                        Postal Code
                                    </label>
                                    <input type="text" 
                                           id="shipping_postal_code" 
                                           name="shipping_postal_code" 
                                           value="{{ old('shipping_postal_code') }}" 
                                           placeholder="Enter shipping postal code"
                                           class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <span>Payment Method</span>
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- Bank Transfer -->
                            <label class="flex items-center p-4 border border-gray-700 rounded-lg hover:border-green-400 transition-colors cursor-pointer">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="bank_transfer"
                                       checked
                                       class="h-4 w-4 text-green-500 focus:ring-green-500 border-gray-700 bg-[#0f0f0f]">
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center space-x-2">
                                        <div class="text-sm font-medium text-white">Bank Transfer</div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-500 text-white">
                            Most Popular
                        </span>
                                    </div>
                                    <div class="text-sm text-gray-400">Direct bank transfer • No transaction fees</div>
                                </div>
                                <div class="flex items-center space-x-2 text-green-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m11 0a2 2 0 01-2 2H7a2 2 0 01-2-2m14 0V9a2 2 0 00-2-2M9 7h6m-6 4h6m-6 4h6m-6 4h6"/>
                                    </svg>
                                </div>
                            </label>

                            <!-- WebXPay -->
                            <label class="flex items-center p-4 border border-gray-700 rounded-lg hover:border-primary-400 transition-colors cursor-pointer">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="webxpay"
                                       class="h-4 w-4 text-primary-500 focus:ring-primary-500 border-gray-700 bg-[#0f0f0f]">
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center space-x-2">
                                        <div class="text-sm font-medium text-white">Credit/Debit Card</div>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-500 text-black">
                                            Instant
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-400">Visa, MasterCard, American Express • 3% transaction fee</div>
                                </div>
                                <div class="flex items-center space-x-2 text-primary-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                </div>
                            </label>

                            <!-- KokoPay -->
                            <label class="flex items-center p-4 border border-gray-700 rounded-lg hover:border-purple-400 transition-colors cursor-pointer">
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
                                    <div class="text-sm text-gray-400">Split into 3 easy payments • 10% transaction fee</div>
                                </div>
                                <div class="flex items-center space-x-2 text-purple-400">
                                    <img src="{{ asset('images/kokopay-logo.png') }}" alt="Koko Pay" class="h-6 w-auto">
                                </div>
                            </label>
                        </div>
                        
                        <!-- Bank Transfer Details (shown when bank transfer is selected) -->
                        <div id="bank-transfer-details" class="mt-6 bg-gradient-to-br from-green-900/20 to-green-800/20 border border-green-700/50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-white mb-4 flex items-center space-x-2">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m11 0a2 2 0 01-2 2H7a2 2 0 01-2-2m14 0V9a2 2 0 00-2-2M9 7h6m-6 4h6m-6 4h6m-6 4h6"/>
                                </svg>
                                <span>Bank Transfer Details</span>
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="bg-[#0f0f0f] rounded-lg p-4">
                                    <div class="space-y-3">
                                        <div>
                                            <div class="text-gray-400 mb-1">Bank Name:</div>
                                            <div class="text-white font-medium">Commercial Bank</div>
                                        </div>
                                        <div>
                                            <div class="text-gray-400 mb-1">Account Name:</div>
                                            <div class="text-white font-medium">MSK Computers</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-[#0f0f0f] rounded-lg p-4">
                                    <div class="space-y-3">
                                        <div>
                                            <div class="text-gray-400 mb-1">Account Number:</div>
                                            <div class="text-white font-medium">1000578810</div>
                                        </div>
                                        <div>
                                            <div class="text-gray-400 mb-1">Branch:</div>
                                            <div class="text-white font-medium">Ragama Branch</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-2 text-sm mb-6">
                                <p class="text-green-300 font-medium">
                                    💡 <strong>Instructions:</strong>
                                </p>
                                <ul class="text-gray-300 space-y-1 ml-4">
                                    <li>• Transfer the exact amount to the above bank account</li>
                                    <li>• Use your order number as the reference</li>
                                    <li>• After order confirmation, send your slip via <strong>WhatsApp</strong> or <strong>email</strong> with your order number</li>
                                    <li>• We'll confirm your payment within 24 hours</li>
                                </ul>
                            </div>
                            
                            <!-- Transfer slip reminder (send via WhatsApp / email after order) -->
                            <div class="bg-[#1a1a1c] rounded-lg p-4 border border-gray-700">
                                <p class="text-sm font-medium text-gray-200 mb-2">
                                    Send Transfer Slip After Order Confirmation
                                </p>
                                <p class="text-xs text-gray-400 mb-3">
                                    On the next page, you can send your slip via WhatsApp or email with the order number for faster verification.
                                    Optional: attach a slip here now (JPG, PNG, PDF — max 2MB).
                                </p>
                                <input type="file" 
                                       name="transfer_slip" 
                                       id="transfer_slip"
                                       accept="image/*,application/pdf"
                                       class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-600 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-600 file:text-white hover:file:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 12H6L5 9z"/>
                            </svg>
                            <span>Order Summary</span>
                        </h3>
                        
                        <!-- Cart Items will be loaded here -->
                        <div id="cart-items-summary" class="space-y-3 mb-6">
                            <div class="text-center py-4">
                                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-green-400 mx-auto"></div>
                                <p class="text-gray-400 text-sm mt-2">Loading cart items...</p>
                            </div>
                        </div>
                        
                        <!-- Detailed Pricing Breakdown -->
                        <div class="border-t border-gray-700 pt-4 space-y-3">
                            <!-- Subtotal -->
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Subtotal:</span>
                                <span class="text-white" id="subtotal-amount">LKR 0.00</span>
                            </div>
                            
                            <!-- Discount (if any) -->
                            <div class="flex justify-between text-sm" id="discount-row" style="display: none;">
                                <span class="text-green-400">Discount:</span>
                                <span class="text-green-400" id="discount-amount">-LKR 0.00</span>
                            </div>
                            
                            <!-- Subtotal after discount -->
                            <div class="flex justify-between text-sm" id="subtotal-after-discount-row" style="display: none;">
                                <span class="text-gray-400">Subtotal (after discount):</span>
                                <span class="text-white" id="subtotal-after-discount-amount">LKR 0.00</span>
                            </div>
                            
                            <!-- Shipping -->
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Shipping:</span>
                                <span class="text-amber-400 text-xs">Pay on delivery</span>
                            </div>
                            
                            <!-- Transaction Fee (dynamic based on payment method) -->
                            <div class="flex justify-between text-sm" id="transaction-fee-row" style="display: none;">
                                <span class="text-yellow-400" id="transaction-fee-label">Transaction Fee:</span>
                                <span class="text-yellow-400" id="transaction-fee-amount">+LKR 0.00</span>
                            </div>
                            
                            <!-- Order Total -->
                            <div class="border-t border-gray-600 pt-3 mt-3">
                                <div class="flex justify-between items-center text-lg font-bold">
                                    <span class="text-white">Order Total:</span>
                                    <span class="text-green-400" id="total-amount">LKR 0.00</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Terms and Conditions -->
                        <div class="border-t border-gray-700 pt-4 mt-4">
                            <label class="flex items-start">
                                <input type="checkbox" 
                                       name="terms" 
                                       required
                                       checked
                                       class="h-4 w-4 text-green-500 focus:ring-green-500 border-gray-700 rounded bg-[#0f0f0f] mt-0.5">
                                <span class="ml-3 text-xs text-gray-300">
                                    I agree to the <a href="{{ route('terms-of-service') }}" target="_blank" class="text-green-400 hover:text-green-300 underline">Terms of Service</a> and 
                                    <a href="{{ route('privacy-policy') }}" target="_blank" class="text-green-400 hover:text-green-300 underline">Privacy Policy</a> *
                                </span>
                            </label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full mt-6 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 12H6L5 9z"/>
                            </svg>
                            Complete Order
                        </button>
                        
                        <!-- Back Link -->
                        <div class="mt-4 text-center">
                            <a href="{{ route('checkout.index') }}" class="text-gray-400 hover:text-green-400 text-sm transition-colors">
                                ← Back to options
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadCartSummary();
});

function loadCartSummary() {
    fetch('/cart/summary')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayCartItems(data.items);
                updatePricingBreakdown(data);
            }
        })
        .catch(error => {
            console.error('Error loading cart summary:', error);
            document.getElementById('cart-items-summary').innerHTML = '<p class="text-red-400 text-sm">Error loading cart items</p>';
        });
}

function updatePricingBreakdown(cartData) {
    const subtotal = cartData.total;
    const originalSubtotal = cartData.original_total || subtotal;
    const discount = cartData.total_discount || 0;
    
    // Update subtotal
    document.getElementById('subtotal-amount').textContent = 'LKR ' + originalSubtotal.toLocaleString('en-US', {minimumFractionDigits: 2});
    
    // Show/hide discount rows
    if (discount > 0) {
        document.getElementById('discount-row').style.display = 'flex';
        document.getElementById('subtotal-after-discount-row').style.display = 'flex';
        document.getElementById('discount-amount').textContent = '-LKR ' + discount.toLocaleString('en-US', {minimumFractionDigits: 2});
        document.getElementById('subtotal-after-discount-amount').textContent = 'LKR ' + subtotal.toLocaleString('en-US', {minimumFractionDigits: 2});
    } else {
        document.getElementById('discount-row').style.display = 'none';
        document.getElementById('subtotal-after-discount-row').style.display = 'none';
    }
    
    // Calculate and update transaction fee based on selected payment method
    updateTransactionFee(subtotal);
}

function updateTransactionFee(subtotal) {
    const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked');
    const transactionFeeRow = document.getElementById('transaction-fee-row');
    const transactionFeeLabel = document.getElementById('transaction-fee-label');
    const transactionFeeAmount = document.getElementById('transaction-fee-amount');
    const totalAmountElement = document.getElementById('total-amount');
    
    let transactionFee = 0;
    let feeLabel = 'Transaction Fee:';
    
    if (selectedPaymentMethod) {
        switch (selectedPaymentMethod.value) {
            case 'kokopay':
                transactionFee = subtotal * 0.10; // 10% for KOKO
                feeLabel = 'Transaction Fee (10%):';
                break;
            case 'webxpay':
                transactionFee = subtotal * 0.03; // 3% for Card Payments
                feeLabel = 'Transaction Fee (3%):';
                break;
            case 'bank_transfer':
            default:
                transactionFee = 0; // No fee for bank transfer
                break;
        }
    }
    
    // Show/hide transaction fee row
    if (transactionFee > 0) {
        transactionFeeRow.style.display = 'flex';
        transactionFeeLabel.textContent = feeLabel;
        transactionFeeAmount.textContent = '+LKR ' + transactionFee.toLocaleString('en-US', {minimumFractionDigits: 2});
    } else {
        transactionFeeRow.style.display = 'none';
    }
    
    // Update total amount
    const totalAmount = subtotal + transactionFee;
    totalAmountElement.textContent = 'LKR ' + totalAmount.toLocaleString('en-US', {minimumFractionDigits: 2});
}

function displayCartItems(items) {
    const container = document.getElementById('cart-items-summary');
    
    if (items.length === 0) {
        container.innerHTML = '<p class="text-gray-400 text-sm">No items in cart</p>';
        return;
    }
    
    let html = '';
    items.forEach(item => {
        html += `
            <div class="flex justify-between items-start text-sm">
                <div class="flex-1">
                    <p class="text-white font-medium">${item.name}</p>
                    <p class="text-gray-400">Qty: ${item.quantity}</p>
                </div>
                <div class="text-green-400 font-medium">
                    LKR ${item.total.toLocaleString('en-US', {minimumFractionDigits: 2})}
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

// Payment method handling
function handlePaymentMethodChange() {
    const bankTransferRadio = document.querySelector('input[name="payment_method"][value="bank_transfer"]');
    const bankTransferDetails = document.getElementById('bank-transfer-details');
    
    // Show/hide bank transfer details based on selection
    if (bankTransferRadio && bankTransferRadio.checked) {
        bankTransferDetails.style.display = 'block';
    } else {
        bankTransferDetails.style.display = 'none';
    }
    
    // Recalculate transaction fee when payment method changes
    const subtotalElement = document.getElementById('subtotal-after-discount-amount') || document.getElementById('subtotal-amount');
    if (subtotalElement) {
        const subtotalText = subtotalElement.textContent.replace('LKR ', '').replace(/,/g, '');
        const subtotal = parseFloat(subtotalText);
        if (!isNaN(subtotal)) {
            updateTransactionFee(subtotal);
        }
    }
}

// Shipping address toggle function
function toggleShippingAddress() {
    const checkbox = document.getElementById('different_shipping_address');
    const shippingFields = document.getElementById('shipping-address-fields');
    const shippingInputs = shippingFields.querySelectorAll('input');
    
    if (checkbox.checked) {
        // Show shipping address fields
        shippingFields.style.display = 'block';
        // Make shipping address fields required
        shippingInputs.forEach(input => {
            if (input.name.includes('address_line_1') || input.name.includes('city')) {
                input.required = true;
            }
        });
    } else {
        // Hide shipping address fields
        shippingFields.style.display = 'none';
        // Remove required attribute from shipping fields
        shippingInputs.forEach(input => {
            input.required = false;
            input.value = ''; // Clear the values
        });
    }
}

// Initialize payment method handling
document.addEventListener('DOMContentLoaded', function() {
    // Handle payment method changes
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    paymentRadios.forEach(radio => {
        radio.addEventListener('change', handlePaymentMethodChange);
    });
    
    // Initialize on page load
    handlePaymentMethodChange();
    
    // Form validation
    const form = document.getElementById('payment-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const termsCheckbox = document.querySelector('input[name="terms"]');
            if (!termsCheckbox.checked) {
                e.preventDefault();
                alert('Please accept the Terms of Service and Privacy Policy to continue.');
                return false;
            }
        });
    }
});
</script>
@endsection

