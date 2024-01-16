@extends('template.Paineluser')
@section('css-view')
    @include('front.PastaList_Incorp.Assets', ['amp' => $amp])
@endsection
@section('custom-php')
    @include('front.includes.Mobiletest')
    @php
        $mobile = false ; //isMobile($options ?? null)  ● Projeto20221201  = desativar a função em view isMobile() ;
        $customThema = $logado ? $logado->thema : '';
        $customClass = 'single-frase';
        $arrpastas = $logado ? $logado->pastas()->all() : [];
        $pageType = 'pastas';
        $titulo = $titulo ?? null;
        if(!$titulo)
            $titulo = isset($tabela) ? (property_exists($tabela,"titulo") ? $tabela->titulo : null) : null;
        if(!$titulo)
            $titulo = data_get($seo, 'titulo', "Fraseteca");
        //custons
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

    <section class="margin-auto max-width-content conteudo--pasta--list">
        @include('front.PastaList_Incorp.Item', [
        "amp" => false,
        "accordion" => "listas",
        "classUl"   => "pasta--list", 
        "title_funy" => "Haaaa que pena, você ainda não criou nenhuma pasta!",
        "description" => 'Mas não seja por isso. Que tal criar uma pasta agora?',
        "link_description" => "/pastas/create",
        "tipo" => "pastas minhas-pastas",
        "dados" => $pastas,
        "lastPage" => 3
        ])
    </section>

@endsection
@section('js-view')
    <script src="{{ asset('js/PastaList.js') }}?ver={{ env('VER') }}"></script>
@endsection
