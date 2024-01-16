@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Anunciodisplay.blade.php
     * Autor: LM
     * Objetivo: View responsável por escrever o Html das caixas de anúncio do google adsense
     * Doc: https://docs.google.com/document/d/1y62UYFpbZiuEWl6InQyp6Dk-Jq0NRiXv7rYa-YElsMw/edit#heading=h.8cvh7g9b36go
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *  ● Projeto2023Jan09 - Bloco de anúncio responsivo Single de Frases.
     *     >> 20-01-23 - Criar a view de caixa de anuncio
     *--------------------------------------------------------------------------------------------------------------*/
    $producao = $producao ?? false;
@endphp

@if ($producao)
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6159622292805097"
        crossorigin="anonymous"></script>
    <!-- Responsivo -->
    <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-6159622292805097" data-ad-slot="6042966650"
        data-ad-format="auto" data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
@else
    <div class="anuncio normal teste no-print">
        <img src="{{ asset('images/anuncio1.jpg') }}" class="view-desk no-print" alt="anuncio">
        <img src="{{ asset('images/anuncio1_mobile.jpg') }}" class="view-responsive no-print" alt="anuncios">
    </div>
@endif
