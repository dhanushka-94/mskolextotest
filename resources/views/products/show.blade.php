@extends('layouts.app')

@section('title', $product->name . ' - MSK COMPUTERS')
@section('description', $product->details ? Str::limit(strip_tags($product->details), 160) : $product->name . ' - Premium computer hardware at MSK Computers. ' . ($product->category ? $product->category->name : '') . ' with warranty and quality assurance.')
@section('keywords', $product->name . ', ' . ($product->category ? $product->category->name : '') . ', MSK Computers, computer hardware, Sri Lanka, ' . ($product->code ? $product->code : ''))
@section('og_title', $product->name . ' - LKR ' . number_format($product->final_price, 2) . ' at MSK COMPUTERS')
@section('og_description', $product->details ? Str::limit(strip_tags($product->details), 200) : 'Premium ' . $product->name . ' available at MSK Computers with warranty and quality assurance.')
@section('og_image', $product->main_image)
@section('og_type', 'product')

@section('content')
<!-- Product Details -->
<section class="py-12 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Images -->
            <div class="p-6 bg-gradient-to-br from-gray-900 to-black rounded-xl border border-gray-800">
                <!-- Main Image -->
                <div class="mb-6 p-4 bg-black/30 rounded-xl border border-gray-700/50">
                    <img id="mainImage" 
                         src="{{ $product->images[0] ?? 'https://via.placeholder.com/600x400?text=No+Image' }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-96 object-contain rounded-lg shadow-2xl p-4 bg-white/5 backdrop-blur-sm">
                </div>
                
                <!-- Thumbnail Images -->
                @if(count($product->images) > 1)
                    <div class="grid grid-cols-4 gap-3 p-2">
                        @foreach($product->images as $index => $image)
                            <div class="p-2 bg-black/20 rounded-lg border border-gray-700/30 hover:border-primary-500/50 transition-all">
                                <img src="{{ $image }}" 
                                     alt="{{ $product->name }} - Image {{ $index + 1 }}"
                                     class="w-full h-20 object-contain rounded cursor-pointer hover:opacity-80 transition-opacity p-1 bg-white/5 {{ $index === 0 ? 'ring-2 ring-primary-500' : '' }}"
                                     onclick="changeMainImage('{{ $image }}', this)">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <!-- Breadcrumb -->
                <nav class="text-sm mb-4">
                    <ol class="flex items-center space-x-2 text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-primary-400">Home</a></li>
                        <li>/</li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-primary-400">Products</a></li>
                        <li>/</li>
                        <li><a href="{{ route('categories.show', $product->category->slug ?: $product->category->id) }}" class="hover:text-primary-400">{{ $product->category->name }}</a></li>
                        <li>/</li>
                        <li class="text-gray-500">{{ $product->name }}</li>
                    </ol>
                </nav>

                <!-- Product Title -->
                <div class="mb-4">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-sm text-primary-400 font-medium">{{ $product->category->name }}</span>
                        @if($product->is_on_sale)
                            <div class="flex items-center gap-2">
                                <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse">
                                    HOT DEAL
                                </span>
                                <span class="bg-primary-500 text-black text-xs font-bold px-2 py-1 rounded">
                                    SAVE LKR {{ number_format($product->price - $product->promo_price, 2) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mt-1">{{ $product->name }}</h1>
                </div>

                <!-- Price -->
                <div class="mb-6">
                    @if($product->is_on_sale)
                        <div class="bg-gradient-to-r from-primary-500/10 to-red-500/10 border border-primary-500/20 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-3xl font-bold text-primary-400">LKR {{ number_format($product->promo_price, 2) }}</span>
                                <span class="text-xl text-gray-400 line-through">LKR {{ number_format($product->price, 2) }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-green-400 font-semibold text-sm">
                                    💰 You Save: LKR {{ number_format($product->price - $product->promo_price, 2) }}
                                </span>
                                <span class="text-green-400 font-semibold text-sm">
                                    ({{ round((($product->price - $product->promo_price) / $product->price) * 100) }}% OFF)
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="bg-black/50 border border-gray-800 rounded-xl p-4">
                            @if($product->price > 0)
                                <span class="text-3xl font-bold text-primary-400">LKR {{ number_format($product->price, 2) }}</span>
                            @else
                                <span class="text-3xl font-bold text-primary-400">Contact for Price</span>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Payment Method Badges -->
                <div class="mb-6">
                    @include('components.payment-badges')
                </div>

                <!-- Product Status -->
                <div class="mb-6">
                    @if($product->status)
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-400 mb-2">Product Status:</h4>
                            @include('components.product-status-badge', ['product' => $product])
                        </div>
                    @endif
                    
                    <!-- Stock Status -->
                    @if($product->stock_quantity > 0)
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                            <span class="text-green-400 font-medium">{{ $product->stock_quantity }} in stock</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                            <span class="text-red-400 font-medium">Out of Stock</span>
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-white mb-2">Description</h3>
                    <p class="text-gray-300 leading-relaxed">{{ $product->description }}</p>
                </div>

                <!-- Specifications -->
                @if($product->specifications)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-white mb-2">Specifications</h3>
                        <p class="text-gray-300 leading-relaxed">{{ $product->specifications }}</p>
                    </div>
                @endif

                <!-- Product Attributes -->
                @if($product->grouped_attributes && count($product->grouped_attributes) > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Product Attributes</h3>
                        <div class="bg-[#1c1c1e] rounded-xl border border-gray-800/30 p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($product->grouped_attributes as $attributeName => $attributeValues)
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-[#f59e0b] mb-2">{{ $attributeName }}</span>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($attributeValues as $value)
                                                <span class="inline-block bg-[#2c2c2e] text-gray-300 text-xs font-medium px-3 py-1 rounded-lg border border-gray-700">
                                                    {{ $value }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Product Meta -->
                <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                    <div>
                        <span class="text-gray-400">SKU:</span>
                        <span class="text-white ml-2">{{ $product->sku }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400">Brand:</span>
                        <span class="text-white ml-2">{{ $product->brand }}</span>
                    </div>
                    @if($product->warranty)
                        <div>
                            <span class="text-gray-400">Warranty:</span>
                            <span class="text-white ml-2">{{ $product->warranty }}</span>
                        </div>
                    @endif
                    <div>
                        <span class="text-gray-400">Category:</span>
                        <span class="text-white ml-2">{{ $product->category->name }}</span>
                    </div>
                </div>

                <!-- Add to Cart Section -->
                <div class="border-t border-dark-700 pt-6">
                    @if($product->can_add_to_cart)
                        <div class="@if($product->is_on_sale) bg-gradient-to-r from-primary-500/5 to-red-500/5 border border-primary-500/20 @else bg-black/50 border border-gray-800 @endif rounded-xl p-4">
                            @if($product->is_on_sale)
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="text-red-400 font-semibold text-sm animate-pulse">⚡ Limited Time Offer!</span>
                                    <span class="text-gray-400 text-sm">Act fast before it's gone!</span>
                                </div>
                            @endif
                            
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="flex items-center border border-dark-600 rounded-lg">
                                    <button type="button" class="px-3 py-2 text-gray-300 hover:text-primary-400" onclick="decreaseQuantity()">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <input type="number" id="quantity" value="1" min="1" max="99" 
                                           class="w-16 py-2 text-center bg-transparent text-white border-0 focus:outline-none">
                                    <button type="button" class="px-3 py-2 text-gray-300 hover:text-primary-400" onclick="increaseQuantity()">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                                <button class="@if($product->is_on_sale) bg-gradient-to-r from-primary-500 to-red-500 hover:from-primary-600 hover:to-red-600 @else btn-primary @endif flex-1 text-lg py-3 font-semibold transition-all transform hover:scale-105" onclick="addToCart({{ $product->id }})">
                                    @if($product->is_on_sale)
                                        Add to Cart (SALE!)
                                    @else
                                        Add to Cart
                                    @endif
                                </button>
                                <button class="btn-outline px-6 py-3" onclick="addToWishlist({{ $product->id }})">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-6 text-center">
                            <div class="text-red-400 text-xl font-semibold mb-2">{{ $product->cart_restriction_reason ?: 'Unavailable' }}</div>
                            @if($product->status && in_array($product->status->status_name, ['Coming Soon', 'Pre Order', 'In Stock (for PC Build)', 'Reserved']))
                                <p class="text-gray-400">{{ $product->cart_restriction_reason }}</p>
                            @else
                                <p class="text-gray-400">This product is currently unavailable.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
    <section class="py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-white text-center mb-12">Related Products</h2>
            
            <div class="product-grid">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="card card-hover overflow-hidden">
                        <div class="relative">
                            <a href="{{ route('products.show', ['category' => $relatedProduct->category->slug ?: $relatedProduct->category->id, 'product' => $relatedProduct->slug]) }}">
                                <div class="p-3 bg-gradient-to-br from-gray-900 to-black">
                                    <img src="{{ $relatedProduct->images[0] ?? 'https://via.placeholder.com/400x300?text=No+Image' }}" 
                                         alt="{{ $relatedProduct->name }}" 
                                         class="w-full h-48 object-contain p-4 bg-white/5 rounded-lg">
                                </div>
                            </a>
                            
                            @if($relatedProduct->is_on_sale)
                                <div class="absolute top-2 right-2">
                                    <span class="badge-sale">SALE</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-white mb-2">
                                <a href="{{ route('products.show', ['category' => $relatedProduct->category->slug ?: $relatedProduct->category->id, 'product' => $relatedProduct->slug]) }}" class="hover:text-primary-400 transition-colors">
                                    {{ $relatedProduct->name }}
                                </a>
                            </h3>
                            <p class="text-gray-400 text-sm mb-4">{{ Str::limit($relatedProduct->description, 80) }}</p>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    @if($relatedProduct->is_on_sale)
                                        <span class="text-sm text-gray-500 line-through">LKR {{ number_format($relatedProduct->price, 2) }}</span>
                                        <span class="text-lg font-bold text-[#f59e0b] ml-2">LKR {{ number_format($relatedProduct->promo_price, 2) }}</span>
                                    @else
                                        @if($relatedProduct->price > 0)
                                            <span class="text-lg font-bold text-white">LKR {{ number_format($relatedProduct->price, 2) }}</span>
                                        @else
                                            <span class="text-lg font-bold text-[#f59e0b]">Contact for Price</span>
                                        @endif
                                    @endif
                                </div>

                                <!-- Product Status Badge -->
                                @if($relatedProduct->status)
                                    <div class="mb-3">
                                        @include('components.product-status-badge', ['product' => $relatedProduct])
                                    </div>
                                @endif
                                
                                <!-- Payment Method Badges -->
                                @include('components.payment-badges')
                                
                                @if($relatedProduct->can_add_to_cart)
                                    <button class="btn-primary px-4 py-2 text-sm" onclick="addToCart({{ $relatedProduct->id }})">
                                        Add to Cart
                                    </button>
                                @else
                                    <button class="btn-secondary px-4 py-2 text-sm opacity-50 cursor-not-allowed" disabled 
                                            title="{{ $relatedProduct->cart_restriction_reason }}">
                                        {{ $relatedProduct->cart_restriction_reason ?: 'Unavailable' }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection

@push('scripts')
<script>
    function changeMainImage(src, thumbnail) {
        document.getElementById('mainImage').src = src;
        
        // Update thumbnail borders
        document.querySelectorAll('.grid img').forEach(img => {
            img.classList.remove('ring-2', 'ring-primary-500');
        });
        thumbnail.classList.add('ring-2', 'ring-primary-500');
    }
    
    function increaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const max = parseInt(quantityInput.getAttribute('max'));
        const current = parseInt(quantityInput.value);
        
        if (current < max) {
            quantityInput.value = current + 1;
        }
    }
    
    function decreaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const current = parseInt(quantityInput.value);
        
        if (current > 1) {
            quantityInput.value = current - 1;
        }
    }
    
    function addToCart(productId) {
        const quantity = document.getElementById('quantity').value;
        const button = event.target;
        const originalText = button.textContent;
        
        // Disable button during request
        button.disabled = true;
        button.textContent = 'Adding...';

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: parseInt(quantity)
            })
        })
        .then(response => {
            // Check if response is ok
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            button.disabled = false;
            button.textContent = originalText;
            
            if (data.success) {
                // Animate cart addition with product name and total
                const productName = document.querySelector('h1').textContent.trim();
                
                // Use setTimeout to ensure animation doesn't interfere
                try {
                    window.animateCartAddition(data.cart_count, productName, data.cart_total);
                } catch (animError) {
                    console.error('Animation error:', animError);
                    // Fallback: Just show a simple success message
                    showNotification('Product added to cart successfully!', 'success');
                }
                
                // Don't show additional notification since animateCartAddition shows one
            } else {
                showNotification(data.message || 'Failed to add product to cart', 'error');
            }
        })
        .catch(error => {
            button.disabled = false;
            button.textContent = originalText;
            console.error('Cart Error Details:', error);
            showNotification('Something went wrong. Please try again.', 'error');
        });
    }
    
    // Remove duplicate updateCartCount function - using global one from app.blade.php

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-24 right-4 z-[99999] p-4 rounded-lg shadow-lg transition-all transform translate-x-full ${
                type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'
            }`;
            notification.style.zIndex = '99999';
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
                notification.classList.add('translate-x-0');
            }, 10);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('opacity-0', 'translate-x-full');
                setTimeout(() => {
                    if (notification.parentNode) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }
    
    function addToWishlist(productId) {
        // TODO: Implement wishlist functionality
        alert('Wishlist functionality will be implemented in the next phase!');
    }
</script>
@endpush
