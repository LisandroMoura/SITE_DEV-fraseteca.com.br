@php
    $classlogado = isset($logado) ? "logado" : "";
    $notificacoes = 0;
    if(isset($logado))
        if($logado->perfil=="1"){
            $notifica     = $logado->getNotificAdm();
            $notificacoes = intval($notifica["pending"]);
        }
@endphp
{{-- <div class="float-rights {{$classlogado}}">     --}}
    @if ($amp) 
        <ul class="menu-usuario no-print">
            <li><a href="https://fraseteca.com.br/login" class="botao-padrao no-print float-right" rel="noopener noreferrer" title="Acessar">Entrar</a></li>
        </ul>
    @else      
        @if (isset($logado))        
            @php $avatar = $logado->getAvatarAttribute(); @endphp
            <ul class="menu--usuario logado no-print ">
                <li class="menu--usuario--item"><a class="principal padrao-icone" href="/feed"><i class="ico ico-home"></i></a></li>
                <li class="menu--usuario--item"><a class="principal padrao-icone" href="{{route("usuario.minhasFrases")}}"><i class="ico ico-minhas-frases"></i></a></li>
                <li class="menu--usuario--item menu--usuario--item-perfil pai">
                    <div class="botao-abre-menu-usuario abreMenuUsuario_desk">
                        <img src="{{$avatar}}" alt="perfil do usuário" class="avatar no-interact">
                        @if (count($logado->notific) + intval($notificacoes))
                            <div class="notific__icon">
                                <span class="circle">{{count($logado->notific) + intval($notificacoes) }}</span>
                            </div>                                
                        @endif  
                        
                        <ul class="menu-usuario-perfil menu-usuario-perfil_desk">                                
                            <li class="header-wrapper">
                                <div class="col-avatar">                                    
                                    <img src="{{$avatar}}" alt="" class="avatar inner no-interact">                                    
                                </div>
                                <div class="col-nome">
                                    <a href="{{"/perfil/".$logado->name. '.' .$logado->id}}" class="nome">
                                        {{$logado->nome_completo}}
                                    </a>
                                    <a href="{{"/perfil/".$logado->name. '.' .$logado->id}}">Ver meu perfil</a>
                                    @if ($logado->perfil=="1")
                                        <a href="{{route("back.Painel")}}" class="pai">
                                            <span class="no-interact">Painel Admin</span>                                            
                                            @if ($notifica["pending"])
                                                <div class="notific__smallball isAdm"></div>                                            
                                            @endif
                                        </a>
                                    @endif
                                    
                                </div>
                            </li>
                            <li class="itens">
                                <ul>
                                    <li class="item">
                                        <a href="{{route("usuario.feed")}}" title="Ver:">
                                            <i class="ico ico-home-menu"></i>
                                            <span>meu feed</span>  
                                        </a>                                    
                                    </li>
                                    <li class="item">
                                        <a href="/minhas-frases">
                                            <i class="ico ico-minhas-frases-menu"></i>
                                            <span class="no-interact">minhas frases</span>
                                            @if (count($logado->notific))
                                                <div class="notific__icon">
                                                    <span class="circle">{{count($logado->notific)}}</span>
                                                </div>                                            
                                            @endif
                                        </a>
                                    </li>
                                    <li class="item">
                                        <a href="{{route("usuario.edit", $logado->id)}}">
                                            <i class="ico ico-config"></i>
                                            <span class="no-interact">configurações</span>
                                        </a>
                                    </li>
                                    <li class="item">
                                        <a href="{{route("logout")}}">
                                            <i class="ico ico-logout"></i>
                                            <span class="no-interact">Sair</span>
                                        </a>
                                    </li>  
                                </ul>
                            </li>
                        </ul>
                        <div class="icone-seta">
                            <a href="#" class="padrao-icone">
                                <i class="ico ico-seta"></i>
                            </a>
                        </div> 
                    </div>
                                        
                </li>                
            </ul>
        @else 
            <ul class="menu--usuario no-print">
                <li><a href="https://fraseteca.com.br/login" class="botao-padrao no-border-mobile no-print" rel="noopener noreferrer" title="Acessar">Entrar</a></li>
            </ul>
        @endif        
    @endif
{{-- </div> --}}