@php    
    $dados = $dadosdoautor ?? null;
    $tipo  = $tipo ?? "normal"; 
    $conquista="Top Usuário";
    $icone_conquista="super-fan";
    if(!isset($dados)) return "";
@endphp
<div class="biografia--perfil">
    <div class="biografia--perfil--col--avatar">
        <a @if ($tipo!="perfil") href="/{{$dados['link-autor']}}" @endif title="Perfil de {{$dados['nome-autor']}}">
            @if ($amp) 
                <amp-img class="lazy-hidden avatar perfil" media="(min-width: 55px)" src="{{ $dados['avatar'] }}" width="153" height="153" layout="fixed" alt="Perfil de {{$dados['nome-autor']}}"></amp-img>
            @else
                <img class="_lazy-hidden avatar perfil"  src="{{ $dados['avatar'] }}" width="153" height="153"  alt="Perfil de {{$dados['nome-autor']}}">
            @endif
        </a>
    </div>
    <div class="biografia--perfil--col--texto">
        <div class="biografia--col--conteudo--texto-autor">
            <a itemprop="author" @if ($tipo!="perfil") href="/{{$dados['link-autor']}}" @endif title="Perfil de {{$dados['nome-autor']}}">
            {{$dados['nome-autor']}}</a>
            @if (isset($dados["conquista"]["nome"]))
                <span class="topusuario">Top usuário </span>
                <i class="ico ico-selo"></i>
            @endif
            
        </div>
        <div class="biografia--col--conteudo--descricao">
            {{$dados['em-uma-frase'] ?? "Sem informações no momento..."}}
        </div>

        <div class="biografia--col--conteudo--link">
            <a href="{{ $dados['url'] ?? "" }}" class="link">
                <i class="ico ico-link"></i> <span>{{ $dados['url'] ?? "fraseteca.com.br/perfil/{$dados['nome-autor']}" }}</span>
            </a>
        </div>
    </div>
</div>


{{-- <div class="biografia">
    <div class="row bio">                
        <div class="bio-wrapper">
            <div class="area-do-autor {{$tipo}}">
                <div class="icone-do-autor {{$tipo}}">                    
                    <a 
                        @if ($tipo!="perfil")
                            href="/{{$dados['link-autor']}}"                                 
                        @endif                             
                        title="Perfil de {{$dados['nome-autor']}}">
                        @if ($amp)
                            <amp-img
                                class="lazy-hidden" 
                                media="(min-width: 82px)"
                                src="{{ $dados['avatar'] }}"
                                width="82"
                                height="82"
                                layout="fixed"
                                alt="Perfil de {{$dados['nome-autor']}}"
                                >
                            </amp-img>                        
                        @else
                            <img class="lazy-hidden" src="{{ $dados['avatar'] }}" alt="Perfil de {{$dados['nome-autor']}}">
                            @if ($tipo=="perfil")
                                @if (isset($logado))
                                    @if ($logado->id == $dados["id"])
                                        <a href="{{route("usuario.edit", $logado->id)}}" class="bt-editar-perfil"><i class="ico ico-pencil"></i></a>
                                    @endif
                                @endif               
                            @endif             
                        @endif
                    </a>
                </div>
                <div class="texto-do-autor {{$tipo}}">                    
                    <div class="conquista-do-usuario smsall-mobile">
                        <div class="inserida-por">Inserida por</div>
                        <div class="conquista">
                            @if (isset($dados["conquista"]["nome"]))
                                <div class="icone-box"><i class="icone {{$dados["conquista"]["icone"] ?? "super-fan"}}"></i></div>
                                <div class="icone-label">{{$dados["conquista"]["nome"]}}</div>    
                            @endif 
                        </div>
                    </div>
                    <h3 class="titulo {{$tipo}}">
                        <a itemprop="author"                             
                            name="{{$dados['nome-autor']}}"
                            @if ($tipo!="perfil")
                                href="/{{$dados['link-autor']}}"                                 
                            @endif                             
                             rel="no0-follow"
                             title="Perfil de {{$dados['nome-autor']}}">
                            <span itemprop="name">
                               {{$dados['nome-autor'] ?? $dados['nome_completo'] }}
                            </span>
                        </a>
                    </h3>
                    @if ($tipo=="perfil")
                        <span class="em-uma-frase">{{$dados['em-uma-frase']}}</span>
                        @if ($dados['url'])                            
                            <a href="{{$dados['url']}}" rel="nofollow" class="link-do-autor">
                                <span class="ico ico-globinho"></span>

                                {{$dados['textoDoLink'] }}

                            </a>                            
                        @endif
                        
                    @endif                    
                    <div class="strutuctured" style="display: none;">
                            <span  style="display: none;" rel="bookmark">
                                <time 
                                    itemprop="datePublished" 
                                    datetime="{{data_get($seo,"published_time","")}}">
                                    {{data_get($seo,"published_time","")}}                            
                                </time>
                            </span>
                            <span  style="display: none;" rel="bookmark">
                                <time 
                                    itemprop="dateModified" 
                                    datetime="{{data_get($seo,"modified_time","")}}">
                                    {{data_get($seo,"modified_time","")}}                           
                                </time>
                            </span>
        
                            <span  style="display: none;" rel="bookmark">
                                <a 
                                    itemprop="mainEntityOfPage" 
                                    href="/{{$dados['link-autor']}}"                                                                
                                    > 
                                    ver                          
                                </a>
                            </span>                            
                    </div>                    
                </div>
            </div>            
        </div>
    </div>
</div> --}}

