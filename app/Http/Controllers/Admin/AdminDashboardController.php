<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\SmaProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    // Middleware is handled at the route level

    /**
     * Show admin dashboard
     */
    public function index()
    {
        // Get overview statistics
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'monthly_revenue' => Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])->sum('total_amount'),
            'weekly_orders' => Order::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count(),
            
            // Daily statistics
            'today_orders' => Order::whereDate('created_at', $today)->count(),
            'today_revenue' => Order::where('payment_status', 'paid')
                ->whereDate('created_at', $today)->sum('total_amount'),
            'today_pending' => Order::where('status', 'pending')
                ->whereDate('created_at', $today)->count(),
            
            // Yesterday statistics
            'yesterday_orders' => Order::whereDate('created_at', $yesterday)->count(),
            'yesterday_revenue' => Order::where('payment_status', 'paid')
                ->whereDate('created_at', $yesterday)->sum('total_amount'),
            'yesterday_pending' => Order::where('status', 'pending')
                ->whereDate('created_at', $yesterday)->count(),
        ];

        // Today's orders
        $todayOrders = Order::with(['user', 'orderItems'])
            ->whereDate('created_at', $today)
            ->latest()
            ->get();

        // Yesterday's orders
        $yesterdayOrders = Order::with(['user', 'orderItems'])
            ->whereDate('created_at', $yesterday)
            ->latest()
            ->get();

        // Recent orders (all time)
        $recentOrders = Order::with(['user', 'orderItems'])
            ->latest()
            ->take(10)
            ->get();

        // Order status distribution
        $orderStatusData = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Monthly sales data for chart
        $monthlySales = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Top selling products (from order items)
        $topProducts = DB::table('order_items')
            ->select('product_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_name')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        // Recent customers
        $recentCustomers = User::where('role', 'customer')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'todayOrders',
            'yesterdayOrders',
            'recentOrders',
            'orderStatusData',
            'monthlySales',
            'topProducts',
            'recentCustomers'
        ));
    }

    /**
     * Show analytics page
     */
    public function analytics()
    {
        // Handle date range parameters
        $dateFrom = request('date_from');
        $dateTo = request('date_to');
        $period = request('period', '30'); // days for backward compatibility
        
        // Determine date range based on input
        if ($dateFrom && $dateTo) {
            // Custom date range
            $startDate = Carbon::parse($dateFrom)->startOfDay();
            $endDate = Carbon::parse($dateTo)->endOfDay();
        } elseif ($dateFrom && !$dateTo) {
            // From date only
            $startDate = Carbon::parse($dateFrom)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        } elseif (!$dateFrom && $dateTo) {
            // To date only  
            $startDate = Carbon::parse($dateTo)->startOfDay()->subDays(30); // Default to 30 days back
            $endDate = Carbon::parse($dateTo)->endOfDay();
        } else {
            // Default to period-based range
            $startDate = Carbon::now()->subDays($period)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        }

        // Revenue analytics
        $revenueData = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Product performance
        $productPerformance = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', $startDate)
            ->where('orders.payment_status', 'paid')
            ->select(
                'order_items.product_name',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.total_price) as revenue')
            )
            ->groupBy('order_items.product_name')
            ->orderBy('revenue', 'desc')
            ->take(10)
            ->get();

        // Customer insights
        $customerInsights = [
            'new_customers' => User::where('role', 'customer')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'repeat_customers' => User::where('role', 'customer')
                ->whereHas('orders', function($query) use ($startDate) {
                    $query->where('created_at', '>=', $startDate);
                })
                ->withCount(['orders' => function($query) use ($startDate) {
                    $query->where('created_at', '>=', $startDate);
                }])
                ->having('orders_count', '>', 1)
                ->count(),
        ];

        return view('admin.analytics', compact(
            'revenueData',
            'productPerformance',
            'customerInsights',
            'period',
            'startDate',
            'endDate'
        ));
    }
}