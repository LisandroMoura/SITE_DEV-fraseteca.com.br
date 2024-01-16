@php
    // Projeto20221201 - Nova Tag de imagem dentro do sistema.
    if (!$imgsrc) return ;
        $width      = $width ?? "auto";
        $height     = $height ?? "auto";

        $lazyLoad   = $lazyLoad ?? false;
        $dimensoes  = $dimensoes ?? "";  //receber via parametro
        $download   = $download  ?? $imgsrc; //receber via parametro
        $mobile     = $mobile ?? $imgsrc; //receber via parametro
        $sizes = "(max-width: 480px) 346px, (max-width: 611px) 100vw, (min-width: 612px) 612px";
        
@endphp

    <picture class="flex margin-auto imagem-post {{ $class ?? "" }} " style="display: flex;flex-direction: column;align-items: center;margin-bottom: 29px;">
        <source 
            type="image/webp" 
            @if ($lazyLoad) 
                data-srcset="{{ $imgsrc }} 612w " 
            @else 
                srcset="{{ $imgsrc }} 612w " 
            @endif
            sizes="{{ $sizes }}"
            class="@if ($lazyLoad) lazy-hidden @endif"
        >
        <img 
            class="{{ $class ?? "" }}  @if ($lazyLoad) imagem-post lazy-hidden @endif" 
            width="{{ $width }}" height="{{ $height }}" 
            @if (!$lazyLoad) src="{{ $download }} "  srcset=" {{ $download }} 612w  "  @endif
            alt="{{ $alt ?? "imagem de capa" }}" 
            data-src="{{ $download }}" 
            sizes="(max-width: {{ $width }} ) 100vw, {{ $width }}"
        >
    </picture>
