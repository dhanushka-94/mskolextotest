@extends('layouts.app')

@section('title', $category->name . ' - MSK COMPUTERS')
@section('description', 'Shop ' . $category->name . ' at MSK Computers. Find the best deals on computer hardware and technology products in Sri Lanka.')
@section('keywords', $category->name . ', computer hardware, MSK Computers, Sri Lanka, technology, ' . strtolower($category->name))
@section('og_title', $category->name . ' - MSK COMPUTERS')
@section('og_description', 'Discover premium ' . $category->name . ' products at MSK Computers. Quality computer hardware and technology solutions.')
@section('og_type', 'product.group')

@section('content')
@php
    $isBaseusCategory = strtoupper(trim($category->name)) === 'BASEUS' || (optional($category->parent)->name && strtoupper(trim(optional($category->parent)->name)) === 'BASEUS');
    $isUgreenCategory = strtoupper(trim($category->name)) === 'UGREEN' || (optional($category->parent)->name && strtoupper(trim(optional($category->parent)->name)) === 'UGREEN');
@endphp
<!-- Compact Category Header -->
<section class="relative bg-[#0f0f0f] border-b border-gray-800/30 py-4 md:py-6 {{ $isBaseusCategory ? 'baseus-category-theme' : ($isUgreenCategory ? 'ugreen-category-theme' : '') }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-3 md:mb-4">
            <ol class="flex items-center space-x-1 md:space-x-2 text-xs text-gray-500 overflow-x-auto">
                <li><a href="{{ route('home') }}" class="{{ $isBaseusCategory ? 'hover:text-[#facc15]' : ($isUgreenCategory ? 'hover:text-[#5ee9a8]' : 'hover:text-[#f59e0b]') }} transition-colors whitespace-nowrap">Home</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="{{ route('categories.index') }}" class="{{ $isBaseusCategory ? 'hover:text-[#facc15]' : ($isUgreenCategory ? 'hover:text-[#5ee9a8]' : 'hover:text-[#f59e0b]') }} transition-colors whitespace-nowrap">Categories</a></li>
                <li><span class="mx-1">/</span></li>
                <li class="{{ $isBaseusCategory ? 'text-[#facc15]' : ($isUgreenCategory ? 'text-[#5ee9a8]' : 'text-[#f59e0b]') }} font-medium truncate">{{ $category->name }}</li>
            </ol>
        </nav>

        @if($isBaseusCategory)
            <div class="mb-3 md:mb-4 bg-gradient-to-r from-[#facc15]/20 via-[#fde047]/10 to-[#facc15]/20 border border-[#facc15]/40 rounded-lg p-3">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/baseus_logo.png') }}" alt="Baseus" class="h-8 md:h-10 w-auto object-contain">
                    <div>
                        <h3 class="text-[#facc15] font-semibold text-sm md:text-base">Official Baseus Collection</h3>
                        <p class="text-yellow-100/80 text-xs md:text-sm">Premium Baseus accessories with trusted MSK support and warranty.</p>
                    </div>
                </div>
            </div>

            <div class="mb-3 md:mb-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <div class="rounded-lg border border-[#facc15]/35 bg-[#facc15]/10 px-3 py-2 text-xs text-yellow-100/90">
                    <span class="font-semibold text-[#fde047]">Premium Design</span> - Modern accessories for daily use
                </div>
                <div class="rounded-lg border border-[#facc15]/35 bg-[#facc15]/10 px-3 py-2 text-xs text-yellow-100/90">
                    <span class="font-semibold text-[#fde047]">Fast Charging</span> - Reliable and safe power delivery
                </div>
                <div class="rounded-lg border border-[#facc15]/35 bg-[#facc15]/10 px-3 py-2 text-xs text-yellow-100/90">
                    <span class="font-semibold text-[#fde047]">MSK Warranty</span> - Local support and trusted service
                </div>
            </div>
        @elseif($isUgreenCategory)
            <div class="mb-3 md:mb-4 bg-gradient-to-r from-[#00c65e]/18 via-emerald-500/10 to-[#00c65e]/18 border border-[#00c65e]/40 rounded-lg p-3">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 rounded-lg bg-black/35 border border-[#00c65e]/35 p-2 flex items-center justify-center shadow-lg shadow-emerald-900/25">
                        <img src="{{ asset('images/ugreen_logo.svg') }}" alt="Ugreen — official accessories at MSK Computers Sri Lanka" width="140" height="40" class="h-8 md:h-10 w-auto object-contain" loading="lazy" decoding="async">
                    </div>
                    <div>
                        <h3 class="text-[#5ee9a8] font-semibold text-sm md:text-base">Official UGREEN Collection</h3>
                        <p class="text-emerald-100/80 text-xs md:text-sm">Quality cables &amp; accessories — MSK Computers authorized range.</p>
                    </div>
                </div>
            </div>

            <div class="mb-3 md:mb-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <div class="rounded-lg border border-[#00c65e]/35 bg-[#00c65e]/10 px-3 py-2 text-xs text-emerald-100/90">
                    <span class="font-semibold text-[#5ee9a8]">Certified quality</span> - Built for durability &amp; safety
                </div>
                <div class="rounded-lg border border-[#00c65e]/35 bg-[#00c65e]/10 px-3 py-2 text-xs text-emerald-100/90">
                    <span class="font-semibold text-[#5ee9a8]">Fast data &amp; charging</span> - USB-C &amp; connectivity
                </div>
                <div class="rounded-lg border border-[#00c65e]/35 bg-[#00c65e]/10 px-3 py-2 text-xs text-emerald-100/90">
                    <span class="font-semibold text-[#5ee9a8]">MSK support</span> - Local warranty &amp; service
                </div>
            </div>
        @endif
        
        <div class="flex items-center justify-between">
            <!-- Category Info -->
            <div class="flex items-center gap-3 md:gap-4 min-w-0 flex-1">
                <div class="w-8 h-8 md:w-10 md:h-10 {{ $isBaseusCategory ? 'bg-gradient-to-br from-[#facc15] to-[#eab308]' : ($isUgreenCategory ? 'bg-gradient-to-br from-[#00c65e] to-emerald-700' : 'bg-gradient-to-br from-[#f59e0b] to-[#d97706]') }} rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                    @if($isBaseusCategory)
                        <img src="{{ asset('images/baseus_logo.png') }}" alt="Baseus" class="h-6 md:h-7 w-auto object-contain">
                    @elseif($isUgreenCategory)
                        <img src="{{ asset('images/ugreen_logo.svg') }}" alt="Ugreen" class="h-6 md:h-7 w-auto max-w-[2.75rem] object-contain" width="44" height="28" loading="lazy" decoding="async">
                    @else
                        <svg class="w-4 h-4 md:w-6 md:h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <h1 class="text-lg md:text-2xl font-bold {{ $isBaseusCategory ? 'text-[#fde047]' : ($isUgreenCategory ? 'text-[#5ee9a8]' : 'text-white') }} truncate">{{ $category->name }}</h1>
                    <p class="text-xs md:text-sm text-gray-400">{{ $products->total() }} products available</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-8 md:py-16 bg-black min-h-screen {{ $isBaseusCategory ? 'baseus-products-theme' : ($isUgreenCategory ? 'ugreen-products-theme' : '') }}">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        
        <!-- Mobile Filter Toggle -->
        <div class="lg:hidden mb-4">
            <button id="mobile-filter-toggle" class="w-full bg-[#1c1c1e] border border-gray-800/30 rounded-lg px-4 py-3 flex items-center justify-between text-white hover:bg-[#2c2c2e] transition-colors">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 {{ $isBaseusCategory ? 'text-[#facc15]' : ($isUgreenCategory ? 'text-[#00c65e]' : 'text-[#f59e0b]') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="w-full lg:w-72 lg:flex-shrink-0 hidden lg:block" id="filter-sidebar">
                <div class="bg-[#1c1c1e] rounded-xl border border-gray-800/30 p-6 shadow-lg">
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
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-semibold text-gray-200">Price Range</h4>
                                <button type="button" id="reset-price" class="text-xs text-gray-500 hover:text-[#f59e0b] transition-colors">Reset</button>
                            </div>
                            
                            <!-- Current Price Display -->
                            <div class="bg-[#2c2c2e] rounded-lg p-3 mb-4 border border-gray-700/50">
                                <div class="flex items-center justify-between">
                                    <div class="text-center flex-1">
                                        <div class="text-xs text-gray-500 mb-1">From</div>
                                        <div class="text-sm font-medium text-white">Rs. <span id="min-price-display">{{ number_format($priceRange['min'] ?? 0) }}</span></div>
                                    </div>
                                    <div class="w-px h-8 bg-gray-600 mx-3"></div>
                                    <div class="text-center flex-1">
                                        <div class="text-xs text-gray-500 mb-1">To</div>
                                        <div class="text-sm font-medium text-white">Rs. <span id="max-price-display">{{ number_format($priceRange['max'] ?? 100000) }}</span></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Modern Range Slider -->
                            <div class="relative mb-4">
                                <div class="price-range-container">
                                    <input type="range" name="min_price" id="min-price" 
                                           min="{{ $priceRange['min'] ?? 0 }}" 
                                           max="{{ $priceRange['max'] ?? 100000 }}" 
                                           value="{{ request('min_price', $priceRange['min'] ?? 0) }}" 
                                           class="price-range-input price-range-min">
                                    <input type="range" name="max_price" id="max-price" 
                                           min="{{ $priceRange['min'] ?? 0 }}" 
                                           max="{{ $priceRange['max'] ?? 100000 }}" 
                                           value="{{ request('max_price', $priceRange['max'] ?? 100000) }}" 
                                           class="price-range-input price-range-max">
                                    <div class="price-range-track">
                                        <div class="price-range-track-active" id="price-track-active"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Manual Input Fields -->
                            <div class="grid grid-cols-2 gap-3">
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-xs text-gray-500">Rs.</div>
                                    <input type="number" id="min-price-input" 
                                           min="{{ $priceRange['min'] ?? 0 }}" 
                                           max="{{ $priceRange['max'] ?? 100000 }}" 
                                           value="{{ request('min_price', $priceRange['min'] ?? 0) }}"
                                           placeholder="Min"
                                           class="w-full bg-[#2c2c2e] border border-gray-700 text-white rounded-lg pl-8 pr-3 py-2.5 text-sm focus:ring-2 focus:ring-[#f59e0b]/50 focus:border-[#f59e0b] transition-all hover:border-gray-600">
                                </div>
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-xs text-gray-500">Rs.</div>
                                    <input type="number" id="max-price-input" 
                                           min="{{ $priceRange['min'] ?? 0 }}" 
                                           max="{{ $priceRange['max'] ?? 100000 }}" 
                                           value="{{ request('max_price', $priceRange['max'] ?? 100000) }}"
                                           placeholder="Max"
                                           class="w-full bg-[#2c2c2e] border border-gray-700 text-white rounded-lg pl-8 pr-3 py-2.5 text-sm focus:ring-2 focus:ring-[#f59e0b]/50 focus:border-[#f59e0b] transition-all hover:border-gray-600">
                                </div>
                            </div>
                            
                            <!-- Quick Price Presets -->
                            <div class="mt-4">
                                <div class="text-xs text-gray-500 mb-2">Quick filters:</div>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" onclick="setQuickPrice(0, 50000)" class="quick-price-btn text-xs px-3 py-1.5 bg-[#2c2c2e] text-gray-400 rounded-lg hover:bg-[#f59e0b] hover:text-white transition-all border border-gray-700 hover:border-[#f59e0b]">
                                        Under 50k
                                    </button>
                                    <button type="button" onclick="setQuickPrice(50000, 100000)" class="quick-price-btn text-xs px-3 py-1.5 bg-[#2c2c2e] text-gray-400 rounded-lg hover:bg-[#f59e0b] hover:text-white transition-all border border-gray-700 hover:border-[#f59e0b]">
                                        50k - 100k
                                    </button>
                                    <button type="button" onclick="setQuickPrice(100000, 300000)" class="quick-price-btn text-xs px-3 py-1.5 bg-[#2c2c2e] text-gray-400 rounded-lg hover:bg-[#f59e0b] hover:text-white transition-all border border-gray-700 hover:border-[#f59e0b]">
                                        Above 100k
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product Status Filters -->
                        @if(isset($availableStatuses) && !empty($availableStatuses))
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-3">Product Status</label>
                            <div class="space-y-2">
                                @foreach($availableStatuses as $status)
                                <label class="flex items-center cursor-pointer hover:bg-[#2c2c2e] rounded p-2 transition-colors">
                                    <input type="checkbox" name="status[]" value="{{ $status['name'] }}" 
                                           {{ in_array($status['name'], (array)request('status', [])) ? 'checked' : '' }}
                                           class="w-4 h-4 text-[#f59e0b] bg-[#2c2c2e] border-gray-600 rounded focus:ring-[#f59e0b] focus:ring-2">
                                    <span class="ml-3 text-sm text-gray-300 flex-1">
                                        @if($status['name'] === 'Pre Order')
                                            <span class="inline-flex items-center">
                                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                                Pre Order
                                            </span>
                                        @elseif($status['name'] === 'Coming Soon')
                                            <span class="inline-flex items-center">
                                                <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                                                Coming Soon
                                            </span>
                                        @else
                                            {{ $status['name'] }}
                                        @endif
                                    </span>
                                    <span class="text-xs text-gray-500 bg-[#2c2c2e] px-2 py-0.5 rounded">{{ $status['count'] }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endif

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
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-8 md:mb-12" id="products-grid">
                @foreach($products as $product)
                    <a href="{{ route('products.show', ['category' => $category->slug ?: $category->id, 'product' => $product->slug]) }}" class="product-card block bg-[#1c1c1e] rounded-xl border border-gray-800/30 overflow-hidden hover:border-[#f59e0b]/30 transition-all duration-300 group shadow-lg hover:shadow-xl hover:shadow-[#f59e0b]/10 cursor-pointer">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden bg-[#1a1a1c] aspect-[4/3]">
                            <img 
                                src="{{ $product->main_image }}" 
                                alt="{{ $product->name }}" 
                                class="product-image w-full h-full object-contain transition-transform duration-300 group-hover:scale-105 p-6 bg-white/5 rounded-lg"
                                loading="lazy"
                            >
                            
                            <!-- Stock Badge -->
                            @if($product->status && in_array($product->status->status_name, ['Coming Soon', 'Pre Order']))
                                <div class="absolute top-3 left-3 bg-[#3b82f6] text-white text-xs font-medium px-2.5 py-1 rounded-lg backdrop-blur-sm">
                                    {{ strtoupper($product->status->status_name) }}
                                </div>
                            @elseif(\App\Models\SmaProduct::listingQuantityFromRaw($product->getAttributes()['quantity'] ?? null) > 0)
                                <div class="absolute top-3 left-3 bg-[#34d399] text-white text-xs font-medium px-2.5 py-1 rounded-lg backdrop-blur-sm">
                                    IN STOCK
                                </div>
                            @else
                                <div class="absolute top-3 left-3 bg-[#ef4444] text-white text-xs font-medium px-2.5 py-1 rounded-lg backdrop-blur-sm">
                                    OUT OF STOCK
                                </div>
                            @endif

                            @if($product->is_on_sale)
                                @if(isset($isChristmasActive) && $isChristmasActive)
                                    <!-- Replace SALE text label with Christmas badge (top-right on category cards) -->
                                    <div class="christmas-sale-badge">
                                        <img src="{{ asset('images/christmas-sale-badge.png') }}" alt="Christmas Sale">
                                    </div>
                                @else
                                <div class="absolute top-3 right-3 bg-[#f59e0b] text-white text-xs font-bold px-2.5 py-1 rounded-lg backdrop-blur-sm">
                                    SALE
                                </div>
                                @endif
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
                                            class="w-full bg-gradient-to-r from-primary-500/15 to-amber-500/15 backdrop-blur-sm border border-primary-400/40 hover:from-primary-500/25 hover:to-amber-500/25 hover:border-primary-400/60 text-primary-200 px-3 md:px-4 py-2 md:py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all duration-300 shadow-lg hover:shadow-primary-500/20 hover:-translate-y-0.5 tracking-wide">
                                        Add to Cart
                                    </button>
                                @else
                                    @if($product->status && in_array($product->status->status_name, ['Coming Soon', 'Pre Order']))
                                        <button onclick="event.preventDefault(); event.stopPropagation(); showSpecialOrderContact('{{ $product->status->status_name }}', '{{ addslashes($product->name) }}')" 
                                                class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-3 md:px-4 py-2 md:py-2.5 rounded-lg text-xs md:text-sm font-semibold transition-all">
                                            Contact Us
                                        </button>
                                    @else
                                        <button disabled 
                                                class="w-full bg-[#2c2c2e] text-gray-500 px-3 md:px-4 py-2 md:py-2.5 rounded-lg text-xs md:text-sm font-medium cursor-not-allowed border border-gray-700"
                                                title="{{ $product->cart_restriction_reason }}">
                                            {{ $product->cart_restriction_reason ?: 'Unavailable' }}
                                        </button>
                                    @endif
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
    .baseus-category-theme {
        background: linear-gradient(180deg, #111111 0%, #1a1606 100%);
        border-bottom-color: rgba(250, 204, 21, 0.25) !important;
    }

    /* Brand accent adjustments for Baseus category pages only */
    .baseus-category-theme + section .product-card:hover {
        border-color: rgba(250, 204, 21, 0.4) !important;
        box-shadow: 0 10px 30px rgba(250, 204, 21, 0.12) !important;
    }

    .baseus-category-theme + section .text-\[\#f59e0b\],
    .baseus-category-theme + section .group-hover\:text-\[\#f59e0b\]:hover {
        color: #facc15 !important;
    }

    .baseus-category-theme + section .hover\:bg-\[\#f59e0b\]:hover {
        background-color: #facc15 !important;
        border-color: #facc15 !important;
        color: #111827 !important;
    }

    .baseus-products-theme #mobile-filter-toggle,
    .baseus-products-theme #filter-sidebar > div,
    .baseus-products-theme .bg-\[\#1c1c1e\].rounded-lg.border,
    .baseus-products-theme .bg-\[\#1c1c1e\].rounded-xl.border {
        border-color: rgba(250, 204, 21, 0.22) !important;
    }

    .baseus-products-theme #mobile-filter-toggle svg,
    .baseus-products-theme #clear-filters:hover,
    .baseus-products-theme #reset-price:hover {
        color: #facc15 !important;
    }

    .baseus-products-theme .price-range-track-active {
        background: linear-gradient(90deg, #facc15, #eab308) !important;
    }

    .baseus-products-theme .price-range-input::-webkit-slider-thumb,
    .baseus-products-theme .price-range-input::-moz-range-thumb {
        background: #facc15 !important;
        box-shadow: 0 4px 12px rgba(250, 204, 21, 0.35), 0 2px 4px rgba(0, 0, 0, 0.2) !important;
    }

    .baseus-products-theme .quick-price-btn:hover,
    .baseus-products-theme .quick-price-btn.active {
        background: #facc15 !important;
        border-color: #facc15 !important;
        color: #111827 !important;
        box-shadow: 0 4px 10px rgba(250, 204, 21, 0.25) !important;
    }

    .baseus-products-theme .product-card .bg-gradient-to-r.from-primary-500\/15.to-amber-500\/15 {
        background: linear-gradient(90deg, rgba(250, 204, 21, 0.22), rgba(234, 179, 8, 0.18)) !important;
        border-color: rgba(250, 204, 21, 0.55) !important;
        color: #fde68a !important;
    }

    .baseus-products-theme .product-card .bg-gradient-to-r.from-primary-500\/15.to-amber-500\/15:hover {
        background: linear-gradient(90deg, rgba(250, 204, 21, 0.32), rgba(234, 179, 8, 0.24)) !important;
        box-shadow: 0 10px 24px rgba(250, 204, 21, 0.2) !important;
    }

    /* UGREEN brand (category + listing page) */
    .ugreen-category-theme {
        background: linear-gradient(180deg, #0f1412 0%, #0a1f16 100%);
        border-bottom-color: rgba(0, 198, 94, 0.28) !important;
    }

    .ugreen-category-theme + section .product-card:hover {
        border-color: rgba(0, 198, 94, 0.45) !important;
        box-shadow: 0 10px 30px rgba(0, 198, 94, 0.14) !important;
    }

    .ugreen-category-theme + section .text-\[\#f59e0b\],
    .ugreen-category-theme + section .group-hover\:text-\[\#f59e0b\]:hover {
        color: #5ee9a8 !important;
    }

    .ugreen-category-theme + section .hover\:bg-\[\#f59e0b\]:hover {
        background-color: #00c65e !important;
        border-color: #00c65e !important;
        color: #052e16 !important;
    }

    .ugreen-products-theme #mobile-filter-toggle,
    .ugreen-products-theme #filter-sidebar > div,
    .ugreen-products-theme .bg-\[\#1c1c1e\].rounded-lg.border,
    .ugreen-products-theme .bg-\[\#1c1c1e\].rounded-xl.border {
        border-color: rgba(0, 198, 94, 0.22) !important;
    }

    .ugreen-products-theme #mobile-filter-toggle svg:first-of-type,
    .ugreen-products-theme #clear-filters:hover,
    .ugreen-products-theme #reset-price:hover {
        color: #00c65e !important;
    }

    .ugreen-products-theme .price-range-track-active {
        background: linear-gradient(90deg, #00c65e, #059669) !important;
    }

    .ugreen-products-theme .price-range-input::-webkit-slider-thumb,
    .ugreen-products-theme .price-range-input::-moz-range-thumb {
        background: #00c65e !important;
        box-shadow: 0 4px 12px rgba(0, 198, 94, 0.35), 0 2px 4px rgba(0, 0, 0, 0.2) !important;
    }

    .ugreen-products-theme .quick-price-btn:hover,
    .ugreen-products-theme .quick-price-btn.active {
        background: #00c65e !important;
        border-color: #00c65e !important;
        color: #052e16 !important;
        box-shadow: 0 4px 10px rgba(0, 198, 94, 0.25) !important;
    }

    .ugreen-products-theme .product-card .bg-gradient-to-r.from-primary-500\/15.to-amber-500\/15 {
        background: linear-gradient(90deg, rgba(0, 198, 94, 0.22), rgba(5, 150, 105, 0.18)) !important;
        border-color: rgba(0, 198, 94, 0.5) !important;
        color: #a7f3d0 !important;
    }

    .ugreen-products-theme .product-card .bg-gradient-to-r.from-primary-500\/15.to-amber-500\/15:hover {
        background: linear-gradient(90deg, rgba(0, 198, 94, 0.32), rgba(5, 150, 105, 0.26)) !important;
        box-shadow: 0 10px 24px rgba(0, 198, 94, 0.18) !important;
    }

    /* 4:3 aspect ratio for product images */
    .aspect-\[4\/3\] {
        aspect-ratio: 4 / 3;
    }
    
    /* Fallback for older browsers */
    @supports not (aspect-ratio: 4 / 3) {
        .aspect-\[4\/3\] {
            position: relative;
        }
        
        .aspect-\[4\/3\]::before {
            content: '';
            display: block;
            padding-bottom: 75%; /* 3/4 = 0.75 = 75% */
        }
        
        .aspect-\[4\/3\] img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
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

    /* Modern Price Range Slider Styles */
    .price-range-container {
        position: relative;
        height: 40px;
        display: flex;
        align-items: center;
    }

    .price-range-track {
        position: absolute;
        width: 100%;
        height: 6px;
        background: #374151;
        border-radius: 3px;
        z-index: 1;
        top: 50%;
        transform: translateY(-50%);
    }

    .price-range-track-active {
        position: absolute;
        height: 6px;
        background: linear-gradient(90deg, #f59e0b, #d97706);
        border-radius: 3px;
        transition: all 0.3s ease;
        top: 50%;
        transform: translateY(-50%);
    }

    .price-range-input {
        position: absolute;
        width: 100%;
        height: 40px;
        top: 0;
        left: 0;
        background: none;
        pointer-events: none;
        -webkit-appearance: none;
        appearance: none;
        outline: none;
        border: none;
        z-index: 2;
    }

    .price-range-input::-webkit-slider-thumb {
        height: 20px;
        width: 20px;
        border-radius: 50%;
        background: #f59e0b;
        border: 3px solid #ffffff;
        cursor: pointer;
        pointer-events: all;
        -webkit-appearance: none;
        appearance: none;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3), 0 2px 4px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        position: relative;
        margin-top: -7px; /* Center thumb with 6px track: (20px thumb - 6px track) / 2 = 7px */
    }

    .price-range-input::-webkit-slider-thumb:hover {
        background: #d97706;
        transform: scale(1.15);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4), 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .price-range-input::-webkit-slider-thumb:active {
        transform: scale(1.25);
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.5), 0 4px 12px rgba(0, 0, 0, 0.4);
    }

    .price-range-input::-moz-range-thumb {
        height: 20px;
        width: 20px;
        border-radius: 50%;
        background: #f59e0b;
        border: 3px solid #ffffff;
        cursor: pointer;
        pointer-events: all;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3), 0 2px 4px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        -moz-appearance: none;
        margin-top: -7px; /* Center thumb with 6px track for Firefox */
    }

    .price-range-input::-moz-range-thumb:hover {
        background: #d97706;
        transform: scale(1.15);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4), 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .price-range-input::-webkit-slider-runnable-track {
        width: 100%;
        height: 6px;
        background: transparent;
        border-radius: 3px;
    }

    .price-range-input::-moz-range-track {
        width: 100%;
        height: 6px;
        background: transparent;
        border-radius: 3px;
        border: none;
    }

    .price-range-min {
        z-index: 3;
    }

    .price-range-max {
        z-index: 4;
    }

    /* Enhanced focus states for better accessibility */
    .price-range-input:focus::-webkit-slider-thumb {
        outline: 2px solid #f59e0b;
        outline-offset: 2px;
    }

    .price-range-input:focus::-moz-range-thumb {
        outline: 2px solid #f59e0b;
        outline-offset: 2px;
    }

    /* Quick price button animations */
    .quick-price-btn {
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .quick-price-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(245, 158, 11, 0.2);
    }

    .quick-price-btn:active {
        transform: translateY(0);
    }

    .quick-price-btn.active {
        background: #f59e0b !important;
        color: white !important;
        border-color: #f59e0b !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // console.log('🔧 AJAX Filter System Loading...');
    
    // Global state
    let FilterSystem = {
        isLoading: false,
        searchTimeout: null,
        isInitialized: false
    };

    /** Category slug (or id) for the listing page — must match server-rendered links, not product.category (parent). */
    const listingCategorySlug = @json($category->slug ?: (string) $category->id);

    /** Match SmaProduct::listingQuantityFromRaw — JSON may send numbers or strings */
    function listingStockQty(product) {
        const v = product.stock_quantity ?? product.quantity;
        if (v === null || v === undefined || v === '') {
            return 0;
        }
        const n = parseFloat(String(v).trim());
        return (Number.isFinite(n) && !Number.isNaN(n)) ? Math.max(0, n) : 0;
    }

    // Initialize filters when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        if (FilterSystem.isInitialized) {
            // console.log('⚠️ Filter system already initialized');
            return;
        }
        
        // console.log('Initializing AJAX Filter System...');
        
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
        // console.log('📍 Elements found:', {
        //     filterForm: !!elements.filterForm,
        //     sortSelect: !!elements.sortSelect,
        //     productsContainer: !!elements.productsContainer,
        //     resultsInfo: !!elements.resultsInfo,
        //     clearFiltersBtn: !!elements.clearFiltersBtn,
        //     searchInput: !!elements.searchInput
        // });

        // Main filter function
        function filterProducts() {
            // console.log('🔍 Filter triggered');
            
            if (FilterSystem.isLoading) {
                // console.log('⏳ Already loading, skipping...');
                return;
            }

            if (!elements.filterForm || !elements.productsContainer) {
                console.error('❌ Required elements missing for filters!');
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
                // console.log('📝 Filter param:', key, '=', value);
            }

            // Make AJAX request
            const url = window.location.pathname + '?' + params.toString();
            // console.log('🌐 AJAX URL:', url);

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                // console.log('📡 Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                // console.log('✅ AJAX Success:', data);
                if (data.success) {
                    updateProductsGrid(data.products || []);
                    updateResultsInfo(data.pagination || {});
                    updatePagination(data.pagination || {}); // Update pagination with AJAX data
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

            let gridHTML = '<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-8 md:mb-12">';
            
            products.forEach(product => {
                let stockBadge = '';
                // Check for Pre Order or Coming Soon status first
                // Use status_data from controller or fallback to status relationship
                const statusName = (product.status_data && product.status_data.status_name) || 
                                   (product.status && product.status.status_name);
                
                if (statusName && ['Coming Soon', 'Pre Order'].includes(statusName)) {
                    stockBadge = `<div class="absolute top-3 left-3 bg-[#3b82f6] text-white text-xs font-medium px-2.5 py-1 rounded-lg backdrop-blur-sm">${statusName.toUpperCase()}</div>`;
                } else if (listingStockQty(product) > 0) {
                    stockBadge = '<div class="absolute top-3 left-3 bg-[#34d399] text-white text-xs font-medium px-2.5 py-1 rounded-lg backdrop-blur-sm">IN STOCK</div>';
                } else {
                    stockBadge = '<div class="absolute top-3 left-3 bg-[#ef4444] text-white text-xs font-medium px-2.5 py-1 rounded-lg backdrop-blur-sm">OUT OF STOCK</div>';
                }

                // Sale / Christmas badge
                const isChristmasActive = {{ isset($isChristmasActive) && $isChristmasActive ? 'true' : 'false' }};
                let saleBadge = '';

                if (product.is_on_sale) {
                    if (isChristmasActive) {
                        // Replace SALE text label with Christmas badge in AJAX cards
                        saleBadge = '<div class="christmas-sale-badge"><img src="{{ asset("images/christmas-sale-badge.png") }}" alt="Christmas Sale"></div>';
                    } else {
                        saleBadge = '<div class="absolute top-3 right-3 bg-[#f59e0b] text-white text-xs font-bold px-2.5 py-1 rounded-lg backdrop-blur-sm">SALE</div>';
                    }
                }
                
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

                // Same segment as Blade route('products.show', ['category' => $category, ...]) — current listing, not product.category (main).
                const productSlug = product.slug || product.id;
                const productUrl = `/${listingCategorySlug}/${productSlug}`;
                
                gridHTML += `
                    <a href="${productUrl}" class="product-card block bg-[#1c1c1e] rounded-xl border border-gray-800/30 overflow-hidden hover:border-[#f59e0b]/30 transition-all duration-300 group shadow-lg hover:shadow-xl hover:shadow-[#f59e0b]/10 cursor-pointer">
                        <div class="relative overflow-hidden bg-[#1a1a1c] aspect-[4/3]">
                            <img src="${product.main_image}" alt="${product.name}" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105 p-6 bg-white/5 rounded-lg" loading="lazy">
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
                                ${(() => {
                                    // Check if product has Pre Order or Coming Soon status
                                    const hasSpecialStatus = product.status_data && 
                                        ['Coming Soon', 'Pre Order'].includes(product.status_data.status_name);
                                    
                                    if (hasSpecialStatus) {
                                        const statusName = product.status_data.status_name.replace(/'/g, "\\'");
                                        const productName = product.name.replace(/'/g, "\\'");
                                        return `<button onclick="event.preventDefault(); event.stopPropagation(); showSpecialOrderContact('${statusName}', '${productName}')" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 shadow-lg hover:shadow-blue-500/20 hover:-translate-y-0.5 tracking-wide">Contact Us</button>`;
                                    } else if (listingStockQty(product) > 0) {
                                        return `<button onclick="event.preventDefault(); event.stopPropagation(); addToCart(${product.id})" class="w-full bg-gradient-to-r from-primary-500/15 to-amber-500/15 backdrop-blur-sm border border-primary-400/40 hover:from-primary-500/25 hover:to-amber-500/25 hover:border-primary-400/60 text-primary-200 px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 shadow-lg hover:shadow-primary-500/20 hover:-translate-y-0.5 tracking-wide">Add to Cart</button>`;
                                    } else {
                                        return `<button disabled class="w-full bg-[#2c2c2e] text-gray-500 px-4 py-2.5 rounded-lg text-sm font-medium cursor-not-allowed border border-gray-700">Out of Stock</button>`;
                                }
                                })()}
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

        // Update pagination for AJAX
        function updatePagination(pagination) {
            if (!elements.paginationContainer) return;
            
            // If no pagination data or only one page, hide pagination
            if (!pagination || pagination.last_page <= 1) {
                elements.paginationContainer.innerHTML = '';
                return;
            }
            
            // Get current filter parameters
            const currentParams = new URLSearchParams();
            if (elements.filterForm) {
                const formData = new FormData(elements.filterForm);
                for (let [key, value] of formData.entries()) {
                    if (value) currentParams.append(key, value);
                }
            }
            if (elements.sortSelect && elements.sortSelect.value) {
                currentParams.append('sort', elements.sortSelect.value);
            }
            
            // Generate pagination HTML
            let paginationHTML = '<nav class="flex flex-wrap items-center justify-center gap-1 sm:gap-2 mt-6 sm:mt-8 px-2" role="navigation" aria-label="Pagination Navigation">';
            
            // Previous page link
            if (pagination.current_page > 1) {
                const prevParams = new URLSearchParams(currentParams);
                prevParams.set('page', pagination.current_page - 1);
                paginationHTML += `
                    <a href="?${prevParams.toString()}" 
                       class="px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm leading-4 text-gray-300 bg-gray-800 border border-gray-700 rounded-md hover:bg-gray-700 hover:text-white transition-colors flex-shrink-0">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>`;
            } else {
                paginationHTML += `
                    <span class="px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm leading-4 text-gray-500 bg-gray-800 border border-gray-700 rounded-md cursor-not-allowed flex-shrink-0">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </span>`;
            }
            
            // Page number links
            const startPage = Math.max(1, pagination.current_page - 2);
            const endPage = Math.min(pagination.last_page, pagination.current_page + 2);
            
            // Show first page if we're not starting from 1
            if (startPage > 1) {
                const firstParams = new URLSearchParams(currentParams);
                firstParams.set('page', 1);
                paginationHTML += `<a href="?${firstParams.toString()}" class="px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm leading-4 text-gray-300 bg-gray-800 border border-gray-700 rounded-md hover:bg-gray-700 hover:text-white transition-colors min-w-[32px] sm:min-w-[36px] text-center">1</a>`;
                if (startPage > 2) {
                    paginationHTML += `<span class="hidden sm:inline-flex px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm leading-4 text-gray-500 bg-gray-800 border border-gray-700 rounded-md">...</span>`;
                }
            }
            
            // Page numbers around current page
            for (let page = startPage; page <= endPage; page++) {
                if (page === pagination.current_page) {
                    paginationHTML += `<span class="px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm leading-4 text-white bg-[#f59e0b] border border-[#f59e0b] rounded-md font-medium min-w-[32px] sm:min-w-[36px] text-center">${page}</span>`;
                } else {
                    const pageParams = new URLSearchParams(currentParams);
                    pageParams.set('page', page);
                    // Show only critical pages on mobile (current, first, last, and adjacent)
                    const showOnMobile = (page === 1 || page === pagination.last_page || Math.abs(page - pagination.current_page) <= 1);
                    const mobileClass = showOnMobile ? '' : 'hidden sm:inline-flex';
                    paginationHTML += `<a href="?${pageParams.toString()}" class="px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm leading-4 text-gray-300 bg-gray-800 border border-gray-700 rounded-md hover:bg-gray-700 hover:text-white transition-colors min-w-[32px] sm:min-w-[36px] text-center ${mobileClass}">${page}</a>`;
                }
            }
            
            // Show last page if we're not ending at the last page
            if (endPage < pagination.last_page) {
                if (endPage < pagination.last_page - 1) {
                    paginationHTML += `<span class="hidden sm:inline-flex px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm leading-4 text-gray-500 bg-gray-800 border border-gray-700 rounded-md">...</span>`;
                }
                const lastParams = new URLSearchParams(currentParams);
                lastParams.set('page', pagination.last_page);
                paginationHTML += `<a href="?${lastParams.toString()}" class="px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm leading-4 text-gray-300 bg-gray-800 border border-gray-700 rounded-md hover:bg-gray-700 hover:text-white transition-colors min-w-[32px] sm:min-w-[36px] text-center">${pagination.last_page}</a>`;
            }
            
            // Next page link
            if (pagination.current_page < pagination.last_page) {
                const nextParams = new URLSearchParams(currentParams);
                nextParams.set('page', pagination.current_page + 1);
                paginationHTML += `
                    <a href="?${nextParams.toString()}" 
                       class="px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm leading-4 text-gray-300 bg-gray-800 border border-gray-700 rounded-md hover:bg-gray-700 hover:text-white transition-colors flex-shrink-0">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>`;
            } else {
                paginationHTML += `
                    <span class="px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm leading-4 text-gray-500 bg-gray-800 border border-gray-700 rounded-md cursor-not-allowed flex-shrink-0">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>`;
            }
            
            paginationHTML += '</nav>';
            
            // Update pagination container
            elements.paginationContainer.innerHTML = paginationHTML;
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
                
                if (elements.minPriceInput) elements.minPriceInput.value = elements.minPriceSlider.min;
                if (elements.maxPriceInput) elements.maxPriceInput.value = elements.maxPriceSlider.max;
                
                updatePriceDisplay();
                updateActiveTrack();
            }
            
            // Remove active state from quick price buttons
            const quickButtons = document.querySelectorAll('.quick-price-btn');
            quickButtons.forEach(btn => btn.classList.remove('active'));
            
            filterProducts();
        }

        // Enhanced Price Range Functions
        function updatePriceDisplay() {
            if (elements.minPriceDisplay && elements.maxPriceDisplay && 
                elements.minPriceSlider && elements.maxPriceSlider) {
                const minVal = parseInt(elements.minPriceSlider.value);
                const maxVal = parseInt(elements.maxPriceSlider.value);
                
                elements.minPriceDisplay.textContent = minVal.toLocaleString();
                elements.maxPriceDisplay.textContent = maxVal.toLocaleString();
                
                updateActiveTrack();
            }
        }

        function updateActiveTrack() {
            const activeTrack = document.getElementById('price-track-active');
            if (activeTrack && elements.minPriceSlider && elements.maxPriceSlider) {
                const min = parseInt(elements.minPriceSlider.min);
                const max = parseInt(elements.maxPriceSlider.max);
                const minVal = parseInt(elements.minPriceSlider.value);
                const maxVal = parseInt(elements.maxPriceSlider.value);
                
                const leftPercent = ((minVal - min) / (max - min)) * 100;
                const rightPercent = ((maxVal - min) / (max - min)) * 100;
                
                activeTrack.style.left = leftPercent + '%';
                activeTrack.style.width = (rightPercent - leftPercent) + '%';
            }
        }

        // Quick Price Preset Functions
        window.setQuickPrice = function(minPrice, maxPrice) {
            if (elements.minPriceSlider && elements.maxPriceSlider) {
                elements.minPriceSlider.value = minPrice;
                elements.maxPriceSlider.value = maxPrice;
                
                if (elements.minPriceInput) elements.minPriceInput.value = minPrice;
                if (elements.maxPriceInput) elements.maxPriceInput.value = maxPrice;
                
                updatePriceDisplay();
                filterProducts();
                
                // Visual feedback for quick buttons
                const quickButtons = document.querySelectorAll('.quick-price-btn');
                quickButtons.forEach(btn => btn.classList.remove('active'));
                event.target.classList.add('active');
                
                setTimeout(() => {
                    event.target.classList.remove('active');
                }, 2000);
            }
        }

        // Reset Price Function
        function resetPrice() {
            if (elements.minPriceSlider && elements.maxPriceSlider) {
                elements.minPriceSlider.value = elements.minPriceSlider.min;
                elements.maxPriceSlider.value = elements.maxPriceSlider.max;
                
                if (elements.minPriceInput) elements.minPriceInput.value = elements.minPriceSlider.min;
                if (elements.maxPriceInput) elements.maxPriceInput.value = elements.maxPriceSlider.max;
                
                updatePriceDisplay();
                filterProducts();
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
                updateActiveTrack();
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

        // Reset Price Button
        const resetPriceBtn = document.getElementById('reset-price');
        if (resetPriceBtn) {
            resetPriceBtn.addEventListener('click', resetPrice);
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

        // Initialize price display and active track
        updatePriceDisplay();
        updateActiveTrack();

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
                quantity: 1,
                catalog: document.documentElement.dataset.catalogSource || 'msk'
            })
        })
        .then(response => response.json())
        .then(data => {
            button.disabled = false;
            button.innerHTML = originalText;
            
            if (data.success) {
                // Professional success feedback - no childish animations
                button.classList.add('bg-gray-700', 'border-primary-500');
                button.innerHTML = 'Added to Cart';
                
                setTimeout(() => {
                    button.classList.remove('bg-gray-700', 'border-primary-500');
                    button.innerHTML = originalText;
                }, 1500);
                
                // Get product name for animation
                const productCard = button.closest('.product-card');
                const productName = productCard.querySelector('h3')?.textContent.trim() || 'Product';
                
                // Use professional cart animation (no flashy effects)
                window.animateCartAddition(data.cart_total, productName);
                
            } else {
                // Professional error feedback
                button.classList.add('bg-red-900', 'border-red-500');
                button.innerHTML = 'Error - Try Again';
                
                setTimeout(() => {
                    button.classList.remove('bg-red-900', 'border-red-500');
                    button.innerHTML = originalText;
                }, 1500);
                
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
    
    // Fallback function for backward compatibility (AJAX Filter Fix)
    window.addToCart = window.addToCartFromCategory;
    
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
@endpush

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
