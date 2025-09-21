@extends('layouts.app')

@section('title', 'My Addresses - MSK COMPUTERS')
@section('description', 'Manage your delivery addresses for faster checkout at MSK Computers.')

@section('content')
<div class="min-h-screen bg-[#0f0f0f] py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">My Addresses</h1>
                <p class="text-gray-400">Manage your delivery addresses for faster checkout</p>
            </div>
            <a href="{{ route('user.dashboard') }}" 
               class="inline-flex items-center text-[#f59e0b] hover:text-[#d97706] transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Dashboard
            </a>
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

        <!-- Add New Address Button -->
        <div class="mb-8">
            <button onclick="toggleAddressForm()" 
                    class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-black bg-gradient-to-r from-[#f59e0b] to-[#fbbf24] hover:from-[#d97706] hover:to-[#f59e0b] transition-all duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add New Address
            </button>
        </div>

        <!-- Add Address Form -->
        <div id="address-form" class="hidden bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6 mb-8">
            <h3 class="text-lg font-medium text-white mb-4">Add New Address</h3>
            
            <form action="{{ route('user.addresses.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Address Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Address Name</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               placeholder="e.g., Home, Office"
                               value="{{ old('name') }}" 
                               required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                    </div>

                    <!-- Address Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-300 mb-2">Address Type</label>
                        <select id="type" 
                                name="type" 
                                required
                                class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            <option value="shipping">Shipping Address</option>
                            <option value="billing">Billing Address</option>
                        </select>
                    </div>

                    <!-- Contact Name -->
                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-gray-300 mb-2">Contact Name</label>
                        <input type="text" 
                               id="contact_name" 
                               name="contact_name" 
                               value="{{ old('contact_name', Auth::user()->name) }}" 
                               required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                    </div>

                    <!-- Contact Phone -->
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-300 mb-2">Contact Phone</label>
                        <input type="tel" 
                               id="contact_phone" 
                               name="contact_phone" 
                               value="{{ old('contact_phone', Auth::user()->phone) }}" 
                               required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                    </div>

                    <!-- Address Line 1 -->
                    <div class="md:col-span-2">
                        <label for="address_line_1" class="block text-sm font-medium text-gray-300 mb-2">Address Line 1</label>
                        <input type="text" 
                               id="address_line_1" 
                               name="address_line_1" 
                               value="{{ old('address_line_1') }}" 
                               required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                    </div>

                    <!-- Address Line 2 -->
                    <div class="md:col-span-2">
                        <label for="address_line_2" class="block text-sm font-medium text-gray-300 mb-2">Address Line 2 (Optional)</label>
                        <input type="text" 
                               id="address_line_2" 
                               name="address_line_2" 
                               value="{{ old('address_line_2') }}"
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-300 mb-2">City</label>
                        <input type="text" 
                               id="city" 
                               name="city" 
                               value="{{ old('city') }}" 
                               required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                    </div>

                    <!-- State -->
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-300 mb-2">State/Province</label>
                        <input type="text" 
                               id="state" 
                               name="state" 
                               value="{{ old('state') }}" 
                               required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-300 mb-2">Postal Code</label>
                        <input type="text" 
                               id="postal_code" 
                               name="postal_code" 
                               value="{{ old('postal_code') }}" 
                               required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                    </div>

                    <!-- Country -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-300 mb-2">Country</label>
                        <input type="text" 
                               id="country" 
                               name="country" 
                               value="{{ old('country', 'Sri Lanka') }}"
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                    </div>

                    <!-- Default Address -->
                    <div class="md:col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_default" 
                                   value="1"
                                   class="h-4 w-4 text-[#f59e0b] focus:ring-[#f59e0b] border-gray-700 rounded bg-[#0f0f0f]">
                            <span class="ml-2 text-sm text-gray-300">Set as default address</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center space-x-4 mt-6">
                    <button type="submit" 
                            class="px-6 py-3 bg-[#f59e0b] text-black rounded-lg hover:bg-[#d97706] transition-colors font-medium">
                        Save Address
                    </button>
                    <button type="button" 
                            onclick="toggleAddressForm()"
                            class="px-6 py-3 border border-gray-700 text-gray-300 rounded-lg hover:bg-gray-800 transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Addresses List -->
        @if($addresses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($addresses as $address)
                    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6 relative">
                        
                        <!-- Address Header -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <h3 class="text-lg font-medium text-white">{{ $address->name }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $address->type === 'shipping' ? 'bg-blue-900/30 text-blue-300 border border-blue-800' : 'bg-purple-900/30 text-purple-300 border border-purple-800' }}">
                                    {{ ucfirst($address->type) }}
                                </span>
                                @if($address->is_default)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#f59e0b]/20 text-[#f59e0b] border border-[#f59e0b]/30">
                                        Default
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Actions Dropdown -->
                            <div class="relative">
                                <button onclick="toggleDropdown('dropdown-{{ $address->id }}')" 
                                        class="text-gray-400 hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                    </svg>
                                </button>
                                
                                <div id="dropdown-{{ $address->id }}" class="hidden absolute right-0 mt-2 w-48 bg-black border border-gray-800 rounded-lg shadow-xl z-10">
                                    <div class="py-1">
                                        @if(!$address->is_default)
                                            <form action="{{ route('user.addresses.default', $address) }}" method="POST" class="block">
                                                @csrf
                                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-[#f59e0b] transition-colors">
                                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Set as Default
                                                </button>
                                            </form>
                                        @endif
                                        <button onclick="editAddress({{ $address->id }})" class="flex items-center w-full px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-[#f59e0b] transition-colors">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </button>
                                        <form action="{{ route('user.addresses.delete', $address) }}" method="POST" class="block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Are you sure you want to delete this address?')"
                                                    class="flex items-center w-full px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-red-400 transition-colors">
                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address Details -->
                        <div class="space-y-2">
                            <p class="text-white font-medium">{{ $address->contact_name }}</p>
                            <p class="text-gray-300">{{ $address->contact_phone }}</p>
                            <div class="text-gray-300 text-sm" style="white-space: pre-line;">{{ $address->full_address }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                <h3 class="text-lg font-medium text-white mb-2">No addresses saved</h3>
                <p class="text-gray-400 mb-6">Add your delivery addresses for faster checkout</p>
                <button onclick="toggleAddressForm()" 
                        class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-black bg-[#f59e0b] hover:bg-[#d97706] transition-colors">
                    Add Your First Address
                </button>
            </div>
        @endif
    </div>
</div>

<script>
function toggleAddressForm() {
    const form = document.getElementById('address-form');
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        form.scrollIntoView({ behavior: 'smooth' });
    } else {
        form.classList.add('hidden');
    }
}

function toggleDropdown(dropdownId) {
    // Close all other dropdowns
    const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
    allDropdowns.forEach(dropdown => {
        if (dropdown.id !== dropdownId) {
            dropdown.classList.add('hidden');
        }
    });
    
    // Toggle the clicked dropdown
    const dropdown = document.getElementById(dropdownId);
    dropdown.classList.toggle('hidden');
}

function editAddress(addressId) {
    // Implementation for edit functionality would go here
    alert('Edit functionality would be implemented here');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('[onclick^="toggleDropdown"]') && !event.target.closest('[id^="dropdown-"]')) {
        const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
        allDropdowns.forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});
</script>
@endsection
