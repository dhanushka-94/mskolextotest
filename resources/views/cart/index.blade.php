@extends('layouts.app')

@section('title', 'Shopping Cart - MSK Computers')

@section('content')
<div class="min-h-screen bg-black py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white">Shopping Cart</h1>
            <p class="text-gray-400 mt-2">Review your items before checkout</p>
        </div>

        @if($cartItems->isEmpty())
            <!-- Empty Cart -->
            <div class="bg-[#1a1a1c] rounded-lg border border-gray-800 p-12 text-center">
                <div class="w-24 h-24 mx-auto mb-6 text-gray-600">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V18C19 19.1 18.1 20 17 20H7C5.9 20 5 19.1 5 18V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V18H17V6H7Z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Your cart is empty</h3>
                <p class="text-gray-400 mb-6">Looks like you haven't added any items to your cart yet.</p>
                <a href="{{ route('categories.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-[#f59e0b] text-black font-semibold rounded-lg hover:bg-[#d97706] transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-[#1a1a1c] rounded-lg border border-gray-800 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-800">
                            <h2 class="text-lg font-semibold text-white">Cart Items ({{ $cartItems->sum('quantity') }})</h2>
                        </div>
                        
                        <div class="divide-y divide-gray-800">
                            @foreach($cartItems as $item)
                                <div class="p-6 cart-item" data-item-id="{{ $item->id }}">
                                    <div class="flex items-start space-x-4">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            <div class="w-20 h-20 bg-[#2c2c2e] rounded-lg overflow-hidden">
                                                <img src="{{ $item->product->main_image }}" 
                                                     alt="{{ $item->product->name }}"
                                                     class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                        
                                        <!-- Product Details -->
                                        <div class="flex-grow">
                                            <h3 class="text-white font-medium text-sm">{{ $item->product->name }}</h3>
                                            <p class="text-gray-400 text-xs mt-1">Code: {{ $item->product->code }}</p>
                                            
                                            @if($item->product->is_on_sale)
                                                <div class="flex items-center space-x-2 mt-2">
                                                    <span class="text-[#f59e0b] font-semibold">LKR {{ number_format($item->product->final_price, 2) }}</span>
                                                    <span class="text-gray-500 line-through text-sm">LKR {{ number_format($item->product->price, 2) }}</span>
                                                </div>
                                            @else
                                                <p class="text-[#f59e0b] font-semibold mt-2">LKR {{ number_format($item->product->final_price, 2) }}</p>
                                            @endif
                                            
                                            <!-- Quantity Controls -->
                                            <div class="flex items-center space-x-3 mt-3">
                                                <label class="text-gray-400 text-sm">Qty:</label>
                                                <div class="flex items-center space-x-2">
                                                    <button type="button" 
                                                            class="quantity-btn w-8 h-8 bg-[#2c2c2e] border border-gray-700 rounded text-white hover:bg-[#3c3c3e] transition-colors"
                                                            data-action="decrease" data-item-id="{{ $item->id }}">-</button>
                                                    <input type="number" 
                                                           value="{{ $item->quantity }}" 
                                                           min="1" 
                                                           max="{{ $item->product->stock_quantity }}"
                                                           class="quantity-input w-16 h-8 bg-[#2c2c2e] border border-gray-700 text-white text-center text-sm rounded focus:ring-1 focus:ring-[#f59e0b] focus:border-[#f59e0b]"
                                                           data-item-id="{{ $item->id }}"
                                                           data-max-stock="{{ $item->product->stock_quantity }}">
                                                    <button type="button" 
                                                            class="quantity-btn w-8 h-8 bg-[#2c2c2e] border border-gray-700 rounded text-white hover:bg-[#3c3c3e] transition-colors"
                                                            data-action="increase" data-item-id="{{ $item->id }}">+</button>
                                                </div>
                                                <span class="text-gray-500 text-sm">({{ number_format($item->product->stock_quantity, 0) }} available)</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Item Total & Remove -->
                                        <div class="flex-shrink-0 text-right">
                                            <p class="text-white font-semibold item-total">LKR {{ number_format($item->product->final_price * $item->quantity, 2) }}</p>
                                            <button type="button" 
                                                    class="remove-item text-red-400 hover:text-red-300 text-sm mt-2 transition-colors"
                                                    data-item-id="{{ $item->id }}">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Continue Shopping -->
                    <div class="mt-6">
                        <a href="{{ route('categories.index') }}" 
                           class="inline-flex items-center text-[#f59e0b] hover:text-[#d97706] transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Continue Shopping
                        </a>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-[#1a1a1c] rounded-lg border border-gray-800 p-6 sticky top-32">
                        <h2 class="text-lg font-semibold text-white mb-4">Order Summary</h2>
                        
                        <div class="space-y-3">
                            <!-- Subtotal (before discounts) -->
                            <div class="flex justify-between text-gray-300">
                                <span>Subtotal</span>
                                <span class="cart-original-subtotal">LKR {{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity; }), 2) }}</span>
                            </div>
                            
                            <!-- Discount (if any) -->
                            <div class="flex justify-between text-green-400 discount-row" style="{{ $cartItems->sum(function($item) { return ($item->product->price - $item->product->final_price) * $item->quantity; }) > 0 ? '' : 'display: none;' }}">
                                <span>
                                    Discount
                                    <span class="text-xs text-gray-500 block">You save</span>
                                </span>
                                <span class="cart-discount">
                                    -LKR {{ number_format($cartItems->sum(function($item) { return ($item->product->price - $item->product->final_price) * $item->quantity; }), 2) }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between text-gray-300">
                                <span>Shipping</span>
                                <span class="text-amber-400 text-xs">
                                    Pay on delivery
                                </span>
                            </div>
                            
                            <div class="border-t border-gray-700 pt-3">
                                <div class="flex justify-between text-white font-semibold text-lg">
                                    <span>Order Total</span>
                                    <span class="cart-total">LKR {{ number_format($cartTotal, 2) }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">+ Shipping charges on delivery</p>
                            </div>
                        </div>
                        
                        <div class="mt-6 space-y-3">
                            <a href="{{ route('checkout.index') }}" 
                               class="w-full bg-[#f59e0b] text-black font-semibold py-3 px-4 rounded-lg hover:bg-[#d97706] transition-colors text-center block">
                                Proceed to Checkout
                            </a>
                            <button type="button" 
                                    id="clear-cart"
                                    class="w-full bg-transparent border border-gray-700 text-gray-300 font-semibold py-3 px-4 rounded-lg hover:bg-[#2c2c2e] transition-colors">
                                Clear Cart
                            </button>
                        </div>
                    </div>
                    
                    <!-- Shipping/Delivery Information -->
                    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-lg border border-gray-800 p-6">
                        <div class="flex items-center mb-4">
                            <svg class="w-5 h-5 text-primary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                            </svg>
                            <h3 class="text-lg font-medium text-white">Shipping Information</h3>
                        </div>
                        
                        <div class="bg-amber-900/20 border border-amber-700/50 rounded-lg p-4">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-amber-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h4 class="text-amber-400 font-medium text-sm mb-2">Delivery Charges</h4>
                                    <p class="text-amber-300 text-sm mb-3">
                                        Kindly note that delivery charges are due at the time of parcel receipt.
                                    </p>
                                    <p class="text-amber-300 text-sm font-medium">
                                        පාර්සලය ලැබුණු අවස්ථාවේදී බෙදා හැරීමේ ගාස්තු ගෙවිය යුතු බව කරුණාවෙන් සලකන්න.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity buttons
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const action = this.dataset.action;
            const itemId = this.dataset.itemId;
            const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
            const maxStock = parseInt(input.dataset.maxStock);
            
            let newQuantity = parseInt(input.value);
            if (action === 'increase') {
                if (newQuantity < maxStock) {
                    newQuantity++;
                } else {
                    alert(`Maximum available quantity is ${maxStock}`);
                    return;
                }
            } else if (action === 'decrease' && newQuantity > 1) {
                newQuantity--;
            }
            
            input.value = newQuantity;
            updateCartItem(itemId, newQuantity);
        });
    });
    
    // Quantity input change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.dataset.itemId;
            const quantity = parseInt(this.value);
            const maxStock = parseInt(this.dataset.maxStock);
            
            if (quantity < 1) {
                this.value = 1;
                return;
            }
            
            if (quantity > maxStock) {
                alert(`Maximum available quantity is ${maxStock}. Setting to maximum.`);
                this.value = maxStock;
                updateCartItem(itemId, maxStock);
                return;
            }
            
            updateCartItem(itemId, quantity);
        });
    });
    
    // Remove item buttons
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            removeCartItem(itemId);
        });
    });
    
    // Clear cart button
    document.getElementById('clear-cart')?.addEventListener('click', function() {
        if (confirm('Are you sure you want to clear your cart?')) {
            clearCart();
        }
    });
    
    function updateCartItem(itemId, quantity) {
        fetch(`/cart/update/${itemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update item total
                const itemRow = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
                itemRow.querySelector('.item-total').textContent = `LKR ${data.item_total}`;
                
                // Update cart totals
                updateCartTotals(data.cart_total);
                updateCartCount(data.cart_count);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong. Please try again.');
        });
    }
    
    function removeCartItem(itemId) {
        fetch(`/cart/remove/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove item from DOM
                document.querySelector(`.cart-item[data-item-id="${itemId}"]`).remove();
                
                // Update cart totals
                updateCartTotals(data.cart_total);
                updateCartCount(data.cart_count);
                
                // Check if cart is empty
                if (data.cart_count === 0) {
                    location.reload();
                }
            }
        });
    }
    
    function clearCart() {
        fetch('/cart/clear', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
    
    function updateCartTotals(cartTotal) {
        const subtotalAfterDiscount = parseFloat(cartTotal);
        
        // Calculate original subtotal and discount for all items in cart
        let originalSubtotal = 0;
        let totalDiscount = 0;
        
        document.querySelectorAll('.cart-item').forEach(item => {
            const itemId = item.dataset.itemId;
            const quantityInput = item.querySelector('.quantity-input');
            if (quantityInput) {
                const quantity = parseInt(quantityInput.value);
                
                // Get price elements (we need to extract original and final price)
                const priceElements = item.querySelectorAll('.text-gray-500.line-through');
                if (priceElements.length > 0) {
                    // Item is on sale
                    const originalPriceText = priceElements[0].textContent;
                    const originalPrice = parseFloat(originalPriceText.replace(/[^\d.,]/g, '').replace(',', ''));
                    
                    const finalPriceElements = item.querySelectorAll('.text-\\[\\#f59e0b\\]');
                    if (finalPriceElements.length > 0) {
                        const finalPriceText = finalPriceElements[0].textContent;
                        const finalPrice = parseFloat(finalPriceText.replace(/[^\d.,]/g, '').replace(',', ''));
                        
                        originalSubtotal += originalPrice * quantity;
                        totalDiscount += (originalPrice - finalPrice) * quantity;
                    }
                } else {
                    // Item not on sale, add to original subtotal
                    const priceText = item.querySelector('.text-\\[\\#f59e0b\\]')?.textContent || '';
                    const price = parseFloat(priceText.replace(/[^\d.,]/g, '').replace(',', ''));
                    if (!isNaN(price)) {
                        originalSubtotal += price * quantity;
                    }
                }
            }
        });
        
        // Format numbers with commas for thousands
        function formatCurrency(amount) {
            return parseFloat(amount).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
        
        // Update all totals
        document.querySelector('.cart-original-subtotal').textContent = `LKR ${formatCurrency(originalSubtotal)}`;
        document.querySelector('.cart-total').textContent = `LKR ${formatCurrency(subtotalAfterDiscount)}`;
        
        // Update discount row
        const discountRow = document.querySelector('.discount-row');
        if (totalDiscount > 0) {
            document.querySelector('.cart-discount').textContent = `-LKR ${formatCurrency(totalDiscount)}`;
            discountRow.style.display = 'flex';
        } else {
            discountRow.style.display = 'none';
        }
        
        console.log('Cart totals updated:', {
            originalSubtotal: originalSubtotal,
            totalDiscount: totalDiscount,
            subtotalAfterDiscount: subtotalAfterDiscount
        });
    }
    
    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count');
        cartCountElements.forEach(element => {
            element.textContent = count;
        });
    }
});
</script>
@endpush
@endsection

@push('scripts')
<script>
    // Initialize cart count on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch and update cart count to ensure header is accurate
        if (window.fetchCartCount) {
            window.fetchCartCount();
        }
    });
</script>
@endpush
