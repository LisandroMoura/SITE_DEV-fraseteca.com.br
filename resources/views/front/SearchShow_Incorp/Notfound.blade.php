@php
    // $logado = \Auth::user();
    $imgsrc = "/images/default/sos.svg";
@endphp

<section class="margin-auto max-width-content conteudo--header--default not-found">
    @include('front.includes.Img',[
        'amp' => false,
        'imgsrc' => $imgsrc,
        "layout"  => "responsive",
        'alt'    => "Imagem do site Fraseteca",
        'validateImag' => false
    ])
</section>
<section class="margin-auto  max-width-content  conteudo--default not-found">
    <h1><strong>S.O.S 404</strong> Página não encontrada</h1>
    <span>  Não encontramos nenhuma {{$tipo}} com o termo: "<strong>{{$query}}</strong>". Tente buscar por outra palavra. </span>    
</section>