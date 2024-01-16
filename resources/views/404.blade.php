@extends('template.Front')
@section('css-view')
    @include('front.DefaultShow_Incorp.Assets', ['amp' => $amp ?? false])
@endsection
@section('custom-php')
    @php
        $logado = \Auth::user();
        $imgsrc = "/images/default/sos.svg";
    @endphp
@endsection

@section('conteudo-view')
    <section class="margin-auto max-width-content conteudo--header--default">
        @include('front.includes.Img',[
            'amp' => false,
            'imgsrc' => $imgsrc,
            "layout"  => "responsive",
            'alt'    => "Imagem do site Fraseteca",
            'validateImag' => false
        ])
    </section>
    
    <section class="margin-auto  max-width-content  conteudo--default">
        <h1><span>S.O.S 404</span> Página não encontrada</h1>
        <span> Aqui nós não encontramos nada. Esta página está vazia ou foi deletada. </span>    
    </section>
    <div class="demarcador-marca no-print"></div>
@endsection
@section('js-view')
    @if (isset($logado))
        <script src="{{ asset('js/DefaultShow.js') }}?ver={{ env('VER') }}"></script>
    @else
        <script src="{{ asset('js/DefaultShow__nolog.js') }}?ver={{ env('VER') }}"></script>
    @endif
@endsection
