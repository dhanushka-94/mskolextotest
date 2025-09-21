<?php $__env->startComponent('mail::message'); ?>
# Order Delivered Successfully! 🎉

Hello <?php echo e($order->customer_name); ?>,

Great news! Your order **<?php echo e($order->order_number); ?>** has been **successfully delivered**!

## Delivery Confirmation

**Delivered Date:** <?php echo e($order->delivered_at->format('F d, Y \a\t g:i A')); ?>  
**Delivered To:** <?php echo e($order->shipping_address); ?>  
**Order Total:** LKR <?php echo e(number_format($order->total_amount, 2)); ?>


## Items Delivered

<?php $__env->startComponent('mail::table'); ?>
| Product | Quantity | Delivered |
|:--------|:--------:|:---------:|
<?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
| <?php echo e($item->product_name); ?> | <?php echo e($item->quantity); ?> | ✅ Complete |
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('mail::panel'); ?>
**Quality Guarantee**

✅ All items inspected before shipping  
📦 Securely packaged to prevent damage  
🛡️ Covered by our warranty policy  
🔄 30-day return/exchange available
<?php echo $__env->renderComponent(); ?>

## Next Steps

### 1. Check Your Items
Please inspect all items immediately upon delivery and report any issues within 24 hours.

### 2. Keep Your Receipt
Your delivery confirmation serves as proof of purchase for warranty claims.

### 3. Product Registration
Register your products for extended warranty and support:

<?php $__env->startComponent('mail::button', ['url' => route('user.dashboard')]); ?>
Register Products
<?php echo $__env->renderComponent(); ?>

## Need Support?

### Technical Support
- **Phone:** 0112 95 9005
- **WhatsApp:** +94 777 506 939
- **Email:** support@mskcomputers.lk

### Returns & Exchanges
- **Return Window:** 30 days from delivery
- **Condition:** Items must be unopened and in original packaging
- **Process:** Contact us to initiate return

### Warranty Service
- **Coverage:** As per manufacturer terms
- **Service Center:** No.12, Maradana Road, Colombo 08
- **Hours:** Monday-Saturday 9AM-7PM

<?php $__env->startComponent('mail::panel'); ?>
**Feedback Request** ⭐

How was your experience with MSK Computers?  
Your feedback helps us improve our service!

**Rate Your Experience:**
- Product Quality: ⭐⭐⭐⭐⭐
- Delivery Service: ⭐⭐⭐⭐⭐
- Customer Support: ⭐⭐⭐⭐⭐
<?php echo $__env->renderComponent(); ?>

## Reorder Made Easy

Love what you ordered? Reorder with one click:

<?php $__env->startComponent('mail::button', ['url' => route('user.orders.detail', $order->order_number)]); ?>
Reorder Items
<?php echo $__env->renderComponent(); ?>

## Follow Us

Stay updated with our latest products and offers:

- **Facebook:** MSK Computers
- **Instagram:** @mskcomputers  
- **YouTube:** MSK Computers Sri Lanka
- **Website:** www.mskcomputers.lk

Thank you for choosing MSK Computers! We hope you love your new products.

Best regards,  
The MSK Computers Team

<?php $__env->startComponent('mail::subcopy'); ?>
Order completed: <?php echo e($order->delivered_at->format('F d, Y \a\t g:i A')); ?>  
Order Number: <?php echo e($order->order_number); ?>  
Need help? Contact us anytime at +94 777 506 939
<?php echo $__env->renderComponent(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\emails\order-delivered.blade.php ENDPATH**/ ?>