<header class="header grid max-width-content ">

    {{-- <div class="header--side--a">
        <div class="logo">
            <a href="https://fraseteca.com.br/">
                <img src="/images/logo-v06.svg" width="150px" height="33px" class=" lazy-hidden logo-gif" alt="Logo do site">
            </a>
        </div>
    </div> --}}
    <div class="header--side--a" > @include('front.includes.Logo',["amp" => $amp,"logado" => $logado ?? null]) </div>
    <div class="header--side--b" > @include('front.includes.Headerpesquisa',["amp" => $amp,"view" => 'desk']) </div>
    
   
    <div class="header--side--c" > @include('front.includes.Menu',["amp" => $amp,"logado" => $logado ?? null,"view" => 'desk'])</div> 
</header>

{{-- @php echo "Front - teste 5.1 Topo do site se os itens  " ; return ;@endphp --}}

@php
    $marca = true;
    if(isset($page)):
        if($page == "homepage")
            if(!$logado){
                    $marca = false;
            }
    endif;
@endphp
@if ($marca)
    <div class="demarcador-marca no-mobile no-print"></div> 
@endif