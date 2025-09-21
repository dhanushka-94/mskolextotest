

<?php $__env->startSection('title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-white">User Management</h1>
        <a href="<?php echo e(route('admin.users.create')); ?>" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg transition-colors">
            <i class="fas fa-plus mr-2"></i>Create User
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gray-800 rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-users text-2xl text-blue-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Total Users</p>
                    <p class="text-2xl font-semibold text-white"><?php echo e($users->total()); ?></p>
                </div>
            </div>
        </div>
        <div class="bg-gray-800 rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-user-check text-2xl text-green-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Active Users</p>
                    <p class="text-2xl font-semibold text-white"><?php echo e(\App\Models\User::where('status', 'active')->count()); ?></p>
                </div>
            </div>
        </div>
        <div class="bg-gray-800 rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-shopping-cart text-2xl text-yellow-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Customers</p>
                    <p class="text-2xl font-semibold text-white"><?php echo e(\App\Models\User::where('role', 'customer')->count()); ?></p>
                </div>
            </div>
        </div>
        <div class="bg-gray-800 rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-user-shield text-2xl text-purple-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Admins</p>
                    <p class="text-2xl font-semibold text-white"><?php echo e(\App\Models\User::where('role', 'admin')->count()); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-gray-800 rounded-lg p-6">
        <form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Search</label>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                       placeholder="Name or email..." 
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Role</label>
                <select name="role" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary-500">
                    <option value="">All Roles</option>
                    <option value="customer" <?php echo e(request('role') == 'customer' ? 'selected' : ''); ?>>Customer</option>
                    <option value="admin" <?php echo e(request('role') == 'admin' ? 'selected' : ''); ?>>Admin</option>
                    <option value="staff" <?php echo e(request('role') == 'staff' ? 'selected' : ''); ?>>Staff</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                <select name="status" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    <option value="banned" <?php echo e(request('status') == 'banned' ? 'selected' : ''); ?>>Banned</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <div class="bg-gray-800 rounded-lg p-4">
        <form id="bulkActionForm" method="POST" action="<?php echo e(route('admin.users.bulk-action')); ?>">
            <?php echo csrf_field(); ?>
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center">
                    <input type="checkbox" id="selectAll" class="mr-2 rounded border-gray-600 bg-gray-700 text-primary-500 focus:ring-primary-500">
                    <label for="selectAll" class="text-sm text-gray-300">Select All</label>
                </div>
                
                <select name="action" id="bulkAction" class="bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-primary-500">
                    <option value="">Choose Action...</option>
                    <option value="activate">Activate Users</option>
                    <option value="deactivate">Deactivate Users</option>
                    <option value="ban">Ban Users</option>
                    <option value="delete">Delete Users (without orders)</option>
                </select>
                
                <button type="submit" id="bulkActionBtn" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg text-sm transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Apply Action
                </button>
                
                <span id="selectedCount" class="text-sm text-gray-400">0 users selected</span>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-gray-800 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            <input type="checkbox" id="selectAllTable" class="rounded border-gray-600 bg-gray-700 text-primary-500 focus:ring-primary-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Orders</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($user->id !== auth()->id()): ?>
                                    <input type="checkbox" name="selected_users[]" value="<?php echo e($user->id); ?>" class="user-checkbox rounded border-gray-600 bg-gray-700 text-primary-500 focus:ring-primary-500">
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" 
                                             src="<?php echo e($user->avatar_url); ?>" 
                                             alt="<?php echo e($user->name); ?>">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-white"><?php echo e($user->name); ?></div>
                                        <div class="text-sm text-gray-400"><?php echo e($user->email); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-300"><?php echo e($user->phone ?: 'N/A'); ?></div>
                                <?php if($user->last_login_at): ?>
                                    <div class="text-sm text-gray-400">Last: <?php echo e($user->last_login_at->diffForHumans()); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    <?php echo e($user->role === 'admin' ? 'bg-purple-100 text-purple-800' : ''); ?>

                                    <?php echo e($user->role === 'customer' ? 'bg-blue-100 text-blue-800' : ''); ?>

                                    <?php echo e($user->role === 'staff' ? 'bg-green-100 text-green-800' : ''); ?>">
                                    <?php echo e(ucfirst($user->role)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    <?php echo e($user->status === 'active' ? 'bg-green-100 text-green-800' : ''); ?>

                                    <?php echo e($user->status === 'inactive' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                                    <?php echo e($user->status === 'banned' ? 'bg-red-100 text-red-800' : ''); ?>">
                                    <?php echo e(ucfirst($user->status)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                <?php echo e($user->orders_count ?? 0); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                <?php echo e($user->created_at->format('M d, Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex flex-col space-y-1">
                                    <!-- View Button -->
                                    <a href="<?php echo e(route('admin.users.show', $user)); ?>" 
                                       class="inline-flex items-center px-2 py-1 text-xs font-medium rounded text-blue-400 hover:text-blue-300 hover:bg-blue-900/20 transition-colors">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>
                                    
                                    <!-- Edit Button -->
                                    <a href="<?php echo e(route('admin.users.edit', $user)); ?>" 
                                       class="inline-flex items-center px-2 py-1 text-xs font-medium rounded text-yellow-400 hover:text-yellow-300 hover:bg-yellow-900/20 transition-colors">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    
                                    <?php if($user->id !== auth()->id()): ?>
                                        <!-- Toggle Status Button -->
                                        <form method="POST" action="<?php echo e(route('admin.users.toggle-status', $user)); ?>" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" 
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded text-<?php echo e($user->status === 'active' ? 'red' : 'green'); ?>-400 hover:text-<?php echo e($user->status === 'active' ? 'red' : 'green'); ?>-300 hover:bg-<?php echo e($user->status === 'active' ? 'red' : 'green'); ?>-900/20 transition-colors"
                                                    onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-<?php echo e($user->status === 'active' ? 'user-slash' : 'user-check'); ?> mr-1"></i><?php echo e($user->status === 'active' ? 'Deactivate' : 'Activate'); ?>

                                            </button>
                                        </form>
                                        
                                        <!-- Delete Button -->
                                        <?php if($user->orders_count == 0): ?>
                                            <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" 
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium rounded text-red-400 hover:text-red-300 hover:bg-red-900/20 transition-colors"
                                                        onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                    <i class="fas fa-trash mr-1"></i>Delete
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded text-gray-500" title="Cannot delete user with orders">
                                                <i class="fas fa-trash mr-1"></i>Delete
                                            </span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                                <i class="fas fa-users text-4xl mb-4"></i>
                                <p>No users found</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($users->hasPages()): ?>
            <div class="bg-gray-700 px-6 py-3">
                <?php echo e($users->appends(request()->query())->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const selectAllTable = document.getElementById('selectAllTable');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const bulkAction = document.getElementById('bulkAction');
    const bulkActionBtn = document.getElementById('bulkActionBtn');
    const selectedCount = document.getElementById('selectedCount');
    const bulkActionForm = document.getElementById('bulkActionForm');

    function updateUI() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        const count = checkedBoxes.length;
        
        selectedCount.textContent = `${count} users selected`;
        bulkActionBtn.disabled = count === 0 || !bulkAction.value;
        
        selectAll.checked = count === userCheckboxes.length && count > 0;
        selectAllTable.checked = count === userCheckboxes.length && count > 0;
    }

    // Select all functionality
    [selectAll, selectAllTable].forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            userCheckboxes.forEach(cb => cb.checked = this.checked);
            updateUI();
        });
    });

    // Individual checkbox changes
    userCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateUI);
    });

    // Bulk action selection
    bulkAction.addEventListener('change', updateUI);

    // Form submission with confirmation
    bulkActionForm.addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        const action = bulkAction.value;
        
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Please select at least one user.');
            return;
        }

        if (!action) {
            e.preventDefault();
            alert('Please select an action.');
            return;
        }

        let message = '';
        switch(action) {
            case 'activate':
                message = `Are you sure you want to activate ${checkedBoxes.length} users?`;
                break;
            case 'deactivate':
                message = `Are you sure you want to deactivate ${checkedBoxes.length} users?`;
                break;
            case 'ban':
                message = `Are you sure you want to ban ${checkedBoxes.length} users?`;
                break;
            case 'delete':
                message = `Are you sure you want to delete ${checkedBoxes.length} users? This action cannot be undone. Only users without orders will be deleted.`;
                break;
        }

        if (!confirm(message)) {
            e.preventDefault();
        }
    });

    // Initial UI update
    updateUI();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\admin\users\index.blade.php ENDPATH**/ ?>