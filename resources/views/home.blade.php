@extends('layouts.app')

@section('title', 'MSK COMPUTERS - Your Trusted Computer Store in Sri Lanka')
@section('description', 'MSK Computers - Your trusted partner for computer hardware, gaming PCs, laptops, and technology solutions in Sri Lanka. Quality products, competitive prices, and expert service.')
@section('keywords', 'MSK Computers, computer store Sri Lanka, gaming PC, laptops, computer hardware, graphics cards, processors, motherboards, technology solutions')
@section('og_title', 'MSK COMPUTERS - Your Trusted Computer Store in Sri Lanka')
@section('og_description', 'Discover premium computer hardware, gaming PCs, and technology solutions at MSK Computers. Quality products with warranty and expert service in Sri Lanka.')
@section('og_type', 'website')

@section('content')
<!-- Enhanced Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-[#0a0a0a] via-[#0f0f0f] to-[#1a1a1c] hero-section">
    <!-- Background Animation -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute w-96 h-96 rounded-full bg-gradient-to-r from-[#f59e0b]/20 to-[#d97706]/20 blur-3xl -top-48 -left-48 animate-pulse"></div>
        <div class="absolute w-96 h-96 rounded-full bg-gradient-to-r from-[#3b82f6]/20 to-[#1d4ed8]/20 blur-3xl -bottom-48 -right-48 animate-pulse" style="animation-delay: 2s;"></div>
    </div>
    
    <div class="hero-slider relative z-10" id="heroSlider">
        <!-- Hero Video -->
        <div class="hero-slide active relative h-[500px] md:h-[600px] lg:h-[700px] flex items-center">
            <div class="absolute inset-0 bg-gradient-to-r from-[#0f0f0f] via-[#0f0f0f]/95 to-transparent z-10"></div>
            <div class="absolute inset-0">
                <video 
                    autoplay 
                    muted 
                    playsinline
                    class="w-full h-full object-cover"
                    id="heroVideo">
                    <source src="{{ asset('videos/slider/mskcomputers-video-promo.webm') }}" type="video/webm">
                    <!-- Fallback image if video fails to load -->
                    <img src="https://images.unsplash.com/photo-1547082299-de196ea013d6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                         alt="Gaming PC Setup" 
                         class="w-full h-full object-cover">
                </video>
            </div>
            <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl">
                    <!-- Badge -->
                    <div class="inline-flex items-center px-4 py-2 bg-[#f59e0b]/10 border border-[#f59e0b]/20 rounded-full text-[#f59e0b] text-sm font-medium mb-6 animate-fade-in-up">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        Sri Lanka's Trusted Computer Specialist
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-8xl font-black text-white mb-4 md:mb-6 animate-fade-in-up leading-tight">
                        <span class="bg-gradient-to-r from-[#f59e0b] via-[#fbbf24] to-[#f59e0b] bg-clip-text text-transparent">
                            MSK
                        </span>
                        <br>Computers
                    </h1>
                    
                    <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-gray-300 mb-6 md:mb-8 animate-fade-in-up leading-relaxed" style="animation-delay: 0.2s;">
                        Experience the latest in computing technology with MSK Computers - 
                        <span class="text-[#f59e0b] font-semibold">Sri Lanka's trusted computer specialist.</span>
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-3 md:gap-4 animate-fade-in-up" style="animation-delay: 0.4s;">
                        <a href="{{ route('products.index') }}" 
                           class="group inline-flex items-center justify-center px-6 md:px-8 py-3 md:py-4 bg-gradient-to-r from-[#f59e0b] to-[#d97706] text-black font-bold text-base md:text-lg rounded-xl hover:shadow-2xl hover:shadow-[#f59e0b]/25 transform hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 group-hover:rotate-12 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            Explore Gaming PCs
                        </a>
                        <a href="{{ route('promotions.index') }}" 
                           class="group inline-flex items-center justify-center px-6 md:px-8 py-3 md:py-4 bg-transparent border-2 border-[#f59e0b] text-[#f59e0b] font-bold text-base md:text-lg rounded-xl hover:bg-[#f59e0b] hover:text-black transition-all duration-300">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            View Deals
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 md:gap-8 mt-8 md:mt-12 animate-fade-in-up" style="animation-delay: 0.6s;">
                        <div class="text-center">
                            <div class="text-xl md:text-3xl font-bold text-white mb-1">3000+</div>
                            <div class="text-xs md:text-sm text-gray-400">Products</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl md:text-3xl font-bold text-white mb-1">10,000+</div>
                            <div class="text-xs md:text-sm text-gray-400">Happy Customers</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl md:text-3xl font-bold text-white mb-1">Expert</div>
                            <div class="text-xs md:text-sm text-gray-400">Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>

<!-- Features Section -->
<section class="py-8 md:py-16 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-6 md:mb-12">
            <h2 class="text-xl sm:text-2xl md:text-4xl font-bold text-white mb-2 md:mb-4">Why Choose MSK COMPUTERS?</h2>
            <p class="text-sm sm:text-base md:text-xl text-gray-300 max-w-3xl mx-auto">Professional expertise, quality products, and exceptional service for all your computing needs.</p>
        </div>
        
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
            <!-- Gaming PCs -->
            <div class="card card-hover p-3 md:p-6 text-center group">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-[#f59e0b] to-[#d97706] rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21,16V4H3V16H21M21,2A2,2 0 0,1 23,4V16A2,2 0 0,1 21,18H14L16,21V22H8V21L10,18H3A2,2 0 0,1 1,16V4A2,2 0 0,1 3,2H21Z"/>
                    </svg>
                </div>
                <h3 class="text-sm sm:text-base md:text-xl font-semibold text-white mb-1 md:mb-2">Gaming PCs</h3>
                <p class="text-xs sm:text-sm md:text-base text-gray-400">High-performance gaming rigs</p>
            </div>

            <!-- Laptops -->
            <div class="card card-hover p-3 md:p-6 text-center group">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-[#3b82f6] to-[#1d4ed8] rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4,6H20V16H4M20,18A2,2 0 0,0 22,16V6C22,4.89 21.1,4 20,4H4C2.89,4 2,4.89 2,6V16A2,2 0 0,0 4,18H1V20H23V18H20Z"/>
                    </svg>
                </div>
                <h3 class="text-sm sm:text-base md:text-xl font-semibold text-white mb-1 md:mb-2">Laptops</h3>
                <p class="text-xs sm:text-sm md:text-base text-gray-400">Gaming & Professional laptops</p>
            </div>

            <!-- Components -->
            <div class="card card-hover p-3 md:p-6 text-center group">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-[#10b981] to-[#059669] rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17,17H7V7H17M21,11V9H19V7C19,5.89 18.1,5 17,5H15V3H13V5H11V3H9V5H7C5.89,5 5,5.89 5,7V9H3V11H5V13H3V15H5V17C5,18.1 5.89,19 7,19H9V21H11V19H13V21H15V19H17C18.1,19 19,18.1 19,17V15H21V13H19V11M15,15H9V9H15V15Z"/>
                    </svg>
                </div>
                <h3 class="text-sm sm:text-base md:text-xl font-semibold text-white mb-1 md:mb-2">Components</h3>
                <p class="text-xs sm:text-sm md:text-base text-gray-400">Latest PC parts & upgrades</p>
            </div>

            <!-- Repair Services -->
            <div class="card card-hover p-3 md:p-6 text-center group">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-[#8b5cf6] to-[#7c3aed] rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22.7,19L13.6,9.9C14.5,7.6 14,4.9 12.1,3C10.1,1 7.1,0.6 4.7,1.7L9,6L6,9L1.6,4.7C0.4,7.1 0.9,10.1 2.9,12.1C4.8,14 7.5,14.5 9.8,13.6L18.9,22.7C19.3,23.1 19.9,23.1 20.3,22.7L22.6,20.4C23.1,20 23.1,19.3 22.7,19Z"/>
                    </svg>
                </div>
                <h3 class="text-sm sm:text-base md:text-xl font-semibold text-white mb-1 md:mb-2">Repair</h3>
                <p class="text-xs sm:text-sm md:text-base text-gray-400">Expert repair services</p>
            </div>
        </div>
        
        <!-- Additional Features Row -->
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8 mt-6 md:mt-8">
            <!-- Best Warranty -->
            <div class="card card-hover p-3 md:p-6 text-center group">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-[#f59e0b] to-[#d97706] rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M12,7C13.4,7 14.8,8.6 14.8,10V11.5C15.4,11.5 16,12.1 16,12.7V16.7C16,17.4 15.4,18 14.8,18H9.2C8.6,18 8,17.4 8,16.8V12.8C8,12.1 8.6,11.5 9.2,11.5V10C9.2,8.6 10.6,7 12,7M12,8.2C11.2,8.2 10.5,8.7 10.5,10V11.5H13.5V10C13.5,8.7 12.8,8.2 12,8.2Z"/>
                    </svg>
                </div>
                <h3 class="text-sm sm:text-base md:text-xl font-semibold text-white mb-1 md:mb-2">Best Warranty Provider</h3>
                <p class="text-xs sm:text-sm md:text-base text-gray-400">On all products</p>
            </div>

            <!-- Island-wide Delivery -->
            <div class="card card-hover p-3 md:p-6 text-center group">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-[#10b981] to-[#059669] rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3,4A2,2 0 0,0 1,6V17H3A3,3 0 0,0 6,20A3,3 0 0,0 9,17H15A3,3 0 0,0 18,20A3,3 0 0,0 21,17H23V12L20,8H17V4M10,6L14,10L10,14V11H4V9H10M17,9.5H19.5L21.46,12H17M6,15.5A1.5,1.5 0 0,1 7.5,17A1.5,1.5 0 0,1 6,18.5A1.5,1.5 0 0,1 4.5,17A1.5,1.5 0 0,1 6,15.5M18,15.5A1.5,1.5 0 0,1 19.5,17A1.5,1.5 0 0,1 18,18.5A1.5,1.5 0 0,1 16.5,17A1.5,1.5 0 0,1 18,15.5Z"/>
                    </svg>
                </div>
                <h3 class="text-sm sm:text-base md:text-xl font-semibold text-white mb-1 md:mb-2">Island-wide Delivery</h3>
                <p class="text-xs sm:text-sm md:text-base text-gray-400">Islandwide delivery available</p>
            </div>

            <!-- Expert Service -->
            <div class="card card-hover p-3 md:p-6 text-center group">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-[#3b82f6] to-[#1d4ed8] rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12,2A2,2 0 0,1 14,4C14,4.74 13.6,5.39 13,5.73V7H14A7,7 0 0,1 21,14H22A1,1 0 0,1 23,15V18A1,1 0 0,1 22,19H21V20A2,2 0 0,1 19,22H5A2,2 0 0,1 3,20V19H2A1,1 0 0,1 1,18V15A1,1 0 0,1 2,14H3A7,7 0 0,1 10,7H11V5.73C10.4,5.39 10,4.74 10,4A2,2 0 0,1 12,2M7.5,13A2.5,2.5 0 0,0 5,15.5A2.5,2.5 0 0,0 7.5,18A2.5,2.5 0 0,0 10,15.5A2.5,2.5 0 0,0 7.5,13M16.5,13A2.5,2.5 0 0,0 14,15.5A2.5,2.5 0 0,0 16.5,18A2.5,2.5 0 0,0 19,15.5A2.5,2.5 0 0,0 16.5,13Z"/>
                    </svg>
                </div>
                <h3 class="text-sm sm:text-base md:text-xl font-semibold text-white mb-1 md:mb-2">Expert Service</h3>
                <p class="text-xs sm:text-sm md:text-base text-gray-400">3000+ products available</p>
            </div>

            <!-- Trusted Customers -->
            <div class="card card-hover p-3 md:p-6 text-center group">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-[#8b5cf6] to-[#7c3aed] rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16,4C18.11,4 20.11,4.89 21.39,6.39L22.5,5.5C20.86,3.85 18.64,3 16.39,3C14.14,3 11.92,3.85 10.28,5.5L11.39,6.39C12.67,4.89 14.67,4 16.89,4H16M16,7C17.38,7 18.63,7.56 19.54,8.46L20.5,7.5C19.33,6.33 17.72,5.7 16,5.7C14.28,5.7 12.67,6.33 11.5,7.5L12.46,8.46C13.37,7.56 14.62,7 16,7M16,10C16.69,10 17.32,10.28 17.78,10.78L16,12.5L14.22,10.78C14.68,10.28 15.31,10 16,10M7,4A3,3 0 0,1 10,7A3,3 0 0,1 7,10A3,3 0 0,1 4,7A3,3 0 0,1 7,4M7,11C8.11,11 9.17,11.25 10.12,11.68L9.5,12.5L8.5,11.5C8,11.34 7.5,11.25 7,11.25C5.5,11.25 4.1,11.95 3.21,13.15L2.25,12.19C3.46,10.65 5.16,10 7,10.75V11M1,17V20H4V17M6,17V20H9V17M11,17V20H14V17"/>
                    </svg>
                </div>
                <h3 class="text-sm sm:text-base md:text-xl font-semibold text-white mb-1 md:mb-2">10,000+ Customers</h3>
                <p class="text-xs sm:text-sm md:text-base text-gray-400">Trusted by thousands</p>
            </div>
        </div>
    </div>
</section>

<!-- Professional Featured Products Section -->
<section class="py-12 md:py-16 bg-gradient-to-b from-black to-[#0f0f0f] relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Clean Section Header -->
        <div class="text-center mb-8 md:mb-12">
            <div class="inline-flex items-center px-3 md:px-4 py-2 bg-[#f59e0b]/10 border border-[#f59e0b]/20 rounded-lg text-[#f59e0b] text-xs md:text-sm font-medium mb-4 md:mb-6">
                <svg class="w-3 h-3 md:w-4 md:h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                Featured Selection
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-3 md:mb-4">
                Featured Products
            </h2>
            <p class="text-base md:text-lg text-gray-400 max-w-3xl mx-auto">
                Discover our handpicked selection of premium computer hardware and technology products
            </p>
        </div>

        @if($featuredProducts->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                    <div class="group bg-[#1a1a1c] rounded-xl border border-gray-800/30 overflow-hidden hover:border-[#f59e0b]/30 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <div class="relative overflow-hidden">
                            <a href="{{ route('products.show', ['category' => $product->category->slug ?: $product->category->id, 'product' => $product->slug]) }}">
                                <div class="aspect-square bg-white/5 overflow-hidden">
                                    <img src="{{ $product->main_image }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300 p-4">
                                </div>
                            </a>
                            
                            <!-- Clean Sale Badge -->
                            @if($product->is_on_sale)
                                <div class="absolute top-4 left-4 z-10">
                                    <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-md">
                                        SALE
                                    </span>
                                </div>
                            @endif

                            <!-- Stock Status -->
                            <div class="absolute top-4 right-4 z-10">
                                @if($product->stock_quantity > 0)
                                    <span class="bg-green-500 text-white text-xs font-medium px-2 py-1 rounded-md">
                                        In Stock
                                    </span>
                                @else
                                    <span class="bg-red-500 text-white text-xs font-medium px-2 py-1 rounded-md">
                                        Out of Stock
                                    </span>
                                @endif
                            </div>

                            <!-- Enhanced Quick View Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center">
                                <div class="transform translate-y-8 group-hover:translate-y-0 transition-all duration-500 space-y-3">
                                    <a href="{{ route('products.show', ['category' => $product->category->slug ?: $product->category->id, 'product' => $product->slug]) }}" 
                                       class="block bg-gradient-to-r from-[#f59e0b] to-[#fbbf24] text-black px-6 py-3 rounded-xl font-bold text-sm shadow-xl hover:shadow-2xl transition-all duration-300 text-center">
                                        VIEW DETAILS
                                    </a>
                                    @if($product->stock_quantity > 0)
                                        <button onclick="addToCartFromHome({{ $product->id }}, '{{ addslashes($product->name) }}')" 
                                                class="block w-full bg-white/10 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold text-sm border border-white/20 hover:bg-white/20 transition-all duration-300">
                                            QUICK ADD
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-6">
                            <div class="mb-2">
                                <span class="text-xs text-[#f59e0b] font-medium">{{ $product->category->name }}</span>
                            </div>
                            
                            <h3 class="text-lg font-semibold text-white mb-3 leading-tight">
                                <a href="{{ route('products.show', ['category' => $product->category->slug ?: $product->category->id, 'product' => $product->slug]) }}" class="hover:text-[#f59e0b] transition-colors">
                                    {{ Str::limit($product->name, 60) }}
                                </a>
                            </h3>
                            
                            <!-- Pricing -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex flex-col">
                                    @if($product->is_on_sale)
                                        <span class="text-sm text-gray-500 line-through">LKR {{ number_format($product->price, 2) }}</span>
                                        <span class="text-xl font-bold text-[#f59e0b]">LKR {{ number_format($product->promo_price, 2) }}</span>
                                    @else
                                        @if($product->price > 0)
                                            <span class="text-xl font-bold text-white">LKR {{ number_format($product->price, 2) }}</span>
                                        @else
                                            <span class="text-lg font-bold text-[#f59e0b]">Contact for Price</span>
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
                            
                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                @if($product->can_add_to_cart)
                                    <button onclick="addToCartFromHome({{ $product->id }}, '{{ addslashes($product->name) }}')" 
                                            class="flex-1 bg-[#f59e0b] hover:bg-[#d97706] text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-all">
                                        Add to Cart
                                    </button>
                                @else
                                    <button class="flex-1 bg-gray-600 text-gray-400 px-4 py-2.5 rounded-lg text-sm font-medium cursor-not-allowed" 
                                            disabled title="{{ $product->cart_restriction_reason }}">
                                        {{ $product->cart_restriction_reason ?: 'Unavailable' }}
                                    </button>
                                @endif
                                <button class="px-3 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <h3 class="text-sm sm:text-base md:text-xl font-semibold text-white mb-1 md:mb-2">No Featured Products</h3>
                <p class="text-gray-400 mb-6">Check back soon for featured products!</p>
                <a href="{{ route('products.index') }}" class="btn-primary">Browse All Products</a>
            </div>
        @endif

        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}" class="btn-outline text-lg px-8 py-4">View All Products</a>
        </div>
    </div>
</section>

<!-- Happy Customer Photos Section -->
<section class="py-16 bg-gradient-to-b from-[#0f0f0f] to-black relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute w-64 h-64 rounded-full bg-[#f59e0b] blur-3xl -top-32 -left-32"></div>
        <div class="absolute w-64 h-64 rounded-full bg-[#3b82f6] blur-3xl -bottom-32 -right-32"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center px-4 py-2 bg-[#f59e0b]/10 border border-[#f59e0b]/20 rounded-lg text-[#f59e0b] text-sm font-medium mb-6">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 7V9C15 10.1 15.9 11 17 11S19 10.1 19 11V9H21ZM17 13C15.9 13 15 12.1 15 11V9L12 9L9 9V11C9 12.1 8.1 13 7 13S5 12.1 5 11V9H3V11C3 12.1 3.9 13 5 13S7 12.1 7 13V21H9V13C9 12.1 9.9 11 11 11S13 12.1 13 11V21H15V13C15 12.1 15.9 11 17 11S19 12.1 19 11V9H21V11C21 12.1 20.1 13 19 13S17 12.1 17 13Z"/>
                </svg>
                Our Happy Customers
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Customer Experiences
            </h2>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                Join thousands of satisfied customers who trust MSK Computers for their technology needs
            </p>
        </div>

        <!-- Dual Customer Photo Sliders -->
        <div class="relative">
            <!-- Top Row Slider -->
            <div class="customer-slider-container mb-8" id="customerSlider1">
                <div class="flex animate-scroll-right">
                    <!-- Customer Photo Set 1 -->
                    <div class="flex space-x-6 min-w-full">
                        <!-- Happy Customer 1 -->
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (1).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        
                        <!-- Happy Customer 2 -->
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (2).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        
                        <!-- Happy Customer 3 -->
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (3).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        
                        <!-- Happy Customer 4 -->
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (4).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        
                        <!-- Happy Customer 5 -->
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (5).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        
                        <!-- Happy Customer 6 -->
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (6).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                    </div>
                    
                    <!-- Duplicate for seamless loop -->
                    <div class="flex space-x-6 min-w-full">
                        <!-- Repeat the same customers for seamless scrolling -->
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (1).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (2).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (3).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (4).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (5).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (6).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Row Slider (Opposite Direction) -->
            <div class="customer-slider-container" id="customerSlider2">
                <div class="flex animate-scroll-left">
                    <!-- Customer Photo Set 2 -->
                    <div class="flex space-x-6 min-w-full">
                        <!-- Happy Customer 7 -->
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (7).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        
                        <!-- Happy Customer 8 -->
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (8).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        
                        <!-- Happy Customer 9 -->
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (9).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        
                        <!-- Happy Customer 10 -->
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (10).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        
                        <!-- Happy Customer 11 -->
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (11).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        
                        <!-- Happy Customer 12 -->
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (12).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                    </div>
                    
                    <!-- Duplicate for seamless loop -->
                    <div class="flex space-x-6 min-w-full">
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (7).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (8).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (9).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (10).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (11).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="customer-photo-card flex-shrink-0 w-48 h-48 rounded-2xl overflow-hidden border-2 border-gray-800 hover:border-[#f59e0b] transition-all duration-300 group">
                            <img src="{{ asset('images/happy-customers/hc00 (12).jpg') }}" 
                                 alt="Happy MSK Customer" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


@endsection

@push('scripts')
<script>
    // Add to Cart from Homepage Function
    function addToCartFromHome(productId, productName) {
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
            if (data.success) {
                // Update cart count
                if (window.updateCartCount && data.cart_count !== undefined) {
                    window.updateCartCount(data.cart_count, data.cart_total);
                }
                
                // Show success notification
                if (window.showCartSuccessNotification) {
                    window.showCartSuccessNotification('Product added to cart successfully!');
                }
                
                // Animate cart addition
                if (window.animateCartAddition) {
                    window.animateCartAddition(data.cart_count, data.cart_total);
                }
            } else {
                alert(data.message || 'Failed to add product to cart');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong. Please try again.');
        });
    }

    // Hero Slider Functionality
    class HeroSlider {
        constructor() {
            this.currentSlide = 0;
            this.slides = document.querySelectorAll('.hero-slide');
            this.dots = document.querySelectorAll('.slider-dot');
            this.totalSlides = this.slides.length;
            this.autoPlayInterval = null;
            
            this.init();
        }
        
        init() {
            // Add event listeners
            document.getElementById('prevSlide').addEventListener('click', () => this.prevSlide());
            document.getElementById('nextSlide').addEventListener('click', () => this.nextSlide());
            
            // Add dot listeners
            this.dots.forEach((dot, index) => {
                dot.addEventListener('click', () => this.goToSlide(index));
            });
            
            // Start auto-play
            this.startAutoPlay();
            
            // Pause auto-play on hover
            const heroSlider = document.getElementById('heroSlider');
            heroSlider.addEventListener('mouseenter', () => this.stopAutoPlay());
            heroSlider.addEventListener('mouseleave', () => this.startAutoPlay());
        }
        
        goToSlide(slideIndex) {
            // Stop current auto-play
            this.stopAutoPlay();
            
            // Remove active class from current slide
            this.slides[this.currentSlide].classList.remove('active');
            this.dots[this.currentSlide].classList.remove('active');
            this.dots[this.currentSlide].classList.add('bg-gray-500');
            this.dots[this.currentSlide].classList.remove('bg-primary-500');
            
            // Handle video playback
            const heroVideo = document.getElementById('heroVideo');
            if (heroVideo) {
                if (this.currentSlide === 0) {
                    // Leaving video slide - pause and reset
                    heroVideo.pause();
                    heroVideo.currentTime = 0;
                }
                if (slideIndex === 0) {
                    // Going to video slide - play from start
                    heroVideo.currentTime = 0;
                    heroVideo.play().catch(e => console.log('Video autoplay prevented:', e));
                }
            }
            
            // Update current slide
            this.currentSlide = slideIndex;
            
            // Add active class to new slide
            this.slides[this.currentSlide].classList.add('active');
            this.dots[this.currentSlide].classList.add('active');
            this.dots[this.currentSlide].classList.remove('bg-gray-500');
            this.dots[this.currentSlide].classList.add('bg-primary-500');
            
            // Restart auto-play for new slide
            this.startAutoPlay();
        }
        
        nextSlide() {
            const nextIndex = (this.currentSlide + 1) % this.totalSlides;
            this.goToSlide(nextIndex);
        }
        
        prevSlide() {
            const prevIndex = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
            this.goToSlide(prevIndex);
        }
        
        startAutoPlay() {
            // Handle video slide differently
            const heroVideo = document.getElementById('heroVideo');
            if (heroVideo && this.currentSlide === 0) {
                // For video slide, wait for video to end or use longer duration
                heroVideo.addEventListener('ended', () => {
                    this.nextSlide();
                }, { once: true });
                
                // Fallback timer in case video doesn't fire ended event
                this.autoPlayInterval = setTimeout(() => {
                    this.nextSlide();
                }, 15000); // 15 seconds for video slide
            } else {
                // For other slides, use normal timing
                this.autoPlayInterval = setInterval(() => {
                    this.nextSlide();
                }, 5000); // Change slide every 5 seconds
            }
        }
        
        stopAutoPlay() {
            if (this.autoPlayInterval) {
                clearInterval(this.autoPlayInterval);
                clearTimeout(this.autoPlayInterval);
                this.autoPlayInterval = null;
            }
        }
    }
    
    // Initialize slider when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        new HeroSlider();
    });
</script>

<style>
    .hero-slide {
        display: none;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }
    
    .hero-slide.active {
        display: flex;
        opacity: 1;
    }
    
    .animate-fade-in-up {
        animation: slideUp 0.6s ease-out forwards;
        opacity: 0;
        transform: translateY(50px);
    }
    
    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Customer Photo Slider Animations */
    .customer-slider-container {
        overflow: hidden;
        width: 100%;
        mask: linear-gradient(90deg, transparent, white 10%, white 90%, transparent);
        -webkit-mask: linear-gradient(90deg, transparent, white 10%, white 90%, transparent);
    }
    
    .animate-scroll-right {
        animation: scrollRight 40s linear infinite;
        width: 200%;
    }
    
    .animate-scroll-left {
        animation: scrollLeft 40s linear infinite;
        width: 200%;
    }
    
    @keyframes scrollRight {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%);
        }
    }
    
    @keyframes scrollLeft {
        0% {
            transform: translateX(-50%);
        }
        100% {
            transform: translateX(0);
        }
    }
    
    .customer-photo-card {
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }
    
    .customer-photo-card:hover {
        transform: translateY(-8px) scale(1.05);
        box-shadow: 0 20px 40px rgba(245, 158, 11, 0.3);
    }
    
    /* Pause animation on hover */
    .customer-slider-container:hover .animate-scroll-right,
    .customer-slider-container:hover .animate-scroll-left {
        animation-play-state: paused;
    }
</style>
@endpush
