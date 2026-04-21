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
                                <a href="{{ route('products.show', ['category' => $product->category ? ($product->category->slug ?: $product->category->id) : $product->category_id, 'product' => $product->slug ?: $product->id]) }}" 
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
                                        @if($product->status && in_array($product->status->status_name, ['Coming Soon', 'Pre Order']))
                                            <div class="bg-blue-500/90 text-white text-xs font-medium px-2 py-1 rounded-lg backdrop-blur-sm">
                                                {{ $product->status->status_name }}
                                            </div>
                                        @elseif($product->stock_quantity > 0)
                                            <div class="bg-green-500/90 text-white text-xs font-medium px-2 py-1 rounded-lg backdrop-blur-sm">
                                                In Stock
                                            </div>
                                        @else
                                            <div class="bg-red-500/90 text-white text-xs font-medium px-2 py-1 rounded-lg backdrop-blur-sm">
                                                Out of Stock
                                            </div>
                                        @endif
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
                                                        class="w-full bg-gradient-to-r from-primary-500/15 to-amber-500/15 backdrop-blur-sm border border-primary-400/40 hover:from-primary-500/25 hover:to-amber-500/25 hover:border-primary-400/60 text-primary-200 px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 shadow-lg hover:shadow-primary-500/20 hover:-translate-y-0.5 tracking-wide">
                                                Add to Cart
                                            </button>
                                        @else
                                                @if($product->status && in_array($product->status->status_name, ['Coming Soon', 'Pre Order']))
                                                    <button onclick="event.preventDefault(); event.stopPropagation(); showSpecialOrderContact('{{ $product->status->status_name }}', '{{ addslashes($product->name) }}')" 
                                                            class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition-all">
                                                        Contact Us
                                                    </button>
                                                @else
                                                    <button class="w-full bg-gray-600/50 text-gray-400 px-4 py-2.5 rounded-lg text-sm font-semibold cursor-not-allowed" 
                                                            disabled title="{{ $product->cart_restriction_reason }}">
                                                        {{ $product->cart_restriction_reason ?: 'Unavailable' }}
                                            </button>
                                        @endif
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
            quantity: 1,
            catalog: document.documentElement.dataset.catalogSource || 'msk'
        })
    })
    .then(response => response.json())
    .then(data => {
        button.disabled = false;
        button.textContent = originalText;
        
        if (data.success) {
            // Professional cart addition feedback
            window.animateCartAddition(data.cart_total, productName);
            
            // Subtle success effect
            button.classList.add('bg-gray-700', 'border-primary-500');
            button.textContent = 'Added to Cart';
            setTimeout(() => {
                button.classList.remove('bg-gray-700', 'border-primary-500');
                button.textContent = originalText;
            }, 1200);
            
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

    // Special Order Contact Modal Functions
    function showSpecialOrderContact(statusType, productName) {
        // Update modal content with product-specific information
        document.getElementById('specialOrderStatus').textContent = statusType;
        document.getElementById('specialOrderProductName').textContent = productName;
        
        // Update contact links with product information
        const whatsappMessage = `Hi MSK Computers! I'm interested in the ${statusType} product: "${productName}". Could you please provide more information about availability and ordering?`;
        const emailSubject = `Inquiry about ${statusType} Product: ${productName}`;
        const emailBody = `Dear MSK Computers Team,\n\nI am interested in the following ${statusType} product:\n\nProduct: ${productName}\n\nCould you please provide more information about:\n- Expected availability date\n- Pricing details\n- How to place an order\n- Any special requirements\n\nThank you for your assistance.\n\nBest regards`;
        
        // Update WhatsApp link
        document.getElementById('specialOrderWhatsApp').href = `https://wa.me/94777506939?text=${encodeURIComponent(whatsappMessage)}`;
        
        // Update Email link
        document.getElementById('specialOrderEmail').href = `mailto:info@mskcomputers.lk?subject=${encodeURIComponent(emailSubject)}&body=${encodeURIComponent(emailBody)}`;
        
        // Show modal
        const modal = document.getElementById('specialOrderContactModal');
        modal.classList.remove('hidden');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function hideSpecialOrderContact() {
        const modal = document.getElementById('specialOrderContactModal');
        modal.classList.add('hidden');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('specialOrderContactModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    hideSpecialOrderContact();
                }
            });
        }
    });
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

<!-- Special Order Contact Modal -->
<div id="specialOrderContactModal" class="hidden fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4" style="display: none !important;">
    <div class="bg-gradient-to-br from-gray-900 to-black border border-gray-700 rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl">
        <!-- Modal Header -->
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">Contact Us</h3>
            <p class="text-gray-400 text-sm">
                <span id="specialOrderStatus" class="text-blue-400 font-semibold"></span> Product Inquiry
            </p>
            <p class="text-gray-300 text-sm mt-1 font-medium" id="specialOrderProductName"></p>
        </div>

        <!-- Contact Information -->
        <div class="space-y-4 mb-6">
            <!-- Shop Info -->
            <div class="text-center border-b border-gray-700 pb-4">
                <h4 class="text-lg font-bold text-white">MSK COMPUTERS</h4>
                <p class="text-gray-400 text-sm">No.296/3D, Delpe Junction, Ragama</p>
                <p class="text-gray-400 text-sm">Sri Lanka</p>
            </div>

            <!-- Phone Numbers -->
            <div class="flex items-center justify-between p-3 bg-gray-800/50 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500/20 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-semibold">0112 95 9005</p>
                        <p class="text-white font-semibold">0777 50 69 39</p>
                        <p class="text-gray-400 text-xs">Call us anytime</p>
                    </div>
                </div>
                <a href="tel:0777506939" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Call Now
                </a>
            </div>

            <!-- WhatsApp -->
            <div class="flex items-center justify-between p-3 bg-gray-800/50 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500/20 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-semibold">0777 50 69 39</p>
                        <p class="text-gray-400 text-xs">Quick response available</p>
                    </div>
                </div>
                <a id="specialOrderWhatsApp" href="#" target="_blank" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    WhatsApp
                </a>
            </div>

            <!-- Email -->
            <div class="flex items-center justify-between p-3 bg-gray-800/50 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-semibold">info@mskcomputers.lk</p>
                        <p class="text-gray-400 text-xs">Expert support</p>
                    </div>
                </div>
                <a id="specialOrderEmail" href="#" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Email
                </a>
            </div>
        </div>

        <!-- Close Button -->
        <button onclick="hideSpecialOrderContact()" class="w-full bg-gray-700 hover:bg-gray-600 text-white py-3 rounded-lg font-medium transition-colors">
            Close
        </button>
    </div>
</div>

@endsection