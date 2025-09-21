@component('mail::message')
# Refund Processed Successfully 💰

Hello {{ $order->customer_name }},

Your refund for order **{{ $order->order_number }}** has been successfully processed.

## Refund Details

**Order Number:** {{ $order->order_number }}  
**Refund Date:** {{ now()->format('F d, Y \a\t g:i A') }}  
**Refund Amount:** **LKR {{ number_format($order->total_amount, 2) }}**  
**Processing Method:** Refund to original payment method

## Timeline

- **Refund Initiated:** {{ now()->format('F d, Y') }}
- **Expected in Account:** {{ now()->addDays(3)->format('F d, Y') }} - {{ now()->addDays(5)->format('F d, Y') }}
- **Bank Processing:** 3-5 business days

## Refunded Items

@component('mail::table')
| Product | Quantity | Unit Price | Refunded Amount |
|:--------|:--------:|:----------:|----------------:|
@foreach($order->orderItems as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | LKR {{ number_format($item->unit_price, 2) }} | LKR {{ number_format($item->total_price, 2) }} |
@endforeach
@endcomponent

**Total Refunded:** **LKR {{ number_format($order->total_amount, 2) }}**

@component('mail::panel')
**Refund Information** ℹ️

- **Method:** {{ $order->payment_method === 'card' ? 'Credit/Debit Card' : 'Bank Transfer' }}
- **Reference Number:** MSK-REF-{{ $order->order_number }}
- **Processing Bank:** Your bank may take additional 1-2 days
- **Notification:** You'll receive bank notification once credited
@endcomponent

## Important Notes

### Bank Processing Time
- **Credit/Debit Cards:** 3-5 business days
- **Bank Transfers:** 2-3 business days
- **Digital Wallets:** 1-2 business days

### Check Your Statement
Look for this transaction in your bank statement:
- **Description:** MSK COMPUTERS REFUND
- **Reference:** {{ $order->order_number }}
- **Amount:** LKR {{ number_format($order->total_amount, 2) }}

## Need to Check Refund Status?

@component('mail::button', ['url' => route('orders.show', $order->order_number)])
Check Refund Status
@endcomponent

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

@component('mail::button', ['url' => route('home')])
Browse Our Products
@endcomponent

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

@component('mail::subcopy')
Refund processed: {{ now()->format('F d, Y \a\t g:i A') }}  
Reference: MSK-REF-{{ $order->order_number }}  
Expected in account: {{ now()->addDays(3)->format('F d, Y') }} - {{ now()->addDays(5)->format('F d, Y') }}
@endcomponent
@endcomponent
