@extends('template.Front')
@section('css-view')
    @include('front.SearchShow_Incorp.Assets', ['amp' => $amp])
@endsection
@section('custom-php')
    @php
        $mobile = false; //isMobile($options ?? null)  ● Projeto20221201  = desativar a função em view isMobile() ;
        $customThema = $logado ? $logado->thema : '';
        $customClass = 'single-frase';
        $arrpastas = $logado ? $logado->pastas()->all() : [];
        $pageType = 'search';
        
        $titulo = isset($tabela) ? (property_exists($tabela, 'titulo') ? $tabela->titulo : null) : '';
        
        if (!$titulo) {
            $titulo = data_get($seo, 'titulo', null);
        }
        
        //custons
        $idpost = 0;
        $dados = [];
        $tipoClasse = [
            'todos' => '',
            'autor' => '',
            'frases' => 'ativo no-interact',
            'listas' => '',
        ];
        $tipo = 'frases';
        $total = 0;
        $ncont = 0;
        $classLazy = '';
        $query = '';
        
        if (isset($posts)):
            if (count($posts)) {
                $dados = $posts;
                $total = $posts->total();
            }
        endif;
        if (isset($frases)):
            if (count($frases)) {
                $dados = $frases;
                $total += $frases->total();
            }
        endif;
        //forçar o erro
        if (env('APP_ENV') != 'producao') {
            stream_context_set_default([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);
        }
        if (isset($_GET['pesquisar'])) {
            $query = $_GET['pesquisar'] ? $_GET['pesquisar'] : '';
            $titulo = "Achamos $total resultados para o termo \" {$_GET['pesquisar']} \" ";
            $queryResultados = "busca por: $query";
        }
        if (isset($_GET['tipo'])) {
            $tipo = $_GET['tipo'] ? $_GET['tipo'] : '';
            $tipoClasse['todos'] = '';
            $tipoClasse['frases'] = '';
            $tipoClasse['listas'] = '';
            $tipoClasse[$tipo] = 'ativo no-interact';
        }
    @endphp
@endsection

@section('conteudo-view')
    <section class="margin-auto max-width-content conteudo--header">
        <div class="lado--a">
            <div class="conteudo--header-ele1 no-print">
                @include('front.includes.Breadcrumbs', [
                    'titulo' => $queryResultados ?? '',
                    'strtabela' => isset($tabela)
                        ? (method_exists($tabela, 'getTable')
                            ? $tabela->getTable()
                            : $pageType)
                        : $pageType,
                    'amp' => $amp,
                ])</div>
            <div class="conteudo--header-ele2 no-print archive--header ">
                <h1 itemprop="name" class="titulo">
                    {{ $titulo }}
                </h1><span itemprop="headline" style="display:none;">{{ $titulo }}</span>
            </div>
        </div>
    </section>

    @if (isset($queryResultados))
        <section class="margin-auto max-width-content conteudo">
            <ul class="botoes--filtro mb-20">
                <li><a href="/pesquisa/termo?pesquisar={{ $query }}&tipo=todos" data-tipo="todos"
                        class="botao-padrao full {{ $tipoClasse['todos'] }}">Tudo</a></li>
                <li><a href="/pesquisa/termo?pesquisar={{ $query }}&tipo=frases" data-tipo="frases"
                        class="botao-padrao full {{ $tipoClasse['frases'] }}">Frases</a></li>
                <li><a href="/pesquisa/termo?pesquisar={{ $query }}&tipo=listas" data-tipo="listas"
                        class="botao-padrao full {{ $tipoClasse['listas'] }}">Bibliotecas</a></li>
                {{-- <li><a href="/pesquisa/termo?pesquisar={{$query}}&tipo=autor" data-tipo="todos"class="bt-filtrar full {{$tipoClasse["autor"]}}">Autores</a></li> --}}
            </ul>
        </section>

        <section class="margin-auto max-width-content conteudo">

            @switch($tipo)
                @case('todos')
                    @if (!count($frases) && !count($posts))
                        @include('front.SearchShow_Incorp.Notfound', [
                            'query' => $query,
                            'tipo' => 'frase',
                        ])
                    @endif
                    @if (count($posts))
                        <div class="mb-30 flex-end">
                            @include('front.includes.Relacionados', [
                                'postrel' => $posts,
                                'desligaLazy' => true
                                ])
                            <section class="margin-auto max-width-content conteudo mb-50 mt-30">
                                @include('front.includes.Navegacao', [
                                    'query' => '&pesquisar=' . $query . '&tipo=listas',
                                    'amp' => false,
                                    'path' => $posts->resolveCurrentPath(),
                                    'lastPage' => $posts->lastPage(),
                                    'currentPage' => $posts->currentPage(),
                                ])
                            </section>
                        </div>
                        @if (count($frases))
                            <div class="demarcador-marca no-mobile no-print"></div>
                            <h2 class="mt-30">Frases</h2>
                        @endif
                    @endif

                    @if (count($frases))
                        @include('front.PostShow_Incorp.Postsitens', [
                            'mobile' => $mobile,
                            'itens' => $frases,
                            'frasesfavoritas' => [],
                        ])
                        <section class="margin-auto max-width-content conteudo mb-50">
                            @include('front.includes.Navegacao', [
                                'query' => '&pesquisar=' . $query . '&tipo=frases',
                                'amp' => false,
                                'path' => $frases->resolveCurrentPath(),
                                'lastPage' => $frases->lastPage(),
                                'currentPage' => $frases->currentPage(),
                            ])
                        </section>
                    @endif
                @break

                @case('frases')
                    @if (!count($frases))
                        @include('front.SearchShow_Incorp.Notfound', [
                            'query' => $query,
                            'tipo' => 'frase',
                        ])
                    @endif

                    @if (count($frases))
                        @include('front.PostShow_Incorp.Postsitens', [
                            'mobile' => $mobile,
                            'itens' => $frases,
                            'frasesfavoritas' => [],
                        ])
                        <section class="margin-auto max-width-content conteudo mb-50">
                            @include('front.includes.Navegacao', [
                                'query' => '&pesquisar=' . $query . '&tipo=frases',
                                'amp' => false,
                                'path' => $frases->resolveCurrentPath(),
                                'lastPage' => $frases->lastPage(),
                                'currentPage' => $frases->currentPage(),
                            ])
                        </section>
                    @endif
                @break

                @case('listas')
                    <div class="mb-40">
                        @if (!count($posts))
                            @include('front.SearchShow_Incorp.Notfound', [
                                'query' => $query,
                                'tipo' => 'biblioteca',
                            ])
                        @endif
                        @if (count($posts))
                            @include('front.includes.Relacionados', ['postrel' => $posts,'desligaLazy' => true])
                            <section class="margin-auto max-width-content conteudo mb-50 mt-30">
                                @include('front.includes.Navegacao', [
                                    'query' => '&pesquisar=' . $query . '&tipo=listas',
                                    'amp' => false,
                                    'path' => $posts->resolveCurrentPath(),
                                    'lastPage' => $posts->lastPage(),
                                    'currentPage' => $posts->currentPage(),
                                ])
                            </section>
                        @endif
                    </div>
                @break
            @endswitch
        </section>
    @endif

    <section class="banner bg-padrao no-print">
        @include('front.PostShow_Incorp.Banner', ['amp' => $amp])
    </section>
@endsection
@section('js-view')
    @if (!$amp)
        @if (isset($logado))
            @include('front.includes.Json', [
                'id' => 'arrPastasData',
                'tabela' => 'PastaUsuarioItem',
                'dadosItens' => $arrpastas,
            ])
            <script src="{{ asset('js/SearchShow.js') }}?ver={{ env('VER') }}"></script>
        @else
            <form ref="call_login" class="form-box" action="/login" method="GET">
                @php $rand = rand(0,9); @endphp
                <input type="hidden" name="token_reverso" value="l{{ $rand }}{{ $idpost ?? 0 }}">
                <button type="submit" class="ref_call_login hidden">Login</button>
            </form>
            <script src="{{ asset('js/SearchShow__nolog.js') }}?ver={{ env('VER') }}"></script>
        @endif
    @endif
@endsection
