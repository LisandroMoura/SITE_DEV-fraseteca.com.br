<?php 
    //dd($dadosItens);
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

        @if ($item->tipo=="1")

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
            
            <div class="frase-box {{$classEditavel}}"> 
                <div class="ordem-da-frase">{{$ordemStr}}</div>
                <div  data-index="{{$contaLinhas-1}}" data-id="frase_{{$item->id}}" data-fraseId="{{$item->frase_id ?? 0}}" class="magic-input-selector frase frase_{{$item->id}} @if ($item->frase_id) noEdit @endif" id="txt_frase_{{$item->id}}">{{$item->frase}}</div>
                            
                <div data-id="autor_{{$item->id}}" class="magic-input-selector autor_{{$item->id}} autor  @if ($item->frase_id) noEdit @endif">
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
            </div>
        @endif        
    @endforeach    
</div>