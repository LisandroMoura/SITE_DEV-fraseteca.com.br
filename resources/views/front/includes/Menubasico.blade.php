@if ($amp)
    <amp-state id="myClass">
        <script type="application/json">
        "wrapper-antes-do-conteudo menu-basico"
        </script>
    </amp-state>
@endif
<!-- Navigation -->
<div class="wrapper-antes-do-conteudo menu-basico " 
    @if ($amp)
        [class]="myClass"        
    @endif
    >
    <div class="area-do-menu">            
        @if ($amp)
            <a class="fechar_menu abreMenu pointer"
                on="tap:AMP.setState({ myClass: 'wrapper-antes-do-conteudo menu-basico' })">            
                <amp-img media="(min-width: 18px)" src="{{asset("images/close_dark.png")}}" width="18" height="18" layout="fixed" alt="Fechar menu"></amp-img>
            </a>
        @else
            <a class="fechar_menu abreMenu pointer">                
                <img src="{{asset("images/close_dark.png")}}" alt="Fechar" width="18px" height="18px">
            </a>
        @endif          
        <div class="corpo-do-menu">
            <ul class="menu principal no-print">
                <li class="title">
                    <a href="{{env('APP_URL')}}/pages/top-listas">
                        Top Listas
                        @if ($amp)
                            <amp-img src="{{asset("images/diamante.png")}}" layout="fixed"  width="26" height="20"  alt="top listas"></amp-img>
                        @else
                            <img src="{{asset("images/diamante.png")}}" width="26px" height="20px" alt="top listas">
                        @endif
                        <span class="icone-foguinho"></span>
                    </a>
                </li>
                <li class="title ">
                    <a href="{{env('APP_URL')}}/sessao/frases-de-amor">Frases de Amor</a>
                </li>
                <li class="title ">
                    <a href="{{env('APP_URL')}}/sessao/frases-engracadas">Frases Engraçadas</a>
                </li> 
                <li class="title ">
                    <a href="{{env('APP_URL')}}/sessao/frases-para-status">Frases para Status</a>
                </li>
                <li class="title ">
                    <a href="{{env('APP_URL')}}/sessao/frases-para-fotos">Frases para Fotos</a>
                </li> 
                <li class="title ">
                    <a href="{{env('APP_URL')}}/sessao/frases-de-series">Frases de Series</a>
                </li> 
                <li class="title ">
                    <a href="{{env('APP_URL')}}/sessao/frases-de-motivacao">Frases de Motivação</a>
                </li>
            </ul>
            {{-- <div class="rodape_do_wrapper rodape_do_menu no-print">
                <a href="#" class="bt btn rodape-menu">
                    Ver todas
                </a>
            </div> --}}
        </div>
        <div class="menu-mobile-fechar abreMenu"></div> 
    </div> 	
</div>