<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <title>@yield('title', 'MSK COMPUTERS - Professional Computer Solutions')</title>
    <meta name="description" content="@yield('description', 'MSK Computers - Your trusted partner for computer hardware, gaming PCs, laptops, and technology solutions in Sri Lanka. Quality products at competitive prices.')">
    <meta name="keywords" content="@yield('keywords', 'computers, gaming PC, laptops, hardware, MSK Computers, Sri Lanka, technology, graphics cards, processors, motherboards')">
    <meta name="author" content="MSK Computers">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'MSK COMPUTERS')">
    <meta property="og:description" content="@yield('og_description', 'MSK Computers - Your trusted partner for computer hardware and technology solutions.')">
    <meta property="og:image" content="@yield('og_image', asset('images/msk-logo.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="MSK Computers">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'MSK COMPUTERS')">
    <meta name="twitter:description" content="@yield('og_description', 'MSK Computers - Your trusted partner for computer hardware and technology solutions.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/msk-logo.png'))">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Fira+Code:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
    
    <!-- Cart Animation Styles -->
    <style>
        @keyframes cartShake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-2px) rotate(-1deg); }
            75% { transform: translateX(2px) rotate(1deg); }
        }
        
        @keyframes cartBounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        @keyframes cartGlow {
            0%, 100% { box-shadow: 0 0 5px rgba(16, 185, 129, 0.3); }
            50% { box-shadow: 0 0 20px rgba(16, 185, 129, 0.8); }
        }
        
        .cart-animate-shake {
            animation: cartShake 0.5s ease-in-out;
        }
        
        .cart-animate-bounce {
            animation: cartBounce 0.3s ease-in-out;
        }
        
        .cart-animate-glow {
            animation: cartGlow 1s ease-in-out;
        }
        
        .cart-success-flash {
            background: linear-gradient(45deg, #10b981, #059669) !important;
            color: white !important;
            transform: scale(1.05);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-dark-900 text-gray-100 font-sans antialiased">
    <!-- Top Contact Bar -->
    <div class="bg-black border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-center py-2 text-sm">
                <div class="flex items-center space-x-4 text-gray-300">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>0112 95 9005 / 0777 50 69 39 / 071 53 21 750</span>
                    </div>
                    <span class="hidden md:inline">|</span>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>info@mskcomputers.lk</span>
                    </div>
                </div>
                <div class="flex items-center space-x-2 text-primary-400 text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    <span>Island Wide Express Delivery Available</span>
                </div>
            </div>
        </div>
    </div>

         <!-- Unified Header with Navigation -->
     <header class="bg-black border-b border-gray-800 sticky top-0 z-[9999] shadow-lg navigation-header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Top Row: Logo, Search, Account -->
            <div class="flex items-center justify-between h-24 border-b border-gray-800/50">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="flex items-center">
                            <img src="{{ asset('msk-computers-logo-color.png') }}" 
                                 alt="MSK Computers Logo" 
                                 class="w-28 h-28 object-contain">
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-primary-400">MSK COMPUTERS</h1>
                            <p class="text-xs text-gray-400">Empowering Tech Solutions, Every Day.</p>
                        </div>
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-2xl mx-8 hidden md:block">
                    <form action="{{ route('products.search') }}" method="GET" class="relative" id="search-form">
                        <input type="text" name="q" placeholder="Search computers, parts, accessories..." 
                               class="w-full bg-black border border-gray-800 text-white px-4 py-2.5 pl-12 pr-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                               value="{{ request('q') }}" 
                               id="search-input"
                               autocomplete="off">
                        <svg class="w-5 h-5 absolute left-4 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <button type="submit" class="absolute right-2 top-1.5 bg-primary-500 text-black px-3 py-1.5 rounded-md hover:bg-primary-600 transition-colors text-sm">
                            Search
                        </button>
                        
                        <!-- Search Suggestions Dropdown -->
                        <div id="search-suggestions" class="absolute top-full left-0 right-0 bg-black border border-gray-800 rounded-lg shadow-xl mt-1 hidden z-[9999] max-h-80 overflow-y-auto">
                            <!-- Suggestions will be populated here -->
                        </div>
                    </form>
                </div>

                <!-- Right side items -->
                <div class="flex items-center space-x-3">
                    <!-- Enhanced Account Section -->
                    @auth
                        <div class="relative group">
                            <div class="flex items-center space-x-2 text-gray-300 hover:text-primary-400 transition-colors cursor-pointer py-2">
                                <div class="relative">
                                    <div class="w-6 h-6 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center">
                                        <span class="text-black font-bold text-xs">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                    <div class="absolute -top-1 -right-1 w-2 h-2 bg-green-400 border border-black rounded-full"></div>
                                </div>
                                <div class="hidden sm:block">
                                    <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                                </div>
                                <svg class="w-3 h-3 text-gray-400 group-hover:text-primary-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                            
                            <!-- Account Dropdown -->
                            <div class="absolute top-full right-0 mt-2 w-48 bg-black border border-gray-700 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-[9999]">
                                <div class="py-2">
                                    <a href="{{ route('user.dashboard') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-primary-400 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                        </svg>
                                        Dashboard
                                    </a>
                                    <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-primary-400 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Profile Settings
                                    </a>
                                    <a href="{{ route('user.orders') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-primary-400 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        My Orders
                                    </a>
                                    <a href="{{ route('orders.track') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-primary-400 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                        </svg>
                                        Track Order
                                    </a>
                                    <a href="{{ route('user.settings') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-primary-400 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Settings
                                    </a>
                                    <hr class="my-2 border-gray-700">
                                    <a href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                       class="flex items-center px-4 py-2 text-red-400 hover:bg-red-900/20 hover:text-red-300 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </a>
                                </div>
                            </div>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center space-x-2 text-gray-300 hover:text-primary-400 transition-colors py-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-sm hidden sm:block">Account</span>
                        </a>
                    @endauth

                    <!-- Enhanced Cart Section -->
                    <a href="{{ route('cart.index') }}" class="relative cart-container group hidden sm:flex items-center space-x-3 text-gray-300 hover:text-primary-400 transition-colors py-2 mr-4">
                        <div class="relative">
                            <svg class="w-6 h-6 cart-icon transition-all duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 12H6L5 9z"/>
                            </svg>
                            
                            <!-- Enhanced Cart Count Badge -->
                            <span class="cart-count absolute -top-2 -right-2 bg-gradient-to-r from-primary-400 to-primary-600 text-black text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center transition-all duration-300 transform shadow-lg">
                                0
                            </span>
                            
                            <!-- Cart Animation Indicator -->
                            <div class="cart-pulse absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full opacity-0 animate-ping"></div>
                        </div>
                        
                        <div class="hidden sm:block min-w-[80px]">
                            <div class="flex flex-col items-start">
                                <span class="text-sm font-medium">Cart</span>
                                <span class="cart-total text-xs text-gray-400">LKR 0.00</span>
                            </div>
                        </div>
                    </a>

                    <!-- Mobile Cart Icon -->
                    <a href="{{ route('cart.index') }}" class="relative cart-container-mobile group sm:hidden flex items-center text-gray-300 hover:text-primary-400 transition-colors py-2 mr-2">
                        <div class="relative">
                            <svg class="w-6 h-6 cart-icon-mobile transition-all duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 12H6L5 9z"/>
                            </svg>
                            <!-- Cart Count Badge -->
                            <span class="cart-count-mobile absolute -top-2 -right-2 bg-gradient-to-r from-primary-400 to-primary-600 text-black text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center transition-all duration-300 transform shadow-lg">
                                0
                            </span>
                        </div>
                    </a>

                    <!-- Mobile menu button -->
                    <button class="md:hidden p-2 hover:bg-black rounded-lg transition-colors" id="mobile-menu-button">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Bottom Row: Navigation Menu -->
            <div class="flex items-center justify-center space-x-4 lg:space-x-8 h-12">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-primary-400 transition-colors text-sm font-medium whitespace-nowrap {{ request()->routeIs('home') ? 'text-primary-400' : '' }}">Home</a>
                
                <!-- Categories Dropdown -->
                <div class="relative group">
                    <a href="{{ route('categories.index') }}" class="text-gray-300 hover:text-primary-400 transition-colors text-sm font-medium flex items-center whitespace-nowrap {{ request()->routeIs('categories.*') ? 'text-primary-400' : '' }}">
                        Categories
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                    
                    <!-- Categories Dropdown Menu -->
                    <div class="absolute top-full left-0 w-80 bg-black border border-gray-800 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-[9999] dropdown-menu max-h-[70vh] overflow-hidden">
                        <div class="py-3">
                            <!-- Dropdown Header -->
                            <div class="px-4 pb-3 border-b border-gray-800">
                                <h3 class="text-primary-400 font-semibold text-sm">Browse Categories</h3>
                            </div>
                            
                            <!-- Categories List with Scrolling -->
                            <div class="py-2 max-h-[60vh] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-gray-900">
                                @foreach($menuCategories as $category)
                                    <!-- Main Category -->
                                    <div class="mb-1">
                                        <a href="{{ route('categories.show', $category->slug ?: $category->id) }}" 
                                           class="flex items-center justify-between px-4 py-2 text-gray-300 hover:bg-gray-900 hover:text-primary-400 transition-colors group">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-3 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                                                </svg>
                                                <span class="font-medium text-sm">{{ $category->name }}</span>
                                            </div>
                                            <span class="text-gray-500 text-xs bg-gray-800 px-2 py-1 rounded-full group-hover:bg-gray-700">{{ $category->products_count }}</span>
                                        </a>
                                        
                                        <!-- Subcategories -->
                                        @if($category->subcategories->count() > 0)
                                            <div class="ml-6 mt-1 space-y-1">
                                                @foreach($category->subcategories as $subcategory)
                                                    <a href="{{ route('categories.show', $subcategory->slug ?: $subcategory->id) }}" 
                                                       class="flex items-center justify-between px-4 py-1.5 text-gray-400 hover:bg-gray-900 hover:text-primary-400 transition-colors text-sm group">
                                                        <div class="flex items-center">
                                                            <svg class="w-3 h-3 mr-3 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                                                            </svg>
                                                            <span>{{ $subcategory->name }}</span>
                                                        </div>
                                                        <span class="text-gray-600 text-xs group-hover:text-gray-500">
                                                            {{ $subcategory->subcategory_products_count ?? 0 }}
                                                        </span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- View All Categories -->
                            <div class="border-t border-gray-800 mt-3 pt-3">
                                <a href="{{ route('categories.index') }}" 
                                   class="flex items-center justify-center px-4 py-2 text-primary-400 hover:bg-gray-900 transition-colors font-medium text-sm">
                                    <span>View All Categories</span>
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('promotions.index') }}" class="text-gray-300 hover:text-primary-400 transition-colors text-sm font-medium whitespace-nowrap {{ request()->routeIs('promotions.*') ? 'text-primary-400' : '' }}">Promotions</a>
                <a href="{{ route('orders.track') }}" class="text-gray-300 hover:text-primary-400 transition-colors text-sm font-medium whitespace-nowrap {{ request()->routeIs('orders.track') ? 'text-primary-400' : '' }}">Track Order</a>
                <a href="{{ route('services.index') }}" class="text-gray-300 hover:text-primary-400 transition-colors text-sm font-medium whitespace-nowrap {{ request()->routeIs('services.*') ? 'text-primary-400' : '' }}">Service Center</a>
                <a href="{{ route('bank-details.index') }}" class="text-gray-300 hover:text-primary-400 transition-colors text-sm font-medium whitespace-nowrap {{ request()->routeIs('bank-details.*') ? 'text-primary-400' : '' }}">Bank Details</a>
                <a href="{{ route('about-us.index') }}" class="text-gray-300 hover:text-primary-400 transition-colors text-sm font-medium whitespace-nowrap {{ request()->routeIs('about-us.*') ? 'text-primary-400' : '' }}">About Us</a>
                <a href="{{ route('contact-us.index') }}" class="text-gray-300 hover:text-primary-400 transition-colors text-sm font-medium whitespace-nowrap {{ request()->routeIs('contact-us.*') ? 'text-primary-400' : '' }}">Contact Us</a>
                <a href="{{ route('e-services.index') }}" class="text-gray-300 hover:text-primary-400 transition-colors text-sm font-medium whitespace-nowrap {{ request()->routeIs('e-services.*') ? 'text-primary-400' : '' }}">E-Services</a>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div class="md:hidden hidden mobile-menu" id="mobile-menu">
            <div class="px-4 pt-4 pb-3 space-y-3 bg-black border-t border-gray-800 max-h-96 overflow-y-auto">
                <!-- Mobile Search -->
                <div class="mb-4">
                    <form action="{{ route('products.search') }}" method="GET" class="relative" id="mobile-search-form">
                        <input type="text" name="q" placeholder="Search computers, parts, accessories..." 
                               class="w-full bg-black border border-gray-800 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" 
                               value="{{ request('q') }}" 
                               id="mobile-search-input"
                               autocomplete="off">
                        
                        <!-- Mobile Search Suggestions -->
                        <div id="mobile-search-suggestions" class="absolute top-full left-0 right-0 bg-black border border-gray-800 rounded-lg shadow-xl mt-1 hidden z-[9999] max-h-60 overflow-y-auto">
                            <!-- Suggestions will be populated here -->
                        </div>
                    </form>
                </div>
                
                <!-- Main Navigation -->
                <a href="{{ route('home') }}" class="block py-2 text-gray-300 hover:text-primary-400 {{ request()->routeIs('home') ? 'text-primary-400' : '' }}">Home</a>
                
                <!-- Mobile Categories -->
                <div class="space-y-2">
                    <div class="text-primary-400 font-semibold text-sm">Categories</div>
                    @foreach($menuCategories as $category)
                        <div class="ml-2 space-y-1">
                            <a href="{{ route('categories.show', $category->slug ?: $category->id) }}" class="block py-1 text-gray-300 hover:text-primary-400 text-sm">
                                {{ $category->name }} ({{ $category->products_count }})
                            </a>
                            @if($category->subcategories->count() > 0)
                                <div class="ml-4 space-y-1">
                                    @foreach($category->subcategories as $subcategory)
                                        <a href="{{ route('categories.show', $subcategory->slug ?: $subcategory->id) }}" class="block py-1 text-gray-400 hover:text-primary-400 text-sm">
                                            {{ $subcategory->name }} ({{ $subcategory->subcategory_products_count ?? 0 }})
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <a href="{{ route('promotions.index') }}" class="block py-2 text-gray-300 hover:text-primary-400 {{ request()->routeIs('promotions.*') ? 'text-primary-400' : '' }}">Promotions</a>
                <a href="{{ route('orders.track') }}" class="block py-2 text-gray-300 hover:text-primary-400 {{ request()->routeIs('orders.track') ? 'text-primary-400' : '' }}">Track Order</a>
                <a href="{{ route('services.index') }}" class="block py-2 text-gray-300 hover:text-primary-400 {{ request()->routeIs('services.*') ? 'text-primary-400' : '' }}">Service Center</a>
                <a href="{{ route('bank-details.index') }}" class="block py-2 text-gray-300 hover:text-primary-400 {{ request()->routeIs('bank-details.*') ? 'text-primary-400' : '' }}">Bank Details</a>
                <a href="{{ route('about-us.index') }}" class="block py-2 text-gray-300 hover:text-primary-400 {{ request()->routeIs('about-us.*') ? 'text-primary-400' : '' }}">About Us</a>
                <a href="{{ route('contact-us.index') }}" class="block py-2 text-gray-300 hover:text-primary-400 {{ request()->routeIs('contact-us.*') ? 'text-primary-400' : '' }}">Contact Us</a>
                <a href="{{ route('e-services.index') }}" class="block py-2 text-gray-300 hover:text-primary-400 {{ request()->routeIs('e-services.*') ? 'text-primary-400' : '' }}">E-Services</a>
                
                <!-- Mobile Account & Cart -->
                <div class="border-t border-gray-800 pt-3 mt-3">
                    @auth
                        <!-- Logged In User Menu -->
                        <div class="space-y-2">
                            <div class="flex items-center py-2 text-gray-300 border-b border-gray-800 pb-2">
                                <img class="w-6 h-6 rounded-full mr-3" src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}">
                                <span class="font-medium">{{ Auth::user()->name }}</span>
                            </div>
                            <a href="{{ route('user.dashboard') }}" class="flex items-center py-2 text-gray-300 hover:text-[#f59e0b] transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('user.orders') }}" class="flex items-center py-2 text-gray-300 hover:text-[#f59e0b] transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                My Orders
                            </a>
                            <a href="{{ route('profile.show') }}" class="flex items-center py-2 text-gray-300 hover:text-[#f59e0b] transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profile Settings
                            </a>
                            <a href="{{ route('orders.track') }}" class="flex items-center py-2 text-gray-300 hover:text-[#f59e0b] transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                                Track Order
                            </a>
                            <a href="{{ route('user.settings') }}" class="flex items-center py-2 text-gray-300 hover:text-[#f59e0b] transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Settings
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="flex items-center py-2 text-gray-300 hover:text-red-400 transition-colors w-full text-left">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Guest User Menu -->
                        <div class="space-y-2">
                            <a href="{{ route('login') }}" class="flex items-center py-2 text-gray-300 hover:text-[#f59e0b] transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="flex items-center py-2 text-gray-300 hover:text-[#f59e0b] transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                Register
                            </a>
                        </div>
                    @endauth
                    
                    <a href="{{ route('cart.index') }}" class="flex items-center py-2 text-gray-300 hover:text-primary-400 mobile-cart-container">
                        <svg class="w-5 h-5 mr-2 mobile-cart-icon transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 12H6L5 9z"/>
                        </svg>
                        <span class="mobile-cart-text">Cart</span>
                        <span class="mobile-cart-count ml-auto bg-primary-500 text-black text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center transition-all duration-300">0</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

         <!-- Main Content -->
     <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-black border-t border-gray-800 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="flex items-center">
                            <img src="{{ asset('msk-computers-logo-color.png') }}" 
                                 alt="MSK Computers Logo" 
                                 class="w-24 h-24 object-contain">
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-primary-400">MSK COMPUTERS</h3>
                            <p class="text-sm font-medium text-gray-300">Best in Sri Lanka</p>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed">Your trusted partner for all computer needs in Sri Lanka, providing quality products and exceptional service.</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-primary-400 transition-colors text-sm">Home</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary-400 transition-colors text-sm">Gaming Laptops</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary-400 transition-colors text-sm">Desktop PCs</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary-400 transition-colors text-sm">Components</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary-400 transition-colors text-sm">Accessories</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary-400 transition-colors text-sm">Repair Services</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Categories</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-primary-400 transition-colors text-sm">Processors</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary-400 transition-colors text-sm">Graphics Cards</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary-400 transition-colors text-sm">Memory (RAM)</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary-400 transition-colors text-sm">Storage</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary-400 transition-colors text-sm">Motherboards</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary-400 transition-colors text-sm">Power Supplies</a></li>
                    </ul>
                </div>

                <!-- Contact Us -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Contact Us</h4>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-2">
                            <svg class="w-4 h-4 text-primary-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div class="text-gray-400 text-sm">
                                <div>No.296/3D, Delpe junction,</div>
                                <div>Ragama, Sri Lanka</div>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-2">
                            <svg class="w-4 h-4 text-primary-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <div class="text-gray-400 text-sm">
                                <div>0112 95 9005</div>
                                <div>0777 50 69 39 / 071 53 21 750</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-primary-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-gray-400 text-sm">info@mskcomputers.lk</span>
                        </div>
                        
                        <div class="flex items-start space-x-2">
                            <svg class="w-4 h-4 text-primary-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-gray-400 text-sm">
                                <div><strong>Tuesday to Friday:</strong> 9:00 AM - 7:00 PM</div>
                                <div><strong>Saturday to Sunday:</strong> 9:00 AM - 6:00 PM</div>
                                <div><strong>Closed on Poya Days</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Methods Section -->
            <div class="border-t border-gray-800 mt-8 pt-8">
                <div class="text-center">
                    <h4 class="text-lg font-semibold text-white mb-6">We Accept</h4>
                    <div class="flex flex-wrap justify-center items-center gap-6">
                        <!-- KokoPay -->
                        <div class="payment-method-item group">
                            <div class="flex items-center bg-gradient-to-r from-[#ec4899]/10 to-[#f97316]/10 border border-[#ec4899]/20 rounded-lg px-4 py-3 hover:from-[#ec4899]/20 hover:to-[#f97316]/20 transition-all">
                                <img src="{{ asset('images/kokopay-logo.png') }}" 
                                     alt="KokoPay - Buy Now Pay Later" 
                                     class="w-10 h-10 mr-3 object-contain">
                                <div class="text-left">
                                    <div class="text-sm font-semibold text-[#ec4899]">KokoPay</div>
                                    <div class="text-xs text-gray-400">Buy Now Pay Later</div>
                                </div>
                            </div>
                        </div>

                        <!-- WebXPay / Credit Cards -->
                        <div class="payment-method-item group">
                            <div class="flex items-center bg-gradient-to-r from-[#2563eb]/10 to-[#1d4ed8]/10 border border-[#2563eb]/20 rounded-lg px-4 py-3 hover:from-[#2563eb]/20 hover:to-[#1d4ed8]/20 transition-all">
                                <div class="w-10 h-10 bg-white rounded-md flex items-center justify-center mr-3">
                                    <img src="{{ asset('images/webxpay-logo.webp') }}" 
                                         alt="Credit/Debit Cards" 
                                         class="w-8 h-8 object-contain">
                                </div>
                                <div class="text-left">
                                    <div class="text-sm font-semibold text-[#2563eb]">Credit/Debit Cards</div>
                                    <div class="text-xs text-gray-400">Visa, MasterCard, Amex</div>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Transfer -->
                        <div class="payment-method-item group">
                            <div class="flex items-center bg-gradient-to-r from-[#10b981]/10 to-[#059669]/10 border border-[#10b981]/20 rounded-lg px-4 py-3 hover:from-[#10b981]/20 hover:to-[#059669]/20 transition-all">
                                <div class="w-10 h-10 bg-gradient-to-br from-[#10b981] to-[#059669] rounded-md flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M2 8V4.5C2 3.67 2.67 3 3.5 3H20.5C21.33 3 22 3.67 22 4.5V8H2ZM22 10V19.5C22 20.33 21.33 21 20.5 21H3.5C2.67 21 2 20.33 2 19.5V10H22ZM4 18H6V16H4V18ZM8 18H10V16H8V18Z"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <div class="text-sm font-semibold text-[#10b981]">Bank Transfer</div>
                                    <div class="text-xs text-gray-400">Direct Bank Deposit</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <!-- Security Notice -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-400 text-xs">
                            <svg class="w-4 h-4 inline mr-1 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M12,7C13.4,7 14.8,8.6 14.8,10V11.5C15.4,11.5 16,12.1 16,12.7V16.7C16,17.4 15.4,18 14.8,18H9.2C8.6,18 8,17.4 8,16.8V12.8C8,12.1 8.6,11.5 9.2,11.5V10C9.2,8.6 10.6,7 12,7M12,8.2C11.2,8.2 10.5,8.7 10.5,10V11.5H13.5V10C13.5,8.7 12.8,8.2 12,8.2Z"/>
                            </svg>
                            Your payment information is processed securely. We do not store credit card details.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="border-t border-gray-800 mt-8 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">© {{ date('Y') }} MSK COMPUTERS. All rights reserved.</p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="{{ route('privacy-policy') }}" class="text-gray-400 hover:text-primary-400 text-sm transition-colors">Privacy Policy</a>
                        <a href="{{ route('terms-of-service') }}" class="text-gray-400 hover:text-primary-400 text-sm transition-colors">Terms of Service</a>
                        <a href="{{ route('warranty') }}" class="text-gray-400 hover:text-primary-400 text-sm transition-colors">Warranty</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
    
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Enhanced Cart Animation Functions
        function updateCartCount(newCount = null, cartTotal = null) {
            try {
                if (newCount === null) {
                    // Get count from localStorage or session
                    newCount = localStorage.getItem('cartCount') || 0;
                } else {
                    // Store the new count
                    localStorage.setItem('cartCount', newCount);
                }
                
                if (cartTotal !== null) {
                    localStorage.setItem('cartTotal', cartTotal);
                } else {
                    cartTotal = localStorage.getItem('cartTotal') || '0.00';
                }
                
                const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(element => {
                    if (!element) return; // Skip if element doesn't exist
                    
                    const oldCount = parseInt(element.textContent) || 0;
                    element.textContent = newCount;
                    
                    // Animate cart count update
                    if (newCount > oldCount) {
                        try {
                            animateCartUpdate(element);
                        } catch (animError) {
                            console.error('Cart animation error:', animError);
                        }
                    }
                    
                    // Hide badge if count is 0
                    if (newCount == 0) {
                        element.style.opacity = '0';
                        element.style.transform = 'scale(0.8)';
                    } else {
                        element.style.opacity = '1';
                        element.style.transform = 'scale(1)';
                    }
                });
                
                // Update cart total display (but not on cart page itself)
                if (!window.location.pathname.includes('/cart')) {
                    const cartTotalElements = document.querySelectorAll('.cart-total');
                    cartTotalElements.forEach(element => {
                        if (element) {
                            element.textContent = `LKR ${cartTotal}`;
                        }
                    });
                }
                
                // Update mobile cart count separately
                const mobileCartCountElements = document.querySelectorAll('.mobile-cart-count');
                mobileCartCountElements.forEach(element => {
                    if (element) {
                        element.textContent = newCount;
                    }
                });

                // Update mobile cart text
                const mobileCartTexts = document.querySelectorAll('.mobile-cart-text');
                mobileCartTexts.forEach(element => {
                    if (element) {
                        element.textContent = newCount > 0 ? `Cart (${newCount})` : 'Cart';
                    }
                });
            } catch (error) {
                console.error('Error updating cart count:', error);
                // Fallback: at least update the basic count
                try {
                    const cartCountElements = document.querySelectorAll('.cart-count');
                    cartCountElements.forEach(element => {
                        if (element && newCount !== null) {
                            element.textContent = newCount;
                        }
                    });
                } catch (fallbackError) {
                    console.error('Fallback cart count update failed:', fallbackError);
                }
            }
        }
        
        function animateCartUpdate(countElement) {
            // Cart count bounce animation
            countElement.style.transform = 'scale(1.3)';
            countElement.style.backgroundColor = '#10b981'; // Green
            
            setTimeout(() => {
                countElement.style.transform = 'scale(1)';
                countElement.style.backgroundColor = '#f59e0b'; // Back to primary
            }, 200);
        }
        
        function updateMobileCartCount(newCount) {
            // Update mobile header cart count
            const mobileCartCountElements = document.querySelectorAll('.cart-count-mobile');
            mobileCartCountElements.forEach(element => {
                if (element) {
                    element.textContent = newCount;
                    if (newCount > 0) {
                        element.style.display = 'flex';
                    } else {
                        element.style.display = 'none';
                    }
                }
            });
        }

        function animateCartIcon() {
            // Cart icon shake and bounce
            const cartIcons = document.querySelectorAll('.cart-icon, .mobile-cart-icon, .cart-icon-mobile');
            cartIcons.forEach(icon => {
                icon.style.transform = 'scale(1.2) rotate(10deg)';
                setTimeout(() => {
                    icon.style.transform = 'scale(1.1) rotate(-5deg)';
                }, 100);
                setTimeout(() => {
                    icon.style.transform = 'scale(1) rotate(0deg)';
                }, 200);
            });
        }
        
        function showCartPulse() {
            // Show pulse animation
            const pulseElements = document.querySelectorAll('.cart-pulse');
            pulseElements.forEach(pulse => {
                pulse.style.opacity = '1';
                setTimeout(() => {
                    pulse.style.opacity = '0';
                }, 1500);
            });
        }
        
        function showCartSuccessNotification(message = 'Item added to cart!') {
            // Remove any existing notifications
            const existingNotifications = document.querySelectorAll('.cart-notification');
            existingNotifications.forEach(n => n.remove());
            
            // Create floating cart notification
            const notification = document.createElement('div');
            notification.className = 'cart-notification fixed z-[99999] bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-3 rounded-xl shadow-2xl transition-all duration-500 flex items-center space-x-3 border border-green-400/20';
            
            // Always position notification in top-right, within viewport
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.maxWidth = '320px';
            notification.style.width = 'auto';
            notification.style.transform = 'translateX(100%)'; // Start off-screen to the right
            
            // For mobile screens, adjust positioning
            if (window.innerWidth < 640) {
                notification.style.right = '10px';
                notification.style.left = '10px';
                notification.style.maxWidth = 'none';
                notification.style.width = 'auto';
                notification.style.transform = 'translateY(-100%)'; // Start off-screen above
            }
            
            notification.innerHTML = `
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-400 rounded-full flex items-center justify-center animate-bounce">
                        <svg class="w-5 h-5 text-green-800" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm">${message}</p>
                    <p class="text-green-100 text-xs mt-1">View cart to proceed to checkout</p>
                </div>
                <button onclick="this.parentElement.remove()" class="flex-shrink-0 text-green-200 hover:text-white transition-colors ml-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            
            document.body.appendChild(notification);
            
            // Trigger slide-in animation
            setTimeout(() => {
                if (window.innerWidth < 640) {
                    notification.style.transform = 'translateY(0)'; // Slide down on mobile
                } else {
                    notification.style.transform = 'translateX(0)'; // Slide in from right on desktop
                }
            }, 100);
            
            // Auto remove after 4 seconds
            setTimeout(() => {
                if (window.innerWidth < 640) {
                    notification.style.transform = 'translateY(-100%)'; // Slide up on mobile
                } else {
                    notification.style.transform = 'translateX(100%)'; // Slide out to right on desktop
                }
                notification.style.opacity = '0';
                
                setTimeout(() => {
                    if (notification.parentNode) {
                        document.body.removeChild(notification);
                    }
                }, 500);
            }, 4000);
        }
        
        // Global function to handle all cart animations
        window.animateCartAddition = function(cartCount, productName = 'Item', cartTotal = null) {
            try {
                // Update cart count with animation and total
                updateCartCount(cartCount, cartTotal);
                
                // Update mobile cart count
                updateMobileCartCount(cartCount);
                
                // Animate cart icon
                animateCartIcon();
                
                // Show pulse effect
                showCartPulse();
                
                // Show success notification
                showCartSuccessNotification(`${productName} added to cart!`);
                
                // Add temporary glow effect to cart container
                const cartContainers = document.querySelectorAll('.cart-container, .mobile-cart-container, .cart-container-mobile');
                cartContainers.forEach(container => {
                    container.style.filter = 'drop-shadow(0 0 15px #10b981)';
                    container.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        container.style.filter = 'none';
                        container.style.transform = 'scale(1)';
                    }, 800);
                });
            } catch (error) {
                console.error('Cart animation error:', error);
                // Don't show error notification, animation failure shouldn't show error to user
                // Just ensure cart count is updated
                if (cartCount) {
                    const cartCountElements = document.querySelectorAll('.cart-count');
                    cartCountElements.forEach(element => {
                        element.textContent = cartCount;
                    });
                }
            }
        }
        
        // Initialize cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Clear localStorage cart data and get fresh count from server
            localStorage.removeItem('cartCount');
            localStorage.removeItem('cartTotal');
            
            // Fetch actual cart count from server
            // Only fetch if not on checkout page to avoid conflicts
            if (!window.location.pathname.includes('/checkout')) {
                fetchCartCount();
            } else {
                // For checkout page, use fallback values
                updateCartCount(0, '0.00');
            }
        });
        
        // Fetch current cart count from server
        function fetchCartCount() {
            fetch('/cart/count', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Cart count fetched successfully:', data);
                updateCartCount(data.count, data.total);
            })
            .catch(error => {
                console.log('Cart count fetch error:', error);
                // Fallback to localStorage or default values
                const fallbackCount = localStorage.getItem('cartCount') || 0;
                const fallbackTotal = localStorage.getItem('cartTotal') || '0.00';
                updateCartCount(fallbackCount, fallbackTotal);
            });
        }

        // Search Suggestions Functionality
        let searchTimeout;
        
        function initSearchSuggestions(inputId, suggestionsId, isMobile = false) {
            const searchInput = document.getElementById(inputId);
            const suggestionsDiv = document.getElementById(suggestionsId);
            
            if (!searchInput || !suggestionsDiv) return;
            
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                
                clearTimeout(searchTimeout);
                
                if (query.length < 2) {
                    suggestionsDiv.classList.add('hidden');
                    return;
                }
                
                searchTimeout = setTimeout(() => {
                    console.log('Fetching suggestions for:', query);
                    fetch(`/api/search/suggestions?q=${encodeURIComponent(query)}`)
                        .then(response => {
                            console.log('Search API response status:', response.status);
                            return response.json();
                        })
                        .then(data => {
                            console.log('Search suggestions data:', data);
                            displaySuggestions(data, suggestionsDiv, isMobile);
                        })
                        .catch(error => {
                            console.error('Search suggestions error:', error);
                            suggestionsDiv.innerHTML = '<div class="p-4 text-red-400 text-center">Search error occurred</div>';
                            suggestionsDiv.classList.remove('hidden');
                        });
                }, 300);
            });
            
            // Hide suggestions when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
                    suggestionsDiv.classList.add('hidden');
                }
            });
            
            // Show suggestions when focusing input (if there's content)
            searchInput.addEventListener('focus', function() {
                if (this.value.trim().length >= 2) {
                    suggestionsDiv.classList.remove('hidden');
                }
            });
        }
        
        function displaySuggestions(data, suggestionsDiv, isMobile) {
            console.log('Displaying suggestions:', data, 'in container:', suggestionsDiv);
            let html = '';
            
            // Add categories
            if (data.categories && data.categories.length > 0) {
                html += '<div class="p-3 border-b border-gray-800"><div class="text-xs font-semibold text-primary-400 mb-2">CATEGORIES</div>';
                data.categories.forEach(category => {
                    html += `<a href="/categories/${category.slug}" class="block py-2 px-3 text-gray-300 hover:bg-gray-900 hover:text-primary-400 transition-colors rounded">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-3 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                            </svg>
                            <span>${category.name}</span>
                        </div>
                    </a>`;
                });
                html += '</div>';
            }
            
            // Add products
            if (data.products && data.products.length > 0) {
                html += '<div class="p-3"><div class="text-xs font-semibold text-primary-400 mb-2">PRODUCTS</div>';
                data.products.forEach(product => {
                    // Generate proper product URL using category and product slugs
                    const categorySlug = product.category?.slug || product.category?.id || 'uncategorized';
                    const productSlug = product.slug || product.id;
                    const productUrl = `/${categorySlug}/${productSlug}`;
                    
                    html += `<a href="${productUrl}" class="block py-2 px-3 text-gray-300 hover:bg-gray-900 hover:text-primary-400 transition-colors rounded">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-medium">${product.name}</div>
                                <div class="text-xs text-primary-400">LKR ${parseFloat(product.price).toLocaleString()}</div>
                            </div>
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>`;
                });
                html += '</div>';
            }
            
            if (html) {
                suggestionsDiv.innerHTML = html;
                suggestionsDiv.classList.remove('hidden');
            } else {
                suggestionsDiv.innerHTML = '<div class="p-4 text-gray-400 text-center">No results found</div>';
                suggestionsDiv.classList.remove('hidden');
            }
        }
        
        // Initialize search suggestions for both desktop and mobile
        document.addEventListener('DOMContentLoaded', function() {
            initSearchSuggestions('search-input', 'search-suggestions', false);
            initSearchSuggestions('mobile-search-input', 'mobile-search-suggestions', true);
        });

        // Initialize cart count on page load
        updateCartCount();
    </script>
</body>
</html>

