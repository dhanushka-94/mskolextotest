{{-- Dashboard Quick Actions Component --}}
<div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
    <h3 class="text-lg font-medium text-white mb-4">Quick Actions</h3>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <!-- View Today's Orders -->
        <a href="{{ route('admin.orders.index', ['filter' => 'today']) }}" 
           class="flex items-center justify-between p-3 bg-primary-500/10 border border-primary-500/20 rounded-lg hover:bg-primary-500/20 transition-colors group">
            <div class="flex items-center">
                <div class="p-2 bg-primary-500/20 rounded-lg mr-3">
                    <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-white">Today's Orders</p>
                    <p class="text-xs text-gray-400">{{ $stats['today_orders'] }} orders</p>
                </div>
            </div>
            <svg class="w-4 h-4 text-primary-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        <!-- View Pending Orders -->
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" 
           class="flex items-center justify-between p-3 bg-yellow-500/10 border border-yellow-500/20 rounded-lg hover:bg-yellow-500/20 transition-colors group">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-500/20 rounded-lg mr-3">
                    <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-white">Pending Orders</p>
                    <p class="text-xs text-gray-400">{{ $stats['pending_orders'] }} orders</p>
                </div>
            </div>
            <svg class="w-4 h-4 text-yellow-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        <!-- View This Week's Orders -->
        <a href="{{ route('admin.orders.index', ['filter' => 'this_week']) }}" 
           class="flex items-center justify-between p-3 bg-blue-500/10 border border-blue-500/20 rounded-lg hover:bg-blue-500/20 transition-colors group">
            <div class="flex items-center">
                <div class="p-2 bg-blue-500/20 rounded-lg mr-3">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-white">This Week</p>
                    <p class="text-xs text-gray-400">{{ $stats['weekly_orders'] }} orders</p>
                </div>
            </div>
            <svg class="w-4 h-4 text-blue-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        <!-- View Transactions -->
        <a href="{{ route('admin.transactions.index') }}" 
           class="flex items-center justify-between p-3 bg-green-500/10 border border-green-500/20 rounded-lg hover:bg-green-500/20 transition-colors group">
            <div class="flex items-center">
                <div class="p-2 bg-green-500/20 rounded-lg mr-3">
                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-white">Transactions</p>
                    <p class="text-xs text-gray-400">View payments</p>
                </div>
            </div>
            <svg class="w-4 h-4 text-green-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>
