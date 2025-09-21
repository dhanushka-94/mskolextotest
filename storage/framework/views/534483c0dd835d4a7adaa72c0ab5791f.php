

<?php $__env->startSection('title', 'Order Details - ' . $order->order_number); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="<?php echo e(route('admin.orders.index')); ?>" 
               class="text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white"><?php echo e($order->order_number); ?></h1>
                <p class="text-gray-400">Order placed on <?php echo e($order->created_at->format('F d, Y \a\t g:i A')); ?></p>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="flex space-x-3">
            <a href="<?php echo e(route('orders.invoice', $order->order_number)); ?>" 
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
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?php echo e($order->status_badge); ?> mt-2">
                        <?php echo e(ucfirst($order->status)); ?>

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
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?php echo e($order->payment_status_badge); ?> mt-2">
                        <?php echo e(ucfirst(str_replace('_', ' ', $order->payment_status))); ?>

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
                    <p class="text-2xl font-bold text-[#f59e0b] mt-1">LKR <?php echo e(number_format($order->total_amount, 2)); ?></p>
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
                    <p class="text-2xl font-bold text-white mt-1"><?php echo e($order->orderItems->count()); ?></p>
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
            
            <form action="<?php echo e(route('admin.orders.update-status', $order)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="space-y-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Order Status</label>
                        <select id="status" name="status" required
                                class="w-full px-4 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                            <option value="pending" <?php echo e($order->status === 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="confirmed" <?php echo e($order->status === 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                            <option value="processing" <?php echo e($order->status === 'processing' ? 'selected' : ''); ?>>Processing</option>
                            <option value="shipped" <?php echo e($order->status === 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                            <option value="delivered" <?php echo e($order->status === 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                            <option value="cancelled" <?php echo e($order->status === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                            <option value="refunded" <?php echo e($order->status === 'refunded' ? 'selected' : ''); ?>>Refunded</option>
                        </select>
                    </div>

                    <div id="shipping-fields" style="<?php echo e($order->status === 'shipped' ? '' : 'display: none;'); ?>">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="tracking_number" class="block text-sm font-medium text-gray-300 mb-2">Tracking Number</label>
                                <input type="text" 
                                       id="tracking_number" 
                                       name="tracking_number" 
                                       value="<?php echo e(old('tracking_number', $order->tracking_number)); ?>"
                                       class="w-full px-4 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                            </div>
                            <div>
                                <label for="courier_service" class="block text-sm font-medium text-gray-300 mb-2">Courier Service</label>
                                <input type="text" 
                                       id="courier_service" 
                                       name="courier_service" 
                                       value="<?php echo e(old('courier_service', $order->courier_service)); ?>"
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
                                  class="w-full px-4 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b]"><?php echo e(old('admin_notes', $order->admin_notes)); ?></textarea>
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
            
            <form action="<?php echo e(route('admin.orders.update-payment', $order)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="space-y-4">
                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-300 mb-2">Payment Status</label>
                        <select id="payment_status" name="payment_status" required
                                class="w-full px-4 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                            <option value="pending" <?php echo e($order->payment_status === 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="paid" <?php echo e($order->payment_status === 'paid' ? 'selected' : ''); ?>>Paid</option>
                            <option value="failed" <?php echo e($order->payment_status === 'failed' ? 'selected' : ''); ?>>Failed</option>
                            <option value="refunded" <?php echo e($order->payment_status === 'refunded' ? 'selected' : ''); ?>>Refunded</option>
                        </select>
                    </div>

                    <div>
                        <label for="payment_reference" class="block text-sm font-medium text-gray-300 mb-2">Payment Reference</label>
                        <input type="text" 
                               id="payment_reference" 
                               name="payment_reference" 
                               value="<?php echo e(old('payment_reference', $order->payment_reference)); ?>"
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
                <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="px-6 py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 w-16 h-16 bg-gray-800 rounded-lg overflow-hidden">
                                <img src="<?php echo e($item->product_image_url); ?>" 
                                     alt="<?php echo e($item->product_name); ?>" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white font-medium"><?php echo e($item->product_name); ?></h4>
                                <?php if($item->product_code): ?>
                                    <p class="text-sm text-gray-400">Code: <?php echo e($item->product_code); ?></p>
                                <?php endif; ?>
                                <p class="text-sm text-gray-400">Quantity: <?php echo e($item->quantity); ?> × LKR <?php echo e(number_format($item->unit_price, 2)); ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-medium text-white">LKR <?php echo e(number_format($item->total_price, 2)); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Order Summary -->
            <div class="px-6 py-4 border-t border-gray-800 bg-gray-800/20">
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Subtotal</span>
                        <span class="text-white">LKR <?php echo e(number_format($order->subtotal, 2)); ?></span>
                    </div>
                    <?php if($order->shipping_cost > 0): ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Shipping</span>
                            <span class="text-white">LKR <?php echo e(number_format($order->shipping_cost, 2)); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if($order->tax_amount > 0): ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Tax</span>
                            <span class="text-white">LKR <?php echo e(number_format($order->tax_amount, 2)); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="border-t border-gray-700 pt-2">
                        <div class="flex justify-between font-medium">
                            <span class="text-white">Total</span>
                            <span class="text-[#f59e0b] text-lg">LKR <?php echo e(number_format($order->total_amount, 2)); ?></span>
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
                
                <?php if($order->user): ?>
                    <div class="flex items-center space-x-3 mb-4">
                        <img class="w-10 h-10 rounded-full" src="<?php echo e($order->user->avatar_url); ?>" alt="<?php echo e($order->user->name); ?>">
                        <div>
                            <p class="text-white font-medium"><?php echo e($order->user->name); ?></p>
                            <p class="text-sm text-gray-400">Registered Customer</p>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="text-gray-400">Name:</span>
                        <span class="text-white ml-2"><?php echo e($order->customer_name); ?></span>
                    </div>
                    <div>
                        <span class="text-gray-400">Email:</span>
                        <span class="text-white ml-2"><?php echo e($order->customer_email); ?></span>
                    </div>
                    <div>
                        <span class="text-gray-400">Phone:</span>
                        <span class="text-white ml-2"><?php echo e($order->customer_phone); ?></span>
                    </div>
                    <div>
                        <span class="text-gray-400">Payment Method:</span>
                        <span class="text-white ml-2"><?php echo e(ucfirst(str_replace('_', ' ', $order->payment_method))); ?></span>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-medium text-white mb-4">Shipping Address</h3>
                <div class="text-sm text-gray-300">
                    <p class="text-white font-medium"><?php echo e($order->customer_name); ?></p>
                    <p><?php echo e($order->shipping_address_line_1); ?></p>
                    <?php if($order->shipping_address_line_2): ?>
                        <p><?php echo e($order->shipping_address_line_2); ?></p>
                    <?php endif; ?>
                    <p><?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_state); ?> <?php echo e($order->shipping_postal_code); ?></p>
                    <p><?php echo e($order->shipping_country); ?></p>
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
                            <span class="text-gray-400 block"><?php echo e($order->created_at->format('M d, Y \a\t g:i A')); ?></span>
                        </div>
                    </div>
                    <?php if($order->shipped_at): ?>
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-blue-400 rounded-full"></div>
                            <div class="text-sm">
                                <span class="text-white font-medium">Shipped</span>
                                <span class="text-gray-400 block"><?php echo e($order->shipped_at->format('M d, Y \a\t g:i A')); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($order->delivered_at): ?>
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                            <div class="text-sm">
                                <span class="text-white font-medium">Delivered</span>
                                <span class="text-gray-400 block"><?php echo e($order->delivered_at->format('M d, Y \a\t g:i A')); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
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
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\admin\orders\show.blade.php ENDPATH**/ ?>