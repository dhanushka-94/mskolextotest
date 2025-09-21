
<div id="loading-screen" class="fixed inset-0 z-[9999] bg-black flex items-center justify-center">
    <!-- Animated Background -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Animated circles -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/5 rounded-full animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-primary-400/10 rounded-full animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary-600/5 rounded-full animate-spin-fast"></div>
        
        <!-- Floating particles -->
        <div class="floating-particles">
            <?php for($i = 0; $i < 20; $i++): ?>
                <div class="particle" style="animation-delay: <?php echo e($i * 0.5); ?>s; left: <?php echo e(rand(10, 90)); ?>%; top: <?php echo e(rand(10, 90)); ?>%;"></div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Main Loading Content -->
    <div class="relative z-10 text-center">
        <!-- Logo Container -->
        <div class="mb-8">
            <div class="logo-container relative">
                <!-- Animated ring around logo -->
                <div class="absolute inset-0 rounded-full border-4 border-primary-500/30 animate-ping"></div>
                <div class="absolute inset-2 rounded-full border-2 border-primary-400/50 animate-pulse"></div>
                
                <!-- Logo -->
                <div class="relative bg-black/50 backdrop-blur-sm rounded-full p-8 border border-primary-500/20">
                    <img src="<?php echo e(asset('msk-computers-logo-color.png')); ?>" 
                         alt="MSK Computers" 
                         class="w-24 h-24 mx-auto object-contain animate-bounce-fast">
                </div>
                
                <!-- Rotating glow effect -->
                <div class="absolute inset-0 rounded-full bg-gradient-to-r from-primary-500/20 via-transparent to-primary-400/20 animate-spin-fast"></div>
            </div>
        </div>

        <!-- Company Name -->
        <div class="mb-6">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-2 animate-fade-in-up">
                <span class="text-primary-400">MSK</span> <span class="text-white">Computers</span>
            </h1>
            <p class="text-gray-300 text-lg animate-fade-in-up delay-300">
                Sri Lanka's Trusted Computer Specialist
            </p>
        </div>

        <!-- Loading Animation -->
        <div class="loading-dots mb-8">
            <div class="flex justify-center items-center space-x-2">
                <div class="loading-dot bg-primary-500 w-3 h-3 rounded-full animate-bounce-fast"></div>
                <div class="loading-dot bg-primary-400 w-3 h-3 rounded-full animate-bounce-fast delay-75"></div>
                <div class="loading-dot bg-primary-300 w-3 h-3 rounded-full animate-bounce-fast delay-150"></div>
            </div>
            <p class="text-gray-400 mt-4 animate-pulse">Loading amazing products...</p>
        </div>

        <!-- Progress Bar -->
        <div class="w-64 mx-auto">
            <div class="bg-gray-700 rounded-full h-2 overflow-hidden">
                <div class="loading-progress bg-gradient-to-r from-primary-500 to-primary-400 h-full rounded-full transition-all duration-300 ease-out"></div>
            </div>
            <div class="flex justify-between text-xs text-gray-500 mt-2">
                <span>Loading</span>
                <span id="loading-percentage">0%</span>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom animations */
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes spin-fast {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    @keyframes bounce-fast {
        0%, 100% {
            transform: translateY(0);
            animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
        }
        50% {
            transform: translateY(-25%);
            animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px) scale(1);
            opacity: 0.7;
        }
        50% {
            transform: translateY(-20px) scale(1.1);
            opacity: 1;
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out forwards;
    }

    .animate-spin-fast {
        animation: spin-fast 2s linear infinite;
    }

    .animate-bounce-fast {
        animation: bounce-fast 0.8s infinite;
    }

    .delay-75 {
        animation-delay: 0.075s;
    }

    .delay-150 {
        animation-delay: 0.15s;
    }

    .delay-100 {
        animation-delay: 0.1s;
    }

    .delay-200 {
        animation-delay: 0.2s;
    }

    .delay-300 {
        animation-delay: 0.3s;
    }

    .delay-1000 {
        animation-delay: 1s;
    }

    /* Floating particles */
    .floating-particles {
        position: absolute;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: linear-gradient(45deg, #f59e0b, #d97706);
        border-radius: 50%;
        animation: float 3s ease-in-out infinite;
        opacity: 0.6;
    }

    /* Loading progress animation */
    .loading-progress {
        width: 0%;
        animation: loading-progress 1.5s ease-out forwards;
    }

    @keyframes loading-progress {
        0% {
            width: 0%;
        }
        20% {
            width: 30%;
        }
        40% {
            width: 60%;
        }
        70% {
            width: 85%;
        }
        100% {
            width: 100%;
        }
    }

    /* Logo pulse effect */
    .logo-container img {
        filter: drop-shadow(0 0 20px rgba(245, 158, 11, 0.3));
    }

    /* Hide scrollbar during loading */
    body.loading {
        overflow: hidden;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadingScreen = document.getElementById('loading-screen');
    const loadingPercentage = document.getElementById('loading-percentage');
    let progress = 0;

    // Add loading class to body
    document.body.classList.add('loading');

    // Simulate loading progress
    const progressInterval = setInterval(() => {
        progress += Math.random() * 40 + 10; // Faster progress increments
        if (progress > 100) progress = 100;
        
        if (loadingPercentage) {
            loadingPercentage.textContent = Math.round(progress) + '%';
        }
        
        if (progress >= 100) {
            clearInterval(progressInterval);
            setTimeout(hideLoadingScreen, 300);
        }
    }, 100); // Faster interval

    // Hide loading screen
    function hideLoadingScreen() {
        if (loadingScreen) {
            loadingScreen.style.opacity = '0';
            loadingScreen.style.transition = 'opacity 0.5s ease-out';
            
            setTimeout(() => {
                loadingScreen.style.display = 'none';
                document.body.classList.remove('loading');
                
                // Trigger entrance animations for page content
                document.body.style.opacity = '0';
                document.body.style.animation = 'fade-in-up 0.6s ease-out forwards';
            }, 500);
        }
    }

    // Ensure loading screen is hidden after maximum time
    setTimeout(hideLoadingScreen, 2000); // Reduced from 4 seconds to 2 seconds
    
    // Hide when page is fully loaded
    window.addEventListener('load', () => {
        setTimeout(hideLoadingScreen, 500);
    });
});
</script>
<?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views/components/loading-screen.blade.php ENDPATH**/ ?>