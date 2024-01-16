@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: PostShow.blade.php
     * Autor: LM
     * Objetivo: Principal programa responsável por criar o HTML do front-end das bibliotecas. Ou seja,
     *           tudo que o google vai ver está aqui.
     * Doc: https://docs.google.com/document/d/1VtR-rXro8Ynn6VtnFfjcdXkTxhKjt6X_ERCgnhs6qv4/edit#heading=h.5o1vlm6c43sz
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *  ● Projeto2023Jan02 - Imagem com height 346px no cache do google
     *     >> 01-01-23 - Passar como false a variável mobile para a view do ítem
     *     >> 23-11-22 -  Funções para MarkDown
     * ● Projeto2023Jan10 - Melhorando o Webmaster Tools  - Tarefa: 1) Para celular ajustar problema de LCP: mais de 2,5s (dispositivos móveis)
     *     >> 26-01-23 - Remover tudo em relação a $lAtrasoAmp - não precisa atrasar imagens em páginas amp
     *     >> 26-01-23 - Remover a declaração da variável - $typeimage para testar se imagem era do unsplash - estava em desuso
     *     >> 26-01-23 - Remover a declaração da variável - $capa = $tabela->capa; não estava em uso
     *     >> 26-01-23 - Remover a tudo em relação ao serviço MarkDown da view - passei toda a lógica para a entidade
     *     >> 26-01-23 - Sempre vai ter lazy das imagens = ou seja, não precisa mais testar isso no seo param
     *                 - então, remover todos os testes de $lazy  das views
     *     >> 26-01-23 - Remover o momentolazy para a imagem inicial
     *     >> 26-01-23 - remover as Customizações css que estavam soltas na PostShow.blade.view     *
     *     >> 28-01-23 - Aplicar o label carregando... na imagem de capa de anchor  e a cor de fundo desta área para impacto visual    *
     *     >> 31-01-23 - definição de tamnhos para as imagens institucionais
     *     >> 01-02-23 - Reinserir a chamada para o Recaptcha, pois avia retirado sem querer
     *     >> 01-02-23 - retirado o teste do parâmetro global recaptcha, pois não estava sendo usado
     * ● Projeto2023Mar01 - Melhorando o CLS em Amp page
     *     >> 10-03-23 - Trazer o Opcoessingle apenas se não for página AMP
     *     >> 10-03-23 - Trazer o banner apenas se não for página AMP
     * ● Projeto2023May06 - Teste A/B de webfont
     *     >> 18-05-23 - Incluir o TesteAB referente a webfont. Trazer a webfont para algumas publicações como era antes
     *                   Vale lembrar que o padrão atual do sistema é trazer a webfont via JS, após o carregamento da página
     *                   As publicações são: 41 (86-frases-de-deus-para-status), 66 (46-frases-da-cora-coralina) e 10 (101-frases-do-augusto-cury) 
     *--------------------------------------------------------------------------------------------------------------*/
@endphp

@extends('template.Front', [
    'tabela' => $tabela ?? 'posts',
])
@section('css-view')
    @include('front.PostShow_Incorp.Assets', ['amp' => $amp])
@endsection

@section('custom-php')
    @php
        
        $customThema = $logado ? $logado->thema : '';
        $customClass = 'single-frase';
        $arrpastas = $logado ? $logado->pastas()->all() : [];
        $titulo = $tabela->titulo;
        $width = '853px';
        $height = '265px';
        $anuncios = $tabela->anuncios;
        $idpost = $tabela->id;
        $urlamigavel = $tabela->urlamigavel;
        $tags = $tabela->tags;
        $imgsrc = $tabela->getImagemCapaAttribute();
        $hasanchor = false;
        $arranchor = [];
        if ($tabela->tipo == '3') {
            $width = 'auto';
            $height = 'auto';
        }
        
        // /Projeto2023May06
        $arrTesteAB = ["10","41","66"];
        $lprojeto2023May06 = in_array($idpost, $arrTesteAB);
        if ($tabela->tipo == '3') {
            switch ($tabela->urlamigavel) {
                case 'ajuda':
                    $imgsrc = '/images/default/ajuda-v01.svg';
                    $width   = "185px";
                    $height  = "275px";
                    break;
                case 'contato':
                    $imgsrc  = '/images/default/contato-v01.svg';
                    $width   = "362px";
                    $height  = "262px";
                    break;
                case 'politica':
                    $imgsrc = '/images/default/privacidade-v01.svg';
                    $width   = "306px";
                    $height  = "266px";
                    break;
                case 'termos':
                    $imgsrc = '/images/default/termos-de-uso-v01.svg';
                    $width   = "266px";
                    $height  = "263px";
                    break;
                default:
                    break;
            }
        }
        foreach ($itens as $key => $item) {
            if ($item->tipo == '3') {
                $hasanchor = true;
                array_push($arranchor, ['title' => $item->aux_1, 'anchor' => $item->aux_2]);
            }
        }
        $introducao = ($tabela->tipo != '3') ? $tabela->getMarkdown() : '';

    @endphp

    {{-- Fraseteca2023Set03 --}}
    @if ($tabela->tipo == '3')
        @if ($tabela->urlamigavel == 'contato')
            <script src="https://www.google.com/recaptcha/api.js?render=NAN"></script>
        @endif
    @endif
    {{-- Projeto2023May06 --}}
    @if ($lprojeto2023May06)
        @include("front.includes.Fonteprincipal" ,["ambiente" => env("APP_ENV")])
    @endif

@endsection

@section('conteudo-view')
    <section class="margin-auto max-width-content conteudo--header">
        @if (!$amp)  @include('front.includes.Compartilhar') @endif
        <div class="lado--a">
            <div class="conteudo--header-ele1 no-print">
                @include('front.includes.Breadcrumbs', [
                    'strtabela' => $tabela->tipo == '3' ? 'institucional' : 'posts',
                    'amp' => $amp,
                ])
            </div>
            <div class="conteudo--header-ele2">
                <h1 itemprop="name" class="titulo @if ($tabela->tipo == 3) institucional @endif">
                    {{ $tabela->titulo }}
                </h1>
                <span itemprop="headline" style="display:none;">{{ $tabela->titulo }}</span>
            </div>
        </div>
        <div class="lado--b">
            @if (!$amp)
                @if ($tabela->tipo == 1)
                    <div class="conteudo--header-ele3">
                        @include('front.includes.Opcoessingle', ['amp' => $amp])
                    </div>
                @endif
            @endif
        </div>
    </section>

    @if ($introducao)
        <section class="margin-auto max-width-content conteudo conteudo-paragrafo introducao">
            @php
                echo $introducao;
            @endphp
        </section>
    @endif

    @if ($hasanchor)
        <section class="margin-auto max-width-content conteudo--anchor @if ($tabela->imprime_capa == '1') with--capa @endif">
            <div class="conteudo--anchor--body">
                <div class="conteudo--anchor--body--header">
                    <div class="indice">Índice</div>
                </div>
                <ul class="@if ($tabela->imprime_capa == '1') with--capa @endif">
                    @php $cont=0; @endphp
                    @foreach ($arranchor as $anchor)
                        @if (isset($anchor['title']))
                            @php $cont++; @endphp
                            <li>
                                <div class="numeros">
                                    {{ $cont }}.
                                </div>
                                <div class="ancora">
                                    <a href="#{{ $anchor['anchor'] }}" title="{{ $anchor['title'] }}">
                                        <span class="link">{{ $anchor['title'] }}</span>
                                    </a>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            @if ($tabela->imprime_capa == '1' )
                @if (!$amp)
                    <div class="conteudo--anchor--capa no-print lazy-background" data-src="{{ $imgsrc }}"></div>
                @else
                    <amp-img src="{{ $imgsrc }}" height="200px" width="400px" layout="responsive"></amp-img>
                @endif
            @endif
        </section>
    @else
        @if ($tabela->imprime_capa == '1' && (!$amp))
            <section
                class="margin-auto max-width-content conteudo no-print conteudo--capa--impressa 
                @if ($tabela->tipo == '3') institucional @endif">

                @include('front.includes.Img', [
                    'amp' => $amp,
                    'width'  => $width,
                    'height' => $height,
                    'imgsrc' => $imgsrc,
                    'validateImag' => false,
                    'lazyLoad' => ($tabela->tipo == 1) ? true : false,
                    'layout' => 'responsive',
                    'class' => $tabela->tipo == 3 ? 'institucional' : '',
                    'alt' => "Imagem de: {$tabela->titulo} ",
                ])
            </section>
        @endif
    @endif

    <section
        class="margin-auto @if ($tabela->urlamigavel == 'ajuda') max-width-content @else max-width-content @endif conteudo">
        @if ($tabela->tipo == 1)
            @include('front.PostShow_Incorp.Postsitens', ['mobile' => false, 'anuncios' => $anuncios, "amp" => $amp])
        @elseif ($tabela->tipo == 3)
            @include('front.PostShow_Incorp.Institucional', [
                'amp' => $amp,
            ])
        @endif
    </section>

    @if ($tabela->tipo == 1)
        <section class="margin-auto max-width-content conteudo mb-30">
            @include('front.includes.Tagposts')
        </section>
        <section class="margin-auto ">
            @include('front.includes.Biografia')
        </section>
        <section class="margin-auto max-width-content no-print mt-50">
            @include('front.includes.Relacionados', [
                'amp' => $amp,
                'withTitulo' => true,
                'lazyOn' => true,
                'txtTitulo' => 'Quem teve por aqui também gostou:',
            ])
        </section>
        <section class="margin-auto max-width-content no-print mt-40">
            @include('front.PostShow_Incorp.Comentarios', ['amp' => $amp])
        </section>
        @if (!$amp)
            <section class="banner bg-padrao no-print">
                @include('front.PostShow_Incorp.Banner', ['amp' => $amp])
            </section>
        @endif
    @else
        <div class="demarcador-marca no-print"></div>
    @endif

@endsection
@section('js-view')
    @if (!$amp)
        @if (isset($logado))
            @include('front.includes.Json', [
                'id' => 'arrPastasData',
                'tabela' => 'PastaUsuarioItem',
                'dadosItens' => $arrpastas,
            ])
            @if ($tabela->tipo == 3)
                <script src="https://fraseteca.com.br/js/PostShow__inst.js?ver={{ env('VER') }}"></script>
            @else
                <script src="https://fraseteca.com.br/js/PostShow.js?ver={{ env('VER') }}"></script>
            @endif
        @else
            <form ref="call_login" class="form-box" action="/login" method="GET">
                @php $rand = rand(0,9); @endphp
                <input type="hidden" name="token_reverso" value="l{{ $rand }}{{ $idpost ?? 0 }}">
                <button type="submit" class="ref_call_login hidden">Login</button>
            </form>
            {{-- Projeto2023May06 --}}
            @if ($lprojeto2023May06)
                <script defer="defer" src="https://fraseteca.com.br/js/PostShow__projeto2023May06.js?ver={{ env('VER') }}"></script>
            @else
                @if (env("APP_ENV")=="local")
                    <script defer="defer" src="http://fraseteca.dev.io/js/PostShow__nolog.js?ver={{ env('VER') }}"></script>
                @else
                    <script defer="defer" src="https://fraseteca.com.br/js/PostShow__nolog.js?ver={{ env('VER') }}"></script>
                @endif
            @endif
        @endif
    @endif
@endsection
