<!doctype html>
@php
    $amp = false;
@endphp
@if (!$amp) <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> @else <html amp lang="{{ str_replace('_', '-', app()->getLocale()) }}"> @endif
    <head>        
        @if (env("APP_ENV")=="producao" ||env("APP_ENV")=="homolog" )
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=G-V66X552YG6"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());

                gtag('config', 'G-V66X552YG6');
            </script>
        @endif
        @php   
            $seo            = $seo ?? []; 
            $titulo         = data_get($seo,"titulo","Fraseteca");
            $resumo         = data_get($seo,"resumo","Fraseteca, sua biblioteca de Frases");
            $canonical      = data_get($seo,"canonical","https://fraseteca.com.br");
            $robots         = data_get($seo,"robots","no-index, no-follow");
            $image          = data_get($seo,"image","https://fraseteca.com.br/images/logo-v06.svg");
            $imagewidth     = data_get($seo,"image_width","134");
            $imageheight    = data_get($seo,"image_height","'32");
            $publishedtime  = data_get($seo,"published_time","2019-08-09T08:00:00+08:00");
            $modifiedtime   = data_get($seo,"modified_time","2019-08-09T08:00:00+08:00");     
            $route = null;
            
        @endphp
        <meta name="csrf-token" content="{{ csrf_token() }}"> 
        
        <link rel="shortcut icon" href="{{env('FIVE_ICON')}}"/>

        @include("front.includes.Fonteprincipal" ,["ambiente" => env("APP_ENV")])
        
        @yield('css-view')
        @yield('custom-php')

    </head>
    
    <body itemscope itemtype="http://schema.org/WebPage" class="{{ $customThema ?? '' }} {{ $customClass ?? ''}} {{env("APP_ENV")}}">
        <div id="before"></div>
        <div id="app" class="corpo-da-pagina {{ $customThema ?? '' }} {{env("APP_ENV") ?? ""}}" >
            
            @include('front.includes.Retorno',["amp" => false])
            @include('front.includes.Topodosite', ["amp" => $amp])
            
            @yield('conteudo-view')
            @include('front.includes.Footer')
            
        </div>
        @yield('js-view')
    </body>
</html>