<?php $__env->startComponent('mail::message'); ?>
# Payment Received ✅

Hello <?php echo e($order->customer_name); ?>,

Excellent! We've successfully received your payment for order **<?php echo e($order->order_number); ?>**.

## Payment Confirmation

**Order Number:** <?php echo e($order->order_number); ?>  
**Payment Date:** <?php echo e(now()->format('F d, Y \a\t g:i A')); ?>  
**Amount Paid:** **LKR <?php echo e(number_format($order->total_amount, 2)); ?>**  
**Payment Method:** <?php echo e(ucfirst(str_replace('_', ' ', $order->payment_method))); ?>  
<?php if($order->payment_reference): ?>
**Payment Reference:** <?php echo e($order->payment_reference); ?>

<?php endif; ?>

## Order Summary

<?php $__env->startComponent('mail::table'); ?>
| Product | Quantity | Unit Price | Total |
|:--------|:--------:|:----------:|------:|
<?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
| <?php echo e($item->product_name); ?> | <?php echo e($item->quantity); ?> | LKR <?php echo e(number_format($item->unit_price, 2)); ?> | LKR <?php echo e(number_format($item->total_price, 2)); ?> |
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->renderComponent(); ?>

## Payment Breakdown

| | |
|:-----------|----------:|
| **Subtotal** | LKR <?php echo e(number_format($order->subtotal, 2)); ?> |
<?php if($order->shipping_cost > 0): ?>
| **Shipping** | LKR <?php echo e(number_format($order->shipping_cost, 2)); ?> |
<?php endif; ?>
<?php if($order->tax_amount > 0): ?>
| **Tax** | LKR <?php echo e(number_format($order->tax_amount, 2)); ?> |
<?php endif; ?>
<?php if($order->discount_amount > 0): ?>
| **Discount** | -LKR <?php echo e(number_format($order->discount_amount, 2)); ?> |
<?php endif; ?>
| **Total Paid** | **LKR <?php echo e(number_format($order->total_amount, 2)); ?>** |

<?php $__env->startComponent('mail::panel'); ?>
**Payment Status: CONFIRMED** ✅

Your payment has been verified and your order is now confirmed for processing.
<?php echo $__env->renderComponent(); ?>

## What Happens Next?

Now that your payment is confirmed:

1. **Order Processing** - We'll start preparing your items immediately
2. **Quality Check** - Each item will be inspected for quality
3. **Packaging** - Items will be securely packed
4. **Shipping** - You'll receive tracking information within 24-48 hours

### Expected Timeline
- **Processing:** 1-2 business days
- **Shipping:** 2-3 business days
- **Total Delivery:** 3-5 business days

<?php $__env->startComponent('mail::button', ['url' => route('orders.show', $order->order_number)]); ?>
Track Your Order
<?php echo $__env->renderComponent(); ?>

## Delivery Information

**Shipping Address:**  
<?php echo e($order->customer_name); ?>  
<?php echo e($order->shipping_address_line_1); ?>  
<?php if($order->shipping_address_line_2): ?>
<?php echo e($order->shipping_address_line_2); ?>  
<?php endif; ?>
<?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_state); ?> <?php echo e($order->shipping_postal_code); ?>  
<?php echo e($order->shipping_country); ?>


**Contact Number:** <?php echo e($order->customer_phone); ?>


## Receipt & Warranty

### Digital Receipt
This email serves as your official payment receipt. Please keep it for:
- **Warranty Claims**
- **Returns/Exchanges**
- **Tax Records**
- **Future Reference**

### Warranty Information
- **Manufacturer Warranty:** As per product specifications
- **MSK Service Support:** Available at our service center
- **Extended Warranty:** Available for purchase

## Payment Security

✅ **Secure Transaction:** Your payment was processed through secure channels  
🔒 **Data Protection:** Your payment information is encrypted and protected  
🛡️ **Fraud Prevention:** Transaction verified through multiple security layers

## Need Help?

Questions about your payment or order?

- **Phone:** 0112 95 9005
- **WhatsApp:** +94 777 506 939
- **Email:** orders@mskcomputers.lk

### Account Access
View your order status anytime:

<?php $__env->startComponent('mail::button', ['url' => route('user.dashboard')]); ?>
My Account Dashboard
<?php echo $__env->renderComponent(); ?>

## Thank You!

Thank you for your payment and for choosing MSK Computers. We appreciate your business and look forward to delivering your order soon!

Best regards,  
MSK Computers Payments Team

<?php $__env->startComponent('mail::subcopy'); ?>
Payment confirmed: <?php echo e(now()->format('F d, Y \a\t g:i A')); ?>  
Order Number: <?php echo e($order->order_number); ?>  
<?php if($order->payment_reference): ?>Reference: <?php echo e($order->payment_reference); ?><?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\emails\payment-received.blade.php ENDPATH**/ ?>