@if ($paginator->hasPages())

    <ul class="pagination">



        @if ($paginator->onFirstPage())
            <li class="disabled"><a href="javascript:void(0);" style="padding: 10px;border-radius: 0;"><img
                        src="frontend/img/Next.png" style="transform: rotate(180deg);" class="img-responsive"
                        alt="img-holiwood"></a></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" style="padding: 10px;border-radius: 0;" rel="prev"><img
                        src="frontend/img/Next.png" style="transform: rotate(180deg);" class="img-responsive"
                        alt="img-holiwood"></a></li>
        @endif







        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="disabled"><a href="javascript:void(0);">{{ $element }}</a></li>
            @endif







            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active my-active"><a href="javascript:void(0);">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach







        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next"><img src="frontend/img/Next.png"
                        class="img-responsive" alt="img-holiwood"></a></li>
        @else
            <li class="disabled"><a href="javascript:void(0);"><img src="frontend/img/Next.png" class="img-responsive"
                        alt="img-holiwood"></a></li>
        @endif

    </ul>

@endif
