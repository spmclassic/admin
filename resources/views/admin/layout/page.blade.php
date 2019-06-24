@if ($paginator->hasPages())
    <div class="page mt20">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
           <span>第一页</span>
        @else
           <a href="{{ $paginator->previousPageUrl() }}" rel="pre">上一页</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span>{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="current">{{ $page }}</span>
                    @else
                            <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
           <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="next">下一页</a>
        @else
            <span>最后一页</span>
        @endif
    </div>
@endif
