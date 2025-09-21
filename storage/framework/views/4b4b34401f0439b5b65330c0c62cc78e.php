<?php $__env->startComponent('mail::message'); ?>
# Welcome to MSK Computers!

Hello <?php echo e($user->name); ?>,

Welcome to MSK Computers! We're excited to have you as part of our community.

## What's Next?

Now that you have an account, you can:

- **Browse our products** with personalized recommendations
- **Track your orders** in real-time
- **Save multiple addresses** for faster checkout
- **Access exclusive deals** and early sales
- **Reorder** your favorite products with one click

<?php $__env->startComponent('mail::button', ['url' => route('user.dashboard')]); ?>
Go to Your Dashboard
<?php echo $__env->renderComponent(); ?>

## Getting Started

Here are some things you might want to do:

1. **Complete your profile** - Add your phone number and address for faster checkout
2. **Browse our categories** - Discover our wide range of computer products
3. **Set up your preferences** - Save your delivery addresses

<?php $__env->startComponent('mail::panel'); ?>
**Special Offer for New Customers**

As a welcome gift, you'll receive notifications about our exclusive deals and new product launches!
<?php echo $__env->renderComponent(); ?>

## Need Help?

Our customer support team is here to help:

- **Phone:** 0112 95 9005
- **WhatsApp:** +94 777 506 939
- **Email:** info@mskcomputers.lk
- **Visit Us:** No.12, Maradana Road, Colombo 08

<?php $__env->startComponent('mail::button', ['url' => route('home')]); ?>
Start Shopping
<?php echo $__env->renderComponent(); ?>

Thank you for choosing MSK Computers!

Best regards,  
The MSK Computers Team

<?php $__env->startComponent('mail::subcopy'); ?>
Follow us on social media for the latest updates:
- Facebook: MSK Computers
- Instagram: @mskcomputers
- YouTube: MSK Computers Sri Lanka
<?php echo $__env->renderComponent(); ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\emails\welcome-new-user.blade.php ENDPATH**/ ?>