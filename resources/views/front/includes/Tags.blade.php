@php     

    if (isset($tagposts)):        
        $dados=[];        
        foreach ($tagposts as $key => $tag) {            
            $jaEsta = false;

            if(isset($feed))
                foreach ($feed as $key => $FeedItem) {
                    if($FeedItem["origem_id"] ==$tag->id )
                        $jaEsta = true;
                }
            array_push($dados, [
                'id'            => $tag->id ?? 0,
                'urlamigavel'   => $tag->urlamigavel ?? "",
                'descricao'     => $tag->descricao ?? "" ,
                'disponivel'    => $tag->disponivel ?? "",
                'resumo'        => $tag->resumo ?? "",
                'jaesta'        => $jaEsta ? "ativado" : ""
            ]);         
        }

    endif;
    if (!isset($dados) || count($dados) == 0 ) return;    
@endphp
<div class="tags--wrapper no-print {{$classe ?? ""}}"> 
    {{-- <div class="tags--col--title only-mobile">Tags</div>     --}}
    <div class="tags {{$classe ?? ""}} no-print">  
        <ul class="tags--col list">
            @foreach ($dados as $key => $tag)
                <li><a href="/tag/{{$tag["urlamigavel"]}}" data-id="{{$tag["id"]}}" class="botao-tag {{$classeItem ?? ""}} {{$tag["jaesta"]}}" title="{{$tag['descricao']}}">{{$tag['descricao']}}</a></li>
            @endforeach
        </ul>
    </div>
</div>