<?php $__env->startSection('title', 'Login - MSK COMPUTERS'); ?>
<?php $__env->startSection('description', 'Sign in to your MSK Computers account to track orders, manage your profile, and enjoy personalized shopping experience.'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-black via-[#0f0f0f] to-[#1a1a1c] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute w-96 h-96 rounded-full bg-[#f59e0b] blur-3xl -top-48 -left-48"></div>
        <div class="absolute w-96 h-96 rounded-full bg-[#3b82f6] blur-3xl -bottom-48 -right-48"></div>
    </div>
    
    <div class="max-w-md w-full space-y-8 relative z-10">
        <!-- Glass Card Container -->
        <div class="bg-[#1a1a1c]/80 backdrop-blur-xl border border-gray-800/50 rounded-2xl p-8 shadow-2xl">
            <!-- Logo and Header -->
            <div class="text-center">
                <div class="h-32 w-32 mx-auto mb-6 relative">
                    <div class="absolute inset-0 bg-[#f59e0b]/20 rounded-full blur-xl"></div>
                    <img src="<?php echo e(asset('msk-computers-logo-color.png')); ?>" alt="MSK Computers Logo" class="w-full h-full object-contain relative z-10">
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Welcome Back</h2>
                <p class="text-gray-400 mb-6">Sign in to your MSK Computers account</p>
            </div>

            <!-- Error Messages -->
            <?php if($errors->any()): ?>
                <div class="bg-red-900/30 backdrop-blur-sm border border-red-500/50 text-red-200 px-4 py-3 rounded-xl mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                        <ul class="list-none space-y-1">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="text-sm"><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Success Messages -->
            <?php if(session('success')): ?>
                <div class="bg-green-900/30 backdrop-blur-sm border border-green-500/50 text-green-200 px-4 py-3 rounded-xl mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <p class="text-sm"><?php echo e(session('success')); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form class="space-y-6" action="<?php echo e(route('login')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="space-y-4">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                   value="<?php echo e(old('email')); ?>"
                                   class="w-full pl-10 pr-4 py-3 bg-[#0f0f0f]/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b]/50 focus:border-[#f59e0b] transition-all duration-300 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Enter your email">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required 
                                   class="w-full pl-10 pr-4 py-3 bg-[#0f0f0f]/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b]/50 focus:border-[#f59e0b] transition-all duration-300 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Enter your password">
                        </div>
                    </div>
            </div>

            <!-- Remember me and Forgot password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" 
                           class="h-4 w-4 bg-[#1a1a1c] border-gray-700 rounded text-[#f59e0b] focus:ring-[#f59e0b] focus:ring-offset-gray-900">
                    <label for="remember" class="ml-2 block text-sm text-gray-300">Remember me</label>
                </div>

                <div class="text-sm">
                    <a href="#" class="text-[#f59e0b] hover:text-[#d97706] transition-colors">Forgot your password?</a>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-black bg-gradient-to-r from-[#f59e0b] to-[#fbbf24] hover:from-[#d97706] hover:to-[#f59e0b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#f59e0b] transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Sign In
                </button>
            </div>

            <!-- Register Link -->
            <div class="text-center">
                <p class="text-gray-400">
                    Don't have an account? 
                    <a href="<?php echo e(route('register')); ?>" class="text-[#f59e0b] hover:text-[#d97706] font-medium transition-colors">Sign up here</a>
                </p>
            </div>
        </form>

        <!-- Features -->
        <div class="mt-8 pt-6 border-t border-gray-800">
            <p class="text-center text-gray-400 text-sm mb-4">Why create an account?</p>
            <div class="grid grid-cols-1 gap-3">
                <div class="flex items-center text-gray-300 text-sm">
                    <svg class="w-4 h-4 text-[#f59e0b] mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    Track your orders in real-time
                </div>
                <div class="flex items-center text-gray-300 text-sm">
                    <svg class="w-4 h-4 text-[#f59e0b] mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    Save multiple delivery addresses
                </div>
                <div class="flex items-center text-gray-300 text-sm">
                    <svg class="w-4 h-4 text-[#f59e0b] mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    Faster checkout experience
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views/auth/login.blade.php ENDPATH**/ ?>