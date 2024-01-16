@extends('template.Admin')

@section('css-view')
    @include('back.PainelShow_Incorp.Assets', ['amp' =>false])
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

            <div class="content-wrapper">

            </div>
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
