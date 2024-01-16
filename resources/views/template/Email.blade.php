<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">                
        <meta name="msapplication-TileColor" content="#ffffff">        
        <meta name="theme-color" content="#ffffff">        
        
        @yield('css-view')

        <title>fraseteca | Email para você! </title>

        <style></style>    
        <meta name="robots" content="noindex,follow" /> 
    </head>
    <body  bgcolor="#f9f8f8" class="panel email" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="font-family:Calibri, Helvetica, Georgia, Times, serif; text-decoration: none;">
        <center>
            @yield('conteudo-view')
        </center>
        @yield('js-view')        
    </body>
</html>