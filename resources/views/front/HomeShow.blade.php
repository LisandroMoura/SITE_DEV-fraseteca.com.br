@extends('template.Front')
@section('css-view')
    @include('front.HomeShow_Incorp.Assets', ['amp' => $amp])
@endsection

@section('custom-php')
    
    @php
        $customThema    = $logado ? $logado->thema : '';
        $customClass    = 'home';
        $arrpastas      = $logado ? $logado->pastas()->all() : [];
        //custons
    @endphp


    {{-- <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6159622292805097" crossorigin="anonymous"></script> --}}
@endsection

@section('conteudo-view')

    {{-- BANNER DO TOPO --}}
    @if (!isset($logado))
        <section class="margin-auto max-width-content">
            <div class="banner--principal">
                <div class="banner--principal--middle">
                    <div class="banner--principal--imagem mb-20">
                        <img src="{{asset("/images/home/banner-home-v03.png")}}" alt="CRIE A SUA PRÓPRIA BIBILIOTECA DE FRASES:)">
                    </div>
                    <div class="banner--principal--txt">
                        <h3>Crie sua <br> biblioteca de frases                                        
                        </h3>
                        <div class="banner--principal--txtlabel mb-40">
                            <span>Faça o seu perfil agora, é rápido e grátis</span>
                            
                            <img src="{{asset("/images/home/sorriso-inclinado.png")}}" alt="Faça o seu perfil agora, é rápido e grátis :)">
                        </div>
                    </div>
                </div>     
            </div>
            <a href="/registrar/newuser" class="botao-callaction max-content pd-2030" title="Quero sim!">Quero!</a>                       
        </section>
    @endif

    {{-- CONTEUDO --}}

    <section class="margin-auto max-width-content mt-40">
        <h3>Bibliotecas Tops</h3>
        @include('front.includes.Relacionados', [
            "amp" => $amp,
            "posts" => [],
            'temPontuacao'=> true,
            'id_ul'  => "toplistas",
            "classe" => "bibliotecas",
            'desligaLazy' => true,
            "postrel" => $toplistas
        ])
    </section>
    
    <section class="margin-auto max-width-content mt-50 mb-50">
        <h3>Top Usuários</h3>
        @include('front.includes.Relacionados', [
            "amp" => $amp,
            "posts" => [],
            "classe" => "rolldafama",
            'temPontuacao'=> true,
            'id_ul'  => "rolldafama",
            'desligaLazy' => true,
            "postrel" => $rolldafama["dados"]
        ])
    </section>

    <section class="margin-auto max-width-content mt-50 mb-50">
        <h3>Últimas Bibliotecas</h3>
        @include('front.includes.Relacionados', [
            "amp" => $amp,
            "posts" => [],
            'id_ul'  => "ultimas",
            'desligaLazy' => true,
            "classe" => "bibliotecas",
            "postrel" => $ultimas
        ])
    </section>
    
    <section class="margin-auto max-width-content mt-50 mb-50">
        <h3>Top Tags</h3>
        @include('front.includes.Tags',[
            "tagposts" => $tagsMaisAcessadas,
            "classe"    => "no-grid",
            "semTitulo" => true,
        ])
    </section>
    <div class="demarcador-marca no-print"></div>
@endsection

@section('js-view')

    @if (!$amp)
        @if (isset($logado))
            <script src="{{ asset('js/HomeShow.js') }}?ver={{ env('VER') }}"></script>
        @else
            <form ref="call_login" class="form-box" action="/login" method="GET">
                @php $rand = rand(0,9); @endphp
                <input type="hidden" name="token_reverso" value="l{{ $rand }}{{ $idpost ?? 0 }}">
                <button type="submit" class="ref_call_login hidden">Login</button>
            </form>
            <script src="{{ asset('js/HomeShow__nolog.js') }}?ver={{ env('VER') }}"></script>
        @endif
    @endif

@endsection
