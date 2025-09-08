@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="px-2 py-1 text-xs bg-white border border-gray-300 rounded text-gray-500">&laquo;</span></li>
            @else
                <li class="page-item"><a class="px-2 py-1 text-xs bg-white border border-gray-300 rounded text-gray-500 hover:bg-gray-50" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="px-2 py-1 text-xs bg-white border border-gray-300 rounded text-gray-500 hover:bg-gray-50" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="px-2 py-1 text-xs bg-white border border-gray-300 rounded text-gray-500">&raquo;</span></li>
            @endif
        </ul>
    </nav>
@endif