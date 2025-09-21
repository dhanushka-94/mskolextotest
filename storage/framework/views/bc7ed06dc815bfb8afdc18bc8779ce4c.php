<?php $__env->startComponent('mail::message'); ?>
# Order Confirmed ✅

Hello <?php echo e($order->customer_name); ?>,

Great news! Your order has been **confirmed** and is now in our system.

## Order Details

**Order Number:** <?php echo e($order->order_number); ?>  
**Confirmation Date:** <?php echo e(now()->format('F d, Y \a\t g:i A')); ?>  
**Payment Status:** <?php echo e(ucfirst(str_replace('_', ' ', $order->payment_status))); ?>


## Items Confirmed

<?php $__env->startComponent('mail::table'); ?>
| Product | Quantity | Unit Price | Total |
|:--------|:--------:|:----------:|------:|
<?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
| <?php echo e($item->product_name); ?> | <?php echo e($item->quantity); ?> | LKR <?php echo e(number_format($item->unit_price, 2)); ?> | LKR <?php echo e(number_format($item->total_price, 2)); ?> |
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->renderComponent(); ?>

**Order Total:** **LKR <?php echo e(number_format($order->total_amount, 2)); ?>**

<?php $__env->startComponent('mail::panel'); ?>
**What's Next?**

✅ Your order is confirmed  
🔄 We'll start processing your items  
📦 You'll receive updates as we prepare your order  
🚚 Shipping details will be sent once dispatched
<?php echo $__env->renderComponent(); ?>

## Estimated Timeline

- **Processing:** 1-2 business days
- **Shipping:** 2-3 business days within Colombo
- **Total Delivery Time:** 3-5 business days

<?php $__env->startComponent('mail::button', ['url' => route('orders.show', $order->order_number)]); ?>
Track Your Order
<?php echo $__env->renderComponent(); ?>

## Need to Make Changes?

If you need to modify or cancel your order, please contact us **within 2 hours** of confirmation:

- **Phone:** 0112 95 9005
- **WhatsApp:** +94 777 506 939 (Immediate Response)
- **Email:** info@mskcomputers.lk

Thank you for choosing MSK Computers!

Best regards,  
MSK Computers Team

<?php $__env->startComponent('mail::subcopy'); ?>
Order confirmed at <?php echo e(now()->format('F d, Y \a\t g:i A')); ?>  
Order Number: <?php echo e($order->order_number); ?>

<?php echo $__env->renderComponent(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\emails\order-confirmed.blade.php ENDPATH**/ ?>