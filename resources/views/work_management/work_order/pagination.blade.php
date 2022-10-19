<div class="d-flex justify-content-between flex-wrap pagination-container mb-5">
    
    @if ($paginator->hasPages() || (request()->input('total') >= $paginator->total() && $paginator->total() > 0))
        @php
            $link_limit = 4;
        @endphp
        <style>
            .btn.btn-hover-primary:not(:disabled):not(.disabled).active,
            .btn.btn-hover-primary:not(:disabled):not(.disabled):active:not(.btn-text),
            .show .btn.btn-hover-primary.btn-dropdown,
            .show>.btn.btn-hover-primary.dropdown-toggle {
                color: #fff !important;
                background-color: #3699FF !important;
                border-color: #3699FF !important;
            }

            .btn.btn-hover-primary.focus:not(.btn-text),
            .btn.btn-hover-primary:focus:not(.btn-text),
            .btn.btn-hover-primary:hover:not(.btn-text):not(:disabled):not(.disabled) {
                color: #fff !important;
                background-color: #3699FF !important;
                border-color: #3699FF !important;
            }

        </style>
        <!--begin::Pagination-->

        {{-- <div class="d-flex justify-content-between flex-wrap"> --}}
        <div class="d-flex flex-wrap">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())

            @else
                <a class="icon item btn btn-icon btn-sm btn-light mr-2 my-1" aria-label="@lang('pagination.previous')"
                    href="{{ $paginator->url(1) }}"> <i class="ki ki-bold-double-arrow-back icon-xs"></i> </a>
                <a class="icon item btn btn-icon btn-sm btn-light mr-2 my-1" href="{{ $paginator->previousPageUrl() }}"
                    rel="prev" aria-label="@lang('pagination.previous')">
                    <i class="ki ki-bold-arrow-back icon-xs"></i> </a>
            @endif
            {{-- Pagination Elements --}}
            @if ($paginator->currentPage() > $paginator->onFirstPage() + 2)
                <a class="item btn btn-icon btn-sm border-0 btn-light btn-hover-primary mr-2 my-1" href="#"
                    aria-current="page">...</a>
            @endif
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                @php
                    $half_total_links = floor($link_limit / 2);
                    $from = $paginator->currentPage() - $half_total_links;
                    $to = $paginator->currentPage() + $half_total_links;
                    if ($paginator->currentPage() < $half_total_links) {
                        $to += $half_total_links - $paginator->currentPage();
                    }
                    if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                        $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
                    }
                @endphp
                @if ($from < $i && $i < $to)
                    <a class="item btn btn-icon btn-sm border-0 btn-light btn-hover-primary {{ $paginator->currentPage() == $i ? ' active' : '' }} mr-2 my-1"
                        href="{{ $paginator->url($i) }}" aria-current="page">{{ $i }}</a>
                @endif
            @endfor
            @if ($paginator->currentPage() < $paginator->lastPage() - 1)
                <a class="item btn btn-icon btn-sm border-0 btn-light btn-hover-primary mr-2 my-1" href="#"
                    aria-current="page">...</a>
            @endif
            {{-- <a href="#" class="btn btn-icon btn-sm border-0 btn-light mr-2 my-1">...</a> --}}
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="icon item btn btn-icon btn-sm btn-light mr-2 my-1" href="{{ $paginator->nextPageUrl() }}"
                    rel="next" aria-label="@lang('pagination.next')"> <i class="ki ki-bold-arrow-next icon-xs"></i>
                </a>
                <a class="icon item btn btn-icon btn-sm btn-light mr-2 my-1"
                    href="{{ $paginator->url($paginator->lastPage()) }} " aria-label="@lang('pagination.next')">
                    <i class="ki ki-bold-double-arrow-next icon-xs"></i> </a>
            @else

            @endif
        </div>
    @endif
    
</div>