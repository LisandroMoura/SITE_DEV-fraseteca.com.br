<!-- Navigation -->
<div class="wrapper-menu-lateral-hidden" v-bind:class="labreMenu">
    <div class="area-do-menu">
        <a class="fechar_menu abreMenu pointer"  
        v-on:click.stop.prevent="abreMenu"
        >X</a>  
        <div class="corpo-do-menu">
            <div class="topo_do_wrapper topo_do_menu">
                <h2>Categorias</h2>                

            </div>
            <ul class="menu principal no-print">
                <li class="title">
                    <a href="{{env('APP_URL')}}/pages/top-listas">
                        Top Listas
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
        <div class="menu-mobile-fechar abreMenu"
        v-on:click.stop.prevent="abreMenu"
        ></div> 
    </div> 	
</div>