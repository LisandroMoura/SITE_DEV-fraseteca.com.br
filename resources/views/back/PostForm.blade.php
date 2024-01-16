@extends('template.Usuario')

@section('css-view')
    <style>
        .anchors {
            display: block;
            display: block;
            position: fixed;
            top: 84px;
            right: 0;
        }

        .anchors label {
            display: block;
            margin: 0;
            margin: 0 0px 0 50px;
            background: rgb(253, 200, 3);
            text-align: center;
            color: #1a2037;
        }

        ul.ul-anchor-fixed {
            list-style-type: disclosure-closed;
        }

        ul.ul-anchor-fixed li {
            margin: 8px;
            background: #fbf4f4;
            color: #ccc;
        }

        ul.ul-anchor-fixed li a {
            color: #1a2037;
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
        ul.toolss{
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        nav.flex.items-center.justify-between
        {
            display: inline;
        } 
        .flex.justify-between{
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: flex-start;
            align-content: flex-end;
            width: 100%;
            justify-content: space-around;
            span{

            }
        }
    </style>
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

        $default_page = 'posts';
        $actionParam = false;
        // $options="";
        if (isset($_GET['action'])) {
            $actionParam = $_GET['action'] ? $_GET['action'] : null;
        }

        //1) dados da tabela
        $idTabela = 0;
        $titulo = '';
        $urlamigavel = '';
        $imgSrc = asset('images/padrao.jpg');
        $tipo = '1';
        $capa = '';
        $resumo = '';
        $midiaId = '';
        $categoria_id = '';
        $corpo = '';
        $tags = '';
        $aux_1 = '';
        $alt = '';
        $status = 0;
        $categoria_Dados = [];
        $tag_Dados = [];
        $tagsDoPost = [];
        $bancoDeTags = '';
        $thumb = '';
        $mobile = '';
        $imprime_capa = '';
        $autor_id = 0;
        $unsplashIdFotoAtual = '';
        $unsplashIdFotoAtualThumb = '';
        $ordenConf = 0;
        $autorName = '';
        $autorLink = '';

        if (isset($post)):
            $i = 0;
            $idTabela = $post ? $post->id : 0;
            $tipo = $post ? $post->tipo : '1';
            $titulo = $post ? $post->titulo : '';
            $resumo = $post ? $post->resumo : '';
            $alt = $post ? $post->alt : '';
            $corpo = $post ? $post->corpo : 'Escreva aqui...';
            $urlamigavel = $post ? $post->urlamigavel : '';
            
            //imagens
            $ver = "?ver=" . Str::random(10);
            $capa = $post ? $post->capa . $ver: '0';
            $mobile = $post->mobile ? $post->mobile . $ver : $post->thumb . $ver;
            $thumb = $post ? $post->thumb . $ver : '';
            $imgSrc = $post ? $post->getImagemCapaAttribute() . $ver : $capa;

            $status = $post ? $post->status : '0';
            $midiaId = $post ? $post->midia_id : 0;
            $autor_id = $post ? $post->autor_id : 0;
            $categoria_id = $post ? $post->categoria_id : 0;
            $tags = $post ? $post->tags : '';
            $aux_1 = $post ? $post->aux_1 : '';

            //SEO PARAMS
            $arrayParams    = $post->getSeoParamsAttribute();
            $anuncios       = $post->anuncios ?? 'false';
            $analytics = data_get($arrayParams, '0', false) ;
            $lazyOn = data_get($arrayParams, '1', null) ;
            $momentolazy    = $post->momentolazy;
            $preloadImages = data_get($arrayParams, '2', null) ;
            // ● 23-ago-22 LM Projeto20220802 - Atraso de imagens em AMP page
            $atrasoAmp = data_get($arrayParams, '7', null) ;
            $preloadFonte = data_get($arrayParams, '3', null) ;
            // ● Projeto20220802 - LazyLoad das imagens iniciais
            $lazyImgInicial  = data_get($arrayParams, '4', null);
            $imagemforte    = $post->imagemforte;
            // $imagemResponsivaAll = data_get($arrayParams, '4', null) ;
            $tipoAnuncio = data_get($arrayParams, '5', null) ;
            $lazyAds = data_get($arrayParams, '6', null) ;
            //////////////////////////////////////////// FIM SEO PARAMS 
            $imprime_capa = $post ? $post->imprime_capa : '1';
            $autorName = $post ? $post->autorName : '';
            $autorLink = $post ? $post->autorLink : '';
            
            // $imgSrc.= $ver;
            // $imgSrc =  $capa;

            if ($imgSrc == '' || $imgSrc == 'null') {
                $imgSrc = asset('images/padrao.jpg');
            }

            $aux = explode('&id=', $imgSrc);
            if (count($aux) > 1) {
                $unsplashIdFotoAtual = $aux[1];
            }

            $aux = explode('&id=', $thumb);
            if (count($aux) > 1) {
                $unsplashIdFotoAtualThumb = $aux[1];
            }

            $nfrases = 0;
            $nAnuncios = 0;
            $nConvites = 0;
            $nAnchors = 0;
            $arrAnchor = [];

            if (count($itens) > 1) {
                foreach ($itens as $key => $item) {
                    # code...
                    if ($item->tipo == '1') {
                        $nfrases++;
                    }

                    if ($item->tipo == '2') {
                        $nAnuncios++;
                    }

                    if ($item->tipo == '4') {
                        $nConvites++;
                    }

                    if ($item->tipo == '3') {
                        $nAnchors++;

                        array_push($arrAnchor, [
                            'aux_1' => $item->aux_1,
                            'aux_2' => $item->aux_2,
                        ]);
                    }
                }
            }
        endif;

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
        if (isset($categorias)):
            foreach ($categorias as $key => $categoria) {
                $categoria_Dados[$categoria->descricao] = $categoria->id;
            }
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

                <div class="anchors">
                    <label for="">Anchors</label>
                    <ul class="ul-anchor-fixed">
                        @foreach ($arrAnchor as $anchor)
                            <li>
                                <a href="#{{ $anchor['aux_2'] }}">{{ $anchor['aux_1'] }}</a>

                            </li>
                        @endforeach
                    </ul>
                </div>
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
                        <div class="toolbkp">
                            <ul>
                                <li>
                                    <a href="#frases-da-lista" alt="Frases" title="Frases">
                                        <span style="font-size: 26px;">💭</span>
                                    </a>
                                    <a href="#">|</a>
                                </li>
                                <li>
                                    <a href="#pipif" title="PiPiF">
                                        <span style="font-size: 26px;">🐈</span>
                                    </a>
                                    <a href="#">|</a>
                                </li>
                                <li>
                                    <a href="#piedpiper" title="piedpiper">
                                        <span style="font-size: 26px;">🐀</span>
                                    </a>
                                    
                                </li>
                                @if (!count($itens) && $idTabela > 0)
                                    <li>
                                        @php
                                            $vaction = 'criar_itens' . $idTabela;
                                            $pergunta = 'Criar itens do Post com base no modelo antigo (o do editor texto)?';
                                            $aviso = 'confirma info';
                                        @endphp
                                        <a href="#">|</a>
                                        <form ref="criar_itens{{ $idTabela }}" class="form-box"
                                            action="{{ route('posts_iniciar_itens', $idTabela) }}" method="GET">
                                            {{ csrf_field() }}
                                            @include(
                                                'front.includes.formulario.Hidden',
                                                ['input' => 'id', 'value' => $idTabela]
                                            )
                                            <a href="#">|</a>
                                            <a href=""
                                                v-on:click="getConfirm('{{ $vaction }}', $event, '{{ $pergunta ?? 'Confirma esta operação:?' }}', '{{ $aviso ?? 'atencao' }}')"
                                                class="bt-rosa"
                                                style="background:  #3490dc; color:#fff;padding:8px 8px" title="Recuperar">
                                                iniciar itens
                                            </a>
                                        </form>
                                    </li>
                                @endif

                                {{-- <li>
                                    
                                    @php
                                        $vaction = 'reiniciar_itens' . $idTabela;
                                        $pergunta = 'ReCriar itens do Post com base no modelo antigo (o do editor texto)?';
                                        $aviso = 'confirma info';
                                    @endphp
                                    <form ref="reiniciar_itens{{ $idTabela }}" class="form-box"
                                        action="{{ route('posts_reiniciar_itens', $idTabela) }}" method="GET">
                                        {{ csrf_field() }}
                                        @include(
                                            'front.includes.formulario.Hidden',
                                            ['input' => 'id', 'value' => $idTabela]
                                        )
                                        <a href="#">|</a>
                                        <a href=""
                                            v-on:click="getConfirm('{{ $vaction }}', $event, '{{ $pergunta ?? 'Confirma esta operação:?' }}', '{{ $aviso ?? 'atencao' }}')"
                                            class="bt-rosa" style="background:  #f87102; color:#fff;padding:8px 8px"
                                            title="ReIniciar">
                                            Zerar e REiniciar itens
                                        </a>
                                     

                                    </form>
                                </li> --}}

                            </ul>

                        </div>
                        <?php endif;?>
                        <?php if($idTabela > 0): //UPDATE ?>
                        {{-- BOTÃO VER SITE --}}
                        <div class="ver-site">
                            @php
                                $rotaVer = env('APP_URL') . '/' . $post->urlamigavel;
                            @endphp
                            <a href="{{ $rotaVer }}">Ver Post</a>

                        </div>
                        <div class="bt-salvar-fixed">
                            @include('front.includes.formulario.Btsalvar', [
                                'rota' => 'post.update',
                                'id' => $idTabela,
                                'class' => 'rascunho item-bt-salvar-fixed',
                                'vaction' => 'enviarParaRascunho',
                                'icone' => 'save',
                                'tip' => 'Salvar alterações',
                            ])
                            <a href="#fim"
                                style="display: block;margin-top: 10px;background: #f0f0f0;color: #3d4745;padding: .7em;text-align: center;border-radius: 5px;box-shadow: 0 5px 10px rgba(81, 81, 81, 0.3);"><i
                                    class="ico ico-seta "></i> <span></span></a>
                        </div>

                        {{-- FORM DE UPDATE --}}
                        <form ref="formulario" action="{{ route('post.update', $idTabela) }}" method="post"
                            enctype="multipart/form-data">
                            @method('PUT')

                            <?php else: //STORE ?>
                            <form ref="formulario" action="{{ route('post.store') }}" method="post"
                                enctype="multipart/form-data">
                                <?php endif;?>
                                {{ csrf_field() }}
                                {{-- from --}}
                                <div class="content-wrapper">
                                    @if ($imgSrc != 'https://fraseteca.com.br/storage/images/thumbnail.jpg.jpg' && $imgSrc != 'https://fraseteca.dev.io/storage/images/thumbnail.jpg.jpg' && $imprime_capa == '1'   )
                                        <section class="field">
                                            <div class="area-da-capa">
                                                <div class="background-capa post" v-show="!mostraCropZone"
                                                    v-bind:data="imgSrc"
                                                    v-bind:style="{ backgroundImage: 'url(' + imgSrc + ')' }">
                                                    @if (isset($imgSrc))
                                                        <img ref="imgSrc" src="{{ $imgSrc }}"
                                                            data-src="{{ $imgSrc }}" class="capa avatar form"
                                                            alt="capa">
                                                    @endif
                                                </div>
                                            </div>
                                        </section>
                                    @endif
                                    <header>
                                        {{-- 3 Nome da tela --}}
                                        @php
                                            $descricao = "";

                                            foreach ($errors->all() as $error) {

                                                $descricao.= $error . " - " ;
                                            }

                                        @endphp
                                       
                                        <h1 style="font-size: 41px">
                                            📝 Editando a Biblioteca:
                                            @if ($idTabela > 0)
                                                {{$titulo}}
                                            @else
                                                Criando Post
                                            @endif
                                        </h1>
                                        @if ($descricao)
                                            @if ($errors->first() =='sucesso' || $errors->first() =='1'  )  
                                                <h3 style="color: #6fe22c"> {{ $descricao }}</h3>
                                            @else 
                                                <h3 style="color: #e52134"> ERROR: {{ $descricao }}</h3>
                                            @endif    
                                        @endif
                                    </header>

                                    <hr><hr><hr><hr><hr><br>
                                    
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
                                                    @include('front.includes.formulario.Checkbox',['input' => "lazyOn",'ref' => 'lazyOn','vmodel' => 'lazyOn','label' => 'OnOFF LazyLoad','value' => $lazyOn,'checked' => $lazyOn,])
                                                    <span :class="lazyOnOn">@{{ lazyOnOn }}</span>
                                                </li>
                                                <li class="seoparam-item">
                                                    @include('front.includes.formulario.Input',['input' => "momentolazy",'ref' => 'momentolazy','label' => 'MomentoLazy / ou lazy das imagens iniciais','value' => $momentolazy])
                                                </li>

                                                {{-- // ● Projeto20220802 - LazyLoad das imagens iniciais --}}
                                                <li class="seoparam-item">
                                                    @include('front.includes.formulario.Checkbox',['input' => "lazyImgInicial",'ref' => 'lazyImgInicial','vmodel' => 'lazyImgInicial','label' => 'LazyLoad de imagens iniciais (capa e frases) ps: LazyLoad tem que estar ligado - Configure o lazy das imagens iniciais para funcionar','value' => $lazyImgInicial,'checked' => $lazyImgInicial,])
                                                    <span :class="lazyImgInicialOn">@{{ lazyImgInicialOn }}</span>
                                                </li>

                                                <li class="seoparam-item">
                                                    @include('front.includes.formulario.Checkbox',['input' => "preloadImages",'ref' => 'preloadImages','vmodel' => 'preloadImages','label' => 'OnOFF Preloads de imagens Acima da dobra','value' => $preloadImages,'checked' => $preloadImages,])
                                                    <span :class="preloadImagesOn">@{{ preloadImagesOn }}</span>
                                                </li>

                                                <li class="seoparam-item">
                                                    @include('front.includes.formulario.Checkbox',['input' => "atrasoAmp",'ref' => 'atrasoAmp','vmodel' => 'atrasoAmp','label' => 'OnOFF Não trazer imagens acima da dobra em AMP page (apenas moblie)','value' => $atrasoAmp,'checked' => $atrasoAmp,])
                                                    <span :class="atrasoAmpOn">@{{ atrasoAmpOn }}</span>
                                                </li>

                                                <li class="seoparam-item">
                                                    @include('front.includes.formulario.Checkbox',['input' => "preloadFonte",'ref' => 'preloadFonte','vmodel' => 'preloadFonte','label' => 'Ocultar WebFont - Fonte padrão do Sistema','value' => $preloadFonte,'checked' => $preloadFonte,])
                                                    <span :class="preloadFonteOn">@{{ preloadFonteOn }}</span>
                                                </li>
                                           
                                                <li class="seoparam-item">
                                                    @include('front.includes.formulario.Input',['input' => "imagemforte",'ref' => 'imagemforte','label' => 'Coloque aqui o ID da frase Mais Forte:','value' => $imagemforte])
                                                </li>
                                                
                                                {{-- <li class="seoparam-item">
                                                    @include('front.includes.formulario.Checkbox',['input' => "imagemResponsivaAll",'ref' => 'imagemResponsivaAll','vmodel' => 'imagemResponsivaAll','label' => 'OnOFF Técnica de imagem responsiva','value' => $imagemResponsivaAll,'checked' => $imagemResponsivaAll,])
                                                    <span :class="imagemResponsivaAllOn">@{{ imagemResponsivaAllOn }}</span>
                                                </li> --}}
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
                                    {{-- titulo --}}
                                    <section class="field">
                                        {{-- <header>                                        
                                        <p class="aproximar"><br></p>
                                    </header> --}}
                                        <div class="row">
                                            @include(
                                                'front.includes.formulario.Input',
                                                [
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
                                                ]
                                            )
                                        </div>
                                    </section>

                                       {{-- introcucao --}}
                                       <section class="field">

                                        <div class="row">
                                            @include(
                                                'front.includes.formulario.Textarea',
                                                [
                                                    'input' => 'introducao',
                                                    'label' => 'INTRODUÇÃO inicial da página (padrão MARKDOWN)',
                                                    'class' => 'introducao',
                                                    'ref' => 'introducao',
                                                    'vmodel' => 'introducao',
                                                    'old' => old('introducao'),
                                                    'value' => $post->introducao,
                                                    'class' => 'introducao',
                                                    'placeholder' =>
                                                        'Caso queira, digite uma boa introdução para a página. Aquele texto que o usuário vai ler de início',
                                                    'ajuda' => '#h1, ##h2, *italico*, **negrito**',
                                                    'width' => '100%',
                                                    'cols' => '5',
                                                    'rows' => '15',
                                                    // 'V_SIZE' => '3050',
                                                ]
                                            )
                                        </div>
                                        <img src="/images/default/help_markdown-v04.svg" alt="">
                                    </section>


                                    {{-- resumo --}}
                                    <section class="field">
                                        <div class="row">
                                            @include(
                                                'front.includes.formulario.Textarea',
                                                [
                                                    'input' => 'resumo',
                                                    'label' => 'Resumo para SEO (texto para o google search)',
                                                    'class' => 'resumo',
                                                    'ref' => 'resumo',
                                                    'vmodel' => 'resumo',
                                                    'old' => old('resumo'),
                                                    'value' => $resumo,
                                                    'class' => 'resumo',
                                                    'placeholder' =>
                                                        'Um bom resumo, faz toda a diferença...',
                                                    'requerid' => 'requerid',
                                                    'ajuda' => 'Mínimo 110, máximo 240. Texto descrição que aparece na pesquisa do google',
                                                    'width' => '100%',
                                                    'cols' => '5',
                                                    'rows' => '3',
                                                    'V_SIZE' => '240',
                                                ]
                                            )
                                        </div>
                                    </section>                                 
                                    {{-- corpo --}}
                                    @if ($tipo == '3')
                                        <section class="field">
                                            <div class="row">
                                                @include(
                                                    'front.includes.formulario.Textarea',
                                                    [
                                                        'input' => 'corpo',
                                                        'label' => 'Corpo',
                                                        'class' => 'corpo',
                                                        'ref' => 'corpo',
                                                
                                                        'old' => old('corpo'),
                                                        'value' => $corpo,
                                                        'class' => 'corpo',
                                                        'placeholder' =>
                                                            'Um bom corpo, faz toda a diferença...',
                                                        'requerid' => 'requerid',
                                                        'ajuda' => 'Mínimo 110, máximo 240',
                                                        'width' => '100%',
                                                        'cols' => '5',
                                                        'rows' => '40',
                                                        'V_SIZE' => '240',
                                                    ]
                                                )

                                            </div>
                                        </section>
                                    @endif

                                    {{-- url amigável --}}

                                    <section class="field">
                                        <div class="row">
                                            @include(
                                                'front.includes.formulario.Input',
                                                [
                                                    'input' => 'urlamigavel',
                                                    'label' => 'Slug',
                                                    'old' => old('urlamigavel'),
                                                    'inputCol' => 'col-lg-10 urlamigavel',
                                                    'class' => 'urlamigavel',
                                                    'ref' => 'urlamigavel',
                                                    'vmodel' => 'urlamigavel',
                                                    'value' => $urlamigavel,
                                                    'class' => 'urlamigavel',
                                                    'requerid' => 'requerid',
                                                ]
                                            )

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
                                                            Alt das imagens das frases que pertencerão a esta lista. Além do
                                                            nome do arquivo.
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>

                                            <div class=" col-lg-10 field-input">
                                                <span class="preview"
                                                    style="display:block;padding: 8px;background: #fbf9f9;width: auto;">
                                                    Ps: <u>Não esqueça de Salvar antes de ajustar!</u>
                                                </span>
                                                <input ref="ref_alt" type="hidden" value="{{ $alt }}">
                                                <input type="text" id="alt" name="alt" placeholder="" v-model.lazy="alt"
                                                    class="fadeIn second alt">
                                                <div class="preview" {{-- v-text="altPreview" --}} ref="altPreview"
                                                    id="preview-alt"
                                                    style="display:block;padding: 8px;background:#90b7b714;width: auto;color:#646262">
                                                    @{{ altPreview }}
                                                </div>

                                                <a class="btn-sucess" href="#ajustar-nome-das-imagens"
                                                    style="background:#fdc803;padding: .7em 25px; display: block;width: 310px;border-radius: 5px;">
                                                    <span class="icon-zynga" style="color:#1a2037"> Go to: ajustar nome
                                                        e alt das imagens
                                                </a>

                                            </div>
                                    </section>

                                    <hr>


                                    

                                    {{-- Mostrar na Index --}}
                                    <section class="field">
                                        <div class="row">
                                            <div class="col-lg-2 label-area ">
                                                <label for="">
                                                    Visualizar?
                                                </label>
                                            </div>
                                            <div class=" col-lg-10 field-input">
                                                @include(
                                                    'front.includes.formulario.Checkbox',
                                                    [
                                                        'input' => 'mostrarNaIndex',
                                                        'ref' => 'mostrarNaIndex',
                                                        'vmodel' => 'mostrarNaIndex',
                                                        'label' => 'Mostrar na Index',
                                                        'value' => '1',
                                                        'checked' => 'true',
                                                    ]
                                                )
                                            </div>
                                        </div>
                                    </section>


                                    {{-- status --}}
                                    <section class="field">
                                        <div class="row">
                                            <div class="col-lg-2 label-area ">
                                                <label for="">
                                                    Status
                                                </label>
                                            </div>
                                            <div class=" col-lg-10 field-input">
                                                @include(
                                                    'front.includes.formulario.Radio',
                                                    [
                                                        'input' => 'status',
                                                        'label' => 'Em edição',
                                                        'value' => '0',
                                                        'checked' => $status == '0' ? 'true' : 'false',
                                                    ]
                                                )
                                                @include(
                                                    'front.includes.formulario.Radio',
                                                    [
                                                        'input' => 'status',
                                                        'label' => 'Publicado',
                                                        'value' => '1',
                                                        'checked' => $status == '1' ? 'true' : 'false',
                                                    ]
                                                )
                                                @include(
                                                    'front.includes.formulario.Radio',
                                                    [
                                                        'input' => 'status',
                                                        'label' => 'Rascunho',
                                                        'value' => '2',
                                                        'checked' => $status == '2' ? 'true' : 'false',
                                                    ]
                                                )
                                            </div>
                                        </div>
                                    </section>


                                    {{-- Tipo --}}
                                    <section class="field">
                                        <div class="row">
                                            <div class="col-lg-2 label-area ">
                                                <label for="">
                                                    Tipo
                                                </label>
                                            </div>
                                            <div class=" col-lg-10 field-input">
                                                <input type="radio" id="frases" name="tipo_post" value="1"
                                                    @if ($tipo == '1') checked @endif>
                                                <label for="frases">Frases</label><br>
                                                <input type="radio" id="publicacao" name="tipo_post" value="2"
                                                    @if ($tipo == '2') checked @endif>
                                                <label for="publicacao">Publicação</label><br>
                                                <input type="radio" id="inst" name="tipo_post" value="3"
                                                    @if ($tipo == '3') checked @endif>
                                                <label for="inst">Institucionais</label>
                                                <input type="radio" id="antigo" name="tipo_post" value="4"
                                                    @if ($tipo == '4') checked @endif>
                                                <label for="antigo">Modelo antigo</label>
                                            </div>
                                        </div>
                                    </section>
                                    {{-- imprimir a capa? --}}
                                    <section class="field">

                                        <div class="row">
                                            <div class="col-lg-2 label-area ">
                                                <label for="">
                                                    Imprimir a capa?
                                                </label>
                                            </div>
                                            <div class=" col-lg-10 field-input">
                                                @include(
                                                    'front.includes.formulario.Radio',
                                                    [
                                                        'input' => 'imprime_capa',
                                                        'label' => 'Sim, imprimir a capa',
                                                        'value' => '1',
                                                        'checked' => $imprime_capa == '1' ? 'true' : 'false',
                                                    ]
                                                )
                                                @include(
                                                    'front.includes.formulario.Radio',
                                                    [
                                                        'input' => 'imprime_capa',
                                                        'label' => 'Não imprimir a capa',
                                                        'value' => '0',
                                                        'checked' => $imprime_capa == '0' ? 'true' : 'false',
                                                    ]
                                                )
                                            </div>
                                        </div>
                                        <hr><hr><hr><hr><hr><hr><hr><hr>
                                    </section>
                                    

                                    {{-- capa --}}
                                    <section class="field field-preview-listas">
                                        <header>
                                            <h2>1) Capa principal (full):</h2>
                                            <span>ps: todas as imagens de capa podem ser geradas automaticamente pela PiedPiper mais abaixo na tela..</span>
                                            <p>Dimensões; 853 x 265 @if ($unsplashIdFotoAtual)
                                                    - Unsplash:<strong>{{ $unsplashIdFotoAtual }}</strong>
                                                @endif
                                            </p>
                                        </header>
                                        <div class="preview-imagem container" ref="preview">
                                            <div v-show="mostraCapa">
                                                <div class="display">Preview: </div>
                                                <div class="row">
                                                    <div class="col-lg-12 preview-listas">
                                                        {{-- aqui --}}
                                                        <div class="row wrapper-image-cropjs" style="width: 853px;" v-show="mostraCropZone">
                                                            <div style="width: 100%;margin: 0 auto;">
                                                                <clipper-fixed :round="false" :area="100"
                                                                    :ratio="16 / 5.3" bg-color="black"
                                                                    {{-- :bg-color="0" --}}
                                                                    style="width:100%;background: black; height:265px;"
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
                                                                    class="preview-imagem-result squad" alt="sem resultado">
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="crop_buttons_zone">
                                                                    <clipper-upload v-model="src" class="btn crop-button ">
                                                                        Buscar outra Imagem</clipper-upload>
                                                                    <button
                                                                        class="save save-branco submit bt-center callAction"
                                                                        @click.stop.prevent="cortar">Cortar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="area-da-capa">
                                                            <div class="background-capa post" v-show="!mostraCropZone"
                                                                v-bind:data="imgSrc"
                                                                v-bind:style="{ backgroundImage: 'url(' + imgSrc + ')' }">
                                                                @if (isset($imgSrc))
                                                                    <img ref="imgSrc" src="{{ $imgSrc }}"
                                                                        data-src="{{ $imgSrc }}"
                                                                        class="capa avatar form" alt="capa">
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <capa opcoes="{{ $options }}"></capa>

                                                        @include(
                                                            'front.includes.formulario.Hidden',
                                                            [
                                                                'input' => 'unsplashIdFotoAtual',
                                                                'value' => $unsplashIdFotoAtual,
                                                                'vmodel' => 'unsplashIdFotoAtual', //'vmodel'=>'avatar_icone'
                                                            ]
                                                        )
                                                        @include(
                                                            'front.includes.formulario.Hidden',
                                                            [
                                                                'input' => 'capa',
                                                                'value' => $imgSrc,
                                                                'vmodel' => 'capa', //'vmodel'=>'avatar_icone'
                                                            ]
                                                        )

                                                        @include(
                                                            'front.includes.formulario.Hidden',
                                                            [
                                                                'input' => 'midia_id',
                                                                'value' => $midiaId, //$usuario->avatar_icone_id
                                                            ]
                                                        )
                                                        @include(
                                                            'front.includes.formulario.Hidden',
                                                            [
                                                                'input' => 'unsplashVar',
                                                                'vmodel' => 'unsplashVar',
                                                            ]
                                                        )
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <section class="field">
                                        <div class="row">
                                            @include(
                                                'front.includes.formulario.Input',
                                                [
                                                    'input' => 'autorName',
                                                    'label' => 'Nome do Autor Capa',
                                                    'old' => old('autorName'),
                                                    'inputCol' => 'col-lg-10 autorName',
                                                    'class' => 'autorName',
                                                    'ref' => 'autorName',
                                                    'value' => $autorName,
                                                    'class' => 'autorName',
                                                ]
                                            )
                                        </div>
                                    </section>
                                    <section class="field">
                                        <div class="row">
                                            @include(
                                                'front.includes.formulario.Input',
                                                [
                                                    'input' => 'autorLink',
                                                    'label' => 'Link Autor Capa',
                                                    'old' => old('autorLink'),
                                                    'inputCol' => 'col-lg-10 autorLink',
                                                    'class' => 'autorLink',
                                                    'ref' => 'autorLink',
                                                    'value' => $autorLink,
                                                    'class' => 'autorLink',
                                                ]
                                            )
                                        </div>
                                        <hr><hr><hr><hr><hr><hr><hr><hr>
                                    </section>

                                    {{-- Mobile --}}
                                    <section class="field">
                                        <div class="row">
                                            <div class="col-lg-12 label-area ">
                                                <header>
                                                    <h2>2) Capa Mobile</h2>
                                                    <p>Dimensões; 416 x 203 
                                                    </p>
                                                </header>
                                            </div>
                                            <div class=" col-lg-12 field">
                                                <div class="background-mobile row" v-bind:data="mobile"
                                                    v-bind:style="{ backgroundImage: 'url(' + mobile + ')' }">
                                                    @if (isset($imgSrc))
                                                        <img ref="thumb" src="{{ $mobile }}" class="capa capa-thumb"
                                                            alt="capa">
                                                    @endif
                                                </div>
                                                <mobile opcoes="{{ $options }}"></mobile>
                                                @include(
                                                    'front.includes.formulario.Hidden',
                                                    [
                                                        'input' => 'mobile',
                                                        'value' => $mobile,
                                                        'vmodel' => 'mobile',
                                                        'ref' => 'mobile',
                                                    ]
                                                )
                                                <div class="col-lg-12 linhas">
                                                    <div class="row-linhas">
                                                        <a href="{{ route('posts_cortarthumb', $idTabela) }}"
                                                            class="botao-padrao "> Mônica: Cortar Mobile imagem Automaticamente 
                                                        </a>
                                                        <span>A Mônica vai gerar um Mobile automáticamente nas seguintes dimensões: w: 416 x h: 203, pegando como ponto base o centro da imagem de capa. </span>
                                                    </div>
                                                </div>

                                                @if (!$unsplashIdFotoAtual)
                                                    <div class="col-lg-12 linhas">
                                                        <div class="row-linhas">
                                                            <a href="#" class="botao-padrao ">Cortar Mobile Manualmente </a>
                                                            <span>Ou você pode cortar Manualmente o Mobile, com base na capa.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 field">
                                                        <div class="background-mobile row" style="width: 416px;" >
                                                            <clipper-fixed :round="false" :area="100"
                                                                :ratio="1 / 1" bg-color="black"
                                                                {{-- :bg-color="0" --}} style="width:100%;background: black; height:203px;"
                                                                :src="src" ref="clipper_thumb">
                                                                <div slot="placeholder">
                                                                    Please upload image
                                                                </div>
                                                            </clipper-fixed>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="crop_buttons_zone">
                                                                <button
                                                                    class="save save-branco submit bt-center callAction"
                                                                    @click.stop.prevent="cortarThumb">Cortar Mobile Imagem</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                        <hr><hr><hr><hr><hr><hr><hr><hr>
                                    </section>

                                    {{-- thumbnail --}}
                                    <section class="field">
                                        <div class="row">
                                            <div class="col-lg-12 label-area ">
                                                <header>
                                                    <h2>3) Capa Thumbnail</h2>
                                                    <p>Dimensões; 191 x 130 @if ($unsplashIdFotoAtualThumb)
                                                            - Unsplash:<strong>{{ $unsplashIdFotoAtualThumb }}</strong>
                                                        @endif
                                                    </p>
                                                    </p>
                                                </header>
                                            </div>
                                            <div class=" col-lg-12 field">
                                                <div class="background-thumb row" v-bind:data="thumb"
                                                    v-bind:style="{ backgroundImage: 'url(' + thumb + ')' }">
                                                    @if (isset($imgSrc))
                                                        <img ref="thumb" src="{{ $thumb }}" class="capa capa-thumb"
                                                            alt="capa">
                                                    @endif
                                                </div>
                                                <thumb opcoes="{{ $options }}"></thumb>
                                                @include(
                                                    'front.includes.formulario.Hidden',
                                                    [
                                                        'input' => 'thumb',
                                                        'value' => $thumb,
                                                        'vmodel' => 'thumb',
                                                        'ref' => 'thumb',
                                                    ]
                                                )
                                                @include(
                                                    'front.includes.formulario.Hidden',
                                                    [
                                                        'input' => 'unsplashIdFotoAtualThumb',
                                                        'value' => $unsplashIdFotoAtualThumb,
                                                        'vmodel' => 'unsplashIdFotoAtualThumb',
                                                    ]
                                                )
                                            </div>
                                        </div>
                                    </section>
                                            {{-- piedpiper --}}
                                            <section class="field field-preview-listas" id="piedpiper" >
                                                <hr><hr><hr><hr><hr><hr><hr><hr>
                                                <header>
                                                    @php
                                                        $vaction = 'pied_piper' . $idTabela;
                                                        $pergunta = 'Executar o Filho de Aton da PiedPiper?';
                                                        $aviso = 'confirma info';
                                                    @endphp
                                                    
                                                    <h2 style="text-align: center">PiedPiper</h2>
                                                    <marquee behavior="" direction="">Executar o sistema de compressão e cortes da PiedPiper - Muito 1996 isso</marquee>
                                                    <img style="text-align: center; margin: 0px auto 30px auto; display: block" src="{{asset("/storage/images/piedpiper.jpg") }}" alt="">
                                                    <p>O algorítimo de compressão da <b>PiedPiper</b> vai gerar e compactar as seguintes imagens:</p>
                                                    <p>Capa: 853 X 265:  capa.webp</p>
                                                    <p>Mobile: 416 X 203: mobile.webp</p>
                                                    <p>Thumb: 191 X 130: thumb.webp</p>
                                                    Lembrando que o PiedPiper vai rodar apenas para capa da LISTA, não vai mecher nas capa das frases.
        
                                                    <a href=""
                                                        v-on:click="getConfirm('{{ $vaction }}', $event, '{{ $pergunta ?? 'Confirma esta operação:?' }}', '{{ $aviso ?? 'atencao' }}')"
                                                        class="botao-padrao full bt-centerbtn botao-padrao green full mt-20 mb-40" title="PiedPiper">
                                                        run (chora Hooli)
                                                    </a>
                                                </header>
                                                <hr><hr><hr><hr><hr><hr><hr><hr>
                                            </section>

                                    {{-- categoria --}}
                                    <section class="field">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    @include(
                                                        'front.includes.formulario.Select',
                                                        [
                                                            'input' => 'categoria_id',
                                                            'value' => $categoria_id,
                                                            'class' => 'w',
                                                            'old' => old('categoria_id'),
                                                            'ref' => 'categoria_id',
                                                            'vmodel' => 'categoria_id',
                                                            'align' => 'right',
                                                            'dados' => $categoria_Dados,
                                                            'inputCol' => 'col-lg-12',
                                                        ]
                                                    )
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    {{-- campos ocultos REVER --}}
                                    <div class="campos-ocultos">

                                        @include(
                                            'front.includes.formulario.Hidden',
                                            [
                                                'input' => 'idDoPost',
                                                'value' => $idTabela,
                                                'vmodel' => 'idDoPost',
                                                'ref' => 'idDoPost',
                                            ]
                                        )
                                        @include(
                                            'front.includes.formulario.Hidden',
                                            ['input' => 'usuario_id', 'value' => $logado->id]
                                        )
                                        @include(
                                            'front.includes.formulario.Hidden',
                                            ['input' => 'conteudo', 'value' => 'rever conteúdo']
                                        )


                                    </div>

                                    {{-- aqui form --}}
                                    {{-- endMagic --}}
                                </div>
                                {{-- segunda parte --}}

                                <div class="row">
                                    <div class="col-lg-12">
                                        <ul class="tools">
                                            <li>
                                                <a
                                                class="botao-padrao "
                                                href="{{ route('post.edit', $idTabela . '?action=conferir_faltando#conferir_faltando') }}">
                                                Ver se tem frases duplicadas
                                                </a>  
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <ul class="toolss">
                                            @foreach ($itens as $item)
                                                
                                                @php
                                                    $booljpg = false;
                                                    $boolreprovada = false;
                                                    $capaJPG = $item->capa;
                                                    $auxwebp = explode(".jpg",$capaJPG);
                                                    if(isset($auxwebp[1])) 
                                                        $booljpg = true;
                                                    $status = $item->status;
                                                    if($status != "1"){
                                                        $status = " REPROVADA";
                                                        $boolreprovada = true;
                                                    }
                                                    else $status = "";



                                                @endphp


                                                @if (($boolreprovada) )

                                                    @php
                                                        $temWidth = false;
                                                        $width = "zero";
                                                        $arrImagem = @getimagesize(env('APP_URL').$item->capa) ?? getimagesize(env('APP_URL').$item->capa) ? getimagesize(env('APP_URL').$item->capa) : [];
                                                        if(isset($arrImagem[0])) {
                                                            $width="$arrImagem[0]px";
                                                            $temWidth=true;        
                                                        }
                                                        if(isset($arrImagem[1])) {
                                                            $height="$arrImagem[1]px";
                                                            $temHeight=true;
                                                        } 
                                                    @endphp
                                                    <li>
                                                        Status: não indexada: FraseiD | <a href="/frases/edit/{{ $item->frase_id }}" target="blanck">{{ $item->frase_id }}</a> | 
                                                        @if( $width = "zero")
                                                            ATENÇÃO: IMAGEM DA FRASE NÃO EXISTE |     
                                                        @endif 
                                                        Vai dar problema ao Rodar o PipiF<br>
                                                    </li>
                                                @else

                                                    @if (($item->nomeDownload == "" && $item->frase_id != "1" && ! $booljpg) )
                                                                
                                                        <li>
                                                            -----> APENAS JPEG PENDENTE: FraseiD | <a href="/frases/edit/{{ $item->frase_id }}" target="blanck">{{ $item->frase_id }}</a> | {{ $item->capa }} - {{ $status }}<br>
                                                        </li>
                                                    @endif

                                                @endif
                                            
                                                
                                            @endforeach
                                            <br>
                                            <br>
                                        </ul>
                                    </div>
                                </div>
                                <div class="content-wrapper frases pai">
                                    {{-- Corpo do post --}}
                                    <header>
                                        <h2 id="frases-da-lista">
                                            <i class="icon icon-007-copy title"></i>
                                            Frases da Lista
                                        </h2>   
                                    </header>
                                    <section>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h3>Edite as frases de sua Lista</h3>
                                                <h6>Conferência: {{ $nfrases }} Frases + {{ $nAnchors }}+
                                                    Anchors(s) + {{ $nAnuncios }} + Anuncio(s) + {{ $nConvites }}
                                                    Convite(s) =
                                                    <strong>{{ $nfrases + $nAnuncios + $nConvites + $nAnchors }}</strong>
                                                </h6>
                                            </div>
                                        </div>
                                        @if ($actionParam == 'conferir_faltando')
                                            <div class="row" id="conferir_faltando">
                                                <div class="col-lg-12">
                                                    <h3>Relatório do modelo antigo - {{ count($arrayStringCorpo) }} Frases
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="row" id="conferir_faltando">
                                                <div class="col-lg-12">
                                                    <table class="table table-hover">

                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Ordem</th>
                                                                <th scope="col">Frase:id</th>
                                                                <th scope="col">Frase</th>
                                                                <th scope="col">Presente?</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach ($arrayStringCorpo as $item)
                                                                @php $ordenConf++;@endphp
                                                                <tr>
                                                                    <td>
                                                                        {{ $ordenConf }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $item['frase_id'] }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $item['frase'] }}
                                                                    </td>
                                                                    <td>
                                                                        @if ($item['presente'] == 'CAD')
                                                                            <span
                                                                                style="padding: 5px;background: #f36405cc;color: #fff;">JáCadastrada</span>
                                                                        @endif
                                                                        @if ($item['presente'] == 'DTXT')
                                                                            <span
                                                                                style="padding: 5px;background: #1e5ac9;color: #fff;">Duplicado</span>
                                                                        @endif
                                                                        @if ($item['presente'] == 'false')
                                                                            <span
                                                                                style="padding: 5px;background: #c9291e;color: #fff;">Não</span>
                                                                        @endif
                                                                        @if ($item['presente'] == 'true')
                                                                            <span class="publicado">Sim</span>
                                                                        @endif
                                                                        @if ($item['presente'] == 'NA')
                                                                            <span
                                                                                style="padding: 5px;background: #d016d6;color: #fff;">NA</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                    </table>

                                                </div>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col">

                                                {{-- @include('front.includes.formulario.Hidden', [
                                                'input'         => 'corpo',                                                                                                
                                                'ref'           => 'corpo', 
                                                'vmodel'        => 'corpo',                                                
                                                'value'         =>  $corpo ,                                                                                        
                                            ]) --}}
                                        
                                                <posts_itens opcoes="{{ $options }}" itens="{{ $itens }}"
                                                    idDoPost="{{ $idTabela }}" v-model="itens" />


                                                {{-- <editor 
                                            opcoes="{{$options}}"
                                            itens="{{$corpo}}"
                                            idDoPost="{{($idTabela)}}"
                                            v-model="corpo"/> --}}
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
                                                @include(
                                                    'front.includes.formulario.Hidden',
                                                    [
                                                        'input' => 'tags',
                                                        'label' => 'Tags',
                                                        'class' => 'tags',
                                                        'ref' => 'tags',
                                                        'vmodel' => 'tags',
                                                        'ajuda' => 'Separe com vírgulas',
                                                        'value' => $tags,
                                                        'class' => 'tags',
                                                    ]
                                                )
                                            </div>
                                        </div>
                                    </section>



                                    {{-- Posts Relacionados --}}
                                    <section>
                                        <div class="row">
                                            <div class="col">
                                                <posts-rel opcoes="{{ $options }}" idDoPost="{{ $idTabela }}"
                                                    postrel="{{ $postrel }}"></posts-rel>
                                            </div>
                                        </div>
                                    </section>




                                    {{-- Autor do Post --}}
                                    <section class="field">
                                        <div class="row">
                                            @include(
                                                'front.includes.formulario.Input',
                                                [
                                                    'input' => 'autor_id',
                                                    'label' => 'Autor ID',
                                                    'inputCol' => 'col-lg-10 autor',
                                                    'old' => old('autor_id'),
                                                    'class' => 'autor',
                                                    'ref' => 'autor_id',
                                                    'value' => $autor_id,
                                                    'placeholder' => 'Autor do Post',
                                                ]
                                            )
                                        </div>
                                    </section>

                                    {{-- Texto do Fim --}}
                                    <section class="field">
                                        <div class="row">
                                            @include(
                                                'front.includes.formulario.Input',
                                                [
                                                    'input' => 'aux_1',
                                                    'label' => 'Texto do Fim',
                                                    'class' => 'texto_do_fim',
                                                    'inputCol' => 'col-lg-10 aux_1',
                                                    'old' => old('aux_1'),
                                                    'ref' => 'aux_1',
                                                    'value' => $aux_1,
                                                    'placeholder' => 'Texto do fim',
                                                ]
                                            )
                                        </div>
                                    </section>

                                    {{-- FIM  Botões de ação --}}
                                    <section class="field">
                                        <div class="row">
                                            <div class="col-md-12 center center-100 zona-bt-rascunho">
                                                @include(
                                                    'front.includes.formulario.Btsalvar',
                                                    [
                                                        'rota' => 'post.update',
                                                        'id' => $idTabela,
                                                        'class' => 'rascunho',
                                                        'vaction' => 'enviarParaRascunho',
                                                        'icone' => 'save',
                                                        'label' => 'Salvar',
                                                        'tip' => 'Salvar alterações',
                                                    ]
                                                )
                                            </div>
                                            @if ($idTabela > 0)
                                                {{-- <div class="col-md-6 float-left  zona-bt-enviar-lista ">
                                                @include('front.includes.formulario.Btsalvar',[                
                                                    'rota'    => 'post.update',
                                                    'id'      =>  $idTabela,  
                                                    'class'   => 'callAction',
                                                    'vaction' => 'publicar',
                                                    
                                                    'aviso'   => 'confirma info',
                                                    'pergunta'  => 'Deseja Publicar o post?',
                                                    'lbconfirma' => 'Publicar',                                                
                                                    'icone'   => 'enviar',                                                    
                                                    'label'   => 'Publicar',
                                                    'tip'     => 'Publicar posts'
                                                ])
                                            </div> --}}
                                            @endif
                                        </div>
                                    </section>
                                </div>
                            </form>

                            {{-- Excluir Lista --}}
                            @if ($idTabela)
                                {{-- Duplicadas no post --}}
                                <div class="content-wrapper">
                                    <header>
                                        <h2>
                                            <i class="icon favorito" style="margin:1px 18px 0px 0px;"></i>
                                            Fareijar frases Duplicadas por aqui!
                                        </h2>
                                    </header>
                                    <section>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h3>Buscar e deletar frases duplicadas apenas dentro deste POST (lista).
                                                </h3>
                                                <p>Deixar a primeira frase e eliminar as demais frases que foram duplicadas
                                                </p>
                                                <p>PS: Ao eliminar alguma frase, REajustar a ordenação da lista </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <form class="form-box"
                                                    action="{{ route('marlon.duplicadasnopost', $idTabela) }}"
                                                    method="GET">
                                                    {{ csrf_field() }}
                                                    @method('PUT')
                                                    <button style="background: rgb(115, 39, 177);">
                                                        <span class="icon-zynga" style="color:#fff"> Fareijar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </section>
                                </div>

                                {{-- PRE-analise do POST --}}
                                <div class="content-wrapper">
                                    <header>
                                        <h2>
                                            <i class="icon favorito" style="margin:1px 18px 0px 0px;"></i>
                                            Pré-análise das Frases
                                        </h2>
                                    </header>
                                    <section>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h3>Analisar e validar todas as frases deste POST que estão com o Status
                                                    "Pré-análise".</h3>
                                                <p>As que estiverem ok, vão ser setadas com o Status <span
                                                        class="publicado">
                                                        Google
                                                    </span></p>
                                                <p>
                                                    PS: Este processo é apenas para as frases desta LISTA (post)...
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <form class="form-box"
                                                    action="{{ route('marlon.preanalisepost', $idTabela) }}" method="GET">
                                                    {{ csrf_field() }}
                                                    @method('PUT')
                                                    <button>
                                                        <span class="icon-zynga" style="color:#fff"> Fareijar para este
                                                            Post
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </section>
                                </div>

                                <div class="content-wrapper">
                                    <header>
                                        <h2>
                                            <i class="icon favorito" style="margin:1px 18px 0px 0px;"></i>
                                            Replicar a Nuvem de Tags
                                        </h2>
                                    </header>
                                    <section>
                                        <div class="col-lg-12">
                                            <h3>Replicar as mesmas tags para todas as Frases deste POST.</h3>

                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <form class="form-box"
                                                    action="{{ route('marlon.criartagfrases', $idTabela) }}" method="GET">
                                                    {{ csrf_field() }}
                                                    @method('PUT')
                                                    <button class="btn-sucess" style="background:#3490dc">
                                                        <span class="icon-zynga" style="color:#fff"> Aplicar as Tags do
                                                            post á todas as Frases
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </section>
                                </div>

                                
                                {{-- REGERAR IMAGE --}}
                                <div class="content-wrapper" id="pipif">
                                    <header>
                                        <hr>
                                        <hr>
                                        <hr>
                                        <hr>
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
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <h2 style="margin-top: 7px;">Tipo de Fundo:</h2>
                                            </div>
                                            <div class="col-lg-12">
                                                @php
                                                    $vaction = 'post_pipif' . $idTabela;
                                                    $pergunta = 'Executar PipiF para todas as Frases desta Lista? Isto pode demorar um pouco';
                                                    $aviso = 'confirma info';
                                                @endphp
                                                <form ref="post_pipif{{ $idTabela }}" class="form-box"
                                                    action="{{ route('post.pipif') }}"
                                                    method="post">
                                                    {{ csrf_field() }}
                                                    @include(
                                                        'front.includes.formulario.Hidden',
                                                        ['input' => 'id', 'value' => $idTabela]
                                                    )

                                                    <div class="formregerar">

                                                        <ul class="pasta">
                                                            <li>
                                                                <div class="col"><h3>Pasta quando for uma imagem (612x612)</h3></div>
                                                                <div class="col">
                                                                    <select name="pasta_bg" id="pasta_bg">
                                                                        <option  value="pensativo" selected>Pensativo</option>
                                                                        <option  value="amor">Amor</option>
                                                                        <option  value="aniver">Aniver</option>
                                                                        <option  value="deus">Deus</option>
                                                                        <option  value="denoite">The Noite</option>
                                                                        <option  value="familia">Familia</option>
                                                                        <option  value="feminino">Feminino</option>
                                                                        <option  value="friends">Friends</option>
                                                                        <option  value="girls">Girls</option>
                                                                        <option  value="motivacao">Motivação</option>
                                                                        <option  value="sad">Sad</option>
                                                                        <option  value="pets">Pets</option>
                                                                        <option  value="manha">Manhã</option>
                                                                    </select>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="col"><h3>Pasta quando fundo for cor Chapada</h3></div>
                                                                <div class="col">
                                                                    <select name="pasta_chapado" id="pasta_chapado">
                                                                        <option selected value="cororido">cororido</option>
                                                                        <option value="preto">preto</option>
                                                                    </select>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="col">Qualidade %</div>
                                                                <div class="col"><input type="number" name="qualidade" id="qualidade" value="100">
                                                                </div>
                                                            </li>
                                                            <li>
                                                                @include(
                                                                    'front.includes.formulario.Checkbox',
                                                                    [
                                                                        'input' => "padraochapado",
                                                                        'ref'   => 'padraochapado',
                                                                        'label' => 'Rodar todas as frases como Padrão Chapado',
                                                                        'value' => 'padraochapado',
                                                                        'checked' => false
                                                                    ]
                                                                )
                                                                <br><br><br>
                                                            </li> 


                                                        </ul>
                                                        <a href=""
                                                            v-on:click="getConfirm('{{ $vaction }}', $event, '{{ $pergunta ?? 'Confirma esta operação:?' }}', '{{ $aviso ?? 'atencao' }}')"
                                                            class="bt-rosa"
                                                            style="background: #e52134; color:#fff;padding:18px 68px;display:block;float:left;"
                                                            title="Regerar IMGS">
                                                            START!!!!!
                                                        </a>

                                                    </div>
                                                </form>
                                                
                                            </div>
                                        </div>
                                    </section>
                                </div>

                                <hr>
                                <hr>
                                <hr>
                                <hr>
                                <h2>

                                {{-- Novo padrão de imagens --}}
                                <div class="content-wrapper" id="pipif">
                                    <header>
                                        <hr>
                                        <hr>
                                        <hr>
                                        <hr>
                                        <h2>
                                            <span style="font-size: 86px;">📦</span>
                                            Novo padrão de imagens das Frases <span style="color: red; background: yellow">New!</span>
                                        </h2>
                                        <hr>
                                        <hr>
                                        <hr>
                                        <hr>
                                        <h2>
                                    </header>
                                    <section>
                                        <div class="row">
                                            
                                            <div class="col-lg-12">
                                                @php
                                                    $vaction = 'post_postPipifNovoPadraoImagens' . $idTabela;
                                                    $pergunta = 'Aplicar o novo padrão de nomenclatura para todas as Frases desta Lista? Isto pode demorar um pouco';
                                                    $aviso = 'confirma info';
                                                @endphp
                                                <form ref="post_postPipifNovoPadraoImagens{{ $idTabela }}" class="form-box"
                                                    action="{{ route('post.postPipifNovoPadraoImagens') }}"
                                                    method="post">
                                                    {{ csrf_field() }}
                                                    @include(
                                                        'front.includes.formulario.Hidden',
                                                        ['input' => 'id', 'value' => $idTabela]
                                                    )

                                                    <div class="formregerar">
                                                        <div class="col-lg-2 label-area ">
                                                            <label for="">
                                                                Gerar o novo padrão de nomenclatura das imagens para as frases desta lista,  Ex: frase-1201.jpg & frase-1201.webp 
                                                                <span class="ajuda">
                                                                    (?)
                                                                    <span class="texto-ajuda">
                                                                        Ex: frase-1201.jpg & frase-1201.webp 
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>

                                                        <ul class="pasta">
                                                            
                                                            
                                                            <li>
                                                                <div class="col">Qualidade dos jpg's %</div>
                                                                <div class="col"><input type="number" name="qualidade" id="qualidade" value="100">
                                                                </div>
                                                            </li>
                                                           


                                                        </ul>
                                                        <a href=""
                                                            v-on:click="getConfirm('{{ $vaction }}', $event, '{{ $pergunta ?? 'Confirma esta operação:?' }}', '{{ $aviso ?? 'atencao' }}')"
                                                            class="bt-rosa"
                                                            style="background: #2218b6; color:rgb(255, 255, 255);padding:18px 68px;display:block;float:left;"
                                                            title="Regerar IMGS">
                                                            Executar
                                                        </a>

                                                    </div>
                                                </form>
                                                
                                            </div>
                                        </div>
                                    </section>
                                </div>

                                <hr>
                                <hr>
                                <hr>
                                <hr>
                                <h2>

                                {{-- IMAGEM PARA DOWNLOAD EM JPG --}}
                                <div class="content-wrapper" id="pipif">
                                    <header>
                                        <hr>
                                        <hr>
                                        <hr>
                                        <hr>
                                        <h2>
                                            <span style="font-size: 86px;">📥</span>
                                            Criar imagem para download em JPG
                                        </h2>
                                        <hr>
                                        <hr>
                                        <hr>
                                        <hr>
                                        <h2>
                                    </header>
                                    <section>
                                        <div class="row">
                                            
                                            <div class="col-lg-12">
                                                @php
                                                    $vaction = 'post_postPipifgeraIMagemParaDownloadFromCopy' . $idTabela;
                                                    $pergunta = 'Executar PipiF para todas as Frases desta Lista? Isto pode demorar um pouco';
                                                    $aviso = 'confirma info';
                                                @endphp
                                                <form ref="post_postPipifgeraIMagemParaDownloadFromCopy{{ $idTabela }}" class="form-box"
                                                    action="{{ route('post.postPipifgeraIMagemParaDownloadFromCopy') }}"
                                                    method="post">
                                                    {{ csrf_field() }}
                                                    @include(
                                                        'front.includes.formulario.Hidden',
                                                        ['input' => 'id', 'value' => $idTabela]
                                                    )

                                                    <div class="formregerar">
                                                        <div class="col-lg-2 label-area ">
                                                            <label for="">
                                                                Gerar Imagem para Download em jpg para todas as frases desta lista
                                                                <span class="ajuda">
                                                                    (?)
                                                                    <span class="texto-ajuda">
                                                                        Nome da imagem para download em JPG.
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>

                                                        <ul class="pasta">
                                                            
                                                            
                                                            <li>
                                                                <div class="col">Qualidade dos jpg's %</div>
                                                                <div class="col"><input type="number" name="qualidade" id="qualidade" value="100">
                                                                </div>
                                                            </li>
                                                           


                                                        </ul>
                                                        <a href=""
                                                            v-on:click="getConfirm('{{ $vaction }}', $event, '{{ $pergunta ?? 'Confirma esta operação:?' }}', '{{ $aviso ?? 'atencao' }}')"
                                                            class="bt-rosa"
                                                            style="background: #6fe22c; color:#000;padding:18px 68px;display:block;float:left;"
                                                            title="Regerar IMGS">
                                                            GERAR JPG's!!!!!
                                                        </a>

                                                    </div>
                                                </form>
                                                
                                            </div>
                                        </div>
                                    </section>
                                </div>

                                <hr>
                                <hr>
                                <hr>
                                <hr>
                                <h2>
                                <div class="content-wrapper" id="ajustar-nome-das-imagens">
                                    <header>
                                        <h2>
                                            <i class="icon favorito" style="margin:1px 18px 0px 0px;"></i>
                                            Ajustar ALT & physycal_name
                                        </h2>
                                    </header>
                                    <section>
                                        <div class="col-lg-12">
                                            <h3>Renomer o physycal_name, além de aplicar o "ALT" para todas as Frases deste
                                                POST.</h3>
                                            <p>PS: O sistema <strong>só</strong> fará isso para as Frases desta lista.</p>
                                            <p> Para as frases presentes aqui, mas que estejam
                                                em outras listas também, o sistema só aplicará estas alterações <b>CASO</b>
                                                esta lista aqui seja a <strong>MANDATORY</strong> da frase.
                                            </p>
                                            <p>Geralmetne a lista <strong>Mandatory</strong> da frase, é aquela que a criou!
                                                (na aprovação) </p>
                                            <p>Para descobrir se a lista é ou não mandatory de uma frase, basta entrar no
                                                cadastro da frase.</p>
                                            <p><br></p>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <form class="form-box"
                                                    action="{{ route('marlon.ajustaralt', 'p;' . $idTabela) }}" action=""
                                                    method="GET">
                                                    {{ csrf_field() }}
                                                    @method('PUT')
                                                    <button class="btn-sucess" style="background:#fdc803">
                                                        <span class="icon-zynga" style="color:#1a2037"> Ajustar
                                                            physical_name e alt das imagens
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </section>
                                </div>

                                <div class="content-wrapper">
                                    <header>
                                        <h2>
                                            <i class="icon atention"></i>
                                            Excluir Post
                                        </h2>
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
                                                    action="{{ route('post.destroy', $idTabela) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    @method('DELETE')
                                                    @include(
                                                        'front.includes.formulario.Hidden',
                                                        ['input' => 'id', 'value' => $idTabela]
                                                    )

                                                    <a href=""
                                                        v-on:click="getConfirm('{{ $vaction }}', $event, '{{ $pergunta ?? 'Confirma esta operação:?' }}', '{{ $aviso ?? 'atencao' }}')"
                                                        class="botao-padrao full bt-center" title="Excluir">
                                                        Excluir
                                                    </a>
                                                </form>

                                            </div>
                                        </div>
                                    </section>
                                </div>
                            @endif
                            {{-- Fim exluir --}}
                    </div>
                </div>
            </div>
            <form ref="pied_piper{{ $idTabela }}" class="form-box"
                action="{{ route('post.piedpiper', $idTabela) }}" action=""
                method="POST">
                {{ csrf_field() }}
                @method('PUT')
                @include(
                    'front.includes.formulario.Hidden',
                    ['input' => 'id', 'value' => $idTabela]
                )
            </form>

            {{-- foter --}}
            @include('front.includes.Footer')
        </div>
    </div>
@endsection
@section('js-view')
    <script src="{{ asset('js/PostForm.js') }}?ver={{ env('VER') }}"></script>
@endsection
