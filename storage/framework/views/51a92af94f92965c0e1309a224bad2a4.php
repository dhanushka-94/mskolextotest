<?php if($paginator->hasPages()): ?>
    <nav class="flex items-center justify-center space-x-2 mt-8" role="navigation" aria-label="Pagination Navigation">
        <!-- Previous Page Link -->
        <?php if($paginator->onFirstPage()): ?>
            <span class="px-3 py-2 text-sm leading-4 text-gray-500 bg-gray-800 border border-gray-700 rounded-md cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </span>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>" 
               class="px-3 py-2 text-sm leading-4 text-gray-300 bg-gray-800 border border-gray-700 rounded-md hover:bg-gray-700 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
        <?php endif; ?>

        <!-- Pagination Elements -->
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!-- "Three Dots" Separator -->
            <?php if(is_string($element)): ?>
                <span class="px-3 py-2 text-sm leading-4 text-gray-500 bg-gray-800 border border-gray-700 rounded-md"><?php echo e($element); ?></span>
            <?php endif; ?>

            <!-- Array Of Links -->
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <span class="px-3 py-2 text-sm leading-4 text-white bg-[#f59e0b] border border-[#f59e0b] rounded-md font-medium"><?php echo e($page); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>" 
                           class="px-3 py-2 text-sm leading-4 text-gray-300 bg-gray-800 border border-gray-700 rounded-md hover:bg-gray-700 hover:text-white transition-colors"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <!-- Next Page Link -->
        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>" 
               class="px-3 py-2 text-sm leading-4 text-gray-300 bg-gray-800 border border-gray-700 rounded-md hover:bg-gray-700 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        <?php else: ?>
            <span class="px-3 py-2 text-sm leading-4 text-gray-500 bg-gray-800 border border-gray-700 rounded-md cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        <?php endif; ?>
    </nav>
<?php endif; ?>
<?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views/custom/pagination.blade.php ENDPATH**/ ?>