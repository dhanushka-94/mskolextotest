<?php $__env->startSection('title', 'Complete Your Secure Payment - MSK Computers'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-dark-900 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Payment Progress Header -->
        <div class="mb-8">
            <!-- Progress Steps -->
            <div class="flex items-center justify-center space-x-4 mb-6">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-black" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-300">Order Details</span>
                </div>
                
                <div class="w-16 h-px bg-primary-500"></div>
                
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center ring-4 ring-primary-500/20">
                        <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <span class="ml-2 text-sm font-medium text-white">Secure Payment</span>
                </div>
                
                <div class="w-16 h-px bg-gray-600"></div>
                
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-500">Confirmation</span>
                </div>
            </div>
            
            <!-- Header Content -->
            <div class="text-center">
                <div class="flex items-center justify-center space-x-6 mb-6">
                    <div class="flex items-center space-x-3">
                        <img src="<?php echo e(asset('msk-computers-logo-color.png')); ?>" alt="MSK Computers" class="w-12 h-12">
                        <div class="text-left">
                            <div class="text-lg font-bold text-white">MSK Computers</div>
                            <div class="text-xs text-gray-400">Secure Checkout</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-px bg-gradient-to-r from-primary-500 to-purple-500"></div>
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <div class="w-8 h-px bg-gradient-to-r from-purple-500 to-primary-500"></div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-r from-purple-600 to-blue-600 p-2 rounded-lg shadow-lg">
                            <img src="<?php echo e(asset('images/kokopay-logo.png')); ?>" alt="Koko Pay" class="h-8 brightness-0 invert">
                        </div>
                        <div class="text-left">
                            <div class="text-lg font-bold text-white">Koko Pay</div>
                            <div class="text-xs text-purple-400">Buy Now, Pay Later</div>
                        </div>
                    </div>
                </div>
                
                <h1 class="text-3xl font-bold text-white mb-2">Complete Your Secure Payment</h1>
                <p class="text-gray-400 max-w-2xl mx-auto">Review your order details and complete payment through Koko Pay's secure Buy Now, Pay Later service. Split your payment into 3 easy installments with industry-standard security.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6 sticky top-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Order Summary
                        </h2>
                        <div class="bg-purple-500/10 text-purple-400 text-xs font-medium px-2 py-1 rounded-full">
                            BNPL Processing
                        </div>
                    </div>

                    <!-- Customer & Order Info -->
                    <div class="space-y-3 mb-6">
                        <div class="bg-dark-800/50 rounded-lg p-4 space-y-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400">Order #</span>
                                <span class="font-mono text-purple-400 font-medium"><?php echo e($order->order_number); ?></span>
                            </div>
                            
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400">Customer</span>
                                <span class="text-gray-200"><?php echo e($order->customer_name); ?></span>
                            </div>
                            
                            <?php if($order->customer_email): ?>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400">Email</span>
                                <span class="text-gray-200"><?php echo e($order->customer_email); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400">Phone</span>
                                <span class="text-gray-200"><?php echo e($order->customer_phone); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="space-y-3 mb-6">
                        <h3 class="text-sm font-medium text-gray-300 uppercase tracking-wider">Items Ordered</h3>
                        <div class="space-y-3">
                            <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-start space-x-3 p-3 bg-dark-800/30 rounded-lg">
                                <div class="w-10 h-10 bg-dark-700 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-white font-medium text-sm truncate"><?php echo e($item->product_name); ?></p>
                                    <p class="text-gray-400 text-xs"><?php echo e($item->quantity); ?> × LKR <?php echo e(number_format($item->unit_price, 2)); ?></p>
                                </div>
                                <div class="text-purple-400 font-semibold text-sm">
                                    LKR <?php echo e(number_format($item->total_price, 2)); ?>

                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Enhanced Pricing Breakdown -->
                    <div class="border-t border-gray-700 pt-4 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Subtotal</span>
                            <span class="text-gray-200">LKR <?php echo e(number_format($originalSubtotal > 0 ? $originalSubtotal : $subtotal, 2)); ?></span>
                        </div>
                        
                        <!-- Discount Section -->
                        <?php if($totalDiscount > 0): ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-green-400">
                                Discount
                                <span class="text-xs text-gray-500 block">You save</span>
                            </span>
                            <span class="text-green-400">-LKR <?php echo e(number_format($totalDiscount, 2)); ?></span>
                        </div>
                        
                        <!-- Subtotal after discount -->
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Subtotal (after discount)</span>
                            <span class="text-gray-200">LKR <?php echo e(number_format($subtotal, 2)); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Shipping Information -->
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Shipping</span>
                            <span class="text-amber-400 text-xs">
                                Pay on delivery
                            </span>
                        </div>
                        
                        <!-- Transaction Fee -->
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">
                                Transaction Fee (10%)
                                <span class="text-xs text-purple-400 block">Koko Pay processing</span>
                            </span>
                            <span class="text-purple-400">LKR <?php echo e(number_format($transactionFee, 2)); ?></span>
                        </div>
                        
                        <div class="border-t border-gray-600 pt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-white">Total (with fee)</span>
                                <span class="text-xl font-bold text-purple-400">LKR <?php echo e(number_format($totalWithFee, 2)); ?></span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">+ Shipping charges on delivery</p>
                        </div>
                    </div>
                    
                    <!-- BNPL Payment Breakdown -->
                    <div class="mt-6 p-4 bg-gradient-to-r from-purple-900/30 to-blue-900/30 border border-purple-700/50 rounded-lg">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-purple-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-purple-400 font-medium text-sm">Your Payment Plan</h4>
                                <div class="mt-2 space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-white font-medium">Today</span>
                                        <span class="text-purple-300 font-semibold">LKR <?php echo e(number_format($totalWithFee / 3, 2)); ?></span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-300">In 30 days</span>
                                        <span class="text-gray-300">LKR <?php echo e(number_format($totalWithFee / 3, 2)); ?></span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-300">In 60 days</span>
                                        <span class="text-gray-300">LKR <?php echo e(number_format($totalWithFee / 3, 2)); ?></span>
                                    </div>
                                </div>
                                <p class="text-purple-300 text-xs mt-2">
                                    ✓ No hidden fees • ✓ Automatic payments
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Enhanced Shipping Notice -->
                    <div class="mt-4 p-4 bg-amber-900/20 border border-amber-700/50 rounded-lg">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-amber-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h4 class="text-amber-400 font-medium text-sm">Shipping & Delivery</h4>
                                <p class="text-amber-300 text-sm mt-1">
                                    Kindly note that delivery charges are due at the time of parcel receipt.
                                </p>
                                <p class="text-amber-300 text-xs mt-1">
                                    පාර්සලය ලැබුණු අවස්ථාවේදී බෙදා හැරීමේ ගාස්තු ගෙවිය යුතු බව කරුණාවෙන් සලකන්න.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Security Badge -->
                    <div class="mt-4 p-3 bg-green-900/20 border border-green-700/50 rounded-lg">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <div>
                                <p class="text-green-400 text-xs font-medium">SSL Encrypted</p>
                                <p class="text-green-300 text-xs">Your data is secure</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Koko Pay Payment Form -->
                <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-white">Payment Details</h3>
                        <div class="text-xs text-gray-400">All fields are pre-filled from your order</div>
                    </div>

                    <form action="<?php echo e($apiUrl); ?>" method="POST" id="kokopay-form" class="space-y-6">
                        <?php echo csrf_field(); ?>
                        
                        <!-- Hidden Fields for Koko Pay -->
                        <?php $__currentLoopData = $paymentData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        <!-- Customer Details Section -->
                        <div class="space-y-4">
                            <h4 class="text-sm font-medium text-gray-300 uppercase tracking-wider">Customer Information</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">
                                        First Name
                                        <span class="text-purple-400 text-xs">(Pre-filled)</span>
                                    </label>
                                    <div class="w-full bg-[#0f0f0f] border border-gray-700 text-white px-4 py-3 rounded-lg">
                                        <?php echo e($paymentData['_firstName']); ?>

                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">
                                        Last Name
                                        <span class="text-purple-400 text-xs">(Pre-filled)</span>
                                    </label>
                                    <div class="w-full bg-[#0f0f0f] border border-gray-700 text-white px-4 py-3 rounded-lg">
                                        <?php echo e($paymentData['_lastName'] ?: 'Not provided'); ?>

                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Email Address
                                    <span class="text-purple-400 text-xs">(Pre-filled)</span>
                                </label>
                                <div class="w-full bg-[#0f0f0f] border border-gray-700 text-white px-4 py-3 rounded-lg">
                                    <?php echo e($paymentData['_email']); ?>

                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Mobile Number
                                    <span class="text-purple-400 text-xs">(Pre-filled)</span>
                                </label>
                                <div class="w-full bg-[#0f0f0f] border border-gray-700 text-white px-4 py-3 rounded-lg">
                                    <?php echo e($paymentData['_mobileNo'] ?: 'Not provided'); ?>

                                </div>
                            </div>
                        </div>

                        <!-- BNPL Information Section -->
                        <div class="bg-gradient-to-r from-purple-900/20 to-blue-900/20 rounded-lg p-6 border border-purple-700/30">
                            <h4 class="text-purple-400 font-semibold text-lg mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                                How Koko Pay Works
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="text-center p-4 bg-purple-800/20 rounded-lg">
                                    <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <span class="text-white font-bold">1</span>
                                    </div>
                                    <h5 class="text-white font-medium text-sm mb-1">Pay Today</h5>
                                    <p class="text-purple-300 text-xs">LKR <?php echo e(number_format($totalWithFee / 3, 2)); ?></p>
                                    <p class="text-gray-400 text-xs mt-1">Immediate payment</p>
                                </div>
                                
                                <div class="text-center p-4 bg-blue-800/20 rounded-lg">
                                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <span class="text-white font-bold">2</span>
                                    </div>
                                    <h5 class="text-white font-medium text-sm mb-1">30 Days Later</h5>
                                    <p class="text-blue-300 text-xs">LKR <?php echo e(number_format($totalWithFee / 3, 2)); ?></p>
                                    <p class="text-gray-400 text-xs mt-1">Automatic payment</p>
                                </div>
                                
                                <div class="text-center p-4 bg-green-800/20 rounded-lg">
                                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <span class="text-white font-bold">3</span>
                                    </div>
                                    <h5 class="text-white font-medium text-sm mb-1">60 Days Later</h5>
                                    <p class="text-green-300 text-xs">LKR <?php echo e(number_format($totalWithFee / 3, 2)); ?></p>
                                    <p class="text-gray-400 text-xs mt-1">Final payment</p>
                                </div>
                            </div>
                            
                            <div class="mt-4 p-4 bg-purple-900/30 rounded-lg">
                                <div class="flex items-center space-x-2 text-purple-300 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>No hidden fees</span>
                                </div>
                                <div class="flex items-center space-x-2 text-purple-300 text-sm mt-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Easy payment plan</span>
                                </div>
                                <div class="flex items-center space-x-2 text-purple-300 text-sm mt-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Automatic payment reminders</span>
                                </div>
                            </div>
                        </div>

                        <!-- Final Security Notice -->
                        <div class="bg-blue-900/20 border border-blue-700/50 rounded-lg p-4">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h4 class="text-blue-400 font-medium text-sm">Payment Processing Notice</h4>
                                    <p class="text-blue-300 text-sm mt-1">
                                        By clicking "Complete Payment", you will be securely redirected to Koko Pay's payment gateway. 
                                        Your information is encrypted and protected throughout the BNPL process.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            <button type="submit" 
                                    class="flex-1 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold py-5 px-8 rounded-xl hover:from-purple-700 hover:to-blue-700 transition-all duration-300 flex items-center justify-center group shadow-2xl shadow-purple-500/25 ring-2 ring-purple-500/20 hover:ring-purple-400/40 hover:shadow-purple-500/40 transform hover:scale-105 hover:-translate-y-1">
                                <svg class="w-6 h-6 mr-3 group-hover:scale-125 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                                <div class="text-center">
                                    <div class="text-lg">💳 Complete BNPL Payment</div>
                                    <div class="text-sm font-semibold">LKR <?php echo e(number_format($totalWithFee, 2)); ?></div>
                                </div>
                            </button>
                            
                            <a href="<?php echo e(route('checkout.index')); ?>" 
                               class="sm:w-auto px-6 py-4 bg-dark-700 border border-gray-600 text-gray-300 font-semibold rounded-lg hover:bg-dark-600 transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Back to Checkout
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Payment Gateway Info -->
                <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                            Koko Pay Information
                        </h2>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-green-400 text-sm font-medium">Secure Connection</span>
                        </div>
                    </div>

                    <!-- Payment Gateway Security Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="flex items-center space-x-3 p-4 bg-dark-800/50 rounded-lg">
                            <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-medium text-sm">256-bit SSL</p>
                                <p class="text-gray-400 text-xs">Bank-level security</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3 p-4 bg-dark-800/50 rounded-lg">
                            <div class="w-10 h-10 bg-purple-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-medium text-sm">BNPL Verified</p>
                                <p class="text-gray-400 text-xs">BNPL certified</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3 p-4 bg-dark-800/50 rounded-lg">
                            <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-medium text-sm">Instant Approval</p>
                                <p class="text-gray-400 text-xs">Real-time processing</p>
                            </div>
                        </div>
                    </div>

                    <!-- BNPL Features -->
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-300 uppercase tracking-wider mb-4">Koko Pay Features</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="flex items-center space-x-2 p-3 bg-dark-800/30 rounded-lg">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-300 text-sm font-medium">Easy Payments</span>
                            </div>
                            
                            <div class="flex items-center space-x-2 p-3 bg-dark-800/30 rounded-lg">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-gray-300 text-sm font-medium">3 Easy Payments</span>
                            </div>
                            
                            <div class="flex items-center space-x-2 p-3 bg-dark-800/30 rounded-lg">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5l-5-5h5v-5a7.5 7.5 0 01-7.5-7.5h10a7.5 7.5 0 01-7.5 7.5v5z"/>
                                </svg>
                                <span class="text-gray-300 text-sm font-medium">Auto Payments</span>
                            </div>
                            
                            <div class="flex items-center space-x-2 p-3 bg-dark-800/30 rounded-lg">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span class="text-gray-300 text-sm font-medium">Secure & Trusted</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trust & Support Information -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Customer Support -->
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Need Help?
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span class="text-gray-300">24/7 Customer Support</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-gray-300">Instant BNPL Approval</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span class="text-gray-300">Payment Reminders via SMS</span>
                    </div>
                </div>
            </div>

            <!-- Security Assurance -->
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Security Promise
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span class="text-gray-300">Your data is never stored on our servers</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6.506-6.506a1.25 1.25 0 00-1.768 0L10.5 8.732l-.732.732m8.486-8.486L16.5 2.732m1.768 1.768L16.5 6.268"/>
                        </svg>
                        <span class="text-gray-300">Encrypted transmission to Koko Pay</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-gray-300">BNPL industry compliance</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kokopayForm = document.getElementById('kokopay-form');
    const submitBtn = kokopayForm.querySelector('button[type="submit"]');
    
    // Form submission handler
    kokopayForm.addEventListener('submit', function(e) {
        // Prevent multiple submissions
        if (submitBtn.disabled) {
            e.preventDefault();
            return false;
        }
        
        // Update button state
        const originalContent = submitBtn.innerHTML;
        submitBtn.innerHTML = `
            <svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Connecting to Koko Pay...
        `;
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-75');
        
        // Show processing message
        const processingMsg = document.createElement('div');
        processingMsg.className = 'mt-4 p-3 bg-purple-900/20 border border-purple-700/50 rounded-lg';
        processingMsg.innerHTML = `
            <div class="flex items-center space-x-2">
                <div class="w-2 h-2 bg-purple-400 rounded-full animate-pulse"></div>
                <span class="text-purple-300 text-sm">Securely redirecting to Koko Pay BNPL gateway...</span>
            </div>
        `;
        kokopayForm.appendChild(processingMsg);
        
        // Timeout fallback (in case redirect fails)
        setTimeout(() => {
            if (!document.hidden) {
                submitBtn.innerHTML = originalContent;
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-75');
                processingMsg.remove();
                
                // Show error message
                const errorMsg = document.createElement('div');
                errorMsg.className = 'mt-4 p-3 bg-red-900/20 border border-red-700/50 rounded-lg';
                errorMsg.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-red-300 text-sm">Redirect taking longer than expected. Please try again.</span>
                    </div>
                `;
                kokopayForm.appendChild(errorMsg);
                
                setTimeout(() => errorMsg.remove(), 5000);
            }
        }, 15000);
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\payment\kokopay.blade.php ENDPATH**/ ?>