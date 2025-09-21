@extends('layouts.app')

@section('title', 'Bank Details - Payment Information | MSK COMPUTERS')
@section('description', 'Complete payment instructions and secure banking options for your computer purchases at MSK Computers. Multiple bank accounts available for easy payments.')
@section('keywords', 'bank details, payment, MSK Computers, bank transfer, payment methods, Sri Lanka banking, computer purchase payment')

@section('content')
<!-- Hero Section -->
<section class="py-16 bg-gradient-to-b from-black to-[#0f0f0f]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-flex items-center px-4 py-2 bg-[#f59e0b]/10 border border-[#f59e0b]/20 rounded-lg text-[#f59e0b] text-sm font-medium mb-6">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586l-2 2V7H5v10h6.586l2 2H4a1 1 0 01-1-1V4z"/>
                    <path d="M17.414 8L21 11.586 11.586 21H8v-3.586L17.414 8z"/>
                </svg>
                Payment Information
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                Bank Details &
                <span class="text-[#f59e0b]">Payment Information</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-4xl mx-auto leading-relaxed">
                Complete payment instructions and secure banking options for your computer purchases.
            </p>
        </div>
    </div>
</section>

<!-- Important Notice Section -->
<section class="py-16 bg-[#0f0f0f]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Payment එකක් කිරීමට පෙර සැලකිලිමත් විය යුතු කරුණු</h2>
            <p class="text-lg text-gray-400">Consider below details before making a payment</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Stock Confirmation -->
            <div class="bg-[#1a1a1c] border border-red-500/30 rounded-xl p-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.728-.833-2.498 0L4.316 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-red-400 mb-3">Stock Confirmation Required</h3>
                        <p class="text-gray-300 text-sm mb-3">ඔබ payment එකක් සිදු කිරීමට පෙර අනිවාර්යයෙන් ම ඔබට අවශ්‍ය භාණ්ඩය shop එකෙහි stock පවතී ද යන්න අප අමතා ස්ථීර කරගත යුතුය</p>
                        <p class="text-gray-400 text-sm">Before you make a payment, you must make sure that the item you want is in stock in the shop.</p>
                    </div>
                </div>
            </div>

            <!-- No Cash on Delivery -->
            <div class="bg-[#1a1a1c] border border-orange-500/30 rounded-xl p-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-orange-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-orange-400 mb-3">No Cash on Delivery</h3>
                        <p class="text-gray-300 text-sm mb-3">Cash on delivery නොමැත</p>
                        <p class="text-gray-400 text-sm">No cash on delivery.</p>
                    </div>
                </div>
            </div>

            <!-- Full Payment Required -->
            <div class="bg-[#1a1a1c] border border-blue-500/30 rounded-xl p-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-400 mb-3">Full Payment Required</h3>
                        <p class="text-gray-300 text-sm mb-3">භාණ්ඩය courier කිරීමට පෙර සියලුම මුදල් ගෙවා තිබිය යුතුය</p>
                        <p class="text-gray-400 text-sm">All payments must be made prior to couriering the item.</p>
                    </div>
                </div>
            </div>

            <!-- Pre-order Policy -->
            <div class="bg-[#1a1a1c] border border-green-500/30 rounded-xl p-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 7a2 2 0 01-2 2H8a2 2 0 01-2-2L5 9z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-green-400 mb-3">Pre-order Policy</h3>
                        <p class="text-gray-300 text-sm mb-3">ඔබ භාණ්ඩයක් වෙන් කරගනු ලබන්නේ නම් (pre order) භාණ්ඩයේ වටිනාකමින් 50% ක් ගෙවිය යුතුය</p>
                        <p class="text-gray-400 text-sm">If you pre-order an item, you must pay 50% of the value of the item.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Payment Confirmation Section -->
<section class="py-16 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Payment Confirmation -->
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-8">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 bg-[#f59e0b]/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white">Payment Confirmation</h3>
                </div>
                <p class="text-gray-300 text-sm mb-4">ඔබ payment එක කිරීමෙන් පසු cash deposit machine එක මඟින් ලැබෙන slip එක හෝ online transfer මඟින් සිදුකරන්නේ නම් එහි screenshot එක WhatsApp මාර්ගයෙන් අපට එවිය යුතුය</p>
                <p class="text-gray-400 text-sm mb-6">If you make a payment from the cash deposit machine or an online transfer, you need to send us a screenshot of slip via WhatsApp.</p>
                
                <div class="bg-green-600/20 border border-green-600/30 rounded-lg p-4">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.386"/>
                        </svg>
                        <div>
                            <p class="text-green-400 font-medium text-sm">WhatsApp Payment Confirmation</p>
                            <p class="text-white font-bold">Send to: 0777506939</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Requirements -->
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-8">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 bg-[#f59e0b]/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white">Address Requirements</h3>
                </div>
                <p class="text-gray-300 text-sm mb-4">ඒ සමඟම ඔබගේ නම,එවිය යුතු ලිපිනය,දුරකතන අංක 2ක් අප වෙත යොමු කළ යුතුය. ඔබගේ ලිපිනයෙහි ප්‍රධාන නගරයක් නිරූපණය නොවේ නම් ඔබට ළඟම ප්‍රධාන නගරය හෝ දිස්ත්‍රික්කය යොමු කළ යුතුය</p>
                <p class="text-gray-400 text-sm mb-6">At the same time your name, address to be sent, 2 telephone numbers should be sent to us. If your address does not represent a major city, you should refer to the nearest major city or district.</p>
                
                <div class="bg-gray-800/50 rounded-lg p-4">
                    <h4 class="text-white font-medium mb-3">Required Information:</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Your full name</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Complete delivery address</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>2 telephone numbers</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Nearest major city/district</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Card Payment Policy -->
        <div class="mt-8 bg-[#1a1a1c] border border-purple-500/30 rounded-xl p-8">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-purple-400 mb-2">Card Payment Policy</h3>
                    <p class="text-gray-300 text-sm mb-2">Card payment සිදු කළ හැක්කේ shop එකට පැමිණීමෙන් පමණි</p>
                    <p class="text-gray-400 text-sm">Card payment can be made only by visiting the shop.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bank Accounts Section -->
<section class="py-16 bg-[#0f0f0f]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Bank Accounts</h2>
            <p class="text-lg text-gray-400">Choose any of our bank accounts for secure payments</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- People Bank -->
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-8 hover:border-[#f59e0b]/30 transition-all duration-300">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-blue-500/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">People's Bank</h3>
                    <p class="text-gray-400 text-sm">Kadawatha branch</p>
                </div>
                
                <div class="space-y-4">
                    <div class="bg-gray-800/50 rounded-lg p-4">
                        <p class="text-gray-400 text-xs mb-1">Account Name</p>
                        <p class="text-white font-medium">S.D MANUKA SHAMINDA</p>
                    </div>
                    
                    <div class="bg-gray-800/50 rounded-lg p-4">
                        <p class="text-gray-400 text-xs mb-1">Account Number</p>
                        <p class="text-[#f59e0b] font-bold text-lg">273100140018638</p>
                    </div>
                </div>
            </div>

            <!-- Commercial Bank -->
            <div class="bg-[#1a1a1c] border border-[#f59e0b]/50 rounded-xl p-8 relative overflow-hidden">
                <div class="absolute top-4 right-4">
                    <span class="bg-[#f59e0b] text-black text-xs font-bold px-2 py-1 rounded-full">Primary Account</span>
                </div>
                
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-[#f59e0b]/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Commercial Bank</h3>
                    <p class="text-gray-400 text-sm">Ragama Branch</p>
                </div>
                
                <div class="space-y-4">
                    <div class="bg-gray-800/50 rounded-lg p-4">
                        <p class="text-gray-400 text-xs mb-1">Account Name</p>
                        <p class="text-white font-medium">MSK Computers</p>
                    </div>
                    
                    <div class="bg-gray-800/50 rounded-lg p-4">
                        <p class="text-gray-400 text-xs mb-1">Account Number</p>
                        <p class="text-[#f59e0b] font-bold text-lg">1000578810</p>
                    </div>
                </div>
            </div>

            <!-- Seylan Bank -->
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-8 hover:border-[#f59e0b]/30 transition-all duration-300">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-green-500/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Seylan Bank</h3>
                    <p class="text-gray-400 text-sm">Kadawatha branch</p>
                </div>
                
                <div class="space-y-4">
                    <div class="bg-gray-800/50 rounded-lg p-4">
                        <p class="text-gray-400 text-xs mb-1">Account Name</p>
                        <p class="text-white font-medium">S.D.Manuka Shaminda</p>
                    </div>
                    
                    <div class="bg-gray-800/50 rounded-lg p-4">
                        <p class="text-gray-400 text-xs mb-1">Account Number</p>
                        <p class="text-[#f59e0b] font-bold text-lg">028013208783120</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Payment Instructions Section -->
<section class="py-16 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Payment Instructions</h2>
            <p class="text-lg text-gray-400">Follow these steps for secure bank transfers</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-[#f59e0b] rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-black">01</span>
                </div>
                <h3 class="text-lg font-semibold text-white mb-3">Choose Bank Account</h3>
                <p class="text-gray-400 text-sm">Use any of the bank account details above</p>
            </div>

            <!-- Step 2 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-[#f59e0b] rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-black">02</span>
                </div>
                <h3 class="text-lg font-semibold text-white mb-3">Make Transfer</h3>
                <p class="text-gray-400 text-sm">Include your name and phone number in transfer description</p>
            </div>

            <!-- Step 3 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-[#f59e0b] rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-black">03</span>
                </div>
                <h3 class="text-lg font-semibold text-white mb-3">Send Proof</h3>
                <p class="text-gray-400 text-sm">Send transfer slip screenshot via WhatsApp</p>
            </div>

            <!-- Step 4 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-[#f59e0b] rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-black">04</span>
                </div>
                <h3 class="text-lg font-semibold text-white mb-3">Provide Details</h3>
                <p class="text-gray-400 text-sm">Provide complete delivery address and 2 phone numbers</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact & Help Section -->
<section class="py-16 bg-gradient-to-b from-[#0f0f0f] to-black">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Need Help with Payments?</h2>
        <p class="text-lg text-gray-400 mb-8">Contact us for payment assistance or stock confirmation before making your payment</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Call Us -->
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Call Us</h3>
                <p class="text-[#f59e0b] font-bold">0112 95 9005</p>
            </div>

            <!-- WhatsApp -->
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.386"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">WhatsApp</h3>
                <p class="text-[#f59e0b] font-bold">+94777506939</p>
            </div>

            <!-- Visit Store -->
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-[#f59e0b]/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Visit Store</h3>
                <p class="text-gray-400 text-sm">No.296/3D, Delpe Junction, Ragama</p>
            </div>
        </div>
        
        <div class="bg-[#1a1a1c] border border-green-500/30 rounded-xl p-6">
            <div class="flex items-center justify-center space-x-3 mb-4">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-green-400 font-medium">Quick Processing</p>
            </div>
            <p class="text-white text-lg font-semibold">Your order will be processed within 24 hours of payment confirmation</p>
        </div>
    </div>
</section>
@endsection
