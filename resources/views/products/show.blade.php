@extends('layouts.app')

@php
    $seoCategory = $product->category?->name;
    $seoCategorySlug = $product->category ? ($product->category->slug ?: $product->category->id) : null;
    $seoProductUrl = $seoCategorySlug
        ? route('products.show', ['category' => $seoCategorySlug, 'product' => $product->slug ?: $product->id])
        : url()->current();
    $seoPrice = (float) $product->final_price;
    $seoInStock = $product->shelfQuantity() > 0;
    $seoRaw = $product->product_details ?: ($product->details ?: '');
    $seoPlain = trim(preg_replace('/\s+/', ' ', strip_tags(html_entity_decode((string) $seoRaw))));
    $seoDescription = $seoPlain !== ''
        ? \Illuminate\Support\Str::limit($seoPlain, 155)
        : ('Buy ' . $product->name . ' in Sri Lanka at MSK Computers'
            . ($seoCategory ? ' — ' . $seoCategory : '')
            . ($seoPrice > 0 ? '. Price LKR ' . number_format($seoPrice, 0) : '')
            . '. Warranty, island-wide delivery & expert support.');
    $seoTitle = $product->name
        . ($seoPrice > 0 ? ' | LKR ' . number_format($seoPrice, 0) : '')
        . ' | Buy Online Sri Lanka - MSK Computers';
    $seoKeywords = implode(', ', array_filter([
        $product->name,
        $seoCategory,
        $product->code,
        'buy ' . ($seoCategory ?: 'computer') . ' Sri Lanka',
        'MSK Computers',
        'Ragama',
        'computer store Sri Lanka',
        'price in Sri Lanka',
        'online computer shop',
    ]));
    $seoImage = collect($product->images ?? [])->first(function ($img) {
        return is_string($img) && $img !== '' && !str_contains($img, 'unsplash.com');
    }) ?: ($product->main_image ?: asset('images/msk-share-og.png'));
    $seoOgTitle = $product->name
        . ($seoPrice > 0 ? ' - LKR ' . number_format($seoPrice, 0) : '')
        . ' | MSK Computers Sri Lanka';
    $seoOgImageAlt = $product->name . ' for sale at MSK Computers Sri Lanka';
    $seoProductPrice = number_format(max($seoPrice, 0), 2, '.', '');
    $seoAvailability = $seoInStock ? 'in stock' : 'out of stock';
@endphp

@section('title', $seoTitle)
@section('description', $seoDescription)
@section('keywords', $seoKeywords)
@section('canonical', $seoProductUrl)
@section('og_title', $seoOgTitle)
@section('og_description', $seoDescription)
@section('og_image', $seoImage)
@section('og_image_alt', $seoOgImageAlt)
@section('og_type', 'product')
@section('product_price', $seoProductPrice)
@section('product_currency', 'LKR')
@section('product_availability', $seoAvailability)
@section('robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')

@push('structured_data')
    @include('products.partials.seo-structured-data', ['product' => $product])
@endpush

@section('content')
<!-- Product Details -->
<section class="py-6 sm:py-12 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-12 items-start">
            <!-- Left column: gallery + attributes/specs under images -->
            <div class="space-y-4">
            <!-- Product Images -->
            <div class="p-3 sm:p-6 bg-gradient-to-br from-gray-900 to-black rounded-xl border border-gray-800 relative">
                <!-- Main Image -->
                <div class="mb-4 sm:mb-6 p-2 sm:p-4 bg-black/30 rounded-xl border border-gray-700/50 relative">
                    <img id="mainImage" 
                         src="{{ $product->images[0] ?? 'https://via.placeholder.com/600x400?text=No+Image' }}" 
                         alt="{{ $product->name }} — buy at MSK Computers Sri Lanka"
                         width="600"
                         height="600"
                         class="w-full h-48 sm:h-64 md:h-80 lg:h-96 object-contain rounded-lg shadow-2xl p-2 sm:p-4 bg-white/5 backdrop-blur-sm"
                         fetchpriority="high">
                    
                    <!-- Christmas Sale Badge Overlay -->
                    @if(isset($isChristmasActive) && $isChristmasActive && $product->is_on_sale)
                        <div class="christmas-sale-badge">
                            <img src="{{ asset('images/christmas-sale-badge.png') }}" alt="Christmas Sale at MSK Computers">
                        </div>
                    @endif
                </div>
                
                <!-- Thumbnail Images -->
                @if(count($product->images) > 1)
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 sm:gap-3 p-1 sm:p-2">
                        @foreach($product->images as $index => $image)
                            <div class="p-1 sm:p-2 bg-black/20 rounded-lg border border-gray-700/30 hover:border-primary-500/50 transition-all">
                                <img src="{{ $image }}" 
                                     alt="{{ $product->name }} gallery image {{ $index + 1 }} — MSK Computers"
                                     width="120"
                                     height="120"
                                     loading="lazy"
                                     decoding="async"
                                     class="w-full h-12 sm:h-16 md:h-20 object-contain rounded cursor-pointer hover:opacity-80 transition-opacity p-1 bg-white/5 {{ $index === 0 ? 'ring-2 ring-primary-500' : '' }}"
                                     onclick="changeMainImage('{{ $image }}', this)">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Attributes & Specs directly under product images -->
            <div class="space-y-4">
                @if($product->grouped_attributes && count($product->grouped_attributes) > 0)
                    <section class="p-4 bg-gradient-to-br from-gray-900/50 to-black/50 rounded-lg border border-gray-800/50" aria-labelledby="product-attributes-heading">
                        <h2 id="product-attributes-heading" class="text-lg font-semibold text-white mb-3 flex items-center">
                            <svg class="w-4 h-4 text-primary-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            {{ $product->name }} — Product Attributes
                        </h2>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($product->grouped_attributes as $attributeName => $attributeValues)
                                <div class="bg-black/20 rounded-md p-3 border border-gray-700/30 hover:border-primary-500/20 transition-colors">
                                    <dt class="text-xs font-semibold text-primary-400 mb-2 block uppercase tracking-wider">{{ $attributeName }}</dt>
                                    <dd class="flex flex-wrap gap-1.5 m-0">
                                        @foreach($attributeValues as $value)
                                            <span class="inline-block bg-gray-800/50 text-gray-300 text-xs font-medium px-2 py-1 rounded border border-gray-700/30">
                                                {{ $value }}
                                            </span>
                                        @endforeach
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    </section>
                @endif

                @if($product->product_details && trim(strip_tags($product->product_details)))
                    @php
                        $htmlContent = $product->product_details;
                        $htmlContent = str_replace(['<p>', '<div>'], '', $htmlContent);
                        $htmlContent = str_replace(['</p>', '</div>'], "\n", $htmlContent);
                        $htmlContent = str_replace(['<br>', '<br/>', '<br />'], "\n", $htmlContent);
                        $htmlContent = str_replace('<ul>', "\n", $htmlContent);
                        $htmlContent = str_replace('</ul>', "\n", $htmlContent);
                        $htmlContent = str_replace('<li>', "• ", $htmlContent);
                        $htmlContent = str_replace('</li>', "\n", $htmlContent);
                        $cleanContent = strip_tags($htmlContent);
                        $cleanContent = html_entity_decode($cleanContent);
                        $cleanContent = preg_replace('/\n\s*\n/', "\n\n", $cleanContent);
                        $cleanContent = preg_replace('/\n{3,}/', "\n\n", $cleanContent);
                        $cleanContent = trim($cleanContent);
                        $lines = array_filter(array_map('trim', explode("\n", $cleanContent)));
                    @endphp

                    <section class="p-5 sm:p-6 bg-gradient-to-br from-gray-900/50 to-black/50 rounded-xl border border-gray-800/50" aria-labelledby="product-specs-heading">
                        <h2 id="product-specs-heading" class="text-xl font-semibold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 text-primary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            {{ $product->name }} — Details &amp; Specifications
                        </h2>

                        <div class="space-y-3">
                            @foreach($lines as $line)
                                @if(!empty($line))
                                    @if(preg_match('/^\d+\.\s/', $line) || str_starts_with($line, '•'))
                                        <div class="flex items-start py-2 px-4 bg-black/20 rounded-lg border border-gray-700/30">
                                            <p class="text-gray-300 leading-relaxed m-0">{{ $line }}</p>
                                        </div>
                                    @elseif(strpos($line, ':') !== false && strlen($line) < 100)
                                        @php
                                            $parts = explode(':', $line, 2);
                                            $key = trim($parts[0]);
                                            $value = isset($parts[1]) ? trim($parts[1]) : '';
                                        @endphp
                                        @if(!empty($value))
                                            <dl class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 px-4 bg-black/20 rounded-lg border border-gray-700/30 m-0">
                                                <dt class="text-gray-400 font-medium mb-1 sm:mb-0">{{ $key }}</dt>
                                                <dd class="text-white font-semibold sm:text-right m-0">{{ $value }}</dd>
                                            </dl>
                                        @else
                                            <h3 class="py-2 px-4 bg-primary-500/10 rounded-lg border border-primary-500/30 text-primary-400 font-bold text-center text-base">{{ $key }}</h3>
                                        @endif
                                    @elseif(preg_match('/^[A-Z\s]+$/', $line) && strlen($line) < 50)
                                        <h3 class="py-2 px-4 bg-primary-500/10 rounded-lg border border-primary-500/30 text-primary-400 font-bold text-center text-base">{{ $line }}</h3>
                                    @else
                                        <div class="py-3 px-4 bg-black/10 rounded-lg border border-gray-700/20">
                                            <p class="text-gray-300 leading-relaxed m-0">{{ $line }}</p>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>

                        @if($product->warranty || $product->model)
                            <dl class="mt-6 pt-4 border-t border-gray-700/50 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @if($product->warranty)
                                    <div class="flex justify-between items-center py-3 px-4 bg-black/20 rounded-lg border border-gray-700/30">
                                        <dt class="text-gray-400 font-medium">Warranty</dt>
                                        <dd class="text-white font-semibold m-0">{{ $product->warranty }}</dd>
                                    </div>
                                @endif
                                @if($product->model)
                                    <div class="flex justify-between items-center py-3 px-4 bg-black/20 rounded-lg border border-gray-700/30">
                                        <dt class="text-gray-400 font-medium">Model</dt>
                                        <dd class="text-white font-semibold m-0">{{ $product->model }}</dd>
                                    </div>
                                @endif
                            </dl>
                        @endif
                    </section>
                @else
                    <section class="p-5 sm:p-6 bg-gradient-to-br from-gray-900/50 to-black/50 rounded-xl border border-gray-800/50" aria-labelledby="product-info-heading">
                        <h2 id="product-info-heading" class="text-xl font-semibold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 text-primary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $product->name }} — Product Information
                        </h2>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @if($product->warranty)
                                <div class="flex justify-between items-center py-3 px-4 bg-black/20 rounded-lg border border-gray-700/30">
                                    <dt class="text-gray-400 font-medium">Warranty</dt>
                                    <dd class="text-white font-semibold m-0">{{ $product->warranty }}</dd>
                                </div>
                            @endif
                            @if($product->model)
                                <div class="flex justify-between items-center py-3 px-4 bg-black/20 rounded-lg border border-gray-700/30">
                                    <dt class="text-gray-400 font-medium">Model</dt>
                                    <dd class="text-white font-semibold m-0">{{ $product->model }}</dd>
                                </div>
                            @endif
                        </dl>
                    </section>
                @endif
            </div>
            </div>{{-- end left column --}}

            <!-- Product Info -->
            <div>
                <!-- Breadcrumb -->
                <nav class="text-sm mb-4" aria-label="Breadcrumb">
                    <!-- Desktop Breadcrumb -->
                    <ol class="hidden sm:flex items-center space-x-2 text-gray-400" itemscope itemtype="https://schema.org/BreadcrumbList">
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="{{ route('home') }}" class="hover:text-primary-400 transition-colors"><span itemprop="name">Home</span></a>
                            <meta itemprop="position" content="1">
                        </li>
                        <li>/</li>
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="{{ route('products.index') }}" class="hover:text-primary-400 transition-colors"><span itemprop="name">Products</span></a>
                            <meta itemprop="position" content="2">
                        </li>
                        <li>/</li>
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="{{ route('categories.show', $product->category->slug ?: $product->category->id) }}" class="hover:text-primary-400 transition-colors"><span itemprop="name">{{ $product->category->name }}</span></a>
                            <meta itemprop="position" content="3">
                        </li>
                        <li>/</li>
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="text-gray-500">
                            <span itemprop="name">{{ $product->name }}</span>
                            <meta itemprop="position" content="4">
                        </li>
                    </ol>
                    
                    <!-- Mobile Breadcrumb -->
                    <div class="sm:hidden">
                        <div class="flex items-center gap-2 mb-2">
                            <a href="{{ route('categories.show', $product->category->slug ?: $product->category->id) }}" class="inline-flex items-center gap-1 text-gray-400 hover:text-primary-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span class="text-xs font-medium">{{ $product->category->name }}</span>
                            </a>
                        </div>
                        <div class="text-xs text-gray-500 leading-relaxed">
                            {{ $product->name }}
                        </div>
                    </div>
                </nav>

                <!-- Product Title -->
                <div class="mb-4 sm:mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 mb-3">
                        <span class="text-sm text-primary-400 font-medium">{{ $product->category->name }}</span>
                        @if($product->is_on_sale)
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold px-2 sm:px-3 py-1 rounded-full animate-pulse">
                                    HOT DEAL
                                </span>
                                <span class="bg-primary-500 text-black text-xs font-bold px-2 py-1 rounded">
                                    SAVE LKR {{ number_format($product->price - $product->promo_price, 2) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white leading-tight">{{ $product->name }}</h1>
                    <p class="mt-2 text-sm text-gray-400 leading-relaxed">
                        Buy <strong class="text-gray-300">{{ $product->name }}</strong> online in Sri Lanka from MSK Computers{{ $product->category ? ' — ' . $product->category->name : '' }}.
                        @if($product->final_price > 0)
                            Current price <strong class="text-primary-400">LKR {{ number_format($product->final_price, 2) }}</strong>.
                        @endif
                        Official warranty, island-wide delivery, and expert local support.
                    </p>
                    
                    <!-- Product Code -->
                    @if($product->code)
                        <div class="mt-3">
                            <div class="inline-flex items-center px-3 py-1.5 bg-gray-800/50 border border-gray-700 rounded-lg">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                <span class="text-sm text-gray-400 mr-2">Product Code:</span>
                                <span class="text-sm font-mono text-white font-medium">{{ $product->code }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Stock Status -->
                @if($product->status && in_array($product->status->status_name, ['Coming Soon', 'Pre Order']))
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                        <span class="text-blue-400 font-medium">{{ $product->status->status_name }}</span>
                    </div>
                @elseif($product->shelfQuantity() > 0)
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                        <span class="text-green-400 font-medium">In Stock</span>
                    </div>
                @else
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                        <span class="text-red-400 font-medium">Out of Stock</span>
                    </div>
                @endif

                <!-- Price -->
                <div class="mb-4 sm:mb-6">
                    @if($product->is_on_sale)
                        <div class="bg-gradient-to-r from-primary-500/10 to-red-500/10 border border-primary-500/20 rounded-xl p-3 sm:p-4">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 mb-2">
                                <span class="text-2xl sm:text-3xl font-bold text-primary-400">LKR {{ number_format($product->promo_price, 2) }}</span>
                                <span class="text-lg sm:text-xl text-gray-400 line-through">LKR {{ number_format($product->price, 2) }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                                <span class="text-green-400 font-semibold text-xs sm:text-sm">
                                    💰 You Save: LKR {{ number_format($product->price - $product->promo_price, 2) }}
                                </span>
                                <span class="text-green-400 font-semibold text-xs sm:text-sm">
                                    ({{ round((($product->price - $product->promo_price) / $product->price) * 100) }}% OFF)
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="bg-black/50 border border-gray-800 rounded-xl p-3 sm:p-4">
                            @if($product->price > 0)
                                <span class="text-2xl sm:text-3xl font-bold text-primary-400">LKR {{ number_format($product->price, 2) }}</span>
                            @else
                                <span class="text-2xl sm:text-3xl font-bold text-primary-400">Contact for Price</span>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Payment method price cards (product detail only) -->
                @if($product->final_price > 0)
                    @include('components.product-payment-methods', ['product' => $product])
                @endif

                <!-- Product Status -->
                <div class="mb-6">
                    @if($product->status)
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-400 mb-2">Product Status:</h4>
                            @include('components.product-status-badge', ['product' => $product])
                        </div>
                    @endif

                    <!-- Add to Cart Section -->
                    @if($product->can_add_to_cart)
                        <div class="@if($product->is_on_sale) bg-gradient-to-r from-primary-500/5 to-red-500/5 border border-primary-500/20 @else bg-black/50 border border-gray-800 @endif rounded-xl p-3 sm:p-4 mb-4 sm:mb-6">
                            @if($product->is_on_sale)
                                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2 mb-3 sm:mb-4">
                                    <span class="text-red-400 font-semibold text-xs sm:text-sm animate-pulse">⚡ Limited Time Offer!</span>
                                    <span class="text-gray-400 text-xs sm:text-sm">Act fast before it's gone!</span>
                                </div>
                            @endif
                            
                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                <div class="flex items-center border border-gray-600 rounded-lg self-start sm:self-auto">
                                    <button type="button" class="px-2 sm:px-3 py-2 text-gray-300 hover:text-primary-400" onclick="decreaseQuantity()">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <input type="number" id="quantity" value="1" min="1" max="99" 
                                           class="w-12 sm:w-16 py-2 text-center bg-transparent text-white border-0 focus:outline-none text-sm sm:text-base">
                                    <button type="button" class="px-2 sm:px-3 py-2 text-gray-300 hover:text-primary-400" onclick="increaseQuantity()">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                                <button class="@if($product->is_on_sale) bg-gradient-to-r from-primary-500 to-red-500 hover:from-primary-600 hover:to-red-600 @else btn-primary @endif flex-1 text-base sm:text-lg py-3 font-semibold transition-all transform hover:scale-105" onclick="addToCart({{ $product->id }})">
                                    @if($product->is_on_sale)
                                        Add to Cart (SALE!)
                                    @else
                                        Add to Cart
                                    @endif
                                </button>
                                <button class="btn-outline px-4 sm:px-6 py-3" onclick="addToWishlist({{ $product->id }})">
                                    <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @else
                        @if($product->status && in_array($product->status->status_name, ['Coming Soon', 'Pre Order']))
                            <!-- Special Contact Button for Coming Soon and Pre Order -->
                            <div class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/30 rounded-xl p-6 text-center mb-6">
                                <div class="text-blue-400 text-xl font-semibold mb-2">{{ $product->status->status_name }}</div>
                                <p class="text-gray-400 mb-4">{{ $product->cart_restriction_reason }}</p>
                                <button onclick="showSpecialOrderContact('{{ $product->status->status_name }}', '{{ addslashes($product->name) }}')" 
                                        class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-semibold transition-all transform hover:scale-105 shadow-lg">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    Contact Us for This Product
                                </button>
                            </div>
                        @else
                            <!-- Regular Unavailable Message -->
                            <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-6 text-center mb-6">
                                <div class="text-red-400 text-xl font-semibold mb-2">{{ $product->cart_restriction_reason ?: 'Unavailable' }}</div>
                                <p class="text-gray-400">This product is currently unavailable.</p>
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Product Description -->
                @if($product->description)
                    <div class="mb-6 p-6 bg-gradient-to-br from-gray-900/50 to-black/50 rounded-xl border border-gray-800/50">
                        <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 text-primary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Description
                        </h3>
                        <p class="text-gray-300 leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
    <section class="py-12 bg-gradient-to-br from-gray-900 to-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">Related Products</h2>
                <p class="text-gray-400">You might also be interested in these products</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="bg-black/50 border border-gray-800/50 rounded-xl overflow-hidden hover:border-primary-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-primary-500/10">
                        <!-- Product Image -->
                        <div class="relative group">
                            <a href="{{ route('products.show', ['category' => $relatedProduct->category->slug ?: $relatedProduct->category->id, 'product' => $relatedProduct->slug]) }}">
                                <div class="aspect-square bg-white/5 p-4">
                                    <img src="{{ $relatedProduct->main_image ?? 'https://via.placeholder.com/400x400?text=No+Image' }}" 
                                         alt="{{ $relatedProduct->name }}" 
                                         class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                                </div>
                            </a>
                            
                            @if($relatedProduct->is_on_sale)
                                <div class="absolute top-2 right-2">
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">SALE</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-4">
                            <h3 class="text-sm sm:text-base font-semibold text-white mb-2 line-clamp-2">
                                <a href="{{ route('products.show', ['category' => $relatedProduct->category->slug ?: $relatedProduct->category->id, 'product' => $relatedProduct->slug]) }}" 
                                   class="hover:text-primary-400 transition-colors">
                                    {{ $relatedProduct->name }}
                                </a>
                            </h3>
                            
                            <!-- Price -->
                            <div class="mb-3">
                                @if($relatedProduct->is_on_sale)
                                    <div class="space-y-1">
                                        <span class="text-xs text-gray-500 line-through block">LKR {{ number_format($relatedProduct->price, 0) }}</span>
                                        <span class="text-base font-bold text-primary-400">LKR {{ number_format($relatedProduct->promo_price, 0) }}</span>
                                    </div>
                                @else
                                    @if($relatedProduct->price > 0)
                                        <span class="text-base font-bold text-white">LKR {{ number_format($relatedProduct->price, 0) }}</span>
                                    @else
                                        <span class="text-base font-bold text-primary-400">Contact for Price</span>
                                    @endif
                                @endif
                            </div>
                            
                            <!-- Stock Status -->
                            <div class="flex items-center justify-between mb-3">
                                @if($relatedProduct->status && in_array($relatedProduct->status->status_name, ['Coming Soon', 'Pre Order']))
                                    <span class="text-xs text-blue-400 flex items-center">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-1"></span>
                                        {{ $relatedProduct->status->status_name }}
                                    </span>
                                @elseif($relatedProduct->shelfQuantity() > 0)
                                    <span class="text-xs text-green-400 flex items-center">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span>
                                        In Stock
                                    </span>
                                @else
                                    <span class="text-xs text-red-400 flex items-center">
                                        <span class="w-2 h-2 bg-red-500 rounded-full mr-1"></span>
                                        Out of Stock
                                    </span>
                                @endif
                                
                                @if($relatedProduct->status && in_array($relatedProduct->status->status_name, ['Reserved', 'In Stock (for PC Build)']))
                                    <span class="text-xs text-yellow-400 bg-yellow-500/20 px-2 py-1 rounded-full">{{ $relatedProduct->status->status_name }}</span>
                                @endif
                            </div>
                            
                            <!-- Add to Cart Button -->
                            @if($relatedProduct->can_add_to_cart)
                                <button class="w-full bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors" 
                                        onclick="addToCart({{ $relatedProduct->id }})">
                                    Add to Cart
                                </button>
                            @else
                                <button class="w-full bg-gray-700 text-gray-400 text-sm font-medium py-2 px-4 rounded-lg cursor-not-allowed" 
                                        disabled title="{{ $relatedProduct->cart_restriction_reason }}">
                                    {{ $relatedProduct->cart_restriction_reason ?: 'Unavailable' }}
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
{{-- Unique SEO content for Google (product-specific, indexable copy) --}}
<section class="py-8 bg-black border-t border-gray-900" aria-labelledby="product-seo-summary-heading">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <article class="rounded-xl border border-gray-800/60 bg-[#0f0f10] p-5 sm:p-7">
            <h2 id="product-seo-summary-heading" class="text-xl sm:text-2xl font-bold text-white mb-3">
                {{ $product->name }} — Buy in Sri Lanka at MSK Computers
            </h2>
            <p class="text-sm sm:text-base text-gray-300 leading-relaxed mb-4">
                Looking for <strong>{{ $product->name }}</strong>
                @if($product->category)
                    in the <a href="{{ route('categories.show', $product->category->slug ?: $product->category->id) }}" class="text-primary-400 hover:underline">{{ $product->category->name }}</a> category
                @endif?
                Shop at <strong>MSK Computers</strong> (Ragama) for genuine products, competitive Sri Lanka pricing,
                @if($product->warranty)
                    {{ $product->warranty }} warranty,
                @endif
                secure checkout, and island-wide delivery.
                @if($product->code)
                    Product code: <span class="font-mono text-gray-200">{{ $product->code }}</span>.
                @endif
            </p>
            <ul class="grid sm:grid-cols-2 gap-2 text-sm text-gray-400">
                <li>✓ Authorized retailer in Sri Lanka</li>
                <li>✓ Cash, bank deposit, Visa/Master/Amex &amp; KOKO Pay</li>
                <li>✓ Expert advice before you buy</li>
                <li>✓ After-sales support from MSK Computers</li>
            </ul>
            <p class="mt-4 text-sm text-gray-400">
                Browse more in
                <a href="{{ route('categories.show', $product->category->slug ?: $product->category->id) }}" class="text-primary-400 hover:underline font-medium">{{ $product->category->name }}</a>
                or view
                <a href="{{ route('products.index') }}" class="text-primary-400 hover:underline font-medium">all products</a>
                at MSK Computers.
            </p>
        </article>
    </div>
</section>
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
                quantity: parseInt(quantity),
                catalog: document.documentElement.dataset.catalogSource || 'msk'
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
                // Update localStorage immediately for faster future loads
                if (data.cart_total !== undefined) {
                    localStorage.setItem('cartTotal', data.cart_total);
                }
                
                // Animate cart addition with product name and total (no count)
                const productName = document.querySelector('h1').textContent.trim();
                
                // Use cart animation (simplified, no count)
                try {
                    window.animateCartAddition(data.cart_total, productName);
                } catch (animError) {
                    console.error('Animation error:', animError);
                    // Fallback: Just show a simple success message
                    showNotification('Product added to cart successfully!', 'success');
                }
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
