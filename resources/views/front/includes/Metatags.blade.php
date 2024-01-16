@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Metatags.blade.php
     * Autor: LM
     * Objetivo: Metatags principais do sistema.
     * Doc: https://docs.google.com/document/d/1zj90N6FttdnPA0MXh778ofLHJB8MSNQBDE14z1RF0lA/edit#heading=h.2cj3mh8781yn
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     * *  ● Projeto2023Mar02 - Redirecionar as páginas AMP para não Amp
     *     >> 16-03-23 - Não trazer a tag link "amphtml" apenas para as seguintes 
     *        publicações: 86-frases-de-deus-para-status, 46-frases-da-cora-coralina
     *    ● Projeto2023Mar03 - Redirecionar páginas AMP, Parte 2
     *     >> 20-03-23 - Remover as lógicas de quais publicações não terão canonical_amp do projeto
     *    ● Projeto2023Mar04 - Redirecionar páginas AMP, Parte 4
     *     >> 20-03-23 - Remover para todas as publicações do site, a canonical_amp tag 
     *--------------------------------------------------------------------------------------------------------------*/
@endphp

<meta charset="utf-8">
<title>{{ $titulo ?? 'Fraseteca' }} - Fraseteca</title>
<meta name="description" content="{{ $resumo ?? 'Fraseteca' }}">
<meta name="keywords" content="{{ $titulo ?? 'Fraseteca' }}">
<link rel="alternate" href="{{ $canonical ?? 'https://fraseteca.com.br' }}" hreflang="pt-br">
<link rel="canonical" href="{{ $canonical ?? 'https://fraseteca.com.br' }}">

{{-- Projeto2023Mar04 --}}
{{-- @if (isset($seo['canonical_amp']))
    @if ($seo['canonical_amp'] != '')
        <link rel="amphtml" href="{{ $seo['canonical_amp'] }}">
    @endif
@endif --}}

<meta content="DOCUMENT" name="RESOURCE-TYPE">
<meta content="GLOBAL" name="DISTRIBUTION">
<meta content="pt-br" name="LANGUAGE">
<meta content="{{ $robots ?? 'INDEX, FOLLOW' }}" name="ROBOTS">

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content=" {{ asset('images/fiveicon/apple-icon-144x144.png') }}">
<meta name="theme-color" content="#ffffff">
<meta name="csrf-token" content="{{ csrf_token() }}">
