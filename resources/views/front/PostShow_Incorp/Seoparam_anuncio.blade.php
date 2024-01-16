@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Seoparam_anuncio.blade.php
     * Autor: LM
     * Objetivo: Principal Include para inclusão de anúncios automáticos do Google Adsense no Front-end.
     * Doc: https://docs.google.com/document/d/1JF_80PYNTFcbXLJWFrkzXHd7LZ0ejYagvsxc2wVis3k/edit
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *  ● Projeto20220805 - SEO parametros para a Single de frase
     *     >> 15-08-22 - Apenas para posts que estiverem com o flag (mostrar anuncios) -ok
        - logica do Tipo de anúncio - ok
        - Adptar o lazyAds
     *  ● Projeto2023Jan10 - Melhorando o LCP no Webmaster Tools  - Tarefa: 6) Melhorias que devem ser implementadas identificadas na Revisão
     *     >> 02-02-23 - Testar se ambiente é produção para a impressão dos anúncios
     *     >> 02-02-23 - Inclusão de comentários para melhor depuração dos anúncios aplicados em produção
     *  ● Projeto2023Mar05 - Aplicar anúncio e Lazy de anúncio nas Single de Frases
     *     >> 21-03-23 - Habilitar o parâmetro isProdução, para garantir que o código de anúncio não execute em nosso localhost
     *     >> 21-03-23 - Retirada de um else if sem uso
*--------------------------------------------------------------------------------------------------------------*/
@endphp
{{-- Projeto2023Mar05 --}}
@php if($nomeTabela == "frases") $tabela->anuncios = true; @endphp
@if ($tabela->anuncios == 'true')
    @php
        $seoparam = explode(';', $seoparam);
        $lautomatico = true;
        
        if (isset($seoparam[5])) {
            if ($seoparam[5] == '2') {
                $lautomatico = false;
            }
        }
        
        $lazyAds = false;
        if (isset($seoparam[6])) {
            if ($seoparam[6] == 'true') {
                $lazyAds = true;
            }
        }

        $lazyAds = true;

    @endphp
    @if ($lautomatico)
        @if ($isProducao)
            @if ($lazyAds)
                <!-- ads X.at Ylz prd -->
                <script>
                    window.addEventListener('load', function() {
                        var is_adsense_load = 0;
                        window.addEventListener('scroll', function() {
                            if (is_adsense_load == 0) {
                                is_adsense_load = 1;

                                var ele = document.createElement('script');
                                ele.async = true;
                                ele.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
                                var sc = document.getElementsByTagName('script')[0];
                                sc.parentNode.insertBefore(ele, sc);

                                (adsbygoogle = window.adsbygoogle || []).push({
                                    google_ad_client: "ca-pub-6159622292805097",
                                    enable_page_level_ads: true
                                });
                            }
                        })
                    })
                </script>
            @else
                <!-- ads X.at Nlz prd -->
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6159622292805097"
                    crossorigin="anonymous"></script>
            @endif
        @else
            <!-- ads X.at loc -->
            {{-- <div class="anuncio-automatico" style="position: relative;     margin: 0 auto;top:0; left:0%; height:300px;width:80% ; background: #f1f1f1;border: 2px dashed #d1d1d1;padding:40px;z-index:1;display: flex; align-items: center; justify-content: center;">SIMULAÇÃO DE ANUNCIO AUTOMATICO LOCAL</div>      --}}
        @endif
    
    @endif
@endif
