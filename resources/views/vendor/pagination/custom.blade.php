@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true">
                    <span aria-hidden="true" class="pagination-arrow">←</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')" class="pagination-arrow">←</a>
                </li>
            @endif

            {{-- Current Page Indicator --}}
            <li class="page-indicator">
                <span class="current-page">{{ $paginator->currentPage() }}</span>
            </li>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')" class="pagination-arrow">→</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true">
                    <span aria-hidden="true" class="pagination-arrow">→</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
