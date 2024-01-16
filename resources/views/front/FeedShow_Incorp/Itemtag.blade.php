@php
    
@endphp

<div class="feed--item feed-box tag">
    <div class="feed--item--header tag">
        <div class="biografia--col--conteudo--texto-autor">
            <a itemprop="author" href="/tag/{{$item['tag_url']}}" title="Você está seguindo a tag: {{$item['tag_descricao']}}">
                {{$item['tag_descricao']}}</a>
            <span class="data-normal"> {{$timeAgo->run($item['post_tempo']) ?? ""}}</span>
            <a href="{{$item['post_urlamigavel']}}" title="{{$item['post_titulo']}}"> ... </a>
        </div>

    </div>
    <div class="feed--item--body">
        <div class="feed--item--body--imagem">
            <a href="{{$item["frase_url"]}}" class="link-imagem-post-wrapper">
                <img src="{{ $item["frase_capa"] }}" 
                alt="{{ $item["frase"] }}" 
                class="imagem-post _lazy-hidden no-print">
            </a>
        </div>
        {{-- <div class="texto-zone ">
            <a href="{{$item["urlamigavel"]}}" class="link-">
                <h4>{{$item["titulo"]}}</h4>
            </a>
        </div> --}}
    </div>
</div>