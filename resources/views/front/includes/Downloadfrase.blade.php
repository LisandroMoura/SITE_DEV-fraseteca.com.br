@php
    $download = $tabela->nomeDownload ?? $capa; 
@endphp
<div class="hover-download {{ $class ?? "" }}">
    <a class="botao-callaction grid {{ $class ?? "" }}"                                    
    href="{{$download}}"                            
    download="{{$download}}">
        <span>Baixar Imagem</span>
        <i class="ico ico-download"></i>
    </a>
</div>