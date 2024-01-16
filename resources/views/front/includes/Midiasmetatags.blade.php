@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Midiasmetatags.blade.php
     * Autor: LM
     * Objetivo: Include do responsável pela inclusão de metastags usadas pelas mídias sociais
     * Doc: PENDENTE
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *  ● Projeto2023Jan10 -  Melhorando o LCP no Webmaster Tools - Tarefa: 6) Melhorias que devem ser implementadas identificadas na Revisão
     *      >> 01-02-23 - Retirado os testes em relação ao $boolteste2 do Projeto Projeto20221110
     *--------------------------------------------------------------------------------------------------------------*/
@endphp
<meta property="og:type" content="article">
<meta property="og:title" content="{{$titulo ?? 'Fraseteca'}}">
<meta property="og:description" content="{{$resumo ?? 'Fraseteca'}}">
<meta property="og:url" content="{{$canonical ?? 'https://fraseteca.com.br'}}">
<meta property="og:site_name" content="fraseteca.com.br">
<meta property="article:published_time" content="{{$publishedtime ?? '2020-04-09T08:00:00+08:00'}}">
<meta property="article:modified_time" content="{{$publishedtime ?? '2020-04-09T08:00:00+08:00'}}">
<meta property="article:author" content="Fraseteca">
<meta property="og:image" content="{{$image ?? 'https://fraseteca.com.br/images/logo-v06.svg'}}">
<meta property="og:image:width" content="{{$imagewidth ?? '150'}}">
<meta property="og:image:height" content="{{$imageheight ?? '33'}}">
<meta property="article:section" content="frases">
<meta property="article:tag" content="{{$titulo ?? 'Fraseteca'}}">