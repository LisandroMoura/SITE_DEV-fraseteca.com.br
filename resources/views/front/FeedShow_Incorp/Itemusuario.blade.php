<div class="feed--item feed-box usuario">
    <div class="feed--item--header usuario">

        <div class="biografia--perfil--col--avatar">
            <a href="/{{$item['urlUsuario']}}" title="Perfil de {{$item['nomeUsuario']}}">
                <img class="_lazy-hidden avatar perfil"  src="{{ $item['avatar'] }}" width="153" height="153"  alt="Perfil de {{$item['nomeUsuario']}}">
            </a>
        </div>

        <div class="biografia--col--conteudo--texto-autor">
            <a itemprop="author" href="/{{$item['urlUsuario']}}" title="Perfil de {{$item['nomeUsuario']}}">
                {{$item['nomeUsuario']}}</a>
            @if (isset($item["conquista"]["nome"]))
                <i class="ico ico-selo"></i>
            @endif
            <span class="data-normal"> {{$timeAgo->run($item['post_tempo']) ?? ""}}</span>
        </div>

    </div>
    <div class="feed--item--body">
        <a href="{{$item["post_urlamigavel"]}}" class="link-imagem-post-wrapper">
            <img class="_lazy-hidden"  width="192px" height="130px" src="{{$item["post_capa"]}}" width="153" height="153"  alt="{{$item['post_titulo']}}">
        </a>
        <div class="texto-zone ">
            <a href="{{$item["post_urlamigavel"]}}" class="link-">
                <h4>{{$item["post_titulo"]}}</h4>
            </a>
        </div>
    </div>
</div>