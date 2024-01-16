<?php 
    // dd($dadosItens);

    if(!$dadosItens) return ;
    //if(!$dados->itens) return ;
    $recuo          = "com-recuo";    
    $registro       = $dadosItens;
    $arrayFrasesFav = [];
    $contaLinhas    = 0; 
    $producao       = false;
    $msgFinalListas = "";    
    if (isset($options['paramGlobal']))
        $producao = $options['paramGlobal'];

    if(isset($itens))
        $registro = $itens;


?>
<div class="corpo-das-frases page-break {{$recuo}}">

    @foreach ($registro as $item)
        @php 
        $contaLinhas++;
        $classtoggleImage = "";
        $classEditavel = $item->frase_id ? "" : "editavel";

        $autor = $item->autor ?? "sem autor";
        $autor = (trim($autor) != "") ? $autor : null;


        $ordemStr = $item["ordem"];
        if(strlen($item["ordem"])==1) $ordemStr = "0" . $ordemStr;        

        if($item->mostraimg=="1") $classtoggleImage = "ativo";
        @endphp
        <div class="frase--box {{$classEditavel}} pastas item_{{ $contaLinhas }}"> 
            <div class="ordem-da-frase">{{$ordemStr}}</div>           
            <div  data-index="{{$contaLinhas-1}}" data-tipo="without-icon" data-indexid="{{$item->id}}" data-id="frase_{{$item->id}}" data-fraseId="{{$item->frase_id ?? 0}}" class="magic-input-selector without-icon frase frase_{{$item->id}} @if ($item->frase_id) noEdit @endif" id="txt_frase_{{$item->id}}">{{$item->frase}}</div>
            @if (!$item->frase_id)
                @include('front.includes.formulario.Textareamagic',  [
                'input' => 'frase_'. $item->id, 
                'dataIndex' => $contaLinhas-1,
                'class' => 'magic-input-frase com-emoji',
                'value' => $item->frase,
                'emoji' => true,
                'placeholder' => 'Digite aqui a sua ideia, a sua inspiração!',
                ])                
            @endif
            
            <div data-id="autor_{{$item->id}}" data-indexid="{{$item->id}}" data-tipo="without-icon" data-fraseId="{{$item->frase_id ?? 0}}" class="magic-input-selector without-icon autor_{{$item->id}} autor @if ($item->autor == "") sem-autor @endif @if ($item->frase_id) noEdit @endif">
                {{$autor ?? "sem autor"}}
            </div>                
            @if (!$item->frase_id)
                @include('front.includes.formulario.Inputmagic',  [
                    'input' => 'autor_'. $item->id,
                    'value' => $item->autor,
                    'dataIndex' => $contaLinhas-1,
                    'class' => "autor_input magic-input-autor",
                    'placeholder' => 'Nome do autor',
                ])
            @endif        
            
            @if ($item->mostraimg=="1" )
                @if ($item->capa)
                    <div class="frase_imagem">
                        @if ($item->status == "1")
                            <a href="/frase/{{$item->frase_id}}" 
                            title="Ver mais detalhers sobre a frase!">                                
                                <img src="{{$item->capa}}" alt="{{$item->frase}}" width="auto" data-srcset="{{$item->capa}} 1070w,{{$item->capa}} 443w" sizes="(max-width: 1070px) 100vw, 1070px" class="imagem-post lazy-hidden no-print">
                            </a>
                        @else
                            <img src="{{$item->capa}}" alt="{{$item->frase}}" width="auto" data-srcset="{{$item->capa}} 1070w, {{$item->capa}} 443w" sizes="(max-width: 1070px) 100vw, 1070px" class="imagem-post lazy-hidden no-print">                            
                        @endif
                    </div>
                @endif
            @endif
            <div class="no-print">
                <div class="tools pastas">
                    <ul id="ul_edicao_{{$item->id}}" class="frases_em_edicao "> {{--frase editável--}}                        
                        <li>
                            <a href="" 
                                title="Salvar!"                                 
                                data-id="{{$item->id}}"                                
                                class="bt-salvar-frase-editada edit_id{{$item->id}} ativo">
                                ok
                            </a>
                        </li>
                        <li>
                            <a  href="#" title="Cancelar"
                                data-id="{{$item->id}}"                                
                                class="bt-action-cancelar item-tools excluir ativo">
                                <span class="ico ico-exit"></span>
                            </a>
                        </li>
                        
                    </ul>   
                    <ul id="ul_view_{{$item->id}}" class="pastas @if(!$item->frase_id)editavel @endif ativo"> {{--frase editável--}}
                            @if ($item->frase_id)
                            <li>
                                <a href="#" 
                                    title="Habilitar imagem da frase" 
                                    id="bt-action-toggle-imagem"
                                    data-id="{{$item->id}}"
                                    data-index="{{$contaLinhas-1}}"
                                    class="bt-action-toggle-imagem item-tools toggle {{$classtoggleImage}}"><span class="ico ico-imagem {{$classtoggleImage}}"></span></a>
                            </li>
                            @else 
                                {{--frase editável--}}
                                <li>
                                <a href="" 
                                title="Edite a sua frase!" 
                                id="bt-edit-frase-fox"
                                data-id="{{$item->id}}"
                                data-index="{{$contaLinhas-1}}"
                                class="magic-input-selector bt-edit-frase-fox item-tools toggle-edit-frase {{$classtoggleImage}} edit_id{{$item->id}}"><span class="ico ico-lapis {{$classtoggleImage}}"></span></a>
                                </li>
                                <li>
                                <a href="" 
                                title="Esta frase não possue imagem. Mas o sistema poderá gerá-la depois!" 
                                id="bt-no-action-toggle-imagem"
                                data-id="{{$item->id}}"
                                data-index="{{$contaLinhas-1}}"
                                class="bt-no-action-toggle-imagem item-tools toggle {{$classtoggleImage}}"><span class="ico ico-imagem {{$classtoggleImage}}"></span></a>
                                </li>
                            @endif
                        </li>                        
                        <li>
                            <a  href="#" title="Excluir esta frase"
                                data-id="{{$item->id}}"
                                data-index="{{$contaLinhas-1}}"
                                id="bt-action-excluir"
                                class="bt-action-excluir item-tools excluir">
                                <span class="ico ico-exit frases"></span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="ordenacao @if ($item->capa) comcapa @endif  @if ($contaLinhas>1 && $contaLinhas < count($registro)) ambos @endif    ">
                    <ul>
                        @if ($contaLinhas>1)
                            <li><a href="#" data-index="{{$contaLinhas-1}}" data-ordem="{{$item->ordem}}" class="bt_sobe" title="Sobe">
                                <span class="ico ico-seta-acima"></span></a></li>
                        @endif
                        @if ($contaLinhas < count($registro))
                            <li><a href="#" data-index="{{$contaLinhas-1}}" data-ordem="{{$item->ordem}}" class="bt_desce" title="Desce"><span class="ico ico-seta-baixo"></span></a></li>                            
                        @endif
                    </ul>                    
                </div>
            </div>
        </div>
        
    @endforeach    
</div>