@php
    $logoFile="logo-v06.svg";
    // ● 23-ago-22: Projeto20220802 - Paginas AMP = corrigir o tamanho da imagem para não ter CLS
    $_width="150";
    $_height="33";
    if (!isset($logado)) $logado=false;
@endphp

@if ($amp) 
    <div class="logo">
        <a class="amp" href="{{env('APP_URL')}}">            
            <amp-img media="(min-width: 141px)" src="{{"/images/$logoFile"}}" width="{{$_width}}" height="{{$_height}}" layout="fixed" alt="logo do site"></amp-img>
        </a>
    </div> 
@else 
    <div class="logo">
        <a href="{{env('APP_URL')}}">
            <img data-src="{{"/images/$logoFile"}}?ver={{env('VER')}}" src="{{"/images/$logoFile"}}?ver={{env('VER')}}" width="{{$_width}}px" height="{{$_height}}px" class=" lazy-hidden__ {{ $customThema ?? '' }}logo-gif" alt="Logo do site">
        </a>
    </div>
@endif