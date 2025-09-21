<?php $__env->startComponent('mail::message'); ?>
# Order Confirmation

Hello <?php echo e($order->customer_name); ?>,

Thank you for your order! We've received your order and it's being processed.

## Order Details

**Order Number:** <?php echo e($order->order_number); ?>  
**Order Date:** <?php echo e($order->created_at->format('F d, Y \a\t g:i A')); ?>  
**Payment Method:** <?php echo e(ucfirst(str_replace('_', ' ', $order->payment_method))); ?>


## Items Ordered

<?php $__env->startComponent('mail::table'); ?>
| Product | Quantity | Unit Price | Total |
|:--------|:--------:|:----------:|------:|
<?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
| <?php echo e($item->product_name); ?> | <?php echo e($item->quantity); ?> | LKR <?php echo e(number_format($item->unit_price, 2)); ?> | LKR <?php echo e(number_format($item->total_price, 2)); ?> |
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->renderComponent(); ?>

## Order Summary

| | |
|:-----------|----------:|
| **Subtotal** | LKR <?php echo e(number_format($order->subtotal, 2)); ?> |
<?php if($order->shipping_cost > 0): ?>
| **Shipping** | LKR <?php echo e(number_format($order->shipping_cost, 2)); ?> |
<?php endif; ?>
<?php if($order->tax_amount > 0): ?>
| **Tax** | LKR <?php echo e(number_format($order->tax_amount, 2)); ?> |
<?php endif; ?>
| **Total** | **LKR <?php echo e(number_format($order->total_amount, 2)); ?>** |

## Delivery Address

<?php echo e($order->customer_name); ?>  
<?php echo e($order->shipping_address_line_1); ?>  
<?php if($order->shipping_address_line_2): ?>
<?php echo e($order->shipping_address_line_2); ?>  
<?php endif; ?>
<?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_state); ?> <?php echo e($order->shipping_postal_code); ?>  
<?php echo e($order->shipping_country); ?>  
Phone: <?php echo e($order->customer_phone); ?>


<?php if($order->payment_method === 'cash_on_delivery'): ?>
<?php $__env->startComponent('mail::panel'); ?>
**Payment on Delivery**

You selected Cash on Delivery. Please have the exact amount ready when your order arrives.
<?php echo $__env->renderComponent(); ?>
<?php elseif($order->payment_method === 'bank_transfer'): ?>
<?php $__env->startComponent('mail::panel'); ?>
**Bank Transfer Details**

Please transfer the order amount to our bank account and send the payment slip to our WhatsApp number.

**Bank Details:**
- Bank: [Bank Name]
- Account Number: [Account Number]
- Account Name: MSK Computers (Pvt) Ltd

Send payment confirmation to: +94 777 506 939
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

## What's Next?

1. **Order Processing** - We'll prepare your items for shipping
2. **Quality Check** - All items are thoroughly inspected
3. **Packaging** - Items are securely packed for delivery
4. **Shipping** - You'll receive tracking information
5. **Delivery** - Our courier will contact you for delivery

<?php $__env->startComponent('mail::button', ['url' => route('orders.show', $order->order_number)]); ?>
Track Your Order
<?php echo $__env->renderComponent(); ?>

<?php if($order->notes): ?>
## Order Notes

<?php echo e($order->notes); ?>

<?php endif; ?>

## Contact Information

If you have any questions about your order:

- **Phone:** 0112 95 9005
- **WhatsApp:** +94 777 506 939 (24/7 Support)
- **Email:** info@mskcomputers.lk

**Store Location:**  
No.12, Maradana Road, Colombo 08

**Business Hours:**  
Monday - Saturday: 9:00 AM - 7:00 PM  
Sunday: 10:00 AM - 6:00 PM

Thank you for choosing MSK Computers!

Best regards,  
MSK Computers Team

<?php $__env->startComponent('mail::subcopy'); ?>
This is an automated confirmation email. Please keep this email for your records.
Order Number: <?php echo e($order->order_number); ?>

<?php echo $__env->renderComponent(); ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\emails\order-confirmation.blade.php ENDPATH**/ ?>