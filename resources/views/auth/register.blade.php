@extends('layouts.app')

@section('title', 'Register - MSK COMPUTERS')
@section('description', 'Create your MSK Computers account to track orders, save addresses, and enjoy personalized shopping experience.')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-black via-[#0f0f0f] to-[#1a1a1c] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute w-96 h-96 rounded-full bg-[#f59e0b] blur-3xl -top-48 -left-48"></div>
        <div class="absolute w-96 h-96 rounded-full bg-[#3b82f6] blur-3xl -bottom-48 -right-48"></div>
    </div>
    
    <div class="max-w-md w-full space-y-8 relative z-10">
        <!-- Glass Card Container -->
        <div class="bg-[#1a1a1c]/80 backdrop-blur-xl border border-gray-800/50 rounded-2xl p-8 shadow-2xl">
            <!-- Logo and Header -->
            <div class="text-center">
                <div class="h-32 w-32 mx-auto mb-6 relative">
                    <div class="absolute inset-0 bg-[#f59e0b]/20 rounded-full blur-xl"></div>
                    <img src="{{ asset('msk-computers-logo-color.png') }}" alt="MSK Computers Logo" class="w-full h-full object-contain relative z-10">
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Create Account</h2>
                <p class="text-gray-400 mb-6">Join MSK Computers for exclusive deals and faster checkout</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-900/30 backdrop-blur-sm border border-red-500/50 text-red-200 px-4 py-3 rounded-xl mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                        <ul class="list-none space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Success Messages -->
            @if (session('success'))
                <div class="bg-green-900/30 backdrop-blur-sm border border-green-500/50 text-green-200 px-4 py-3 rounded-xl mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Registration Form -->
            <form class="space-y-6" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="space-y-4">
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input id="name" name="name" type="text" autocomplete="name" required 
                                   value="{{ old('name') }}"
                                   class="w-full pl-10 pr-4 py-3 bg-[#0f0f0f]/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b]/50 focus:border-[#f59e0b] transition-all duration-300 @error('name') border-red-500 @enderror"
                                   placeholder="Enter your full name">
                        </div>
                    </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 bg-[#1a1a1c] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent transition-all duration-300 @error('email') border-red-500 @enderror"
                           placeholder="Enter your email address">
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Phone Number <span class="text-gray-500">(Optional)</span></label>
                    <input id="phone" name="phone" type="tel" autocomplete="tel" 
                           value="{{ old('phone') }}"
                           class="w-full px-4 py-3 bg-[#1a1a1c] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent transition-all duration-300 @error('phone') border-red-500 @enderror"
                           placeholder="Enter your phone number">
                    <p class="text-xs text-gray-500 mt-1">We'll use this for order updates and delivery coordination</p>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required 
                           class="w-full px-4 py-3 bg-[#1a1a1c] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent transition-all duration-300 @error('password') border-red-500 @enderror"
                           placeholder="Create a strong password">
                    <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters with letters and numbers</p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                           class="w-full px-4 py-3 bg-[#1a1a1c] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent transition-all duration-300"
                           placeholder="Confirm your password">
                </div>
            </div>

            <!-- Terms and Privacy -->
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="terms" name="terms" type="checkbox" required
                           class="h-4 w-4 bg-[#1a1a1c] border-gray-700 rounded text-[#f59e0b] focus:ring-[#f59e0b] focus:ring-offset-gray-900 @error('terms') border-red-500 @enderror">
                </div>
                <div class="ml-3 text-sm">
                    <label for="terms" class="text-gray-300">
                        I agree to the <a href="#" class="text-[#f59e0b] hover:text-[#d97706] transition-colors">Terms of Service</a> 
                        and <a href="#" class="text-[#f59e0b] hover:text-[#d97706] transition-colors">Privacy Policy</a>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-black bg-gradient-to-r from-[#f59e0b] to-[#fbbf24] hover:from-[#d97706] hover:to-[#f59e0b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#f59e0b] transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Create Account
                </button>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <p class="text-gray-400">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-[#f59e0b] hover:text-[#d97706] font-medium transition-colors">Sign in here</a>
                </p>
            </div>
        </form>

        <!-- Benefits -->
        <div class="mt-8 pt-6 border-t border-gray-800">
            <p class="text-center text-gray-400 text-sm mb-4">Benefits of creating an account</p>
            <div class="grid grid-cols-1 gap-3">
                <div class="flex items-center text-gray-300 text-sm">
                    <svg class="w-4 h-4 text-[#f59e0b] mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    Track orders and delivery status
                </div>
                <div class="flex items-center text-gray-300 text-sm">
                    <svg class="w-4 h-4 text-[#f59e0b] mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    Save multiple delivery addresses
                </div>
                <div class="flex items-center text-gray-300 text-sm">
                    <svg class="w-4 h-4 text-[#f59e0b] mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    Faster checkout & reorder previous purchases
                </div>
                <div class="flex items-center text-gray-300 text-sm">
                    <svg class="w-4 h-4 text-[#f59e0b] mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    Access to exclusive deals and early sales
                </div>
            </div>
        </div>
    </div>
</div>
@endsection