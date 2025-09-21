@extends('layouts.app')

@section('title', 'My Profile - MSK COMPUTERS')
@section('description', 'Update your MSK Computers account profile, change password, and manage personal information.')

@section('content')
<div class="min-h-screen bg-[#0f0f0f] py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Profile Settings</h1>
            <p class="text-gray-400">Manage your account information and preferences</p>
        </div>

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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Avatar Section -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                    <h3 class="text-lg font-medium text-white mb-4">Profile Picture</h3>
                    
                    <div class="text-center">
                        <img class="mx-auto h-32 w-32 rounded-full border-4 border-[#f59e0b] object-cover" 
                             src="{{ $user->avatar_url }}" 
                             alt="{{ $user->name }}">
                        
                        <form action="{{ route('user.avatar.update') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <div class="mt-4">
                                <label for="avatar" class="block text-sm font-medium text-gray-300 mb-2">
                                    Choose new picture
                                </label>
                                <input type="file" 
                                       id="avatar" 
                                       name="avatar" 
                                       accept="image/*" 
                                       class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[#f59e0b] file:text-black hover:file:bg-[#d97706] file:cursor-pointer">
                                @error('avatar')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <button type="submit" 
                                    class="mt-3 w-full px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-black bg-[#f59e0b] hover:bg-[#d97706] transition-colors">
                                Upload Photo
                            </button>
                        </form>
                        
                        <p class="text-xs text-gray-500 mt-2">JPG, PNG or GIF (max. 2MB)</p>
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="lg:col-span-2">
                <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6 mb-6">
                    <h3 class="text-lg font-medium text-white mb-4">Personal Information</h3>
                    
                    <form action="{{ route('user.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Phone Number</label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $user->phone) }}"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-300 mb-2">Date of Birth</label>
                                <input type="date" 
                                       id="date_of_birth" 
                                       name="date_of_birth" 
                                       value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent @error('date_of_birth') border-red-500 @enderror">
                                @error('date_of_birth')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-300 mb-2">Gender</label>
                                <div class="flex space-x-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="gender" value="male" {{ old('gender', $user->gender) === 'male' ? 'checked' : '' }}
                                               class="h-4 w-4 text-[#f59e0b] focus:ring-[#f59e0b] border-gray-700 bg-[#0f0f0f]">
                                        <span class="ml-2 text-sm text-gray-300">Male</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="gender" value="female" {{ old('gender', $user->gender) === 'female' ? 'checked' : '' }}
                                               class="h-4 w-4 text-[#f59e0b] focus:ring-[#f59e0b] border-gray-700 bg-[#0f0f0f]">
                                        <span class="ml-2 text-sm text-gray-300">Female</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="gender" value="other" {{ old('gender', $user->gender) === 'other' ? 'checked' : '' }}
                                               class="h-4 w-4 text-[#f59e0b] focus:ring-[#f59e0b] border-gray-700 bg-[#0f0f0f]">
                                        <span class="ml-2 text-sm text-gray-300">Other</span>
                                    </label>
                                </div>
                                @error('gender')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" 
                                    class="px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-black bg-gradient-to-r from-[#f59e0b] to-[#fbbf24] hover:from-[#d97706] hover:to-[#f59e0b] transition-all duration-300">
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                    <h3 class="text-lg font-medium text-white mb-4">Change Password</h3>
                    
                    <form action="{{ route('user.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-4">
                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-300 mb-2">Current Password</label>
                                <input type="password" 
                                       id="current_password" 
                                       name="current_password"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent @error('current_password') border-red-500 @enderror">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-300 mb-2">New Password</label>
                                <input type="password" 
                                       id="new_password" 
                                       name="new_password"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent @error('new_password') border-red-500 @enderror">
                                @error('new_password')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters with letters and numbers</p>
                            </div>

                            <!-- Confirm New Password -->
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm New Password</label>
                                <input type="password" 
                                       id="new_password_confirmation" 
                                       name="new_password_confirmation"
                                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" 
                                    class="px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-black bg-gradient-to-r from-[#f59e0b] to-[#fbbf24] hover:from-[#d97706] hover:to-[#f59e0b] transition-all duration-300">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Back to Dashboard -->
        <div class="mt-8">
            <a href="{{ route('user.dashboard') }}" 
               class="inline-flex items-center text-[#f59e0b] hover:text-[#d97706] transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
