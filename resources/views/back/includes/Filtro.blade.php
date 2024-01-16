@php
    $filtro = '';
    $i=0;
@endphp
<div class="card filtro">    
    <div class="well">
        <ul>
            <li><span>{{$label ?? 'Filtrar: ' }}</span></li>            
            @foreach ($opt as $item => $value)
                @php $i++; @endphp                
                <li class="separador item{{$i}}"> | </li>
                <li>
                    <a href="@if (isset($rota)) {{route($rota, mb_strtolower($item))}} @endif">
                    {{$value}}
                    </a>
                </li>
            @endforeach
        </ul>    
    </div>    
</div>