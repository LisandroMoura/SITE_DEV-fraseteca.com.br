@php
if (!isset($lastPage)) {
    return;
}
$query = $query ?? null;
@endphp
@if ($lastPage > 1)
    <div class="navegacao"
        @if (isset($accordion)) id="navega_{{ $accordion }}"  
            data-atual="{{ $currentPage }}"
            data-go="{{ $accordion }}" @endif>
        @if ($currentPage == 1)
            <a class="navegacao--item prev disabled">
                <i class="ico ico-seta-left disabled"></i>
                <span>Anterior</span>
            </a>
        @else
            <a href="{{ $path }}?page={{ $currentPage - 1 }}{{ $query }}" rel="prev"
                data-action="{{ $currentPage - 1 }}" class="navegacao--item prev">
                <i class="ico ico-seta-left "></i>
                <span>Anterior</span>
            </a>
        @endif
        @for ($i = 1; $i <= $lastPage; $i++)
            @if ($currentPage == $i)
                <a class="navegacao--item box active">{{ $i }}</a>
            @else
                <a href="{{ $path }}?page={{ $i }}{{ $query }}" rel="page"
                    data-action="{{ $i }}" class="navegacao--item box"> {{ $i }} </a>
            @endif
        @endfor

        @if ($lastPage == $currentPage)
            <a class="navegacao--item disabled next">
                <span>Próximo</span>
                <i class="ico ico-seta-next disabled"></i>
            </a>
        @else
            <a href="{{ $path }}?page={{ $currentPage + 1 }}{{ $query }}" rel="next"
                data-action="{{ $currentPage + 1 }}" class="navegacao--item next">
                <span>Próximo</span>
                <i class="ico ico-seta-next"></i>
            </a>
        @endif
        @if (isset($accordion))
            <input type="hidden" id="navega_{{ $accordion }}_currentPage" value="{{ $currentPage }}">
        @endif
    </div>
@endif
