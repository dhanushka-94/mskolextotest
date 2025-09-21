@extends('admin.layout')

@section('title', 'Transactions')

@section('content')
<div class="space-y-8">
    
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Transactions</h1>
            <p class="text-gray-400">Track and manage all payment transactions</p>
        </div>
        
        <div class="flex items-center space-x-4">
            <!-- Export Button -->
            <a href="{{ route('admin.transactions.export', request()->query()) }}" 
               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export CSV
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Transactions -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Total Transactions</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($stats['total_transactions']) }}</p>
                    <p class="text-sm text-blue-400">{{ $stats['success_rate'] }}% success rate</p>
                </div>
                <div class="p-3 bg-blue-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Total Revenue</p>
                    <p class="text-3xl font-bold text-white">LKR {{ number_format($stats['total_amount'], 2) }}</p>
                    <p class="text-sm text-green-400">+LKR {{ number_format($stats['total_fees'], 2) }} in fees</p>
                </div>
                <div class="p-3 bg-green-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Failed Transactions -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Failed Transactions</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($stats['failed_transactions']) }}</p>
                    <p class="text-sm text-red-400">Requires attention</p>
                </div>
                <div class="p-3 bg-red-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Transactions -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Pending Transactions</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($stats['pending_transactions']) }}</p>
                    <p class="text-sm text-yellow-400">Awaiting processing</p>
                </div>
                <div class="p-3 bg-yellow-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Method Distribution -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Credit/Debit Cards</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($stats['webxpay_count']) }}</p>
                </div>
                <div class="p-3 bg-purple-500/20 rounded-lg">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3-3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Koko Pay (BNPL)</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($stats['kokopay_count']) }}</p>
                </div>
                <div class="p-3 bg-indigo-500/20 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Bank Transfers</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($stats['bank_transfer_count']) }}</p>
                </div>
                <div class="p-3 bg-cyan-500/20 rounded-lg">
                    <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m11 0a2 2 0 01-2 2H7a2 2 0 01-2-2m14 0V9a2 2 0 00-2-2M9 7h6m-6 4h6m-6 4h6m-6 4h6"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
        <form method="GET" action="{{ route('admin.transactions.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Search</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Transaction ID, Order, Customer..."
                           class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                </div>

                <!-- Payment Method Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Payment Method</label>
                    <select name="payment_method" 
                            class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                        <option value="">All Methods</option>
                        <option value="webxpay" {{ request('payment_method') == 'webxpay' ? 'selected' : '' }}>Credit/Debit Card</option>
                        <option value="kokopay" {{ request('payment_method') == 'kokopay' ? 'selected' : '' }}>Koko Pay (BNPL)</option>
                        <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                    <select name="status" 
                            class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Date From</label>
                        <input type="date" 
                               name="date_from" 
                               value="{{ request('date_from') }}"
                               class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Date To</label>
                        <input type="date" 
                               name="date_to" 
                               value="{{ request('date_to') }}"
                               class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-[#f59e0b] hover:bg-[#d97706] text-black font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filter Transactions
                </button>
                
                <a href="{{ route('admin.transactions.index') }}" 
                   class="inline-flex items-center px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Clear Filters
                </a>
            </div>
        </form>
    </div>

    <!-- Transactions Table -->
    <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-800">
                <thead class="bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Transaction</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Payment Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-800/30 transition-colors">
                        <!-- Transaction Info -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <div class="text-sm font-medium text-white">{{ $transaction->transaction_id }}</div>
                                @if($transaction->order)
                                    <div class="text-sm text-gray-400">Order: {{ $transaction->order->order_number }}</div>
                                @endif
                                @if($transaction->gateway_transaction_id)
                                    <div class="text-xs text-gray-500">Gateway: {{ $transaction->gateway_transaction_id }}</div>
                                @endif
                            </div>
                        </td>

                        <!-- Customer Info -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <div class="text-sm font-medium text-white">{{ $transaction->customer_name ?: 'N/A' }}</div>
                                @if($transaction->customer_email)
                                    <div class="text-sm text-gray-400">{{ $transaction->customer_email }}</div>
                                @endif
                                @if($transaction->customer_phone)
                                    <div class="text-xs text-gray-500">{{ $transaction->customer_phone }}</div>
                                @endif
                            </div>
                        </td>

                        <!-- Payment Method -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($transaction->payment_method === 'webxpay')
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3-3v8a3 3 0 003 3z"/>
                                            </svg>
                                        </div>
                                        <span class="text-sm text-white">Credit/Debit Card</span>
                                    </div>
                                @elseif($transaction->payment_method === 'kokopay')
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-indigo-500/20 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                            </svg>
                                        </div>
                                        <span class="text-sm text-white">Koko Pay (BNPL)</span>
                                    </div>
                                @elseif($transaction->payment_method === 'bank_transfer')
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-cyan-500/20 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m11 0a2 2 0 01-2 2H7a2 2 0 01-2-2m14 0V9a2 2 0 00-2-2M9 7h6m-6 4h6m-6 4h6m-6 4h6"/>
                                            </svg>
                                        </div>
                                        <span class="text-sm text-white">Bank Transfer</span>
                                    </div>
                                @endif
                            </div>
                        </td>

                        <!-- Amount -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <div class="text-sm font-medium text-white">LKR {{ number_format($transaction->amount, 2) }}</div>
                                @if($transaction->transaction_fee > 0)
                                    <div class="text-xs text-gray-400">Fee: LKR {{ number_format($transaction->transaction_fee, 2) }}</div>
                                    <div class="text-xs text-green-400">Total: LKR {{ number_format($transaction->total_amount, 2) }}</div>
                                @endif
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
                                    'processing' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
                                    'completed' => 'bg-green-500/20 text-green-400 border-green-500/30',
                                    'failed' => 'bg-red-500/20 text-red-400 border-red-500/30',
                                    'cancelled' => 'bg-gray-500/20 text-gray-400 border-gray-500/30',
                                    'refunded' => 'bg-purple-500/20 text-purple-400 border-purple-500/30',
                                ];
                                $statusColor = $statusColors[$transaction->status] ?? 'bg-gray-500/20 text-gray-400 border-gray-500/30';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusColor }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                            @if($transaction->failure_reason)
                                <div class="text-xs text-red-400 mt-1">{{ Str::limit($transaction->failure_reason, 30) }}</div>
                            @endif
                        </td>

                        <!-- Date -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            <div class="flex flex-col">
                                <div>{{ $transaction->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $transaction->created_at->format('H:i:s') }}</div>
                                @if($transaction->completed_at)
                                    <div class="text-xs text-green-400">Completed: {{ $transaction->completed_at->format('H:i:s') }}</div>
                                @elseif($transaction->failed_at)
                                    <div class="text-xs text-red-400">Failed: {{ $transaction->failed_at->format('H:i:s') }}</div>
                                @endif
                            </div>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.transactions.show', $transaction) }}" 
                                   class="text-[#f59e0b] hover:text-[#d97706] transition-colors"
                                   title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                
                                @if($transaction->isFailed())
                                    <form action="{{ route('admin.transactions.retry', $transaction) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" 
                                                class="text-blue-400 hover:text-blue-300 transition-colors"
                                                title="Retry Transaction"
                                                onclick="return confirm('Are you sure you want to retry this transaction?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                @if($transaction->isCompleted())
                                    <button type="button" 
                                            class="text-purple-400 hover:text-purple-300 transition-colors"
                                            title="Refund Transaction"
                                            onclick="openRefundModal('{{ $transaction->id }}')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <p class="text-gray-400 text-lg font-medium mb-2">No transactions found</p>
                                <p class="text-gray-500">Try adjusting your search criteria or date range.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-gray-800">
            {{ $transactions->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Refund Modal -->
<div id="refundModal" class="fixed inset-0 bg-black/75 hidden items-center justify-center z-50">
    <div class="bg-[#1a1a1c] rounded-xl border border-gray-800 p-6 max-w-md w-full mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-white">Refund Transaction</h3>
            <button onclick="closeRefundModal()" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form id="refundForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Refund Reason</label>
                <textarea name="refund_reason" 
                          rows="3" 
                          required
                          placeholder="Enter the reason for this refund..."
                          class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent"></textarea>
            </div>
            
            <div class="flex space-x-4">
                <button type="submit" 
                        class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Process Refund
                </button>
                <button type="button" 
                        onclick="closeRefundModal()"
                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRefundModal(transactionId) {
    const modal = document.getElementById('refundModal');
    const form = document.getElementById('refundForm');
    form.action = `/admin/transactions/${transactionId}/refund`;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeRefundModal() {
    const modal = document.getElementById('refundModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Close modal on outside click
document.getElementById('refundModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRefundModal();
    }
});
</script>
@endsection
