<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Panel') - MSK COMPUTERS</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @stack('styles')
</head>
<body class="bg-[#0a0a0a] text-white font-sans antialiased">
    
    <!-- Admin Header -->
    <nav class="bg-black border-b border-gray-800 sticky top-0 z-50">
        <!-- Developer Info Mini Header -->
        <div class="bg-gray-900 border-b border-gray-700">
            <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
                <div class="flex justify-between items-center py-1.5 text-xs">
                    <div class="text-gray-400">
                        <span class="font-medium text-[#f59e0b]">MSK COMPUTERS</span> Admin Dashboard - Real-time Management System
                    </div>
                    <div class="text-gray-500">
                        Developed by <span class="text-[#f59e0b] font-medium">Olexto Digital Solutions (Pvt) Ltd</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
            <div class="flex justify-between h-18">
                
                <!-- Logo & Navigation -->
                <div class="flex items-center space-x-10 lg:space-x-12 xl:space-x-16">
                    <div class="flex items-center space-x-4 py-3">
                        <img src="{{ asset('msk-computers-logo-color.png') }}" alt="MSK Computers" class="h-10 w-10">
                        <div>
                            <span class="text-xl font-bold text-[#f59e0b]">MSK COMPUTERS</span>
                            <div class="text-sm text-gray-400">Admin Panel</div>
                        </div>
                    </div>
                    
                    <!-- Main Navigation - Optimized for Large Screens -->
                    <div class="hidden md:flex md:space-x-4 lg:space-x-6 xl:space-x-8 2xl:space-x-10">
                        <!-- Primary Navigation Group -->
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-[#f59e0b] text-black shadow-lg scale-105' : 'text-gray-300 hover:text-white hover:bg-gray-700/70 hover:scale-105' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                <span class="hidden lg:inline">Dashboard</span>
                                <span class="lg:hidden">Home</span>
                            </a>
                            
                            <a href="{{ route('admin.orders.index') }}" 
                               class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-[#f59e0b] text-black shadow-lg scale-105' : 'text-gray-300 hover:text-white hover:bg-gray-700/70 hover:scale-105' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Orders
                            </a>
                        </div>

                        <!-- Divider -->
                        <div class="hidden xl:block w-px h-8 bg-gray-600 self-center"></div>

                        <!-- User Management Group -->
                        <div class="flex space-x-2">
                            <div class="relative group">
                                <button class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-[#f59e0b] text-black shadow-lg' : 'text-gray-300 hover:text-white hover:bg-gray-700/70' }}">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                    </svg>
                                    <span class="hidden lg:inline">Users</span>
                                    <span class="lg:hidden">Users</span>
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div class="absolute left-0 mt-2 w-48 bg-gray-800 border border-gray-700 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <div class="py-2">
                                        <a href="{{ route('admin.users.index') }}" 
                                           class="flex items-center px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-700/70 transition-colors">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                            </svg>
                                            All Users
                                        </a>
                                        <a href="{{ route('admin.users.index', ['role' => 'customer']) }}" 
                                           class="flex items-center px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-700/70 transition-colors">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            Customers
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="{{ route('admin.transactions.index') }}" 
                               class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.transactions.*') ? 'bg-[#f59e0b] text-black shadow-lg scale-105' : 'text-gray-300 hover:text-white hover:bg-gray-700/70 hover:scale-105' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span class="hidden lg:inline">Transactions</span>
                                <span class="lg:hidden">Pay</span>
                            </a>
                        </div>

                        <!-- Divider -->
                        <div class="hidden xl:block w-px h-8 bg-gray-600 self-center"></div>

                        <!-- Analytics & Tools Group -->
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.analytics') }}" 
                               class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.analytics') ? 'bg-[#f59e0b] text-black shadow-lg scale-105' : 'text-gray-300 hover:text-white hover:bg-gray-700/70 hover:scale-105' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <span class="hidden lg:inline">Analytics</span>
                                <span class="lg:hidden">Stats</span>
                            </a>
                            
                            <!-- Tools Dropdown -->
                            <div class="relative group">
                                <button class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.activity-logs.*') || request()->routeIs('admin.sitemap.*') ? 'bg-[#f59e0b] text-black shadow-lg' : 'text-gray-300 hover:text-white hover:bg-gray-700/70' }}">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="hidden lg:inline">Tools</span>
                                    <span class="lg:hidden">Tools</span>
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div class="absolute right-0 mt-2 w-48 bg-gray-800 border border-gray-700 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <div class="py-2">
                                        <a href="{{ route('admin.activity-logs.index') }}" 
                                           class="flex items-center px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-700/70 transition-colors">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Activity Logs
                                        </a>
                                        <a href="{{ route('admin.sitemap.index') }}" 
                                           class="flex items-center px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-700/70 transition-colors">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                            </svg>
                                            Sitemap Management
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button type="button" 
                            id="mobile-menu-button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            aria-controls="mobile-menu" 
                            aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <!-- Menu icon -->
                        <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Close icon -->
                        <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- Website Link -->
                    <a href="{{ route('home') }}" 
                       class="text-gray-400 hover:text-white transition-colors" 
                       target="_blank"
                       title="View Website">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                    
                    <!-- User Menu -->
                    <div class="relative">
                        <div class="flex items-center space-x-3">
                            <img class="w-8 h-8 rounded-full" src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}">
                            <div class="hidden md:block">
                                <div class="text-sm font-medium text-white">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-400">Administrator</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Logout -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="text-gray-400 hover:text-red-400 transition-colors" 
                                title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-gray-900 border-t border-gray-700">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-3 py-2 text-base font-medium rounded-md transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#f59e0b] text-black' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center px-3 py-2 text-base font-medium rounded-md transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-[#f59e0b] text-black' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Orders
                </a>
                
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center px-3 py-2 text-base font-medium rounded-md transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-[#f59e0b] text-black' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    All Users
                </a>
                
                <a href="{{ route('admin.users.index', ['role' => 'customer']) }}" 
                   class="flex items-center px-3 py-2 text-base font-medium rounded-md transition-colors {{ request()->get('role') == 'customer' ? 'bg-[#f59e0b] text-black' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Customers
                </a>
                
                <a href="{{ route('admin.transactions.index') }}" 
                   class="flex items-center px-3 py-2 text-base font-medium rounded-md transition-colors {{ request()->routeIs('admin.transactions.*') ? 'bg-[#f59e0b] text-black' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Transactions
                </a>
                
                <a href="{{ route('admin.analytics') }}" 
                   class="flex items-center px-3 py-2 text-base font-medium rounded-md transition-colors {{ request()->routeIs('admin.analytics') ? 'bg-[#f59e0b] text-black' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Analytics
                </a>
                
                <a href="{{ route('admin.activity-logs.index') }}" 
                   class="flex items-center px-3 py-2 text-base font-medium rounded-md transition-colors {{ request()->routeIs('admin.activity-logs.*') ? 'bg-[#f59e0b] text-black' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Activity Logs
                </a>
                
                <a href="{{ route('admin.sitemap.index') }}" 
                   class="flex items-center px-3 py-2 text-base font-medium rounded-md transition-colors {{ request()->routeIs('admin.sitemap.*') ? 'bg-[#f59e0b] text-black' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    Sitemap Management
                </a>
                
                <!-- Mobile User Info -->
                <div class="border-t border-gray-700 pt-4 mt-4">
                    <div class="flex items-center px-3 py-2">
                        <img class="w-8 h-8 rounded-full mr-3" src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}">
                        <div>
                            <div class="text-sm font-medium text-white">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-400">Administrator</div>
                        </div>
                    </div>
                    
                    <a href="{{ route('home') }}" 
                       class="flex items-center px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 rounded-md transition-colors"
                       target="_blank">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        View Website
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" 
                                class="flex items-center w-full px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 rounded-md transition-colors text-left">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16 py-8">
            
            <!-- Success Messages -->
            @if (session('success'))
                <div class="bg-green-900/50 border border-green-500 text-green-200 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if (session('error'))
                <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
            
            <!-- Developer Copyright Footer -->
            <footer class="mt-12 pt-8 border-t border-gray-700/50">
                <div class="text-center">
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-2 text-sm text-gray-400">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Developed by</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="font-semibold text-primary-400">Olexto Digital Solutions (Pvt) Ltd</span>
                            <span class="text-gray-500">•</span>
                            <span class="text-xs text-gray-500">{{ date('Y') }}</span>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-gray-500">
                        Professional Web Development & Digital Solutions
                    </div>
                </div>
            </footer>
        </div>
    </main>

    @stack('scripts')

    <!-- Mobile Menu Toggle Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = mobileMenuButton.querySelector('svg:first-of-type');
        const closeIcon = mobileMenuButton.querySelector('svg:last-of-type');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                const isOpen = !mobileMenu.classList.contains('hidden');
                
                if (isOpen) {
                    // Close menu
                    mobileMenu.classList.add('hidden');
                    menuIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'false');
                } else {
                    // Open menu
                    mobileMenu.classList.remove('hidden');
                    menuIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'true');
                }
            });

            // Close menu when clicking on a link
            const mobileMenuLinks = mobileMenu.querySelectorAll('a');
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                    menuIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'false');
                });
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                    menuIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'false');
                }
            });
        }
    });
    </script>
</body>
</html>
