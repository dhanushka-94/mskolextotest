@extends('layouts.admin')

@section('title', 'Activity Log Details - Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <a href="{{ route('admin.activity-logs.index') }}" class="text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Activity Log Details</h1>
                <p class="text-gray-600 dark:text-gray-300 mt-1">Log ID: {{ $activityLog->id }}</p>
            </div>
        </div>
        <div class="text-sm text-gray-500 dark:text-gray-400">
            {{ $activityLog->created_at->format('M d, Y H:i:s') }}
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Activity Overview -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-start">
                    <span class="text-4xl mr-4">{{ $activityLog->icon }}</span>
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $activityLog->action }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($activityLog->type === 'admin') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @elseif($activityLog->type === 'customer') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($activityLog->type === 'system') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @endif">
                                {{ ucfirst($activityLog->type) }}
                            </span>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $activityLog->description }}</p>
                        
                        <!-- Status and Severity -->
                        <div class="flex items-center gap-4">
                            <div class="flex items-center">
                                <span class="text-sm text-gray-500 dark:text-gray-400 mr-2">Status:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($activityLog->status === 'success') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($activityLog->status === 'failed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @elseif($activityLog->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @endif">
                                    {{ ucfirst($activityLog->status) }}
                                </span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm text-gray-500 dark:text-gray-400 mr-2">Severity:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($activityLog->severity === 'critical') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @elseif($activityLog->severity === 'high') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                    @elseif($activityLog->severity === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @endif">
                                    {{ ucfirst($activityLog->severity) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Properties -->
            @if($activityLog->properties)
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Activity Properties</h4>
                <div class="space-y-3">
                    @foreach($activityLog->properties as $key => $value)
                        <div class="flex items-start">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 w-1/3">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                            <span class="text-sm text-gray-900 dark:text-white flex-1">
                                @if(is_array($value))
                                    <pre class="bg-gray-100 dark:bg-gray-700 p-2 rounded text-xs overflow-auto">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                @else
                                    {{ $value }}
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Request Data -->
            @if($activityLog->request_data)
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Request Data</h4>
                <pre class="bg-gray-100 dark:bg-gray-700 p-4 rounded text-sm overflow-auto">{{ json_encode($activityLog->request_data, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- User Information -->
            @if($activityLog->causer)
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">User Information</h4>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <img src="{{ $activityLog->causer->avatar_url ?? asset('images/avatars/default-avatar.svg') }}" 
                             alt="{{ $activityLog->causer->name }}" 
                             class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $activityLog->causer->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $activityLog->causer->email }}</div>
                        </div>
                    </div>
                    @if($activityLog->causer->role)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Role:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst($activityLog->causer->role) }}</span>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Technical Details -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Technical Details</h4>
                <div class="space-y-3 text-sm">
                    @if($activityLog->ip_address)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400">IP Address:</span>
                            <span class="font-mono text-gray-900 dark:text-white">{{ $activityLog->ip_address }}</span>
                        </div>
                    @endif
                    
                    @if($activityLog->url)
                        <div class="flex items-start justify-between">
                            <span class="text-gray-500 dark:text-gray-400">URL:</span>
                            <span class="font-mono text-gray-900 dark:text-white text-right break-all">{{ $activityLog->url }}</span>
                        </div>
                    @endif
                    
                    @if($activityLog->method)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Method:</span>
                            <span class="font-mono text-gray-900 dark:text-white">{{ $activityLog->method }}</span>
                        </div>
                    @endif
                    
                    @if($activityLog->device_type)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Device:</span>
                            <span class="text-gray-900 dark:text-white">{{ ucfirst($activityLog->device_type) }}</span>
                        </div>
                    @endif
                    
                    @if($activityLog->browser)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Browser:</span>
                            <span class="text-gray-900 dark:text-white">{{ $activityLog->browser }}</span>
                        </div>
                    @endif
                    
                    @if($activityLog->platform)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Platform:</span>
                            <span class="text-gray-900 dark:text-white">{{ $activityLog->platform }}</span>
                        </div>
                    @endif
                    
                    @if($activityLog->country)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Country:</span>
                            <span class="text-gray-900 dark:text-white">{{ $activityLog->country }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- User Agent -->
            @if($activityLog->user_agent)
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">User Agent</h4>
                <p class="text-sm text-gray-700 dark:text-gray-300 font-mono break-all">{{ $activityLog->user_agent }}</p>
            </div>
            @endif

            <!-- Subject Information -->
            @if($activityLog->subject)
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Subject</h4>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Type:</span>
                        <span class="text-gray-900 dark:text-white">{{ class_basename($activityLog->subject_type) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 dark:text-gray-400">ID:</span>
                        <span class="text-gray-900 dark:text-white">{{ $activityLog->subject_id }}</span>
                    </div>
                    @if(isset($activityLog->subject->name))
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Name:</span>
                            <span class="text-gray-900 dark:text-white">{{ $activityLog->subject->name }}</span>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Timeline -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Timeline</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Created:</span>
                        <span class="text-gray-900 dark:text-white">{{ $activityLog->created_at->format('M d, Y H:i:s') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Time Ago:</span>
                        <span class="text-gray-900 dark:text-white">{{ $activityLog->time_ago }}</span>
                    </div>
                    @if($activityLog->updated_at && $activityLog->updated_at != $activityLog->created_at)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Updated:</span>
                            <span class="text-gray-900 dark:text-white">{{ $activityLog->updated_at->format('M d, Y H:i:s') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
