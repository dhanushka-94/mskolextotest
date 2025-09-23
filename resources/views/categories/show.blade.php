@extends('layouts.app')

@section('title', $category->name . ' - MSK COMPUTERS')
@section('description', 'Shop ' . $category->name . ' at MSK Computers. Find the best deals on computer hardware and technology products in Sri Lanka.')
@section('keywords', $category->name . ', computer hardware, MSK Computers, Sri Lanka, technology, ' . strtolower($category->name))
@section('og_title', $category->name . ' - MSK COMPUTERS')
@section('og_description', 'Discover premium ' . $category->name . ' products at MSK Computers. Quality computer hardware and technology solutions.')
@section('og_type', 'product.group')

@section('content')
<!-- Compact Category Header -->
<section class="relative bg-[#0f0f0f] border-b border-gray-800/30 py-4 md:py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-3 md:mb-4">
            <ol class="flex items-center space-x-1 md:space-x-2 text-xs text-gray-500 overflow-x-auto">
                <li><a href="{{ route('home') }}" class="hover:text-[#f59e0b] transition-colors whitespace-nowrap">Home</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="{{ route('categories.index') }}" class="hover:text-[#f59e0b] transition-colors whitespace-nowrap">Categories</a></li>
                <li><span class="mx-1">/</span></li>
                <li class="text-[#f59e0b] font-medium truncate">{{ $category->name }}</li>
            </ol>
        </nav>
        
        <div class="flex items-center justify-between">
            <!-- Category Info -->
            <div class="flex items-center gap-3 md:gap-4 min-w-0 flex-1">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-[#f59e0b] to-[#d97706] rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 md:w-6 md:h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <h1 class="text-lg md:text-2xl font-bold text-white truncate">{{ $category->name }}</h1>
                    <p class="text-xs md:text-sm text-gray-400">{{ $products->total() }} products available</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-8 md:py-16 bg-black min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Mobile Filter Toggle -->
        <div class="lg:hidden mb-4">
            <button id="mobile-filter-toggle" class="w-full bg-[#1c1c1e] border border-gray-800/30 rounded-lg px-4 py-3 flex items-center justify-between text-white hover:bg-[#2c2c2e] transition-colors">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                    </svg>
                    <span class="font-medium">Filters & Sort</span>
                </div>
                <svg class="w-5 h-5 transition-transform duration-200" id="mobile-filter-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            <!-- Filter Sidebar -->
            <div class="w-full lg:w-80 lg:flex-shrink-0 hidden lg:block" id="filter-sidebar">
                <div class="bg-[#1c1c1e] rounded-xl border border-gray-800/30 p-6 shadow-lg sticky top-24">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-2 h-2 bg-[#f59e0b] rounded-full"></div>
                        <h3 class="text-lg font-semibold text-white">Filters</h3>
                        <button type="button" id="clear-filters" class="ml-auto text-xs text-gray-400 hover:text-[#f59e0b] transition-colors">Clear All</button>
                    </div>
                    
                    <form id="filter-form" class="space-y-6">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Search Products</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                   placeholder="Search by name, code..." 
                                   class="w-full bg-[#2c2c2e] border border-gray-700 text-white rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#f59e0b] focus:border-[#f59e0b] transition-all">
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-3">Price Range</label>
                            <div class="space-y-4">
                                <!-- Price Display -->
                                <div class="flex items-center justify-between text-sm text-gray-400">
                                    <span>Rs. <span id="min-price-display">{{ $priceRange['min'] ?? 0 }}</span></span>
                                    <span>Rs. <span id="max-price-display">{{ $priceRange['max'] ?? 100000 }}</span></span>
                                </div>
                                
                                <!-- Range Slider Container -->
                                <div class="relative">
                                    <div class="price-range-slider">
                                        <input type="range" name="min_price" id="min-price" 
                                               min="{{ $priceRange['min'] ?? 0 }}" 
                                               max="{{ $priceRange['max'] ?? 100000 }}" 
                                               value="{{ request('min_price', $priceRange['min'] ?? 0) }}" 
                                               class="range-input range-min">
                                        <input type="range" name="max_price" id="max-price" 
                                               min="{{ $priceRange['min'] ?? 0 }}" 
                                               max="{{ $priceRange['max'] ?? 100000 }}" 
                                               value="{{ request('max_price', $priceRange['max'] ?? 100000) }}" 
                                               class="range-input range-max">
                                    </div>
                                </div>
                                
                                <!-- Input Fields -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Min</label>
                                        <input type="number" id="min-price-input" 
                                               min="{{ $priceRange['min'] ?? 0 }}" 
                                               max="{{ $priceRange['max'] ?? 100000 }}" 
                                               value="{{ request('min_price', $priceRange['min'] ?? 0) }}"
                                               class="w-full bg-[#2c2c2e] border border-gray-700 text-white rounded px-2 py-1 text-xs focus:ring-1 focus:ring-[#f59e0b] focus:border-[#f59e0b]">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Max</label>
                                        <input type="number" id="max-price-input" 
                                               min="{{ $priceRange['min'] ?? 0 }}" 
                                               max="{{ $priceRange['max'] ?? 100000 }}" 
                                               value="{{ request('max_price', $priceRange['max'] ?? 100000) }}"
                                               class="w-full bg-[#2c2c2e] border border-gray-700 text-white rounded px-2 py-1 text-xs focus:ring-1 focus:ring-[#f59e0b] focus:border-[#f59e0b]">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Attributes -->
                        @if(isset($availableAttributes) && !empty($availableAttributes))
                        @foreach($availableAttributes as $parentName => $attributes)
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-3">{{ $parentName }}</label>
                            <div class="space-y-2">
                                @foreach($attributes as $attribute)
                                <label class="flex items-center cursor-pointer hover:bg-[#2c2c2e] rounded p-2 transition-colors">
                                    <input type="checkbox" name="attributes[{{ $parentName }}][]" value="{{ $attribute['id'] }}" 
                                           {{ in_array($attribute['id'], request('attributes.'.$parentName, [])) ? 'checked' : '' }}
                                           class="w-4 h-4 text-[#f59e0b] bg-[#2c2c2e] border-gray-600 rounded focus:ring-[#f59e0b] focus:ring-2">
                                    <span class="ml-3 text-sm text-gray-300 flex-1">{{ $attribute['name'] }}</span>
                                    <span class="text-xs text-gray-500 bg-[#2c2c2e] px-2 py-0.5 rounded">{{ $attribute['count'] }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1">
                <!-- Compact Top Bar with Results & Sort -->
                <div class="bg-[#1c1c1e] rounded-lg border border-gray-800/30 p-3 mb-4 md:mb-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <!-- Results Info -->
                        <div class="flex items-center">
                            <span id="results-info" class="text-gray-300 text-xs sm:text-sm">
                                @if($products->total() > 0)
                                    {{ $products->total() }} products found
                                @else
                                    No products found
                                @endif
                            </span>
                        </div>
                        
                        <!-- Sort Options -->
                        <div class="flex items-center gap-2">
                            <label for="sort-select" class="text-xs text-gray-400 whitespace-nowrap">Sort:</label>
                            <select name="sort" id="sort-select" class="bg-[#2c2c2e] border border-gray-700 text-white rounded px-2 md:px-3 py-1.5 text-xs md:text-sm focus:ring-1 focus:ring-[#f59e0b] focus:border-[#f59e0b] transition-all">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price ↑</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price ↓</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div id="products-container">
                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8 md:mb-12" id="products-grid">
                @foreach($products as $product)
                    <a href="{{ route('products.show', ['category' => $category->slug ?: $category->id, 'product' => $product->slug]) }}" class="product-card block bg-[#1c1c1e] rounded-xl border border-gray-800/30 overflow-hidden hover:border-[#f59e0b]/30 transition-all duration-300 group shadow-lg hover:shadow-xl hover:shadow-[#f59e0b]/10 cursor-pointer">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden bg-[#1a1a1c] aspect-square">
                            <img 
                                src="{{ $product->main_image }}" 
                                alt="{{ $product->name }}" 
                                class="product-image w-full h-full object-contain transition-transform duration-300 group-hover:scale-105 p-4 bg-white/5 rounded-lg"
                                loading="lazy"
                            >
                            
                            <!-- Stock Badge -->
                            @if($product->stock_quantity > 0)
                                <div class="absolute top-3 left-3 bg-[#34d399] text-white text-xs font-medium px-2.5 py-1 rounded-lg backdrop-blur-sm">
                                    IN STOCK
                                </div>
                            @else
                                <div class="absolute top-3 left-3 bg-[#ef4444] text-white text-xs font-medium px-2.5 py-1 rounded-lg backdrop-blur-sm">
                                    OUT OF STOCK
                                </div>
                            @endif

                            @if($product->is_on_sale)
                                <div class="absolute top-3 right-3 bg-[#f59e0b] text-white text-xs font-bold px-2.5 py-1 rounded-lg backdrop-blur-sm">
                                    SALE
                                </div>
                            @endif
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-3 md:p-4">
                            <div class="mb-2">
                                <span class="text-xs text-[#f59e0b] font-medium tracking-wide">{{ $product->category->name ?? 'Uncategorized' }}</span>
                            </div>
                            <h3 class="text-sm md:text-base font-semibold text-white mb-2 md:mb-3 line-clamp-2 group-hover:text-[#f59e0b] transition-colors leading-tight">
                                {{ $product->name }}
                            </h3>
                            
                            <div class="flex items-center justify-between mb-3 md:mb-4">
                                <div class="flex flex-col">
                                    @if($product->is_on_sale)
                                        <span class="text-xs md:text-sm text-gray-500 line-through">LKR {{ number_format($product->price, 2) }}</span>
                                        <span class="text-sm md:text-lg font-bold text-[#f59e0b]">LKR {{ number_format($product->final_price, 2) }}</span>
                                    @else
                                        @if($product->price > 0 && $product->final_price > 0)
                                            <span class="text-sm md:text-lg font-bold text-white">LKR {{ number_format($product->final_price, 2) }}</span>
                                        @else
                                            <span class="text-sm md:text-lg font-bold text-[#f59e0b]">Contact for Price</span>
                                        @endif
                                    @endif
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
                            
                            <div class="mt-auto">
                                @if($product->can_add_to_cart)
                                    <button onclick="event.preventDefault(); event.stopPropagation(); addToCartFromCategory({{ $product->id }})" 
                                            class="w-full bg-[#f59e0b] hover:bg-[#d97706] text-white px-3 md:px-4 py-2 md:py-2.5 rounded-lg text-xs md:text-sm font-semibold transition-all">
                                        Add to Cart
                                    </button>
                                @else
                                    <button disabled 
                                            class="w-full bg-[#2c2c2e] text-gray-500 px-3 md:px-4 py-2 md:py-2.5 rounded-lg text-xs md:text-sm font-medium cursor-not-allowed border border-gray-700"
                                            title="{{ $product->cart_restriction_reason }}">
                                        {{ $product->cart_restriction_reason ?: 'Unavailable' }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

                        </div>

                        <!-- Custom Pagination -->
                        <div id="pagination-container">
                            {{ $products->appends(request()->query())->links('custom.pagination') }}
                        </div>
                    @else
                        <!-- No Products Found -->
                        <div class="text-center py-16">
                            <div class="max-w-md mx-auto">
                                <div class="bg-[#2c2c2e] rounded-xl w-24 h-24 flex items-center justify-center mx-auto mb-6 border border-gray-700">
                                    <svg class="w-12 h-12 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 2C5.58 2 2 5.58 2 10s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-white mb-2">No products found</h3>
                                <p class="text-gray-400 mb-6">Try adjusting your filters to see more results.</p>
                                <button onclick="clearAllFilters()" class="bg-[#f59e0b] hover:bg-[#d97706] text-white px-6 py-3 rounded-lg font-semibold transition-all inline-block">
                                    Clear Filters
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Perfect 1:1 aspect ratio for product images */
    .aspect-square {
        aspect-ratio: 1 / 1;
    }
    
    /* Fallback for older browsers */
    @supports not (aspect-ratio: 1 / 1) {
        .aspect-square {
            position: relative;
        }
        
        .aspect-square::before {
            content: '';
            display: block;
            padding-bottom: 100%;
        }
        
        .aspect-square img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    }
    
    /* Enhanced product card hover effects */
    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    /* Custom scrollbar for filters */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #2c2c2e;
        border-radius: 3px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #f59e0b;
        border-radius: 3px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #d97706;
    }

    /* Loading spinner */
    .loading-spinner {
        border: 2px solid #2c2c2e;
        border-top: 2px solid #f59e0b;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Price Range Slider Styles */
    .price-range-slider {
        position: relative;
        height: 24px;
        background: #2c2c2e;
        border-radius: 12px;
        margin: 8px 0;
    }

    .range-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: none;
        pointer-events: none;
        -webkit-appearance: none;
        appearance: none;
        outline: none;
        border: none;
    }

    .range-input::-webkit-slider-thumb {
        height: 20px;
        width: 20px;
        border-radius: 50%;
        background: #f59e0b;
        border: 2px solid #1c1c1e;
        cursor: pointer;
        pointer-events: all;
        -webkit-appearance: none;
        appearance: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        transition: all 0.2s ease;
    }

    .range-input::-webkit-slider-thumb:hover {
        background: #d97706;
        transform: scale(1.1);
    }

    .range-input::-moz-range-thumb {
        height: 20px;
        width: 20px;
        border-radius: 50%;
        background: #f59e0b;
        border: 2px solid #1c1c1e;
        cursor: pointer;
        pointer-events: all;
        box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        transition: all 0.2s ease;
        border: none;
    }

    .range-input::-moz-range-thumb:hover {
        background: #d97706;
        transform: scale(1.1);
    }

    .range-input::-webkit-slider-runnable-track {
        width: 100%;
        height: 4px;
        background: #4a5568;
        border-radius: 2px;
    }

    .range-input::-moz-range-track {
        width: 100%;
        height: 4px;
        background: #4a5568;
        border-radius: 2px;
        border: none;
    }

    .range-min {
        z-index: 1;
    }

    .range-max {
        z-index: 2;
    }
</style>
@endpush

@push('scripts')
<script>
    console.log('🔧 AJAX Filter System Loading...');
    
    // Global state
    let FilterSystem = {
        isLoading: false,
        searchTimeout: null,
        isInitialized: false
    };

    // Initialize filters when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        if (FilterSystem.isInitialized) {
            console.log('⚠️ Filter system already initialized');
            return;
        }
        
        console.log('Initializing AJAX Filter System...');
        
        // Get DOM elements
        const elements = {
            filterForm: document.getElementById('filter-form'),
            sortSelect: document.getElementById('sort-select'),
            productsContainer: document.getElementById('products-container'),
            resultsInfo: document.getElementById('results-info'),
            clearFiltersBtn: document.getElementById('clear-filters'),
            searchInput: document.getElementById('search'),
            paginationContainer: document.getElementById('pagination-container'),
            minPriceSlider: document.getElementById('min-price'),
            maxPriceSlider: document.getElementById('max-price'),
            minPriceInput: document.getElementById('min-price-input'),
            maxPriceInput: document.getElementById('max-price-input'),
            minPriceDisplay: document.getElementById('min-price-display'),
            maxPriceDisplay: document.getElementById('max-price-display')
        };

        // Validate elements exist
        console.log('📍 Elements found:', {
            filterForm: !!elements.filterForm,
            sortSelect: !!elements.sortSelect,
            productsContainer: !!elements.productsContainer,
            resultsInfo: !!elements.resultsInfo,
            clearFiltersBtn: !!elements.clearFiltersBtn,
            searchInput: !!elements.searchInput
        });

        // Main filter function
        function filterProducts() {
            console.log('🔍 Filter triggered');
            
            if (FilterSystem.isLoading) {
                console.log('⏳ Already loading, skipping...');
                return;
            }

            if (!elements.filterForm || !elements.productsContainer) {
                console.log('❌ Required elements missing!');
                return;
            }

            FilterSystem.isLoading = true;
            
            // Show loading state
            showLoadingState();

            // Collect form data
            const formData = new FormData(elements.filterForm);
            if (elements.sortSelect && elements.sortSelect.value) {
                formData.append('sort', elements.sortSelect.value);
            }

            // Convert to URL params
            const params = new URLSearchParams();
            for (let [key, value] of formData.entries()) {
                params.append(key, value);
                console.log('📝 Filter param:', key, '=', value);
            }

            // Make AJAX request
            const url = window.location.pathname + '?' + params.toString();
            console.log('🌐 AJAX URL:', url);

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                console.log('📡 Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('✅ AJAX Success:', data);
                if (data.success) {
                    updateProductsGrid(data.products || []);
                    updateResultsInfo(data.pagination || {});
                    hidePagination(); // Hide pagination for now with AJAX
                } else {
                    throw new Error('Server returned error response');
                }
                FilterSystem.isLoading = false;
            })
            .catch(error => {
                console.error('❌ AJAX Error:', error);
                showErrorState(error.message);
                FilterSystem.isLoading = false;
            });
        }

        // Show loading state
        function showLoadingState() {
            elements.productsContainer.innerHTML = `
                <div class="flex justify-center items-center py-16">
                    <div class="text-center">
                        <div class="loading-spinner mx-auto mb-4"></div>
                        <p class="text-gray-400">Loading products...</p>
                    </div>
                </div>
            `;
        }

        // Show error state
        function showErrorState(message) {
            elements.productsContainer.innerHTML = `
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="bg-[#2c2c2e] rounded-xl w-24 h-24 flex items-center justify-center mx-auto mb-6 border border-gray-700">
                            <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Error Loading Products</h3>
                        <p class="text-red-400 mb-6">${message}</p>
                        <button onclick="location.reload()" class="bg-[#f59e0b] hover:bg-[#d97706] text-white px-6 py-3 rounded-lg font-semibold transition-all">
                            Reload Page
                        </button>
                    </div>
                </div>
            `;
        }

        // Update products grid
        function updateProductsGrid(products) {
            console.log('🔄 Updating grid with', products.length, 'products');
            
            if (!products || products.length === 0) {
                elements.productsContainer.innerHTML = `
                    <div class="text-center py-16">
                        <div class="max-w-md mx-auto">
                            <div class="bg-[#2c2c2e] rounded-xl w-24 h-24 flex items-center justify-center mx-auto mb-6 border border-gray-700">
                                <svg class="w-12 h-12 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 2C5.58 2 2 5.58 2 10s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-2">No products found</h3>
                            <p class="text-gray-400 mb-6">Try adjusting your filters to see more results.</p>
                            <button onclick="clearAllFilters()" class="bg-[#f59e0b] hover:bg-[#d97706] text-white px-6 py-3 rounded-lg font-semibold transition-all">
                                Clear Filters
                            </button>
                        </div>
                    </div>
                `;
                return;
            }

            let gridHTML = '<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8 md:mb-12">';
            
            products.forEach(product => {
                let stockBadge = '';
                if (product.stock_quantity > 0) {
                    stockBadge = '<div class="absolute top-3 left-3 bg-[#34d399] text-white text-xs font-medium px-2.5 py-1 rounded-lg backdrop-blur-sm">IN STOCK</div>';
                } else {
                    stockBadge = '<div class="absolute top-3 left-3 bg-[#ef4444] text-white text-xs font-medium px-2.5 py-1 rounded-lg backdrop-blur-sm">OUT OF STOCK</div>';
                }

                let saleBadge = product.is_on_sale ? '<div class="absolute top-3 right-3 bg-[#f59e0b] text-white text-xs font-bold px-2.5 py-1 rounded-lg backdrop-blur-sm">SALE</div>' : '';
                
                let priceHTML = '';
                if (product.is_on_sale) {
                    priceHTML = `<span class="text-sm text-gray-500 line-through">LKR ${new Intl.NumberFormat().format(product.price)}</span>
                                 <span class="text-lg font-bold text-[#f59e0b]">LKR ${new Intl.NumberFormat().format(product.final_price)}</span>`;
                } else {
                    if (product.final_price > 0) {
                        priceHTML = `<span class="text-lg font-bold text-white">LKR ${new Intl.NumberFormat().format(product.final_price)}</span>`;
                    } else {
                        priceHTML = `<span class="text-lg font-bold text-[#f59e0b]">Contact for Price</span>`;
                    }
                }

                // Generate proper product URL using category and product slugs
                const categorySlug = product.category?.slug || product.category?.id || 'uncategorized';
                const productSlug = product.slug || product.id;
                const productUrl = `/${categorySlug}/${productSlug}`;
                
                gridHTML += `
                    <a href="${productUrl}" class="product-card block bg-[#1c1c1e] rounded-xl border border-gray-800/30 overflow-hidden hover:border-[#f59e0b]/30 transition-all duration-300 group shadow-lg hover:shadow-xl hover:shadow-[#f59e0b]/10 cursor-pointer">
                        <div class="relative overflow-hidden bg-[#1a1a1c] aspect-square">
                            <img src="${product.main_image}" alt="${product.name}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
                            ${stockBadge}
                            ${saleBadge}
                        </div>
                        <div class="p-4">
                            <div class="mb-2">
                                <span class="text-xs text-[#f59e0b] font-medium tracking-wide">${product.category?.name || 'Uncategorized'}</span>
                            </div>
                            <h3 class="text-base font-semibold text-white mb-3 line-clamp-2 group-hover:text-[#f59e0b] transition-colors leading-tight">
                                ${product.name}
                            </h3>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex flex-col">${priceHTML}</div>
                            </div>
                            <div class="mt-auto">
                                ${product.stock_quantity > 0 
                                    ? `<button onclick="event.preventDefault(); event.stopPropagation(); addToCart(${product.id})" class="w-full bg-[#f59e0b] hover:bg-[#d97706] text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition-all">Add to Cart</button>`
                                    : `<button disabled class="w-full bg-[#2c2c2e] text-gray-500 px-4 py-2.5 rounded-lg text-sm font-medium cursor-not-allowed border border-gray-700">Out of Stock</button>`
                                }
                            </div>
                        </div>
                    </a>
                `;
            });

            gridHTML += '</div>';
            elements.productsContainer.innerHTML = gridHTML;
        }

        // Update results info
        function updateResultsInfo(pagination) {
            if (elements.resultsInfo) {
                const text = pagination.total > 0 
                    ? `${pagination.total} products found`
                    : 'No products found';
                elements.resultsInfo.textContent = text;
            }
        }

        // Hide pagination for AJAX
        function hidePagination() {
            if (elements.paginationContainer) {
                elements.paginationContainer.style.display = 'none';
            }
        }

        // Debounced search
        function debounceSearch() {
            clearTimeout(FilterSystem.searchTimeout);
            FilterSystem.searchTimeout = setTimeout(filterProducts, 500);
        }

        // Clear all filters
        window.clearAllFilters = function() {
            console.log('🧹 Clearing all filters');
            if (elements.filterForm) elements.filterForm.reset();
            if (elements.sortSelect) elements.sortSelect.value = 'latest';
            
            // Reset price sliders to their default values
            if (elements.minPriceSlider && elements.maxPriceSlider) {
                elements.minPriceSlider.value = elements.minPriceSlider.min;
                elements.maxPriceSlider.value = elements.maxPriceSlider.max;
                updatePriceDisplay();
            }
            
            filterProducts();
        }

        // Price Range Slider Functions
        function updatePriceDisplay() {
            if (elements.minPriceDisplay && elements.maxPriceDisplay && 
                elements.minPriceSlider && elements.maxPriceSlider) {
                elements.minPriceDisplay.textContent = parseInt(elements.minPriceSlider.value).toLocaleString();
                elements.maxPriceDisplay.textContent = parseInt(elements.maxPriceSlider.value).toLocaleString();
            }
        }

        function syncSliderToInput(isMin) {
            if (isMin && elements.minPriceInput && elements.minPriceSlider) {
                let value = parseInt(elements.minPriceInput.value);
                let max = parseInt(elements.maxPriceSlider.value);
                if (value >= max) {
                    value = max - 1;
                    elements.minPriceInput.value = value;
                }
                elements.minPriceSlider.value = value;
            } else if (!isMin && elements.maxPriceInput && elements.maxPriceSlider) {
                let value = parseInt(elements.maxPriceInput.value);
                let min = parseInt(elements.minPriceSlider.value);
                if (value <= min) {
                    value = min + 1;
                    elements.maxPriceInput.value = value;
                }
                elements.maxPriceSlider.value = value;
            }
            updatePriceDisplay();
        }

        function handleSliderChange() {
            if (elements.minPriceSlider && elements.maxPriceSlider) {
                let minVal = parseInt(elements.minPriceSlider.value);
                let maxVal = parseInt(elements.maxPriceSlider.value);
                
                if (minVal >= maxVal) {
                    elements.minPriceSlider.value = maxVal - 1;
                    minVal = maxVal - 1;
                }
                
                if (elements.minPriceInput) elements.minPriceInput.value = minVal;
                if (elements.maxPriceInput) elements.maxPriceInput.value = maxVal;
                
                updatePriceDisplay();
                filterProducts();
            }
        }

        // Event listeners
        if (elements.filterForm) {
            elements.filterForm.addEventListener('change', function(e) {
                console.log('📝 Form change:', e.target.name || e.target.id);
                filterProducts();
            });
        }

        if (elements.sortSelect) {
            elements.sortSelect.addEventListener('change', function() {
                console.log('🔀 Sort change:', this.value);
                filterProducts();
            });
        }

        if (elements.clearFiltersBtn) {
            elements.clearFiltersBtn.addEventListener('click', clearAllFilters);
        }

        if (elements.searchInput) {
            elements.searchInput.addEventListener('input', debounceSearch);
        }

        // Price Range Slider Event Listeners
        if (elements.minPriceSlider) {
            elements.minPriceSlider.addEventListener('input', handleSliderChange);
        }

        if (elements.maxPriceSlider) {
            elements.maxPriceSlider.addEventListener('input', handleSliderChange);
        }

        if (elements.minPriceInput) {
            elements.minPriceInput.addEventListener('input', function() {
                syncSliderToInput(true);
                clearTimeout(FilterSystem.searchTimeout);
                FilterSystem.searchTimeout = setTimeout(filterProducts, 500);
            });
        }

        if (elements.maxPriceInput) {
            elements.maxPriceInput.addEventListener('input', function() {
                syncSliderToInput(false);
                clearTimeout(FilterSystem.searchTimeout);
                FilterSystem.searchTimeout = setTimeout(filterProducts, 500);
            });
        }

        // Initialize price display
        updatePriceDisplay();

        FilterSystem.isInitialized = true;
        console.log('✅ AJAX Filter System initialized successfully!');
        
        // Mobile filter toggle functionality
        const mobileFilterToggle = document.getElementById('mobile-filter-toggle');
        const mobileFilterArrow = document.getElementById('mobile-filter-arrow');
        const filterSidebar = document.getElementById('filter-sidebar');
        
        if (mobileFilterToggle && filterSidebar) {
            mobileFilterToggle.addEventListener('click', function() {
                const isHidden = filterSidebar.classList.contains('hidden');
                
                if (isHidden) {
                    filterSidebar.classList.remove('hidden');
                    filterSidebar.classList.add('block', 'mb-6');
                    mobileFilterArrow.style.transform = 'rotate(180deg)';
                } else {
                    filterSidebar.classList.add('hidden');
                    filterSidebar.classList.remove('block', 'mb-6');
                    mobileFilterArrow.style.transform = 'rotate(0deg)';
                }
            });
        }
    });

    // Global function for add to cart from category page
    window.addToCartFromCategory = function(productId) {
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
                quantity: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            button.disabled = false;
            button.innerHTML = originalText;
            
            if (data.success) {
                // Add success animation to button
                button.classList.add('bg-green-500', 'animate-pulse');
                button.innerHTML = '✅ Added!';
                
                setTimeout(() => {
                    button.classList.remove('bg-green-500', 'animate-pulse');
                    button.innerHTML = originalText;
                }, 2000);
                
                // Get product name for animation
                const productCard = button.closest('.product-card');
                const productName = productCard.querySelector('h3')?.textContent.trim() || 'Product';
                
                // Animate cart addition with enhanced effects
                window.animateCartAddition(data.cart_count, productName, data.cart_total);
                
            } else {
                // Add error animation to button
                button.classList.add('bg-red-500', 'animate-pulse');
                button.innerHTML = '❌ Error';
                
                setTimeout(() => {
                    button.classList.remove('bg-red-500', 'animate-pulse');
                    button.innerHTML = originalText;
                }, 2000);
                
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            button.disabled = false;
            button.textContent = originalText;
            console.error('Cart Error Details:', error);
            showNotification('Something went wrong. Please try again. Check console for details.', 'error');
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
</script>
@endpush
