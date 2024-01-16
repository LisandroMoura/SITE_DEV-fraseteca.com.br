<a href="@if (isset($rota)) {{route($rota)}} @endif"
class='btn btn-add {{ $icone ?? "" }}' 
title="{{ $tip ?? "Inserir" }}"
>
    
     <i class="icon-plus"></i>
    
</a>
