@component('mail::message')
# Order Status Update

Hello {{ $order->customer_name }},

Your order **{{ $order->order_number }}** status has been updated.

**Previous Status:** {{ ucfirst($oldStatus) }}  
**Current Status:** {{ ucfirst($order->status) }}

## Order Details

@component('mail::table')
| Product | Quantity | Price |
|:--------|:--------:|------:|
@foreach($order->orderItems as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | LKR {{ number_format($item->total_price, 2) }} |
@endforeach
@endcomponent

**Order Total:** LKR {{ number_format($order->total_amount, 2) }}

@if($order->status === 'shipped' && $order->tracking_number)
## Tracking Information

**Tracking Number:** {{ $order->tracking_number }}  
@if($order->courier_service)
**Courier Service:** {{ $order->courier_service }}
@endif
@endif

@if($order->admin_notes)
## Additional Notes

{{ $order->admin_notes }}
@endif

@component('mail::button', ['url' => route('orders.show', $order->order_number)])
Track Your Order
@endcomponent

Thank you for shopping with MSK Computers!

Best regards,  
{{ config('app.name') }} Team

@component('mail::subcopy')
If you have any questions about your order, please contact us:
- Phone: 0112 95 9005
- WhatsApp: +94 777 506 939
- Email: info@mskcomputers.lk
@endcomponent
@endcomponent