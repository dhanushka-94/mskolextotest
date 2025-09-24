@extends('admin.layout')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white">Analytics Dashboard</h1>
            <p class="text-gray-400 mt-1">Sales performance and business insights</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
    </div>

    <!-- Enhanced Date Range Filters -->
    <div class="bg-gradient-to-r from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
        <form method="GET" action="{{ route('admin.analytics') }}">
            <div class="space-y-4">
                <!-- Filter Row -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Date From -->
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-300 mb-2">Date From</label>
                        <input type="date" 
                               id="date_from" 
                               name="date_from" 
                               value="{{ request('date_from') }}"
                               max="{{ now()->format('Y-m-d') }}"
                               class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-300 mb-2">Date To</label>
                        <input type="date" 
                               id="date_to" 
                               name="date_to" 
                               value="{{ request('date_to') }}"
                               max="{{ now()->format('Y-m-d') }}"
                               class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                    </div>

                    <!-- Quick Presets -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Quick Periods</label>
                        <select id="date_preset" class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                            <option value="">Select Period</option>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="this_week">This Week</option>
                            <option value="last_week">Last Week</option>
                            <option value="this_month">This Month</option>
                            <option value="last_month">Last Month</option>
                            <option value="last_7_days">Last 7 Days</option>
                            <option value="last_30_days">Last 30 Days</option>
                            <option value="last_90_days">Last 90 Days</option>
                            <option value="last_year">Last Year</option>
                        </select>
                    </div>

                    <!-- Legacy Period (for backward compatibility) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Legacy Periods</label>
                        <select name="period" class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                            <option value="">Custom Range</option>
                            <option value="7" {{ $period == '7' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="30" {{ $period == '30' ? 'selected' : '' }}>Last 30 Days</option>
                            <option value="90" {{ $period == '90' ? 'selected' : '' }}>Last 90 Days</option>
                            <option value="365" {{ $period == '365' ? 'selected' : '' }}>Last Year</option>
                        </select>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="px-4 py-2 bg-[#f59e0b] text-black rounded-lg hover:bg-[#d97706] transition-colors text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Analyze
                        </button>
                        @if(request()->hasAny(['date_from', 'date_to', 'period']))
                            <a href="{{ route('admin.analytics') }}" class="px-4 py-2 border border-gray-700 text-gray-300 rounded-lg hover:bg-gray-800 transition-colors text-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Reset
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Active Filters Display -->
                @if(request()->hasAny(['date_from', 'date_to', 'period']))
                    <div class="flex flex-wrap gap-2 pt-2 border-t border-gray-700">
                        <span class="text-sm text-gray-400 mr-2">Active Period:</span>
                        
                        @if(request('date_from') || request('date_to'))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-900/50 text-blue-200 border border-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                @if(request('date_from') && request('date_to'))
                                    {{ request('date_from') }} to {{ request('date_to') }}
                                @elseif(request('date_from'))
                                    From {{ request('date_from') }}
                                @else
                                    Until {{ request('date_to') }}
                                @endif
                                <a href="{{ route('admin.analytics', request()->except(['date_from', 'date_to'])) }}" class="ml-2 text-blue-300 hover:text-blue-100">×</a>
                            </span>
                        @elseif(request('period'))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-900/50 text-green-200 border border-green-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Last {{ request('period') }} Days
                                <a href="{{ route('admin.analytics', request()->except('period')) }}" class="ml-2 text-green-300 hover:text-green-100">×</a>
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Revenue -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Total Revenue</p>
                    <p class="text-2xl font-bold">Rs. {{ number_format($revenueData->sum('revenue'), 2) }}</p>
                    <p class="text-green-100 text-sm mt-1">Last {{ $period }} days</p>
                </div>
                <div class="text-green-200">
                    <i class="fas fa-dollar-sign text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Orders</p>
                    <p class="text-2xl font-bold">{{ number_format($revenueData->sum('orders')) }}</p>
                    <p class="text-blue-100 text-sm mt-1">Last {{ $period }} days</p>
                </div>
                <div class="text-blue-200">
                    <i class="fas fa-shopping-cart text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Average Order Value -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Avg Order Value</p>
                    @php
                        $totalOrders = $revenueData->sum('orders');
                        $avgOrder = $totalOrders > 0 ? $revenueData->sum('revenue') / $totalOrders : 0;
                    @endphp
                    <p class="text-2xl font-bold">Rs. {{ number_format($avgOrder, 2) }}</p>
                    <p class="text-purple-100 text-sm mt-1">Per order</p>
                </div>
                <div class="text-purple-200">
                    <i class="fas fa-chart-line text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- New Customers -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm">New Customers</p>
                    <p class="text-2xl font-bold">{{ $customerInsights['new_customers'] }}</p>
                    <p class="text-yellow-100 text-sm mt-1">Last {{ $period }} days</p>
                </div>
                <div class="text-yellow-200">
                    <i class="fas fa-users text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="bg-gray-800 rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-white">Revenue Trends</h3>
            <div class="text-sm text-gray-400">Last {{ $period }} days</div>
        </div>
        
        <!-- Simple Chart -->
        <div class="h-64 bg-gray-700 rounded-lg flex items-end justify-between p-4 space-x-1">
            @if($revenueData->count() > 0)
                @php
                    $maxRevenue = $revenueData->max('revenue');
                    $chartData = $revenueData->take(20); // Show last 20 days for better visibility
                @endphp
                @foreach($chartData as $data)
                    @php
                        $height = $maxRevenue > 0 ? ($data->revenue / $maxRevenue) * 100 : 0;
                    @endphp
                    <div class="flex flex-col items-center group">
                        <div class="bg-primary-500 rounded-t group-hover:bg-primary-400 transition-colors relative"
                             style="height: {{ max($height, 5) }}%; width: 20px;"
                             title="Date: {{ $data->date }}, Revenue: Rs. {{ number_format($data->revenue, 2) }}">
                        </div>
                        <div class="text-xs text-gray-400 mt-2 transform -rotate-45 origin-left">
                            {{ \Carbon\Carbon::parse($data->date)->format('M d') }}
                        </div>
                    </div>
                @endforeach
            @else
                <div class="w-full text-center text-gray-400">
                    <i class="fas fa-chart-bar text-4xl mb-4"></i>
                    <p>No revenue data available for the selected period</p>
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Products -->
        <div class="bg-gray-800 rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-white">Top Selling Products</h3>
                <span class="text-sm text-gray-400">Last {{ $period }} days</span>
            </div>
            
            @if($productPerformance->count() > 0)
                <div class="space-y-4">
                    @foreach($productPerformance->take(10) as $index => $product)
                        <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <p class="text-white font-medium">{{ $product->product_name }}</p>
                                    <p class="text-gray-400 text-sm">{{ $product->total_sold }} units sold</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-white font-semibold">Rs. {{ number_format($product->revenue, 2) }}</p>
                                <p class="text-gray-400 text-sm">Revenue</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-400 py-8">
                    <i class="fas fa-box text-4xl mb-4"></i>
                    <p>No product sales data available</p>
                </div>
            @endif
        </div>

        <!-- Customer Insights -->
        <div class="bg-gray-800 rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-white">Customer Insights</h3>
                <span class="text-sm text-gray-400">Last {{ $period }} days</span>
            </div>
            
            <div class="space-y-6">
                <!-- New vs Returning Customers -->
                <div class="bg-gray-700 rounded-lg p-4">
                    <h4 class="text-white font-medium mb-3">Customer Types</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300">New Customers</span>
                            <span class="text-white font-semibold">{{ $customerInsights['new_customers'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300">Repeat Customers</span>
                            <span class="text-white font-semibold">{{ $customerInsights['repeat_customers'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Customer Acquisition Rate -->
                <div class="bg-gray-700 rounded-lg p-4">
                    <h4 class="text-white font-medium mb-3">Growth Metrics</h4>
                    <div class="space-y-3">
                        @php
                            $totalCustomers = $customerInsights['new_customers'] + $customerInsights['repeat_customers'];
                            $newCustomerRate = $totalCustomers > 0 ? ($customerInsights['new_customers'] / $totalCustomers) * 100 : 0;
                            $repeatRate = $totalCustomers > 0 ? ($customerInsights['repeat_customers'] / $totalCustomers) * 100 : 0;
                        @endphp
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300">New Customer Rate</span>
                            <span class="text-green-400 font-semibold">{{ number_format($newCustomerRate, 1) }}%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300">Repeat Purchase Rate</span>
                            <span class="text-blue-400 font-semibold">{{ number_format($repeatRate, 1) }}%</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="pt-4">
                    <h4 class="text-white font-medium mb-3">Quick Actions</h4>
                    <div class="space-y-2">
                        <a href="{{ route('admin.orders.index') }}" 
                           class="block w-full text-center bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-list mr-2"></i>View All Orders
                        </a>
                        <a href="{{ route('admin.users.index') }}" 
                           class="block w-full text-center bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-users mr-2"></i>Manage Customers
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Insights -->
    <div class="bg-gray-800 rounded-lg p-6">
        <h3 class="text-xl font-semibold text-white mb-6">Business Summary</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-primary-400">
                    Rs. {{ number_format($revenueData->avg('revenue'), 2) }}
                </div>
                <div class="text-gray-400 mt-1">Average Daily Revenue</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-400">
                    {{ number_format($revenueData->avg('orders'), 1) }}
                </div>
                <div class="text-gray-400 mt-1">Average Daily Orders</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-400">
                    {{ $productPerformance->count() }}
                </div>
                <div class="text-gray-400 mt-1">Products Sold</div>
            </div>
        </div>
    </div>
</div>

<script>
// Date range functionality for Analytics Dashboard
document.addEventListener('DOMContentLoaded', function() {
    const dateFrom = document.getElementById('date_from');
    const dateTo = document.getElementById('date_to');
    const datePreset = document.getElementById('date_preset');

    // Date validation - ensure 'from' is not after 'to'
    function validateDateRange() {
        if (dateFrom.value && dateTo.value) {
            if (new Date(dateFrom.value) > new Date(dateTo.value)) {
                dateTo.value = dateFrom.value;
            }
        }
    }

    // Update date_to minimum based on date_from
    if (dateFrom) {
        dateFrom.addEventListener('change', function() {
            if (this.value) {
                dateTo.min = this.value;
            } else {
                dateTo.removeAttribute('min');
            }
            validateDateRange();
        });
    }

    // Update date_from maximum based on date_to
    if (dateTo) {
        dateTo.addEventListener('change', function() {
            if (this.value) {
                dateFrom.max = this.value;
            } else {
                dateFrom.max = '{{ now()->format('Y-m-d') }}';
            }
            validateDateRange();
        });
    }

    // Quick date presets functionality
    if (datePreset) {
        datePreset.addEventListener('change', function() {
            const today = new Date();
            const preset = this.value;
            
            // Clear preset selection after use
            setTimeout(() => this.value = '', 100);

            switch(preset) {
                case 'today':
                    const todayStr = today.toISOString().split('T')[0];
                    dateFrom.value = todayStr;
                    dateTo.value = todayStr;
                    break;

                case 'yesterday':
                    const yesterday = new Date(today);
                    yesterday.setDate(yesterday.getDate() - 1);
                    const yesterdayStr = yesterday.toISOString().split('T')[0];
                    dateFrom.value = yesterdayStr;
                    dateTo.value = yesterdayStr;
                    break;

                case 'this_week':
                    const thisWeekStart = new Date(today);
                    thisWeekStart.setDate(today.getDate() - today.getDay());
                    dateFrom.value = thisWeekStart.toISOString().split('T')[0];
                    dateTo.value = today.toISOString().split('T')[0];
                    break;

                case 'last_week':
                    const lastWeekEnd = new Date(today);
                    lastWeekEnd.setDate(today.getDate() - today.getDay() - 1);
                    const lastWeekStart = new Date(lastWeekEnd);
                    lastWeekStart.setDate(lastWeekEnd.getDate() - 6);
                    dateFrom.value = lastWeekStart.toISOString().split('T')[0];
                    dateTo.value = lastWeekEnd.toISOString().split('T')[0];
                    break;

                case 'this_month':
                    const thisMonthStart = new Date(today.getFullYear(), today.getMonth(), 1);
                    dateFrom.value = thisMonthStart.toISOString().split('T')[0];
                    dateTo.value = today.toISOString().split('T')[0];
                    break;

                case 'last_month':
                    const lastMonthStart = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                    const lastMonthEnd = new Date(today.getFullYear(), today.getMonth(), 0);
                    dateFrom.value = lastMonthStart.toISOString().split('T')[0];
                    dateTo.value = lastMonthEnd.toISOString().split('T')[0];
                    break;

                case 'last_7_days':
                    const sevenDaysAgo = new Date(today);
                    sevenDaysAgo.setDate(today.getDate() - 7);
                    dateFrom.value = sevenDaysAgo.toISOString().split('T')[0];
                    dateTo.value = today.toISOString().split('T')[0];
                    break;

                case 'last_30_days':
                    const thirtyDaysAgo = new Date(today);
                    thirtyDaysAgo.setDate(today.getDate() - 30);
                    dateFrom.value = thirtyDaysAgo.toISOString().split('T')[0];
                    dateTo.value = today.toISOString().split('T')[0];
                    break;

                case 'last_90_days':
                    const ninetyDaysAgo = new Date(today);
                    ninetyDaysAgo.setDate(today.getDate() - 90);
                    dateFrom.value = ninetyDaysAgo.toISOString().split('T')[0];
                    dateTo.value = today.toISOString().split('T')[0];
                    break;

                case 'last_year':
                    const oneYearAgo = new Date(today);
                    oneYearAgo.setFullYear(today.getFullYear() - 1);
                    dateFrom.value = oneYearAgo.toISOString().split('T')[0];
                    dateTo.value = today.toISOString().split('T')[0];
                    break;
            }

            // Trigger change events to update validation
            if (dateFrom.value) {
                dateFrom.dispatchEvent(new Event('change'));
            }
            if (dateTo.value) {
                dateTo.dispatchEvent(new Event('change'));
            }
        });
    }

    // Auto-submit on preset selection for better UX
    if (datePreset) {
        datePreset.addEventListener('change', function() {
            if (this.value) {
                setTimeout(() => {
                    document.querySelector('form').submit();
                }, 200);
            }
        });
    }
});

// Auto-refresh every 5 minutes (only if no custom date filter is applied)
@if(!request()->hasAny(['date_from', 'date_to']))
setTimeout(function() {
    window.location.reload();
}, 300000);
@endif
</script>
@endsection
