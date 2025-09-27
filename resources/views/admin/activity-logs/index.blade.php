@extends('admin.layout')

@section('title', 'Activity Logs')

@section('content')
<div class="space-y-8">
    
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Activity Logs</h1>
            <p class="text-gray-400">Monitor system and user activities</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('admin.activity-logs.export') }}" 
               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Logs
            </a>
            <button id="refresh-btn"
                    class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Refresh
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        <!-- Total Activities -->
        <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/5 border border-blue-500/20 rounded-xl p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-400 text-sm font-medium">Total Activities</p>
                    <p class="text-2xl lg:text-3xl font-bold text-white">{{ number_format($stats['total_activities'] ?? 0) }}</p>
                </div>
                <div class="bg-blue-500/20 p-2 lg:p-3 rounded-lg">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Customer Activities -->
        <div class="bg-gradient-to-br from-green-500/10 to-green-600/5 border border-green-500/20 rounded-xl p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-400 text-sm font-medium">Customer Activities</p>
                    <p class="text-2xl lg:text-3xl font-bold text-white">{{ number_format($stats['by_type']['customer'] ?? 0) }}</p>
                </div>
                <div class="bg-green-500/20 p-2 lg:p-3 rounded-lg">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- System Activities -->
        <div class="bg-gradient-to-br from-purple-500/10 to-purple-600/5 border border-purple-500/20 rounded-xl p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-400 text-sm font-medium">System Activities</p>
                    <p class="text-2xl lg:text-3xl font-bold text-white">{{ number_format($stats['by_type']['system'] ?? 0) }}</p>
                </div>
                <div class="bg-purple-500/20 p-2 lg:p-3 rounded-lg">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Admin Activities -->
        <div class="bg-gradient-to-br from-orange-500/10 to-orange-600/5 border border-orange-500/20 rounded-xl p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-400 text-sm font-medium">Admin Activities</p>
                    <p class="text-2xl lg:text-3xl font-bold text-white">{{ number_format($stats['by_type']['admin'] ?? 0) }}</p>
                </div>
                <div class="bg-orange-500/20 p-2 lg:p-3 rounded-lg">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-gray-800/50 border border-gray-700 rounded-xl p-4 lg:p-6">
        <div class="flex flex-col lg:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Search Activities</label>
                <div class="relative">
                    <input type="text" id="search" name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search by description, user, or IP address..."
                           class="w-full bg-gray-900/50 border border-gray-600 text-white placeholder-gray-400 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Type Filter -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-300 mb-2">Type</label>
                    <select id="type" name="type" 
                            class="w-full bg-gray-900/50 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="customer" {{ request('type') == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="system" {{ request('type') == 'system' ? 'selected' : '' }}>System</option>
                        <option value="admin" {{ request('type') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <!-- Action Filter -->
                <div>
                    <label for="action" class="block text-sm font-medium text-gray-300 mb-2">Action</label>
                    <select id="action" name="action"
                            class="w-full bg-gray-900/50 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">All Actions</option>
                        <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                        <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Logout</option>
                        <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Create</option>
                        <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Update</option>
                        <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Delete</option>
                    </select>
                </div>

                <!-- Severity Filter -->
                <div>
                    <label for="severity" class="block text-sm font-medium text-gray-300 mb-2">Severity</label>
                    <select id="severity" name="severity"
                            class="w-full bg-gray-900/50 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">All Levels</option>
                        <option value="low" {{ request('severity') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('severity') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ request('severity') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="critical" {{ request('severity') == 'critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                </div>

                <!-- Apply Button -->
                <div class="flex items-end">
                    <button type="button" id="apply-filters"
                            class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        Apply Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Logs Table -->
    <div class="bg-gray-800/50 border border-gray-700 rounded-xl overflow-hidden">
        <div class="px-4 lg:px-6 py-4 border-b border-gray-700">
            <h3 class="text-lg font-semibold text-white">Recent Activities</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-900/50">
                    <tr>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Activity</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider hidden sm:table-cell">User</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider hidden md:table-cell">Type</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider hidden lg:table-cell">IP Address</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Time</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($activities as $log)
                    <tr class="hover:bg-gray-700/30 transition-colors">
                        <!-- Activity Description -->
                        <td class="px-4 lg:px-6 py-4">
                            <div class="flex flex-col">
                                <div class="text-sm font-medium text-white truncate max-w-xs lg:max-w-md">
                                    {{ $log->description }}
                                </div>
                                <div class="text-xs text-gray-400 mt-1 sm:hidden">
                                    {{ $log->causer ? $log->causer->name : 'System' }} • 
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                        {{ $log->type == 'customer' ? 'bg-green-100 text-green-800' : 
                                           ($log->type == 'admin' ? 'bg-orange-100 text-orange-800' : 'bg-purple-100 text-purple-800') }}">
                                        {{ ucfirst($log->type) }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <!-- User (Hidden on mobile) -->
                        <td class="px-4 lg:px-6 py-4 hidden sm:table-cell">
                            <div class="text-sm text-white">
                                {{ $log->causer ? $log->causer->name : 'System' }}
                            </div>
                            <div class="text-xs text-gray-400">
                                {{ $log->causer ? $log->causer->email : 'Automated' }}
                            </div>
                        </td>

                        <!-- Type (Hidden on small screens) -->
                        <td class="px-4 lg:px-6 py-4 hidden md:table-cell">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $log->type == 'customer' ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 
                                   ($log->type == 'admin' ? 'bg-orange-500/20 text-orange-400 border border-orange-500/20' : 'bg-purple-500/20 text-purple-400 border border-purple-500/20') }}">
                                {{ ucfirst($log->type) }}
                            </span>
                        </td>

                        <!-- IP Address (Hidden on medium screens and below) -->
                        <td class="px-4 lg:px-6 py-4 hidden lg:table-cell">
                            <div class="text-sm text-gray-300 font-mono">
                                {{ $log->ip_address ?? 'N/A' }}
                            </div>
                        </td>

                        <!-- Time -->
                        <td class="px-4 lg:px-6 py-4">
                            <div class="text-sm text-white">
                                {{ $log->created_at->format('M j') }}
                            </div>
                            <div class="text-xs text-gray-400">
                                {{ $log->created_at->format('H:i') }}
                            </div>
                        </td>

                        <!-- Actions -->
                        <td class="px-4 lg:px-6 py-4">
                            <a href="{{ route('admin.activity-logs.show', $log) }}" 
                               class="inline-flex items-center px-3 py-1 bg-primary-600/20 text-primary-400 text-xs font-medium rounded-lg hover:bg-primary-600/30 transition-colors">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 lg:px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-300 mb-2">No activity logs found</h3>
                                <p class="text-gray-400">Activities will appear here as users interact with the system.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($activities->hasPages())
        <div class="px-4 lg:px-6 py-4 border-t border-gray-700">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-400">
                    Showing {{ $activities->firstItem() }} to {{ $activities->lastItem() }} of {{ $activities->total() }} results
                </div>
                <div class="flex space-x-1">
                    {{ $activities->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
        @endif
    </div>

</div>

<!-- Real-time Update Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh functionality
    const refreshBtn = document.getElementById('refresh-btn');
    const applyFiltersBtn = document.getElementById('apply-filters');
    
    // Refresh button
    refreshBtn?.addEventListener('click', function() {
        window.location.reload();
    });

    // Apply filters
    applyFiltersBtn?.addEventListener('click', function() {
        const params = new URLSearchParams();
        
        const search = document.getElementById('search')?.value;
        const type = document.getElementById('type')?.value;
        const action = document.getElementById('action')?.value;
        const severity = document.getElementById('severity')?.value;
        
        if (search) params.append('search', search);
        if (type) params.append('type', type);
        if (action) params.append('action', action);
        if (severity) params.append('severity', severity);
        
        window.location.search = params.toString();
    });

    // Enter key search
    document.getElementById('search')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applyFiltersBtn?.click();
        }
    });

    // Auto-refresh every 30 seconds (only when user is actively viewing)
    let refreshInterval;
    
    function startAutoRefresh() {
        refreshInterval = setInterval(() => {
            // Only refresh if user is on this page and page is visible
            if (!document.hidden && document.hasFocus()) {
                // Optional: Add subtle notification or reload if no user interaction
                // Currently disabled to prevent performance issues
            }
        }, 30000);
    }
    
    // Only start auto-refresh if user is actively using the page
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            clearInterval(refreshInterval);
        } else {
            startAutoRefresh();
        }
    });
    
    // Start initially only if page is visible
    if (!document.hidden) {
        startAutoRefresh();
    }
});
</script>

@endsection