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

                <!-- KOKO Pay 3-Split Breakdown -->
                @if($product->final_price > 0)
                    @php
                        $finalPrice = $product->final_price;
                        $kokoPayTotal = $finalPrice * 1.10; // Add 10% transaction charge
                        $splitAmount = ceil($kokoPayTotal / 3); // Round up to avoid decimals
                        $lastSplitAmount = $kokoPayTotal - ($splitAmount * 2); // Adjust last payment for exact total
                    @endphp
                    <div class="mb-6">
                        <div class="bg-gradient-to-r from-purple-500/10 to-pink-500/10 border border-purple-500/20 rounded-xl p-4">
                            <div class="flex items-center gap-2 mb-3">
                                <img src="{{ asset('images/kokopay-logo.png') }}" alt="KOKO Pay" class="w-6 h-6 object-contain">
                                <h3 class="text-base sm:text-lg font-semibold text-white">KOKO Pay - Split into 3 Payments</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-3">
                                <div class="bg-black/30 border border-purple-500/30 rounded-lg p-3 text-center">
                                    <div class="text-purple-300 text-xs font-medium mb-1">1st Payment (Today)</div>
                                    <div class="text-white font-bold text-base sm:text-lg">LKR {{ number_format($splitAmount, 2) }}</div>
                                </div>
                                <div class="bg-black/30 border border-purple-500/30 rounded-lg p-3 text-center">
                                    <div class="text-purple-300 text-xs font-medium mb-1">2nd Payment (30 days)</div>
                                    <div class="text-white font-bold text-base sm:text-lg">LKR {{ number_format($splitAmount, 2) }}</div>
                                </div>
                                <div class="bg-black/30 border border-purple-500/30 rounded-lg p-3 text-center">
                                    <div class="text-purple-300 text-xs font-medium mb-1">3rd Payment (60 days)</div>
                                    <div class="text-white font-bold text-base sm:text-lg">LKR {{ number_format($lastSplitAmount, 2) }}</div>
                                </div>
                            </div>
                            
                            <div class="flex justify-center">
                                <div class="text-purple-300 font-medium">
                                    ✨ No credit check required
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


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
                        <div class="flex items-center gap-2 mb-6">
                            <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                            <span class="text-green-400 font-medium">In Stock</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 mb-6">
                            <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                            <span class="text-red-400 font-medium">Out of Stock</span>
                        </div>
                    @endif

                    <!-- Add to Cart Section -->
                    @if($product->can_add_to_cart)
                        <div class="@if($product->is_on_sale) bg-gradient-to-r from-primary-500/5 to-red-500/5 border border-primary-500/20 @else bg-black/50 border border-gray-800 @endif rounded-xl p-4 mb-6">
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
                        <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-6 text-center mb-6">
                            <div class="text-red-400 text-xl font-semibold mb-2">{{ $product->cart_restriction_reason ?: 'Unavailable' }}</div>
                            @if($product->status && in_array($product->status->status_name, ['Coming Soon', 'Pre Order', 'In Stock (for PC Build)', 'Reserved']))
                                <p class="text-gray-400">{{ $product->cart_restriction_reason }}</p>
                            @else
                                <p class="text-gray-400">This product is currently unavailable.</p>
                            @endif
                        </div>
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


                <!-- Product Attributes (Compact) -->
                @if($product->grouped_attributes && count($product->grouped_attributes) > 0)
                    <div class="mb-4 p-4 bg-gradient-to-br from-gray-900/50 to-black/50 rounded-lg border border-gray-800/50">
                        <h3 class="text-lg font-semibold text-white mb-3 flex items-center">
                            <svg class="w-4 h-4 text-primary-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Product Attributes
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($product->grouped_attributes as $attributeName => $attributeValues)
                                <div class="bg-black/20 rounded-md p-3 border border-gray-700/30 hover:border-primary-500/20 transition-colors">
                                    <span class="text-xs font-semibold text-primary-400 mb-2 block uppercase tracking-wider">{{ $attributeName }}</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($attributeValues as $value)
                                            <span class="inline-block bg-gray-800/50 text-gray-300 text-xs font-medium px-2 py-1 rounded border border-gray-700/30 hover:bg-gray-700/50 transition-colors">
                                                {{ $value }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Product Details & Specifications -->
                @if($product->product_details && trim(strip_tags($product->product_details)))
                    @php
                        // Clean and format HTML content for display
                        $htmlContent = $product->product_details;
                        
                        // Convert HTML to readable text while preserving structure
                        $htmlContent = str_replace(['<p>', '<div>'], '', $htmlContent);
                        $htmlContent = str_replace(['</p>', '</div>'], "\n", $htmlContent);
                        $htmlContent = str_replace('<br>', "\n", $htmlContent);
                        $htmlContent = str_replace('<br/>', "\n", $htmlContent);
                        $htmlContent = str_replace('<br />', "\n", $htmlContent);
                        
                        // Handle lists
                        $htmlContent = str_replace('<ul>', "\n", $htmlContent);
                        $htmlContent = str_replace('</ul>', "\n", $htmlContent);
                        $htmlContent = str_replace('<li>', "• ", $htmlContent);
                        $htmlContent = str_replace('</li>', "\n", $htmlContent);
                        
                        // Remove remaining HTML tags
                        $cleanContent = strip_tags($htmlContent);
                        
                        // Clean up whitespace and decode entities
                        $cleanContent = html_entity_decode($cleanContent);
                        $cleanContent = preg_replace('/\n\s*\n/', "\n\n", $cleanContent); // Multiple newlines to double
                        $cleanContent = preg_replace('/\n{3,}/', "\n\n", $cleanContent); // More than 2 newlines to 2
                        $cleanContent = trim($cleanContent);
                        
                        // Split into lines for better formatting
                        $lines = explode("\n", $cleanContent);
                        $lines = array_filter(array_map('trim', $lines)); // Remove empty lines and trim
                    @endphp
                    
                    <div class="mb-6 p-6 bg-gradient-to-br from-gray-900/50 to-black/50 rounded-xl border border-gray-800/50">
                        <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 text-primary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            Product Details & Specifications
                        </h3>
                        
                        <div class="space-y-4">
                            @foreach($lines as $line)
                                @if(!empty($line))
                                    @if(preg_match('/^\d+\.\s/', $line) || str_starts_with($line, '•'))
                                        <!-- List items -->
                                        <div class="flex items-start py-2 px-4 bg-black/20 rounded-lg border border-gray-700/30 hover:border-primary-500/30 transition-colors">
                                            <div class="text-gray-300 leading-relaxed">{{ $line }}</div>
                                        </div>
                                    @elseif(strpos($line, ':') !== false && strlen($line) < 100)
                                        <!-- Key-value pairs (short lines with colons) -->
                                        @php
                                            $parts = explode(':', $line, 2);
                                            $key = trim($parts[0]);
                                            $value = isset($parts[1]) ? trim($parts[1]) : '';
                                        @endphp
                                        @if(!empty($value))
                                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 px-4 bg-black/20 rounded-lg border border-gray-700/30 hover:border-primary-500/30 transition-colors">
                                                <span class="text-gray-400 font-medium mb-1 sm:mb-0">{{ $key }}:</span>
                                                <span class="text-white font-semibold sm:text-right">{{ $value }}</span>
                                            </div>
                                        @else
                                            <!-- Header or section title -->
                                            <div class="py-2 px-4 bg-primary-500/10 rounded-lg border border-primary-500/30">
                                                <div class="text-primary-400 font-bold text-center">{{ $key }}</div>
                                            </div>
                                        @endif
                                    @elseif(preg_match('/^[A-Z\s]+$/', $line) && strlen($line) < 50)
                                        <!-- All caps headers -->
                                        <div class="py-2 px-4 bg-primary-500/10 rounded-lg border border-primary-500/30">
                                            <div class="text-primary-400 font-bold text-center">{{ $line }}</div>
                                        </div>
                                    @else
                                        <!-- Regular text -->
                                        <div class="py-3 px-4 bg-black/10 rounded-lg border border-gray-700/20">
                                            <div class="text-gray-300 leading-relaxed">{{ $line }}</div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        
                        <!-- Basic Product Info (Only Warranty and Model) -->
                        @if($product->warranty || $product->model)
                            <div class="mt-6 pt-4 border-t border-gray-700/50">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @if($product->warranty)
                                        <div class="flex justify-between items-center py-3 px-4 bg-black/20 rounded-lg border border-gray-700/30">
                                            <span class="text-gray-400 font-medium">Warranty:</span>
                                            <span class="text-white font-semibold">{{ $product->warranty }}</span>
                                        </div>
                                    @endif
                                    @if($product->model)
                                        <div class="flex justify-between items-center py-3 px-4 bg-black/20 rounded-lg border border-gray-700/30">
                                            <span class="text-gray-400 font-medium">Model:</span>
                                            <span class="text-white font-semibold">{{ $product->model }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <!-- Fallback when no product details are available -->
                    <div class="mb-6 p-6 bg-gradient-to-br from-gray-900/50 to-black/50 rounded-xl border border-gray-800/50">
                        <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 text-primary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Product Information
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @if($product->warranty)
                                <div class="flex justify-between items-center py-3 px-4 bg-black/20 rounded-lg border border-gray-700/30">
                                    <span class="text-gray-400 font-medium">Warranty:</span>
                                    <span class="text-white font-semibold">{{ $product->warranty }}</span>
                                </div>
                            @endif
                            @if($product->model)
                                <div class="flex justify-between items-center py-3 px-4 bg-black/20 rounded-lg border border-gray-700/30">
                                    <span class="text-gray-400 font-medium">Model:</span>
                                    <span class="text-white font-semibold">{{ $product->model }}</span>
                                </div>
                            @endif
                        </div>
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
                                @if($relatedProduct->stock_quantity > 0)
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
                                
                                @if($relatedProduct->status && in_array($relatedProduct->status->status_name, ['Coming Soon', 'Pre Order']))
                                    <span class="text-xs text-blue-400 bg-blue-500/20 px-2 py-1 rounded-full">{{ $relatedProduct->status->status_name }}</span>
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
</script>
@endpush
