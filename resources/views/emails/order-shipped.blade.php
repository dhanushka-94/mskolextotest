@component('mail::message')
# Order Shipped! 🚚

Hello {{ $order->customer_name }},

Excellent news! Your order **{{ $order->order_number }}** has been shipped and is on its way to you!

@if($order->tracking_number)
## Tracking Information

**Tracking Number:** {{ $order->tracking_number }}  
@if($order->courier_service)
**Courier Service:** {{ $order->courier_service }}  
@endif
**Shipped Date:** {{ $order->shipped_at->format('F d, Y \a\t g:i A') }}  
**Expected Delivery:** {{ $order->shipped_at->addDays(2)->format('F d, Y') }}
@endif

## What's Being Delivered

@component('mail::table')
| Product | Quantity | Condition |
|:--------|:--------:|:---------:|
@foreach($order->orderItems as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | ✅ Quality Checked |
@endforeach
@endcomponent

**Order Total:** LKR {{ number_format($order->total_amount, 2) }}

@if($order->tracking_number)
@component('mail::button', ['url' => '#'])
Track Your Package
@endcomponent
@endif

## Delivery Information

**Delivering To:**  
{{ $order->customer_name }}  
{{ $order->shipping_address_line_1 }}  
@if($order->shipping_address_line_2)
{{ $order->shipping_address_line_2 }}  
@endif
{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}  
**Contact:** {{ $order->customer_phone }}

@component('mail::panel')
**Important Delivery Notes**

📱 Our courier will call you before delivery  
🏠 Please ensure someone is available to receive the package  
🆔 ID verification may be required for high-value items  
📦 Items are securely packaged to prevent damage
@endcomponent

## What to Expect

🕐 **Delivery Hours:** 9:00 AM - 6:00 PM  
📞 **Courier Contact:** They'll call you 30 minutes before arrival  
💳 **Payment:** {{ $order->payment_method === 'cash_on_delivery' ? 'Have exact amount ready' : 'Already paid - No payment required' }}

@if($order->payment_method === 'cash_on_delivery')
@component('mail::panel')
**Cash on Delivery Instructions**

💰 **Amount Due:** LKR {{ number_format($order->total_amount, 2) }}  
💵 Please have the **exact amount** ready  
🧾 You'll receive an official receipt upon payment
@endcomponent
@endif

## Need Help?

- **Delivery Issues:** Contact the courier directly
- **Order Questions:** +94 777 506 939
- **Emergency Support:** 0112 95 9005

@component('mail::button', ['url' => route('orders.show', $order->order_number)])
View Order Status
@endcomponent

Thank you for choosing MSK Computers!

Best regards,  
MSK Computers Shipping Team

@component('mail::subcopy')
Shipped: {{ $order->shipped_at->format('F d, Y \a\t g:i A') }}  
@if($order->tracking_number)Tracking: {{ $order->tracking_number }}@endif
@endcomponent
@endcomponent
