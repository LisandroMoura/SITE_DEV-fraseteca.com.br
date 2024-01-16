@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Seoparam_preload_imagens.blade.php
     * Autor: LM
     * Objetivo: Objetivo desta Função é informar ao navegador, quais as imagens devem ser carregadas primeiramente 
     *           na fila de execução do navegador. Com base nesta informação, o navegador, vai fazer um pré 
     *           carregamento da imagem.
     * Doc: https://docs.google.com/document/d/1Xi5UPcpwxjlpaLOem15ntsVitdeyZEfZe5DY-VemMGI/edit#heading=h.8cvh7g9b36go
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *  ● Projeto20220805 - SEO parametros para a Single de frase
     *     >> 15-08-22 - LM SeoParam preloadImages
     *   ● Projeto2023Fev01 - Problema de LCP: mais de 2,5s (dispositivos móveis) - Dia 18/02
     *    >> 20-02-23 - Trazer de volta a vida esta include, porém apenas para páginas AMP
     *--------------------------------------------------------------------------------------------------------------*/
    $momentolazy = $tabela->momentolazy ?? 2;
    $contador = 0;

@endphp

@if (isset($itens))
@foreach ($itens as $item)
    @php
        $contador++;
        if ($contador > $momentolazy) {
            return;
        }
    @endphp
    <link rel="preload" as="image" href="{{ $item->nomeDownload ?? $item->capa }}">
@endforeach
    
@endif
@if ($nomeDaTabela)
    @if ($nomeDaTabela == 'frases')
        <link rel="preload" as="image" href="{{ $tabela->nomeDownload ?? $tabela->capa }}">
    @endif
@endif
