@php
    
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Img.blade.php
     * Autor: LM
     * Objetivo: Uma das mais importantes template de imagem do sistema.
     * Doc: hhttps://docs.google.com/document/d/1VtfvGG33YdyivV2Qbk5KjVLL4vwWaihky8n84ehJJWA/edit#
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     * ● Projeto2023Jan04 - 
     *  ● Projeto2023Jan04 - Imagens em AMP distorcidas
 *     >> 03-01-23 - Para páginas AMP, o height das imagens do tipo Chapadas, ou seja
     *--------------------------------------------------------------------------------------------------------------*/
    
    if (!$imgsrc) {
        return;
    }
    $validateImag = $validateImag ?? true;
    $amp = $amp ?? false;
    $width = $width ?? 'auto';
    $height = $height ?? 'auto';
    $lazyLoad = $lazyLoad ?? false;
    
    if ($validateImag) {
        if (!@getimagesize(env('APP_URL') . $imgsrc)) {
            return;
        }
        $arrImagem = @getimagesize(env('APP_URL') . $imgsrc) ?? getimagesize(env('APP_URL') . $imgsrc) ? getimagesize(env('APP_URL') . $imgsrc) : [];
        if (count($arrImagem)) {
            $width = $arrImagem[0] ?? 'auto';
            $height = $arrImagem[1] ?? 'auto';
        }
    }
@endphp
@if ($amp)
    <div class="box-image-amp margin-auto mb-30" style="width:{{ $width }}px">
        <amp-img media="{{ $media ?? '(min-width: 1px)' }}" src="{{ $imgsrc }}" width="{{ $width }}"
            height="{{ $height }}" layout="{{ $layout ?? 'fixed' }}" alt="{{ $alt ?? 'imagem de capa' }}"></amp-img>
    </div>
@else
    {{-- // ● 22-ago-22 LM Projeto20220802 - LazyLoad das imagens iniciais --}}
    @if ($lazyLoad)
        <img class="margin-auto {{ $class ?? '' }}  imagem-post lazy-hidden" data-src="{{ $imgsrc }}"
            alt="{{ $alt ?? 'imagem de capa' }}" width="{{ $width ?? 'auto' }}" height="{{ $height ?? 'auto' }}">
    @else
        <img class="margin-auto {{ $class ?? '' }}" src="{{ $imgsrc }}" alt="{{ $alt ?? 'imagem de capa' }}"
            width="{{ $width ?? 'auto' }}" height="{{ $height ?? 'auto' }}">
    @endif
@endif
