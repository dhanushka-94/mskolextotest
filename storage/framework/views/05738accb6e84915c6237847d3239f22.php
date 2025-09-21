
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'src' => '',
    'alt' => '',
    'class' => '',
    'width' => '',
    'height' => '',
    'placeholder' => 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjQwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IiMxMTExMTEiLz48dGV4dCB4PSIyMDAiIHk9IjE1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjE2IiBmaWxsPSIjNjY2NjY2IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSI+TG9hZGluZy4uLjwvdGV4dD48L3N2Zz4='
]));

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

foreach (array_filter(([
    'src' => '',
    'alt' => '',
    'class' => '',
    'width' => '',
    'height' => '',
    'placeholder' => 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjQwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IiMxMTExMTEiLz48dGV4dCB4PSIyMDAiIHk9IjE1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjE2IiBmaWxsPSIjNjY2NjY2IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSI+TG9hZGluZy4uLjwvdGV4dD48L3N2Zz4='
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<img 
    src="<?php echo e($placeholder); ?>" 
    data-src="<?php echo e($src); ?>" 
    alt="<?php echo e($alt); ?>"
    class="lazy <?php echo e($class); ?>"
    <?php if($width): ?> width="<?php echo e($width); ?>" <?php endif; ?>
    <?php if($height): ?> height="<?php echo e($height); ?>" <?php endif; ?>
    loading="lazy"
    onload="this.style.opacity='1'"
    style="opacity: 0; transition: opacity 0.3s ease;"
>

<?php if (! $__env->hasRenderedOnce('2c71c9c3-5cb0-4efe-b30d-6f154cf658bd')): $__env->markAsRenderedOnce('2c71c9c3-5cb0-4efe-b30d-6f154cf658bd'); ?>
    <?php $__env->startPush('scripts'); ?>
    <script>
        // Intersection Observer for lazy loading
        document.addEventListener('DOMContentLoaded', function() {
            const lazyImages = document.querySelectorAll('img.lazy');
            
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    });
                });

                lazyImages.forEach(img => {
                    imageObserver.observe(img);
                });
            } else {
                // Fallback for older browsers
                lazyImages.forEach(img => {
                    img.src = img.dataset.src;
                });
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\components\lazy-image.blade.php ENDPATH**/ ?>