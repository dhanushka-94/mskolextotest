

<?php $__env->startSection('title', 'Analytics Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white">Analytics Dashboard</h1>
            <p class="text-gray-400 mt-1">Sales performance and business insights</p>
        </div>
        <div class="flex space-x-3">
            <!-- Period Filter -->
            <form method="GET" action="<?php echo e(route('admin.analytics')); ?>" class="flex items-center space-x-2">
                <select name="period" onchange="this.form.submit()" 
                        class="bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary-500">
                    <option value="7" <?php echo e($period == '7' ? 'selected' : ''); ?>>Last 7 Days</option>
                    <option value="30" <?php echo e($period == '30' ? 'selected' : ''); ?>>Last 30 Days</option>
                    <option value="90" <?php echo e($period == '90' ? 'selected' : ''); ?>>Last 90 Days</option>
                    <option value="365" <?php echo e($period == '365' ? 'selected' : ''); ?>>Last Year</option>
                </select>
            </form>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Revenue -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Total Revenue</p>
                    <p class="text-2xl font-bold">Rs. <?php echo e(number_format($revenueData->sum('revenue'), 2)); ?></p>
                    <p class="text-green-100 text-sm mt-1">Last <?php echo e($period); ?> days</p>
                </div>
                <div class="text-green-200">
                    <i class="fas fa-dollar-sign text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Orders</p>
                    <p class="text-2xl font-bold"><?php echo e(number_format($revenueData->sum('orders'))); ?></p>
                    <p class="text-blue-100 text-sm mt-1">Last <?php echo e($period); ?> days</p>
                </div>
                <div class="text-blue-200">
                    <i class="fas fa-shopping-cart text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Average Order Value -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Avg Order Value</p>
                    <?php
                        $totalOrders = $revenueData->sum('orders');
                        $avgOrder = $totalOrders > 0 ? $revenueData->sum('revenue') / $totalOrders : 0;
                    ?>
                    <p class="text-2xl font-bold">Rs. <?php echo e(number_format($avgOrder, 2)); ?></p>
                    <p class="text-purple-100 text-sm mt-1">Per order</p>
                </div>
                <div class="text-purple-200">
                    <i class="fas fa-chart-line text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- New Customers -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm">New Customers</p>
                    <p class="text-2xl font-bold"><?php echo e($customerInsights['new_customers']); ?></p>
                    <p class="text-yellow-100 text-sm mt-1">Last <?php echo e($period); ?> days</p>
                </div>
                <div class="text-yellow-200">
                    <i class="fas fa-users text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="bg-gray-800 rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-white">Revenue Trends</h3>
            <div class="text-sm text-gray-400">Last <?php echo e($period); ?> days</div>
        </div>
        
        <!-- Simple Chart -->
        <div class="h-64 bg-gray-700 rounded-lg flex items-end justify-between p-4 space-x-1">
            <?php if($revenueData->count() > 0): ?>
                <?php
                    $maxRevenue = $revenueData->max('revenue');
                    $chartData = $revenueData->take(20); // Show last 20 days for better visibility
                ?>
                <?php $__currentLoopData = $chartData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $height = $maxRevenue > 0 ? ($data->revenue / $maxRevenue) * 100 : 0;
                    ?>
                    <div class="flex flex-col items-center group">
                        <div class="bg-primary-500 rounded-t group-hover:bg-primary-400 transition-colors relative"
                             style="height: <?php echo e(max($height, 5)); ?>%; width: 20px;"
                             title="Date: <?php echo e($data->date); ?>, Revenue: Rs. <?php echo e(number_format($data->revenue, 2)); ?>">
                        </div>
                        <div class="text-xs text-gray-400 mt-2 transform -rotate-45 origin-left">
                            <?php echo e(\Carbon\Carbon::parse($data->date)->format('M d')); ?>

                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="w-full text-center text-gray-400">
                    <i class="fas fa-chart-bar text-4xl mb-4"></i>
                    <p>No revenue data available for the selected period</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Products -->
        <div class="bg-gray-800 rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-white">Top Selling Products</h3>
                <span class="text-sm text-gray-400">Last <?php echo e($period); ?> days</span>
            </div>
            
            <?php if($productPerformance->count() > 0): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $productPerformance->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                    <?php echo e($index + 1); ?>

                                </div>
                                <div>
                                    <p class="text-white font-medium"><?php echo e($product->product_name); ?></p>
                                    <p class="text-gray-400 text-sm"><?php echo e($product->total_sold); ?> units sold</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-white font-semibold">Rs. <?php echo e(number_format($product->revenue, 2)); ?></p>
                                <p class="text-gray-400 text-sm">Revenue</p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center text-gray-400 py-8">
                    <i class="fas fa-box text-4xl mb-4"></i>
                    <p>No product sales data available</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Customer Insights -->
        <div class="bg-gray-800 rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-white">Customer Insights</h3>
                <span class="text-sm text-gray-400">Last <?php echo e($period); ?> days</span>
            </div>
            
            <div class="space-y-6">
                <!-- New vs Returning Customers -->
                <div class="bg-gray-700 rounded-lg p-4">
                    <h4 class="text-white font-medium mb-3">Customer Types</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300">New Customers</span>
                            <span class="text-white font-semibold"><?php echo e($customerInsights['new_customers']); ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300">Repeat Customers</span>
                            <span class="text-white font-semibold"><?php echo e($customerInsights['repeat_customers']); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Customer Acquisition Rate -->
                <div class="bg-gray-700 rounded-lg p-4">
                    <h4 class="text-white font-medium mb-3">Growth Metrics</h4>
                    <div class="space-y-3">
                        <?php
                            $totalCustomers = $customerInsights['new_customers'] + $customerInsights['repeat_customers'];
                            $newCustomerRate = $totalCustomers > 0 ? ($customerInsights['new_customers'] / $totalCustomers) * 100 : 0;
                            $repeatRate = $totalCustomers > 0 ? ($customerInsights['repeat_customers'] / $totalCustomers) * 100 : 0;
                        ?>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300">New Customer Rate</span>
                            <span class="text-green-400 font-semibold"><?php echo e(number_format($newCustomerRate, 1)); ?>%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300">Repeat Purchase Rate</span>
                            <span class="text-blue-400 font-semibold"><?php echo e(number_format($repeatRate, 1)); ?>%</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="pt-4">
                    <h4 class="text-white font-medium mb-3">Quick Actions</h4>
                    <div class="space-y-2">
                        <a href="<?php echo e(route('admin.orders.index')); ?>" 
                           class="block w-full text-center bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-list mr-2"></i>View All Orders
                        </a>
                        <a href="<?php echo e(route('admin.users.index')); ?>" 
                           class="block w-full text-center bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-users mr-2"></i>Manage Customers
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Insights -->
    <div class="bg-gray-800 rounded-lg p-6">
        <h3 class="text-xl font-semibold text-white mb-6">Business Summary</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-primary-400">
                    Rs. <?php echo e(number_format($revenueData->avg('revenue'), 2)); ?>

                </div>
                <div class="text-gray-400 mt-1">Average Daily Revenue</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-400">
                    <?php echo e(number_format($revenueData->avg('orders'), 1)); ?>

                </div>
                <div class="text-gray-400 mt-1">Average Daily Orders</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-400">
                    <?php echo e($productPerformance->count()); ?>

                </div>
                <div class="text-gray-400 mt-1">Products Sold</div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-refresh every 5 minutes
setTimeout(function() {
    window.location.reload();
}, 300000);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\admin\analytics.blade.php ENDPATH**/ ?>