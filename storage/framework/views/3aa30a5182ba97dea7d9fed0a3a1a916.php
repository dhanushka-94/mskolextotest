

<?php $__env->startSection('title', 'Order Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Order Management</h1>
            <p class="text-gray-400">Manage and track all customer orders</p>
        </div>
        <div class="flex space-x-3">
            <a href="<?php echo e(route('admin.orders.create')); ?>" 
               class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors">
                <i class="fas fa-plus mr-2"></i>Create Order
            </a>
            <a href="<?php echo e(route('admin.orders.statistics')); ?>" 
               class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-chart-bar mr-2"></i>Statistics
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-gradient-to-r from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
        <form method="GET" action="<?php echo e(route('admin.orders.index')); ?>">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Search</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="<?php echo e(request('search')); ?>"
                           placeholder="Order number, customer..."
                           class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                    <select id="status" name="status" class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                        <option value="">All Status</option>
                        <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="confirmed" <?php echo e(request('status') === 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                        <option value="processing" <?php echo e(request('status') === 'processing' ? 'selected' : ''); ?>>Processing</option>
                        <option value="shipped" <?php echo e(request('status') === 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                        <option value="delivered" <?php echo e(request('status') === 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                        <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                </div>

                <!-- Payment Status -->
                <div>
                    <label for="payment_status" class="block text-sm font-medium text-gray-300 mb-2">Payment</label>
                    <select id="payment_status" name="payment_status" class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                        <option value="">All Payments</option>
                        <option value="pending" <?php echo e(request('payment_status') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="paid" <?php echo e(request('payment_status') === 'paid' ? 'selected' : ''); ?>>Paid</option>
                        <option value="failed" <?php echo e(request('payment_status') === 'failed' ? 'selected' : ''); ?>>Failed</option>
                        <option value="refunded" <?php echo e(request('payment_status') === 'refunded' ? 'selected' : ''); ?>>Refunded</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-300 mb-2">Date From</label>
                    <input type="date" 
                           id="date_from" 
                           name="date_from" 
                           value="<?php echo e(request('date_from')); ?>"
                           class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                </div>

                <!-- Filter Buttons -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="px-4 py-2 bg-[#f59e0b] text-black rounded-lg hover:bg-[#d97706] transition-colors text-sm font-medium">
                        Filter
                    </button>
                    <?php if(request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to'])): ?>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="px-4 py-2 border border-gray-700 text-gray-300 rounded-lg hover:bg-gray-800 transition-colors text-sm">
                            Clear
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 overflow-hidden">
        
        <!-- Bulk Actions -->
        <div class="px-6 py-4 border-b border-gray-800 bg-gray-800/20">
            <form id="bulk-form" action="<?php echo e(route('admin.orders.bulk-action')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="checkbox" id="select-all" class="h-4 w-4 text-[#f59e0b] focus:ring-[#f59e0b] border-gray-700 rounded bg-[#0f0f0f]">
                        <span class="ml-2 text-sm text-gray-300">Select All</span>
                    </label>
                    
                    <select name="action" class="px-3 py-1 bg-[#0f0f0f] border border-gray-700 rounded text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                        <option value="">Bulk Actions</option>
                        <option value="update_status">Update Status</option>
                        <option value="export">Export Selected</option>
                        <option value="delete">Delete</option>
                    </select>
                    
                    <select name="bulk_status" class="px-3 py-1 bg-[#0f0f0f] border border-gray-700 rounded text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]" style="display: none;">
                        <option value="confirmed">Confirmed</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    
                    <button type="submit" class="px-4 py-1 bg-[#f59e0b] text-black rounded hover:bg-[#d97706] transition-colors text-sm font-medium">
                        Apply
                    </button>
                </div>
            </form>
        </div>

        <?php if($orders->count() > 0): ?>
            <!-- Orders Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-800/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                <input type="checkbox" class="h-4 w-4 text-[#f59e0b] focus:ring-[#f59e0b] border-gray-700 rounded bg-[#0f0f0f]">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Order</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Payment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-800/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="selected_orders[]" value="<?php echo e($order->id); ?>" class="order-checkbox h-4 w-4 text-[#f59e0b] focus:ring-[#f59e0b] border-gray-700 rounded bg-[#0f0f0f]">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-white"><?php echo e($order->order_number); ?></div>
                                        <div class="text-sm text-gray-400"><?php echo e($order->orderItems->count()); ?> items</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-white"><?php echo e($order->customer_name); ?></div>
                                        <div class="text-sm text-gray-400"><?php echo e($order->customer_email); ?></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($order->status_badge); ?>">
                                        <?php echo e(ucfirst($order->status)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($order->payment_status_badge); ?>">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $order->payment_status))); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                    LKR <?php echo e(number_format($order->total_amount, 2)); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                    <?php echo e($order->created_at->format('M d, Y')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="<?php echo e(route('admin.orders.show', $order)); ?>" 
                                           class="text-[#f59e0b] hover:text-[#d97706] transition-colors">
                                            <i class="fas fa-eye mr-1"></i>View
                                        </a>
                                        <button onclick="editOrder(<?php echo e($order->id); ?>)" 
                                                class="text-blue-400 hover:text-blue-300 transition-colors">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        <?php if(in_array($order->status, ['pending', 'cancelled']) && $order->payment_status !== 'paid'): ?>
                                            <form method="POST" action="<?php echo e(route('admin.orders.destroy', $order)); ?>" class="inline" onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="text-red-400 hover:text-red-300 transition-colors">
                                                    <i class="fas fa-trash mr-1"></i>Delete
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-800">
                <?php echo e($orders->appends(request()->query())->links('custom.pagination')); ?>

            </div>

        <?php else: ?>
            <!-- Empty State -->
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <h3 class="text-lg font-medium text-white mb-2">No orders found</h3>
                <?php if(request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to'])): ?>
                    <p class="text-gray-400 mb-4">Try adjusting your filters</p>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" 
                       class="inline-flex items-center px-4 py-2 border border-gray-700 text-gray-300 rounded-lg hover:bg-gray-800 transition-colors">
                        Clear Filters
                    </a>
                <?php else: ?>
                    <p class="text-gray-400">No orders have been placed yet</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Select all functionality
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.order-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Bulk action functionality
document.querySelector('select[name="action"]').addEventListener('change', function() {
    const statusSelect = document.querySelector('select[name="bulk_status"]');
    if (this.value === 'update_status') {
        statusSelect.style.display = 'inline-block';
        statusSelect.required = true;
    } else {
        statusSelect.style.display = 'none';
        statusSelect.required = false;
    }
});

// Edit order function
function editOrder(orderId) {
    // Redirect to order details page
    window.location.href = `/admin/orders/${orderId}`;
}

// Bulk form submission
document.getElementById('bulk-form').addEventListener('submit', function(e) {
    const selectedOrders = document.querySelectorAll('.order-checkbox:checked');
    if (selectedOrders.length === 0) {
        e.preventDefault();
        alert('Please select at least one order');
        return;
    }

    const action = document.querySelector('select[name="action"]').value;
    if (!action) {
        e.preventDefault();
        alert('Please select an action');
        return;
    }

    if (action === 'delete') {
        if (!confirm('Are you sure you want to delete the selected orders?')) {
            e.preventDefault();
        }
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\admin\orders\index.blade.php ENDPATH**/ ?>