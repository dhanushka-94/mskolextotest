

<?php $__env->startSection('title', 'Create New Order'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white">Create New Order</h1>
            <p class="text-gray-400 mt-1">Manually create a new order for a customer</p>
        </div>
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to Orders
        </a>
    </div>

    <!-- Create Form -->
    <div class="bg-gray-800 rounded-lg p-6">
        <form method="POST" action="<?php echo e(route('admin.orders.store')); ?>" id="createOrderForm">
            <?php echo csrf_field(); ?>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Customer Information -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-medium text-white mb-4">Customer Information</h3>
                </div>

                <!-- Customer Selection -->
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-300 mb-2">Select Customer *</label>
                    <select id="customer_id" name="customer_id" required onchange="fillCustomerInfo()"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary-500 <?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">Choose a customer...</option>
                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($customer->id); ?>" 
                                    data-name="<?php echo e($customer->name); ?>"
                                    data-email="<?php echo e($customer->email); ?>"
                                    data-phone="<?php echo e($customer->phone); ?>"
                                    <?php echo e(old('customer_id') == $customer->id ? 'selected' : ''); ?>>
                                <?php echo e($customer->name); ?> (<?php echo e($customer->email); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Customer Name -->
                <div>
                    <label for="customer_name" class="block text-sm font-medium text-gray-300 mb-2">Customer Name *</label>
                    <input type="text" id="customer_name" name="customer_name" value="<?php echo e(old('customer_name')); ?>" required
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500 <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Customer Email -->
                <div>
                    <label for="customer_email" class="block text-sm font-medium text-gray-300 mb-2">Customer Email *</label>
                    <input type="email" id="customer_email" name="customer_email" value="<?php echo e(old('customer_email')); ?>" required
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500 <?php $__errorArgs = ['customer_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['customer_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Customer Phone -->
                <div>
                    <label for="customer_phone" class="block text-sm font-medium text-gray-300 mb-2">Customer Phone *</label>
                    <input type="text" id="customer_phone" name="customer_phone" value="<?php echo e(old('customer_phone')); ?>" required
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500 <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Billing Address -->
                <div class="lg:col-span-2 mt-6">
                    <h3 class="text-lg font-medium text-white mb-4">Billing Address</h3>
                </div>

                <div>
                    <label for="billing_address_line_1" class="block text-sm font-medium text-gray-300 mb-2">Address Line 1 *</label>
                    <input type="text" id="billing_address_line_1" name="billing_address_line_1" value="<?php echo e(old('billing_address_line_1')); ?>" required
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500 <?php $__errorArgs = ['billing_address_line_1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['billing_address_line_1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="billing_address_line_2" class="block text-sm font-medium text-gray-300 mb-2">Address Line 2</label>
                    <input type="text" id="billing_address_line_2" name="billing_address_line_2" value="<?php echo e(old('billing_address_line_2')); ?>"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500">
                </div>

                <div>
                    <label for="billing_city" class="block text-sm font-medium text-gray-300 mb-2">City *</label>
                    <input type="text" id="billing_city" name="billing_city" value="<?php echo e(old('billing_city')); ?>" required
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500 <?php $__errorArgs = ['billing_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['billing_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="billing_state" class="block text-sm font-medium text-gray-300 mb-2">State/Province *</label>
                    <input type="text" id="billing_state" name="billing_state" value="<?php echo e(old('billing_state')); ?>" required
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500 <?php $__errorArgs = ['billing_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['billing_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="billing_postal_code" class="block text-sm font-medium text-gray-300 mb-2">Postal Code *</label>
                    <input type="text" id="billing_postal_code" name="billing_postal_code" value="<?php echo e(old('billing_postal_code')); ?>" required
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-5002 <?php $__errorArgs = ['billing_postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['billing_postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="billing_country" class="block text-sm font-medium text-gray-300 mb-2">Country *</label>
                    <input type="text" id="billing_country" name="billing_country" value="<?php echo e(old('billing_country', 'Sri Lanka')); ?>" required
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500 <?php $__errorArgs = ['billing_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['billing_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Order Items -->
                <div class="lg:col-span-2 mt-6">
                    <h3 class="text-lg font-medium text-white mb-4">Order Items</h3>
                    <div id="orderItems">
                        <div class="order-item bg-gray-700 rounded-lg p-4 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Product Name *</label>
                                    <input type="text" name="items[0][product_name]" required
                                           class="w-full bg-gray-600 border border-gray-500 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Quantity *</label>
                                    <input type="number" name="items[0][quantity]" min="1" value="1" required onchange="calculateItemTotal(0)"
                                           class="w-full bg-gray-600 border border-gray-500 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Unit Price (Rs.) *</label>
                                    <input type="number" name="items[0][unit_price]" min="0" step="0.01" required onchange="calculateItemTotal(0)"
                                           class="w-full bg-gray-600 border border-gray-500 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Total</label>
                                    <input type="text" readonly class="item-total w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 text-gray-400">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="addOrderItem()" class="mt-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add Another Item
                    </button>
                </div>

                <!-- Order Details -->
                <div class="lg:col-span-2 mt-6">
                    <h3 class="text-lg font-medium text-white mb-4">Order Details</h3>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Order Status *</label>
                    <select id="status" name="status" required
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary-500">
                        <option value="pending" <?php echo e(old('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="processing" <?php echo e(old('status') == 'processing' ? 'selected' : ''); ?>>Processing</option>
                        <option value="shipped" <?php echo e(old('status') == 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                        <option value="delivered" <?php echo e(old('status') == 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                        <option value="cancelled" <?php echo e(old('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                </div>

                <div>
                    <label for="payment_status" class="block text-sm font-medium text-gray-300 mb-2">Payment Status *</label>
                    <select id="payment_status" name="payment_status" required
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary-500">
                        <option value="pending" <?php echo e(old('payment_status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="paid" <?php echo e(old('payment_status') == 'paid' ? 'selected' : ''); ?>>Paid</option>
                        <option value="failed" <?php echo e(old('payment_status') == 'failed' ? 'selected' : ''); ?>>Failed</option>
                        <option value="refunded" <?php echo e(old('payment_status') == 'refunded' ? 'selected' : ''); ?>>Refunded</option>
                    </select>
                </div>

                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-300 mb-2">Payment Method *</label>
                    <select id="payment_method" name="payment_method" required
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary-500">
                        <option value="cash_on_delivery" <?php echo e(old('payment_method') == 'cash_on_delivery' ? 'selected' : ''); ?>>Cash on Delivery</option>
                        <option value="bank_transfer" <?php echo e(old('payment_method') == 'bank_transfer' ? 'selected' : ''); ?>>Bank Transfer</option>
                        <option value="card_payment" <?php echo e(old('payment_method') == 'card_payment' ? 'selected' : ''); ?>>Card Payment</option>
                        <option value="mobile_payment" <?php echo e(old('payment_method') == 'mobile_payment' ? 'selected' : ''); ?>>Mobile Payment</option>
                    </select>
                </div>

                <!-- Order Totals -->
                <div class="lg:col-span-2 mt-6">
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-white mb-4">Order Summary</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-300">Subtotal:</span>
                                <span class="text-white font-semibold" id="subtotalDisplay">Rs. 0.00</span>
                                <input type="hidden" id="subtotal" name="subtotal" value="0">
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-300">Tax (0%):</span>
                                <span class="text-white">Rs. 0.00</span>
                                <input type="hidden" name="tax_amount" value="0">
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-300">Shipping:</span>
                                <span class="text-white">Rs. 0.00</span>
                                <input type="hidden" name="shipping_cost" value="0">
                            </div>
                            <div class="border-t border-gray-600 pt-3">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold text-white">Total:</span>
                                    <span class="text-lg font-semibold text-primary-400" id="totalDisplay">Rs. 0.00</span>
                                    <input type="hidden" id="total_amount" name="total_amount" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-300 mb-2">Order Notes</label>
                    <textarea id="notes" name="notes" rows="3"
                              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500"
                              placeholder="Any additional notes for this order..."><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 mt-8">
                <a href="<?php echo e(route('admin.orders.index')); ?>" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>Create Order
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let itemCount = 1;

function fillCustomerInfo() {
    const select = document.getElementById('customer_id');
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption.value) {
        document.getElementById('customer_name').value = selectedOption.dataset.name || '';
        document.getElementById('customer_email').value = selectedOption.dataset.email || '';
        document.getElementById('customer_phone').value = selectedOption.dataset.phone || '';
    } else {
        document.getElementById('customer_name').value = '';
        document.getElementById('customer_email').value = '';
        document.getElementById('customer_phone').value = '';
    }
}

function addOrderItem() {
    const container = document.getElementById('orderItems');
    const itemHtml = `
        <div class="order-item bg-gray-700 rounded-lg p-4 mb-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Product Name *</label>
                    <input type="text" name="items[${itemCount}][product_name]" required
                           class="w-full bg-gray-600 border border-gray-500 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Quantity *</label>
                    <input type="number" name="items[${itemCount}][quantity]" min="1" value="1" required onchange="calculateItemTotal(${itemCount})"
                           class="w-full bg-gray-600 border border-gray-500 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Unit Price (Rs.) *</label>
                    <input type="number" name="items[${itemCount}][unit_price]" min="0" step="0.01" required onchange="calculateItemTotal(${itemCount})"
                           class="w-full bg-gray-600 border border-gray-500 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Total</label>
                    <input type="text" readonly class="item-total w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 text-gray-400">
                </div>
                <div class="flex items-end">
                    <button type="button" onclick="removeOrderItem(this)" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg transition-colors">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', itemHtml);
    itemCount++;
}

function removeOrderItem(button) {
    button.closest('.order-item').remove();
    calculateOrderTotal();
}

function calculateItemTotal(index) {
    const quantity = document.querySelector(`input[name="items[${index}][quantity]"]`).value;
    const unitPrice = document.querySelector(`input[name="items[${index}][unit_price]"]`).value;
    const total = quantity * unitPrice;
    
    const itemTotalInput = document.querySelector(`input[name="items[${index}][quantity]"]`).closest('.order-item').querySelector('.item-total');
    itemTotalInput.value = 'Rs. ' + total.toFixed(2);
    
    calculateOrderTotal();
}

function calculateOrderTotal() {
    let subtotal = 0;
    
    // Sum all item totals
    document.querySelectorAll('input[name^="items"][name$="[quantity]"]').forEach((quantityInput, index) => {
        const quantity = parseFloat(quantityInput.value) || 0;
        const unitPriceInput = quantityInput.closest('.order-item').querySelector('input[name*="[unit_price]"]');
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        subtotal += quantity * unitPrice;
    });
    
    document.getElementById('subtotal').value = subtotal;
    document.getElementById('total_amount').value = subtotal;
    document.getElementById('subtotalDisplay').textContent = 'Rs. ' + subtotal.toFixed(2);
    document.getElementById('totalDisplay').textContent = 'Rs. ' + subtotal.toFixed(2);
}

// Calculate total on any input change
document.addEventListener('input', function(e) {
    if (e.target.name && (e.target.name.includes('[quantity]') || e.target.name.includes('[unit_price]'))) {
        calculateOrderTotal();
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\admin\orders\create.blade.php ENDPATH**/ ?>