@extends('template.Admin')

@section('css-view')
    @include('back.PainelShow_Incorp.Assets', ['amp' => $amp])
@endsection

@section('custom-php')
    @include('front.includes.Mobiletest')
    @php
        $mobile = false ; //isMobile($options ?? null)  ● Projeto20221201  = desativar a função em view isMobile() ;
        $customThema = $logado ? $logado->thema : '';
        $customClass = 'single-frase';
        $arrpastas = $logado ? $logado->pastas()->all() : [];
        $pageType = 'pastas';
        $titulo = $titulo ?? null;

        $default_page = 'painel';

        $nComments = \App\Services\NotificAdm::getPendingQuantity('comments');
        $nCommentsFrases = \App\Services\NotificAdm::getPendingQuantity('comments_frases');
        $nAprovacao = \App\Services\NotificAdm::getPendingQuantity('aprovacao');
        $nRemessas = \App\Services\NotificAdm::getPendingQuantity("remessas");      


    @endphp
@endsection

@section('conteudo-view')

    <section class="margin-auto full-width-content conteudo--header--painel">
        <div class="margin-auto max-width-content conteudo--header--painel--item">
            <h1 itemprop="name" class="titulo">
                {{ $titulo }}
            </h1><span itemprop="headline" style="display:none;">{{ $titulo }}</span>
        </div>
    </section>

    <section class="margin-auto max-width-content conteudo--admin">
        <aside id="sidebar" class="normal" ref="ref_sidebar">
            @include('back.includes.Menu', [
                'pagina' => $default_page,
                'amp' => false,
            ])
        </aside>
        <aside id="content" class="default-form {{ $default_page }}">
            @if ($errors->any())
                @if ($errors->first() == false && $errors->first() != 'sucesso')
                    <h1> {{ $errors->all()['1'] }}</h1>
                    <p>{{ $errors->all()['2'] }}</p>
                @endif
            @endif

            {{-- Pendẽncias --}}
            <div class="content-wrapper">
                <h2>Pendências ({{ intval($nComments) + intval($nCommentsFrases) + intval($nAprovacao) + intval($nRemessas) }})</h2>
                <ul>
                    <li><a href="{{ route('admin.gestao_aprovacao', 'todos') }}">Aprovar/revisar
                            listas
                            @if ($nAprovacao > 0)
                                <strong style="color:red;">({{ $nAprovacao }}) pendentes</strong>
                            @endif
                        </a></li>
                    <li><a href="{{ route('admin.gestao_comments', 'todos') }}">Aprovar comentários

                            @if ($nComments > 0)
                                <strong style="color:red;">({{ $nComments }}) pendentes</strong>
                            @endif

                        </a></li>

                    <li><a href="{{ route('admin.gestao_comments_frases', 'todos') }}">Aprovar
                            comentários de Frases

                            @if ($nCommentsFrases > 0)
                                <strong style="color:red;">({{ $nCommentsFrases }})
                                    pendentes</strong>
                            @endif

                        </a></li>

                        <li><a href="{{ route('listas.gestaoListasAdmin', 'ativas') }}">Aprovar
                            Remessas da Marta Golpista

                            @if ($nRemessas > 0)
                                <strong style="color:red;">({{ $nRemessas }})
                                    pendentes</strong>
                            @endif

                        </a></li>


                </ul>
            </div>
            {{-- Cadastros --}}
            <div class="content-wrapper">
                <h2> Cadastros </h2>
                <ul>
                    <li><a href="{{ route('admin.gestao_usuarios', 'ativos') }}">Gestão de
                            Usuários</a></li>
                    <li><a href="{{ route('admin.gestao_posts', 'todos') }}">Gestão de Posts</a>
                    </li>
                    <li><a href="{{ route('admin.gestao_posts', 'todos') }}">Categorias</a></li>
                    <li><a href="{{ route('admin.gestao_posts', 'todos') }}">Tags</a></li>

                </ul>
            </div>

            {{-- Parâmetros --}}
            <div class="content-wrapper">
                <h2>
                    Parâmetros
                </h2>
                <ul>
                    <li><a href="{{ route('admin.gestao_posts', 'todos') }}">Parâmetros gerais</a>
                    </li>
                    <li><a href="{{ route('admin.gestao_midias', 'todas') }}">Gestão de Mídias</a>
                    </li>
                    <li><a href="{{ route('admin.gestao_banner', 'todos') }}">Imagem de capa</a>
                    </li>
                </ul>
            </div>
            {{-- endMagic --}}
        </aside>

    </section>
    {{-- <div class="page" id="app">
        @include('front.includes.Retorno')
        <bt-confirma :confirma="objConfirma"></bt-confirma>
        @include('back.includes.Menulateral')
        @include('back.includes.Areapesquisa')
        <div class="corpo-da-pagina">
            @include('back.includes.Topo', ['amp' => false])

            <div class="container corpo">
                <div class="wrapper">
                    <!-- Sidebar -->
                    <div id="sidebar" class="normal" ref="ref_sidebar">
                        @include('back.includes.Menu', [
                            'pagina' => $default_page,
                            'amp' => false,
                        ])
                    </div>
                    
                </div>
            </div>
        </div>
    </div> --}}
@endsection
@section('js-view')
    <script src="{{ asset('js/PastaList.js') }}?ver={{ env('VER') }}"></script>
@endsection
