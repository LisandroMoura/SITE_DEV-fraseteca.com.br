@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Headerpesquisa.blade.php
     * Autor: LM
     * Objetivo: Html da pesquisa no cabeçalho do site
     * Doc: 
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *   ● Projeto2023Mar01 - Melhorando o CLS em Amp page
     *    >> 10-03-23 - Tirar o ícone da lupa, no caso de páginas AMP e aplicar a class botao-pesquisa-amp
     *--------------------------------------------------------------------------------------------------------------*/
@endphp

<div class="header-pesquisa pai">
    @if ($amp)


        <input type="text" name="pesquisar"  
            id="pesquisarPrincipal"
            placeholder="pesquise frases" 
            value=""
            class="w100 fa fa-search pesquisa bordas-forms hasPlaceholder mobile no-print pesquisar">
        <button type="submit" class="botao-pesquisa-amp @if ($amp) amp @endif">buscar</button> 

    @else    
        <form name="form_search" id="form-search" action="{{ env("APP_URL") }}/pesquisa/termo" method="get" class="animes">
            <input type="text" name="pesquisar"  
                id="pesquisarPrincipal"
                placeholder="pesquise frases" 
                value=""
                class="w100 fa fa-search pesquisa bordas-forms hasPlaceholder mobile no-print">
            <button type="submit" class="botao-pesquisa  amp ">
                <i class="icone-pesquisa ico ico-buscar"></i>
            </button>
        </form>
    @endif
</div>

