@php
    
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Newimg.blade.php
     * Autor: LM
     * Objetivo: Uma das mais importantes template de imagem do sistema.
     * Doc: hhttps://docs.google.com/document/d/1VtfvGG33YdyivV2Qbk5KjVLL4vwWaihky8n84ehJJWA/edit#
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     * ● Projeto20220802 - ● LazyLoad das imagens iniciais
     *     >> 22-08-22 - Providenciar o LazyLoad das imagens iniciais
     * ● Projeto2023Jan06 - ● A volta da tag IMG:
     *     >> 13-01-23 - Inclusão da nova tag IMg
     *     >> 13-01-23 - Inclusão da propriedade html fetchpriority ver documentação:(https://web.dev/priority-hints/)
     *     >> 17-01-23 - Retirar o parametro fetchpriority para a tag amp-img (não existe esse parâmetro para esta tag)
     *   ● Projeto2023Fev01 - Problema de LCP: mais de 2,5s (dispositivos móveis) - Dia 18/02
     *    >> 20-02-23 - inclusão do parâmetro data-hero na imagem -na tentativa de melhorar o cls de páginas amp
     *                  doc: https://blog.amp.dev/2021/03/23/optimizing-your-amp-page-experience-for-core-web-vitals/
     *   ● Projeto2023Mar01 - Melhorando o CLS em Amp page
     *    >> 10-03-23 - Criar a lógica do Pulo de 3 imagens das frases em caso de página AMP
     *--------------------------------------------------------------------------------------------------------------*/
    if (!$imgsrc) {
        return;
    }
    $validateImag = $validateImag ?? true;
    $amp = $amp ?? false;
    $width = $width ?? 'auto';
    $height = $height ?? 'auto';
    $lazyLoad = $lazyLoad ?? false;
    $fetchpriority = $fetchpriority ?? false;
    $contFrases  = $contFrases ?? 0;
    $validadeLCPAmp = $validadeLCPAmp ?? false;
    
@endphp
@if ($amp)

    @if ($validadeLCPAmp)
        @if ($contFrases > 3 )
            <div class="box-image-amp margin-auto mb-30" >
                <amp-img media="{{ $media ?? '(min-width: 1px)' }}" @if ($fetchpriority) data-hero @endif src="{{ $imgsrc }}" width="{{ $width }}"
                    height="{{ $height }}" layout="responsive" alt="{{ $alt ?? 'imagem de capa' }}"></amp-img>
            </div>        
        @endif

    @else 
        <div class="box-image-amp margin-auto mb-30" >
            <amp-img media="{{ $media ?? '(min-width: 1px)' }}" @if ($fetchpriority) data-hero @endif src="{{ $imgsrc }}" width="{{ $width }}"
                height="{{ $height }}" layout="responsive" alt="{{ $alt ?? 'imagem de capa' }}"></amp-img>
        </div>
        
    @endif
    
@else
    @if ($lazyLoad)
        <img class="phrase-image margin-auto {{ $class ?? '' }}  imagem-post lazy-hidden" data-src="{{ $imgsrc }}"
            alt="{{ $alt ?? 'imagem de capa' }}" width="{{ $width ?? 'auto' }}" height="{{ $height ?? 'auto' }}"
            data-srcset="{{ $imgsrc }} 612w " @if ($fetchpriority) fetchpriority="high" @endif>
    @else
        <img class="phrase-image margin-auto {{ $class ?? '' }}" src="{{ $imgsrc }}"
            alt="{{ $alt ?? 'imagem de capa' }}" width="{{ $width ?? 'auto' }}" height="{{ $height ?? 'auto' }}"
            @if ($fetchpriority) fetchpriority="high" @endif>
    @endif
@endif
