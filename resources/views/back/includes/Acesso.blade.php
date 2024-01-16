@if ($amp) 
    {{-- Fraseteca2023Set03 
        date: 25-set-2023   
        obs: mudar o link do login para o endereço do site fixo    
    --}}
    <div class="acesso no-print">    
        <a href="https://fraseteca.com.br/login" class="bt-acessar" rel="noopener noreferrer" title="Acessar">Acessar</a>
        <a href="https://fraseteca.com.br/login" class="btn bt-criarlista">Criar lista</a>
        <a href="https://fraseteca.com.br/login" class="bt-criarlista-small only-mobile"><i class="icon icone icon-005-plus"></i></a>
    </div>
@else
    <div class="acesso no-print">    
        @php $logado     = \Auth::user(); @endphp
        @if (isset($logado))
            @php
                $avatar = $logado->getAvatarAttribute();
            @endphp

            <div class="icone-perfil-logado no-mobile"            
                {{-- data-src="{{$avatar}}" --}}
                style="background-size: cover; background-image:url({{$avatar}})">
                <a 
                class="afull"    
                href="{{"/perfil/".$logado->name. '.' .$logado->id}}"
                title="Ver seu perfil"
                rel="nofollow"
                >perfil</a>
            </div>
            
        @else 
            <a href="https://fraseteca.com.br/login" class="bt-acessar" rel="noopener noreferrer" title="Acessar">Acessar</a>
            <a href="https://fraseteca.com.br/login" class="btn bt-criarlista">Criar lista</a>
            <a href="https://fraseteca.com.br/login" class="bt-criarlista-small only-mobile"><i class="icon icone icon-005-plus"></i></a>
        @endif
    </div>
@endif