

<?php $__env->startSection('title', 'My Dashboard - MSK COMPUTERS'); ?>
<?php $__env->startSection('description', 'Manage your MSK Computers account, track orders, update profile, and view your purchase history.'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-[#0f0f0f] py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="bg-gradient-to-r from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6 mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <img class="h-16 w-16 rounded-full border-2 border-[#f59e0b] object-cover" 
                         src="<?php echo e($user->avatar_url); ?>" 
                         alt="<?php echo e($user->name); ?>">
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-white">Welcome back, <?php echo e($user->name); ?>!</h1>
                    <p class="text-gray-400">Manage your account and track your orders</p>
                </div>
                <div class="flex-shrink-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-900/30 text-green-300 border border-green-800">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                        </svg>
                        Active Account
                    </span>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-md bg-[#f59e0b]/20">
                            <svg class="h-5 w-5 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-400 truncate">Total Orders</dt>
                            <dd class="text-lg font-medium text-white"><?php echo e($orderStats['total']); ?></dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-md bg-yellow-500/20">
                            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-400 truncate">Pending Orders</dt>
                            <dd class="text-lg font-medium text-white"><?php echo e($orderStats['pending']); ?></dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-md bg-green-500/20">
                            <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-400 truncate">Completed</dt>
                            <dd class="text-lg font-medium text-white"><?php echo e($orderStats['completed']); ?></dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-md bg-[#f59e0b]/20">
                            <svg class="h-5 w-5 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-400 truncate">Total Spent</dt>
                            <dd class="text-lg font-medium text-white">LKR <?php echo e(number_format($totalSpent, 2)); ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Recent Orders -->
            <div class="lg:col-span-2">
                <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-800">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-white">Recent Orders</h3>
                            <a href="<?php echo e(route('user.orders')); ?>" class="text-[#f59e0b] hover:text-[#d97706] text-sm font-medium transition-colors">
                                View All Orders
                            </a>
                        </div>
                    </div>
                    
                    <?php if($recentOrders->count() > 0): ?>
                        <div class="divide-y divide-gray-800">
                            <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="p-6 hover:bg-gray-800/30 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3">
                                                <p class="text-sm font-medium text-white"><?php echo e($order->order_number); ?></p>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($order->status_badge); ?>">
                                                    <?php echo e(ucfirst($order->status)); ?>

                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-400 mt-1">
                                                <?php echo e($order->orderItems->count()); ?> <?php echo e(Str::plural('item', $order->orderItems->count())); ?> • 
                                                <?php echo e($order->created_at->format('M d, Y')); ?>

                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-white"><?php echo e($order->formatted_total); ?></p>
                                            <a href="<?php echo e(route('user.orders.detail', $order->order_number)); ?>" 
                                               class="text-xs text-[#f59e0b] hover:text-[#d97706] transition-colors">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="p-6 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-300">No orders yet</h3>
                            <p class="mt-1 text-sm text-gray-400">Start shopping to see your orders here.</p>
                            <div class="mt-6">
                                <a href="<?php echo e(route('home')); ?>" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-black bg-[#f59e0b] hover:bg-[#d97706] transition-colors">
                                    Start Shopping
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Actions & Account Info -->
            <div class="space-y-6">
                
                <!-- Quick Actions -->
                <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                    <h3 class="text-lg font-medium text-white mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="<?php echo e(route('user.orders')); ?>" 
                           class="flex items-center p-3 rounded-lg bg-gray-800/30 hover:bg-gray-800/50 transition-colors group">
                            <svg class="h-5 w-5 text-[#f59e0b] group-hover:text-[#d97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <span class="ml-3 text-sm font-medium text-gray-300 group-hover:text-white">View All Orders</span>
                        </a>
                        
                        <a href="<?php echo e(route('user.addresses')); ?>" 
                           class="flex items-center p-3 rounded-lg bg-gray-800/30 hover:bg-gray-800/50 transition-colors group">
                            <svg class="h-5 w-5 text-[#f59e0b] group-hover:text-[#d97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            <span class="ml-3 text-sm font-medium text-gray-300 group-hover:text-white">Manage Addresses</span>
                        </a>
                        
                        <a href="<?php echo e(route('user.profile')); ?>" 
                           class="flex items-center p-3 rounded-lg bg-gray-800/30 hover:bg-gray-800/50 transition-colors group">
                            <svg class="h-5 w-5 text-[#f59e0b] group-hover:text-[#d97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="ml-3 text-sm font-medium text-gray-300 group-hover:text-white">Update Profile</span>
                        </a>
                        
                        <a href="<?php echo e(route('orders.track')); ?>" 
                           class="flex items-center p-3 rounded-lg bg-gray-800/30 hover:bg-gray-800/50 transition-colors group">
                            <svg class="h-5 w-5 text-[#f59e0b] group-hover:text-[#d97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            <span class="ml-3 text-sm font-medium text-gray-300 group-hover:text-white">Track Order</span>
                        </a>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                    <h3 class="text-lg font-medium text-white mb-4">Account Information</h3>
                    <div class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-400">Email</dt>
                            <dd class="mt-1 text-sm text-white"><?php echo e($user->email); ?></dd>
                        </div>
                        <?php if($user->phone): ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-400">Phone</dt>
                                <dd class="mt-1 text-sm text-white"><?php echo e($user->phone); ?></dd>
                            </div>
                        <?php endif; ?>
                        <div>
                            <dt class="text-sm font-medium text-gray-400">Member Since</dt>
                            <dd class="mt-1 text-sm text-white"><?php echo e($user->created_at->format('F Y')); ?></dd>
                        </div>
                        <?php if($user->last_login_at): ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-400">Last Login</dt>
                                <dd class="mt-1 text-sm text-white"><?php echo e($user->last_login_at->diffForHumans()); ?></dd>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\user\dashboard.blade.php ENDPATH**/ ?>