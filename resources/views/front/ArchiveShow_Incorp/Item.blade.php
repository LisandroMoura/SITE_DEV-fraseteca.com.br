@php    
    if (!isset($dados))        
        return ;
    if(!count($dados))
    return ;
@endphp
<div class="container container-full relacionadas-wrapper no-print">
    <ul class="relacionadas padrao_a">
        @foreach ($dados as $item)
            @php
                $capa = $item->thumb;
                if(trim($capa) ==="")                            
                    $capa = $item->capa;
                // if($capa=="" || $capa=="null") 
                //     $capa="/images/default/semcapa-v07.jpg";
                // else 

                $removeVer = explode("?",$capa); if($removeVer[0]) $capa = $removeVer[0];
                $path =\storage_path()."/app/public/usuarios/".str_replace('/storage/usuarios/','',$capa);if(!file_exists($path))$capa="/images/default/semcapa-v07.jpg";
            @endphp
            <li>
                <div class="imagem-zone">
                    @if ($amp)
                        <div class="box-amp-img"> 
                            <a href="/{{$item->urlamigavel}}" 
                                class="relacionadas-link-imagem-zone-amp " title="{{$item->titulo}}">
                                <amp-img
                                class="lazy-hidden"
                                src="{{$capa}}"
                                width="187"
                                height="151"
                                layout="responsive"
                                alt="Imagem de {{$item->titulo}}">
                                </amp-img>
                            </a>
                        </div>
                    @else
                        <a href="/{{$item->urlamigavel}}" 
                            class="relacionadas-link-imagem-zone" title="{{$item->titulo}}"
                            data-src="{{$capa}}"  
                            style="background-image:url({{$capa}})">
                        </a>
                    @endif
                </div>
                
                <div class="texto-zone  @if ($amp) amp @endif " >
                    <div class="table">
                        <div class="table-cell">
                            <a href="/{{$item->urlamigavel}}"  title="{{$item->titulo}}">
                                {{$item->titulo}}
                            </a>
                        </div>
                    </div>
                    
                </div>
            </li>

        @endforeach

        {{-- Fim item --}}
        
    </ul>
    
</div>