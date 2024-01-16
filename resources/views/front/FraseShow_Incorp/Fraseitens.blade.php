<?php 
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Fraseitens.blade.php
     * Autor: LM
     * Objetivo: View responsável pelo html da single de frases - parte item
     * Doc: 
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *  ● Projeto2023Jan02 - Imagem com height 346px no cache do google
     *     >> 01-01-23 - Comentado todos os testes em relação a variável $mobile
     * ● Projeto2023Jan10 - Melhorando o Webmaster Tools  - Tarefa: 3) Ajustes de LCP nas "single de Frase" 
     *     >> 31-01-23 - Limpeza de código Pesada
     *     >> 31-01-23 - adaptação ao código para que fique igual ao Postitens.blade.php
     *     >> 31-01-23 - Refatorar os botões de Salvar | Copiar | Compartilhar
     *   ● Projeto2023Fev01 - Problema de LCP: mais de 2,5s (dispositivos móveis) - Dia 18/02
     *    >> 20-02-23 - passagem do parâmetro 'fetchpriority' como true, para envocar o parâmetro amp data-hero, em uma frase amp
     *                  doc: https://blog.amp.dev/2021/03/23/optimizing-your-amp-page-experience-for-core-web-vitals/
     *   ● Projeto2023Mar01 - Melhorando o CLS em Amp page
     *    >> 10-03-23 - Ocultar as imagens de Seguir, Copiar e compartilhar - retirar a tag amp-img para páginas AMP
     *--------------------------------------------------------------------------------------------------------------*/

    if(!isset($tbFrase)) $tbFrase=[];
    $arrayfrasessalvas  = [];
    $item               = $tabela;
    $contador           = 0; 
    $ancoras            = 0;
    if (count($frasessalvas))    
        $arrayfrasessalvas = $frasessalvas->all();

    /**============================================================
     * INicio do controle de dimensões das imagens = LM - 27/jul/22
     * ============================================================*/
    //parâmetros iniciais
    $width="612px";
    $height="612px";
    $temWidth=false;
    $temHeight=false;
    $capa=$item->capa; 
    if($capa!=null){
        //Verificar Se as dimensões da imagem foram geradas pela pipiEf
        if($item->dimensoes !=""){
            $dataDim =  explode("|",$item->dimensoes);
            if(isset($dataDim[0])){
                $dimensoesDesk  = explode("x",$dataDim[0]);
                $width="612px";
                $temWidth=true;
                if(isset($dimensoesDesk[1])){
                    $height = $dimensoesDesk[1]."px";
                    $temHeight=true;
                }
            }
          
        } else {
            // Caso as imagens não tenham sido geradas pela pipiEf, 
            // vamos trazer as dimensões da imagem pelo methodo padrão do php getimagesize()   
            $arrImagem = @getimagesize(env('APP_URL').$capa) ?? getimagesize(env('APP_URL').$capa) ? getimagesize(env('APP_URL').$capa) : [];
            if(isset($arrImagem[0])) {
                $width="$arrImagem[0]px";
                $temWidth=true;        
            }
            if(isset($arrImagem[1])) {
                $height="$arrImagem[1]px";
                $temHeight=true;
            } 
        }
    }
    // Validação importante!!!!
    // em caso de páginas Amp, a imagem precisa ser uma imagem válida, ter altura e largura
    // caso alguma destas regras não forem atendidas, não imprimir a imagem no documento
    if($amp){
        if(!$temWidth || !$temHeight )
            $capa=null;
    }
    
?>
<div class="conteudo--wrapepr">
        @php
            $contador++;
            $alt = substr($item->frase,0,120);   
            $item->frase_id = $item->id;            
        @endphp
        @if (isset($logado)) <a class="modal_salvar" @if (!$amp) idData="{{$item->frase_id}}" @endif title="Cancelar/ESC" id="modal_salvar_{{$item->frase_id}}"></a> @endif
        <div class="frase--box">
            {{-- imagem da frase --}}
            @if ($capa)
                <div class=" frase_imagem picture ">
                    <a>
                    @include('front.includes.Newimg', [
                                'width' => '612px', 
                                'validadeLCPAmp' => true,
                                'height' => $height,
                                'imgsrc' => $item->nomeDownload,
                                'amp'   => $amp,
                                'validateImag' => false,
                                'lazyLoad' => true,
                                'class' => "imagem-post no-print",
                                'alt' => $item->frase,
                                'fetchpriority'=> true,
                            ])
                    </a>        
                    
                </div>
            @endif
            {{-- frasebox --}}
            <div class="frase" id="frase_{{$item->item_id}}">{{$item->frase}}</div>
            {{-- autor --}}
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
            {{-- tools botões --}}
            <div class="tools no-print">
                <ul class="frases">                                              
                    <li>
                        @if (isset($logado))
                            @php
                                $jacurtida=false;
                                foreach ($arrayfrasessalvas as $key => $frasesFav) {
                                    if ($frasesFav->frase_id == $item->frase_id) $jacurtida=true;
                                }
                            @endphp
                            @if ($jacurtida)
                                <a title="Já está em suas frases favoritas!" class="padrao-icone favoritas jacurtida">
                                    @if ($amp)
                                        {{-- <amp-img alt="seguir" src="/images/icones/24x24/seguir-on-v01.svg" width="24px" height="24px"></amp-img> --}}
                                    @else
                                        <span data-src="/images/icones/24x24/seguir-on-v01.svg" class="ico lazy-background lazy-seguir seguindo no-interact"></span>
                                        
                                    @endif
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
                                @if ($amp)
                                    {{-- <amp-img alt="seguir" src="/images/icones/24x24/seguir-v01.svg" width="24px" height="24px"></amp-img> --}}
                                @else
                                    <span data-src="/images/icones/24x24/seguir-v01.svg" class="ico lazy-background lazy-seguir"></span>
                                @endif                                      
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
                                @if ($amp)
                                    {{-- <amp-img alt="seguir" src="/images/icones/24x24/seguir-v01.svg" width="24px" height="24px"></amp-img> --}}
                                @else
                                    <span data-src="/images/icones/24x24/seguir-v01.svg" class="ico lazy-background lazy-seguir no-interact"></span>
                                @endif
                                {{-- <img src="{{asset("images/estrela_pequena.png")}}" alt="estrela" width="32px" height="31px"> --}}
                                <span class="label no-interact">Salvar</span>
                            </a>
                        @endif
                    </li>
                    
                    <li>
                        <a href="#" title="Copiar"                                 
                        @if (!$amp)
                            idData="{{$item->item_id}}"                                                                        
                        @endif
                        class="padrao-icone item-tools copiar icon icone copiarFraseFavorita ">                                
                            @if ($amp)
                                {{-- <amp-img alt="seguir" src="/images/icones/24x24/copiar-v01.svg" width="24px" height="24px"></amp-img> --}}
                            @else
                                <span data-src="/images/icones/24x24/copiar-v01.svg"  class="ico lazy-background lazy-copiar no-interact"></span>
                            @endif                                 
                            <span class="label no-interact">Copiar</span>                                
                        </a>                            
                    </li>
                    <li>
                        <a href="/login" class="padrao-icone callLogin_ item-tools  abreCompartilhar" title="Compartilhar">
                            @if ($amp)
                                {{-- <amp-img alt="seguir" src="/images/icones/24x24/compartilhar-v01.svg" width="24px" height="24px"></amp-img> --}}
                            @else
                                <span data-src="/images/icones/24x24/compartilhar-v01.svg"  class="ico lazy-background lazy-copiar no-interact"></span>
                            @endif 
                            <span class="label no-interact">Compartilhar</span>
                        </a>
                    </li>
                </ul>
            </div>                    
            @if (isset($logado))                        
                <div class="tool tool-salvar" id="salvar_{{$item->frase_id}}"></div>                    
            @endif
        </div>
</div>