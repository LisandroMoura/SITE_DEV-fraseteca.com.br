@php
    
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Relacionados.blade.php
     * Autor: LM
     * Objetivo: View responsável por escrever o Html das bibliotecas relacionadas à publicação. Responsável por trazer
     *           os thumbnails das Bibliotecas em várias partes do sistema.
     * Doc: https://docs.google.com/document/d/1RcbpJ42nBitXQQVDohH_a7o7Ncu_-lmK6odwnT_eHFw/edit#
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *  ● Projeto2023Jan01 - Imagens quebradas em LazyLoad
     *     >> 01-01-23 - inserido data-srcset na tag img
     *
     *--------------------------------------------------------------------------------------------------------------*/
    
    $id_ul = $id_ul ?? 'relacionados';
    $classe = $classe ?? '';
    $dados = $postrel ?? [];
    $pontuacao = 0;
    $semTitulo = $semTitulo ?? null;
    $width = '191px';
    $height = '130px';
    
    if ($classe == 'rolldafama') {
        $width = '152px';
        $height = '152px';
    }
    $classLazy = 'lazy-hidden';


    $desligaLazy = $desligaLazy ?? false;

    if($desligaLazy)
        $classLazy = '';
@endphp
@if (isset($withTitulo))
    <h3 class="sub-titulos {{ $icone ?? '' }} {{ $classe ?? '' }}">
        @if (isset($icone))
            <i class="ico ico-clipse"></i>
        @endif
        @if (!$semTitulo)
            <span>{{ $txtTitulo ?? 'Quem teve por aqui também gostou:' }}</span>
        @endif
    </h3>
@endif
<ul id="{{ $id_ul }}" class="relacionados {{ $classe ?? 'default    ' }}">
    @foreach ($dados as $item)
        @php
            if (isset($temPontuacao)) {
                $pontuacao++;
            }
            
            $capa = isset($item->thumb) ? $item->thumb : '';
            if (trim($capa) === '') {
                $capa = isset($item->capa) ? $item->capa : '';
            }
            
            //tratativa para capa do unsplash
            $temUnsplash = explode('images.unsplash.com', $capa);
            if (count($temUnsplash) == 0) {
                $path = \storage_path() . '/app/public/usuarios/' . str_replace('/storage/usuarios/', '', $capa);
                if (!file_exists($path)) {
                    $capa = '/images/default/semcapa-v07.jpg';
                }
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
                        {{-- <amp-img class="lazy-hidden" src="{{ $capa }}" width="{{ $width }}"
                            height="{{ $height }}" layout="responsive" alt="{{ $item->titulo }}"></amp-img> --}}
                        @if (isset($temPontuacao))
                            <span class="bolinha-curtidas">{{ $pontuacao }}º</span>
                        @endif
                    </a>
                @else
                    {{-- pendencia: falta a classe lazy-hidden --}}
                    <a href="/{{ $item->urlamigavel }}" title="{{ $item->titulo }}">
                        <img @if ($classLazy == '') src="{{ $capa }}" @else data-srcset="{{ $capa }}" @endif
                            alt="{{ $item->titulo }}" width="{{ $width }}" height="{{ $height }}"
                            class="imagem-post {{ $classLazy }} no-print">
                    </a>
                    @if (isset($temPontuacao))
                        <span class="bolinha-curtidas">{{ $pontuacao }}º</span>
                    @endif
                @endif
            </div>
            <div class="relacionados--texto">
                <h3>
                    <a href="/{{ $item->urlamigavel }}" title="{{ $item->titulo }}"> 
                        <strong>
                            {{ $item->titulo }}
                        </strong>
                    </a>
                </h3>
            </div>
        </li>
    @endforeach
    {{-- Fim item --}}


</ul>
@if ($id_ul == 'ultimas')
    <div class="wrapper-loadMaisListas">
        <a href="{{ env('APP_URL') }}?page=2" data-pageatual="1" data-canonical="{{ env('APP_URL') }}" rel="no-follow"
            alt="quero ver mais listas de frases" class="enable botao-padrao full" id="btLoadMore">Carregar mais
            frases</a>
    </div>
@endif
