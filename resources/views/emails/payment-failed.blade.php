@component('mail::message')
# Payment Failed ❌

Hello {{ $order->customer_name }},

We encountered an issue processing your payment for order **{{ $order->order_number }}**.

## Payment Details

**Order Number:** {{ $order->order_number }}  
**Attempted Date:** {{ now()->format('F d, Y \a\t g:i A') }}  
**Amount:** LKR {{ number_format($order->total_amount, 2) }}  
**Payment Method:** {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}  
**Status:** Failed

## Possible Reasons

The payment might have failed due to:

- 💳 **Insufficient Funds** - Please check your account balance
- 🔒 **Card Security Block** - Your bank may have blocked the transaction
- 📝 **Incorrect Details** - Please verify card number, expiry, or CVV
- 🌐 **Network Issues** - Temporary connection problems
- 🏦 **Bank Decline** - Contact your bank for authorization

## Your Order Status

**Current Status:** Payment Pending  
**Order Expiry:** {{ now()->addHours(24)->format('F d, Y \a\t g:i A') }}

@component('mail::panel')
**Action Required** ⚠️

Your order is **reserved for 24 hours**. Please complete payment to avoid cancellation.
@endcomponent

## Complete Your Payment

Choose your preferred payment method:

### Option 1: Retry Online Payment
@component('mail::button', ['url' => route('payment.retry', $order->order_number)])
Retry Payment
@endcomponent

### Option 2: Bank Transfer
**Bank Details:**
- **Bank:** People's Bank
- **Account Name:** MSK Computers (Pvt) Ltd
- **Account Number:** 0123456789
- **Branch:** Maradana

**Instructions:**
1. Transfer LKR {{ number_format($order->total_amount, 2) }}
2. Send payment slip to WhatsApp: +94 777 506 939
3. Include order number: {{ $order->order_number }}

### Option 3: Visit Our Store
**MSK Computers Showroom**  
No.12, Maradana Road, Colombo 08  
**Hours:** Monday-Saturday 9AM-7PM

**Payment Options Available:**
- 💳 Credit/Debit Cards
- 💰 Cash Payment
- 🏦 Bank Transfer
- 📱 Mobile Payment

## Order Summary

@component('mail::table')
| Product | Quantity | Price |
|:--------|:--------:|------:|
@foreach($order->orderItems as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | LKR {{ number_format($item->total_price, 2) }} |
@endforeach
@endcomponent

**Total Amount:** **LKR {{ number_format($order->total_amount, 2) }}**

## Need Assistance?

Our team is ready to help you complete your payment:

### Immediate Support
- **WhatsApp:** +94 777 506 939 (24/7)
- **Phone:** 0112 95 9005
- **Email:** payments@mskcomputers.lk

### Common Solutions

#### For Card Payments
1. **Check Balance** - Ensure sufficient funds
2. **Contact Bank** - Ask them to authorize the transaction
3. **Try Different Card** - Use an alternative card
4. **Use Different Browser** - Clear cache and try again

#### For Bank Issues
1. **Call Your Bank** - Explain you're making an online purchase
2. **Check Daily Limits** - Ensure you haven't exceeded spending limits
3. **Verify Card Status** - Make sure your card is active

@component('mail::panel')
**Important Reminder** ⏰

- **Order Reserved Until:** {{ now()->addHours(24)->format('F d, Y \a\t g:i A') }}
- **Auto-Cancellation:** Order will be cancelled if payment not received
- **Inventory Hold:** Items are held for you during this period
@endcomponent

## Alternative Products

If you're unable to complete this payment, you might be interested in similar products:

@component('mail::button', ['url' => route('home')])
Browse Similar Products
@endcomponent

## We're Here to Help

Don't let a payment issue stop you from getting the products you need. Our team will work with you to find a solution.

**Contact us now:** +94 777 506 939

Best regards,  
MSK Computers Payment Support Team

@component('mail::subcopy')
Payment failed: {{ now()->format('F d, Y \a\t g:i A') }}  
Order expires: {{ now()->addHours(24)->format('F d, Y \a\t g:i A') }}  
Need help? WhatsApp +94 777 506 939
@endcomponent
@endcomponent
