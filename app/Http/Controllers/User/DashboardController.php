<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show user dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get recent orders
        $recentOrders = $user->orders()
            ->with('orderItems')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get order statistics
        $orderStats = [
            'total' => $user->orders()->count(),
            'pending' => $user->orders()->where('status', 'pending')->count(),
            'completed' => $user->orders()->where('status', 'delivered')->count(),
            'cancelled' => $user->orders()->where('status', 'cancelled')->count(),
        ];

        // Get total spent
        $totalSpent = $user->orders()
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        return view('user.dashboard', compact(
            'user', 
            'recentOrders', 
            'orderStats', 
            'totalSpent'
        ));
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Show user orders
     */
    public function orders(Request $request)
    {
        $user = Auth::user();
        
        $query = $user->orders()->with('orderItems');
        
        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search by order number
        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('user.orders', compact('orders'));
    }

    /**
     * Show specific order
     */
    public function orderDetail($orderNumber)
    {
        $user = Auth::user();
        
        $order = $user->orders()
            ->with('orderItems')
            ->where('order_number', $orderNumber)
            ->firstOrFail();
            
        return view('user.order-detail', compact('order'));
    }

    /**
     * Show user addresses
     */
    public function addresses()
    {
        $user = Auth::user();
        $addresses = $user->addresses()->orderBy('is_default', 'desc')->get();
        
        return view('user.addresses', compact('addresses'));
    }

    /**
     * Store new address
     */
    public function storeAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:shipping,billing',
            'name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        UserAddress::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'name' => $request->name,
            'contact_name' => $request->contact_name,
            'contact_phone' => $request->contact_phone,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country ?? 'Sri Lanka',
            'is_default' => $request->boolean('is_default'),
        ]);

        return back()->with('success', 'Address added successfully.');
    }

    /**
     * Update address
     */
    public function updateAddress(Request $request, UserAddress $address)
    {
        // Check ownership
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required|in:shipping,billing',
            'name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $address->update([
            'type' => $request->type,
            'name' => $request->name,
            'contact_name' => $request->contact_name,
            'contact_phone' => $request->contact_phone,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country ?? 'Sri Lanka',
            'is_default' => $request->boolean('is_default'),
        ]);

        return back()->with('success', 'Address updated successfully.');
    }

    /**
     * Delete address
     */
    public function deleteAddress(UserAddress $address)
    {
        // Check ownership
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        return back()->with('success', 'Address deleted successfully.');
    }

    /**
     * Set default address
     */
    public function setDefaultAddress(UserAddress $address)
    {
        // Check ownership
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        // Remove default from other addresses of same type
        UserAddress::where('user_id', Auth::id())
            ->where('type', $address->type)
            ->update(['is_default' => false]);

        // Set this address as default
        $address->update(['is_default' => true]);

        return back()->with('success', 'Default address updated successfully.');
    }

    /**
     * Cancel order
     */
    public function cancelOrder(Order $order)
    {
        // Check ownership
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$order->canBeCancelled()) {
            return back()->with('error', 'This order cannot be cancelled.');
        }

        $order->update([
            'status' => 'cancelled',
            'admin_notes' => 'Cancelled by customer on ' . now()->format('Y-m-d H:i:s')
        ]);

        return back()->with('success', 'Order cancelled successfully.');
    }

    /**
     * Show user settings
     */
    public function settings()
    {
        $user = Auth::user();
        return view('user.settings', compact('user'));
    }

    /**
     * Update user settings
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'marketing_notifications' => 'boolean',
            'language' => 'in:en,si,ta',
            'currency' => 'in:LKR,USD',
            'timezone' => 'string|max:50',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // For now, we'll store settings in user table
        $user->update([
            'settings' => json_encode([
                'email_notifications' => $request->boolean('email_notifications', true),
                'sms_notifications' => $request->boolean('sms_notifications', true),
                'marketing_notifications' => $request->boolean('marketing_notifications', false),
                'language' => $request->input('language', 'en'),
                'currency' => $request->input('currency', 'LKR'),
                'timezone' => $request->input('timezone', 'Asia/Colombo'),
            ])
        ]);

        return back()->with('success', 'Settings updated successfully');
    }
}