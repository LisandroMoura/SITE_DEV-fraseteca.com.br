<?php 
    $recuo = "sem-recuo";    
    // if($posts->imprime_capa =='1')
    //     $recuo = "com-recuo";
    $registro = $itens; 
    $arrayFrasesSalvas =[];
    $contaLinhas=0; 
    $producao = false;
    $msgFinalListas="";
    if (count($frasesSalvas))    
        $arrayFrasesSalvas = $frasesSalvas->all();  
    
    if (isset($options['paramGlobal']))
        $producao = $options['paramGlobal'];
        
        $mobile = FALSE;
        
        if (isset($options['keyYandex'])){           
            if(isset($_SERVER['HTTP_USER_AGENT'])){
                if($options['keyYandex']=="true") {
                    $user_agents = array("iPhone","iPad","Android","webOS","BlackBerry","iPod","Symbian","IsGeneric");
                    foreach($user_agents as $user_agent){
                        if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== FALSE) {
                            $mobile = TRUE;                                                        
                            break;
                        }
                    }
                }
            }            
        }        
        $capa= $posts->capa;

        
        

        $explo =explode("?",$capa);
        if (count($explo) > 1){
            $capa = $explo[0];
        }        
        
        if($mobile) {
            $smallWebp = $capa;
            $aux = explode(".", $smallWebp);
            if(isset($aux[1])){ 
                if($aux[1] == "webp") 
                    $smallWebp = $aux[0].".jpg.webp";
                else 
                    $smallWebp = $capa.".webp";                
            }
            $capa = $smallWebp;           
        }      
        $path=\storage_path()."/app/public/frases/".str_replace('/storage/frases/','',$capa);if(!file_exists($path))$capa=null;
        $alt = substr($posts->frase,0,120);        
?>
<div class="corpo-das-frases page-break {{$recuo}}">
    @if (isset($logado))

        <a class="modal_salvar" 
        @if (!$amp) idData="{{$posts->id}}" @endif
        title="Cancelar/ESC" id="modal_salvar_{{$posts->id}}"></a>
    @endif
    <div class="frase-box">
        @if ($capa)
            <div class="frase_imagem no-print pai">                
                @if ($posts->status == "1")
                    <div class="hover-download no-print">
                        <div class="cell">
                            <a class="cell-center"                                    
                            href="{{$capa}}"                            
                            download="{{$capa}}">
                                <i class="ico ico-download"></i>
                                <span>baixar</span>
                            </a>
                        </div>
                    </div> 
                    <a href="{{$capa}}" 
                        download="{{$capa}}"                        
                        title="{{$alt . " - " . $posts->alt}}">
                        @if ($amp)
                            <amp-img alt="{{$alt . " - " . $posts->alt}}" 
                            media="(min-height:420px)"
                            itemprop="image"
                            width="612"
                            height="612"
                            layout="responsive"                            
                            src="{{$capa}}"></amp-img>
                        @else
                            <img src="{{$capa}}" alt="{{$alt . " - " . $posts->alt}}" width="auto" data-srcset="{{$capa}} 1070w,{{$capa}} 443w" sizes="(max-width: 1070px) 100vw, 1070px" class="imagem-post lazy-hidden no-print">                                        
                        @endif
                    </a>
                @else
                    @if ($amp)
                        <amp-img alt="{{$alt . "-" . $posts->alt}}" 
                        media="(min-width: 768px)"
                        itemprop="image"
                        width="612"
                        height="612"
                        layout="responsive"                            
                        src="{{$capa}}"></amp-img>                        
                    @else
                        <img src="{{$capa}}" alt="{{$alt . " - " . $posts->alt}}" width="auto" data-srcset="{{$capa}} 1070w, {{$capa}} 443w" sizes="(max-width: 1070px) 100vw, 1070px" class="imagem-post lazy-hidden no-print">    
                    @endif                    
                @endif
            </div>
        @endif        
        <div class="frase" id="frase_{{$posts->id}}">{{$posts->frase}}</div>
        {{-- @if ($posts->autor)
            <div class="autor">{{$posts->autor}}</div>
        @endif --}}
        @if ($posts->autor)  
            @php
                //Customização para buscar o autor  
                $autorDaFrase=App\Entities\AutorItem::
                where([
                    ["tipo","=","1"],
                    ["tipo_id","=",$posts->id]
                ])
                ->join("autor","autor.id","=","autor_item.autor_id")
                ->select("autor.id","autor.nome","autor.urlamigavel")
                ->first();  
            @endphp
            @if ($autorDaFrase)
                <div class="autor">
                    <a href="{{$autorDaFrase->urlamigavel}}" title="página do Autor {{$autorDaFrase->nome}}">{{$posts->autor}}</a>
                </div>                    
            @else
                <div class="autor">{{$posts->autor}}</div>
            @endif
        @endif   
        <span class="texto_para_copiar" id="frase_copiar_{{$posts->id}}">{{$posts->frase}} @if ($posts->autor) - {{$posts->autor}}@endif</span>        
        <div class="no-print">
            <div class="tools">
                <ul>                                              
                    <li>
                        @if (isset($logado))
                            @php
                                $jacurtida=false;
                                foreach ($arrayFrasesSalvas as $key => $frasesFav) {
                                    if ($frasesFav->frase_id == $posts->id)
                                        $jacurtida=true;
                                }
                            @endphp
                            @if ($jacurtida)
                                <a title="Já está em suas frases favoritas!" class="favoritas jacurtida na-frase">
                                    <span class="ico ico-estrela-pequena-amarela"></span>                                    
                                    <span class="label">Salvo!</span>
                                </a>
                            @else
                                <a 
                                href="/login"                                                                                 
                                @if (!$amp)
                                    idData="{{$posts->id}}" 
                                    data="go" 
                                @endif                                        
                                title="Adicionar a suas Frases Favoritas."                                                                             
                                class="favoritas fraseFavorita favorita-id-{{$posts->id}} na-frase">
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
                            title="Que tal salvar esta frase em suas Frases Favoritas?"                             
                            class="callLogin item-tools favoritas icon favorita-id-{{$posts->id}} mg0 na-frase">
                                <span class="ico ico-estrela-pequena no-interact"></span>                                
                                <span class="label no-interact">Salvar</span>
                            </a>
                        @endif
                    </li>                    
                    <li>
                        <a 
                        @if ($amp) href="/frase/{{$posts->id}}" @endif
                        title="Copiar"                                 
                        @if (!$amp)
                            idData="{{$posts->id}}"                                                                        
                        @endif
                        class="item-tools copiar icon icone copiarFraseFavorita na-frase">                                
                            <span class="ico ico-copiar-colar no-interact"></span>                            
                            <span class="label no-interact">Copiar</span>                                
                        </a>                            
                    </li>
                    <li>
                        <a  href="{{env("APP_URL") . "/compartilhar?id=f".$posts->id}}"
                        title="{{$item->alt ?? "Ver mais detalhers sobre a frase!" }}" 
                            class="icon icon compartilhar item-tools na-frase">
                            <span class="ico ico-compartilhar-frase"></span>                            
                            <span class="label">Compartilhar</span>                                
                        </a>
                    </li>                        
                </ul>
            </div>
            {{-- testar se o usuário estiver logado --}}
            @if (isset($logado))                        
                <div class="tool tool-salvar" id="salvar_{{$posts->id}}">
                </div>                    
            @endif
        </div>
    </div>
        
</div>