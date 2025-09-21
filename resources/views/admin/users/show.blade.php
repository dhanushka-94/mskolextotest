@extends('admin.layout')

@section('title', 'User Details - ' . $user->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white">User Details</h1>
            <p class="text-gray-400 mt-1">Viewing {{ $user->name }}'s profile</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.users.edit', $user) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg transition-colors">
                <i class="fas fa-edit mr-2"></i>Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Users
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Profile -->
        <div class="lg:col-span-1">
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="text-center">
                    <img class="h-32 w-32 rounded-full mx-auto object-cover mb-4" 
                         src="{{ $user->avatar_url }}" 
                         alt="{{ $user->name }}">
                    <h3 class="text-xl font-semibold text-white">{{ $user->name }}</h3>
                    <p class="text-gray-400">{{ $user->email }}</p>
                    
                    <div class="flex justify-center space-x-4 mt-4">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                            {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : '' }}
                            {{ $user->role === 'customer' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $user->role === 'staff' ? 'bg-green-100 text-green-800' : '' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                            {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $user->status === 'inactive' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $user->status === 'banned' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Phone</label>
                        <p class="text-white">{{ $user->phone ?: 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Date of Birth</label>
                        <p class="text-white">{{ $user->date_of_birth ? $user->date_of_birth->format('M d, Y') : 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Gender</label>
                        <p class="text-white">{{ $user->gender ? ucfirst($user->gender) : 'Not specified' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Member Since</label>
                        <p class="text-white">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Last Login</label>
                        <p class="text-white">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Statistics & Orders -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-800 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-shopping-cart text-2xl text-blue-400"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-400">Total Orders</p>
                            <p class="text-2xl font-semibold text-white">{{ $userStats['total_orders'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-800 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-dollar-sign text-2xl text-green-400"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-400">Total Spent</p>
                            <p class="text-2xl font-semibold text-white">Rs. {{ number_format($userStats['total_spent'], 2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-800 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-chart-line text-2xl text-yellow-400"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-400">Avg Order</p>
                            <p class="text-2xl font-semibold text-white">Rs. {{ number_format($userStats['average_order'] ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-gray-800 rounded-lg">
                <div class="px-6 py-4 border-b border-gray-700">
                    <h3 class="text-lg font-medium text-white">Recent Orders</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                            @forelse($user->orders->take(10) as $order)
                                <tr class="hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-white">#{{ $order->order_number }}</div>
                                        <div class="text-sm text-gray-400">{{ $order->orderItems->count() }} items</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                        Rs. {{ number_format($order->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $order->status === 'shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.orders.show', $order) }}" 
                                           class="text-blue-400 hover:text-blue-300">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                        <i class="fas fa-shopping-cart text-3xl mb-3"></i>
                                        <p>No orders yet</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- User Addresses -->
            @if($user->addresses->count() > 0)
                <div class="bg-gray-800 rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-700">
                        <h3 class="text-lg font-medium text-white">Saved Addresses</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($user->addresses as $address)
                                <div class="bg-gray-700 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-medium text-white">{{ ucfirst($address->type) }} Address</h4>
                                        @if($address->is_default)
                                            <span class="bg-primary-500 text-white text-xs px-2 py-1 rounded">Default</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-300">{{ $address->name }}</p>
                                    <p class="text-sm text-gray-300">{{ $address->address_line_1 }}</p>
                                    @if($address->address_line_2)
                                        <p class="text-sm text-gray-300">{{ $address->address_line_2 }}</p>
                                    @endif
                                    <p class="text-sm text-gray-300">{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                                    <p class="text-sm text-gray-300">{{ $address->country }}</p>
                                    @if($address->contact_phone)
                                        <p class="text-sm text-gray-400 mt-2">{{ $address->contact_phone }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
