@extends('layouts.app')

@section('title', 'My Orders - MSK COMPUTERS')
@section('description', 'View and track your MSK Computers orders, download invoices, and manage your purchase history.')

@section('content')
<div class="min-h-screen bg-[#0f0f0f] py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">My Orders</h1>
                <p class="text-gray-400">Track and manage your order history</p>
            </div>
            <a href="{{ route('user.dashboard') }}" 
               class="inline-flex items-center text-[#f59e0b] hover:text-[#d97706] transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-gradient-to-r from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6 mb-8">
            <form method="GET" action="{{ route('user.orders') }}" class="flex flex-wrap items-center gap-4">
                <!-- Search -->
                <div class="flex-1 min-w-64">
                    <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Search Orders</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search by order number..."
                           class="w-full px-4 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                    <select id="status" 
                            name="status"
                            class="px-4 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="flex items-end">
                    <button type="submit" 
                            class="px-6 py-2 bg-[#f59e0b] text-black rounded-lg hover:bg-[#d97706] transition-colors font-medium">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('user.orders') }}" 
                           class="ml-2 px-4 py-2 border border-gray-700 text-gray-300 rounded-lg hover:bg-gray-800 transition-colors">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Orders List -->
        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 overflow-hidden">
                        <!-- Order Header -->
                        <div class="px-6 py-4 border-b border-gray-800">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <h3 class="text-lg font-medium text-white">{{ $order->order_number }}</h3>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $order->status_badge }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $order->payment_status_badge }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-medium text-white">{{ $order->formatted_total }}</p>
                                    <p class="text-sm text-gray-400">{{ $order->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items Preview -->
                        <div class="px-6 py-4">
                            <div class="flex items-center space-x-4 mb-4">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <span class="text-sm text-gray-400">
                                    {{ $order->orderItems->count() }} {{ Str::plural('item', $order->orderItems->count()) }}
                                </span>
                                @if($order->shipping_address)
                                    <span class="text-gray-500">•</span>
                                    <span class="text-sm text-gray-400">{{ $order->shipping_city }}</span>
                                @endif
                            </div>

                            <!-- Item List -->
                            <div class="space-y-2">
                                @foreach($order->orderItems->take(3) as $item)
                                    <div class="flex items-center space-x-3 text-sm">
                                        <div class="w-8 h-8 bg-gray-800 rounded flex items-center justify-center">
                                            <span class="text-xs text-gray-400">{{ $item->quantity }}x</span>
                                        </div>
                                        <span class="flex-1 text-gray-300">{{ $item->product_name }}</span>
                                        <span class="text-white font-medium">{{ $item->formatted_total_price }}</span>
                                    </div>
                                @endforeach
                                @if($order->orderItems->count() > 3)
                                    <div class="text-sm text-gray-400">
                                        + {{ $order->orderItems->count() - 3 }} more items
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Order Actions -->
                        <div class="px-6 py-4 border-t border-gray-800 bg-gray-800/20">
                            <div class="flex items-center justify-between">
                                <div class="flex space-x-3">
                                    <a href="{{ route('user.orders.detail', $order->order_number) }}" 
                                       class="text-[#f59e0b] hover:text-[#d97706] text-sm font-medium transition-colors">
                                        View Details
                                    </a>
                                    @if($order->status === 'delivered')
                                        <form action="{{ route('user.orders.reorder', $order) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="text-[#f59e0b] hover:text-[#d97706] text-sm font-medium transition-colors">
                                                Reorder
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('orders.invoice', $order->order_number) }}" 
                                       class="text-gray-400 hover:text-white text-sm font-medium transition-colors">
                                        Download Invoice
                                    </a>
                                </div>
                                
                                @if($order->canBeCancelled())
                                    <form action="{{ route('user.orders.cancel', $order) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to cancel this order?')"
                                                class="text-red-400 hover:text-red-300 text-sm font-medium transition-colors">
                                            Cancel Order
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->appends(request()->query())->links('custom.pagination') }}
            </div>

        @else
            <!-- Empty State -->
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <h3 class="text-lg font-medium text-white mb-2">No orders found</h3>
                @if(request()->hasAny(['search', 'status']))
                    <p class="text-gray-400 mb-6">Try adjusting your search criteria or filters</p>
                    <a href="{{ route('user.orders') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-700 text-gray-300 rounded-lg hover:bg-gray-800 transition-colors">
                        Clear Filters
                    </a>
                @else
                    <p class="text-gray-400 mb-6">You haven't placed any orders yet</p>
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-black bg-[#f59e0b] hover:bg-[#d97706] transition-colors">
                        Start Shopping
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
