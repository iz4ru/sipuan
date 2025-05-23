<nav aria-label="Page navigation example">
    <ul class="inline-flex -space-x-px text-sm">
        <!-- Previous Button -->
        <li>
            <a href="{{ $paginator->previousPageUrl() }}"
                class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700{{ $paginator->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}">
                Previous
            </a>
        </li>

        <!-- Page Numbers -->
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            <li>
                <a href="{{ $url }}"
                    class="flex items-center justify-center px-3 h-8 leading-tight border border-gray-300 hover:bg-gray-100 hover:text-gray-700{{ $paginator->currentPage() === $page ? 'text-blue-600 bg-blue-50 dark:bg-[#0FA3FF] dark:text-white' : 'text-gray-500 bg-white' }}">
                    {{ $page }}
                </a>
            </li>
        @endforeach

        <!-- Next Button -->
        <li>
            <a href="{{ $paginator->nextPageUrl() }}"
                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700{{ $paginator->hasMorePages() ? '' : 'opacity-50 cursor-not-allowed' }}">
                Next
            </a>
        </li>
    </ul>
</nav>
