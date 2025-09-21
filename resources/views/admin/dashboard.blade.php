@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-8">
    
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Dashboard</h1>
            <p class="text-gray-400">Welcome to the MSK Computers admin panel</p>
        </div>
        <div class="text-right text-sm text-gray-400">
            <p>{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
            <p>{{ \Carbon\Carbon::now()->format('g:i A') }}</p>
        </div>
    </div>

    <!-- Daily Orders Highlight Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        
        <!-- Today's Orders -->
        <div class="bg-gradient-to-br from-primary-500/10 to-primary-600/5 border border-primary-500/20 rounded-xl p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Today's Orders</h2>
                    <p class="text-gray-300">{{ \Carbon\Carbon::today()->format('F j, Y') }}</p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-primary-400">{{ $stats['today_orders'] }}</div>
                    <div class="text-sm text-gray-400">Orders</div>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="text-center">
                    <div class="text-lg font-semibold text-white">{{ $stats['today_pending'] }}</div>
                    <div class="text-xs text-yellow-400">Pending</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-semibold text-white">{{ $stats['today_orders'] - $stats['today_pending'] }}</div>
                    <div class="text-xs text-green-400">Processed</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-semibold text-white">LKR {{ number_format($stats['today_revenue'], 0) }}</div>
                    <div class="text-xs text-primary-400">Revenue</div>
                </div>
            </div>
            
            <div class="flex gap-2">
                <a href="{{ route('admin.orders.index', ['filter' => 'today']) }}" 
                   class="flex-1 bg-primary-500/20 hover:bg-primary-500/30 text-primary-400 px-4 py-2 rounded-lg text-center text-sm font-medium transition-colors">
                    View All Today's Orders
                </a>
                @if($stats['today_pending'] > 0)
                <a href="{{ route('admin.orders.index', ['filter' => 'today', 'status' => 'pending']) }}" 
                   class="bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-400 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    {{ $stats['today_pending'] }} Pending
                </a>
                @endif
            </div>
        </div>

        <!-- Yesterday's Orders -->
        <div class="bg-gradient-to-br from-gray-500/10 to-gray-600/5 border border-gray-500/20 rounded-xl p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Yesterday's Orders</h2>
                    <p class="text-gray-300">{{ \Carbon\Carbon::yesterday()->format('F j, Y') }}</p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-300">{{ $stats['yesterday_orders'] }}</div>
                    <div class="text-sm text-gray-400">Orders</div>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="text-center">
                    <div class="text-lg font-semibold text-white">{{ $stats['yesterday_pending'] }}</div>
                    <div class="text-xs text-yellow-400">Pending</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-semibold text-white">{{ $stats['yesterday_orders'] - $stats['yesterday_pending'] }}</div>
                    <div class="text-xs text-green-400">Processed</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-semibold text-white">LKR {{ number_format($stats['yesterday_revenue'], 0) }}</div>
                    <div class="text-xs text-gray-400">Revenue</div>
                </div>
            </div>
            
            <div class="flex gap-2">
                <a href="{{ route('admin.orders.index', ['filter' => 'yesterday']) }}" 
                   class="flex-1 bg-gray-500/20 hover:bg-gray-500/30 text-gray-300 px-4 py-2 rounded-lg text-center text-sm font-medium transition-colors">
                    View All Yesterday's Orders
                </a>
                @if($stats['yesterday_pending'] > 0)
                <a href="{{ route('admin.orders.index', ['filter' => 'yesterday', 'status' => 'pending']) }}" 
                   class="bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-400 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    {{ $stats['yesterday_pending'] }} Pending
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Orders -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Total Orders</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($stats['total_orders']) }}</p>
                    <p class="text-sm text-green-400">+{{ $stats['weekly_orders'] }} this week</p>
                </div>
                <div class="p-3 bg-blue-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Pending Orders</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($stats['pending_orders']) }}</p>
                    <p class="text-sm text-yellow-400">Requires attention</p>
                </div>
                <div class="p-3 bg-yellow-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Total Customers</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($stats['total_customers']) }}</p>
                    <p class="text-sm text-green-400">Active users</p>
                </div>
                <div class="p-3 bg-green-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Total Revenue</p>
                    <p class="text-3xl font-bold text-white">LKR {{ number_format($stats['total_revenue'], 2) }}</p>
                    <p class="text-sm text-[#f59e0b]">LKR {{ number_format($stats['monthly_revenue'], 2) }} this month</p>
                </div>
                <div class="p-3 bg-[#f59e0b]/20 rounded-lg">
                    <svg class="w-8 h-8 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Data -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Sales Chart -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <h3 class="text-lg font-medium text-white mb-4">Monthly Sales (Last 6 Months)</h3>
            <div class="h-64">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Order Status Distribution -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <h3 class="text-lg font-medium text-white mb-4">Order Status Distribution</h3>
            <div class="h-64">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Today's and Yesterday's Orders Lists -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        
        <!-- Today's Orders List -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-white">Today's Orders ({{ $todayOrders->count() }})</h3>
                    <a href="{{ route('admin.orders.index', ['filter' => 'today']) }}" 
                       class="text-primary-400 hover:text-primary-300 text-sm font-medium transition-colors">
                        View All Today
                    </a>
                </div>
            </div>
            
            @if($todayOrders->count() > 0)
                <div class="divide-y divide-gray-800 max-h-96 overflow-y-auto">
                    @foreach($todayOrders->take(8) as $order)
                        <div class="px-6 py-4 hover:bg-gray-800/30 transition-colors">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p class="text-sm font-medium text-white">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-primary-400">
                                            #{{ $order->order_number ?? $order->id }}
                                        </a>
                                    </p>
                                    <p class="text-sm text-gray-400">{{ $order->customer_name ?? $order->customer_email }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-white">LKR {{ number_format($order->total_amount, 2) }}</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        @if($order->status == 'pending') bg-yellow-500/20 text-yellow-400
                                        @elseif($order->status == 'confirmed') bg-blue-500/20 text-blue-400
                                        @elseif($order->status == 'processing') bg-purple-500/20 text-purple-400
                                        @elseif($order->status == 'shipped') bg-indigo-500/20 text-indigo-400
                                        @elseif($order->status == 'delivered') bg-green-500/20 text-green-400
                                        @elseif($order->status == 'cancelled') bg-red-500/20 text-red-400
                                        @else bg-gray-500/20 text-gray-400 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span>{{ $order->orderItems->count() ?? 0 }} items</span>
                                <span>{{ $order->created_at->format('g:i A') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-8 text-center">
                    <div class="text-gray-400 mb-2">
                        <svg class="w-12 h-12 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <p class="text-gray-400">No orders today yet</p>
                    <p class="text-sm text-gray-500 mt-1">Orders will appear here as they come in</p>
                </div>
            @endif
        </div>

        <!-- Yesterday's Orders List -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-white">Yesterday's Orders ({{ $yesterdayOrders->count() }})</h3>
                    <a href="{{ route('admin.orders.index', ['filter' => 'yesterday']) }}" 
                       class="text-gray-400 hover:text-gray-300 text-sm font-medium transition-colors">
                        View All Yesterday
                    </a>
                </div>
            </div>
            
            @if($yesterdayOrders->count() > 0)
                <div class="divide-y divide-gray-800 max-h-96 overflow-y-auto">
                    @foreach($yesterdayOrders->take(8) as $order)
                        <div class="px-6 py-4 hover:bg-gray-800/30 transition-colors">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p class="text-sm font-medium text-white">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-gray-300">
                                            #{{ $order->order_number ?? $order->id }}
                                        </a>
                                    </p>
                                    <p class="text-sm text-gray-400">{{ $order->customer_name ?? $order->customer_email }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-white">LKR {{ number_format($order->total_amount, 2) }}</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        @if($order->status == 'pending') bg-yellow-500/20 text-yellow-400
                                        @elseif($order->status == 'confirmed') bg-blue-500/20 text-blue-400
                                        @elseif($order->status == 'processing') bg-purple-500/20 text-purple-400
                                        @elseif($order->status == 'shipped') bg-indigo-500/20 text-indigo-400
                                        @elseif($order->status == 'delivered') bg-green-500/20 text-green-400
                                        @elseif($order->status == 'cancelled') bg-red-500/20 text-red-400
                                        @else bg-gray-500/20 text-gray-400 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span>{{ $order->orderItems->count() ?? 0 }} items</span>
                                <span>{{ $order->created_at->format('g:i A') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-8 text-center">
                    <div class="text-gray-400 mb-2">
                        <svg class="w-12 h-12 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <p class="text-gray-400">No orders yesterday</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Orders and Top Products -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent Orders -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-white">Recent Orders</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-[#f59e0b] hover:text-[#d97706] text-sm font-medium transition-colors">
                        View All
                    </a>
                </div>
            </div>
            
            @if($recentOrders->count() > 0)
                <div class="divide-y divide-gray-800">
                    @foreach($recentOrders->take(5) as $order)
                        <div class="px-6 py-4 hover:bg-gray-800/30 transition-colors">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-white">{{ $order->order_number }}</p>
                                    <p class="text-sm text-gray-400">{{ $order->customer_name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-white">{{ $order->formatted_total }}</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status_badge }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-8 text-center">
                    <p class="text-gray-400">No orders yet</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        @include('components.dashboard-quick-actions')
    </div>

    <!-- Recent Customers -->
    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-white">Recent Customers</h3>
                <a href="{{ route('admin.users.index') }}" class="text-[#f59e0b] hover:text-[#d97706] text-sm font-medium transition-colors">
                    View All
                </a>
            </div>
        </div>
        
        @if($recentCustomers->count() > 0)
            <div class="divide-y divide-gray-800">
                @foreach($recentCustomers as $customer)
                    <div class="px-6 py-4 hover:bg-gray-800/30 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img class="w-8 h-8 rounded-full" src="{{ $customer->avatar_url }}" alt="{{ $customer->name }}">
                                <div>
                                    <p class="text-sm font-medium text-white">{{ $customer->name }}</p>
                                    <p class="text-sm text-gray-400">{{ $customer->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-400">{{ $customer->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="px-6 py-8 text-center">
                <p class="text-gray-400">No customers yet</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Sales Chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
const salesData = @json($monthlySales);

new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: salesData.map(item => `${item.year}-${String(item.month).padStart(2, '0')}`),
        datasets: [{
            label: 'Revenue (LKR)',
            data: salesData.map(item => item.total),
            borderColor: '#f59e0b',
            backgroundColor: 'rgba(245, 158, 11, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    color: '#ffffff'
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#9ca3af',
                    callback: function(value) {
                        return 'LKR ' + value.toLocaleString();
                    }
                },
                grid: {
                    color: '#374151'
                }
            },
            x: {
                ticks: {
                    color: '#9ca3af'
                },
                grid: {
                    color: '#374151'
                }
            }
        }
    }
});

// Order Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusData = @json($orderStatusData);

new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: Object.keys(statusData).map(status => status.charAt(0).toUpperCase() + status.slice(1)),
        datasets: [{
            data: Object.values(statusData),
            backgroundColor: [
                '#f59e0b', // pending
                '#3b82f6', // confirmed
                '#8b5cf6', // processing
                '#06b6d4', // shipped
                '#10b981', // delivered
                '#ef4444', // cancelled
                '#6b7280'  // refunded
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: '#ffffff',
                    padding: 20
                }
            }
        }
    }
});
</script>
@endpush
