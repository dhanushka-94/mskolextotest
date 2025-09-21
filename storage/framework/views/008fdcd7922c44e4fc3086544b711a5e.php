<?php $__env->startSection('title', 'Categories - MSK COMPUTERS'); ?>
<?php $__env->startSection('description', 'Browse our computer hardware categories including gaming PCs, laptops, monitors, and components at MSK COMPUTERS.'); ?>

<?php $__env->startSection('content'); ?>
<!-- Compact Header -->
<section class="bg-black py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Product Categories</h1>
            <p class="text-lg text-gray-300">Explore our comprehensive range of computer hardware and technology solutions</p>
        </div>
    </div>
</section>

<!-- Categories Grid -->
<section class="py-12 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="group">
                    <a href="<?php echo e(route('categories.show', $category->id)); ?>" class="block">
                        <div class="card card-hover overflow-hidden transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-primary-500/20">
                            <!-- Icon Section -->
                            <div class="relative p-6 bg-gradient-to-br from-gray-800/50 to-gray-900/50">
                                <div class="flex flex-col items-center">
                                    <!-- Category Icon -->
                                    <div class="w-16 h-16 bg-primary-500/10 rounded-2xl flex items-center justify-center group-hover:bg-primary-500/20 transition-all duration-300 mb-3">
                                        <?php
                                            $categoryName = strtolower($category->name);
                                            $icon = 'chip'; // default
                                            
                                            if (str_contains($categoryName, 'desktop') || str_contains($categoryName, 'pc')) {
                                                $icon = 'desktop';
                                            } elseif (str_contains($categoryName, 'laptop') || str_contains($categoryName, 'notebook')) {
                                                $icon = 'laptop';
                                            } elseif (str_contains($categoryName, 'gaming') || str_contains($categoryName, 'game')) {
                                                $icon = 'gaming';
                                            } elseif (str_contains($categoryName, 'monitor') || str_contains($categoryName, 'display')) {
                                                $icon = 'monitor';
                                            } elseif (str_contains($categoryName, 'processor') || str_contains($categoryName, 'cpu')) {
                                                $icon = 'cpu';
                                            } elseif (str_contains($categoryName, 'memory') || str_contains($categoryName, 'ram')) {
                                                $icon = 'memory';
                                            } elseif (str_contains($categoryName, 'storage') || str_contains($categoryName, 'hdd') || str_contains($categoryName, 'ssd')) {
                                                $icon = 'storage';
                                            } elseif (str_contains($categoryName, 'graphic') || str_contains($categoryName, 'vga') || str_contains($categoryName, 'gpu')) {
                                                $icon = 'gpu';
                                            } elseif (str_contains($categoryName, 'motherboard') || str_contains($categoryName, 'mainboard')) {
                                                $icon = 'motherboard';
                                            } elseif (str_contains($categoryName, 'power') || str_contains($categoryName, 'psu')) {
                                                $icon = 'power';
                                            } elseif (str_contains($categoryName, 'cooler') || str_contains($categoryName, 'cooling') || str_contains($categoryName, 'fan')) {
                                                $icon = 'cooling';
                                            } elseif (str_contains($categoryName, 'case') || str_contains($categoryName, 'casing')) {
                                                $icon = 'case';
                                            } elseif (str_contains($categoryName, 'keyboard') || str_contains($categoryName, 'mouse') || str_contains($categoryName, 'headset')) {
                                                $icon = 'peripheral';
                                            } elseif (str_contains($categoryName, 'printer') || str_contains($categoryName, 'print')) {
                                                $icon = 'printer';
                                            } elseif (str_contains($categoryName, 'network') || str_contains($categoryName, 'wifi') || str_contains($categoryName, 'router')) {
                                                $icon = 'network';
                                            } elseif (str_contains($categoryName, 'cable') || str_contains($categoryName, 'adapter')) {
                                                $icon = 'cable';
                                            } elseif (str_contains($categoryName, 'speaker') || str_contains($categoryName, 'audio')) {
                                                $icon = 'speaker';
                                            } elseif (str_contains($categoryName, 'camera') || str_contains($categoryName, 'webcam')) {
                                                $icon = 'camera';
                                            } elseif (str_contains($categoryName, 'software') || str_contains($categoryName, 'antivirus')) {
                                                $icon = 'software';
                                            } elseif (str_contains($categoryName, 'used') || str_contains($categoryName, 'second')) {
                                                $icon = 'used';
                                            }
                                        ?>

                                        <?php switch($icon):
                                            case ('desktop'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7l-2 3v1h8v-1l-2-3h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 12H3V4h18v10z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('laptop'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20 18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('gaming'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                                    <circle cx="10" cy="8" r="2"/>
                                                    <path d="m8 12 1.5 1.5L12 11"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('monitor'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7l-2 3v1h8v-1l-2-3h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 12H3V4h18v10z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('cpu'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M9 7v1H7v8h2v1h6v-1h2V8h-2V7H9zm4 8H11V9h2v6zm6-12h-2V1H7v2H5v2h2v8H5v2h2v2h10v-2h2v-2h-2V5h2V3zM3 15h2v2H3v-2zm16 0h2v2h-2v-2zm0-12h2v2h-2V3zM3 3h2v2H3V3z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('memory'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M6 7v10h12V7H6zm4 8H8v-6h2v6zm6 0h-2v-6h2v6z"/>
                                                    <path d="M4 5v14h16V5H4zm2 2h12v10H6V7z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('storage'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20 6H4c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM4 8h16v8H4V8zm2 2v4h8V10H6zm10 2h2v2h-2v-2z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('gpu'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M5 7v10h14V7H5zm2 2h10v6H7V9zm12-6h-2V1H7v2H5v2h2v10H5v2h2v2h10v-2h2v-2h-2V5h2V3z"/>
                                                    <rect x="9" y="11" width="6" height="2"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('motherboard'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M4 4v16h16V4H4zm2 2h12v12H6V6zm2 2v2h2V8H8zm6 0v2h2V8h-2zm-6 4v2h2v-2H8zm6 0v2h2v-2h-2zm-6 4v2h2v-2H8zm6 0v2h2v-2h-2z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('power'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M7 2v11h3v9l7-12h-4l3-8H7z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('cooling'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2l3.09 6.26L22 9l-5.19 1.74L18 17l-6-3-6 3 1.19-6.26L2 9l6.91-.74L12 2zm0 4.5L10.5 9 8 9.5l3 1.5L8 12.5l2.5.5L12 16.5l1.5-3.5L16 12.5l-3-1.5L16 9.5L13.5 9 12 6.5z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('case'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M6 2c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2H6zm0 2h12v16H6V4zm2 2v2h8V6H8zm0 4v2h8v-2H8zm0 4v2h4v-2H8z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('peripheral'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20 5H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zM4 7h16v10H4V7zm2 2v6h2V9H6zm4 0v6h2V9h-2zm4 0v6h2V9h-2zm4 0v6h2V9h-2z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('printer'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('network'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.07 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('cable'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20 5V4c0-.55-.45-1-1-1h-2c-.55 0-1 .45-1 1v1h-1v1.5c0 .83-.67 1.5-1.5 1.5S12 7.33 12 6.5V5h-1V4c0-.55-.45-1-1-1H8c-.55 0-1 .45-1 1v1H6c-.55 0-1 .45-1 1v3c0 .55.45 1 1 1h1v7c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2v-7h1c.55 0 1-.45 1-1V6c0-.55-.45-1-1-1h-1z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('speaker'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('camera'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 15c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3zm0-8c2.76 0 5 2.24 5 5s-2.24 5-5 5-5-2.24-5-5 2.24-5 5-5zM9 2L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2H9z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('software'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php case ('used'): ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                                </svg>
                                                <?php break; ?>
                                            <?php default: ?>
                                                <svg class="w-8 h-8 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M9 3V1h6v2h4a1 1 0 011 1v16a1 1 0 01-1 1H5a1 1 0 01-1-1V4a1 1 0 011-1h4zm4 0H11v1h2V3zm-5 3v12h8V6H8zm2 2h4v2h-4V8zm0 3h4v2h-4v-2zm0 3h2v2h-2v-2z"/>
                                                </svg>
                                        <?php endswitch; ?>
                                    </div>
                                    
                                    <!-- Category Name -->
                                    <h3 class="text-center text-white font-semibold text-sm md:text-base mb-1 group-hover:text-primary-400 transition-colors line-clamp-2">
                                        <?php echo e($category->name); ?>

                                    </h3>
                                    
                                    <!-- Product Count -->
                                    <div class="bg-primary-500/10 text-primary-400 px-3 py-1 rounded-full text-xs font-medium">
                                        <?php echo e($category->active_products_count); ?> Products
                                    </div>
                                </div>
                                
                                <!-- Hover Effect Gradient -->
                                <div class="absolute inset-0 bg-gradient-to-br from-primary-500/5 to-primary-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg"></div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- Quick Actions Section -->
<section class="py-12 bg-gray-900/50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">Need Help Finding Something?</h2>
        <p class="text-gray-300 mb-6">Our expert team can help you find the perfect computer solution</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo e(route('products.index')); ?>" class="btn-primary px-6 py-3">Browse All Products</a>
            <a href="<?php echo e(route('contact-us.index')); ?>" class="btn-outline px-6 py-3">Contact Support</a>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\categories\index.blade.php ENDPATH**/ ?>