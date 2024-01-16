@extends('template.Usuario')

<style>
    .view-webp {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        align-content: center;
        position: absolute;
        top: 0;
    }

    .content-view-webp {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        flex-direction: column;
        align-items: center;
        background: #ffffff26;
        padding: 2px;
    }

    span.previewwebp {
        display: block;
        color: #fff;
        width: auto;
    }

    .seoparam-item{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        margin-bottom: 10px;

    }
    label.label-anuncio {
        display: flex;
        flex-direction: row;
        gap: 20px;
    }

    span.On{
            background: green;
            padding: 8px;
            color: #fff;
            
    }
    span.Off{
            background: red;
            padding: 8px;
            color: #fff;
            
    }

    @media (min-width: 1200px) {
        .container.corpo {
            max-width: 70% !important;
        }

        .corpo-da-pagina {
            font-size: 0.9rem;
            font-family: "Lato", sans-serif;
            color: #061032 !important;
            background-position: 1% 7% !important;
        }
        ul {
            list-style: none;
        }

        ul.flex {
            display: grid;
            grid-template-columns: repeat(5, 180px);
        }


        ul.flex li {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-evenly;
            flex-wrap: nowrap;
            align-content: space-between;
        }

        ul.imagens-na-pasta {
            display: grid;
            grid-template-columns: repeat(5, 160px);
            justify-content: center;
            gap: 20px;
        }

        ul.imagens-na-pasta li a {
            display: block;
            max-width: 160px;
            margin: 10px;
        }

        .escolhida {
            border: 10px solid #49ff00;
        }

        .col,
        .row {
            max-width: 600px;
            margin: 0 auto;
        }

        .no-pointer {
            pointer-events: none;
        }
    }
</style>

@section('css-view')
@endsection

@section('metadados')
    {{-- 1 html header --}}
    @include('back.includes.Backend', [
        'titulo' => 'Lista de Frases',
        'descricao' => 'Lista de Frases, Editar ou criar Posts',
    ])
@endsection

@section('conteudo-menu')
@endsection

@section('conteudo-view')

    {{-- 2 Váriáveis --}}

    @php
    $msgValidatorArr = \App\Services\MsgValidator::run($errors);
    $default_page = 'frases';
   

    if (!isset($arrFrases)) {
        $arrFrases = [];
    }

    //1) dados da tabela
    $idTabela = 0;
    $titulo = '';
    $imgSrc = '';
    $frase = '';
    $autor = '';
    $alt = '';
    $ownerid = '';

    //
    $capa = '';
    $campofrase = '';
    $midiaId = '';
    $categoria_id = '';
    $corpo = '';
    $tags = '';
    $aux_1 = '';
    $status = 1;
    $tipo_imagem = '0';
    $capaupload = 'liberado';
    $categoria_Dados = [];
    $tag_Dados = [];
    $tagsDoPost = [];
    $bancoDeTags = '';
    $thumb = '';
    $imprime_capa = '';
    $ver = '?' . rand();
    $usuario_id = 1;
    $chave = '';
    $physical_name = '';
    $cdn = '';
    $dimensoes = '612x612';

    $autorDaFrase = [];
    //Ajustes do Marlon
    $fraseMaisAntiga = 0;
    $tokenFrases = '';
    $tokenPostItens = '';
    $lDuplicadas = false;
    $save_to_path = '';

    $parametros = $parametros ?? null;

    if (isset($tabela)):
        $autorDaFrase = $tabela->getAutor();
        $i = 0;
        $idTabela = $tabela ? $tabela->id : 0;
        $autor = $tabela ? $tabela->autor : '';
        $titulo = $tabela ? $tabela->titulo : '';
        $frase = $tabela ? $tabela->frase : '';
        $alt = $tabela ? $tabela->alt : '';
        $cdn = $tabela ? $tabela->cdn : '';
        $ownerid = $tabela ? $tabela->ownerid : '';
        $tags = $tabela ? $tabela->tags : '';
        $status = $tabela ? $tabela->status : '0';
        $tipo_imagem = $tabela ? $tabela->tipo_imagem : '0';
        $capaupload = $tabela ? $tabela->capaupload : 'liberado';
        $usuario_id = $tabela ? $tabela->usuario_id : 1;
        $chave = $tabela ? $tabela->aux_2 : '';
        $physical_name = $tabela ? $tabela->physical_name : '';
        $dimensoes = $tabela ? $tabela->dimensoes : $dimensoes;

        // ● 24-ago-22 LM Projeto20220804 - SEO parametros para a Single de frase
        $arrayParams    = $tabela->getSeoParamsAttribute();
        $anuncios       = $tabela->anuncios ?? 'false';
        $analytics      = data_get($arrayParams, '0', false) ;
        $lazyOn         = data_get($arrayParams, '1', null) ;
        $preloadImages  = data_get($arrayParams, '2', null) ;
        $preloadFonte   = data_get($arrayParams, '3', null) ;
        $tipoAnuncio    = data_get($arrayParams, '4', null) ;
        $lazyAds        = data_get($arrayParams, '5', null) ;

        $nomeDownload   = $tabela->nomeDownload ?? "";
        $extension = "";
        $arrExtension = explode(".", $tabela->capa);
        if(isset($arrExtension[1])){
            $extension = $arrExtension[1];    
        }
        if(isset($arrExtension[2])){
            $extension = $arrExtension[2];    
        }
        if(isset($arrExtension[3])){
            $extension = $arrExtension[3];    
        }
        if(isset($arrExtension[4])){
            $extension = $arrExtension[4];    
        }


        //////////////////////////////////////////// FIM SEO PARAMS 
        if ($tabela->capa) {
            $imgSrc = $tabela->capa;
        }
        $tagFrases = $tabela->listaTags();
        if ($tags == '') {
            foreach ($tagFrases as $key => $tagFrase) {
                $tags .= $tagFrase->getTag()[0]['descricao'] . ';';
            }
        }
        $listatTags = explode(',', $tags);
        if (!isset($listatTags[1])) {
            $listatTags = explode(';', $tags);
        }
        if (isset($tagsum)):
            foreach ($tagsum as $key => $tag) {
                if (!in_array($tag->descricao, $listatTags)) {
                    $bancoDeTags .= $tag->descricao . ',';
                    $tag_Dados[$tag->descricao] = $tag->id;
                } else {
                    $tagsDoPost[$tag->descricao] = $tag->id;
                }
            }
        endif;
        $smallWebp = $tabela->capa;
        $aux = explode('.', $smallWebp);
        if (isset($aux[1])) {
            if ($aux[1] == 'webp') {
                $smallWebp = $aux[0] . '.jpg.webp';
            } else {
                $smallWebp = $tabela->capa . '.webp';
            }
        }
        if ($capaupload == '') {
            $capaupload = 'liberado';
        }

        if ($imgSrc == '') {
            $imgSrc = 'null';
        }
        $save_to_path = \storage_path() . '/app/public/frases/' . str_replace('/storage/frases/', '', $imgSrc);
    endif;

    @endphp

    <div class="page" id="app">
        {{-- validatorSys será colocado aqui, via JS, pelo Mixin --}}
        @include('front.includes.Retorno')
        <bt-confirma :confirma="objConfirma"></bt-confirma>
        @include('back.includes.Menulateral')
        @include('front.includes.Areapesquisa')
        <div class="corpo-da-pagina">
            @include('back.includes.Topo', ['amp' => false])

            <div class="container corpo">
                <div class="wrapper">
                    <!-- Sidebar -->
                    <div id="sidebar" class="normal" ref="ref_sidebar">
                        @include('back.includes.Menu', [
                            'pagina' => $default_page,
                        ])
                    </div>
                    <div id="botao" ref="ref_botao" class="only-mobile" @click.prevent.stop="abreSidebar">
                        <span class="linha "></span>
                        <span class="linha linha2"></span>
                    </div>

                    <!-- Page Content -->
                    <div id="content" class="default-form {{ $default_page }}">
                        {{-- startMagic --}}
                        <?php if($idTabela > 0): //UPDATE ?>
                        {{-- BOTÃO VER SITE --}}
                        <div class="ver-site">
                            @php
                                $rotaVer = env('APP_URL') . '/frase/' . $tabela->id;
                            @endphp
                            <a href="{{ $rotaVer }}">Ver Post</a>
                        </div>
                        <div class="bt-salvar-fixed">
                            @include('front.includes.formulario.Btsalvar', [
                                'rota' => 'frase.update',
                                'id' => $idTabela,
                                'class' => 'rascunho item-bt-salvar-fixed',
                                'vaction' => 'salvar',
                                'icone' => 'save',
                                'tip' => 'Salvar alterações',
                            ])
                        </div>

                        <ul style="display: flex;flex-direction: column;justify-content: flex-start;align-items: center;gap: 6px;margin-bottom: 20px;">
                        @if ($nomeDownload=="")
                            <li style="color: #fff; background:red">Critical: Imagem de download JPG Pendente, rode o PipiF ou ReGere as imagens auxiliares!</li>
                        @endif

                        @if ($extension=="jpg" && $tabela->capaupload != "trancado")
                            <li style="color: #fff; background:red">Critical: Imagem no formato Jpg - Rode o processo Transformar em .webp</li>
                        @endif
                        
                        @if (!isset($parametros["fonte"]) && $tabela->capaupload != "trancado")
                            <li style="color: #fff; background:red">Critical: Pipif Pendente!, rode o PipiF</li>
                        @endif
                        

                        @if ($tabela->status == "4")
                            <li style="color: #fff; background:red">Critical: Frase com status REGEITADA!</li>
                        @endif

                        @if ($alt == "")
                            <li style="color: #fff; background:yellow; color:#000;">Atenção: Imagem sem campo Alt e nome fisico do arquivo para seo!</li>
                        @endif

                        @if ($capaupload == "trancado")
                            <li style="color: #fff; background:yellow; color:#000;">Atenção: 🔒 Imagem está trancada para alterações!</li>
                        @endif

                        @if ($ownerid == "")
                            <li style="color: #fff; background:yellow; color:#000;">Atenção: Frase sem lista mandatória definda!</li>
                        @endif
                        
                        

                        </ul>
                        <h1 style="font-size: 41px">
                            📜
                            @if ($idTabela > 0)
                                Editando Frase: id ({{ $idTabela }})
                            @else
                                Criando Frase
                            @endif
                        </h1>

                        <div class="content-wrapper" id="pipipi-nome-das-imagens">
                            <header>
                              
                                <h2>
                                    <span style="font-size: 86px;">🐈</span>
                                    PipiF - Sistema de Gestão de Imagens <span style="color: red; background: yellow">New!</span>
                                </h2>
                                <hr>
                                <hr>
                                <hr>
                                <hr>
                                <h2>
                            </header>
                            <section>
                                <div class="col-lg-12">
                                    @include('back.includes.Pipief.Gestaodeimagens', [
                                        'options' => $options,
                                        'tipo' => 'frase',
                                        'id' => $idTabela,
                                        'imgSrc' => $imgSrc,
                                        'smallWebp' => $smallWebp,
                                        'parametros' => $parametros,
                                        'dimensoes' => $dimensoes,
                                    ])
                                </div>
                            </section>
                        </div>

                        {{-- SEO PARAM --}}
                        <hr><hr><hr><hr><hr><br>
                                    
                        

                        {{-- FORM DE UPDATE --}}
                        <form ref="formulario" action="{{ route('frases.update', $idTabela) }}" method="post"
                            enctype="multipart/form-data">
                            @method('PUT')

                            <?php else: //STORE ?>
                            <form ref="formulario" action="{{ route('frases.store') }}" method="post"
                                enctype="multipart/form-data">
                                <?php endif;?>
                                {{ csrf_field() }}
                                {{-- from --}}
                                <div class="content-wrapper">
                                    <header>
                                        {{-- 3 Nome da tela --}}
                                        

                                        @if (!$titulo)
                                            <a href="{{ route('marlon.titulo', $idTabela) }}"
                                                class="btn bt-call btn-success marlon">
                                                <span class="icon-zynga" style="color:#000"> Ajustar título
                                            </a>
                                        @endif
                                    </header>

                                    <section class="field">
                                        <header>
                                            <h2>SEO PARAMS</h2>
                                        </header>
                                        <main>
                                            <ul>
                                                <li class="seoparam-item">
                                                        @include(
                                                            'front.includes.formulario.Checkbox',
                                                            [
                                                                'input' => "anuncios",
                                                                'ref'   => 'anuncios',
                                                                'vmodel' => 'anuncios',
                                                                'label' => 'Ligar anúncios nesta página',
                                                                'value' => $anuncios,
                                                                'checked' => $anuncios,
                                                            ]
                                                        )
                                                        <span :class="anunciosOn">
                                                            @{{ anunciosOn }}
                                                        </span>
                                                </li>
                                                <li class="seoparam-item">
                                                    @include('front.includes.formulario.Checkbox',['input' => "analytics",'ref' => 'analytics','vmodel' => 'analytics','label' => 'Ocultar Analytics da página','value' => $analytics,'checked' => $analytics,])
                                                    <span :class="analyticsOn">@{{ analyticsOn }}</span>
                                                </li>
                                                <li class="seoparam-item">
                                                    @include('front.includes.formulario.Checkbox',['input' => "lazyOn",'ref' => 'lazyOn','vmodel' => 'lazyOn','label' => 'OnOFF LazyLoad (para as imagens abaixo da dobra)','value' => $lazyOn,'checked' => $lazyOn,])
                                                    <span :class="lazyOnOn">@{{ lazyOnOn }}</span>
                                                </li>
            
                                                
            
                                                <li class="seoparam-item">
                                                    @include('front.includes.formulario.Checkbox',['input' => "preloadImages",'ref' => 'preloadImages','vmodel' => 'preloadImages','label' => 'OnOFF Preloads de imagens Acima da dobra','value' => $preloadImages,'checked' => $preloadImages,])
                                                    <span :class="preloadImagesOn">@{{ preloadImagesOn }}</span>
                                                </li>
            
                                                
            
                                                <li class="seoparam-item">
                                                    @include('front.includes.formulario.Checkbox',['input' => "preloadFonte",'ref' => 'preloadFonte','vmodel' => 'preloadFonte','label' => 'Ocultar WebFont - Fonte padrão do Sistema','value' => $preloadFonte,'checked' => $preloadFonte,])
                                                    <span :class="preloadFonteOn">@{{ preloadFonteOn }}</span>
                                                </li>
                            
                                                <li class="seoparam-item">
                                                    @include('front.includes.formulario.Input',['input' => "tipoAnuncio",'ref' => 'tipoAnuncio','label' => 'Tipo de anúncio, Automático(1), Normal(2)','value' => $tipoAnuncio])
                                                </li>
                                                <li class="seoparam-item">
                                                    @include('front.includes.formulario.Checkbox',['input' => "lazyAds",'ref' => 'lazyAds','vmodel' => 'lazyAds','label' => 'OnOFF LazyAds','value' => $lazyAds,'checked' => $lazyAds,])
                                                    <span :class="lazyAdsOn">@{{ lazyAdsOn }}</span>
                                                </li> 
                                            </ul>
                                        </main>
                                        <br><hr><hr><hr><hr><hr>
                                    </section>
                                    {{-- -------------------------------------------
                                    -------------------------------------------
                                    -------------------------------------------
                                    4 - CAMPOS 
                                    -------------------------------------------
                                    -------------------------------------------
                                    ------------------------------------------- --}}
                                    {{-- titulo --}}
                                    <section class="field">
                                        {{-- <header>                                        
                                        <p class="aproximar"><br></p>
                                    </header> --}}
                                        <div class="row">
                                            @include('front.includes.formulario.Input', [
                                                'input' => 'titulo',
                                                'label' => 'Título',
                                                'old' => old('titulo'),
                                                'inputCol' => 'col-lg-10 titulo',
                                                'class' => 'titulo ',
                                                'ref' => 'titulo',
                                                'vmodel' => 'titulo',
                                                'value' => $titulo,
                                                'placeholder' => 'Título (Obrigatório)',
                                                'ajuda' => '',
                                                'validator' => true,
                                                'msgValidator' => isset($msgValidatorArr['titulo'])
                                                    ? $msgValidatorArr['titulo']
                                                    : null,
                                            ])

                                        </div>
                                    </section>

                                    {{-- frase --}}
                                    <section class="field">
                                        <div class="row">
                                            @include('front.includes.formulario.Textarea', [
                                                'input' => 'frase',
                                                'label' => 'Frase',
                                                'class' => 'frase',
                                                'ref' => 'frase',
                                                'vmodel' => 'frase',
                                                'old' => old('frase'),
                                                'value' => $frase,
                                                'class' => 'frase',
                                                'placeholder' => 'Frase',
                                                'requerid' => 'requerid',
                                                'width' => '100%',
                                                'cols' => '5',
                                                'rows' => '3',
                                            ])

                                        </div>
                                    </section>

                                    {{-- autor --}}
                                    <section class="field">
                                        <div class="row">
                                            <div class="col-lg-2 label-area ">
                                                <label for="">
                                                    Autor
                                                </label>
                                            </div>
                                            <div class=" col-lg-10 field-input">
                                                <input ref="ref_autor" type="hidden" value="{{ $autor }}">
                                                <input type="text" id="autor" name="autor" placeholder=""
                                                    v-model.lazy="autor" class="fadeIn second autor">
                                                @if ($autorDaFrase)
                                                    <a href="/autor/{{ $autorDaFrase->id }}/edit/">Frase ligada ao autor: <i
                                                            class="icon-wrench"></i><strong
                                                            style="display: inline-block;padding:12px 3px 8px 3px;">{{ $autorDaFrase->nome }}</strong></a>
                                                @endif
                                            </div>

                                        </div>
                                    </section>
                                    <hr>
                                    <section class="field">
                                        <div class="row">

                                            <div class="col-lg-2 label-area ">
                                                <label for="">
                                                    Campo Alt nas images
                                                    <span class="ajuda">
                                                        (?)
                                                        <span class="texto-ajuda">
                                                            Alt da imagem da Frase.
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>

                                            <div class=" col-lg-10 field-input">
                                                <span class="preview"
                                                    style="display:block;padding: 8px;background: #fbf9f9;width: auto;">
                                                    Campo Alt & <u>Nome do arquivo da imagem da frase</u>
                                                </span>
                                                <input ref="ref_alt" type="hidden" value="{{ $alt }}">
                                                <input type="text" id="alt" name="alt" placeholder=""
                                                    v-model.lazy="alt" class="fadeIn second alt">
                                                <div class="preview" {{-- v-text="altPreview" --}} ref="altPreview"
                                                    id="preview-alt"
                                                    style="display:block;padding: 8px;background:#90b7b714;width: auto;color:#646262">
                                                    @{{ altPreview }}
                                                </div>
                                            </div>
                                    </section>

                                    <section class="field">
                                        <div class="row">

                                            <div class="col-lg-2 label-area ">
                                                <label for="">
                                                    Imagem para Download
                                                    <span class="ajuda">
                                                        (?)
                                                        <span class="texto-ajuda">
                                                            Nome da imagem para download em JPG.
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>

                                            <div class=" col-lg-10 field-input">
                                                <input ref="ref_nomeDownload" id="nomeDownload" type="text"
                                                    value="{{ $tabela->nomeDownload }}" disabled>
                                                <a class="btn-sucess" href="#ajustar-imagem-para-download"
                                                    style="background:#6fe22c;padding: .7em 25px; display: block;width: 310px;border-radius: 5px;">
                                                    <span class="icon-zynga" style="color:#1a2037">... Mais informações sobre.
                                                </a>
                                            </div>

                                    </section>


                                    <section class="field">
                                        <div class="row">

                                            <div class="col-lg-2 label-area ">
                                                <label for="">
                                                    Physycal Name
                                                    <span class="ajuda">
                                                        (?)
                                                        <span class="texto-ajuda">
                                                            Nome do campo fisico da imagem.
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>

                                            <div class=" col-lg-10 field-input">
                                                <input ref="ref_physical_name" id="physical_name" type="text"
                                                    value="{{ $physical_name }}" disabled>
                                                <a class="btn-sucess" href="#ajustar-nome-das-imagens"
                                                    style="background:#fdc803;padding: .7em 25px; display: block;width: 310px;border-radius: 5px;">
                                                    <span class="icon-zynga" style="color:#1a2037">... Go to: ajustar
                                                        physycal name
                                                </a>
                                            </div>

                                    </section>

                                    <section class="field">
                                        <div class="row">

                                            <div class="col-lg-2 label-area ">
                                                <label for="">
                                                    Lista mandatory
                                                    <span class="ajuda">
                                                        (?)
                                                        <span class="texto-ajuda">
                                                            Id da Lista que é dona desta frase.
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>

                                            <div class=" col-lg-10 field-input">
                                                <input type="text" id="ownerid" name="ownerid"
                                                    value="{{ $ownerid }}" placeholder=""
                                                    class="fadeIn second ownerid">
                                                <a class="btn-sucess"
                                                    href="{{ env('APP_URL') }}/posts/edit/{{ $ownerid }}"
                                                    style="background:#4a47b6;padding: .7em 25px; display: block;width: 310px;border-radius: 5px;">
                                                    <span class="icon-megaphone" style="color:#fff">...Editar Lista
                                                        mandatory desta frase
                                                </a>
                                            </div>

                                        </div>


                                    </section>
                                    <hr>


                                    {{-- status --}}
                                    <section class="field">
                                        <div class="row">
                                            <div class="col-lg-2 label-area ">
                                                <label for="">
                                                    Status
                                                </label>
                                            </div>
                                            <div class=" col-lg-10 field-input">
                                                @include('front.includes.formulario.Radio', [
                                                    'input' => 'status',
                                                    'label' => 'Em pré-análise',
                                                    'value' => '0',
                                                    'checked' => $status == '0' ? 'true' : 'false',
                                                ])
                                                @include('front.includes.formulario.Radio', [
                                                    'input' => 'status',
                                                    'label' => 'Indexar no Google',
                                                    'value' => '1',
                                                    'checked' => $status == '1' ? 'true' : 'false',
                                                ])
                                                @include('front.includes.formulario.Radio', [
                                                    'input' => 'status',
                                                    'label' => 'Não indexa',
                                                    'value' => '2',
                                                    'checked' => $status == '2' ? 'true' : 'false',
                                                ])
                                                @include('front.includes.formulario.Radio', [
                                                    'input' => 'status',
                                                    'label' => 'Lixeira',
                                                    'value' => '9',
                                                    'checked' => $status == '9' ? 'true' : 'false',
                                                ])
                                                @include('front.includes.formulario.Radio', [
                                                    'input' => 'status',
                                                    'label' => 'Reprovada',
                                                    'value' => '4',
                                                    'checked' => $status == '4' ? 'true' : 'false',
                                                ])
                                                @include('front.includes.formulario.Radio', [
                                                    'input' => 'status',
                                                    'label' => 'Duplicada',
                                                    'value' => '5',
                                                    'checked' => $status == '5' ? 'true' : 'false',
                                                ])
                                                @include('front.includes.formulario.Radio', [
                                                    'input' => 'status',
                                                    'label' => 'Duplicada em uso',
                                                    'value' => '51',
                                                    'checked' => $status == '51' ? 'true' : 'false',
                                                ])
                                            </div>
                                        </div>
                                    </section>

                                    {{-- status --}}
                                    <section class="field">
                                        <div class="row">
                                            <div class="col-lg-2 label-area ">
                                                <label for="">
                                                    Tipo de Imagem de Fundo
                                                </label>
                                            </div>
                                            <div class=" col-lg-10 field-input">
                                                @include('front.includes.formulario.Radio', [
                                                    'input' => 'tipo_imagem',
                                                    'label' => 'Amor',
                                                    'vmodel' => 'tipo_imagem',
                                                    'value' => '1',
                                                    'checked' => $tipo_imagem == '1' ? 'true' : 'false',
                                                ])
                                                @include('front.includes.formulario.Radio', [
                                                    'input' => 'tipo_imagem',
                                                    'label' => 'Feminino',
                                                    'vmodel' => 'tipo_imagem',
                                                    'value' => '2',
                                                    'checked' => $tipo_imagem == '2' ? 'true' : 'false',
                                                ])
                                                @include('front.includes.formulario.Radio', [
                                                    'input' => 'tipo_imagem',
                                                    'label' => 'Motivação',
                                                    'vmodel' => 'tipo_imagem',
                                                    'value' => '3',
                                                    'checked' => $tipo_imagem == '3' ? 'true' : 'false',
                                                ])
                                                @include('front.includes.formulario.Radio', [
                                                        'input' => 'tipo_imagem',
                                                        'label' => 'Pensativo',
                                                        'vmodel' => 'tipo_imagem',
                                                        'value' => '4',
                                                        'checked' => $tipo_imagem == '4' ? 'true' : 'false',
                                                    ])
                                            </div>
                                        </div>
                                    </section>

                                    {{-- campos ocultos REVER --}}
                                    <div class="campos-ocultos">
                                        @include('front.includes.formulario.Hidden', [
                                            'input' => 'idTabela',
                                            'value' => $idTabela,
                                            'vmodel' => 'idTabela',
                                            'ref' => 'idTabela',
                                        ])
                                    </div>

                                    {{-- aqui form --}}
                                    {{-- endMagic --}}
                                </div>


                                <div class="content-wrapper">
                       
                                    {{-- capa --}}
                                    <section class="field field-preview-listas">
                                        {{-- <random opcoes="{{ $options }}"></random> --}}
                                        <header>
                                            <h2>Informações sobre a Imagem da Frase</h2>
                                            <span style="font-size: 12px;">{{ $imgSrc }}{{ $ver }}</span>
                                            <p>Dimensões; 612 x 612 
                                            </p>
                                        </header>
                                        <div class="preview-imagem container" ref="preview">

                                            <div v-show="mostraCapa">
                                                <div class="display">Preview: </div>
                                                <a class="remove-image float-right bt-lixeira icon-trash-1"
                                                    title="Remover a imagem" @click.stop.prevent="removeImage"></a>
                                                <div class="row">
                                                    <div class="col-lg-12 preview-listas">
                                                        <div class="row" v-show="mostraCropZone">
                                                            <div class="col-12">
                                                                <clipper-fixed :round="false" :area="100"
                                                                :ratio="1" bg-color="black"
                                                                {{-- :bg-color="0" --}}
                                                                style="width:100%;background: black;"
                                                                :src="src" ref="clipper">
                                                                <div slot="placeholder">
                                                                    Please upload image
                                                                </div>
                                                            </clipper-fixed>
                                                            <input type="hidden" id="result" name="result"
                                                                :value="result">
                                                            <div class="crop_ranger_zone">
                                                                <div class="rw">
                                                                    <img src="{{ asset('images/default/crop-scrool-v01.png') }}"
                                                                        class="crop_img before" alt="IMgs">
                                                                </div>
                                                                <div class="ranger_btn_zone">
                                                                    <clipper-range ref="ranger" v-model="area"
                                                                        style="max-width:300px" :min="0"
                                                                        :max="360"></clipper-range>
                                                                </div>
                                                                <div class="rw">
                                                                    <img src="{{ asset('images/default/crop-scrool-v01.png') }}"
                                                                        class="crop_img after" alt="IMgs">
                                                                </div>
                                                            </div>
                                         
                                                            </div>
                                                            <div class="col-4" style="display:none;">
                                                                <div>Visualização: @{{ pixel }}</div>
                                                                <img :src="result"
                                                                    class="preview-imagem-result squad"
                                                                    alt="sem resultado">
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="crop_buttons_zone">
                                                                    <clipper-upload v-model="src"
                                                                        class="btn crop-button ">Buscar outra Imagem
                                                                    </clipper-upload>
                                                                    <button
                                                                        class="save save-branco submit bt-center callAction"
                                                                        @click.stop.prevent="cortar">Cortar</button>

                                                                        
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="area-da-capa" style="display: none">
                                                            <div class="background-capa frase" v-show="!mostraCropZone"
                                                                v-bind:data="imgSrc"
                                                                v-bind:style="{ backgroundImage: 'url(' + imgSrc + ')' }">
                                                                @if (isset($imgSrc))
                                                                    @if (!file_exists($save_to_path))
                                                                        <img ref="imgSrc"
                                                                            src="/images/default/semcapa-v07.jpg"
                                                                            data-src="/images/default/semcapa-v07.jpg"
                                                                            class="capa avatar frase" alt="capa">
                                                                    @else
                                                                        <img ref="imgSrc" src="{{ $imgSrc . $ver }}"
                                                                            data-src="{{ $imgSrc . $ver }}"
                                                                            class="capa avatar frase" alt="capa">
                                                                        
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <section class="field">

                                                            <div class="col-lg-12">
                                                                <h3>Se a imagem estiver trancada:</h3>
                                                                <ul>
                                                                    <li>1 - Não podemos, rodar o PipiF para esta frase
                                                                        </li>
                                                                    <li>2 - Não podemos, Fazer upload de uma nova imagem</li>
                                                                    <li>3 - Se rodarmos o processo de <strong>"Regerar
                                                                            imagens das Frases"</strong> lá na lista
                                                                        mandatory desta frase, <strong>NADA</strong> vai
                                                                        acontecer para esta frase trancada.</li>
                                                                    <li>4 - SIM POdemos, regerar a imagem mobile desta frase</li>
                                                                    <li>5 - SIM POdemos, Renomenar o arquivo físico da imagem desta frase</li>
                                                                    {{-- ● Projeto20221201 - 11-12-22, Apenas informação visual de regra--}}
                                                                    <li>6 - SIM POdemos, gerar/Regerar o arquivo para download desta</li> 
                                                                </ul>
                                                            </div>
                                                        </section>

                                                        <section class="field">
                                                            <div class="row">
                                                                <div class="col-lg-2 label-area ">
                                                                    <label for="">
                                                                        Regerar imagem?
                                                                    </label>
                                                                </div>
                                                                <div class=" col-lg-10 field-input">
                                                                    @include('front.includes.formulario.Radio',
                                                                        [
                                                                            'input' => 'capaupload',
                                                                            'label' =>
                                                                                'Não pode, manter trancada a imagem',
                                                                            'value' => 'trancado',
                                                                            'checked' =>
                                                                                $capaupload == 'trancado'
                                                                                    ? 'true'
                                                                                    : 'false',
                                                                        ])
                                                                    @include('front.includes.formulario.Radio',
                                                                        [
                                                                            'input' => 'capaupload',
                                                                            'label' =>
                                                                                'Sim, pode regerar à vontade e se puder...',
                                                                            'value' => 'liberado',
                                                                            'checked' =>
                                                                                $capaupload == 'liberado'
                                                                                    ? 'true'
                                                                                    : 'false',
                                                                        ])
                                                                </div>
                                                            </div>

                                                        </section>
                                                        <capa opcoes="{{ $options }}"></capa>

                                                        @include('front.includes.formulario.Hidden', [
                                                            'input' => 'capa',
                                                            'value' => $imgSrc,
                                                            'vmodel' => 'capa', //'vmodel'=>'avatar_icone'
                                                        ])

                                                        @include('front.includes.formulario.Hidden', [
                                                            'input' => 'ver',
                                                            'value' => $ver, //'vmodel'=>'avatar_icone'
                                                        ])
                                                        @include('front.includes.formulario.Hidden', [
                                                            'input' => 'midia_id',
                                                            'value' => $midiaId, //$usuario->avatar_icone_id
                                                        ])
                                                        @include('front.includes.formulario.Hidden', [
                                                            'input' => 'unsplashVar',
                                                            'vmodel' => 'unsplashVar',
                                                        ])

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>



                                    {{-- Autor do Post --}}
                                    <section class="field">
                                        <div class="row">
                                            @include('front.includes.formulario.Input', [
                                                'input' => 'usuario_id',
                                                'label' => 'Autor ID',
                                                'inputCol' => 'col-lg-10 autor',
                                                'old' => old('usuario_id'),
                                                'class' => 'autor',
                                                'ref' => 'usuario_id',
                                                'value' => $usuario_id,
                                                'placeholder' => 'Autor do Post',
                                            ])
                                        </div>
                                    </section>

                                    {{-- Autor do Post --}}
                                    <section class="field">
                                        <div class="row">
                                            @include('front.includes.formulario.Input', [
                                                'input' => 'cdn',
                                                'label' => 'CDN',
                                                'inputCol' => 'col-lg-10 cdn',
                                                'old' => old('cdn'),
                                                'class' => 'cdn',
                                                'ref' => 'cdn',
                                                'value' => $cdn ? $cdn : '',
                                                'placeholder' => 'cdn',
                                            ])
                                        </div>
                                    </section>

                                    {{-- FIM  Botões de ação --}}
                                    <section class="field">
                                        <div class="row">
                                            <div class="col-md-6 float-center center  zona-bt-enviar-lista ">
                                                @include('front.includes.formulario.Btsalvar', [
                                                    'rota' => 'frase.update',
                                                    'id' => $idTabela,
                                                    'class' => 'callAction',
                                                    'vaction' => 'salvar',
                                                
                                                    'aviso' => 'confirma info',
                                                    'pergunta' => 'Deseja Publicar o post?',
                                                    'lbconfirma' => 'Salvar',
                                                    'icone' => 'enviar',
                                                    'label' => 'Salvar frase',
                                                    'tip' => 'Salvar a frase',
                                                ])
                                            </div>

                                        </div>
                                    </section>
                                </div>
                                <div class="content-wrapper">
                                    {{-- Nuvem de tags --}}
                                    <section>
                                        <div class="row">
                                            <div class="col">
                                                <nuvem-tag opcoes="{{ $options }}"
                                                    listatags="{{ json_encode($tagsDoPost) }}"
                                                    tagdados="{{ json_encode($tag_Dados) }}"></nuvem-tag>
                                                @include('front.includes.formulario.Hidden', [
                                                    'input' => 'tags',
                                                    'label' => 'Tags',
                                                    'class' => 'tags',
                                                    'ref' => 'tags',
                                                    'vmodel' => 'tags',
                                                    'ajuda' => 'Separe com vírgulas',
                                                    'value' => $tags,
                                                    'class' => 'tags',
                                                ])
                                            </div>
                                        </div>
                                    </section>
                                </div>

                            </form>

                            {{-- ● Projeto202207 26-ago-22
                                - Ocultar estas rotinas não mais usadas    
                            --}}
                            
                            {{-- <div class="content-wrapper" id="ajustar-webp">
                                <header>
                                    <h2>
                                        <i class="icon favorito" style="margin:1px 18px 0px 0px;"></i>
                                        Ajustar a imagem Webp pendente...
                                    </h2>
                                </header>
                                <section>
                                    <div class="row">
                                        <div class="col">
                                            <form class="form-box"
                                                action="{{ route('marlon.verificaWebpPendente', 'f;' . $idTabela) }}"
                                                action="" method="GET">
                                                {{ csrf_field() }}
                                                @method('PUT')
                                                <button>
                                                    <span class="icon-zynga" style="color:#fff"> Pega bolfo!
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            </div> --}}


                            <div class="content-wrapper" id="transformar-em-webp">
                                <header>
                                    <h2>
                                        Transformar em .webp...
                                    </h2>
                                    <h4 style="background:#4a47b6; height:4px"></h4>
                                </header>
                                <section>
                                    <div class="row">
                                        <div class="col">
                                            <p>
                                                ps: Transforma a imagem desta frases em webp
                                            </p>
                                            <form class="form-box"
                                                action="{{ route('marlon.transformaEmWebp', 'f;' . $idTabela) }}"
                                                action="" method="GET">
                                                {{ csrf_field() }}
                                                @method('PUT')
                                                <button style="background: #4a47b6;color: #fff;">
                                                    Transforma em webp!
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div class="content-wrapper" id="ajustar-imagem-para-download">
                                <header>
                                    <h2>
                                        <i class="icon favorito" style="margin:1px 18px 0px 0px;"></i>
                                        Imagem para download em JPG
                                    </h2>
                                    <h4 style="background:#6fe22c; height:4px"></h4>
                                </header>
                                <section>
                                    <div class="col-lg-12">
                                        <h3>Informações sobre imagem jpg para download na single de frases</h3>
                                        <h3>PS:</h3>
                                        <p> - Este processo também pode ser executado  <strong>em qualquer post </strong> dona desta frase.</p>
                                        <p> - SEMPRE que rodar o PiPIf, tanto no post quanto aqui na single, será regerado uma imagem JPG para download.</p>
                                        <p> - Quando não tiver sido gerado o arquivo de download, na single de frases será providenciado a imagem .webp de capa para download</p>
                                    </div>
                                </section>
                            </div>
                            <div class="content-wrapper" id="ajustar-imagem-mobile">
                                <header>
                                    <h2>
                                        <i class="icon favorito" style="margin:1px 18px 0px 0px;"></i>
                                        Regerar imagem MOBILE da frase
                                    </h2>
                                    <h4 style="background:#be0b89; height:4px"></h4>
                                </header>
                                <section>
                                    <div class="col-lg-12">
                                        <h3>Este processo vai regerar a imagem Mobile desta frase</h3>
                                        <h3>PS:</h3>
                                        <p> - Este processo é ideal para <strong>imagens oriundas de upload do computador.</strong> 
                                            Sempre rode este processo logo após algum upload.</p>
                                        <p> - Este processo <strong>não vai alterar a imagem principal </strong> desta frase.</p>
                                        <p> - Poderá ser executado também pela lista mandatória desta frase.</p>

                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <form class="form-box"
                                                action="{{ route('marlon.ajustaralt', 'f;' . $idTabela) }}" action=""
                                                method="GET">
                                                {{ csrf_field() }}
                                                @method('PUT')
                                                <button class="btn-sucess" style="background:#be0b89;color:#fff;">
                                                    REgerar...
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div class="content-wrapper" id="ajustar-nome-das-imagens">
                                <header>
                                    <h2>
                                        <i class="icon favorito" style="margin:1px 18px 0px 0px;"></i>
                                        Renomenar o arquivo físico da imagem
                                    </h2>
                                    <h4 style="background:#fdc803; height:4px"></h4>
                                    
                                </header>
                                <section>
                                    <div class="col-lg-12">
                                        <h3>Renomer o arquivo físico, com base no conteúdo do campo "ALT" desta frase</h3>
                                        <h3>PS:</h3>
                                        <p> - Precisa informar primeiramente o <strong>campo ALT </strong> desta frase.</p>

                                        <p> - Este processo também pode ser executado na <strong>Lista Mandatory</strong>
                                            dona desta frase.</p>
                                        <p> - Você poderá verificar como ficou o resultado deste processo, consultando o
                                            campo <strong>PHYSYCAL_NAME</strong> no ínicio desta tela.</p>
                                        <p> - O sistema vai sempre renomear também a imagem mobile correspondente</p>
                                        <p> - O sistema vai sempre renomear também a imagem para download desta frase</p>

                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <form class="form-box"
                                                action="{{ route('marlon.ajustaralt', 'f;' . $idTabela) }}" action=""
                                                method="GET">
                                                {{ csrf_field() }}
                                                @method('PUT')
                                                <button class="btn-sucess" style="background:#fdc803">
                                                    <span class="icon-zynga" style="color:#1a2037"> Ajustar physical_name
                                                        para esta imagem
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            @if (count($arrFrases))
                                {{-- posts desta frase --}}
                                <div class="content-wrapper">
                                    <header>
                                        <h1>
                                            <i class="icon icone icon-007-copy"></i>
                                            Uso desta Frase:
                                        </h1>
                                        @if ($chave)
                                            <strong>key: </strong>{{ $chave }}
                                        @endif

                                    </header>
                                    <section>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h3>Veja quais as listas(posts) usam esta frase!</h3>
                                            </div>
                                            <div class="col-lg-12">

                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Id</th>
                                                            <th scope="col">Classific</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Post</th>
                                                            <th scope="col">Ordem Na Lista</th>
                                                            <th scope="col">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @foreach ($arrFrases as $item)
                                                            @php
                                                                //Controle do Marlon
                                                                if ($item['maisAntiga']) {
                                                                    $fraseMaisAntiga = $item['idDaFrase'];
                                                                } else {
                                                                    $tokenFrases .= '|tk|' . $item['idDaFrase'];
                                                                    $tokenPostItens .= '|tk|' . $item['idDopostItem'];
                                                                }
                                                                
                                                                if ($item['classific'] == 'Duplicada') {
                                                                    $lDuplicadas = true;
                                                                }
                                                                
                                                            @endphp
                                                            <tr>
                                                                <td>
                                                                    <a
                                                                        href="{{ route('frase.edit', $item['idDaFrase']) }}">{{ $item['idDaFrase'] }}</a>
                                                                </td>
                                                                <td>
                                                                    @if ($item['maisAntiga'])
                                                                        <span class="publicado">+antiga</span>
                                                                    @endif
                                                                    @if ($item['atual'])
                                                                        <span class="rejeitado">atual</span>
                                                                    @endif

                                                                    {{ $item['classific'] }}

                                                                </td>
                                                                <td>{{ $item['status'] }}</td>
                                                                <td>
                                                                    @if ($item['idDopost'])
                                                                        <a
                                                                            href="{{ route('post.edit', $item['idDopost']) }}">{{ $item['tituloPost'] }}</a>
                                                                    @else
                                                                        {{ $item['tituloPost'] }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    {{ $item['ordemPost'] }}
                                                                </td>
                                                                <td>
                                                                    @if ($item['idDopost'] == "$ownerid")
                                                                        <a
                                                                            href="{{ route('post.edit', $item['idDopost']) }}">
                                                                            <span
                                                                                style="padding: 8px;background: #4a47b6;color: #fff;">mandatory</span>
                                                                        </a>
                                                                    @endif

                                                                    @if ($item['idDopost'])
                                                                    @else
                                                                        @if (!$item['atual'])
                                                                            <form
                                                                                ref="frase_delete{{ $item['idDaFrase'] }}"
                                                                                class="form-box"
                                                                                action="{{ route('frases.destroy', $item['idDaFrase']) }}"
                                                                                method="POST">
                                                                                {{ csrf_field() }}
                                                                                {{ method_field('DELETE') }}
                                                                                @method('DELETE')
                                                                                @include('front.includes.formulario.Hidden',
                                                                                    [
                                                                                        'input' => 'id',
                                                                                        'value' =>
                                                                                            $item['idDaFrase'],
                                                                                    ])
                                                                                @include('front.includes.formulario.Btaction',
                                                                                    [
                                                                                        'input' => 'add',
                                                                                        'aviso' =>
                                                                                            'confirma cuidado',
                                                                                        'icone' => 'icon-trash',
                                                                                        'class' => 'btn-danger',
                                                                                        'pergunta' =>
                                                                                            'Deseja deletar para sempre?',
                                                                                        'vaction' =>
                                                                                            'frase_delete' .
                                                                                            $item['idDaFrase'],
                                                                                        'tip' =>
                                                                                            'Destruir de vez',
                                                                                    ])
                                                                            </form>
                                                                        @endif
                                                                    @endif

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            @if ($lDuplicadas)
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <form ref="ajustar_duplicada{{ $idTabela }}" class="form-box"
                                                            action="{{ route('marlon.ajustarFraseDuplicada') }}"
                                                            method="POST">
                                                            {{ csrf_field() }}
                                                            @method('POST')

                                                            @include('front.includes.formulario.Hidden', [
                                                                'input' => 'fraseMaisAntiga',
                                                                'value' => $fraseMaisAntiga,
                                                            ])
                                                            @include('front.includes.formulario.Hidden', [
                                                                'input' => 'tokenFrases',
                                                                'value' => $tokenFrases,
                                                            ])
                                                            @include('front.includes.formulario.Hidden', [
                                                                'input' => 'tokenPostItens',
                                                                'value' => $tokenPostItens,
                                                            ])

                                                            <p>
                                                                @include('front.includes.formulario.Btaction',
                                                                    [
                                                                        'input' => 'add',
                                                                        'title' => 'as',
                                                                        'aviso' => 'confirma info',
                                                                        'icone' => 'icon-zynga',
                                                                        'label' =>
                                                                            'Marlon - ajustar Frases duplicadas',
                                                                        'class' => 'callAction',
                                                                        'pergunta' =>
                                                                            'Deseja que o Marlon ajuste estas frases duplicadas acima?',
                                                                        'vaction' =>
                                                                            'ajustar_duplicada' . $idTabela,
                                                                        'tip' => 'Ajustar',
                                                                    ])

                                                            </p>
                                                            <p>&nbsp;</p>

                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <p>
                                                            <a href="{{ route('marlon.deletarduplicadas', '0') }}"
                                                                class="btn bt-call btn-success marlon">
                                                                <span class="icon-zynga" style="color:#000">4º Setar
                                                                    deletado frases duplicadas não utilizadas
                                                            </a>
                                                        </p>

                                                    </div>

                                                </div>
                                            @endif


                                        </div>
                                    </section>
                                </div>
                                {{-- Fim Post --}}
                            @endif
                            {{-- Excluir Lista --}}
                            @if ($idTabela)
                                <div class="content-wrapper">
                                    <header>
                                        <h1>
                                            <i class="icon atention"></i>
                                            Excluir Frase
                                        </h1>
                                    </header>
                                    <section>
                                        <div class="row">
                                            <h3>Após a exclusão, é impossível reativar o registro :(</h3>
                                            <div class="col-lg-12">
                                                @php
                                                    $vaction = 'enviar_lixeira' . $idTabela;
                                                    $pergunta = 'Deseja realmente excluir ese item?';
                                                    $aviso = 'confirma cuidado';
                                                @endphp

                                                <form ref="enviar_lixeira{{ $idTabela }}" class="form-box"
                                                    action="{{ route('frases.destroy', $idTabela) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    @method('DELETE')
                                                    @include('front.includes.formulario.Hidden', [
                                                        'input' => 'id',
                                                        'value' => $idTabela,
                                                    ])

                                                    <a href=""
                                                        v-on:click="getConfirm('{{ $vaction }}', $event, '{{ $pergunta ?? 'Confirma esta operação:?' }}', '{{ $aviso ?? 'atencao' }}')"
                                                        class="botao-padrao full red" title="Excluir">
                                                        Excluir
                                                    </a>
                                                </form>

                                            </div>
                                        </div>
                                    </section>
                                </div>
                            @endif
                    </div>
                </div>
            </div>

            {{-- foter --}}
            @include('front.includes.Footer')
        </div>
    </div>
@endsection
@section('js-view')
    <script src="{{ asset('js/FrasesForm.js') }}?ver={{ env('VER') }}"></script>
@endsection
