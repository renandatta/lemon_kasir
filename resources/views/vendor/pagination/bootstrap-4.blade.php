@if ($paginator->hasPages())
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex flex-wrap py-2 mr-3">
            <a @if (!$paginator->onFirstPage()) href="javascript:void(0)" onclick="search_data('-1')" @endif class="btn btn-icon btn-sm btn-light-success mr-2 my-1">
                <i class="ki ki-bold-arrow-back icon-xs"></i>
            </a>

            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <a class="btn btn-icon btn-sm border-0 btn-hover-success mr-2 my-1">...</a>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a class="btn btn-icon btn-sm border-0 btn-hover-success active mr-2 my-1">{{ $page }}</a>
                        @else
                            <a href="javascript:void(0)" onclick="search_data({{ $page }})" class="btn btn-icon btn-sm border-0 btn-hover-success mr-2 my-1">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif

            @endforeach

            <a @if ($paginator->hasMorePages()) href="javascript:void(0)" onclick="search_data('+1')" @endif class="btn btn-icon btn-sm btn-light-success mr-2 my-1"><i class="ki ki-bold-arrow-next icon-xs"></i></a>
        </div>
        <div class="d-flex align-items-center py-3">
            <span class="text-muted">Menampilkan {{ $paginator->perPage() }} dari {{ $paginator->total() }} data</span>
        </div>
    </div>
@endif
