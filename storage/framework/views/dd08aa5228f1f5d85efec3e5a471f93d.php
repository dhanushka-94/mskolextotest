

<?php $__env->startSection('title', 'Profile Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Profile Settings</h1>
        <p class="text-gray-400">Manage your account information and preferences</p>
    </div>

    <!-- Success Messages -->
    <?php if(session('success')): ?>
        <div class="bg-green-900/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Error Messages -->
    <?php if(session('error')): ?>
        <div class="bg-red-900/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Profile Photo Section -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-semibold text-white mb-6">Profile Photo</h3>
                
                <!-- Current Profile Photo -->
                <div class="flex flex-col items-center">
                    <div class="relative mb-6">
                        <img src="<?php echo e($user->avatar_url); ?>" 
                             alt="Profile Photo" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-gray-700"
                             id="currentProfilePhoto">
                        
                        <?php if($user->profile_photo_path): ?>
                            <!-- Delete Photo Button -->
                            <form action="<?php echo e(route('profile.photo.delete')); ?>" method="POST" class="absolute -top-2 -right-2">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" 
                                        class="bg-red-600 hover:bg-red-700 text-white rounded-full p-2 transition-colors"
                                        onclick="return confirm('Are you sure you want to remove your profile photo?')"
                                        title="Remove Photo">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <!-- Upload New Photo Form -->
                    <form action="<?php echo e(route('profile.photo.update')); ?>" method="POST" enctype="multipart/form-data" class="w-full">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Choose New Photo
                            </label>
                            <input type="file" 
                                   name="profile_photo" 
                                   accept="image/*"
                                   class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#f59e0b] file:text-black hover:file:bg-[#d97706] transition-colors"
                                   onchange="previewImage(this)">
                            <?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-400 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Image Preview -->
                        <div id="imagePreview" class="hidden mb-4">
                            <img id="previewImg" class="w-20 h-20 rounded-full object-cover mx-auto border-2 border-gray-600">
                        </div>

                        <button type="submit" 
                                class="w-full bg-[#f59e0b] hover:bg-[#d97706] text-black font-medium py-2 px-4 rounded-lg transition-colors">
                            Upload Photo
                        </button>
                    </form>

                    <p class="text-xs text-gray-500 mt-3 text-center">
                        Supported formats: JPEG, PNG, GIF, WebP<br>
                        Maximum size: 2MB
                    </p>
                </div>
            </div>
        </div>

        <!-- Profile Information Section -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Basic Information -->
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-semibold text-white mb-6">Personal Information</h3>
                
                <form action="<?php echo e(route('profile.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Full Name <span class="text-red-400">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   value="<?php echo e(old('name', $user->name)); ?>"
                                   required
                                   class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-400 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Email Address <span class="text-red-400">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   value="<?php echo e(old('email', $user->email)); ?>"
                                   required
                                   class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-400 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Phone Number
                            </label>
                            <input type="tel" 
                                   name="phone" 
                                   value="<?php echo e(old('phone', $user->phone)); ?>"
                                   class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-400 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Date of Birth
                            </label>
                            <input type="date" 
                                   name="date_of_birth" 
                                   value="<?php echo e(old('date_of_birth', $user->date_of_birth?->format('Y-m-d'))); ?>"
                                   class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-400 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Gender -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Gender
                            </label>
                            <select name="gender" 
                                    class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                                <option value="">Select Gender</option>
                                <option value="male" <?php echo e(old('gender', $user->gender) === 'male' ? 'selected' : ''); ?>>Male</option>
                                <option value="female" <?php echo e(old('gender', $user->gender) === 'female' ? 'selected' : ''); ?>>Female</option>
                                <option value="other" <?php echo e(old('gender', $user->gender) === 'other' ? 'selected' : ''); ?>>Other</option>
                            </select>
                            <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-400 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" 
                                class="bg-[#f59e0b] hover:bg-[#d97706] text-black font-medium py-2 px-6 rounded-lg transition-colors">
                            Update Information
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-semibold text-white mb-6">Change Password</h3>
                
                <form action="<?php echo e(route('profile.password.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    
                    <div class="space-y-4">
                        <!-- Current Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Current Password <span class="text-red-400">*</span>
                            </label>
                            <input type="password" 
                                   name="current_password" 
                                   required
                                   class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-400 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- New Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                New Password <span class="text-red-400">*</span>
                            </label>
                            <input type="password" 
                                   name="password" 
                                   required
                                   class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-400 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Confirm New Password <span class="text-red-400">*</span>
                            </label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   required
                                   class="w-full px-3 py-2 bg-[#0f0f0f] border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f59e0b] focus:border-transparent">
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('hidden');
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\profile\show.blade.php ENDPATH**/ ?>