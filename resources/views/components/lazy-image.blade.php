{{-- Lazy loading image component --}}
@props([
    'src' => '',
    'alt' => '',
    'class' => '',
    'width' => '',
    'height' => '',
    'placeholder' => 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjQwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IiMxMTExMTEiLz48dGV4dCB4PSIyMDAiIHk9IjE1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjE2IiBmaWxsPSIjNjY2NjY2IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSI+TG9hZGluZy4uLjwvdGV4dD48L3N2Zz4='
])

<img 
    src="{{ $placeholder }}" 
    data-src="{{ $src }}" 
    alt="{{ $alt }}"
    class="lazy {{ $class }}"
    @if($width) width="{{ $width }}" @endif
    @if($height) height="{{ $height }}" @endif
    loading="lazy"
    onload="this.style.opacity='1'"
    style="opacity: 0; transition: opacity 0.3s ease;"
>

@once
    @push('scripts')
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
    @endpush
@endonce
