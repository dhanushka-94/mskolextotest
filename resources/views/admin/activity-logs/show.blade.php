@extends('admin.layout')

@section('title', 'Activity Log Details')

@section('content')
<div class="space-y-8">
    
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.activity-logs.index') }}" 
                   class="inline-flex items-center text-gray-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Activity Logs
                </a>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Activity Log Details</h1>
            <p class="text-gray-400">Detailed information about this activity</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" 
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print
            </button>
        </div>
    </div>

    <!-- Activity Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Activity Info -->
        <div class="lg:col-span-2">
            <div class="bg-gray-800/50 border border-gray-700 rounded-xl p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-white mb-2">Activity Description</h2>
                        <p class="text-gray-300 text-lg leading-relaxed">{{ $activityLog->description }}</p>
                    </div>
                    <div class="ml-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $activityLog->type == 'customer' ? 'bg-green-500/20 text-green-400 border border-green-500/20' : 
                               ($activityLog->type == 'admin' ? 'bg-orange-500/20 text-orange-400 border border-orange-500/20' : 'bg-purple-500/20 text-purple-400 border border-purple-500/20') }}">
                            {{ ucfirst($activityLog->type) }}
                        </span>
                    </div>
                </div>

                <!-- Key Details Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Action -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-400 mb-2">Action</h3>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-sm font-medium bg-primary-500/20 text-primary-400 border border-primary-500/20">
                                {{ ucfirst($activityLog->action) }}
                            </span>
                        </div>
                    </div>

                    <!-- Severity -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-400 mb-2">Severity</h3>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-sm font-medium
                                {{ $activityLog->severity == 'critical' ? 'bg-red-500/20 text-red-400 border border-red-500/20' :
                                   ($activityLog->severity == 'high' ? 'bg-orange-500/20 text-orange-400 border border-orange-500/20' :
                                   ($activityLog->severity == 'medium' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/20' : 'bg-blue-500/20 text-blue-400 border border-blue-500/20')) }}">
                                {{ ucfirst($activityLog->severity) }}
                            </span>
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-400 mb-2">Status</h3>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-sm font-medium
                                {{ $activityLog->status == 'success' ? 'bg-green-500/20 text-green-400 border border-green-500/20' :
                                   ($activityLog->status == 'failed' ? 'bg-red-500/20 text-red-400 border border-red-500/20' : 'bg-gray-500/20 text-gray-400 border border-gray-500/20') }}">
                                {{ ucfirst($activityLog->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Log Name -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-400 mb-2">Log Category</h3>
                        <p class="text-white text-sm">{{ $activityLog->log_name ?: 'General' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Side Info -->
        <div class="space-y-6">
            
            <!-- Timestamp Info -->
            <div class="bg-gray-800/50 border border-gray-700 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Timestamp</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-400">Date & Time</p>
                        <p class="text-white font-medium">{{ $activityLog->created_at->format('F j, Y') }}</p>
                        <p class="text-gray-300 text-sm">{{ $activityLog->created_at->format('g:i:s A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Time Ago</p>
                        <p class="text-white">{{ $activityLog->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- User Info -->
            @if($activityLog->causer)
            <div class="bg-gray-800/50 border border-gray-700 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-white mb-4">User Information</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-400">Name</p>
                        <p class="text-white font-medium">{{ $activityLog->causer->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Email</p>
                        <p class="text-white">{{ $activityLog->causer->email }}</p>
                    </div>
                    @if(isset($activityLog->causer->id))
                    <div>
                        <p class="text-sm text-gray-400">User ID</p>
                        <p class="text-white font-mono text-sm">{{ $activityLog->causer->id }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="bg-gray-800/50 border border-gray-700 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-white mb-4">System Activity</h3>
                <div class="flex items-center">
                    <div class="bg-purple-500/20 p-3 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-medium">Automated Action</p>
                        <p class="text-gray-400 text-sm">No user associated</p>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    <!-- Technical Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Request Information -->
        <div class="bg-gray-800/50 border border-gray-700 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Request Information</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-400 mb-1">IP Address</p>
                    <p class="text-white font-mono">{{ $activityLog->ip_address ?: 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-400 mb-1">URL</p>
                    <p class="text-white font-mono text-sm break-all">{{ $activityLog->url ?: 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-400 mb-1">HTTP Method</p>
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                        {{ $activityLog->method == 'GET' ? 'bg-blue-500/20 text-blue-400' :
                           ($activityLog->method == 'POST' ? 'bg-green-500/20 text-green-400' :
                           ($activityLog->method == 'PUT' ? 'bg-yellow-500/20 text-yellow-400' :
                           ($activityLog->method == 'DELETE' ? 'bg-red-500/20 text-red-400' : 'bg-gray-500/20 text-gray-400'))) }}">
                        {{ $activityLog->method ?: 'N/A' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Device Information -->
        <div class="bg-gray-800/50 border border-gray-700 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Device Information</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-400 mb-1">Device</p>
                    <p class="text-white">{{ $activityLog->device ?: 'Unknown' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-400 mb-1">Platform</p>
                    <p class="text-white">{{ $activityLog->platform ?: 'Unknown' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-400 mb-1">Browser</p>
                    <p class="text-white">{{ $activityLog->browser ?: 'Unknown' }}</p>
                </div>
                @if($activityLog->user_agent)
                <div>
                    <p class="text-sm text-gray-400 mb-1">User Agent</p>
                    <p class="text-gray-300 text-xs font-mono break-all bg-gray-900/50 p-2 rounded">{{ $activityLog->user_agent }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Subject Information -->
    @if($activityLog->subject)
    <div class="bg-gray-800/50 border border-gray-700 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-white mb-4">Subject Information</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <p class="text-sm text-gray-400 mb-1">Subject Type</p>
                <p class="text-white">{{ class_basename($activityLog->subject_type) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-400 mb-1">Subject ID</p>
                <p class="text-white font-mono">{{ $activityLog->subject_id }}</p>
            </div>
            @if(method_exists($activityLog->subject, 'name'))
            <div>
                <p class="text-sm text-gray-400 mb-1">Subject Name</p>
                <p class="text-white">{{ $activityLog->subject->name }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Properties -->
    @if($activityLog->properties && count($activityLog->properties) > 0)
    <div class="bg-gray-800/50 border border-gray-700 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-white mb-4">Additional Properties</h3>
        <div class="bg-gray-900/50 rounded-lg p-4 overflow-x-auto">
            <pre class="text-sm text-gray-300"><code>{{ json_encode($activityLog->properties, JSON_PRETTY_PRINT) }}</code></pre>
        </div>
    </div>
    @endif

</div>
@endsection