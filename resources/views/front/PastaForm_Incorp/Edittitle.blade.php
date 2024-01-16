<div class="margin-auto max-width-content conteudo--header--painel--item">
    <header class="painel--header--edit">

        {{-- Primeira coluna o titulo --}}
        <div class="tittle--warpper ">
            <h1 data-id="titulo" title="Clique para editar o título da sua pasta"
                class="magic-input-selector titulo withIcon editar">{{ $titulo }}</h1>
                
            <span class="ico ico-lapis bt-toggle-titulo titulo no-interact" data-id="titulo"></span>
            @include('front.includes.formulario.Inputmagic', [
                'input' => 'titulo',
                'vmodel' => 'titulo',
                'class' => 'magic-input-titulo titulo com-botoes-magic-out',
                'value' => $titulo ? $titulo : null,
                'placeholder' => 'Ex: frases que ameiiii no site: fraseteca',
                'validator' => true,
                'msgValidator' => isset($msgValidatorArr['nome_completo'])
                    ? $msgValidatorArr['nome_completo']
                    : null,
            ])
        </div>

        {{-- Segunda coluna o os botões de confimação de ok nao ok --}}
        <div class="coluna-botoes-magic-out to-show-in-edit {{ $action }}">
            <div class="botoes-magic-out">
                <a class="magic-buttons bt-confirm-magic out" data-target="titulo" id="bt-confirm-magic-titulo">ok</a>
                <a class="magic-buttons bt-cancel-magic out" data-target="titulo" id="bt-cancel-magic-titulo"><span class="ico ico-exit"></span></a>
            </div>
        </div>

        {{-- Terceira coluna - as configurações da pasta e o bt excluir --}}
        <div class="botoes-form-wrapper to-hide-in-edit {{ $action }}">
            <ul class="botoes-form ">
                {{-- configurações de viewPasta --}}
                <li>
                    <a href="#" title="{{ $tituloViewPasta }} - {{ $subTituloViewPasta }}" id="bt-modo-de-edicao"
                        class=" botoes-form-item view-pasta {{ $statusViewpasta }}">
                        <i class="ico ico-pasta-privada"></i>
                    </a>
                </li>
                <li>
                    <a href="#" class="item-menu-config deletar confirmaExcluir" title="Após excluído, o registro não poderá ser restaurado" >
                        <i class="ico ico-lixeira"></i>
                    </a>
                </li>
            </ul>
            
            <div class="wrapper-menu-view-pasta">
                <div class="menu-view-pasta-clica-fora"></div>
                <ul class="menu-view-pasta">
                    <li>
                        <a href="" title="Opção atual desta pasta!" class="item-menu-config no-pointer">
                            <div class="icones">
                                <i class="ico ico-cadeado ativo"></i>
                            </div>
                            <div class="col-texto privada">
                                <strong>Esta biblioteca é privada</strong>
                                <span>só você pode ver</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" title="Trocar para esta opção?" class="item-menu-config tornarPublica last">
                            <div class="icones">
                                <i class="ico ico-share"></i>
                            </div>
                            <div class="col-texto publica">
                                <strong>Tornar biblioteca pública?</strong>
                                <span>todos poderão ver</span>
                            </div>
                        </a>
                    </li>

                    
                </ul>
            </div>
        </div>
    </header>
</div>
