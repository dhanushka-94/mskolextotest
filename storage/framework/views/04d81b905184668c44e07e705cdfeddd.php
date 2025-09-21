

<?php $__env->startSection('title', 'My Orders - MSK COMPUTERS'); ?>
<?php $__env->startSection('description', 'View and track your MSK Computers orders, download invoices, and manage your purchase history.'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-[#0f0f0f] py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">My Orders</h1>
                <p class="text-gray-400">Track and manage your order history</p>
            </div>
            <a href="<?php echo e(route('user.dashboard')); ?>" 
               class="inline-flex items-center text-[#f59e0b] hover:text-[#d97706] transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-gradient-to-r from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6 mb-8">
            <form method="GET" action="<?php echo e(route('user.orders')); ?>" class="flex flex-wrap items-center gap-4">
                <!-- Search -->
                <div class="flex-1 min-w-64">
                    <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Search Orders</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="<?php echo e(request('search')); ?>"
                           placeholder="Search by order number..."
                           class="w-full px-4 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                    <select id="status" 
                            name="status"
                            class="px-4 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="confirmed" <?php echo e(request('status') === 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                        <option value="processing" <?php echo e(request('status') === 'processing' ? 'selected' : ''); ?>>Processing</option>
                        <option value="shipped" <?php echo e(request('status') === 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                        <option value="delivered" <?php echo e(request('status') === 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                        <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="flex items-end">
                    <button type="submit" 
                            class="px-6 py-2 bg-[#f59e0b] text-black rounded-lg hover:bg-[#d97706] transition-colors font-medium">
                        Filter
                    </button>
                    <?php if(request()->hasAny(['search', 'status'])): ?>
                        <a href="<?php echo e(route('user.orders')); ?>" 
                           class="ml-2 px-4 py-2 border border-gray-700 text-gray-300 rounded-lg hover:bg-gray-800 transition-colors">
                            Clear
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Orders List -->
        <?php if($orders->count() > 0): ?>
            <div class="space-y-6">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 overflow-hidden">
                        <!-- Order Header -->
                        <div class="px-6 py-4 border-b border-gray-800">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <h3 class="text-lg font-medium text-white"><?php echo e($order->order_number); ?></h3>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?php echo e($order->status_badge); ?>">
                                        <?php echo e(ucfirst($order->status)); ?>

                                    </span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?php echo e($order->payment_status_badge); ?>">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $order->payment_status))); ?>

                                    </span>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-medium text-white"><?php echo e($order->formatted_total); ?></p>
                                    <p class="text-sm text-gray-400"><?php echo e($order->created_at->format('M d, Y')); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items Preview -->
                        <div class="px-6 py-4">
                            <div class="flex items-center space-x-4 mb-4">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <span class="text-sm text-gray-400">
                                    <?php echo e($order->orderItems->count()); ?> <?php echo e(Str::plural('item', $order->orderItems->count())); ?>

                                </span>
                                <?php if($order->shipping_address): ?>
                                    <span class="text-gray-500">•</span>
                                    <span class="text-sm text-gray-400"><?php echo e($order->shipping_city); ?></span>
                                <?php endif; ?>
                            </div>

                            <!-- Item List -->
                            <div class="space-y-2">
                                <?php $__currentLoopData = $order->orderItems->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center space-x-3 text-sm">
                                        <div class="w-8 h-8 bg-gray-800 rounded flex items-center justify-center">
                                            <span class="text-xs text-gray-400"><?php echo e($item->quantity); ?>x</span>
                                        </div>
                                        <span class="flex-1 text-gray-300"><?php echo e($item->product_name); ?></span>
                                        <span class="text-white font-medium"><?php echo e($item->formatted_total_price); ?></span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($order->orderItems->count() > 3): ?>
                                    <div class="text-sm text-gray-400">
                                        + <?php echo e($order->orderItems->count() - 3); ?> more items
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Order Actions -->
                        <div class="px-6 py-4 border-t border-gray-800 bg-gray-800/20">
                            <div class="flex items-center justify-between">
                                <div class="flex space-x-3">
                                    <a href="<?php echo e(route('user.orders.detail', $order->order_number)); ?>" 
                                       class="text-[#f59e0b] hover:text-[#d97706] text-sm font-medium transition-colors">
                                        View Details
                                    </a>
                                    <?php if($order->status === 'delivered'): ?>
                                        <form action="<?php echo e(route('user.orders.reorder', $order)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" 
                                                    class="text-[#f59e0b] hover:text-[#d97706] text-sm font-medium transition-colors">
                                                Reorder
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <a href="<?php echo e(route('orders.invoice', $order->order_number)); ?>" 
                                       class="text-gray-400 hover:text-white text-sm font-medium transition-colors">
                                        Download Invoice
                                    </a>
                                </div>
                                
                                <?php if($order->canBeCancelled()): ?>
                                    <form action="<?php echo e(route('user.orders.cancel', $order)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to cancel this order?')"
                                                class="text-red-400 hover:text-red-300 text-sm font-medium transition-colors">
                                            Cancel Order
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <?php echo e($orders->appends(request()->query())->links('custom.pagination')); ?>

            </div>

        <?php else: ?>
            <!-- Empty State -->
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <h3 class="text-lg font-medium text-white mb-2">No orders found</h3>
                <?php if(request()->hasAny(['search', 'status'])): ?>
                    <p class="text-gray-400 mb-6">Try adjusting your search criteria or filters</p>
                    <a href="<?php echo e(route('user.orders')); ?>" 
                       class="inline-flex items-center px-4 py-2 border border-gray-700 text-gray-300 rounded-lg hover:bg-gray-800 transition-colors">
                        Clear Filters
                    </a>
                <?php else: ?>
                    <p class="text-gray-400 mb-6">You haven't placed any orders yet</p>
                    <a href="<?php echo e(route('home')); ?>" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-black bg-[#f59e0b] hover:bg-[#d97706] transition-colors">
                        Start Shopping
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\user\orders.blade.php ENDPATH**/ ?>