<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    // Middleware is handled at the route level

    /**
     * Display users list
     */
    public function index(Request $request)
    {
        $query = User::withCount('orders');

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user details
     */
    public function show(User $user)
    {
        $user->load(['orders.orderItems', 'addresses']);
        
        $userStats = [
            'total_orders' => $user->orders->count(),
            'total_spent' => $user->orders->where('payment_status', 'paid')->sum('total_amount'),
            'average_order' => $user->orders->where('payment_status', 'paid')->avg('total_amount'),
            'last_order' => $user->orders->sortByDesc('created_at')->first(),
        ];

        return view('admin.users.show', compact('user', 'userStats'));
    }

    /**
     * Show create user form
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store new user
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:customer,admin,staff',
            'status' => 'required|in:active,inactive,banned',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Show edit user form
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:customer,admin,staff',
            'status' => 'required|in:active,inactive,banned',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'status' => $request->status,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ];

        // Update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return back()->with('success', 'User updated successfully');
    }

    /**
     * Delete user
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account');
        }

        // Check if user has orders
        if ($user->orders()->count() > 0) {
            return back()->with('error', 'Cannot delete user with existing orders');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }

    /**
     * Toggle user status
     */
    public function toggleStatus(User $user)
    {
        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        
        $user->update(['status' => $newStatus]);

        return back()->with('success', "User status changed to {$newStatus}");
    }

    /**
     * Bulk actions on users
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:delete,activate,deactivate,ban',
            'selected_users' => 'required|array|min:1',
            'selected_users.*' => 'exists:users,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $userIds = $request->selected_users;
        $action = $request->action;

        // Prevent bulk actions on current admin
        if (in_array(auth()->id(), $userIds)) {
            return back()->with('error', 'You cannot perform bulk actions on your own account');
        }

        switch ($action) {
            case 'activate':
                User::whereIn('id', $userIds)->update(['status' => 'active']);
                return back()->with('success', count($userIds) . ' users activated successfully');

            case 'deactivate':
                User::whereIn('id', $userIds)->update(['status' => 'inactive']);
                return back()->with('success', count($userIds) . ' users deactivated successfully');

            case 'ban':
                User::whereIn('id', $userIds)->update(['status' => 'banned']);
                return back()->with('success', count($userIds) . ' users banned successfully');

            case 'delete':
                // Only delete users without orders
                $usersWithoutOrders = User::whereIn('id', $userIds)
                    ->doesntHave('orders')
                    ->pluck('id');
                
                if ($usersWithoutOrders->count() > 0) {
                    User::whereIn('id', $usersWithoutOrders)->delete();
                    return back()->with('success', $usersWithoutOrders->count() . ' users deleted successfully');
                } else {
                    return back()->with('error', 'No users can be deleted (users with orders cannot be deleted)');
                }

            default:
                return back()->with('error', 'Invalid action');
        }
    }
}