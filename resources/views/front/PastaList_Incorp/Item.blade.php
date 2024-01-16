@php
    $ncount=0;


@endphp
<ul class="{{$classUl ?? "relacionadas"}} {{$tipo}}">
    @foreach ($dados as $item)
        @php
            $showItem = true;
            $callAction  = '/pastas/'.$item->id."/edit";
            $classCapa   = "comcapa";
            $situacao    = "fechada";  
            $ownerID     = $item->usuario_id;
            $emusoClass  = "";  

            if($item->post_id){
                $post = App\Entities\Post::find($item->post_id);
                if($post){
                    $ownerID = $post->autor_id;
                    if($post->status > "1")
                        $showItem = false;
                }
                else 
                    $showItem = false;
            }
            //ver esta questão de pasta secreta
            $ncount++;                
            
            $capa = $item->capa;
            if(trim($capa) ==="")
                $capa = $item->capa;
            if($capa=="") {
                $capa = $item->thumb;
                //$capa   = "/images/default/pasta-desktop-v03.svg";
                $classCapa = "img-null";
            }

            if($showItem){
                if($item->post_id !=  ""){
                    $callAction = $item->getLinkAttribute();
                    $images = $item->getThumbThePost();
                    if (isset($images["capa"]))                    
                        $capa = $images["capa"];
                    if (isset($images["thumb"]))                    
                        $capa = $images["thumb"];
                    $situacao = "compartilhada";
                }                
                if ($item->status == "0"){
                    $situacao    = "fechada";
                }
                if ($item->emuso == "1")
                    $emusoClass  = "emuso";  
                
                if ($item->status == "1")
                    $situacao    = "compartilhada";  

                if($logado->id !=  $ownerID){                    
                    //$callAction  = '/pastas/naoeditavel/'.$item->id;
                    $situacao = "de-outro";                    
                }

                if ($item->status == "2"){
                    $situacao    = "emaprovacao";  
                    $emusoClass  = "emaprovacao";

                }

                $total          = $dados->total();
                $path           = $dados->resolveCurrentPath();       
                $lastPage       = $dados->lastPage();
                $perPage        = $dados->perPage();
                $currentPage    = $dados->currentPage();     
            } 

        @endphp
        @if ($showItem)
            @if ($ncount == 1)
                <li>                 
                    <div class="imagem-zone">                                        
                        <a href="/pastas/create" 
                            class="add relacionadas-link-imagem-zone {{$tipo}}" title="Criar uma nova pasta">
                            <img src="/images/default/pasta-desktop-v03.svg" alt="{{$item->titulo}}" class="img-marcacao {{$classCapa}}">
                            <span class="span-bg img-null" style="background:#f6f6f6"></span>
                        </a>
                        <div class="cantos-arredondados-para-pastas add"></div>
                        <div class="tipo-de-pasta add">
                            <a href="/pastas/create" class="ico-wrapp add" title="Aqui você pode criar uma nova pasta">                                
                                <i class="ico ico-new"></i>
                            </a>                            
                        </div>                    
                    </div>
                    
                    <div class="texto-zone minhas-pastas add" >                        
                        <a  href="/pastas/create" title="Criar nova pasta">Criar Nova Pasta</a>
                    </div>
                </li>
            @endif
            <li>
                <div class="imagem-zone">
                    <div class="ultima {{$emusoClass}} {{ $situacao }}">
                        @if ($situacao == "emaprovacao")
                            Em revisão
                        @else
                            Pasta em uso
                        @endif                   
                    </div>
                    <div class="cantos-arredondados-para-pastas {{$classCapa}}"></div>
                    <div class="tipo-de-pasta {{$situacao}}">
                        @switch($situacao)
                            @case("fechada")
                                <a href="{{$callAction}}" class="ico-wrapp {{$situacao}}" title="Pasta secreta! só você tem acesso á este conteúdo!">
                                    <i class="ico ico-cadeado"></i>
                                </a>
                            @break
                            @case("de-outro")
                                <a href="{{$callAction}}" class="ico-wrapp {{$situacao}}" title="Esta pasta pertence a outro usuário do site e está em seus favoritos!">
                                    <i class="ico ico-clipse-invert"></i>
                                </a>
                            @break
                            @case("compartilhada")                            
                                <a href="{{$callAction}}" class="ico-wrapp {{$situacao}}" title="UAU! Esta sua pasta está compartilhada com o Mundo!">
                                    <i class="ico ico-share"></i>
                                </a >
                            @break                               
                            @case("emaprovacao")                            
                                <a  class="ico-wrapp {{$situacao}}" title="Esta pasta está aguardando a aprovação de nossos moderadores para ser publicada no site!">
                                    <i class="ico ico-espera"></i>
                                </a >
                            @break                               
                        @endswitch 
                    </div>
                    @if ($classCapa=="img-null")
                        <a @if ($situacao != "emaprovacao") href="{{$callAction}}" @endif class="{{$classCapa}} relacionadas-link-imagem-zone {{$tipo}}" title="Pasta: {{$item->titulo}}">
                            <img src="/images/default/pasta-desktop-v03.svg" alt="{{$item->titulo}}" class="img-marcacao {{$classCapa}}">
                            <span class="span-bg {{$classCapa}}" style="background-image:url({{$capa}})"></span>
                        </a>
                    @else
                        <a  @if ($situacao != "emaprovacao") href="{{$callAction}}"  @endif
                            class="{{$classCapa}} relacionadas-link-imagem-zone {{$tipo}}" title="Pasta: {{$item->titulo}}"                             
                            {{-- style="background-image:url({{$capa}})" --}}
                            >
                            <img src="/images/default/pasta-desktop-v03.svg" alt="{{$item->titulo}}" class="img-marcacao {{$classCapa}}">
                            <span class="span-bg" style="background-image:url({{$capa}})"></span>
                        </a> 
                    @endif
                    
                    
                </div>
                
                <div class="texto-zone {{$tipo}} @if ($amp) amp @endif " >
                    
                    <a  
                        @if ($situacao != "emaprovacao") href="{{$callAction}}"  @endif
                        title="{{$item->titulo}}">
                        {{$item->titulo}}
                    </a>
                    
                </div>
            </li>
        @endif
  
        
    @endforeach        
</ul>
@if (!count($dados))
<section>
   
    <div class="row">
        <div class="col no-content">
            <p class="no-content-text">{{ $title_funy ?? "Este perfil está mais vazio que carteira no fim do mês..."}}</p>
            <img  class="no-content-img lazy autoload" src="<?php echo asset('storage/images/broken_woman.webp'); ?>" alt="O usuário não tem lista de frases favoritas!">
            @if ($link_description)
                <p><a class="aqui_tem_link" href="{{$link_description}}">{{ $description ?? "O usuário não tem informações aqui"}}</a></p>                
            @else
                <p> {{ $description ?? "O usuário não tem informações aqui"}}</p>
            @endif

            <ul class="minhas-pastas pastas minhas-pastas flex">
                <li>                 
                    <div class="imagem-zone">                                        
                        <a href="/pastas/create" class="add relacionadas-link-imagem-zone pastas minhas-pastas" title="Criar uma nova pasta">
                            <img src="/images/default/pasta-desktop-v03.svg" alt="asdasdasd" class="img-marcacao img-null">
                            <span class="span-bg img-null" style="background:#f6f6f6"></span>
                        </a>
                        <div class="cantos-arredondados-para-pastas add"></div>
                        <div class="tipo-de-pasta add">
                            <a href="/pastas/create" class="ico-wrapp add" title="Aqui você pode criar uma nova pasta">                                
                                <i class="ico ico-new"></i>
                            </a>                            
                        </div>                    
                    </div>
                    
                    <div class="texto-zone minhas-pastas add">                        
                        <a href="/pastas/create" title="Criar nova pasta">Criar Nova Pasta</a>
                    </div>
                </li>   
            </ul>            
        </div>
    </div> 
    @php
        return ;
    @endphp
@endif
@if ($lastPage>1)
    <div class="wrapper-navegacao-perfil">
        @include('front.includes.Navegacao', [
        "amp" => false,        
        "accordion"     => $accordion,
        "lastPage"      => $lastPage,        
        "path"         => $path, 
        "query"         => "all",     
        ])
    </div>    
@endif