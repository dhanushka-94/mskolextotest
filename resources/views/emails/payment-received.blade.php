@component('mail::message')
# Payment Received ✅

Hello {{ $order->customer_name }},

Excellent! We've successfully received your payment for order **{{ $order->order_number }}**.

## Payment Confirmation

**Order Number:** {{ $order->order_number }}  
**Payment Date:** {{ now()->format('F d, Y \a\t g:i A') }}  
**Amount Paid:** **LKR {{ number_format($order->total_amount, 2) }}**  
**Payment Method:** {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}  
@if($order->payment_reference)
**Payment Reference:** {{ $order->payment_reference }}
@endif

## Order Summary

@component('mail::table')
| Product | Quantity | Unit Price | Total |
|:--------|:--------:|:----------:|------:|
@foreach($order->orderItems as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | LKR {{ number_format($item->unit_price, 2) }} | LKR {{ number_format($item->total_price, 2) }} |
@endforeach
@endcomponent

## Payment Breakdown

| | |
|:-----------|----------:|
| **Subtotal** | LKR {{ number_format($order->subtotal, 2) }} |
@if($order->shipping_cost > 0)
| **Shipping** | LKR {{ number_format($order->shipping_cost, 2) }} |
@endif
@if($order->tax_amount > 0)
| **Tax** | LKR {{ number_format($order->tax_amount, 2) }} |
@endif
@if($order->discount_amount > 0)
| **Discount** | -LKR {{ number_format($order->discount_amount, 2) }} |
@endif
| **Total Paid** | **LKR {{ number_format($order->total_amount, 2) }}** |

@component('mail::panel')
**Payment Status: CONFIRMED** ✅

Your payment has been verified and your order is now confirmed for processing.
@endcomponent

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

@component('mail::button', ['url' => route('orders.show', $order->order_number)])
Track Your Order
@endcomponent

## Delivery Information

**Shipping Address:**  
{{ $order->customer_name }}  
{{ $order->shipping_address_line_1 }}  
@if($order->shipping_address_line_2)
{{ $order->shipping_address_line_2 }}  
@endif
{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}  
{{ $order->shipping_country }}

**Contact Number:** {{ $order->customer_phone }}

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

@component('mail::button', ['url' => route('user.dashboard')])
My Account Dashboard
@endcomponent

## Thank You!

Thank you for your payment and for choosing MSK Computers. We appreciate your business and look forward to delivering your order soon!

Best regards,  
MSK Computers Payments Team

@component('mail::subcopy')
Payment confirmed: {{ now()->format('F d, Y \a\t g:i A') }}  
Order Number: {{ $order->order_number }}  
@if($order->payment_reference)Reference: {{ $order->payment_reference }}@endif
@endcomponent
@endcomponent
