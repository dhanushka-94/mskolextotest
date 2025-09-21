@component('mail::message')
# Order Confirmation

Hello {{ $order->customer_name }},

Thank you for your order! We've received your order and it's being processed.

## Order Details

**Order Number:** {{ $order->order_number }}  
**Order Date:** {{ $order->created_at->format('F d, Y \a\t g:i A') }}  
**Payment Method:** {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}

## Items Ordered

@component('mail::table')
| Product | Quantity | Unit Price | Total |
|:--------|:--------:|:----------:|------:|
@foreach($order->orderItems as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | LKR {{ number_format($item->unit_price, 2) }} | LKR {{ number_format($item->total_price, 2) }} |
@endforeach
@endcomponent

## Order Summary

| | |
|:-----------|----------:|
| **Subtotal** | LKR {{ number_format($order->subtotal, 2) }} |
@if($order->shipping_cost > 0)
| **Shipping** | LKR {{ number_format($order->shipping_cost, 2) }} |
@endif
@if($order->tax_amount > 0)
| **Tax** | LKR {{ number_format($order->tax_amount, 2) }} |
@endif
| **Total** | **LKR {{ number_format($order->total_amount, 2) }}** |

## Delivery Address

{{ $order->customer_name }}  
{{ $order->shipping_address_line_1 }}  
@if($order->shipping_address_line_2)
{{ $order->shipping_address_line_2 }}  
@endif
{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}  
{{ $order->shipping_country }}  
Phone: {{ $order->customer_phone }}

@if($order->payment_method === 'cash_on_delivery')
@component('mail::panel')
**Payment on Delivery**

You selected Cash on Delivery. Please have the exact amount ready when your order arrives.
@endcomponent
@elseif($order->payment_method === 'bank_transfer')
@component('mail::panel')
**Bank Transfer Details**

Please transfer the order amount to our bank account and send the payment slip to our WhatsApp number.

**Bank Details:**
- Bank: [Bank Name]
- Account Number: [Account Number]
- Account Name: MSK Computers (Pvt) Ltd

Send payment confirmation to: +94 777 506 939
@endcomponent
@endif

## What's Next?

1. **Order Processing** - We'll prepare your items for shipping
2. **Quality Check** - All items are thoroughly inspected
3. **Packaging** - Items are securely packed for delivery
4. **Shipping** - You'll receive tracking information
5. **Delivery** - Our courier will contact you for delivery

@component('mail::button', ['url' => route('orders.show', $order->order_number)])
Track Your Order
@endcomponent

@if($order->notes)
## Order Notes

{{ $order->notes }}
@endif

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

@component('mail::subcopy')
This is an automated confirmation email. Please keep this email for your records.
Order Number: {{ $order->order_number }}
@endcomponent
@endcomponent