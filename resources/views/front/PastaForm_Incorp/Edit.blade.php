

    <input id="nitens" name="nitens" type="hidden" value="{{$nItens}}">                    
    <textarea name="arrItens"        id="arrItens" cols="30" rows="10" style="display: none;"></textarea>
    <textarea name="arrFrasesDelete" id="arrFrasesDelete" cols="30" rows="10" style="display: none;"></textarea> 
    <section class="margin-auto pasta--form--zone {{ $action }}">
        <section>
            <div id="img-pronta" class="wrapper--image imagem-de-capa no-print">
                
                <div
                    id="capa"
                    class="wrapper-image-bg no-print autoload @if ($capa == asset("images/bgs/fundo-v01.svg")) auto @endif"
                    style="background-image:url({{$capa ?? ''}})">
                    @if ($capa == asset("images/bgs/fundo-v01.svg"))
                        <div class="default--image">
                            <img class="imagem--capa--center" src="/images/default/capa.svg" alt="">
                        </div>                        
                    @endif
                    
                    <a href="#" class="botao-padrao branco uploadJs JSUpload flex com-icone" id="btUpload" title="Alterar imagem de capa!">
                        <span class="label">Inserir capa</span>
                        <i class="ico ico-add-capa"></i>
                    </a>
                </div>

                <div
                    id="capa_m"
                    class="wrapper-image-bg mobile no-print autoload @if ($capa == asset("images/bgs/fundo.png")) auto @endif"
                    style="background-image:url({{$capa_m ?? ''}})">
                    @if ($capa == asset("images/bgs/fundo-v01.svg"))
                        <div class="default--image">
                            <img class="imagem--capa--center" src="/images/default/capa.svg" alt="">
                        </div>                        
                    @endif
                    <a href="#" class="botao-padrao branco uploadJs JSUpload flex com-icone" id="btUpload" title="Alterar imagem de capa!">
                        <span class="label">Inserir capa</span>
                        <i class="ico ico-add-capa"></i>
                    </a>
                </div>
            </div> 
            <div id="cropjs-zone" class="wrapper-image-cropjs imagem-de-capa no-print">                                
                <a href="#" class="botao-padrao green bt-cortar-capa avatar-cropjss" id="btCortar" title="Cortar Imagem - Finalizar!">Cortar capa</a>
                <img src="{{$capa}}" alt="" id="srcImgCropJS">                                
                <textarea name="inputCapa" id="inputCapa"></textarea>
                <input type="hidden" name="autorName" id="autorName" value="">
                <input type="hidden" name="autorLink" id="autorLink" value="">
            </div>
            <div class="container-corpo" id="arrFrases">
                @if (isset($dados->itens))
                    @if (count($dados->itens))
                        @include('front.PastaForm_Incorp.Item')
                    @else
                        {{-- @include('front.PastaForm_Incorp.Itemdefault') --}}
                    @endif
                @endif
                
            </div>
        </section>
    </section>
    


