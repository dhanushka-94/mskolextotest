@component('mail::message')
# Order Delivered Successfully! 🎉

Hello {{ $order->customer_name }},

Great news! Your order **{{ $order->order_number }}** has been **successfully delivered**!

## Delivery Confirmation

**Delivered Date:** {{ $order->delivered_at->format('F d, Y \a\t g:i A') }}  
**Delivered To:** {{ $order->shipping_address }}  
**Order Total:** LKR {{ number_format($order->total_amount, 2) }}

## Items Delivered

@component('mail::table')
| Product | Quantity | Delivered |
|:--------|:--------:|:---------:|
@foreach($order->orderItems as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | ✅ Complete |
@endforeach
@endcomponent

@component('mail::panel')
**Quality Guarantee**

✅ All items inspected before shipping  
📦 Securely packaged to prevent damage  
🛡️ Covered by our warranty policy  
🔄 30-day return/exchange available
@endcomponent

## Next Steps

### 1. Check Your Items
Please inspect all items immediately upon delivery and report any issues within 24 hours.

### 2. Keep Your Receipt
Your delivery confirmation serves as proof of purchase for warranty claims.

### 3. Product Registration
Register your products for extended warranty and support:

@component('mail::button', ['url' => route('user.dashboard')])
Register Products
@endcomponent

## Need Support?

### Technical Support
- **Phone:** 0112 95 9005
- **WhatsApp:** +94 777 506 939
- **Email:** support@mskcomputers.lk

### Returns & Exchanges
- **Return Window:** 30 days from delivery
- **Condition:** Items must be unopened and in original packaging
- **Process:** Contact us to initiate return

### Warranty Service
- **Coverage:** As per manufacturer terms
- **Service Center:** No.12, Maradana Road, Colombo 08
- **Hours:** Monday-Saturday 9AM-7PM

@component('mail::panel')
**Feedback Request** ⭐

How was your experience with MSK Computers?  
Your feedback helps us improve our service!

**Rate Your Experience:**
- Product Quality: ⭐⭐⭐⭐⭐
- Delivery Service: ⭐⭐⭐⭐⭐
- Customer Support: ⭐⭐⭐⭐⭐
@endcomponent

## Reorder Made Easy

Love what you ordered? Reorder with one click:

@component('mail::button', ['url' => route('user.orders.detail', $order->order_number)])
Reorder Items
@endcomponent

## Follow Us

Stay updated with our latest products and offers:

- **Facebook:** MSK Computers
- **Instagram:** @mskcomputers  
- **YouTube:** MSK Computers Sri Lanka
- **Website:** www.mskcomputers.lk

Thank you for choosing MSK Computers! We hope you love your new products.

Best regards,  
The MSK Computers Team

@component('mail::subcopy')
Order completed: {{ $order->delivered_at->format('F d, Y \a\t g:i A') }}  
Order Number: {{ $order->order_number }}  
Need help? Contact us anytime at +94 777 506 939
@endcomponent
@endcomponent
