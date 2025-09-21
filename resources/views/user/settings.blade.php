@extends('layouts.app')

@section('title', 'Account Settings - MSK COMPUTERS')

@section('content')
<div class="min-h-screen bg-[#0a0a0a] py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Account Settings</h1>
                    <p class="text-gray-400 mt-2">Manage your notification preferences and account settings</p>
                </div>
                <a href="{{ route('user.dashboard') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Settings Navigation -->
            <div class="lg:col-span-1">
                <div class="bg-[#1c1c1e] rounded-xl border border-gray-800/30 p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Settings Categories</h3>
                    <nav class="space-y-2">
                        <a href="#notifications" class="flex items-center p-3 text-gray-300 hover:text-primary-400 hover:bg-gray-800/50 rounded-lg transition-colors">
                            <i class="fas fa-bell w-5 mr-3"></i>
                            Notifications
                        </a>
                        <a href="#preferences" class="flex items-center p-3 text-gray-300 hover:text-primary-400 hover:bg-gray-800/50 rounded-lg transition-colors">
                            <i class="fas fa-cog w-5 mr-3"></i>
                            Preferences
                        </a>
                        <a href="#privacy" class="flex items-center p-3 text-gray-300 hover:text-primary-400 hover:bg-gray-800/50 rounded-lg transition-colors">
                            <i class="fas fa-shield-alt w-5 mr-3"></i>
                            Privacy
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Settings Content -->
            <div class="lg:col-span-2">
                <form method="POST" action="{{ route('user.settings.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Notification Settings -->
                    <div id="notifications" class="bg-[#1c1c1e] rounded-xl border border-gray-800/30 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-white mb-4">
                            <i class="fas fa-bell text-primary-400 mr-2"></i>
                            Notification Preferences
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-800/30 rounded-lg">
                                <div>
                                    <h4 class="text-white font-medium">Email Notifications</h4>
                                    <p class="text-gray-400 text-sm">Receive order updates and important notifications via email</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="email_notifications" value="1" class="sr-only peer" 
                                           {{ (old('email_notifications', json_decode($user->settings ?? '{}', true)['email_notifications'] ?? true)) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-800/30 rounded-lg">
                                <div>
                                    <h4 class="text-white font-medium">SMS Notifications</h4>
                                    <p class="text-gray-400 text-sm">Receive order status updates via SMS</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="sms_notifications" value="1" class="sr-only peer"
                                           {{ (old('sms_notifications', json_decode($user->settings ?? '{}', true)['sms_notifications'] ?? true)) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-800/30 rounded-lg">
                                <div>
                                    <h4 class="text-white font-medium">Marketing Notifications</h4>
                                    <p class="text-gray-400 text-sm">Receive promotional offers and new product updates</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="marketing_notifications" value="1" class="sr-only peer"
                                           {{ (old('marketing_notifications', json_decode($user->settings ?? '{}', true)['marketing_notifications'] ?? false)) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Preference Settings -->
                    <div id="preferences" class="bg-[#1c1c1e] rounded-xl border border-gray-800/30 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-white mb-4">
                            <i class="fas fa-cog text-primary-400 mr-2"></i>
                            General Preferences
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="language" class="block text-sm font-medium text-gray-300 mb-2">Language</label>
                                <select id="language" name="language" class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary-500">
                                    <option value="en" {{ (old('language', json_decode($user->settings ?? '{}', true)['language'] ?? 'en') == 'en') ? 'selected' : '' }}>English</option>
                                    <option value="si" {{ (old('language', json_decode($user->settings ?? '{}', true)['language'] ?? 'en') == 'si') ? 'selected' : '' }}>Sinhala</option>
                                    <option value="ta" {{ (old('language', json_decode($user->settings ?? '{}', true)['language'] ?? 'en') == 'ta') ? 'selected' : '' }}>Tamil</option>
                                </select>
                            </div>

                            <div>
                                <label for="currency" class="block text-sm font-medium text-gray-300 mb-2">Currency</label>
                                <select id="currency" name="currency" class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary-500">
                                    <option value="LKR" {{ (old('currency', json_decode($user->settings ?? '{}', true)['currency'] ?? 'LKR') == 'LKR') ? 'selected' : '' }}>Sri Lankan Rupee (LKR)</option>
                                    <option value="USD" {{ (old('currency', json_decode($user->settings ?? '{}', true)['currency'] ?? 'LKR') == 'USD') ? 'selected' : '' }}>US Dollar (USD)</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label for="timezone" class="block text-sm font-medium text-gray-300 mb-2">Timezone</label>
                                <select id="timezone" name="timezone" class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary-500">
                                    <option value="Asia/Colombo" {{ (old('timezone', json_decode($user->settings ?? '{}', true)['timezone'] ?? 'Asia/Colombo') == 'Asia/Colombo') ? 'selected' : '' }}>Asia/Colombo (GMT+5:30)</option>
                                    <option value="UTC" {{ (old('timezone', json_decode($user->settings ?? '{}', true)['timezone'] ?? 'Asia/Colombo') == 'UTC') ? 'selected' : '' }}>UTC (GMT+0:00)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Privacy Settings -->
                    <div id="privacy" class="bg-[#1c1c1e] rounded-xl border border-gray-800/30 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-white mb-4">
                            <i class="fas fa-shield-alt text-primary-400 mr-2"></i>
                            Privacy & Security
                        </h3>
                        <div class="space-y-4">
                            <div class="p-4 bg-gray-800/30 rounded-lg">
                                <h4 class="text-white font-medium mb-2">Profile Visibility</h4>
                                <p class="text-gray-400 text-sm mb-3">Control who can see your profile information</p>
                                <select class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary-500">
                                    <option value="private">Private (Only you)</option>
                                    <option value="limited">Limited (MSK Staff only)</option>
                                </select>
                            </div>

                            <div class="p-4 bg-gray-800/30 rounded-lg">
                                <h4 class="text-white font-medium mb-2">Order History Visibility</h4>
                                <p class="text-gray-400 text-sm mb-3">Choose who can view your order history</p>
                                <select class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary-500">
                                    <option value="private">Private (Only you and MSK support)</option>
                                    <option value="public">Public (Visible in reviews)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-lg font-medium transition-colors">
                            <i class="fas fa-save mr-2"></i>Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Smooth scroll for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>
@endsection
