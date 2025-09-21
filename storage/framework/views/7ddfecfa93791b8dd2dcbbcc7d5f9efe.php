<?php $__env->startSection('title', 'Products - MSK COMPUTERS'); ?>
<?php $__env->startSection('description', 'Browse our extensive collection of computer hardware, gaming PCs, laptops, and accessories at MSK COMPUTERS.'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<section class="bg-black py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Our Products</h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">Discover premium computer hardware and solutions tailored for your needs</p>
        </div>
    </div>
</section>

<!-- Filters and Products -->
<section class="py-12 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:w-1/4">
                <div class="card p-6 sticky top-20">
                    <h3 class="text-lg font-semibold text-white mb-4">Filter Products</h3>
                    
                    <!-- Categories Filter -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-primary-400 mb-3">Categories</h4>
                        <div class="space-y-2">
                            <a href="<?php echo e(route('products.index')); ?>" 
                               class="block py-2 px-3 rounded <?php echo e(!request('category') ? 'bg-primary-500 text-dark-900' : 'text-gray-300 hover:text-primary-400'); ?>">
                                All Products
                            </a>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('products.index', ['category' => $category->slug])); ?>" 
                                   class="block py-2 px-3 rounded <?php echo e(request('category') == $category->slug ? 'bg-primary-500 text-dark-900' : 'text-gray-300 hover:text-primary-400'); ?>">
                                    <?php echo e($category->name); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Sort Options -->
                    <div>
                        <h4 class="text-md font-medium text-primary-400 mb-3">Sort By</h4>
                        <form method="GET" action="<?php echo e(route('products.index')); ?>" id="sortForm">
                            <?php if(request('category')): ?>
                                <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
                            <?php endif; ?>
                            <?php if(request('search')): ?>
                                <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                            <?php endif; ?>
                            <select name="sort" class="input-field w-full" onchange="document.getElementById('sortForm').submit()">
                                <option value="latest" <?php echo e(request('sort') == 'latest' ? 'selected' : ''); ?>>Latest</option>
                                <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>Price: Low to High</option>
                                <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>Price: High to Low</option>
                                <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>Name: A to Z</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:w-3/4">
                <!-- Search Results Info -->
                <?php if(request('category') || request('search')): ?>
                    <div class="mb-6">
                        <p class="text-gray-300">
                            <?php if(request('search')): ?>
                                Search results for "<span class="text-primary-400"><?php echo e(request('search')); ?></span>"
                            <?php elseif(request('category')): ?>
                                Category: <span class="text-primary-400"><?php echo e($categories->where('slug', request('category'))->first()->name ?? 'Unknown'); ?></span>
                            <?php endif; ?>
                            - <?php echo e($products->total()); ?> products found
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Products Grid -->
                <?php if($products->count() > 0): ?>
                    <div class="product-grid">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card card-hover overflow-hidden">
                                <div class="relative">
                                    <a href="<?php echo e(route('products.show', ['category' => $product->category->slug ?: $product->category->id, 'product' => $product->slug])); ?>">
                                        <img src="<?php echo e($product->images[0] ?? 'https://via.placeholder.com/400x300?text=No+Image'); ?>" 
                                             alt="<?php echo e($product->name); ?>" 
                                             class="w-full h-48 object-cover">
                                    </a>
                                    
                                    <!-- Badges -->
                                    <div class="absolute top-2 left-2 flex flex-col gap-1">
                                        <?php if($product->is_featured): ?>
                                            <span class="badge-new">FEATURED</span>
                                        <?php endif; ?>
                                        <?php if($product->is_on_sale): ?>
                                            <span class="badge-sale">SALE</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Stock Status -->
                                    <div class="absolute top-2 right-2">
                                        <?php if($product->stock_quantity > 0): ?>
                                            <span class="badge-stock">In Stock</span>
                                        <?php else: ?>
                                            <span class="badge-out-of-stock">Out of Stock</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="p-6">
                                    <div class="mb-2">
                                        <span class="text-xs text-primary-400 font-medium"><?php echo e($product->category->name); ?></span>
                                    </div>
                                    <h3 class="text-lg font-semibold text-white mb-2">
                                        <a href="<?php echo e(route('products.show', ['category' => $product->category->slug ?: $product->category->id, 'product' => $product->slug])); ?>" class="hover:text-primary-400 transition-colors">
                                            <?php echo e($product->name); ?>

                                        </a>
                                    </h3>
                                    
                                    <!-- Product Status Badge -->
                                    <?php if($product->status): ?>
                                        <div class="mb-3">
                                            <?php echo $__env->make('components.product-status-badge', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <p class="text-gray-400 text-sm mb-4 line-clamp-2"><?php echo e(Str::limit($product->description, 100)); ?></p>
                                    
                                    <!-- Price and Actions -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <?php if($product->is_on_sale): ?>
                                                <span class="text-sm text-gray-500 line-through">LKR <?php echo e(number_format($product->price, 2)); ?></span>
                                                <span class="text-lg font-bold text-[#f59e0b]">LKR <?php echo e(number_format($product->promo_price, 2)); ?></span>
                                            <?php else: ?>
                                                <?php if($product->price > 0): ?>
                                                    <span class="text-lg font-bold text-white">LKR <?php echo e(number_format($product->price, 2)); ?></span>
                                                <?php else: ?>
                                                    <span class="text-lg font-bold text-[#f59e0b]">Contact for Price</span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Payment Method Badges -->
                                    <?php echo $__env->make('components.payment-badges', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    
                                    <div class="flex items-center justify-between">
                                        <div></div>
                                        <?php if($product->can_add_to_cart): ?>
                                            <button class="btn-primary px-4 py-2 text-sm" onclick="addToCart(<?php echo e($product->id); ?>)">
                                                Add to Cart
                                            </button>
                                        <?php else: ?>
                                            <button class="btn-secondary px-4 py-2 text-sm opacity-50 cursor-not-allowed" disabled 
                                                    title="<?php echo e($product->cart_restriction_reason); ?>">
                                                <?php echo e($product->cart_restriction_reason ?: 'Unavailable'); ?>

                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        <?php echo e($products->appends(request()->query())->links()); ?>

                    </div>
                <?php else: ?>
                    <!-- No Products Found -->
                    <div class="text-center py-16">
                        <svg class="w-24 h-24 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.137 0-4.146-.832-5.657-2.343"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-white mb-2">No Products Found</h3>
                        <p class="text-gray-400 mb-6">Sorry, we couldn't find any products matching your criteria.</p>
                        <a href="<?php echo e(route('products.index')); ?>" class="btn-primary">View All Products</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function addToCart(productId) {
        // TODO: Implement add to cart functionality
        alert('Add to cart functionality will be implemented in the next phase!');
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views/products/index.blade.php ENDPATH**/ ?>