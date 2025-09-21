<?php $__env->startComponent('mail::message'); ?>
# Order Cancelled 

Hello <?php echo e($order->customer_name); ?>,

Your order **<?php echo e($order->order_number); ?>** has been cancelled as requested.

## Cancellation Details

**Order Number:** <?php echo e($order->order_number); ?>  
**Cancelled Date:** <?php echo e(now()->format('F d, Y \a\t g:i A')); ?>  
**Original Amount:** LKR <?php echo e(number_format($order->total_amount, 2)); ?>


## Cancelled Items

<?php $__env->startComponent('mail::table'); ?>
| Product | Quantity | Unit Price | Total |
|:--------|:--------:|:----------:|------:|
<?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
| <?php echo e($item->product_name); ?> | <?php echo e($item->quantity); ?> | LKR <?php echo e(number_format($item->unit_price, 2)); ?> | LKR <?php echo e(number_format($item->total_price, 2)); ?> |
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->renderComponent(); ?>

<?php if($order->payment_status === 'paid'): ?>
<?php $__env->startComponent('mail::panel'); ?>
**Refund Information** 💰

Since your payment was already processed, we'll issue a full refund:

- **Refund Amount:** LKR <?php echo e(number_format($order->total_amount, 2)); ?>

- **Processing Time:** 3-5 business days
- **Method:** Refund to original payment method
- **Reference:** Will be provided separately

You'll receive a separate email confirmation once the refund is processed.
<?php echo $__env->renderComponent(); ?>
<?php elseif($order->payment_method === 'bank_transfer' && $order->payment_status === 'pending'): ?>
<?php $__env->startComponent('mail::panel'); ?>
**Payment Instructions** ❌

Since your order is cancelled:
- **Do not proceed with bank transfer**
- If already transferred, contact us immediately for refund
- Ignore previous payment instructions
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

<?php if($order->notes): ?>
## Cancellation Reason

<?php echo e($order->notes); ?>

<?php endif; ?>

<?php if($order->admin_notes): ?>
## Additional Information

<?php echo e($order->admin_notes); ?>

<?php endif; ?>

## What's Next?

### Browse Our Products
Even though this order was cancelled, we'd love to help you find what you need:

<?php $__env->startComponent('mail::button', ['url' => route('home')]); ?>
Continue Shopping
<?php echo $__env->renderComponent(); ?>

### Need Alternative Products?
Our team can help you find similar or better alternatives:

- **Phone:** 0112 95 9005
- **WhatsApp:** +94 777 506 939 (Chat with our experts)
- **Email:** info@mskcomputers.lk

### Visit Our Store
Get hands-on experience with our products:

**MSK Computers Showroom**  
No.12, Maradana Road, Colombo 08  
**Hours:** Monday-Saturday 9AM-7PM, Sunday 10AM-6PM

<?php $__env->startComponent('mail::panel'); ?>
**Why Choose MSK Computers?**

✅ **Best Prices** - Competitive pricing guaranteed  
✅ **Genuine Products** - 100% authentic items  
✅ **Expert Support** - Technical assistance available  
✅ **Fast Delivery** - Island-wide shipping  
✅ **Warranty Service** - Comprehensive after-sales support
<?php echo $__env->renderComponent(); ?>

## Get Exclusive Offers

Don't miss out on our latest deals and new arrivals:

- 📧 **Email Updates:** Already subscribed with <?php echo e($order->customer_email); ?>

- 📱 **WhatsApp Alerts:** +94 777 506 939
- 📘 **Facebook:** Like our page for daily updates

## Customer Support

If you have any questions about this cancellation or need assistance:

- **General Inquiries:** 0112 95 9005
- **Refund Status:** +94 777 506 939
- **Email Support:** info@mskcomputers.lk

We're sorry this order didn't work out, but we hope to serve you again soon!

Best regards,  
MSK Computers Customer Service Team

<?php $__env->startComponent('mail::subcopy'); ?>
Order cancelled: <?php echo e(now()->format('F d, Y \a\t g:i A')); ?>  
Order Number: <?php echo e($order->order_number); ?>  
<?php if($order->payment_status === 'paid'): ?>Refund will be processed within 3-5 business days@endif
<?php echo $__env->renderComponent(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\emails\order-cancelled.blade.php ENDPATH**/ ?>