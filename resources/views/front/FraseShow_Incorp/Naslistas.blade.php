@php

$id_ul="relacionados";
$classe="nas-listas";
$pontuacao=0;
$classCount="space-center";
$cont_4=0;
if(count($dados)>=4)    
    $classCount="space-between";

@endphp
<div class="container container-full relacionadas-wrapper {{$classe}} no-print">                           
    <div class="row">
        <div class="col">
            <h2 class="sub-titulos-21"> <i class="ico ico-clipse-nas-listas"></i> ESTA FRASE APARECE NAS LISTAS ABAIXO</h2>
        </div>
    </div>

    <ul id="{{$id_ul}}" class="relacionadas {{$classe ?? "padrao_a"}} {{$classCount}}">                
       

        @foreach ($dados as $item)
            @php
                $cont_4++;
                if(isset($temPontuacao)) $pontuacao++;
                $capa = $item->thumb;                        
                if(trim($capa) ==="")                            
                    $capa = $item->capa;
                if($capa=="" || $capa=="null") $capa = asset("storage/images/thumbnail.jpg.jpg");

                if($classe=="rolldafama"){
                    $capa = $item->getAvatarAttribute();
                    $item->titulo = $item->nome_completo;
                    $item->urlamigavel = "perfil". "/". $item->name. '.' .$item->id;
                }                
            @endphp
             @if ($cont_4 == 5)
                @php
                    $cont_4 = 0;
                    $classCount="space-center";
                @endphp
                </ul>
                <ul id="{{$id_ul}}" class="relacionadas {{$classe ?? "padrao_a"}} {{$classCount}}">                
                
            @endif
            
            <li class="{{$classe}} {{$classCount}}">
                <div class="imagem-zone">
                    @if ($amp)
                        <div class="box-amp-img"> 
                            <a href="/{{$item->urlamigavel}}" 
                                class="relacionadas-link-imagem-zone-amp " title="{{$item->titulo}}">
                                <amp-img
                                class="lazy-hidden"
                                src="{{$capa}}"
                                width="187"
                                height="151"
                                layout="responsive"
                                alt="Imagem de {{$item->titulo}}">
                                </amp-img>
                                @if (isset($temPontuacao))
                                    <span class="bolinha-curtidas">{{$pontuacao}}º</span>
                                @endif
                            </a>
                        </div>
                    @else
                        <a href="/{{$item->urlamigavel}}" 
                            class="relacionadas-link-imagem-zone" title="{{$item->titulo}}"
                            data-src="{{$capa}}"  
                            style="background-image:url({{$capa}})">
                        </a>
                        @if (isset($temPontuacao))
                            <span class="bolinha-curtidas">{{$pontuacao}}º</span>
                        @endif
                    @endif
                </div>
                
                <div class="texto-zone  @if ($amp) amp @endif " >
                    <div class="table">
                        <div class="table-cell">
                            <a href="/{{$item->urlamigavel}}"  title="{{$item->titulo}}">
                                {{$item->titulo}}
                            </a>
                        </div>
                    </div>
                    
                </div>
            </li>
        @endforeach
    </ul>

</div>