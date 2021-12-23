@if(isset($elements) && $paginator->hasPages())
    <div class="table-navigation">
        <div class="table-info">
            {{__('paginator.show')}} {{$paginator->count()}} {{__('paginator.article')}} {{$paginator->total()}}
        </div>
        <div class="pagination table-pagination">
            <!-- Ссылка на предыдущую страницу -->
            @if (!$paginator->onFirstPage())
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link icon-arrow-left"></a>
            @endif
        <!-- Элементы страничной навигации -->
            @foreach ($elements as $element)

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a href="javascript:void(0)" class="pagination-link active">{{ $page }}</a>
                        @else
                            <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        <!-- Ссылка на следующую страницу -->
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link icon-arrow-right"></a>
            @endif
        </div>
    </div>
@endif
