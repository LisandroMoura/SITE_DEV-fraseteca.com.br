<a @if ($amp) href="{{$url}}" @else href="#" @endif 
    class="botao-padrao red callLogin bt-seguir {{$class ?? ""}} {{$seguindo}}" 
    title="{{$title ?? "Para seguir você precisa se cadastrar."}}"
    data-lblBtconfirm="Fazer login"
    data-lblBtcancel="Não agora ☹️"
    >
    @if ($seguindo=="enable")
        Seguir                                                         
    @else
        Seguindo 
        {{-- <span class="ico ico-seguindo"></span> --}}
    @endif                                                    
</a>                                