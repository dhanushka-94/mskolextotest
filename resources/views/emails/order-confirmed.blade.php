@component('mail::message')
# Order Confirmed ✅

Hello {{ $order->customer_name }},

Great news! Your order has been **confirmed** and is now in our system.

## Order Details

**Order Number:** {{ $order->order_number }}  
**Confirmation Date:** {{ now()->format('F d, Y \a\t g:i A') }}  
**Payment Status:** {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}

## Items Confirmed

@component('mail::table')
| Product | Quantity | Unit Price | Total |
|:--------|:--------:|:----------:|------:|
@foreach($order->orderItems as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | LKR {{ number_format($item->unit_price, 2) }} | LKR {{ number_format($item->total_price, 2) }} |
@endforeach
@endcomponent

**Order Total:** **LKR {{ number_format($order->total_amount, 2) }}**

@component('mail::panel')
**What's Next?**

✅ Your order is confirmed  
🔄 We'll start processing your items  
📦 You'll receive updates as we prepare your order  
🚚 Shipping details will be sent once dispatched
@endcomponent

## Estimated Timeline

- **Processing:** 1-2 business days
- **Shipping:** 2-3 business days within Colombo
- **Total Delivery Time:** 3-5 business days

@component('mail::button', ['url' => route('orders.show', $order->order_number)])
Track Your Order
@endcomponent

## Need to Make Changes?

If you need to modify or cancel your order, please contact us **within 2 hours** of confirmation:

- **Phone:** 0112 95 9005
- **WhatsApp:** +94 777 506 939 (Immediate Response)
- **Email:** info@mskcomputers.lk

Thank you for choosing MSK Computers!

Best regards,  
MSK Computers Team

@component('mail::subcopy')
Order confirmed at {{ now()->format('F d, Y \a\t g:i A') }}  
Order Number: {{ $order->order_number }}
@endcomponent
@endcomponent
