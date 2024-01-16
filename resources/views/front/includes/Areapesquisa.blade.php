<div class="wrapper-pesquisa-lateral-hidden">
    <div class="topo_do_wrapper topo_da_pesquisa">
        <a href="#close" class="botao_fechar fechar_pesquisa">X</a>
    </div>
    <div class="barra-de-pesquisa-campo animes">
        <div class="area-da-pesquisa">
            <div class="corpo-da-pesquisa">
                
                <form name="form_search" id="form-search" action="{{route("pesquisa",'termo')}}" method="get" class="animes">
                    <label class="bt-action-search">Buscar</label>
                    <input type="hidden" name="page" id="page" value="0">
                    <input type="text" name="pesquisar" id="pesquisar" placeholder="O que você procura?" value="{{old("pesquisar")}}" class="fa fa-search pesquisa bordas-forms hasPlaceholder mobile">
                    <button type="submit" class="bt-pesquisar">
                        <i class="icone-pesquisa icon-search"></i>
                    </button>
                </form>
            </div>
            <div class="menu-mobile-fechar abrePesquisa" v-on:click.stop.prevent="abrePesquisa"></div>
        </div>
    </div>
</div>