@extends('layouts.app')

@section('title', 'Search Results for "' . $searchTerm . '" - MSK Computers')
@section('description', 'Search results for computer hardware and technology products at MSK Computers.')

@section('content')
<div class="min-h-screen bg-[#0f0f0f]">
    <!-- Compact Search Header -->
    <section class="relative bg-gradient-to-r from-[#0f0f0f] to-[#1a1a1c] border-b border-gray-800/30 py-8">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-500/5 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white">
                Search Results
            </h1>
                        <p class="text-sm text-gray-400 mt-1">
                Results for "<span class="text-primary-400">{{ $searchTerm }}</span>"
            </p>
                    </div>
                </div>
                <div class="hidden md:block">
                    <span class="inline-flex items-center px-4 py-2 bg-primary-500/10 border border-primary-500/20 rounded-lg text-primary-400 text-sm font-medium">
                        {{ $products->total() }} Products Found
                    </span>
                </div>
            </div>
    </div>
</section>

    <!-- Main Content with Sidebar -->
    <section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
                    
                <!-- Left Sidebar - Search Filters -->
                <div class="lg:w-64 flex-shrink-0">
                    <div class="bg-[#1a1a1c] rounded-xl border border-gray-800/30 p-6 sticky top-6">
                    <!-- New Search -->
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Refine Search
                        </h3>
                        
                    <div class="mb-6">
                        <form action="{{ route('products.search') }}" method="GET">
                            <div class="flex gap-2">
                                    <input type="text" 
                                           name="q" 
                                           value="{{ $searchTerm }}" 
                                       placeholder="Search products..." 
                                           class="flex-1 bg-[#0f0f0f] border border-gray-700 text-white px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm">
                                    <button type="submit" 
                                            class="bg-primary-500 hover:bg-primary-600 text-black px-3 py-2 rounded-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Categories Filter -->
                    <div class="mb-6">
                            <h4 class="text-md font-medium text-gray-300 mb-3">Categories</h4>
                        <div class="space-y-2">
                            <a href="{{ route('products.search', ['q' => $searchTerm]) }}" 
                                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all {{ !request('category') ? 'bg-primary-500 text-black' : 'text-gray-300 hover:bg-primary-500/10 hover:text-primary-400' }}">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                All Results
                                    @if(!request('category'))
                                        <span class="ml-auto text-xs bg-black/20 px-2 py-0.5 rounded-full">{{ $products->total() }}</span>
                                    @endif
                                </a>
                                
                                @foreach($categories as $category)
                                    <a href="{{ route('products.search', ['q' => $searchTerm, 'category' => $category->slug ?: $category->id]) }}" 
                                       class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request('category') == ($category->slug ?: $category->id) ? 'bg-primary-500 text-black' : 'text-gray-300 hover:bg-primary-500/10 hover:text-primary-400' }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        <span class="truncate">{{ $category->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sort Options -->
                    <div>
                            <h4 class="text-md font-medium text-gray-300 mb-3">Sort By</h4>
                        <form method="GET" action="{{ route('products.search') }}" id="sortForm">
                            <input type="hidden" name="q" value="{{ $searchTerm }}">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                                <select name="sort" 
                                        class="w-full bg-[#0f0f0f] border border-gray-700 text-white px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm" 
                                        onchange="document.getElementById('sortForm').submit()">
                                <option value="relevance" {{ request('sort') == 'relevance' ? 'selected' : '' }}>Relevance</option>
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A to Z</option>
                            </select>
                        </form>
                        </div>

                        <!-- Mobile Product Count -->
                        <div class="block md:hidden mt-4 pt-4 border-t border-gray-700">
                            <span class="inline-flex items-center px-3 py-1.5 bg-primary-500/10 border border-primary-500/20 rounded-lg text-primary-400 text-xs font-medium">
                                {{ $products->total() }} Products Found
                            </span>
                        </div>
                </div>
            </div>

                <!-- Right Content - Products Grid -->
                <div class="flex-1">
                    @if($products->count() > 0)
                <!-- Results Info -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div>
                                <p class="text-gray-300 text-sm">
                            Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                            @if(request('category'))
                                        in <span class="text-primary-400">{{ $categories->where('slug', request('category'))->first()->name ?? 'Category' }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                        <!-- Products Grid - 3 Column Layout -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-12">
                        @foreach($products as $product)
                                <a href="{{ route('products.show', ['category' => $product->category->slug ?: $product->category->id, 'product' => $product->slug]) }}" 
                                   class="group bg-[#1c1c1e] rounded-xl border border-gray-800/30 overflow-hidden hover:border-primary-500/30 transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-primary-500/10">
                                    
                                    <!-- Product Image -->
                                    <div class="relative overflow-hidden bg-[#1a1a1c] aspect-square">
                                        <img 
                                            src="{{ $product->main_image }}" 
                                            alt="{{ $product->name }}" 
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                            loading="lazy"
                                        >
                                        
                                        <!-- Category Badge -->
                                        <div class="absolute top-3 left-3">
                                            <div class="bg-primary-500/90 text-black text-xs font-medium px-2 py-1 rounded-lg backdrop-blur-sm">
                                                {{ $product->category ? $product->category->name : 'Uncategorized' }}
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
                                        <h3 class="text-sm font-semibold text-white mb-3 line-clamp-2 group-hover:text-primary-400 transition-colors">
                                            {!! preg_replace('/(' . preg_quote($searchTerm, '/') . ')/i', '<span class="bg-primary-500 text-black px-1 rounded">$1</span>', $product->name) !!}
                                    </h3>

                                        <!-- Pricing -->
                                        <div class="mb-4">
                                            @if($product->is_on_sale && $product->promo_price > 0)
                                                <div class="flex items-baseline gap-2">
                                                    <span class="text-lg font-bold text-primary-400">
                                                        LKR {{ number_format($product->promo_price, 2) }}
                                                    </span>
                                                    <span class="text-sm text-gray-500 line-through">
                                                        LKR {{ number_format($product->price, 2) }}
                                                    </span>
                                                </div>
                                                <div class="text-xs text-green-400 font-medium">
                                                    Save LKR {{ number_format($product->price - $product->promo_price, 2) }}
                                                </div>
                                            @else
                                                <div class="text-lg font-bold text-white">
                                                @if($product->price > 0)
                                                        LKR {{ number_format($product->price, 2) }}
                                                @else
                                                        <span class="text-primary-400">Contact for Price</span>
                                                @endif
                                                </div>
                                            @endif
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
                                                <button onclick="event.preventDefault(); event.stopPropagation(); addToCartFromSearch({{ $product->id }}, '{{ addslashes($product->name) }}')" 
                                                        class="w-full bg-primary-500 hover:bg-primary-600 text-black px-4 py-2.5 rounded-lg text-sm font-semibold transition-all">
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
                        <!-- No Results -->
                    <div class="text-center py-16">
                            <div class="w-24 h-24 bg-[#2c2c2e] rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                            </div>
                        <h3 class="text-xl font-semibold text-white mb-2">No Results Found</h3>
                            <p class="text-gray-400 mb-6">Sorry, we couldn't find any products matching "<span class="text-primary-400">{{ $searchTerm }}</span>" that are currently in stock.</p>
                        
                        <div class="space-y-4">
                            <div class="text-sm text-gray-500">
                                <p class="mb-2">Try:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Different keywords</li>
                                    <li>More general terms</li>
                                    <li>Check spelling</li>
                                    <li>Browse categories instead</li>
                                </ul>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-6">
                                    <a href="{{ route('products.index') }}" 
                                       class="inline-flex items-center px-6 py-3 bg-primary-500 hover:bg-primary-600 text-black font-semibold rounded-lg transition-all">
                                        Browse All Products
                                    </a>
                                    <a href="{{ route('home') }}" 
                                       class="inline-flex items-center px-6 py-3 bg-[#2c2c2e] hover:bg-[#3c3c3e] text-gray-300 font-semibold rounded-lg transition-all border border-gray-700">
                                        Back to Home
                                    </a>
                                </div>
                        </div>
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
// Add to Cart from Search Results
function addToCartFromSearch(productId, productName = 'Product') {
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
            // Animate cart addition
            window.animateCartAddition(data.cart_count, productName, data.cart_total);
            
            // Add success effect
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

<style>
.cart-success-flash {
    animation: flash 0.5s ease-in-out;
}

@keyframes flash {
    0%, 100% { 
        background-color: rgb(245 158 11); 
    }
    50% { 
        background-color: rgb(34 197 94); 
    }
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    }
</style>
@endsection