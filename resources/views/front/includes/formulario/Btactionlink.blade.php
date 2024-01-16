<a 

@if (isset($value))
    href="@if (isset($rota)) {{route($rota, mb_strtolower($value))}} @endif"
@else 
    href="{{$rota}}"
@endif
class='btn {{ $class ?? "" }} btn-add-card {{ $icone ?? "" }} ' 
title="{{ $tip ?? "Executar" }}"
target="blank"
@if (isset($vaction))
    v-on:click="{{$vaction}}"
@endif
>
    {{$label}}
</a>
