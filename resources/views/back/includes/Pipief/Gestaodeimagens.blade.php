@php
    $boolTrancada = false;
    //$tabela->capaupload

    if(isset($tabela))
    if ( method_exists($tabela, 'getTable') ){
        if($tabela->getTable() == "frases" ) {
            if($tabela->capaupload == "trancado")
                $boolTrancada = true;
        }
    }

@endphp
<div class="content-wrapper">
    <section id="pipief" class="field field-preview-listas">
        @if (isset($parametros["fonte"]))

            <form ref="formulario" action="{{ route('frase.zerarPipif') }}" method="post"
                enctype="multipart/form-data">
                @method('get')
                <input type="hidden" name="runpipif" id="runpipif" value="go">
                <input type="hidden" name="id" id="id" value="<?php echo $idTabela;?>">
                <button type="submit">zerar - RESETAR</button>
            </form>
            <input type="hidden" name="tipoTelaSelect" id="tipoTelaSelect" value="<?php echo $parametros["tipoTela"];?>">
            @if ($parametros["tipoTela"] == 'bg')
                @include('back.includes.Pipief.views.FormBg', ['parametros' => $parametros, 'items' => []])
                @include('back.includes.Pipief.views.InfoPreview',[])
            @else
                @include('back.includes.Pipief.views.FormChapado', [
                    'parametros' => $parametros,
                    'items' => [],
                ])
                @include('back.includes.Pipief.views.InfoPreview',[])
            @endif
        @else
            
            {{--   /**
                * ● Projeto20221201 - 12-12-22
                    - Botões de execução para imagens com o status de TRANCADA
                      Flexbilizando a tratativa de problemas
                *   - Trazer a visualização da imagem da frases para as imagens trancadas
                *     além disso, nesta view, trazer o campo de Download jpeg, afim de facilitar
                *     na identificaçao de problemas 
                */
            --}}
            @if ($boolTrancada)

                    <form ref="formulario" action="{{ route('frase.regerarAuxiliaresPipif') }}" method="post"
                        enctype="multipart/form-data">
                        @method('get')
                        <input type="hidden" name="runpipif" id="runpipif" value="go">
                        <input type="hidden" name="id" id="id" value="<?php echo $idTabela;?>">
                        <button type="submit" style="background:rgb(111, 226, 44);">ReGerar imagem JPEG...</button>
                    </form>

                    <form class="form-box"
                        action="{{ route('marlon.ajustaralt', 'f;' . $idTabela) }}" action=""
                        method="GET">
                        {{ csrf_field() }}
                        @method('PUT')
                        <button class="btn-sucess" style="background:#be0b89;color:#fff;">
                            ReGerar Imagem mobile
                        </button>
                    </form>
                    
            @else
                <form ref="formulario" action="{{ route('frase.iniciarPipif') }}" method="post"
                    enctype="multipart/form-data">
                    @method('get')
                    <input type="hidden" name="runpipif" id="runpipif" value="go">
                    <input type="hidden" name="id" id="id" value="<?php echo $idTabela;?>">
                    <button type="submit">Rodar o PipiF 🐈</button>
            </form>
            @endif

          
            @include('back.includes.Pipief.views.InfoPreview',[])
            
        @endif

        

    </section>
</div>
{{-- trazer o js aqui mesmo --}}
