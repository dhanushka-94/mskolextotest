<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    /**
     * Display activity logs dashboard
     */
    public function index(Request $request)
    {
        // Filters
        $type = $request->get('type');
        $action = $request->get('action');
        $severity = $request->get('severity');
        $status = $request->get('status');
        $dateRange = $request->get('date_range', '7_days');
        $userId = $request->get('user_id');
        $search = $request->get('search');

        // Build query
        $query = ActivityLog::with(['causer'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($type) {
            $query->where('type', $type);
        }

        if ($action) {
            $query->where('action', $action);
        }

        if ($severity) {
            $query->where('severity', $severity);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($userId) {
            $query->where('causer_id', $userId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        // Date range filter
        $this->applyDateRangeFilter($query, $dateRange);

        // Paginate results
        $activities = $query->paginate(50)->withQueryString();

        // Get statistics
        $stats = $this->getActivityStats($dateRange);

        // Get filter options
        $filterOptions = $this->getFilterOptions();

        return view('admin.activity-logs.index', compact(
            'activities',
            'stats',
            'filterOptions',
            'type',
            'action',
            'severity',
            'status',
            'dateRange',
            'userId',
            'search'
        ));
    }

    /**
     * Show activity log details
     */
    public function show(ActivityLog $activityLog)
    {
        $activityLog->load(['causer', 'subject']);
        
        return view('admin.activity-logs.show', compact('activityLog'));
    }

    /**
     * Export activity logs
     */
    public function export(Request $request)
    {
        // This would implement CSV/Excel export
        // For now, return JSON
        $activities = ActivityLog::with(['causer'])
            ->orderBy('created_at', 'desc')
            ->limit(1000)
            ->get();

        return response()->json($activities);
    }

    /**
     * Get real-time activity feed (for AJAX)
     */
    public function feed(Request $request)
    {
        $lastId = $request->get('last_id', 0);
        
        $activities = ActivityLog::with(['causer'])
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return response()->json([
            'activities' => $activities->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'type' => $activity->type,
                    'action' => $activity->action,
                    'description' => $activity->description,
                    'causer_name' => $activity->causer->name ?? 'System',
                    'time_ago' => $activity->time_ago,
                    'icon' => $activity->icon,
                    'severity_color' => $activity->severity_color,
                    'status_color' => $activity->status_color,
                    'created_at' => $activity->created_at->toISOString(),
                ];
            }),
            'last_id' => $activities->max('id') ?? $lastId,
        ]);
    }

    /**
     * Clear old activity logs
     */
    public function cleanup(Request $request)
    {
        $days = $request->get('days', 90);
        
        $deleted = ActivityLog::where('created_at', '<', now()->subDays($days))->delete();
        
        // Log the cleanup activity
        ActivityLog::logAdmin('cleanup', "Cleaned up {$deleted} activity logs older than {$days} days", Auth::user());
        
        return redirect()->back()->with('success', "Cleaned up {$deleted} old activity logs");
    }

    /**
     * Apply date range filter to query
     */
    private function applyDateRangeFilter($query, $dateRange)
    {
        switch ($dateRange) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'yesterday':
                $query->whereDate('created_at', today()->subDay());
                break;
            case '7_days':
                $query->where('created_at', '>=', now()->subDays(7));
                break;
            case '30_days':
                $query->where('created_at', '>=', now()->subDays(30));
                break;
            case '90_days':
                $query->where('created_at', '>=', now()->subDays(90));
                break;
            case 'all':
                // No filter
                break;
            default:
                $query->where('created_at', '>=', now()->subDays(7));
        }
    }

    /**
     * Get activity statistics
     */
    private function getActivityStats($dateRange = '7_days')
    {
        $query = ActivityLog::query();
        $this->applyDateRangeFilter($query, $dateRange);

        $totalActivities = $query->count();

        return [
            'total_activities' => $totalActivities,
            'by_type' => $this->getStatsByField($dateRange, 'type'),
            'by_action' => $this->getStatsByField($dateRange, 'action'),
            'by_severity' => $this->getStatsByField($dateRange, 'severity'),
            'by_status' => $this->getStatsByField($dateRange, 'status'),
            'by_hour' => $this->getHourlyStats($dateRange),
            'top_users' => $this->getTopUsersStats($dateRange),
            'top_ips' => $this->getTopIPsStats($dateRange),
        ];
    }

    /**
     * Get statistics by field
     */
    private function getStatsByField($dateRange, $field)
    {
        $query = ActivityLog::selectRaw("{$field}, COUNT(*) as count")
            ->groupBy($field)
            ->orderBy('count', 'desc');
            
        $this->applyDateRangeFilter($query, $dateRange);
        
        return $query->get()->pluck('count', $field)->toArray();
    }

    /**
     * Get hourly statistics
     */
    private function getHourlyStats($dateRange)
    {
        $query = ActivityLog::selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('hour');
            
        $this->applyDateRangeFilter($query, $dateRange);
        
        $stats = $query->get()->pluck('count', 'hour')->toArray();
        
        // Fill in missing hours with 0
        $hourlyStats = [];
        for ($i = 0; $i < 24; $i++) {
            $hourlyStats[$i] = $stats[$i] ?? 0;
        }
        
        return $hourlyStats;
    }

    /**
     * Get top users statistics
     */
    private function getTopUsersStats($dateRange)
    {
        $query = ActivityLog::with('causer')
            ->selectRaw('causer_id, causer_type, COUNT(*) as count')
            ->whereNotNull('causer_id')
            ->groupBy('causer_id', 'causer_type')
            ->orderBy('count', 'desc')
            ->limit(10);
            
        $this->applyDateRangeFilter($query, $dateRange);
        
        return $query->get()->map(function ($stat) {
            return [
                'user' => $stat->causer->name ?? 'Unknown',
                'count' => $stat->count,
            ];
        })->toArray();
    }

    /**
     * Get top IPs statistics
     */
    private function getTopIPsStats($dateRange)
    {
        $query = ActivityLog::selectRaw('ip_address, COUNT(*) as count')
            ->whereNotNull('ip_address')
            ->groupBy('ip_address')
            ->orderBy('count', 'desc')
            ->limit(10);
            
        $this->applyDateRangeFilter($query, $dateRange);
        
        return $query->get()->pluck('count', 'ip_address')->toArray();
    }

    /**
     * Get filter options
     */
    private function getFilterOptions()
    {
        return [
            'types' => [
                ActivityLog::TYPE_SYSTEM => 'System',
                ActivityLog::TYPE_CUSTOMER => 'Customer',
                ActivityLog::TYPE_ADMIN => 'Admin',
                ActivityLog::TYPE_API => 'API',
            ],
            'actions' => ActivityLog::select('action')
                ->distinct()
                ->orderBy('action')
                ->pluck('action', 'action')
                ->toArray(),
            'severities' => [
                ActivityLog::SEVERITY_LOW => 'Low',
                ActivityLog::SEVERITY_MEDIUM => 'Medium',
                ActivityLog::SEVERITY_HIGH => 'High',
                ActivityLog::SEVERITY_CRITICAL => 'Critical',
            ],
            'statuses' => [
                ActivityLog::STATUS_SUCCESS => 'Success',
                ActivityLog::STATUS_FAILED => 'Failed',
                ActivityLog::STATUS_PENDING => 'Pending',
                ActivityLog::STATUS_CANCELLED => 'Cancelled',
            ],
            'date_ranges' => [
                'today' => 'Today',
                'yesterday' => 'Yesterday',
                '7_days' => 'Last 7 Days',
                '30_days' => 'Last 30 Days',
                '90_days' => 'Last 90 Days',
                'all' => 'All Time',
            ],
        ];
    }
}