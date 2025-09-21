@extends('layouts.app')

@section('title', 'Promotions & Deals - MSK Computers')
@section('description', 'Discover amazing deals and promotions on computer hardware, gaming accessories, and tech products at MSK Computers. Limited time offers!')
@section('keywords', 'promotions, deals, discounts, sales, computer hardware deals, gaming deals, MSK Computers')

@push('head')
    <!-- Open Graph Tags -->
    <meta property="og:title" content="Promotions & Deals - MSK Computers">
    <meta property="og:description" content="Discover amazing deals and promotions on computer hardware, gaming accessories, and tech products.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/promotions-banner.jpg') }}">
    
    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Promotions & Deals - MSK Computers">
    <meta name="twitter:description" content="Discover amazing deals and promotions on computer hardware, gaming accessories, and tech products.">
    <meta name="twitter:image" content="{{ asset('images/promotions-banner.jpg') }}">
@endpush

@section('content')
<div class="min-h-screen bg-[#0f0f0f]">
    <!-- Compact Header Section -->
    <section class="relative bg-gradient-to-r from-[#0f0f0f] to-[#1a1a1c] border-b border-gray-800/30 py-8">
        <div class="absolute inset-0 bg-gradient-to-r from-[#f59e0b]/5 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-[#f59e0b] to-[#d97706] rounded-xl">
                        <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white">
                            Promotions & <span class="text-[#f59e0b]">Deals</span>
                        </h1>
                        <p class="text-sm text-gray-400 mt-1">
                            Discover amazing deals with up to 50% off!
                        </p>
                    </div>
                </div>
                <div class="hidden md:block">
                    <span class="inline-flex items-center px-4 py-2 bg-[#f59e0b]/10 border border-[#f59e0b]/20 rounded-lg text-[#f59e0b] text-sm font-medium">
                        {{ $products->total() }} Products on Sale
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content with Sidebar -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Left Sidebar - Category Filter -->
                <div class="lg:w-64 flex-shrink-0">
                    <div class="bg-[#1a1a1c] rounded-xl border border-gray-800/30 p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                            </svg>
                            Categories
                        </h3>
                        
                        <div class="space-y-2">
                            <a href="{{ route('promotions.index') }}" 
                               class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all {{ !request('category') ? 'bg-[#f59e0b] text-black' : 'text-gray-300 hover:bg-[#f59e0b]/10 hover:text-[#f59e0b]' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                All Deals
                                @if(!request('category'))
                                    <span class="ml-auto text-xs bg-black/20 px-2 py-0.5 rounded-full">{{ $products->total() }}</span>
                                @endif
                            </a>
                            
                            @foreach($categories as $category)
                                <a href="{{ route('promotions.index', ['category' => $category->slug ?: $category->id]) }}" 
                                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all group {{ request('category') == ($category->slug ?: $category->id) ? 'bg-[#f59e0b] text-black' : 'text-gray-300 hover:bg-[#f59e0b]/10 hover:text-[#f59e0b]' }}">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <span class="truncate">{{ $category->name }}</span>
                                    @if(request('category') == ($category->slug ?: $category->id))
                                        <span class="ml-auto text-xs bg-black/20 px-2 py-0.5 rounded-full">{{ $products->total() }}</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>

                        <!-- Mobile Category Count -->
                        <div class="block md:hidden mt-4 pt-4 border-t border-gray-700">
                            <span class="inline-flex items-center px-3 py-1.5 bg-[#f59e0b]/10 border border-[#f59e0b]/20 rounded-lg text-[#f59e0b] text-xs font-medium">
                                {{ $products->total() }} Products on Sale
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Products Grid -->
                <div class="flex-1">
                    @if($products->count() > 0)
                        <!-- Products Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-12">
                    @foreach($products as $product)
                        <a href="{{ route('products.show', ['category' => $product->category->slug ?: $product->category->id, 'product' => $product->slug]) }}" 
                           class="group bg-[#1c1c1e] rounded-xl border border-gray-800/30 overflow-hidden hover:border-[#f59e0b]/30 transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-[#f59e0b]/10">
                            
                            <!-- Product Image -->
                            <div class="relative overflow-hidden bg-[#1a1a1c] aspect-square">
                                <img 
                                    src="{{ $product->main_image }}" 
                                    alt="{{ $product->name }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                    loading="lazy"
                                >
                                
                                <!-- Sale Badge -->
                                <div class="absolute top-3 left-3">
                                    <div class="bg-gradient-to-r from-[#ef4444] to-[#dc2626] text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-lg">
                                        SALE
                                    </div>
                                </div>

                                <!-- Stock Status -->
                                <div class="absolute top-3 right-3">
                                    <div class="bg-green-500/90 text-white text-xs font-medium px-2 py-1 rounded-lg backdrop-blur-sm">
                                        In Stock
                                    </div>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <div class="mb-2">
                                    <span class="text-xs text-[#f59e0b] font-medium">{{ $product->category->name }}</span>
                                </div>
                                
                                <h3 class="text-sm font-semibold text-white mb-3 line-clamp-2 group-hover:text-[#f59e0b] transition-colors">
                                    {{ $product->name }}
                                </h3>

                                <!-- Pricing -->
                                <div class="mb-4">
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-lg font-bold text-[#f59e0b]">
                                            LKR {{ number_format($product->promo_price, 2) }}
                                        </span>
                                        <span class="text-sm text-gray-500 line-through">
                                            LKR {{ number_format($product->price, 2) }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-green-400 font-medium">
                                        Save LKR {{ number_format($product->price - $product->promo_price, 2) }}
                                    </div>
                                </div>

                                <!-- Product Status Badge -->
                                @if($product->status)
                                    <div class="mb-3">
                                        @include('components.product-status-badge', ['product' => $product])
                                    </div>
                                @endif
                                
                                <!-- Payment Method Badges -->
                                @include('components.payment-badges')

                                <!-- Add to Cart Button -->
                                <div class="mt-auto">
                                    @if($product->can_add_to_cart)
                                        <button onclick="event.preventDefault(); event.stopPropagation(); addToCartFromPromo({{ $product->id }}, '{{ addslashes($product->name) }}')" 
                                                class="w-full bg-[#f59e0b] hover:bg-[#d97706] text-black px-4 py-2.5 rounded-lg text-sm font-semibold transition-all">
                                            Add to Cart
                                        </button>
                                    @else
                                        <button class="w-full bg-gray-600/50 text-gray-400 px-4 py-2.5 rounded-lg text-sm font-semibold cursor-not-allowed" 
                                                disabled title="{{ $product->cart_restriction_reason }}">
                                            {{ $product->cart_restriction_reason ?: 'Unavailable' }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                        <!-- Pagination -->
                        <div class="flex justify-center">
                            {{ $products->appends(request()->query())->links('custom.pagination') }}
                        </div>
                    @else
                        <!-- No Products -->
                        <div class="text-center py-16">
                            <div class="w-24 h-24 bg-[#2c2c2e] rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-2">No Active Promotions</h3>
                            <p class="text-gray-400 mb-6">There are currently no promotional products available in this category. Check back soon for amazing deals!</p>
                            <a href="{{ route('products.index') }}" 
                               class="inline-flex items-center px-6 py-3 bg-[#f59e0b] hover:bg-[#d97706] text-black font-semibold rounded-lg transition-all">
                                Browse All Products
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Notification Container -->
<div id="notification-container" class="fixed top-20 right-4 z-[9999]"></div>

<script>
// Enhanced Add to Cart from Promotions Page with Animations
function addToCartFromPromo(productId, productName = 'Promotional Item') {
    const button = event.target;
    const originalText = button.textContent;
    
    // Disable button during request
    button.disabled = true;
    button.textContent = 'Adding...';
    
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        button.disabled = false;
        button.textContent = originalText;
        
        if (data.success) {
            // Animate cart addition with enhanced effects
            window.animateCartAddition(data.cart_count, productName, data.cart_total);
            
            // Add special promotional success effect
            button.classList.add('cart-success-flash');
            setTimeout(() => {
                button.classList.remove('cart-success-flash');
            }, 1000);
            
        } else {
            showNotification(data.message || 'Failed to add product to cart', 'error');
        }
    })
    .catch(error => {
        button.disabled = false;
        button.textContent = originalText;
        console.error('Error:', error);
        showNotification('An error occurred. Please try again.', 'error');
    });
}

// Show notification function
function showNotification(message, type = 'success') {
    const container = document.getElementById('notification-container');
    const notification = document.createElement('div');
    
    notification.className = `p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full opacity-0 mb-4 ${
        type === 'success' 
            ? 'bg-green-500 text-white' 
            : 'bg-red-500 text-white'
    }`;
    
    notification.innerHTML = `
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
                ${type === 'success' 
                    ? '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>'
                    : '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>'
                }
            </div>
            <div class="flex-1 text-sm font-medium">${message}</div>
        </div>
    `;
    
    container.appendChild(notification);
    
    // Trigger animation
    setTimeout(() => {
        notification.classList.remove('translate-x-full', 'opacity-0');
    }, 100);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => {
            container.removeChild(notification);
        }, 300);
    }, 3000);
}
</script>
@endsection
