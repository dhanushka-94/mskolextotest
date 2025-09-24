<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdminOrderController extends Controller
{
    // Middleware is handled at the route level

    /**
     * Display orders list
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order number, customer name, email, or phone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // Special filters for dashboard
        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'this_month':
                    $query->whereBetween('created_at', [
                        Carbon::now()->startOfMonth(),
                        Carbon::now()->endOfMonth()
                    ]);
                    break;
            }
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // View status filter
        if ($request->filled('view_status')) {
            if ($request->view_status === 'unviewed') {
                $query->whereNull('admin_viewed_at');
            } elseif ($request->view_status === 'viewed') {
                $query->whereNotNull('admin_viewed_at');
            }
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show specific order
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems']);
        
        // Mark order as viewed by current admin
        if (!$order->isViewedByAdmin()) {
            $order->markAsViewedBy(auth()->id());
        }
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,refunded',
            'admin_notes' => 'nullable|string|max:1000',
            'tracking_number' => 'nullable|string|max:100',
            'courier_service' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $oldStatus = $order->status;
        
        $updateData = [
            'status' => $request->status,
        ];

        if ($request->filled('admin_notes')) {
            $updateData['admin_notes'] = $request->admin_notes;
        }

        // Handle shipping-specific updates
        if ($request->status === 'shipped') {
            $updateData['shipped_at'] = now();
            if ($request->filled('tracking_number')) {
                $updateData['tracking_number'] = $request->tracking_number;
            }
            if ($request->filled('courier_service')) {
                $updateData['courier_service'] = $request->courier_service;
            }
        }

        // Handle delivery
        if ($request->status === 'delivered') {
            $updateData['delivered_at'] = now();
            if (!$order->shipped_at) {
                $updateData['shipped_at'] = now();
            }
        }

        $order->update($updateData);

        // TODO: Send email notification to customer about status change
        
        return back()->with('success', "Order status updated from {$oldStatus} to {$request->status}");
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'payment_reference' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'payment_status' => $request->payment_status,
        ];

        if ($request->filled('payment_reference')) {
            $updateData['payment_reference'] = $request->payment_reference;
        }

        $order->update($updateData);

        return back()->with('success', 'Payment status updated successfully');
    }

    /**
     * Bulk actions on orders
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:delete,update_status,export',
            'selected_orders' => 'required|array|min:1',
            'selected_orders.*' => 'exists:orders,id',
            'bulk_status' => 'required_if:action,update_status|in:pending,confirmed,processing,shipped,delivered,cancelled,refunded',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.orders.index')->withErrors($validator)->withInput();
        }

        $orderIds = $request->selected_orders;
        $action = $request->action;

        // Preserve query parameters for redirect
        $redirectUrl = route('admin.orders.index', $request->only(['search', 'status', 'payment_status', 'view_status', 'date_from', 'date_to', 'filter']));

        try {
            switch ($action) {
                case 'update_status':
                    $updatedCount = Order::whereIn('id', $orderIds)->update([
                        'status' => $request->bulk_status
                    ]);
                    Log::info("Bulk status update: {$updatedCount} orders updated to {$request->bulk_status}");
                    return redirect($redirectUrl)->with('success', count($orderIds) . ' orders updated successfully');

                case 'delete':
                    // First delete order items, then delete orders in a transaction
                    DB::transaction(function() use ($orderIds) {
                        $itemsDeleted = OrderItem::whereIn('order_id', $orderIds)->delete();
                        $ordersDeleted = Order::whereIn('id', $orderIds)->delete();
                        Log::info("Bulk delete: {$itemsDeleted} order items and {$ordersDeleted} orders deleted");
                    });
                    return redirect($redirectUrl)->with('success', count($orderIds) . ' orders deleted successfully');

                case 'export':
                    // TODO: Implement CSV export
                    return redirect($redirectUrl)->with('info', 'Export functionality will be implemented');

                default:
                    return redirect($redirectUrl)->with('error', 'Invalid action');
            }
        } catch (\Exception $e) {
            Log::error('Bulk action failed: ' . $e->getMessage(), [
                'action' => $action,
                'order_ids' => $orderIds,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect($redirectUrl)->with('error', 'Bulk action failed: ' . $e->getMessage());
        }
    }

    /**
     * Show create order form
     */
    public function create()
    {
        $customers = \App\Models\User::where('role', 'customer')->active()->get();
        return view('admin.orders.create', compact('customers'));
    }

    /**
     * Store new order
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:users,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'billing_address_line_1' => 'required|string|max:255',
            'billing_city' => 'required|string|max:100',
            'billing_state' => 'required|string|max:100',
            'billing_postal_code' => 'required|string|max:20',
            'billing_country' => 'required|string|max:100',
            'subtotal' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'payment_method' => 'required|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Generate order number
            $orderNumber = 'MSK-' . date('Y') . '-' . str_pad(Order::count() + 1, 6, '0', STR_PAD_LEFT);

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $request->customer_id,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'billing_address_line_1' => $request->billing_address_line_1,
                'billing_address_line_2' => $request->billing_address_line_2,
                'billing_city' => $request->billing_city,
                'billing_state' => $request->billing_state,
                'billing_postal_code' => $request->billing_postal_code,
                'billing_country' => $request->billing_country,
                'shipping_address_line_1' => $request->shipping_address_line_1 ?? $request->billing_address_line_1,
                'shipping_address_line_2' => $request->shipping_address_line_2 ?? $request->billing_address_line_2,
                'shipping_city' => $request->shipping_city ?? $request->billing_city,
                'shipping_state' => $request->shipping_state ?? $request->billing_state,
                'shipping_postal_code' => $request->shipping_postal_code ?? $request->billing_postal_code,
                'shipping_country' => $request->shipping_country ?? $request->billing_country,
                'subtotal' => $request->subtotal,
                'tax_amount' => $request->tax_amount ?? 0,
                'shipping_cost' => $request->shipping_cost ?? 0,
                'discount_amount' => $request->discount_amount ?? 0,
                'total_amount' => $request->total_amount,
                'status' => $request->status,
                'payment_status' => $request->payment_status,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'admin_notes' => 'Created manually by admin: ' . auth()->user()->name,
            ]);

            // Create order items
            foreach ($request->items as $item) {
                $order->orderItems()->create([
                    'product_name' => $item['product_name'],
                    'product_code' => $item['product_code'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['quantity'] * $item['unit_price'],
                    'product_attributes' => $item['attributes'] ?? null,
                ]);
            }

            return redirect()->route('admin.orders.show', $order)->with('success', 'Order created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create order: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Delete order
     */
    public function destroy(Order $order)
    {
        try {
            // Check if order can be deleted
            if (in_array($order->status, ['shipped', 'delivered'])) {
                return redirect()->back()->with('error', 'Cannot delete shipped or delivered orders.');
            }

            if ($order->payment_status === 'paid') {
                return redirect()->back()->with('error', 'Cannot delete orders with paid status. Refund first.');
            }

            // Delete order items first
            $order->orderItems()->delete();
            
            // Delete the order
            $order->delete();

            return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete order: ' . $e->getMessage());
        }
    }

    /**
     * Order statistics
     */
    public function statistics()
    {
        $stats = [
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
        ];

        return view('admin.orders.statistics', compact('stats'));
    }
}