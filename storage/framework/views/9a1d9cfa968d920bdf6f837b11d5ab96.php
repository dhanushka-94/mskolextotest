<?php $__env->startSection('title', $product->name . ' - MSK COMPUTERS'); ?>
<?php $__env->startSection('description', $product->details ? Str::limit(strip_tags($product->details), 160) : $product->name . ' - Premium computer hardware at MSK Computers. ' . ($product->category ? $product->category->name : '') . ' with warranty and quality assurance.'); ?>
<?php $__env->startSection('keywords', $product->name . ', ' . ($product->category ? $product->category->name : '') . ', MSK Computers, computer hardware, Sri Lanka, ' . ($product->code ? $product->code : '')); ?>
<?php $__env->startSection('og_title', $product->name . ' - LKR ' . number_format($product->final_price, 2) . ' at MSK COMPUTERS'); ?>
<?php $__env->startSection('og_description', $product->details ? Str::limit(strip_tags($product->details), 200) : 'Premium ' . $product->name . ' available at MSK Computers with warranty and quality assurance.'); ?>
<?php $__env->startSection('og_image', $product->main_image); ?>
<?php $__env->startSection('og_type', 'product'); ?>

<?php $__env->startSection('content'); ?>
<!-- Product Details -->
<section class="py-12 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Images -->
            <div class="p-6 bg-gradient-to-br from-gray-900 to-black rounded-xl border border-gray-800">
                <!-- Main Image -->
                <div class="mb-6 p-4 bg-black/30 rounded-xl border border-gray-700/50">
                    <img id="mainImage" 
                         src="<?php echo e($product->images[0] ?? 'https://via.placeholder.com/600x400?text=No+Image'); ?>" 
                         alt="<?php echo e($product->name); ?>" 
                         class="w-full h-96 object-contain rounded-lg shadow-2xl p-4 bg-white/5 backdrop-blur-sm">
                </div>
                
                <!-- Thumbnail Images -->
                <?php if(count($product->images) > 1): ?>
                    <div class="grid grid-cols-4 gap-3 p-2">
                        <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-2 bg-black/20 rounded-lg border border-gray-700/30 hover:border-primary-500/50 transition-all">
                                <img src="<?php echo e($image); ?>" 
                                     alt="<?php echo e($product->name); ?> - Image <?php echo e($index + 1); ?>"
                                     class="w-full h-20 object-contain rounded cursor-pointer hover:opacity-80 transition-opacity p-1 bg-white/5 <?php echo e($index === 0 ? 'ring-2 ring-primary-500' : ''); ?>"
                                     onclick="changeMainImage('<?php echo e($image); ?>', this)">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Product Info -->
            <div>
                <!-- Breadcrumb -->
                <nav class="text-sm mb-4">
                    <ol class="flex items-center space-x-2 text-gray-400">
                        <li><a href="<?php echo e(route('home')); ?>" class="hover:text-primary-400">Home</a></li>
                        <li>/</li>
                        <li><a href="<?php echo e(route('products.index')); ?>" class="hover:text-primary-400">Products</a></li>
                        <li>/</li>
                        <li><a href="<?php echo e(route('categories.show', $product->category->slug ?: $product->category->id)); ?>" class="hover:text-primary-400"><?php echo e($product->category->name); ?></a></li>
                        <li>/</li>
                        <li class="text-gray-500"><?php echo e($product->name); ?></li>
                    </ol>
                </nav>

                <!-- Product Title -->
                <div class="mb-4">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-sm text-primary-400 font-medium"><?php echo e($product->category->name); ?></span>
                        <?php if($product->is_on_sale): ?>
                            <div class="flex items-center gap-2">
                                <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse">
                                    HOT DEAL
                                </span>
                                <span class="bg-primary-500 text-black text-xs font-bold px-2 py-1 rounded">
                                    SAVE LKR <?php echo e(number_format($product->price - $product->promo_price, 2)); ?>

                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mt-1"><?php echo e($product->name); ?></h1>
                </div>

                <!-- Price -->
                <div class="mb-6">
                    <?php if($product->is_on_sale): ?>
                        <div class="bg-gradient-to-r from-primary-500/10 to-red-500/10 border border-primary-500/20 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-3xl font-bold text-primary-400">LKR <?php echo e(number_format($product->promo_price, 2)); ?></span>
                                <span class="text-xl text-gray-400 line-through">LKR <?php echo e(number_format($product->price, 2)); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-green-400 font-semibold text-sm">
                                    💰 You Save: LKR <?php echo e(number_format($product->price - $product->promo_price, 2)); ?>

                                </span>
                                <span class="text-green-400 font-semibold text-sm">
                                    (<?php echo e(round((($product->price - $product->promo_price) / $product->price) * 100)); ?>% OFF)
                                </span>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="bg-black/50 border border-gray-800 rounded-xl p-4">
                            <?php if($product->price > 0): ?>
                                <span class="text-3xl font-bold text-primary-400">LKR <?php echo e(number_format($product->price, 2)); ?></span>
                            <?php else: ?>
                                <span class="text-3xl font-bold text-primary-400">Contact for Price</span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Payment Method Badges -->
                <div class="mb-6">
                    <?php echo $__env->make('components.payment-badges', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <!-- Product Status -->
                <div class="mb-6">
                    <?php if($product->status): ?>
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-400 mb-2">Product Status:</h4>
                            <?php echo $__env->make('components.product-status-badge', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Stock Status -->
                    <?php if($product->stock_quantity > 0): ?>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                            <span class="text-green-400 font-medium"><?php echo e($product->stock_quantity); ?> in stock</span>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                            <span class="text-red-400 font-medium">Out of Stock</span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Product Details -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-white mb-2">Description</h3>
                    <p class="text-gray-300 leading-relaxed"><?php echo e($product->description); ?></p>
                </div>

                <!-- Specifications -->
                <?php if($product->specifications): ?>
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-white mb-2">Specifications</h3>
                        <p class="text-gray-300 leading-relaxed"><?php echo e($product->specifications); ?></p>
                    </div>
                <?php endif; ?>

                <!-- Product Attributes -->
                <?php if($product->grouped_attributes && count($product->grouped_attributes) > 0): ?>
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Product Attributes</h3>
                        <div class="bg-[#1c1c1e] rounded-xl border border-gray-800/30 p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <?php $__currentLoopData = $product->grouped_attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attributeName => $attributeValues): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-[#f59e0b] mb-2"><?php echo e($attributeName); ?></span>
                                        <div class="flex flex-wrap gap-2">
                                            <?php $__currentLoopData = $attributeValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="inline-block bg-[#2c2c2e] text-gray-300 text-xs font-medium px-3 py-1 rounded-lg border border-gray-700">
                                                    <?php echo e($value); ?>

                                                </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Product Meta -->
                <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                    <div>
                        <span class="text-gray-400">SKU:</span>
                        <span class="text-white ml-2"><?php echo e($product->sku); ?></span>
                    </div>
                    <div>
                        <span class="text-gray-400">Brand:</span>
                        <span class="text-white ml-2"><?php echo e($product->brand); ?></span>
                    </div>
                    <?php if($product->warranty): ?>
                        <div>
                            <span class="text-gray-400">Warranty:</span>
                            <span class="text-white ml-2"><?php echo e($product->warranty); ?></span>
                        </div>
                    <?php endif; ?>
                    <div>
                        <span class="text-gray-400">Category:</span>
                        <span class="text-white ml-2"><?php echo e($product->category->name); ?></span>
                    </div>
                </div>

                <!-- Add to Cart Section -->
                <div class="border-t border-dark-700 pt-6">
                    <?php if($product->can_add_to_cart): ?>
                        <div class="<?php if($product->is_on_sale): ?> bg-gradient-to-r from-primary-500/5 to-red-500/5 border border-primary-500/20 <?php else: ?> bg-black/50 border border-gray-800 <?php endif; ?> rounded-xl p-4">
                            <?php if($product->is_on_sale): ?>
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="text-red-400 font-semibold text-sm animate-pulse">⚡ Limited Time Offer!</span>
                                    <span class="text-gray-400 text-sm">Act fast before it's gone!</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="flex items-center border border-dark-600 rounded-lg">
                                    <button type="button" class="px-3 py-2 text-gray-300 hover:text-primary-400" onclick="decreaseQuantity()">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <input type="number" id="quantity" value="1" min="1" max="99" 
                                           class="w-16 py-2 text-center bg-transparent text-white border-0 focus:outline-none">
                                    <button type="button" class="px-3 py-2 text-gray-300 hover:text-primary-400" onclick="increaseQuantity()">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                                <button class="<?php if($product->is_on_sale): ?> bg-gradient-to-r from-primary-500 to-red-500 hover:from-primary-600 hover:to-red-600 <?php else: ?> btn-primary <?php endif; ?> flex-1 text-lg py-3 font-semibold transition-all transform hover:scale-105" onclick="addToCart(<?php echo e($product->id); ?>)">
                                    <?php if($product->is_on_sale): ?>
                                        Add to Cart (SALE!)
                                    <?php else: ?>
                                        Add to Cart
                                    <?php endif; ?>
                                </button>
                                <button class="btn-outline px-6 py-3" onclick="addToWishlist(<?php echo e($product->id); ?>)">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-6 text-center">
                            <div class="text-red-400 text-xl font-semibold mb-2"><?php echo e($product->cart_restriction_reason ?: 'Unavailable'); ?></div>
                            <?php if($product->status && in_array($product->status->status_name, ['Coming Soon', 'Pre Order', 'In Stock (for PC Build)', 'Reserved'])): ?>
                                <p class="text-gray-400"><?php echo e($product->cart_restriction_reason); ?></p>
                            <?php else: ?>
                                <p class="text-gray-400">This product is currently unavailable.</p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<?php if($relatedProducts->count() > 0): ?>
    <section class="py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-white text-center mb-12">Related Products</h2>
            
            <div class="product-grid">
                <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card card-hover overflow-hidden">
                        <div class="relative">
                            <a href="<?php echo e(route('products.show', ['category' => $relatedProduct->category->slug ?: $relatedProduct->category->id, 'product' => $relatedProduct->slug])); ?>">
                                <div class="p-3 bg-gradient-to-br from-gray-900 to-black">
                                    <img src="<?php echo e($relatedProduct->images[0] ?? 'https://via.placeholder.com/400x300?text=No+Image'); ?>" 
                                         alt="<?php echo e($relatedProduct->name); ?>" 
                                         class="w-full h-48 object-contain p-4 bg-white/5 rounded-lg">
                                </div>
                            </a>
                            
                            <?php if($relatedProduct->is_on_sale): ?>
                                <div class="absolute top-2 right-2">
                                    <span class="badge-sale">SALE</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-white mb-2">
                                <a href="<?php echo e(route('products.show', ['category' => $relatedProduct->category->slug ?: $relatedProduct->category->id, 'product' => $relatedProduct->slug])); ?>" class="hover:text-primary-400 transition-colors">
                                    <?php echo e($relatedProduct->name); ?>

                                </a>
                            </h3>
                            <p class="text-gray-400 text-sm mb-4"><?php echo e(Str::limit($relatedProduct->description, 80)); ?></p>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <?php if($relatedProduct->is_on_sale): ?>
                                        <span class="text-sm text-gray-500 line-through">LKR <?php echo e(number_format($relatedProduct->price, 2)); ?></span>
                                        <span class="text-lg font-bold text-[#f59e0b] ml-2">LKR <?php echo e(number_format($relatedProduct->promo_price, 2)); ?></span>
                                    <?php else: ?>
                                        <?php if($relatedProduct->price > 0): ?>
                                            <span class="text-lg font-bold text-white">LKR <?php echo e(number_format($relatedProduct->price, 2)); ?></span>
                                        <?php else: ?>
                                            <span class="text-lg font-bold text-[#f59e0b]">Contact for Price</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <!-- Product Status Badge -->
                                <?php if($relatedProduct->status): ?>
                                    <div class="mb-3">
                                        <?php echo $__env->make('components.product-status-badge', ['product' => $relatedProduct], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Payment Method Badges -->
                                <?php echo $__env->make('components.payment-badges', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                
                                <?php if($relatedProduct->can_add_to_cart): ?>
                                    <button class="btn-primary px-4 py-2 text-sm" onclick="addToCart(<?php echo e($relatedProduct->id); ?>)">
                                        Add to Cart
                                    </button>
                                <?php else: ?>
                                    <button class="btn-secondary px-4 py-2 text-sm opacity-50 cursor-not-allowed" disabled 
                                            title="<?php echo e($relatedProduct->cart_restriction_reason); ?>">
                                        <?php echo e($relatedProduct->cart_restriction_reason ?: 'Unavailable'); ?>

                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function changeMainImage(src, thumbnail) {
        document.getElementById('mainImage').src = src;
        
        // Update thumbnail borders
        document.querySelectorAll('.grid img').forEach(img => {
            img.classList.remove('ring-2', 'ring-primary-500');
        });
        thumbnail.classList.add('ring-2', 'ring-primary-500');
    }
    
    function increaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const max = parseInt(quantityInput.getAttribute('max'));
        const current = parseInt(quantityInput.value);
        
        if (current < max) {
            quantityInput.value = current + 1;
        }
    }
    
    function decreaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const current = parseInt(quantityInput.value);
        
        if (current > 1) {
            quantityInput.value = current - 1;
        }
    }
    
    function addToCart(productId) {
        const quantity = document.getElementById('quantity').value;
        const button = event.target;
        const originalText = button.textContent;
        
        // Disable button during request
        button.disabled = true;
        button.textContent = 'Adding...';

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: parseInt(quantity)
            })
        })
        .then(response => {
            // Check if response is ok
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            button.disabled = false;
            button.textContent = originalText;
            
            if (data.success) {
                // Animate cart addition with product name and total
                const productName = document.querySelector('h1').textContent.trim();
                
                // Use setTimeout to ensure animation doesn't interfere
                try {
                    window.animateCartAddition(data.cart_count, productName, data.cart_total);
                } catch (animError) {
                    console.error('Animation error:', animError);
                    // Fallback: Just show a simple success message
                    showNotification('Product added to cart successfully!', 'success');
                }
                
                // Don't show additional notification since animateCartAddition shows one
            } else {
                showNotification(data.message || 'Failed to add product to cart', 'error');
            }
        })
        .catch(error => {
            button.disabled = false;
            button.textContent = originalText;
            console.error('Cart Error Details:', error);
            showNotification('Something went wrong. Please try again.', 'error');
        });
    }
    
    // Remove duplicate updateCartCount function - using global one from app.blade.php

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-24 right-4 z-[99999] p-4 rounded-lg shadow-lg transition-all transform translate-x-full ${
                type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'
            }`;
            notification.style.zIndex = '99999';
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
                notification.classList.add('translate-x-0');
            }, 10);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('opacity-0', 'translate-x-full');
                setTimeout(() => {
                    if (notification.parentNode) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }
    
    function addToWishlist(productId) {
        // TODO: Implement wishlist functionality
        alert('Wishlist functionality will be implemented in the next phase!');
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\products\show.blade.php ENDPATH**/ ?>