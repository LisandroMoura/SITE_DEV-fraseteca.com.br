@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: FraseShow.blade.php
     * Autor: LM
     * Objetivo: View responsável pelo html da single de frases
     * Doc: 
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *  ● Projeto2023Jan09 - Bloco de anúncio responsivo Single de Frases.
     *     >> 20-01-23 - comentar o trecho que define se o tipo de anúncio será automático ou de display
     *     >> 20-01-23 - remover o bloco de anúncio Display deste programa e criar a view Anunciodisplay para
     *                   centralizar esta função. Sempre testar o anúncio em ambiente local
     *                   Anúncios para todas as frases com o status de 1 (google)
     *     >> 20-01-23 - Grantir que páginas amp não rodem os Anuncios de display
     *     >> 20-01-23 - Grantir lazyOn para os posts relacionados da frase
     * ● Projeto2023Jan10 - Melhorando o Webmaster Tools  - Tarefa: 3) Ajustes de LCP nas "single de Frase" 
     *     >> 31-01-23 - Limpeza de código
     * ● Projeto2023Mar01 - Melhorando o CLS em Amp page
     *     >> 10-03-23 - Trazer o banner apenas se não for página AMP
     *--------------------------------------------------------------------------------------------------------------*/
@endphp
@extends('template.Front')
@section('css-view')
    @include('front.FraseShow_Incorp.Assets', ['amp' => $amp])
@endsection
@section('custom-php')
    @php
        $arrpastas      = $logado ? $logado->pastas()->all() : [];
        $producao       = $options["paramGlobal"] ?? false; 
        $titulo         = $tabela->titulo;
        $idpost         = $tabela->id;
        $capa           = $tabela->capa;
        $thumb          = $tabela->thumb;
        $autor          = $tabela->autor;
        $frase          = $tabela->frase;
        $status         = $tabela->status;
        $autor_id       = $tabela->usuario_id;
        $tags           = '';
    @endphp
@endsection

@section('conteudo-view')
    @if (!$amp)
        @include('front.includes.Compartilhar', ['amp' => $amp])
    @endif

    <section class="margin-auto max-width-content conteudo--header">
        
        <div class="lado--a">
            <div class="conteudo--header-ele1 no-print">
                @include('front.includes.Breadcrumbs', [
                    'strtabela' => 'frases',
                    'amp' => $amp,
            ])</div>
            
            <div class="conteudo--header-ele2">
                <h1 itemprop="name" class="titulo">
                    {{ $tabela->frase }}
                </h1><span itemprop="headline" style="display:none;">{{ $tabela->titulo }}</span>
            </div>
        </div>
        
        <div class="lado--b">
            <div class="conteudo--header-ele3">
                @include('front.includes.Downloadfrase', [
                'amp' => $amp,
                'class' => 'no-mobile'
            ])</div>
        </div>
    </section>
    
    <section class="margin-auto max-width-content conteudo">
        @include('front.FraseShow_Incorp.Fraseitens')        
    </section>

    <section class="margin-auto max-width-content conteudo">
        <div class="frase-inserida">
            Frase inserida no dia {{$tabela->getCreatedAtAttribute()}} 
        </div>
    </section>
    
    @if ($tabela->status == "1" && !$amp && $tabela->id == "21645"  )
        @include('front.includes.Anunciodisplay', [
            'producao'      => $producao,
        ])
    @endif

    <section class="margin-auto max-width-content conteudo">
        @include('front.includes.Downloadfrase', [
        'amp' => $amp,
        'class' => 'only-mobile mt-30'
        ])
    </section>

    <section class="margin-auto max-width-content no-print mt-50 mb-30">
        @include('front.includes.RelacionadosFraseAmp', [
            'amp' => $amp,
            'withTitulo' => true,
            'lazyOn' => true,
            'postrel' => $naslistas ?? [],
            'icone'   => 'ico-clipse',
            "classe"   => "fonte-18",
            'txtTitulo' => 'Esta frase encontra-se nas bibliotecas abaixo:',
        ])
    </section>

    <section class="margin-auto max-width-content conteudo">
        @include('front.includes.Tagposts')
    </section>
    <section class="margin-auto mt-40">
        @include('front.includes.Biografia', [
            'hiddeImgFromAmp'=>true
        ])
    </section>
    <section class="margin-auto max-width-content no-print mt-40">
        @include('front.includes.RelacionadosFraseAmp', [
            'amp' => $amp,
            'lazyOn' => true,
            'withTitulo' => true,
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
@endsection
@section('js-view')
    @if (!$amp)
        @if (isset($logado))
            @include('front.includes.Json', [
                'id'            => 'arrPastasData',
                'tabela'        => 'PastaUsuarioItem',
                'dadosItens'    => $arrpastas,
            ])
            <script src="{{ asset('js/FraseShow.js') }}?ver={{ env('VER') }}"></script>
        @else
            <form ref="call_login" class="form-box" action="/login" method="GET">
                @php $rand = rand(0,9); @endphp
                <input type="hidden" name="token_reverso" value="l{{ $rand }}{{ $idpost ?? 0 }}">
                <button type="submit" class="ref_call_login hidden">Login</button>
            </form>
            <script src="{{ asset('js/FraseShow__nolog.js') }}?ver={{ env('VER') }}"></script>
        @endif
    @endif
@endsection
