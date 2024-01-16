@php
    if ($nivel == 0 ) 
        $label = "Responder";
    else 
        $label = "Responder";
@endphp
<a
    @if (isset($logado)) 
        href="#comentario-titulo"
        rel="nofollow"
        class="botao-padrao no-border nivel_{{ $nivel }} bt-responder"  
        data-autor="{{ $autor ?? "" }}"
        title="{{ $title ?? "" }}"                                                  
    @else
        href="/login"
        rel="nofollow"
        title="Para poder comentar no site, você precisa ter cadastro e fazer login. Deseja fazer Login?" 
        class="botao-padrao no-border nivel_{{ $nivel }} callLogin_" @endif
    >
    
    {{ $label }}
</a>