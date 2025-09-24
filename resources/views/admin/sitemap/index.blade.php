@extends('admin.layout')

@section('title', 'Sitemap Management')

@section('content')
<div class="space-y-8">
    
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Sitemap Management</h1>
            <p class="text-gray-400">Manage and regenerate sitemaps for Google Search Console</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <button id="regenerate-btn" 
                    class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span id="regenerate-text">Regenerate All Sitemaps</span>
            </button>
            <button id="refresh-btn"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Refresh Status
            </button>
        </div>
    </div>
    <!-- Success/Error Messages -->
    <div id="message-container" class="hidden">
        <div id="success-message" class="hidden bg-green-500/20 border border-green-500/20 text-green-400 px-4 py-3 rounded-lg mb-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span id="success-text"></span>
            </div>
        </div>
        <div id="error-message" class="hidden bg-red-500/20 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg mb-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span id="error-text"></span>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 lg:gap-6">
        <!-- Total Pages -->
        <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/5 border border-blue-500/20 rounded-xl p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-400 text-sm font-medium">Total Pages</p>
                    <p id="total-pages" class="text-2xl lg:text-3xl font-bold text-white">{{ number_format($stats['total_pages']) }}</p>
                </div>
                <div class="bg-blue-500/20 p-2 lg:p-3 rounded-lg">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="bg-gradient-to-br from-green-500/10 to-green-600/5 border border-green-500/20 rounded-xl p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-400 text-sm font-medium">Categories</p>
                    <p id="categories-count" class="text-2xl lg:text-3xl font-bold text-white">{{ number_format($stats['categories']) }}</p>
                </div>
                <div class="bg-green-500/20 p-2 lg:p-3 rounded-lg">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="bg-gradient-to-br from-purple-500/10 to-purple-600/5 border border-purple-500/20 rounded-xl p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-400 text-sm font-medium">Products</p>
                    <p id="products-count" class="text-2xl lg:text-3xl font-bold text-white">{{ number_format($stats['products']) }}</p>
                </div>
                <div class="bg-purple-500/20 p-2 lg:p-3 rounded-lg">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Sitemap Files -->
        <div class="bg-gradient-to-br from-yellow-500/10 to-yellow-600/5 border border-yellow-500/20 rounded-xl p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-400 text-sm font-medium">Sitemap Files</p>
                    <p id="files-count" class="text-2xl lg:text-3xl font-bold text-white">{{ count($stats['sitemap_files']) }}</p>
                </div>
                <div class="bg-yellow-500/20 p-2 lg:p-3 rounded-lg">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707L16.414 6.5a1 1 0 00-.707-.293H7a2 2 0 00-2 2v11a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Last Generated -->
        <div class="bg-gradient-to-br from-indigo-500/10 to-indigo-600/5 border border-indigo-500/20 rounded-xl p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-400 text-sm font-medium">Last Generated</p>
                    <p id="last-generated" class="text-lg lg:text-xl font-bold text-white">
                        {{ $stats['last_generated'] ? date('M j', strtotime($stats['last_generated'])) : 'Never' }}
                    </p>
                    @if($stats['last_generated'])
                    <p class="text-xs text-indigo-300">{{ date('H:i', strtotime($stats['last_generated'])) }}</p>
                    @endif
                </div>
                <div class="bg-indigo-500/20 p-2 lg:p-3 rounded-lg">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Search Console Info -->
    <div class="bg-gradient-to-br from-primary-500/10 to-primary-600/5 border border-primary-500/20 rounded-xl p-4 lg:p-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="bg-primary-500/20 p-3 rounded-lg flex-shrink-0">
                <svg class="w-6 h-6 text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-white mb-2">Google Search Console Submission</h3>
                <p class="text-gray-300 text-sm mb-3">Submit this URL to Google Search Console for complete coverage:</p>
                <div class="bg-gray-800/50 rounded-lg p-3 mb-3">
                    <code class="text-primary-400 font-mono text-sm break-all">{{ url('/sitemap-index.xml') }}</code>
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    <a href="{{ url('/sitemap-index.xml') }}" target="_blank" 
                       class="inline-flex items-center px-3 py-2 bg-primary-600/20 text-primary-400 text-sm font-medium rounded-lg hover:bg-primary-600/30 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        View Sitemap Index
                    </a>
                    <button onclick="navigator.clipboard.writeText('{{ url('/sitemap-index.xml') }}')" 
                            class="inline-flex items-center px-3 py-2 bg-gray-600/20 text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-600/30 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        Copy URL
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sitemap Files -->
    <div class="bg-gray-800/50 border border-gray-700 rounded-xl overflow-hidden">
        <div class="px-4 lg:px-6 py-4 border-b border-gray-700">
            <h3 class="text-lg font-semibold text-white">Sitemap Files</h3>
            <p class="mt-1 text-sm text-gray-400">
                Individual sitemap files and their details
            </p>
        </div>
        
        <div class="divide-y divide-gray-700">
            <ul id="sitemap-files" class="divide-y divide-gray-700">
                @forelse($stats['sitemap_files'] as $file)
                <li class="px-4 lg:px-6 py-4 hover:bg-gray-700/30 transition-colors">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center">
                            <div class="bg-blue-500/20 p-2 rounded-lg flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-white">{{ $file['name'] }}</div>
                                <div class="text-sm text-gray-400">
                                    {{ $file['size'] }} • Modified {{ date('M j, Y H:i', $file['last_modified']) }}
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <a href="{{ $file['url'] }}" target="_blank" 
                               class="inline-flex items-center justify-center px-3 py-2 bg-primary-600/20 text-primary-400 text-sm font-medium rounded-lg hover:bg-primary-600/30 transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                View
                            </a>
                            <a href="{{ route('admin.sitemap.download', $file['name']) }}" 
                               class="inline-flex items-center justify-center px-3 py-2 bg-green-600/20 text-green-400 text-sm font-medium rounded-lg hover:bg-green-600/30 transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>
                </li>
                @empty
                <li class="px-4 lg:px-6 py-12">
                    <div class="text-center">
                        <div class="bg-gray-600/20 p-4 rounded-lg inline-block mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-300 mb-2">No sitemap files found</h3>
                        <p class="text-gray-400 mb-4">Click "Regenerate All Sitemaps" to create them.</p>
                        <button onclick="document.getElementById('regenerate-btn').click()" 
                                class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Generate Sitemaps
                        </button>
                    </div>
                </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loading-modal" class="hidden fixed inset-0 bg-gray-900/80 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-6 border border-gray-600 w-96 shadow-2xl rounded-xl bg-gray-800">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-primary-500/20 mb-4">
                <svg class="animate-spin h-8 w-8 text-primary-400" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-3">Generating Sitemaps</h3>
            <div class="mb-4">
                <p class="text-gray-300 text-sm">
                    Please wait while we regenerate all sitemaps with your latest content...
                </p>
            </div>
            <div class="bg-gray-700/50 rounded-lg p-3">
                <p class="text-xs text-gray-400">
                    This process includes all 2,366+ products across multiple sitemap files
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const regenerateBtn = document.getElementById('regenerate-btn');
    const refreshBtn = document.getElementById('refresh-btn');
    const loadingModal = document.getElementById('loading-modal');
    const messageContainer = document.getElementById('message-container');
    const successMessage = document.getElementById('success-message');
    const errorMessage = document.getElementById('error-message');

    // Regenerate button click
    regenerateBtn.addEventListener('click', function() {
        showLoading(true);
        hideMessages();

        fetch('{{ route("admin.sitemap.regenerate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            showLoading(false);
            
            if (data.success) {
                showSuccess(data.message);
                updateStats(data.stats);
            } else {
                showError(data.message);
            }
        })
        .catch(error => {
            showLoading(false);
            showError('An error occurred while regenerating sitemaps.');
            console.error('Error:', error);
        });
    });

    // Refresh button click
    refreshBtn.addEventListener('click', function() {
        hideMessages();

        fetch('{{ route("admin.sitemap.status") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateStats(data.stats);
                showSuccess('Status refreshed successfully!');
            }
        })
        .catch(error => {
            showError('Failed to refresh status.');
            console.error('Error:', error);
        });
    });

    function showLoading(show) {
        if (show) {
            loadingModal.classList.remove('hidden');
            regenerateBtn.disabled = true;
            regenerateBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            loadingModal.classList.add('hidden');
            regenerateBtn.disabled = false;
            regenerateBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    function showSuccess(message) {
        document.getElementById('success-text').textContent = message;
        successMessage.classList.remove('hidden');
        errorMessage.classList.add('hidden');
        messageContainer.classList.remove('hidden');
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            hideMessages();
        }, 5000);
    }

    function showError(message) {
        document.getElementById('error-text').textContent = message;
        errorMessage.classList.remove('hidden');
        successMessage.classList.add('hidden');
        messageContainer.classList.remove('hidden');
    }

    function hideMessages() {
        messageContainer.classList.add('hidden');
        successMessage.classList.add('hidden');
        errorMessage.classList.add('hidden');
    }

    function updateStats(stats) {
        // Update statistics
        document.getElementById('total-pages').textContent = stats.total_pages.toLocaleString();
        document.getElementById('categories-count').textContent = stats.categories.toLocaleString();
        document.getElementById('products-count').textContent = stats.products.toLocaleString();
        document.getElementById('files-count').textContent = stats.sitemap_files.length;
        
        if (stats.last_generated) {
            const date = new Date(stats.last_generated);
            document.getElementById('last-generated').textContent = date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Update files list (simplified - you may want to fully rebuild the list)
        // This is a basic update - for a full implementation you'd rebuild the entire list
    }
});
</script>
@endsection
