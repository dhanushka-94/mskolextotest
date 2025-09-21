

<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    
    <!-- Page Header -->
    <div>
        <h1 class="text-3xl font-bold text-white mb-2">Dashboard</h1>
        <p class="text-gray-400">Welcome to the MSK Computers admin panel</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Orders -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Total Orders</p>
                    <p class="text-3xl font-bold text-white"><?php echo e(number_format($stats['total_orders'])); ?></p>
                    <p class="text-sm text-green-400">+<?php echo e($stats['weekly_orders']); ?> this week</p>
                </div>
                <div class="p-3 bg-blue-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Pending Orders</p>
                    <p class="text-3xl font-bold text-white"><?php echo e(number_format($stats['pending_orders'])); ?></p>
                    <p class="text-sm text-yellow-400">Requires attention</p>
                </div>
                <div class="p-3 bg-yellow-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Total Customers</p>
                    <p class="text-3xl font-bold text-white"><?php echo e(number_format($stats['total_customers'])); ?></p>
                    <p class="text-sm text-green-400">Active users</p>
                </div>
                <div class="p-3 bg-green-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Total Revenue</p>
                    <p class="text-3xl font-bold text-white">LKR <?php echo e(number_format($stats['total_revenue'], 2)); ?></p>
                    <p class="text-sm text-[#f59e0b]">LKR <?php echo e(number_format($stats['monthly_revenue'], 2)); ?> this month</p>
                </div>
                <div class="p-3 bg-[#f59e0b]/20 rounded-lg">
                    <svg class="w-8 h-8 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Data -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Sales Chart -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <h3 class="text-lg font-medium text-white mb-4">Monthly Sales (Last 6 Months)</h3>
            <div class="h-64">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Order Status Distribution -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <h3 class="text-lg font-medium text-white mb-4">Order Status Distribution</h3>
            <div class="h-64">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Orders and Top Products -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent Orders -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-white">Recent Orders</h3>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-[#f59e0b] hover:text-[#d97706] text-sm font-medium transition-colors">
                        View All
                    </a>
                </div>
            </div>
            
            <?php if($recentOrders->count() > 0): ?>
                <div class="divide-y divide-gray-800">
                    <?php $__currentLoopData = $recentOrders->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="px-6 py-4 hover:bg-gray-800/30 transition-colors">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-white"><?php echo e($order->order_number); ?></p>
                                    <p class="text-sm text-gray-400"><?php echo e($order->customer_name); ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-white"><?php echo e($order->formatted_total); ?></p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($order->status_badge); ?>">
                                        <?php echo e(ucfirst($order->status)); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="px-6 py-8 text-center">
                    <p class="text-gray-400">No orders yet</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Top Products -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800">
                <h3 class="text-lg font-medium text-white">Top Selling Products</h3>
            </div>
            
            <?php if($topProducts->count() > 0): ?>
                <div class="divide-y divide-gray-800">
                    <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-white truncate"><?php echo e($product->product_name); ?></p>
                                </div>
                                <div class="text-right ml-4">
                                    <p class="text-sm font-medium text-[#f59e0b]"><?php echo e($product->total_sold); ?> sold</p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="px-6 py-8 text-center">
                    <p class="text-gray-400">No sales data yet</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Customers -->
    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-white">Recent Customers</h3>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="text-[#f59e0b] hover:text-[#d97706] text-sm font-medium transition-colors">
                    View All
                </a>
            </div>
        </div>
        
        <?php if($recentCustomers->count() > 0): ?>
            <div class="divide-y divide-gray-800">
                <?php $__currentLoopData = $recentCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="px-6 py-4 hover:bg-gray-800/30 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img class="w-8 h-8 rounded-full" src="<?php echo e($customer->avatar_url); ?>" alt="<?php echo e($customer->name); ?>">
                                <div>
                                    <p class="text-sm font-medium text-white"><?php echo e($customer->name); ?></p>
                                    <p class="text-sm text-gray-400"><?php echo e($customer->email); ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-400"><?php echo e($customer->created_at->format('M d, Y')); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="px-6 py-8 text-center">
                <p class="text-gray-400">No customers yet</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Sales Chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
const salesData = <?php echo json_encode($monthlySales, 15, 512) ?>;

new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: salesData.map(item => `${item.year}-${String(item.month).padStart(2, '0')}`),
        datasets: [{
            label: 'Revenue (LKR)',
            data: salesData.map(item => item.total),
            borderColor: '#f59e0b',
            backgroundColor: 'rgba(245, 158, 11, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    color: '#ffffff'
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#9ca3af',
                    callback: function(value) {
                        return 'LKR ' + value.toLocaleString();
                    }
                },
                grid: {
                    color: '#374151'
                }
            },
            x: {
                ticks: {
                    color: '#9ca3af'
                },
                grid: {
                    color: '#374151'
                }
            }
        }
    }
});

// Order Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusData = <?php echo json_encode($orderStatusData, 15, 512) ?>;

new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: Object.keys(statusData).map(status => status.charAt(0).toUpperCase() + status.slice(1)),
        datasets: [{
            data: Object.values(statusData),
            backgroundColor: [
                '#f59e0b', // pending
                '#3b82f6', // confirmed
                '#8b5cf6', // processing
                '#06b6d4', // shipped
                '#10b981', // delivered
                '#ef4444', // cancelled
                '#6b7280'  // refunded
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: '#ffffff',
                    padding: 20
                }
            }
        }
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>