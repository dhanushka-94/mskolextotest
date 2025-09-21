@extends('layouts.app')

@section('title', 'Warranty Certificate and Terms - MSK COMPUTERS')
@section('description', 'Comprehensive warranty coverage with clear terms and conditions for your peace of mind at MSK COMPUTERS. වගකීම් සහතිකය හා අදාළ කොන්දේසි')

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-br from-[#0a0a0a] via-[#0f0f0f] to-[#1a1a1c] py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 bg-[#f59e0b]/10 border border-[#f59e0b]/20 rounded-full text-[#f59e0b] text-sm font-medium mb-6">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M12,7C13.4,7 14.8,8.6 14.8,10V11.5C15.4,11.5 16,12.1 16,12.7V16.7C16,17.4 15.4,18 14.8,18H9.2C8.6,18 8,17.4 8,16.8V12.8C8,12.1 8.6,11.5 9.2,11.5V10C9.2,8.6 10.6,7 12,7M12,8.2C11.2,8.2 10.5,8.7 10.5,10V11.5H13.5V10C13.5,8.7 12.8,8.2 12,8.2Z"/>
                </svg>
                Warranty & Protection
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">
                Warranty Certificate
                <br>
                <span class="text-2xl md:text-3xl text-gray-300">වගකීම් සහතිකය</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                Comprehensive warranty coverage with clear terms and conditions for your peace of mind
            </p>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Requirements Section -->
            <div class="lg:col-span-1">
                <div class="bg-[#1c1c1e] border border-gray-800 rounded-xl p-8 mb-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#f59e0b] rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Bill Required</h3>
                            <p class="text-sm text-gray-400">බිල්පත අනිවාර්යයි</p>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed mb-4">
                        වගකීම ලබාදීම සඳහා බිල්පත අනිවාර්යයෙන් ඉදිරිපත් කළ යුතුය
                    </p>
                    <p class="text-gray-400 text-sm">
                        The bill must be submitted to provide warranty coverage
                    </p>
                </div>

                <div class="bg-[#1c1c1e] border border-gray-800 rounded-xl p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#10b981] rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12,2A3,3 0 0,1 15,5V7H19A1,1 0 0,1 20,8V20A1,1 0 0,1 19,21H5A1,1 0 0,1 4,20V8A1,1 0 0,1 5,7H9V5A3,3 0 0,1 12,2M12,4A1,1 0 0,0 11,5V7H13V5A1,1 0 0,0 12,4Z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Manufacturing Defects Only</h3>
                            <p class="text-sm text-gray-400">නිෂ්පාදිත දෝෂ පමණක්</p>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed mb-4">
                        නිෂ්පාදිත දෝෂ සඳහා පමණක් වගකීම හිමි වේ
                    </p>
                    <p class="text-gray-400 text-sm">
                        Warranty covers manufacturing defects only
                    </p>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Processing Time -->
                <div class="bg-[#1c1c1e] border border-gray-800 rounded-xl p-8 mb-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#3b82f6] rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Processing Time</h3>
                            <p class="text-sm text-gray-400">ක්‍රියාත්මක කිරීමේ කාලය</p>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed mb-6">
                        Brand new අයිතම සඳහා warranty ලබා ගැනීමේදී දින 10 ත් දින 30ත් අතර කාලයක් ගතවනු ඇත
                    </p>
                    <p class="text-gray-400 text-sm mb-8">
                        Brand new items: 10-30 days processing time
                    </p>

                    <!-- Warranty Period Chart -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gradient-to-br from-[#f59e0b]/10 to-[#d97706]/10 border border-[#f59e0b]/20 rounded-lg p-6 text-center">
                            <div class="text-3xl font-bold text-[#f59e0b] mb-2">1 Year</div>
                            <div class="text-sm text-gray-400">350 days</div>
                        </div>
                        <div class="bg-gradient-to-br from-[#10b981]/10 to-[#059669]/10 border border-[#10b981]/20 rounded-lg p-6 text-center">
                            <div class="text-3xl font-bold text-[#10b981] mb-2">2 Years</div>
                            <div class="text-sm text-gray-400">700 days</div>
                        </div>
                        <div class="bg-gradient-to-br from-[#8b5cf6]/10 to-[#7c3aed]/10 border border-[#8b5cf6]/20 rounded-lg p-6 text-center">
                            <div class="text-3xl font-bold text-[#8b5cf6] mb-2">3 Years</div>
                            <div class="text-sm text-gray-400">1050 days</div>
                        </div>
                    </div>
                </div>

                <!-- Warranty Exclusions -->
                <div class="bg-[#1c1c1e] border border-gray-800 rounded-xl p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12,2L13.09,8.26L22,9L17,14L18.18,22L12,19L5.82,22L7,14L2,9L10.91,8.26L12,2Z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Warranty Exclusions</h3>
                            <p class="text-sm text-gray-400">වගකීම් බහිර්ගතයන්</p>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm mb-6">
                        This warranty certificate does not cover the following types of damage:
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center p-4 bg-red-500/5 border border-red-500/20 rounded-lg">
                            <svg class="w-5 h-5 text-red-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11,15H13V17H11V15M11,7H13V13H11V7M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                            </svg>
                            <div>
                                <div class="text-sm font-medium text-white">Burn marks</div>
                                <div class="text-xs text-gray-400">පිළිස්සුණු ලකුණු</div>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-red-500/5 border border-red-500/20 rounded-lg">
                            <svg class="w-5 h-5 text-red-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11,15H13V17H11V15M11,7H13V13H11V7M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                            </svg>
                            <div>
                                <div class="text-sm font-medium text-white">Physical damage marks</div>
                                <div class="text-xs text-gray-400">පෑස්සූ ලකුණු</div>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-red-500/5 border border-red-500/20 rounded-lg">
                            <svg class="w-5 h-5 text-red-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11,15H13V17H11V15M11,7H13V13H11V7M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                            </svg>
                            <div>
                                <div class="text-sm font-medium text-white">Rust damage</div>
                                <div class="text-xs text-gray-400">මලකඩ කෑම</div>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-red-500/5 border border-red-500/20 rounded-lg">
                            <svg class="w-5 h-5 text-red-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11,15H13V17H11V15M11,7H13V13H11V7M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                            </svg>
                            <div>
                                <div class="text-sm font-medium text-white">Scratch marks</div>
                                <div class="text-xs text-gray-400">සීරීම් ලකුණු</div>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-red-500/5 border border-red-500/20 rounded-lg">
                            <svg class="w-5 h-5 text-red-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11,15H13V17H11V15M11,7H13V13H11V7M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                            </svg>
                            <div>
                                <div class="text-sm font-medium text-white">Lightning damage</div>
                                <div class="text-xs text-gray-400">අකුණු වලින් සිදුවී ඇති හානි</div>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-red-500/5 border border-red-500/20 rounded-lg">
                            <svg class="w-5 h-5 text-red-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11,15H13V17H11V15M11,7H13V13H11V7M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                            </svg>
                            <div>
                                <div class="text-sm font-medium text-white">Liquid spills</div>
                                <div class="text-xs text-gray-400">ආහාර හෝ බීම වර්ග හැලීමෙන් සිදුවන හානි</div>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-red-500/5 border border-red-500/20 rounded-lg">
                            <svg class="w-5 h-5 text-red-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11,15H13V17H11V15M11,7H13V13H11V7M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                            </svg>
                            <div>
                                <div class="text-sm font-medium text-white">User error damage</div>
                                <div class="text-xs text-gray-400">පරිගණක දැනුමක් නැති අය සිදුකරන වැරදි</div>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-red-500/5 border border-red-500/20 rounded-lg">
                            <svg class="w-5 h-5 text-red-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11,15H13V17H11V15M11,7H13V13H11V7M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                            </svg>
                            <div>
                                <div class="text-sm font-medium text-white">Natural disasters</div>
                                <div class="text-xs text-gray-400">ස්වාභාවික විපත් වැනි හානි</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Important Notice -->
        <div class="mt-12 bg-gradient-to-r from-red-500/10 to-orange-500/10 border border-red-500/20 rounded-xl p-8">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13,13H11V7H13M13,17H11V15H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-red-400 mb-3">Important Notice</h3>
                    <p class="text-gray-300 leading-relaxed">
                        <strong>If the warranty label is deleted or damaged, the warranty becomes void.</strong> 
                        No refunds will be given for purchased items. Please ensure that warranty labels remain intact and visible throughout the warranty period.
                    </p>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="mt-12 bg-[#1c1c1e] border border-gray-800 rounded-xl p-8 text-center">
            <h3 class="text-2xl font-bold text-white mb-4">Need Help with Your Warranty?</h3>
            <p class="text-gray-400 mb-6">Contact our support team for warranty assistance and claims</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact-us.index') }}" class="bg-[#f59e0b] hover:bg-[#d97706] text-black px-8 py-3 rounded-lg font-semibold transition-colors">
                    Contact Support
                </a>
                <a href="tel:0112959005" class="bg-[#1c1c1e] border border-gray-700 hover:border-[#f59e0b] text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    Call: 0112 95 9005
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
