<?php $__env->startComponent('mail::message'); ?>
# Order Shipped! 🚚

Hello <?php echo e($order->customer_name); ?>,

Excellent news! Your order **<?php echo e($order->order_number); ?>** has been shipped and is on its way to you!

<?php if($order->tracking_number): ?>
## Tracking Information

**Tracking Number:** <?php echo e($order->tracking_number); ?>  
<?php if($order->courier_service): ?>
**Courier Service:** <?php echo e($order->courier_service); ?>  
<?php endif; ?>
**Shipped Date:** <?php echo e($order->shipped_at->format('F d, Y \a\t g:i A')); ?>  
**Expected Delivery:** <?php echo e($order->shipped_at->addDays(2)->format('F d, Y')); ?>

<?php endif; ?>

## What's Being Delivered

<?php $__env->startComponent('mail::table'); ?>
| Product | Quantity | Condition |
|:--------|:--------:|:---------:|
<?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
| <?php echo e($item->product_name); ?> | <?php echo e($item->quantity); ?> | ✅ Quality Checked |
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->renderComponent(); ?>

**Order Total:** LKR <?php echo e(number_format($order->total_amount, 2)); ?>


<?php if($order->tracking_number): ?>
<?php $__env->startComponent('mail::button', ['url' => '#']); ?>
Track Your Package
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

## Delivery Information

**Delivering To:**  
<?php echo e($order->customer_name); ?>  
<?php echo e($order->shipping_address_line_1); ?>  
<?php if($order->shipping_address_line_2): ?>
<?php echo e($order->shipping_address_line_2); ?>  
<?php endif; ?>
<?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_state); ?> <?php echo e($order->shipping_postal_code); ?>  
**Contact:** <?php echo e($order->customer_phone); ?>


<?php $__env->startComponent('mail::panel'); ?>
**Important Delivery Notes**

📱 Our courier will call you before delivery  
🏠 Please ensure someone is available to receive the package  
🆔 ID verification may be required for high-value items  
📦 Items are securely packaged to prevent damage
<?php echo $__env->renderComponent(); ?>

## What to Expect

🕐 **Delivery Hours:** 9:00 AM - 6:00 PM  
📞 **Courier Contact:** They'll call you 30 minutes before arrival  
💳 **Payment:** <?php echo e($order->payment_method === 'cash_on_delivery' ? 'Have exact amount ready' : 'Already paid - No payment required'); ?>


<?php if($order->payment_method === 'cash_on_delivery'): ?>
<?php $__env->startComponent('mail::panel'); ?>
**Cash on Delivery Instructions**

💰 **Amount Due:** LKR <?php echo e(number_format($order->total_amount, 2)); ?>  
💵 Please have the **exact amount** ready  
🧾 You'll receive an official receipt upon payment
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

## Need Help?

- **Delivery Issues:** Contact the courier directly
- **Order Questions:** +94 777 506 939
- **Emergency Support:** 0112 95 9005

<?php $__env->startComponent('mail::button', ['url' => route('orders.show', $order->order_number)]); ?>
View Order Status
<?php echo $__env->renderComponent(); ?>

Thank you for choosing MSK Computers!

Best regards,  
MSK Computers Shipping Team

<?php $__env->startComponent('mail::subcopy'); ?>
Shipped: <?php echo e($order->shipped_at->format('F d, Y \a\t g:i A')); ?>  
<?php if($order->tracking_number): ?>Tracking: <?php echo e($order->tracking_number); ?><?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\emails\order-shipped.blade.php ENDPATH**/ ?>