@if ($paginator->hasPages())
    <nav class="flex items-center justify-center space-x-2 mt-8" role="navigation" aria-label="Pagination Navigation">
        <!-- Previous Page Link -->
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-sm leading-4 text-gray-500 bg-gray-800 border border-gray-700 rounded-md cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" 
               class="px-3 py-2 text-sm leading-4 text-gray-300 bg-gray-800 border border-gray-700 rounded-md hover:bg-gray-700 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
        @endif

        <!-- Pagination Elements -->
        @foreach ($elements as $element)
            <!-- "Three Dots" Separator -->
            @if (is_string($element))
                <span class="px-3 py-2 text-sm leading-4 text-gray-500 bg-gray-800 border border-gray-700 rounded-md">{{ $element }}</span>
            @endif

            <!-- Array Of Links -->
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-2 text-sm leading-4 text-white bg-[#f59e0b] border border-[#f59e0b] rounded-md font-medium">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" 
                           class="px-3 py-2 text-sm leading-4 text-gray-300 bg-gray-800 border border-gray-700 rounded-md hover:bg-gray-700 hover:text-white transition-colors">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        <!-- Next Page Link -->
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" 
               class="px-3 py-2 text-sm leading-4 text-gray-300 bg-gray-800 border border-gray-700 rounded-md hover:bg-gray-700 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        @else
            <span class="px-3 py-2 text-sm leading-4 text-gray-500 bg-gray-800 border border-gray-700 rounded-md cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        @endif
    </nav>
@endif
