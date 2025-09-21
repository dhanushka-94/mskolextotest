@component('mail::message')
# Order Being Prepared 🔄

Hello {{ $order->customer_name }},

Your order **{{ $order->order_number }}** is now being processed in our warehouse!

## Current Status: Processing

Our team is carefully:
- ✅ Picking your items from inventory
- 🔍 Quality checking each product
- 📦 Preparing secure packaging
- 🏷️ Generating shipping labels

## Order Summary

@component('mail::table')
| Product | Quantity | Status |
|:--------|:--------:|:------:|
@foreach($order->orderItems as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | ✅ In Process |
@endforeach
@endcomponent

**Order Total:** LKR {{ number_format($order->total_amount, 2) }}

@if($order->payment_status === 'paid')
@component('mail::panel')
**Payment Confirmed** ✅

Your payment has been received and processed successfully.
@endcomponent
@else
@component('mail::panel')
**Payment Pending** ⏳

Please ensure your payment is completed to avoid delays:
- Bank Transfer: Send confirmation to +94 777 506 939
- Card Payment: Check your payment status
@endcomponent
@endif

## Delivery Information

**Shipping Address:**  
{{ $order->customer_name }}  
{{ $order->shipping_address_line_1 }}  
@if($order->shipping_address_line_2)
{{ $order->shipping_address_line_2 }}  
@endif
{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}

## Expected Timeline

🕐 **Processing Time:** 24-48 hours  
🚚 **Shipping Time:** 2-3 business days  
📅 **Expected Delivery:** {{ now()->addDays(4)->format('F d, Y') }}

@component('mail::button', ['url' => route('orders.show', $order->order_number)])
View Order Details
@endcomponent

## Contact Us

Questions about your order processing?

- **Phone:** 0112 95 9005
- **WhatsApp:** +94 777 506 939
- **Email:** info@mskcomputers.lk

We'll notify you as soon as your order ships!

Best regards,  
MSK Computers Fulfillment Team

@component('mail::subcopy')
Processing started: {{ now()->format('F d, Y \a\t g:i A') }}  
Estimated completion: {{ now()->addHours(48)->format('F d, Y \a\t g:i A') }}
@endcomponent
@endcomponent
