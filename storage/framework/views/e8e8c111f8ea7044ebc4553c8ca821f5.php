<?php $__env->startComponent('mail::message'); ?>
# Order Being Prepared 🔄

Hello <?php echo e($order->customer_name); ?>,

Your order **<?php echo e($order->order_number); ?>** is now being processed in our warehouse!

## Current Status: Processing

Our team is carefully:
- ✅ Picking your items from inventory
- 🔍 Quality checking each product
- 📦 Preparing secure packaging
- 🏷️ Generating shipping labels

## Order Summary

<?php $__env->startComponent('mail::table'); ?>
| Product | Quantity | Status |
|:--------|:--------:|:------:|
<?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
| <?php echo e($item->product_name); ?> | <?php echo e($item->quantity); ?> | ✅ In Process |
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->renderComponent(); ?>

**Order Total:** LKR <?php echo e(number_format($order->total_amount, 2)); ?>


<?php if($order->payment_status === 'paid'): ?>
<?php $__env->startComponent('mail::panel'); ?>
**Payment Confirmed** ✅

Your payment has been received and processed successfully.
<?php echo $__env->renderComponent(); ?>
<?php else: ?>
<?php $__env->startComponent('mail::panel'); ?>
**Payment Pending** ⏳

Please ensure your payment is completed to avoid delays:
- Bank Transfer: Send confirmation to +94 777 506 939
- Card Payment: Check your payment status
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

## Delivery Information

**Shipping Address:**  
<?php echo e($order->customer_name); ?>  
<?php echo e($order->shipping_address_line_1); ?>  
<?php if($order->shipping_address_line_2): ?>
<?php echo e($order->shipping_address_line_2); ?>  
<?php endif; ?>
<?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_state); ?> <?php echo e($order->shipping_postal_code); ?>


## Expected Timeline

🕐 **Processing Time:** 24-48 hours  
🚚 **Shipping Time:** 2-3 business days  
📅 **Expected Delivery:** <?php echo e(now()->addDays(4)->format('F d, Y')); ?>


<?php $__env->startComponent('mail::button', ['url' => route('orders.show', $order->order_number)]); ?>
View Order Details
<?php echo $__env->renderComponent(); ?>

## Contact Us

Questions about your order processing?

- **Phone:** 0112 95 9005
- **WhatsApp:** +94 777 506 939
- **Email:** info@mskcomputers.lk

We'll notify you as soon as your order ships!

Best regards,  
MSK Computers Fulfillment Team

<?php $__env->startComponent('mail::subcopy'); ?>
Processing started: <?php echo e(now()->format('F d, Y \a\t g:i A')); ?>  
Estimated completion: <?php echo e(now()->addHours(48)->format('F d, Y \a\t g:i A')); ?>

<?php echo $__env->renderComponent(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\emails\order-processing.blade.php ENDPATH**/ ?>