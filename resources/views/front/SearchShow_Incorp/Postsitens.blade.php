<?php 
    if(!isset($tbFrase)) $tbFrase=[];
    $recuo = "sem-recuo";    
    if(isset($posts->imprime_capa))
        if($posts->imprime_capa =='1')
            $recuo = "com-recuo";
    $registro = $itens; 
    
    $arrayFrasesSalvas =[];
    $contaLinhas=0; 
    //$producao = false;
    $msgFinalListas="";
    if (count($frasesSalvas))    
        $arrayFrasesSalvas = $frasesSalvas->all();
?>
<div class="corpo-das-frases page-break {{$recuo}}">
    @foreach ($registro as $item)
        @php
            $capa = $item->capa;
            $contaLinhas++;
            $capa=$item->capa; //iniciando a variável capa para cada frase da lista
            $alt = substr($item->frase,0,120);   
            $item->frase_id = $item->id;            
            $path=\storage_path()."/app/public/frases/".str_replace('/storage/frases/','',$capa);if(!file_exists($path))$capa=null;

            if (!isset($item->tipo)) $item->tipo=1;
        @endphp
        @if ($item->tipo == "3")
        <div class="anchor-content {{$recuo}} item-{{$contaLinhas}}" id="{{$item->aux_2}}">
            <div class="anchor-content-title">
                <i class="ico ico-indice"></i>
                <h2>{{$item->aux_1}}</h2>
            </div>                
        </div>
        @endif     
        
        {{-- @if ($item->tipo == "2" && !$amp)
            @if ($producao)
                <div class="no-print anuncio-responsivo">
                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-6159622292805097" data-ad-slot="6042966650" data-ad-format="auto" data-full-width-responsive="true"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
                </div>    
            @else
                <div class="anuncio normal teste no-print">
                    <img src="{{asset("images/anuncio1.jpg")}}" class="view-desk no-print" alt="anuncio">
                    <img src="{{asset("images/anuncio1_mobile.jpg")}}" class="view-responsive no-print" alt="anuncios">
                </div>                
            @endif    
        @endif      --}}
        @if ($item->tipo=="4" && !$logado )            
            <div class="convite no-print">Você sabia que neste site você pode fazer a sua própria lista de frases, salvar as suas frases favoritas em sua seleção e muito mais? <br><br>Que tal aproveitar que você já está por aqui, clicar <a target="_blank" rel="nofollow" href="/registrar/newuser">neste link</a> e experimentar? (Pedimos apenas seu email, um cadastro muito mais rápido que qualquer outro site :))</div>            
        @endif
        @if ($item->tipo=="1")                
            @if (isset($logado))
                <a class="modal_salvar" 
                    @if (!$amp)
                        idData="{{$item->frase_id}}"
                    @endif                    
                title="Cancelar/ESC" id="modal_salvar_{{$item->frase_id}}"></a>
            @endif
            <div class="frase-box">
                @if ($item->mostraimg=="1" )
                    @if ($capa)
                        @php
                            //deletar esta linha, pois a variável capa foi iniciada acima
                            if($mobile){
                                //$capa = $item->capa.".webp";
                                $smallWebp = $capa;
                                $aux = explode(".", $smallWebp);                               
                                if(isset($aux[1])){                                    
                                    if($aux[1] == "webp") 
                                        $smallWebp = $aux[0].".jpg.webp";
                                    else 
                                        $smallWebp = $capa.".webp";                
                                    $capa = $smallWebp;
                                }                                
                            }   

                        @endphp
                        <div class="frase_imagem">
                            @if ($item->status == "1")
                                <a href="/frase/{{$item->frase_id}}" 
                                title="{{"Ver a Frase: " . $alt . " - " . $item->alt }}"
                                >
                                    @if ($amp)
                                        <amp-img alt="{{$alt . " - " . $item->alt}}" 
                                        media="(min-height:420px)"
                                        itemprop="image"
                                        width="612"
                                        height="612"
                                        layout="responsive"                            
                                        src="{{$capa}}"></amp-img>
                                    @else
                                        <img src="{{$capa}}" alt="{{$alt . " - " . $item->alt}}" width="auto" data-srcset="{{$capa}} 1070w,{{$capa}} 443w" sizes="(max-width: 1070px) 100vw, 1070px" class="imagem-post lazy-hidden no-print">
                                    @endif
                                </a>
                            @else
                                @if ($amp)
                                    <amp-img alt="{{$alt . " - " . $item->alt}}" 
                                    media="(min-width: 768px)"
                                    itemprop="image"
                                    width="612"
                                    height="612"
                                    layout="responsive"                            
                                    src="{{$capa}}"></amp-img>
                                @else
                                    <img src="{{$capa}}" alt="{{$alt . " - " . $item->alt}}" width="auto" data-srcset="{{$capa}} 1070w, {{$capa}} 443w" sizes="(max-width: 1070px) 100vw, 1070px" class="imagem-post lazy-hidden no-print">
                                @endif
                                
                            @endif
                        </div>
                    @endif
                @endif             
                <div class="frase" id="frase_{{$item->item_id}}{{$contaLinhas}}">{{$item->frase}}</div>
                @if ($item->autor)  
                    @php
                        $autorDaFrase=App\Entities\AutorItem::
                        where([
                            ["tipo","=","1"],
                            ["tipo_id","=",$item->frase_id]
                        ])
                        ->join("autor","autor.id","=","autor_item.autor_id")
                        ->select("autor.id","autor.nome","autor.urlamigavel")
                        ->first();  
                    @endphp
                    @if ($autorDaFrase)
                        @if (!str_contains($autorDaFrase->urlamigavel,$_SERVER["REQUEST_URI"]))
                            <div class="autor">
                                <a href="{{$autorDaFrase->urlamigavel}}" title="página do Autor {{$autorDaFrase->nome}}">{{$item->autor}}</a>
                            </div> 
                        @else
                            <div class="autor">{{$item->autor}}</div>                            
                        @endif
                    @else
                        <div class="autor">{{$item->autor}}</div>
                    @endif
                @endif   
                <span class="texto_para_copiar" id="frase_copiar_{{$item->item_id}}">{{$item->frase}} @if ($item->autor) - {{$item->autor}}@endif</span>
                
                <div class="no-print">
                    <div class="tools">
                        <ul>                                              
                            <li>
                                @if (isset($logado))
                                    @php
                                        $jacurtida=false;
                                        foreach ($arrayFrasesSalvas as $key => $frasesFav) {
                                            if ($frasesFav->frase_id == $item->frase_id)
                                                $jacurtida=true;
                                        }
                                    @endphp
                                    @if ($jacurtida)
                                        <a title="Já está em suas frases favoritas!" class="favoritas jacurtida padrao-icone">
                                            <span class="ico ico-estrela-pequena-amarela"></span>
                                            {{-- <img src="{{asset("images/estrela_pequena.png")}}" alt="estrela" width="32px" height="31px"> --}}
                                            <span class="label">Salvo!</span>
                                        </a>
                                    @else 
                                    
                                        <a 
                                        href="/login"  
                                        rel="nofollow"                                                                               
                                        @if (!$amp)
                                            idData="{{$item->frase_id}}" 
                                            data="go" 
                                        @endif                                        
                                        title="Adicionar a suas Frases Favoritas."                                                                                     
                                        class="padrao-icone favoritas fraseFavorita favorita-id-{{$item->frase_id}}">
                                        <span class="ico ico-estrela-pequena no-interact"></span>
                                        <span class="ico ico-estrela-pequena-amarela"></span>                                        
                                        <span class="label no-interact">Salvar</span>
                                        </a>
                                        
                                    @endif                        
                                @else                             
                                    <a href="/login" 
                                    @if (!$amp)
                                        data="go"
                                    @endif
                                    rel="nofollow"
                                    title="Que tal salvar esta frase em suas Frases Favoritas?"                                     
                                    class="padrao-icone callLogin_ item-tools favoritas icon favorita-id-{{$item->frase_id}} mg0">
                                        <span class="ico ico-estrela-pequena no-interact"></span>
                                        {{-- <img src="{{asset("images/estrela_pequena.png")}}" alt="estrela" width="32px" height="31px"> --}}
                                        <span class="label no-interact">Salvar</span>
                                    </a>
                                @endif
                            </li>
                            @if ($item->status == "1")
                                <li>
                                    <a href="/frase/{{$item->frase_id}}" 
                                        title="{{"Ver a Frase: " . $alt . " - " . $item->alt }}"
                                        class="padrao-icone icon icon imagem item-tools">
                                        <span class="ico ico-vermais"></span>                                        
                                        <span class="label">Imagem</span>                                
                                    </a>
                                </li>
                            @else 
                                <li>
                                    <a 
                                        title="{{"Frase: " . $alt . " - " . $item->alt }}"
                                        class="padrao-icone icon icon imagem item-tools jacurtida">
                                        <span class="ico ico-vermais"></span>                                        
                                        <span class="label">Imagem</span>                                
                                    </a>
                                </li>                        
                            @endif  
                            <li>
                                <a href="#" title="Copiar"                                 
                                @if (!$amp)
                                    idData="{{$item->item_id}}"                                                                        
                                @endif
                                class="padrao-icone item-tools copiar icon icone copiarFraseFavorita ">                                
                                    <span class="ico ico-copiar-colar no-interact"></span>                                    
                                    <span class="label no-interact">Copiar</span>                                
                                </a>                            
                            </li>
                        </ul>
                    </div>                    
                    @if (isset($logado))                        
                        <div class="tool tool-salvar" id="salvar_{{$item->frase_id}}"></div>                    
                    @endif
                </div>
            </div>
        @endif
    @endforeach    
</div>