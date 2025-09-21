
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['product']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="card card-hover overflow-hidden group">
    <div class="relative">
        <a href="<?php echo e(route('products.show', ['category' => $product->category->slug ?: $product->category->id, 'product' => $product->slug])); ?>">
            <?php echo $__env->make('components.lazy-image', [
                'src' => $product->images[0] ?? 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=400&h=300&fit=crop&crop=center',
                'alt' => $product->name,
                'class' => 'w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300',
                'width' => '400',
                'height' => '300'
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </a>
        
        <!-- Badges -->
        <div class="absolute top-2 left-2 flex flex-col gap-1">
            <?php if($product->promotion && $product->promo_price > 0): ?>
                <span class="bg-red-500 text-white px-2 py-1 text-xs font-semibold rounded">SALE</span>
            <?php endif; ?>
        </div>
        
        <!-- Stock Status -->
        <div class="absolute top-2 right-2">
            <?php if($product->quantity > 0): ?>
                <span class="bg-green-500/80 text-white px-2 py-1 text-xs rounded-full">In Stock</span>
            <?php else: ?>
                <span class="bg-red-500/80 text-white px-2 py-1 text-xs rounded-full">Out of Stock</span>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="p-6">
        <div class="mb-2">
            <span class="text-xs text-primary-400 font-medium"><?php echo e($product->category->name); ?></span>
        </div>
        
        <h3 class="text-lg font-semibold text-white mb-2">
            <a href="<?php echo e(route('products.show', ['category' => $product->category->slug ?: $product->category->id, 'product' => $product->slug])); ?>" 
               class="hover:text-primary-400 transition-colors line-clamp-2">
                <?php echo e($product->name); ?>

            </a>
        </h3>
        
        <!-- Product Status Badge -->
        <?php if($product->status): ?>
            <div class="mb-3">
                <?php echo $__env->make('components.product-status-badge', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        <?php endif; ?>
        
        <!-- Price -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <?php if($product->promotion && $product->promo_price > 0 && $product->promo_price < $product->price): ?>
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
        
        <!-- Action Button -->
        <div class="flex items-center justify-between mt-4">
            <div></div>
            <?php if($product->can_add_to_cart): ?>
                <button class="btn-primary px-4 py-2 text-sm group-hover:bg-primary-600 transition-colors" 
                        onclick="addToCart(<?php echo e($product->id); ?>)">
                    Add to Cart
                </button>
            <?php else: ?>
                <button class="btn-secondary px-4 py-2 text-sm opacity-50 cursor-not-allowed" 
                        disabled title="<?php echo e($product->cart_restriction_reason); ?>">
                    <?php echo e($product->cart_restriction_reason ?: 'Unavailable'); ?>

                </button>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\components\optimized-product-card.blade.php ENDPATH**/ ?>