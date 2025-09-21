
<div id="page-transition" class="fixed inset-0 z-[9998] bg-black pointer-events-none opacity-0 transition-opacity duration-300">
    <div class="flex items-center justify-center h-full">
        <div class="text-center">
            <!-- Mini logo for page transitions -->
            <div class="w-16 h-16 mx-auto mb-4 bg-primary-500/10 rounded-full flex items-center justify-center">
                <img src="<?php echo e(asset('msk-computers-logo-color.png')); ?>" 
                     alt="MSK" 
                     class="w-8 h-8 animate-spin">
            </div>
            <p class="text-gray-400 text-sm">Loading...</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pageTransition = document.getElementById('page-transition');
    
    // Show transition on link clicks
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && link.href && !link.target && !link.download && 
            link.href.startsWith(window.location.origin) && 
            !link.href.includes('#') &&
            !link.onclick) {
            
            e.preventDefault();
            
            // Show transition
            pageTransition.style.pointerEvents = 'all';
            pageTransition.style.opacity = '1';
            
            // Navigate after animation
            setTimeout(() => {
                window.location.href = link.href;
            }, 200);
        }
    });
    
    // Hide transition when page loads
    window.addEventListener('pageshow', function() {
        pageTransition.style.opacity = '0';
        setTimeout(() => {
            pageTransition.style.pointerEvents = 'none';
        }, 300);
    });
});
</script>
<?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views/components/page-transition.blade.php ENDPATH**/ ?>