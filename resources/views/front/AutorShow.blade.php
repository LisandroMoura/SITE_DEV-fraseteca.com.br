@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: AutorShow.blade.php
     * Autor: LM
     * Objetivo: Principal programa responsável por criar o HTML dos autores
     * Doc: 
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     * ● Fraseteca2023Set03 - problemas na no uso da distribuição
     *     >> 25-09-23 - ajustar o link da navegação
     *--------------------------------------------------------------------------------------------------------------*/
@endphp
@extends('template.Front')
@section('css-view')
    @include('front.AutorShow_Incorp.Assets', ['amp' => $amp])
@endsection
@section('custom-php')
@include('front.includes.Mobiletest')
    @php
        $mobile = false ; //isMobile($options ?? null)  ● Projeto20221201  = desativar a função em view isMobile() ;     
        $customThema = $logado ? $logado->thema : "";
        $customClass = 'single-frase';
        $arrpastas = $logado ? $logado->pastas()->all() : [];
        //custons
        $titulo = $tabela->titulo;
        $idpost = $tabela->id;
        $urlamigavel = $tabela->urlamigavel;
        $capa = $tabela->capa;
        $thumb = $tabela->thumb;

        // dd($tabela->thumb);
        $tags = $tabela->tags;
        $imgsrc = null;

        // dd($mobile);
        if($mobile && $thumb ) $imgsrc = $thumb; 
        $typeimage = '';
        if (strpos($imgsrc, 'images.unsplash.com') !== false) {
            $typeimage = 'unsplash';
        }
        $hasanchor = false;
        $arranchor = [];

        if (isset($itens)){
            if(count($itens)):
                if(isset($itens['custom'])):
                    $total          = $itens['total'];
                    $path           = $itens['resolveCurrentPath'];       
                    $lastPage       = $itens['lastPage'];
                    $perPage        = $itens['perPage'];
                    $currentPage    = $itens['currentPage'];
                else:
                    $total          = $itens->total();
                    $path           = $itens->resolveCurrentPath();       
                    $lastPage       = $itens->lastPage();
                    $perPage        = $itens->perPage();
                    $currentPage    = $itens->currentPage();
                endif;
            endif; 
        }

        // Fraseteca2023Set03 date: 25-set-2023 // obs: ajustar o link das tags
        $path = str_replace("http://fraseteca.dev.io","https://fraseteca.com.br",$path);
        $path = str_replace(env("DISTRIBUITION_URL"),"https://fraseteca.com.br",$path);

    @endphp
    
@endsection

@section('conteudo-view')
    <section class="margin-auto max-width-content conteudo--header">

        {{-- @include('front.includes.Compartilhar', ['amp' => $amp]) --}}
        
        <div class="lado--a">
            <div class="conteudo--header-ele1 no-print">
                @include('front.includes.Breadcrumbs', [
                'strtabela' => $tabela->getTable(),
                'amp' => $amp,
            ])</div>
            <div class="conteudo--header-ele2">
                <h1 itemprop="name" class="titulo @if ($tabela->tipo == 3) institucional @endif">
                    {{ $tabela->titulo }}
                </h1><span itemprop="headline" style="display:none;">{{ $tabela->titulo }}</span>
            </div>
        </div>
        <div class="lado--b">
            <div class="conteudo--header-ele3">@include('front.includes.Opcoessingle', [
                'amp' => $amp,
            ])</div>
        </div>
    </section>
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
            @if ($tabela->imprime_capa == '1')
                <div class="conteudo--anchor--capa no-print" style="background-image:url({{ $imgsrc }});"></div>
            @endif
        </section>
    @else
        @if ($tabela->imprime_capa == '1')
            <section class="margin-auto max-width-content conteudo no-print conteudo--capa--impressa">
                @include('front.includes.Img',[
                    'amp' => $amp,
                    'imgsrc' => $imgsrc,
                    "layout"  => "responsive",
                    'class'   => $tabela->tipo==3 ? "institucional" : "",
                    'alt'    => "Imagem de: {$tabela->titulo} "

                ])
            </section>
        @endif
    @endif
    <section class="margin-auto @if ($tabela->urlamigavel=="ajuda") full-width-content @else max-width-content @endif conteudo">
        @include('front.AutorShow_Incorp.Postsitens', ['mobile' => $mobile])
    </section>

    <section class="margin-auto max-width-content conteudo mb-50">
        @include('front.includes.Navegacao', [
            'amp' => $amp,
        ])
    </section>


    <section class="margin-auto max-width-content no-print mt-50">
        @include('front.includes.Relacionados', [
            'amp' => $amp,
            'withTitulo' => true,
            'txtTitulo' => 'Quem teve por aqui também gostou:',
        ])
    </section>
    

    <section class="margin-auto max-width-content no-print mb-50">
        @php
            $lmsg = false;
            $tabela = $tabela ?? new stdClass();
            if (method_exists($tabela, 'getTable')) {
                if ($tabela->getTable() == 'frases' || $tabela->getTable() == 'posts') {
                    $lmsg = true;
                }
            }
        @endphp
    {{-- //Projeto20221103 - Page with redirect: LM 10-09-22 - retirar a barra do final do contato --}}

        @if ($lmsg)
            <div class="footer--item texto-contato no-print">
                Se você encontrou algum problema com esta lista, por favor entre em contato <a
                    href="/contato?page={{ $idpost ?? 'contato' }}">clicando aqui</a>
            </div>
        @endif

    </section>
    
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
            @if ($tabela->tipo == 3)
                <script src="{{ asset('js/PostShow__inst.js') }}?ver={{ env('VER') }}"></script>
            @else
                <script src="{{ asset('js/PostShow.js') }}?ver={{ env('VER') }}"></script>
            @endif
        @else
            <form ref="call_login" class="form-box" action="/login" method="GET">
                @php $rand = rand(0,9); @endphp
                <input type="hidden" name="token_reverso" value="l{{ $rand }}{{ $idpost ?? 0 }}">
                <button type="submit" class="ref_call_login hidden">Login</button>
            </form>
            <script src="{{ asset('js/PostShow__nolog.js') }}?ver={{ env('VER') }}"></script>
        @endif
    @endif
@endsection
