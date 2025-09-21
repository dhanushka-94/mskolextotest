<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <title><?php echo $__env->yieldContent('title', 'Admin Panel'); ?> - MSK COMPUTERS</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-[#0a0a0a] text-white font-sans antialiased">
    
    <!-- Admin Header -->
    <nav class="bg-black border-b border-gray-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                
                <!-- Logo & Navigation -->
                <div class="flex items-center space-x-8">
                    <div class="flex items-center space-x-3">
                        <img src="<?php echo e(asset('msk-computers-logo-color.png')); ?>" alt="MSK Computers" class="h-8 w-8">
                        <span class="text-xl font-bold text-[#f59e0b]">Admin Panel</span>
                    </div>
                    
                    <!-- Main Navigation -->
                    <div class="hidden md:flex space-x-6">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" 
                           class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-[#f59e0b] text-black' : 'text-gray-300 hover:text-white hover:bg-gray-800'); ?>">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            Dashboard
                        </a>
                        
                        <a href="<?php echo e(route('admin.orders.index')); ?>" 
                           class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors <?php echo e(request()->routeIs('admin.orders.*') ? 'bg-[#f59e0b] text-black' : 'text-gray-300 hover:text-white hover:bg-gray-800'); ?>">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Orders
                        </a>
                        
                        
                        <a href="<?php echo e(route('admin.users.index')); ?>" 
                           class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors <?php echo e(request()->routeIs('admin.users.*') ? 'bg-[#f59e0b] text-black' : 'text-gray-300 hover:text-white hover:bg-gray-800'); ?>">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            All Users
                        </a>
                        
                        <a href="<?php echo e(route('admin.users.index', ['role' => 'customer'])); ?>" 
                           class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors <?php echo e(request()->get('role') == 'customer' ? 'bg-[#f59e0b] text-black' : 'text-gray-300 hover:text-white hover:bg-gray-800'); ?>">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Customers
                        </a>
                        
                        <a href="<?php echo e(route('admin.transactions.index')); ?>" 
                           class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors <?php echo e(request()->routeIs('admin.transactions.*') ? 'bg-[#f59e0b] text-black' : 'text-gray-300 hover:text-white hover:bg-gray-800'); ?>">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Transactions
                        </a>
                        
                        <a href="<?php echo e(route('admin.analytics')); ?>" 
                           class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors <?php echo e(request()->routeIs('admin.analytics') ? 'bg-[#f59e0b] text-black' : 'text-gray-300 hover:text-white hover:bg-gray-800'); ?>">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Analytics
                        </a>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- Website Link -->
                    <a href="<?php echo e(route('home')); ?>" 
                       class="text-gray-400 hover:text-white transition-colors" 
                       target="_blank"
                       title="View Website">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                    
                    <!-- User Menu -->
                    <div class="relative">
                        <div class="flex items-center space-x-3">
                            <img class="w-8 h-8 rounded-full" src="<?php echo e(Auth::user()->avatar_url); ?>" alt="<?php echo e(Auth::user()->name); ?>">
                            <div class="hidden md:block">
                                <div class="text-sm font-medium text-white"><?php echo e(Auth::user()->name); ?></div>
                                <div class="text-xs text-gray-400">Administrator</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Logout -->
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" 
                                class="text-gray-400 hover:text-red-400 transition-colors" 
                                title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Success Messages -->
            <?php if(session('success')): ?>
                <div class="bg-green-900/50 border border-green-500 text-green-200 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                        </svg>
                        <?php echo e(session('success')); ?>

                    </div>
                </div>
            <?php endif; ?>

            <!-- Error Messages -->
            <?php if(session('error')): ?>
                <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/>
                        </svg>
                        <?php echo e(session('error')); ?>

                    </div>
                </div>
            <?php endif; ?>

            <!-- Page Content -->
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\admin\layout.blade.php ENDPATH**/ ?>