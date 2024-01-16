@php
    $amp = $amp ?? false;
@endphp
<!doctype html>
@if (!$amp) <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> @else <html amp lang="{{ str_replace('_', '-', app()->getLocale()) }}"> @endif
    <head>        
        @if ($amp)
            <script async src="https://cdn.ampproject.org/v0.js"></script>
            <script async custom-element="amp-font" src="https://cdn.ampproject.org/v0/amp-font-0.1.js"></script>
            <script async custom-element="amp-bind" src="https://cdn.ampproject.org/v0/amp-bind-0.1.js"></script>            
            @if ($tabela->tipo == 1 && env("APP_ENV")=="producao") 
                <script async custom-element="amp-auto-ads" src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js"></script>
                {{-- 18-ago-22: LM - codigo analytics para amp --}}
                <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
                
            @endif
        @else 
            @if (env("APP_ENV")=="producao" ||env("APP_ENV")=="homolog" )
                <!-- Global site tag (gtag.js) - Google Analytics -->
                <script async src="https://www.googletagmanager.com/gtag/js?id=G-V66X552YG6"></script>
                <script>
                    window.dataLayer = window.dataLayer || [];
                    function gtag(){dataLayer.push(arguments);}
                    gtag('js', new Date());

                    gtag('config', 'G-V66X552YG6');
                </script>
                @if (isset($tabela) && $tabela->tipo == 1)
                    {{-- <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6159622292805097" data-ad-client="ca-pub-6159622292805097" crossorigin="anonymous"></script> --}}
                @endif
            @endif
        @endif
        @php   
            // $seo            = $seo ?? []; 
            // $titulo         = data_get($seo,"titulo","Fraseteca");
            // $resumo         = data_get($seo,"resumo","Fraseteca, sua biblioteca de Frases");
            // $canonical      = data_get($seo,"canonical","https://fraseteca.com.br");
            // $robots         = data_get($seo,"robots","INDEX, FOLLOW");
            // $image          = data_get($seo,"image","https://fraseteca.com.br/images/logo.png");
            // $imagewidth     = data_get($seo,"image_width","141");
            // $imageheight    = data_get($seo,"image_height","'30");
            // $publishedtime  = data_get($seo,"published_time","2019-08-09T08:00:00+08:00");
            // $modifiedtime   = data_get($seo,"modified_time","2019-08-09T08:00:00+08:00");     
            // $route          = null;
        @endphp
        <link rel="shortcut icon" href="{{env('FIVE_ICON')}}"/>
        @if (!$amp)
            @include("front.includes.Fonteprincipal" ,["ambiente" => env("APP_ENV")])
        @endif
        @yield('css-view')
        @yield('custom-php')
    </head>
    <body itemscope itemtype="http://schema.org/WebPage" class="{{ $customThema ?? '' }} {{ $customClass ?? ''}} {{env("APP_ENV")}}">
        @if ($amp)  
            @if (env("APP_ENV")=="producao")
                @if ($tabela->tipo == 1)      
                {{-- //PENDENCIA Anuncio AMP --}}
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
        @endif
        <div id="before"></div>
        <div id="app" class="corpo-da-pagina {{ $customThema ?? '' }} {{env("APP_ENV") ?? ""}}" >
            
            @include('front.includes.Topodosite', ["amp" => $amp, "page" => data_get($seo,"page","single")] )
            @yield('conteudo-view')
            @include('front.includes.Footer')
        </div>
        @yield('js-view')
    </body>
</html>