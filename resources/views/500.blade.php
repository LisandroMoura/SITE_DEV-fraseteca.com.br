@extends('template.Front')
@section('css-view')
    @include('front.DefaultShow_Incorp.Assets', ['amp' => $amp ?? false])
@endsection
@section('custom-php')
    @php
        $logado = \Auth::user();
        $imgsrc = "/images/default/embaraco-v01.svg";
    @endphp
@endsection

@section('conteudo-view')
    <section class="margin-auto max-width-content conteudo--header--default">
        @include('front.includes.Img',[
            'amp' => false,
            'imgsrc' => $imgsrc,
            "layout"  => "responsive",
            'alt'    => "Imagem do site Fraseteca"
        ])
    </section>

    @php
        $message = $exception->getMessage();
        $message = str_replace("/home/ubuntu/repositorio/listafrases.projeto/fraseteca","",$message);
    @endphp 
    
    <section class="margin-auto max-width-content conteudo--default">
        <h1><span>Isso é embaraçoso...</span> </h1>
        <span> Tivemos um erro ao processar a sua solicitação. Por favor, tente novamente mais tarde.</span>   
            @if (isset($logado)) @if ($logado->perfil == "1") 
                <pre>
                    {{ $message }} 
                </pre> 
            @endif @endif

            <a href="/" class="botao-padrao red mt-20 ">Ir para home</a>
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
