

<?php $__env->startSection('title', 'Transaction Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <a href="<?php echo e(route('admin.transactions.index')); ?>" 
                   class="text-gray-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-white">Transaction Details</h1>
            </div>
            <p class="text-gray-400">Transaction ID: <?php echo e($transaction->transaction_id); ?></p>
        </div>
        
        <div class="flex items-center space-x-4">
            <?php if($transaction->isFailed()): ?>
                <form action="<?php echo e(route('admin.transactions.retry', $transaction)); ?>" method="POST" class="inline-block">
                    <?php echo csrf_field(); ?>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors"
                            onclick="return confirm('Are you sure you want to retry this transaction?')">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Retry Transaction
                    </button>
                </form>
            <?php endif; ?>

            <?php if($transaction->isCompleted()): ?>
                <button type="button" 
                        class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors"
                        onclick="openRefundModal()">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                    Process Refund
                </button>
            <?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Transaction Details -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Basic Information -->
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-semibold text-white mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Transaction Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Transaction ID</label>
                        <p class="text-white font-mono"><?php echo e($transaction->transaction_id); ?></p>
                    </div>

                    <?php if($transaction->gateway_transaction_id): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Gateway Transaction ID</label>
                        <p class="text-white font-mono"><?php echo e($transaction->gateway_transaction_id); ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if($transaction->order): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Order Number</label>
                        <a href="<?php echo e(route('admin.orders.show', $transaction->order)); ?>" 
                           class="text-[#f59e0b] hover:text-[#d97706] transition-colors">
                            <?php echo e($transaction->order->order_number); ?>

                        </a>
                    </div>
                    <?php endif; ?>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Payment Method</label>
                        <div class="flex items-center">
                            <?php if($transaction->payment_method === 'webxpay'): ?>
                                <div class="w-6 h-6 bg-purple-500/20 rounded flex items-center justify-center mr-2">
                                    <svg class="w-3 h-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3-3v8a3 3 0 003 3z"/>
                                    </svg>
                                </div>
                            <?php elseif($transaction->payment_method === 'kokopay'): ?>
                                <div class="w-6 h-6 bg-indigo-500/20 rounded flex items-center justify-center mr-2">
                                    <svg class="w-3 h-3 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                    </svg>
                                </div>
                            <?php elseif($transaction->payment_method === 'bank_transfer'): ?>
                                <div class="w-6 h-6 bg-cyan-500/20 rounded flex items-center justify-center mr-2">
                                    <svg class="w-3 h-3 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m11 0a2 2 0 01-2 2H7a2 2 0 01-2-2m14 0V9a2 2 0 00-2-2M9 7h6m-6 4h6m-6 4h6m-6 4h6"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                            <span class="text-white"><?php echo e($transaction->payment_method_name); ?></span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Status</label>
                        <?php
                            $statusColors = [
                                'pending' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
                                'processing' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
                                'completed' => 'bg-green-500/20 text-green-400 border-green-500/30',
                                'failed' => 'bg-red-500/20 text-red-400 border-red-500/30',
                                'cancelled' => 'bg-gray-500/20 text-gray-400 border-gray-500/30',
                                'refunded' => 'bg-purple-500/20 text-purple-400 border-purple-500/30',
                            ];
                            $statusColor = $statusColors[$transaction->status] ?? 'bg-gray-500/20 text-gray-400 border-gray-500/30';
                        ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border <?php echo e($statusColor); ?>">
                            <?php echo e(ucfirst($transaction->status)); ?>

                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Currency</label>
                        <p class="text-white"><?php echo e($transaction->currency); ?></p>
                    </div>
                </div>

                <?php if($transaction->description): ?>
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-400 mb-1">Description</label>
                    <p class="text-white"><?php echo e($transaction->description); ?></p>
                </div>
                <?php endif; ?>

                <?php if($transaction->failure_reason): ?>
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-400 mb-1">Failure Reason</label>
                    <div class="bg-red-900/20 border border-red-500/30 rounded-lg p-3">
                        <p class="text-red-400"><?php echo e($transaction->failure_reason); ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Customer Information -->
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-semibold text-white mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Customer Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Name</label>
                        <p class="text-white"><?php echo e($transaction->customer_name ?: 'N/A'); ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Email</label>
                        <p class="text-white"><?php echo e($transaction->customer_email ?: 'N/A'); ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Phone</label>
                        <p class="text-white"><?php echo e($transaction->customer_phone ?: 'N/A'); ?></p>
                    </div>

                    <?php if($transaction->ip_address): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">IP Address</label>
                        <p class="text-white font-mono"><?php echo e($transaction->ip_address); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Gateway Response -->
            <?php if($transaction->gateway_response): ?>
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-semibold text-white mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Gateway Response
                </h3>

                <div class="bg-[#0f0f0f] rounded-lg p-4">
                    <pre class="text-sm text-gray-300 overflow-x-auto"><code><?php echo e(json_encode($transaction->gateway_response, JSON_PRETTY_PRINT)); ?></code></pre>
                </div>
            </div>
            <?php endif; ?>

            <!-- Order Details -->
            <?php if($transaction->order): ?>
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 12H6L5 9z"/>
                        </svg>
                        Order Details
                    </h3>
                    <a href="<?php echo e(route('admin.orders.show', $transaction->order)); ?>" 
                       class="text-[#f59e0b] hover:text-[#d97706] text-sm transition-colors">
                        View Full Order →
                    </a>
                </div>

                <div class="space-y-4">
                    <?php $__currentLoopData = $transaction->order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center space-x-4 p-4 bg-[#0f0f0f] rounded-lg">
                        <?php if($item->product): ?>
                            <img src="<?php echo e($item->product->main_image); ?>" 
                                 alt="<?php echo e($item->product->name); ?>" 
                                 class="w-16 h-16 object-cover rounded-lg">
                            <div class="flex-1">
                                <h4 class="text-white font-medium"><?php echo e($item->product->name); ?></h4>
                                <p class="text-gray-400 text-sm">Quantity: <?php echo e($item->quantity); ?></p>
                                <p class="text-[#f59e0b] font-medium">LKR <?php echo e(number_format($item->price, 2)); ?> each</p>
                            </div>
                            <div class="text-right">
                                <p class="text-white font-medium">LKR <?php echo e(number_format($item->price * $item->quantity, 2)); ?></p>
                            </div>
                        <?php else: ?>
                            <div class="w-16 h-16 bg-gray-700 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-gray-400 font-medium">Product Not Found</h4>
                                <p class="text-gray-500 text-sm">Quantity: <?php echo e($item->quantity); ?></p>
                                <p class="text-gray-400 font-medium">LKR <?php echo e(number_format($item->price, 2)); ?> each</p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-400 font-medium">LKR <?php echo e(number_format($item->price * $item->quantity, 2)); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            
            <!-- Amount Breakdown -->
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-semibold text-white mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                    Amount Breakdown
                </h3>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Subtotal</span>
                        <span class="text-white font-medium">LKR <?php echo e(number_format($transaction->amount, 2)); ?></span>
                    </div>

                    <?php if($transaction->transaction_fee > 0): ?>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Transaction Fee</span>
                        <span class="text-white font-medium">LKR <?php echo e(number_format($transaction->transaction_fee, 2)); ?></span>
                    </div>
                    
                    <div class="border-t border-gray-700 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-white font-semibold">Total Amount</span>
                            <span class="text-[#f59e0b] font-bold text-lg">LKR <?php echo e(number_format($transaction->total_amount, 2)); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-semibold text-white mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Transaction Timeline
                </h3>

                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        <div class="flex-1">
                            <p class="text-white text-sm">Transaction Created</p>
                            <p class="text-gray-400 text-xs"><?php echo e($transaction->created_at->format('M d, Y H:i:s')); ?></p>
                        </div>
                    </div>

                    <?php if($transaction->initiated_at): ?>
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                        <div class="flex-1">
                            <p class="text-white text-sm">Payment Initiated</p>
                            <p class="text-gray-400 text-xs"><?php echo e($transaction->initiated_at->format('M d, Y H:i:s')); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($transaction->completed_at): ?>
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        <div class="flex-1">
                            <p class="text-white text-sm">Payment Completed</p>
                            <p class="text-gray-400 text-xs"><?php echo e($transaction->completed_at->format('M d, Y H:i:s')); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($transaction->failed_at): ?>
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-red-400 rounded-full"></div>
                        <div class="flex-1">
                            <p class="text-white text-sm">Payment Failed</p>
                            <p class="text-gray-400 text-xs"><?php echo e($transaction->failed_at->format('M d, Y H:i:s')); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Additional Metadata -->
            <?php if($transaction->metadata): ?>
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-semibold text-white mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Additional Information
                </h3>

                <div class="bg-[#0f0f0f] rounded-lg p-4">
                    <pre class="text-sm text-gray-300 overflow-x-auto"><code><?php echo e(json_encode($transaction->metadata, JSON_PRETTY_PRINT)); ?></code></pre>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Refund Modal -->
<div id="refundModal" class="fixed inset-0 bg-black/75 hidden items-center justify-center z-50">
    <div class="bg-[#1a1a1c] rounded-xl border border-gray-800 p-6 max-w-md w-full mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-white">Refund Transaction</h3>
            <button onclick="closeRefundModal()" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form action="<?php echo e(route('admin.transactions.refund', $transaction)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Refund Reason</label>
                <textarea name="refund_reason" 
                          rows="3" 
                          required
                          placeholder="Enter the reason for this refund..."
                          class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent"></textarea>
            </div>
            
            <div class="flex space-x-4">
                <button type="submit" 
                        class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Process Refund
                </button>
                <button type="button" 
                        onclick="closeRefundModal()"
                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRefundModal() {
    const modal = document.getElementById('refundModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeRefundModal() {
    const modal = document.getElementById('refundModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Close modal on outside click
document.getElementById('refundModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRefundModal();
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\admin\transactions\show.blade.php ENDPATH**/ ?>