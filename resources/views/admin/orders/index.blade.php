@extends('admin.layout')

@section('title', 'Order Management')

@section('content')
<div class="space-y-6">
    
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Order Management</h1>
            <p class="text-gray-400">Manage and track all customer orders</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.orders.create') }}" 
               class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors">
                <i class="fas fa-plus mr-2"></i>Create Order
            </a>
            <a href="{{ route('admin.orders.statistics') }}" 
               class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-chart-bar mr-2"></i>Statistics
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-gradient-to-r from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <div class="space-y-4">
                <!-- First Row: Search, Status, Payment, View Status -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Search</label>
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Order number, customer, email, mobile..."
                               class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                        <select id="status" name="status" class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <!-- Payment Status -->
                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-300 mb-2">Payment</label>
                        <select id="payment_status" name="payment_status" class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                            <option value="">All Payments</option>
                            <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>

                    <!-- View Status -->
                    <div>
                        <label for="view_status" class="block text-sm font-medium text-gray-300 mb-2">View Status</label>
                        <select id="view_status" name="view_status" class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                            <option value="">All Orders</option>
                            <option value="unviewed" {{ request('view_status') === 'unviewed' ? 'selected' : '' }}>🔵 Unviewed Only</option>
                            <option value="viewed" {{ request('view_status') === 'viewed' ? 'selected' : '' }}>👁️ Viewed Only</option>
                        </select>
                    </div>
                </div>

                <!-- Second Row: Date Range and Quick Filters -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
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

                    <!-- Quick Date Presets -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Quick Filters</label>
                        <select id="date_preset" class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                            <option value="">Select Period</option>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="this_week">This Week</option>
                            <option value="last_week">Last Week</option>
                            <option value="this_month">This Month</option>
                            <option value="last_month">Last Month</option>
                            <option value="last_30_days">Last 30 Days</option>
                            <option value="last_90_days">Last 90 Days</option>
                        </select>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="px-4 py-2 bg-[#f59e0b] text-black rounded-lg hover:bg-[#d97706] transition-colors text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                            </svg>
                            Filter
                        </button>
                        @if(request()->hasAny(['search', 'status', 'payment_status', 'view_status', 'date_from', 'date_to']))
                            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 border border-gray-700 text-gray-300 rounded-lg hover:bg-gray-800 transition-colors text-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Clear
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Active Filters Display -->
                @if(request()->hasAny(['search', 'status', 'payment_status', 'view_status', 'date_from', 'date_to']))
                    <div class="flex flex-wrap gap-2 pt-2 border-t border-gray-700">
                        <span class="text-sm text-gray-400 mr-2">Active Filters:</span>
                        
                        @if(request('search'))
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-900/50 text-blue-200 border border-blue-700">
                                Search: "{{ request('search') }}"
                                <a href="{{ route('admin.orders.index', request()->except('search')) }}" class="ml-1 text-blue-300 hover:text-blue-100">×</a>
                            </span>
                        @endif
                        
                        @if(request('status'))
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-purple-900/50 text-purple-200 border border-purple-700">
                                Status: {{ ucfirst(request('status')) }}
                                <a href="{{ route('admin.orders.index', request()->except('status')) }}" class="ml-1 text-purple-300 hover:text-purple-100">×</a>
                            </span>
                        @endif
                        
                        @if(request('payment_status'))
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-900/50 text-green-200 border border-green-700">
                                Payment: {{ ucfirst(request('payment_status')) }}
                                <a href="{{ route('admin.orders.index', request()->except('payment_status')) }}" class="ml-1 text-green-300 hover:text-green-100">×</a>
                            </span>
                        @endif

                        @if(request('view_status'))
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-cyan-900/50 text-cyan-200 border border-cyan-700">
                                View: {{ request('view_status') === 'unviewed' ? '🔵 Unviewed' : '👁️ Viewed' }}
                                <a href="{{ route('admin.orders.index', request()->except('view_status')) }}" class="ml-1 text-cyan-300 hover:text-cyan-100">×</a>
                            </span>
                        @endif
                        
                        @if(request('date_from') || request('date_to'))
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-orange-900/50 text-orange-200 border border-orange-700">
                                Date: 
                                @if(request('date_from') && request('date_to'))
                                    {{ request('date_from') }} to {{ request('date_to') }}
                                @elseif(request('date_from'))
                                    From {{ request('date_from') }}
                                @else
                                    Until {{ request('date_to') }}
                                @endif
                                <a href="{{ route('admin.orders.index', request()->except(['date_from', 'date_to'])) }}" class="ml-1 text-orange-300 hover:text-orange-100">×</a>
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 overflow-hidden">
        
        <!-- Bulk Actions Form - Wraps the entire table -->
        <form id="bulk-form" action="{{ route('admin.orders.bulk-action') }}" method="POST">
            @csrf
            
            <!-- Bulk Actions Controls -->
            <div class="px-6 py-4 border-b border-gray-800 bg-gray-800/20">
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="checkbox" id="select-all" class="h-4 w-4 text-[#f59e0b] focus:ring-[#f59e0b] border-gray-700 rounded bg-[#0f0f0f]">
                        <span class="ml-2 text-sm text-gray-300">Select All</span>
                    </label>
                    
                    <select name="action" id="bulk-action-select" class="px-3 py-1 bg-[#0f0f0f] border border-gray-700 rounded text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                        <option value="">Bulk Actions</option>
                        <option value="update_status">Update Status</option>
                        <option value="export">Export Selected</option>
                        <option value="delete">Delete</option>
                    </select>
                    
                    <select name="bulk_status" id="bulk-status-select" class="px-3 py-1 bg-[#0f0f0f] border border-gray-700 rounded text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]" style="display: none;">
                        <option value="confirmed">Confirmed</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    
                    <button type="submit" id="bulk-submit-btn" class="px-4 py-1 bg-[#f59e0b] text-black rounded hover:bg-[#d97706] transition-colors text-sm font-medium">
                        Apply
                    </button>
                    
                    <span id="selected-count" class="text-sm text-gray-400 ml-4" style="display: none;">
                        <span id="count-number">0</span> orders selected
                    </span>
                </div>
            </div>

        @if($orders->count() > 0)
            <!-- Orders Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-800/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                <input type="checkbox" class="h-4 w-4 text-[#f59e0b] focus:ring-[#f59e0b] border-gray-700 rounded bg-[#0f0f0f]">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Order</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Payment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-800/30 transition-colors {{ !$order->isViewedByAdmin() ? 'bg-blue-900/20 border-l-4 border-blue-500' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" name="selected_orders[]" value="{{ $order->id }}" class="order-checkbox h-4 w-4 text-[#f59e0b] focus:ring-[#f59e0b] border-gray-700 rounded bg-[#0f0f0f]">
                                        @if(!$order->isViewedByAdmin())
                                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse" title="Unviewed order"></div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div>
                                            <div class="flex items-center space-x-2">
                                                <div class="text-sm font-medium {{ !$order->isViewedByAdmin() ? 'text-blue-200 font-bold' : 'text-white' }}">
                                                    {{ $order->order_number }}
                                                </div>
                                                @if(!$order->isViewedByAdmin())
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-blue-900 text-blue-200 border border-blue-700">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                        NEW
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-400">{{ $order->orderItems->count() }} items</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-white">{{ $order->customer_name }}</div>
                                        <div class="text-sm text-gray-400">{{ $order->customer_email }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status_badge }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->payment_status_badge }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                    LKR {{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.orders.show', $order) }}" 
                                           class="text-[#f59e0b] hover:text-[#d97706] transition-colors">
                                            <i class="fas fa-eye mr-1"></i>View
                                        </a>
                                        <button onclick="editOrder({{ $order->id }})" 
                                                class="text-blue-400 hover:text-blue-300 transition-colors">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        @if(in_array($order->status, ['pending', 'cancelled']) && $order->payment_status !== 'paid')
                                            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300 transition-colors">
                                                    <i class="fas fa-trash mr-1"></i>Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-800">
                {{ $orders->appends(request()->query())->links('custom.pagination') }}
            </div>

        @else
            <!-- Empty State -->
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <h3 class="text-lg font-medium text-white mb-2">No orders found</h3>
                @if(request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                    <p class="text-gray-400 mb-4">Try adjusting your filters</p>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-700 text-gray-300 rounded-lg hover:bg-gray-800 transition-colors">
                        Clear Filters
                    </a>
                @else
                    <p class="text-gray-400">No orders have been placed yet</p>
                @endif
            </div>
        @endif
        
        </form> <!-- Close bulk form -->
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const orderCheckboxes = document.querySelectorAll('.order-checkbox');
    const bulkActionSelect = document.getElementById('bulk-action-select');
    const bulkStatusSelect = document.getElementById('bulk-status-select');
    const bulkForm = document.getElementById('bulk-form');
    const selectedCountSpan = document.getElementById('selected-count');
    const countNumberSpan = document.getElementById('count-number');

    // Update selected count display
    function updateSelectedCount() {
        const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (count > 0) {
            selectedCountSpan.style.display = 'inline';
            countNumberSpan.textContent = count;
        } else {
            selectedCountSpan.style.display = 'none';
        }
        
        // Update select all checkbox state
        if (count === 0) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = false;
        } else if (count === orderCheckboxes.length) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.indeterminate = true;
            selectAllCheckbox.checked = false;
        }
    }

    // Select all functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            orderCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedCount();
        });
    }

    // Individual checkbox change
    orderCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCount);
    });

    // Bulk action functionality
    if (bulkActionSelect) {
        bulkActionSelect.addEventListener('change', function() {
            if (this.value === 'update_status') {
                bulkStatusSelect.style.display = 'inline-block';
                bulkStatusSelect.required = true;
            } else {
                bulkStatusSelect.style.display = 'none';
                bulkStatusSelect.required = false;
            }
        });
    }

    // Bulk form submission
    if (bulkForm) {
        bulkForm.addEventListener('submit', function(e) {
            const selectedOrders = document.querySelectorAll('.order-checkbox:checked');
            const action = bulkActionSelect.value;

            // Validate selection
            if (selectedOrders.length === 0) {
                e.preventDefault();
                alert('Please select at least one order to perform bulk actions.');
                return;
            }

            // Validate action
            if (!action) {
                e.preventDefault();
                alert('Please select a bulk action.');
                return;
            }

            // Action-specific validations and confirmations
            if (action === 'delete') {
                const confirmMsg = `Are you sure you want to delete ${selectedOrders.length} selected order(s)?\n\nThis action cannot be undone.`;
                if (!confirm(confirmMsg)) {
                    e.preventDefault();
                    return;
                }
            }

            if (action === 'update_status') {
                const status = bulkStatusSelect.value;
                if (!status) {
                    e.preventDefault();
                    alert('Please select a status to update to.');
                    return;
                }
                
                const confirmMsg = `Are you sure you want to update ${selectedOrders.length} order(s) to "${status}" status?`;
                if (!confirm(confirmMsg)) {
                    e.preventDefault();
                    return;
                }
            }

            if (action === 'export') {
                const confirmMsg = `Export ${selectedOrders.length} selected order(s)?`;
                if (!confirm(confirmMsg)) {
                    e.preventDefault();
                    return;
                }
            }

            // Show loading state
            const submitBtn = document.getElementById('bulk-submit-btn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Processing...';
            }
        });
    }

    // Initialize selected count
    updateSelectedCount();
});

// Edit order function
function editOrder(orderId) {
    // Redirect to order details page
    window.location.href = `/admin/orders/${orderId}`;
}

// Date range functionality
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

    // Auto-submit on preset selection (optional)
    // Uncomment the following lines if you want automatic filtering when selecting presets
    /*
    if (datePreset) {
        datePreset.addEventListener('change', function() {
            if (this.value) {
                setTimeout(() => {
                    document.querySelector('form').submit();
                }, 200);
            }
        });
    }
    */
});
</script>
@endsection
