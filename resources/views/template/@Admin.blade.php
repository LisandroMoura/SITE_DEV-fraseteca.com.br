<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @if (env('ANALYTICS')) @include('templates/analytics') @endif
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">        
        <link rel="shortcut icon" href="{{env('FIVE_ICON')}}"/>
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/fiveicon/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href=" {{ asset('images/fiveicon/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href=" {{ asset('images/fiveicon/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href=" {{ asset('images/fiveicon/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href=" {{ asset('images/fiveicon/apple-icon-114x114.png')}}">
        <link rel="apple-touch-icon" sizes="120x120" href=" {{ asset('images/fiveicon/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href=" {{ asset('images/fiveicon/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href=" {{ asset('images/fiveicon/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href=" {{ asset('images/fiveicon/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"  href=" {{ asset('images/fiveicon/apple-icon-192x192.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href=" {{ asset('images/fiveicon/apple-icon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href=" {{ asset('images/fiveicon/apple-icon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href=" {{ asset('images/fiveicon/apple-icon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('images/fiveicon/manifest.json')}}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content=" {{ asset('images/fiveicon/apple-icon-144x144.png') }}">
        <meta name="theme-color" content="#ffffff">
        
        <link rel="stylesheet" scoped href="{{ asset('css/back_end_usuario.css')}}?ver={{env('VER')}}">                
        
        @yield('css-view')

        @yield('metadados') 
        

    </head>
    <body class=" site back-end {{$class ?? ''}}">
        @yield('conteudo-view')
        @yield('js-view')
    </body>
</html>