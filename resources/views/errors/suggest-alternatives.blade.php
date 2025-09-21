@extends('layouts.app')

@section('title', 'Page Not Found')
@section('description', 'The requested page could not be found, but here are some suggestions.')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-[#0f0f0f] to-[#1a1a1c] py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Error Header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-red-500/10 border border-red-500/20 rounded-full text-red-400 text-sm font-medium mb-6">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                404 - Page Not Found
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white mb-6">
                Oops! <span class="bg-gradient-to-r from-red-400 to-red-600 bg-clip-text text-transparent">Page Not Found</span>
            </h1>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed mb-4">
                We couldn't find the page you're looking for: <span class="text-[#f59e0b] font-mono">{{ $path }}</span>
            </p>
            <p class="text-gray-500">
                But don't worry! We found some similar items that might interest you.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Similar Categories -->
            @if($similarCategories->count() > 0)
            <div class="bg-[#2c2c2e]/50 rounded-2xl p-6 border border-gray-800/30">
                <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#f59e0b]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                    </svg>
                    Similar Categories
                </h2>
                <div class="space-y-3">
                    @foreach($similarCategories as $category)
                    <a href="{{ route('categories.show', $category->slug ?: $category->id) }}" 
                       class="block p-3 rounded-lg bg-[#3c3c3e]/50 hover:bg-[#4c4c4e]/50 transition-colors group">
                        <div class="text-white font-medium group-hover:text-[#f59e0b] transition-colors">
                            {{ $category->name }}
                        </div>
                        @if($category->slug)
                        <div class="text-sm text-gray-500 font-mono">/{{ $category->slug }}</div>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Similar Products -->
            @if($similarProducts->count() > 0)
            <div class="bg-[#2c2c2e]/50 rounded-2xl p-6 border border-gray-800/30">
                <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#f59e0b]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7Z"/>
                    </svg>
                    Similar Products
                </h2>
                <div class="space-y-3">
                    @foreach($similarProducts as $product)
                    <a href="{{ route('products.show', ['category' => $product->category->slug ?: $product->category->id, 'product' => $product->slug]) }}" 
                       class="block p-3 rounded-lg bg-[#3c3c3e]/50 hover:bg-[#4c4c4e]/50 transition-colors group">
                        <div class="text-white font-medium group-hover:text-[#f59e0b] transition-colors">
                            {{ $product->name }}
                        </div>
                        <div class="text-sm text-gray-500">in {{ $product->category->name }}</div>
                        @if($product->price > 0)
                        <div class="text-sm text-[#f59e0b] font-semibold">LKR {{ number_format($product->price, 2) }}</div>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="text-center space-y-4">
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center px-6 py-3 bg-[#f59e0b] text-black font-semibold rounded-lg hover:bg-[#d97706] transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                    Go Home
                </a>
                <a href="{{ route('categories.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-transparent text-white border border-gray-600 font-semibold rounded-lg hover:bg-gray-800 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                    </svg>
                    Browse Categories
                </a>
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-transparent text-white border border-gray-600 font-semibold rounded-lg hover:bg-gray-800 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7Z"/>
                    </svg>
                    All Products
                </a>
            </div>
            
            <!-- Search Alternative -->
            <div class="mt-8 p-6 bg-[#2c2c2e]/30 rounded-xl border border-gray-800/20">
                <h3 class="text-lg font-semibold text-white mb-3">Can't find what you're looking for?</h3>
                <form action="{{ route('products.search') }}" method="GET" class="flex gap-3">
                    <input type="text" 
                           name="q" 
                           placeholder="Search for products..." 
                           value="{{ $requestedProduct ? str_replace('-', ' ', $requestedProduct) : '' }}"
                           class="flex-1 px-4 py-3 bg-[#3c3c3e] border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-[#f59e0b]">
                    <button type="submit" 
                            class="px-6 py-3 bg-[#f59e0b] text-black font-semibold rounded-lg hover:bg-[#d97706] transition-colors">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
