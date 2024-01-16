@php
    
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Front.blade.php
     * Autor: LM
     * Objetivo: Include de template de html padrão do Front-end.
     * Doc: https://docs.google.com/document/d/1zj90N6FttdnPA0MXh778ofLHJB8MSNQBDE14z1RF0lA/edit
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *  ● Projeto20220805 - SEO parametros para a Single de frase
     *     >> 25-08-22 - Inserir a tratativa do código de anúncio, inserir as regras de forma mais eficiente
     *  ● Projeto2023Jan09 - Bloco de anúncio responsivo Single de Frases.
     *     >> 20-01-23 - Remover a possibilidade dos anuncios automáticos para Single de frases
     *  ● Projeto2023Jan10 - Melhorando o Webmaster Tools  - Tarefa: 1) Para celular ajustar problema de LCP: mais de 2,5s (dispositivos móveis)
     *     >> 25-01-23 - remover a chamada da webfont e inserir via JavaScrit
     *     >> 25-01-23 - remover a lógica de SEO Params, preload de imagens
     *     >> 26-01-23 - remover do Front.blade.php a lógica de $ocultarFonte - já que a fonte vai ser carregada via JS
     *     >> 31-01-23 - Não Trazer a imagem de capa pra página Não AMP
     *     >> 01-02-23 - Inserir novamente a chamada do Seoparam_preload_imagens.blade.php, pois ainda não sabemos se isso pode ser bom em alguns casos. E como ví nos testes, o uso desta técnica não fez diferença no pagespeed.
     *     >> 02-02-23 - Passagem do parâmetro $isProducao para a view Seoparam_anuncio.blade.php
     *     >> 02-02-23 - Tirar o Pre-carregar as imagens  
     *  ● Projeto2023Fev01 - Problema de LCP: mais de 2,5s (dispositivos móveis) - Dia 18/02
            >> 20-02-23 - Trazer de volta a include Seoparam_preload_imagens.blade.php porém apenas para as páginas AMP
            >> 20-02-23 - Para anúncios em páginas amp, trazer os parâmetros data-lazy-fetch="true" data-loading-strategy="1" na
                        tag amp-auto-ads, Na tentativa de fazer um lazyload nos anúncios e melhorar o LCP -PS testar isso em produção
     * ● Projeto2023Mar01 - Melhorando o CLS em Amp page
     *     >> 10-03-23 - Ocultar o script amp-font
     *     >> 10-03-23 - Ocultar o script amp-bind
     *     >> 10-03-23 - Chamar o amp-analytics apenas se for produção e colocar a sua respectiva tag mais abaixo
     * ● Projeto2023Mar05 - Aplicar anúncio e Lazy de anúncio nas Single de Frases
     *     >> 21-03-23 - Habilitar o parâmetro isProdução, para garantir que o código de anúncio não execute em nosso localhost
     *--------------------------------------------------------------------------------------------------------------*/
    
    $amp = $amp ?? false;
    $isProducao = false;
    $printAdsAMP = false;
    $hideFooterImage = false;
    if (env('APP_ENV') == 'producao' || env('APP_ENV') == 'homolog') {
        $isProducao = true;
        if (isset($nomeTabela)) {
            if ($nomeTabela == 'posts') {
                if (isset($tabela->tipo) && $tabela->tipo == 1) {
                    $printAdsAMP = true;
                }
            }
            if ($nomeTabela == 'frases') {
                $printAdsAMP = true;
                $hideFooterImage = true;
            }
        }
    }
@endphp
<!doctype html>
@if (!$amp)
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@else
    <html amp lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endif

<head>
    @if ($amp)
        <script async src="https://cdn.ampproject.org/v0.js"></script>

        @if (env('APP_ENV') == 'producao' || env('APP_ENV') == 'homolog')
            {{-- @if ($printAdsAMP)
                <script async custom-element="amp-auto-ads" src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js"></script>
            @endif --}}
            {{-- <script async custom-element="amp-font" src="https://cdn.ampproject.org/v0/amp-font-0.1.js"></script> --}}
            <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>

        @endif
        
    @else
        @include('front.PostShow_Incorp.Seoparam_analytics', [
            'seoparam' => '',
        ])
        @if ($isProducao)
            @if (isset($nomeTabela))
                @if ($nomeTabela == 'posts' || $nomeTabela == 'frases' )
                    @include('front.PostShow_Incorp.Seoparam_anuncio', [
                        'seoparam' => $tabela->seoparam,
                        'isProducao' =>$isProducao,
                    ])
                @endif
            @endif
        @endif
    @endif
    @php
        $seo = $seo ?? [];
        $titulo = data_get($seo, 'titulo', 'Fraseteca');
        $resumo = data_get($seo, 'resumo', 'Fraseteca, sua biblioteca de Frases');
        $canonical = data_get($seo, 'canonical', 'https://fraseteca.com.br');
        $robots = data_get($seo, 'robots', 'INDEX, FOLLOW');
        $image = data_get($seo, 'image', 'https://fraseteca.com.br/images/logo-v06.svg');
        $imagewidth = data_get($seo, 'image_width', '150');
        $imageheight = data_get($seo, 'image_height', "'33");
        $publishedtime = data_get($seo, 'published_time', '2019-08-09T08:00:00+08:00');
        $modifiedtime = data_get($seo, 'modified_time', '2019-08-09T08:00:00+08:00');
        
        $route = null;
        if (isset($nomeTabela)) {
            $route = $nomeTabela == 'frases' ? 'frase.edit' : 'post.edit';
            $urlamigavel = $nomeTabela == 'frases' ? "/frase/{$tabela->id}" : "/{$tabela->urlamigavel}";
            if ($nomeTabela == 'autor') {
                $route = 'autor.edit';
                $urlamigavel = $tabela->urlamigavel;
            }
        }
    @endphp

    @if ($amp)
        @include('front.PostShow_Incorp.Seoparam_preload_imagens', [
            'nomeDaTabela' => $nomeTabela ?? "",
        ])
    @endif
    <link rel="shortcut icon" href="{{ env('FIVE_ICON') }}" />
    @include('front.includes.Metatags')
    @if ($robots == 'INDEX, FOLLOW')
        @include('front.includes.Googleboots')
    @endif
    @php
        //15-ago-22: LM SeoParam imagemforte
        $image = $image ?? 'https://fraseteca.com.br/images/logo-v06.svg';
        $imagewidth = $imagewidth ?? '150';
        $imageheight = $imageheight ?? '33';
        $imagemforte = $tabela->imagemforte ?? ($tabela->capa ?? null);
        if ($imagemforte) {
            $arrImage = explode('|', $imagemforte);
            if (isset($arrImage[1])) {
                $image = $arrImage[0];
        
                $dimensoes = explode('x', $arrImage[1]);
        
                if (isset($dimensoes[1])) {
                    $imagewidth = $dimensoes[0];
                    $imageheight = $dimensoes[1];
                }
            }
        }
    @endphp
    {{-- 
            ● Projeto20221110 - Problema com as imagens webp - 
            Pluguin de Testes - executar os testes do case 2 (metatag do pinterest) e case 3 (metadados JSON)
        --}}
    @include('front.includes.Midiasmetatags')
    @include('front.includes.Dadosestruturados', [
        'image' => $image,
        'imagewidth' => $imagewidth,
        'imageheight' => $imageheight,
    ])

    @yield('css-view')
    @yield('custom-php')
</head>



<body itemscope itemtype="http://schema.org/WebPage"
    class="{{ $customThema ?? '' }} {{ $customClass ?? '' }} {{ env('APP_ENV') }}">
    {{-- @if ($amp)
        @if ($printAdsAMP)
            <amp-auto-ads 
                type="adsense" 
                data-ad-client="ca-pub-6159622292805097">
            </amp-auto-ads>
           
        @endif
    @endif --}}

    @if ($amp)
        @if (env('APP_ENV') == 'producao' || env('APP_ENV') == 'homolog')
            <amp-analytics type="gtag" data-credentials="include">
                <script type="application/json">
                    {
                    "vars" : {
                        "gtag_id": "G-V66X552YG6",
                        "config" : {
                        "G-V66X552YG6": { "groups": "default" }
                        }
                    }
                    }
                    </script>
            </amp-analytics>
        @endif  
    @endif
    
    <div id="before"></div>
    <div id="app" class="corpo-da-pagina {{ $customThema ?? '' }} {{ env('APP_ENV') ?? '' }}">

        @if (!$amp) @include('front.includes.Retorno', ['amp' => false]) @endif
        @include('front.includes.Topodosite', ['amp' => $amp, 'page' => data_get($seo, 'page', 'single')])

        @yield('conteudo-view')

        @include('front.includes.Footer',[
            "amp" => $amp,
            'hideFooterImage' => $hideFooterImage
        ])


    </div>

    @yield('js-view')

    
    
</body>

</html>
