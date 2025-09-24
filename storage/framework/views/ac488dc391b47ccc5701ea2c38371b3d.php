

<?php $__env->startSection('title', 'User Details - ' . $user->name); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white">User Details</h1>
            <p class="text-gray-400 mt-1">Viewing <?php echo e($user->name); ?>'s profile</p>
        </div>
        <div class="flex space-x-3">
            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg transition-colors">
                <i class="fas fa-edit mr-2"></i>Edit User
            </a>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Users
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Profile -->
        <div class="lg:col-span-1">
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="text-center">
                    <img class="h-32 w-32 rounded-full mx-auto object-cover mb-4" 
                         src="<?php echo e($user->avatar_url); ?>" 
                         alt="<?php echo e($user->name); ?>">
                    <h3 class="text-xl font-semibold text-white"><?php echo e($user->name); ?></h3>
                    <p class="text-gray-400"><?php echo e($user->email); ?></p>
                    
                    <div class="flex justify-center space-x-4 mt-4">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                            <?php echo e($user->role === 'admin' ? 'bg-purple-100 text-purple-800' : ''); ?>

                            <?php echo e($user->role === 'customer' ? 'bg-blue-100 text-blue-800' : ''); ?>

                            <?php echo e($user->role === 'staff' ? 'bg-green-100 text-green-800' : ''); ?>">
                            <?php echo e(ucfirst($user->role)); ?>

                        </span>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                            <?php echo e($user->status === 'active' ? 'bg-green-100 text-green-800' : ''); ?>

                            <?php echo e($user->status === 'inactive' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                            <?php echo e($user->status === 'banned' ? 'bg-red-100 text-red-800' : ''); ?>">
                            <?php echo e(ucfirst($user->status)); ?>

                        </span>
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Phone</label>
                        <p class="text-white"><?php echo e($user->phone ?: 'Not provided'); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Date of Birth</label>
                        <p class="text-white"><?php echo e($user->date_of_birth ? $user->date_of_birth->format('M d, Y') : 'Not provided'); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Gender</label>
                        <p class="text-white"><?php echo e($user->gender ? ucfirst($user->gender) : 'Not specified'); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Member Since</label>
                        <p class="text-white"><?php echo e($user->created_at->format('M d, Y')); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Last Login</label>
                        <p class="text-white"><?php echo e($user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Statistics & Orders -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-800 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-shopping-cart text-2xl text-blue-400"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-400">Total Orders</p>
                            <p class="text-2xl font-semibold text-white"><?php echo e($userStats['total_orders']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-800 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-dollar-sign text-2xl text-green-400"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-400">Total Spent</p>
                            <p class="text-2xl font-semibold text-white">Rs. <?php echo e(number_format($userStats['total_spent'], 2)); ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-800 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-chart-line text-2xl text-yellow-400"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-400">Avg Order</p>
                            <p class="text-2xl font-semibold text-white">Rs. <?php echo e(number_format($userStats['average_order'] ?? 0, 2)); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-gray-800 rounded-lg">
                <div class="px-6 py-4 border-b border-gray-700">
                    <h3 class="text-lg font-medium text-white">Recent Orders</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                            <?php $__empty_1 = true; $__currentLoopData = $user->orders->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-white">#<?php echo e($order->order_number); ?></div>
                                        <div class="text-sm text-gray-400"><?php echo e($order->orderItems->count()); ?> items</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                        Rs. <?php echo e(number_format($order->total_amount, 2)); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            <?php echo e($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                                            <?php echo e($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : ''); ?>

                                            <?php echo e($order->status === 'shipped' ? 'bg-purple-100 text-purple-800' : ''); ?>

                                            <?php echo e($order->status === 'delivered' ? 'bg-green-100 text-green-800' : ''); ?>

                                            <?php echo e($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : ''); ?>">
                                            <?php echo e(ucfirst($order->status)); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                        <?php echo e($order->created_at->format('M d, Y')); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="<?php echo e(route('admin.orders.show', $order)); ?>" 
                                           class="text-blue-400 hover:text-blue-300">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                        <i class="fas fa-shopping-cart text-3xl mb-3"></i>
                                        <p>No orders yet</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- User Addresses -->
            <?php if($user->addresses->count() > 0): ?>
                <div class="bg-gray-800 rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-700">
                        <h3 class="text-lg font-medium text-white">Saved Addresses</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php $__currentLoopData = $user->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-gray-700 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-medium text-white"><?php echo e(ucfirst($address->type)); ?> Address</h4>
                                        <?php if($address->is_default): ?>
                                            <span class="bg-primary-500 text-white text-xs px-2 py-1 rounded">Default</span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-sm text-gray-300"><?php echo e($address->name); ?></p>
                                    <p class="text-sm text-gray-300"><?php echo e($address->address_line_1); ?></p>
                                    <?php if($address->address_line_2): ?>
                                        <p class="text-sm text-gray-300"><?php echo e($address->address_line_2); ?></p>
                                    <?php endif; ?>
                                    <p class="text-sm text-gray-300"><?php echo e($address->city); ?>, <?php echo e($address->state); ?> <?php echo e($address->postal_code); ?></p>
                                    <p class="text-sm text-gray-300"><?php echo e($address->country); ?></p>
                                    <?php if($address->contact_phone): ?>
                                        <p class="text-sm text-gray-400 mt-2"><?php echo e($address->contact_phone); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views/admin/users/show.blade.php ENDPATH**/ ?>