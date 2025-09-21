<?php $__env->startComponent('mail::message'); ?>
# Refund Processed Successfully 💰

Hello <?php echo e($order->customer_name); ?>,

Your refund for order **<?php echo e($order->order_number); ?>** has been successfully processed.

## Refund Details

**Order Number:** <?php echo e($order->order_number); ?>  
**Refund Date:** <?php echo e(now()->format('F d, Y \a\t g:i A')); ?>  
**Refund Amount:** **LKR <?php echo e(number_format($order->total_amount, 2)); ?>**  
**Processing Method:** Refund to original payment method

## Timeline

- **Refund Initiated:** <?php echo e(now()->format('F d, Y')); ?>

- **Expected in Account:** <?php echo e(now()->addDays(3)->format('F d, Y')); ?> - <?php echo e(now()->addDays(5)->format('F d, Y')); ?>

- **Bank Processing:** 3-5 business days

## Refunded Items

<?php $__env->startComponent('mail::table'); ?>
| Product | Quantity | Unit Price | Refunded Amount |
|:--------|:--------:|:----------:|----------------:|
<?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
| <?php echo e($item->product_name); ?> | <?php echo e($item->quantity); ?> | LKR <?php echo e(number_format($item->unit_price, 2)); ?> | LKR <?php echo e(number_format($item->total_price, 2)); ?> |
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->renderComponent(); ?>

**Total Refunded:** **LKR <?php echo e(number_format($order->total_amount, 2)); ?>**

<?php $__env->startComponent('mail::panel'); ?>
**Refund Information** ℹ️

- **Method:** <?php echo e($order->payment_method === 'card' ? 'Credit/Debit Card' : 'Bank Transfer'); ?>

- **Reference Number:** MSK-REF-<?php echo e($order->order_number); ?>

- **Processing Bank:** Your bank may take additional 1-2 days
- **Notification:** You'll receive bank notification once credited
<?php echo $__env->renderComponent(); ?>

## Important Notes

### Bank Processing Time
- **Credit/Debit Cards:** 3-5 business days
- **Bank Transfers:** 2-3 business days
- **Digital Wallets:** 1-2 business days

### Check Your Statement
Look for this transaction in your bank statement:
- **Description:** MSK COMPUTERS REFUND
- **Reference:** <?php echo e($order->order_number); ?>

- **Amount:** LKR <?php echo e(number_format($order->total_amount, 2)); ?>


## Need to Check Refund Status?

<?php $__env->startComponent('mail::button', ['url' => route('orders.show', $order->order_number)]); ?>
Check Refund Status
<?php echo $__env->renderComponent(); ?>

## Still Haven't Received Your Refund?

If you don't see the refund in your account after the expected timeframe:

1. **Check with Your Bank:** Sometimes banks have additional processing delays
2. **Contact Us:** We can provide transaction proof and references
3. **Dispute Resolution:** We'll help resolve any banking issues

### Contact Information
- **Phone:** 0112 95 9005
- **WhatsApp:** +94 777 506 939
- **Email:** refunds@mskcomputers.lk

## We Value Your Feedback

Help us improve by sharing why you returned this order:

- **Product Quality Issues**
- **Delivery Problems**
- **Better Price Found**
- **Changed Mind**
- **Technical Issues**

Your feedback helps us serve customers better!

## Continue Shopping

We hope this experience doesn't discourage you from shopping with us again:

<?php $__env->startComponent('mail::button', ['url' => route('home')]); ?>
Browse Our Products
<?php echo $__env->renderComponent(); ?>

### Special Offers for You
As a valued customer, you'll continue receiving:
- **Exclusive Discounts**
- **Early Access to Sales**
- **New Product Announcements**
- **Technical Support**

## Thank You

Thank you for giving MSK Computers a try. We apologize that this particular order didn't meet your expectations, but we hope to serve you better in the future.

Best regards,  
MSK Computers Finance Team

<?php $__env->startComponent('mail::subcopy'); ?>
Refund processed: <?php echo e(now()->format('F d, Y \a\t g:i A')); ?>  
Reference: MSK-REF-<?php echo e($order->order_number); ?>  
Expected in account: <?php echo e(now()->addDays(3)->format('F d, Y')); ?> - <?php echo e(now()->addDays(5)->format('F d, Y')); ?>

<?php echo $__env->renderComponent(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\emails\order-refunded.blade.php ENDPATH**/ ?>