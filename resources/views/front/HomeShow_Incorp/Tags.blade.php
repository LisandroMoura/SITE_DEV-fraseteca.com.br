@php     
    if (isset($tagPosts)):        
        $dados=[];        
        foreach ($tagPosts as $key => $tag) {            
            $jaEsta = false;

            if(isset($feed))
            foreach ($feed as $key => $FeedItem) {
                if($FeedItem->origem_id ==$tag->id )
                    $jaEsta = true;
            }
            
            array_push($dados, [
                'id'            => $tag->id,
                'urlamigavel'   => $tag->urlamigavel,
                'descricao'     => $tag->descricao,
                'disponivel'    => $tag->disponivel,
                'resumo'        => $tag->resumo,
                'jaesta'        => $jaEsta ? "jaesta" : ""
            ]);         
        }

    endif;
    if (!isset($dados) || count($dados) == 0 ) return;    
@endphp
<div class="container categorias-wrapper no-print {{$classe ?? ""}}">    
    @if (!isset($semTitulo))
        <div class="row">
            <div class="col">
                <div class="titulo-categorias">                                                            
                    <h2 class="titulo titulo-com-icone no-print">{{$nome ?? "Este usuário"}} também está seguindo:</h2>
                </div>  
            </div>
        </div>        
    @endif
    
    <div class="row categorias no-print">
        <div class="col">
            <ul>
                @foreach ($dados as $key => $tag)
                    <li>
                        <a href="/tag/{{$tag["urlamigavel"]}}" data-id="{{$tag["id"]}}" class="btn box tag-item {{$tag["jaesta"]}}" title="{{$tag['descricao']}}">
                            {{$tag['descricao']}}
                        </a>                                        
                    </li>
                @endforeach                

            </ul>
        </div>
    </div>  
</div>