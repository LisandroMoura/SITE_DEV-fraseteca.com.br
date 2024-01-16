@php
    //15-ago-22: LM SeoParam preloadImages
    $seoparam = [];
    if(isset($tabela->seoparam))
        $seoparam = explode(";", $tabela->seoparam);
    $preloadImages = false;
    if(isset($seoparam[2]))
        if($seoparam[2]=="true")
        $preloadImages = true;
    $momentolazy = $tabela->momentolazy ?? 2;
    $contador=0;
@endphp
@if ($preloadImages)
    @foreach ($itens as $item)
        @php
        $contador++;
        if($contador >$momentolazy )
            return;
        @endphp
        <link rel="preload" as="image" href="{{ $item->capa }}">
    @endforeach   
@endif
