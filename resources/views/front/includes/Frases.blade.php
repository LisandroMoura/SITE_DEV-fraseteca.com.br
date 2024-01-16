@php

$id_ul = $id_ul ?? 'relacionados';
$classe = $classe ?? '';
$dados = $postrel ?? [];
$pontuacao = 0;
$semTitulo = $semTitulo ?? null;

$width = '600px';
$height = '600px';

if($classe == "rolldafama"){
    $width = '152px';
    $height = '152px';
}

@endphp
@if (isset($withTitulo))
    <h3 class="sub-titulos {{ $icone ?? '' }}">
        @if (isset($icone))
            <i class="ico ico-clipse"></i>
        @endif
        @if (!$semTitulo)
            <span>{{ $txtTitulo ?? 'Quem teve por aqui também gostou:' }}</span>
        @endif
    </h3>
@endif
<ul id="{{ $id_ul }}" class="frases {{ $classe ?? 'default    ' }}">
    @foreach ($dados as $item)
        @php
            if (isset($temPontuacao)) {
                $pontuacao++;
            }
            
            $capa = isset($item->thumb) ? $item->thumb : '';
            if (trim($capa) === '') {
                $capa = isset($item->capa) ? $item->capa : '';
            }

            $path = \storage_path() . '/app/public/frases/' . str_replace('/storage/frases/', '', $capa);


            if (!file_exists($path)) {
                $capa = '/images/default/semcapa-v07.jpg';
            }
            if ($classe == 'rolldafama') {
                $capa = $item->getAvatarAttribute();
        
                $item->titulo = $item->nome_completo;
                $item->urlamigavel = 'perfil' . '/' . $item->name . '.' . $item->id;
            }
        @endphp
        <li>
            <div class="relacionados--imagens">
                @if ($amp)
                    <a href="/{{ $item->urlamigavel }}" title="{{ $item->titulo }}">
                        <amp-img class="lazy-hidden" src="{{ $capa }}" width="{{ $width }}"
                            height="{{ $height }}" layout="responsive" alt="{{ $item->titulo }}"></amp-img>
                        @if (isset($temPontuacao))
                            <span class="bolinha-curtidas">{{ $pontuacao }}º</span>
                        @endif
                    </a>
                @else
                    <a href="/{{ $item->urlamigavel }}" title="{{ $item->titulo }}">
                        <img src="{{ $capa }}" alt="{{ $item->titulo }}">
                    </a>
                    @if (isset($temPontuacao))
                        <span class="bolinha-curtidas">{{ $pontuacao }}º</span>
                    @endif
                @endif
            </div>
            <div class="relacionados--texto">
                <a href="/{{ $item->urlamigavel }}" title="{{ $item->titulo }}"> {{ $item->titulo }}</a>
            </div>
        </li>
    @endforeach
    {{-- Fim item --}}


</ul>
@if ($id_ul == 'ultimas')
    <div class="wrapper-loadMaisListas">
        <a href="{{ env('APP_URL') }}?page=2" data-pageatual="1" data-canonical="{{ env('APP_URL') }}" rel="no-follow"
            alt="quero ver mais listas de frases" class="enable botao-padrao full" id="btLoadMore">Carregar mais frases</a>
    </div>
@endif
