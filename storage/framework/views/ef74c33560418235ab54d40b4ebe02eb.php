
<div id="smooth-loader" class="fixed top-4 right-4 z-[9999] pointer-events-none opacity-0 transition-all duration-300">
    <div class="bg-black/90 backdrop-blur-sm border border-primary-500/20 rounded-xl p-4 shadow-2xl">
        <div class="flex items-center space-x-3">
            <!-- Spinning logo -->
            <div class="w-8 h-8 bg-primary-500/10 rounded-full flex items-center justify-center">
                <img src="<?php echo e(asset('msk-computers-logo-color.png')); ?>" 
                     alt="Loading" 
                     class="w-5 h-5 animate-spin">
            </div>
            
            <!-- Loading text -->
            <div class="text-white">
                <p class="text-sm font-medium">Processing...</p>
                <div class="flex space-x-1 mt-1">
                    <div class="w-1 h-1 bg-primary-400 rounded-full animate-bounce"></div>
                    <div class="w-1 h-1 bg-primary-400 rounded-full animate-bounce delay-100"></div>
                    <div class="w-1 h-1 bg-primary-400 rounded-full animate-bounce delay-200"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
class SmoothLoader {
    constructor() {
        this.loader = document.getElementById('smooth-loader');
        this.isVisible = false;
        this.init();
    }

    init() {
        // Show loader for AJAX requests
        this.interceptAjaxRequests();
        
        // Show loader for form submissions
        this.interceptFormSubmissions();
        
        // Show loader for add to cart actions
        this.interceptCartActions();
    }

    show(message = 'Processing...') {
        if (this.loader && !this.isVisible) {
            const textElement = this.loader.querySelector('p');
            if (textElement) {
                textElement.textContent = message;
            }
            
            this.loader.style.opacity = '1';
            this.loader.style.transform = 'translateY(0) scale(1)';
            this.isVisible = true;
        }
    }

    hide() {
        if (this.loader && this.isVisible) {
            this.loader.style.opacity = '0';
            this.loader.style.transform = 'translateY(-10px) scale(0.95)';
            this.isVisible = false;
        }
    }

    interceptAjaxRequests() {
        // Intercept fetch requests
        const originalFetch = window.fetch;
        window.fetch = (...args) => {
            this.show('Loading...');
            return originalFetch(...args)
                .then(response => {
                    this.hide();
                    return response;
                })
                .catch(error => {
                    this.hide();
                    throw error;
                });
        };

        // Intercept XMLHttpRequest
        const originalOpen = XMLHttpRequest.prototype.open;
        XMLHttpRequest.prototype.open = function(...args) {
            this.addEventListener('loadstart', () => window.smoothLoader?.show('Loading...'));
            this.addEventListener('loadend', () => window.smoothLoader?.hide());
            return originalOpen.apply(this, args);
        };
    }

    interceptFormSubmissions() {
        document.addEventListener('submit', (e) => {
            // Only show for forms that aren't file uploads or GET methods
            const form = e.target;
            if (form.method?.toLowerCase() !== 'get' && !form.enctype?.includes('multipart')) {
                this.show('Submitting...');
                
                // Hide after 5 seconds as fallback
                setTimeout(() => this.hide(), 5000);
            }
        });
    }

    interceptCartActions() {
        // Show loader for add to cart buttons
        document.addEventListener('click', (e) => {
            const button = e.target.closest('button');
            if (button && (
                button.textContent?.includes('Add to Cart') ||
                button.onclick?.toString().includes('addToCart') ||
                button.getAttribute('onclick')?.includes('addToCart')
            )) {
                this.show('Adding to cart...');
                
                // Hide after 3 seconds as fallback
                setTimeout(() => this.hide(), 3000);
            }
        });
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.smoothLoader = new SmoothLoader();
});

// Export for manual usage
window.showLoader = (message) => window.smoothLoader?.show(message);
window.hideLoader = () => window.smoothLoader?.hide();
</script>

<style>
#smooth-loader {
    transform: translateY(-10px) scale(0.95);
}

.delay-100 {
    animation-delay: 0.1s;
}

.delay-200 {
    animation-delay: 0.2s;
}
</style>
<?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views/components/smooth-loader.blade.php ENDPATH**/ ?>