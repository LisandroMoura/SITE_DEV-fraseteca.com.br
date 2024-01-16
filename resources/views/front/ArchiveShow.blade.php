@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: ArchiveShow.blade.php
     * Autor: LM
     * Objetivo: Principal programa responsável por criar o HTML dos archives
     * Doc: 
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     * ● Fraseteca2023Set03 - problemas na no uso da distribuição
     *     >> 25-09-23 - ajustar o link da navegação das tags 
     *--------------------------------------------------------------------------------------------------------------*/
@endphp
@extends('template.Front')

@section('css-view')
    @include('front.ArchiveShow_Incorp.Assets', ['amp' => $amp])
@endsection

@section('custom-php')
    @php
    $mobile = false ; //isMobile($options ?? null)  ● Projeto20221201  = desativar a função em view isMobile() ;
    $customThema = $logado ? $logado->thema : '';
    $pageType = $tipo ?? 'archive';
    $arrpastas = $logado ? $logado->pastas()->all() : [];
    //custons
    $dados = $tabela->items() ?? [];
    $query = data_get($_GET, 'pesquisar', '');
    $total = data_get($tabela, 'total', null) ? data_get($tabela, 'total', null) : (method_exists($tabela, 'total') ? $tabela->total() : 0);
    $path = data_get($tabela, 'resolveCurrentPath', null) ? data_get($tabela, 'resolveCurrentPath', null) : (method_exists($tabela, 'resolveCurrentPath') ? $tabela->resolveCurrentPath() : null);
    // Fraseteca2023Set03 date: 25-set-2023 // obs: ajustar o link das tags
    $path = str_replace("http://fraseteca.dev.io","https://fraseteca.com.br",$path);
    $path = str_replace(env("DISTRIBUITION_URL"),"https://fraseteca.com.br",$path);

    $lastPage = data_get($tabela, 'lastPage', null) ? data_get($tabela, 'lastPage', null) : (method_exists($tabela, 'lastPage') ? $tabela->lastPage() : null);
    $perPage = data_get($tabela, 'perPage', null) ? data_get($tabela, 'perPage', null) : (method_exists($tabela, 'perPage') ? $tabela->perPage() : null);
    $currentPage = data_get($tabela, 'currentPage', null) ? data_get($tabela, 'currentPage', null) : (method_exists($tabela, 'currentPage') ? $tabela->currentPage() : null);
    $idpost = data_get($dados, 0,null) ? $dados[0]->id : null;
    $urlamigavel = data_get($tabela, 'path', null) ? data_get($tabela, 'path', null) : (method_exists($tabela, 'path') ? $tabela->path() : null);;

    $titulo = property_exists($tabela,"titulo") ? $tabela->titulo : null;
    if(!$titulo)
        $titulo = data_get($seo, 'titulo', null);
    if(isset($tituloPage))
        $titulo = $tituloPage;
    @endphp
@endsection
@section('conteudo-view')
    <section class="margin-auto max-width-content conteudo--header archive--header">
        <div class="lado--a">
            <div class="conteudo--header-ele1 no-print">
                @include('front.includes.Breadcrumbs', [
                    'titulo' => $titulo,
                    'strtabela' => method_exists($tabela, 'getTable') ? $tabela->getTable() : $pageType,
                    'amp' => $amp,
                ])</div>
            <div class="conteudo--header-ele2 no-print archive--header ">
                <h1 itemprop="name" class="titulo">
                    {{ $titulo }}
                </h1><span itemprop="headline" style="display:none;">{{ $titulo }}</span>
            </div>
        </div>
        <div class="lado--b">
            <div class="conteudo--header-ele3 flex-end no-print archive--header">
                @if ($tipo == "tag")
                    @include('front.includes.formulario.Btseguindo', [
                            'amp' => $amp,
                            'url' => $seo['canonical'],
                            'tipo' => $tipo,
                            'seguindo' => $seguindo,
                    ])
                @endif
            </div>
        </div>
    </section>

    <section class="margin-auto max-width-content conteudo mb-50">
        @if (isset($dados))
            @if ($tipo == "tags")
                @include('front.includes.Tags',[
                    "tagposts" => $dados,
                    "classe"    => "no-grid",
                    "semTitulo" => true,
                ])

            @elseif ($tipo=="frases")
                @include('front.includes.Frases', [
                    'amp' => $amp,
                    'withTitulo' => true,
                    'postrel' => $dados ?? [],
                    'semTitulo' => true,
                ])
            @else
                @include('front.includes.Relacionados', [
                    'amp' => $amp,
                    'withTitulo' => true,
                    'postrel' => $dados ?? [],
                    'desligaLazy' => true,
                    'semTitulo' => true,
                ])    
            @endif
            
        @else 
            <h3>Sem informações no momento</h3>
        @endif
    </section>


    <section class="margin-auto max-width-content conteudo mb-50">
        @include('front.includes.Navegacao', [
            'amp' => $amp,
        ])
    </section>

    <section class="banner bg-padrao no-print">
        @include('front.PostShow_Incorp.Banner', ['amp' => $amp])
    </section>
@endsection

@section('js-view')
    @if (!$amp)
        <form class="form-box" action="/login" method="GET">
            @php $rand = rand(0,9); @endphp
            <input type="hidden" name="token_reverso" id="token_reverso"  value="l{{ $rand }}{{ $idpost ?? 0 }}">
            <button type="submit" class="ref_call_login hidden">Login</button>
        </form>
        @if (isset($logado))
            <script src="{{ asset('js/ArchiveShow.js') }}?ver={{ env('VER') }}"></script>
        @else
            <script src="{{ asset('js/ArchiveShow__nolog.js') }}?ver={{ env('VER') }}"></script>
        @endif
    @endif
@endsection
