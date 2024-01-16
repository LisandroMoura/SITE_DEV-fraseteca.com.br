@extends('template.Paineluser')
@section('css-view')
    @include('front.FeedShow_Incorp.Assets', ['amp' => $amp])
@endsection
@section('custom-php')
    @php
        $mobile = false ; //isMobile($options ?? null)  ● Projeto20221201  = desativar a função em view isMobile() ;
        $customThema = $logado ? $logado->thema : '';
        $customClass = 'single-frase';
        $arrpastas = $logado ? $logado->pastas()->all() : [];
        $pageType = 'archive';
        $titulo = $titulo ?? null;
        if(!$titulo)
            $titulo = isset($tabela) ? (property_exists($tabela,"titulo") ? $tabela->titulo : null) : null;
        if(!$titulo)
            $titulo = data_get($seo, 'titulo', "Fraseteca");
        //custons
        // use App\Entities\Midia;
        // use App\Entities\Usuario;
        use App\Services\TimeAgo;
        $timeAgo = new TimeAgo;
        $classAtiva=null;
        $listasClass=""; $seguidoresClass=""; $seguindoClass="";
        function uniqueInArray($arr, $key){        
            $temp_array = array();
            $i          = 0;
            $key_array  = array();
            foreach($arr as $val) {
                if (!in_array($val[$key], $key_array)) {
                    $key_array[$i] = $val[$key];
                    $temp_array[$i] = $val;
                }
                $i++;
            }
            return $temp_array;
        }
        //embaralhar os itens
        function cmp($a, $b){
            return strcmp($b["post_tempo"], $a["post_tempo"]);
        }    
        usort($feed, "cmp");
        $dados1 = $feed;
        $dados2 = uniqueInArray($dados1, "frase_id");
    @endphp
@endsection

@section('conteudo-view')
    <section class="margin-auto full-width-content conteudo--header--painel">
        <div class="margin-auto max-width-content conteudo--header--painel--item">
            <h1 itemprop="name" class="titulo">
                {{ $titulo }}
            </h1><span itemprop="headline" style="display:none;">{{ $titulo }}</span>
        </div>
    </section>

    <section class="margin-auto max-width-content conteudo--feed">
        @if (count($dados2))
            @foreach ($dados2 as $item)
                @if ($item["tipo"]=="tag")
                    @include ('front.FeedShow_Incorp.Itemtag')
                @else 
                    @include ('front.FeedShow_Incorp.Itemusuario')
                @endif
            @endforeach
        @else 
            @include ('front.LoginShow_Incorp.Preferencias')
        @endif
    </section>

@endsection
@section('js-view')
    <script src="{{ asset('js/FeedShow.js') }}?ver={{ env('VER') }}"></script>
@endsection
