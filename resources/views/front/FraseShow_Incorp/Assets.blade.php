@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Assets.blade.php
     * Autor: LM
     * Objetivo: Include para incluir as folhas de estilos.
     * Doc: 
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *  ● Projeto2023Mar01 - Melhorando o CLS em Amp page
            >> 10-03-23 - Separação das folhas de estilos de frases, entre Amp e não AMP (linha 17)
     *--------------------------------------------------------------------------------------------------------------*/
@endphp

@if ($amp)
    <style amp-custom>                
        @include("front.FraseShowAmp_Incorp.Css")
    </style>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>    
@else
    <style>                
        @include("front.FraseShow_Incorp.Css")
    </style>
@endif