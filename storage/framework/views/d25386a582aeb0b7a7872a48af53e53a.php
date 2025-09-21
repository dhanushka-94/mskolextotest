<?php $__env->startComponent('mail::message'); ?>
# Order Status Update

Hello <?php echo e($order->customer_name); ?>,

Your order **<?php echo e($order->order_number); ?>** status has been updated.

**Previous Status:** <?php echo e(ucfirst($oldStatus)); ?>  
**Current Status:** <?php echo e(ucfirst($order->status)); ?>


## Order Details

<?php $__env->startComponent('mail::table'); ?>
| Product | Quantity | Price |
|:--------|:--------:|------:|
<?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
| <?php echo e($item->product_name); ?> | <?php echo e($item->quantity); ?> | LKR <?php echo e(number_format($item->total_price, 2)); ?> |
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->renderComponent(); ?>

**Order Total:** LKR <?php echo e(number_format($order->total_amount, 2)); ?>


<?php if($order->status === 'shipped' && $order->tracking_number): ?>
## Tracking Information

**Tracking Number:** <?php echo e($order->tracking_number); ?>  
<?php if($order->courier_service): ?>
**Courier Service:** <?php echo e($order->courier_service); ?>

<?php endif; ?>
<?php endif; ?>

<?php if($order->admin_notes): ?>
## Additional Notes

<?php echo e($order->admin_notes); ?>

<?php endif; ?>

<?php $__env->startComponent('mail::button', ['url' => route('orders.show', $order->order_number)]); ?>
Track Your Order
<?php echo $__env->renderComponent(); ?>

Thank you for shopping with MSK Computers!

Best regards,  
<?php echo e(config('app.name')); ?> Team

<?php $__env->startComponent('mail::subcopy'); ?>
If you have any questions about your order, please contact us:
- Phone: 0112 95 9005
- WhatsApp: +94 777 506 939
- Email: info@mskcomputers.lk
<?php echo $__env->renderComponent(); ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\emails\order-status-updated.blade.php ENDPATH**/ ?>