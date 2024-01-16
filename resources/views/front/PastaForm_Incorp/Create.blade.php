
    <div class="pasta--form--create">         
        
        <div class="pasta--form--create--itens">
            @include('front.includes.formulario.Inputreq',  [
            'input' => 'titulo', 
            'inputCol' => 'w100',
            'class' => 'magic titulo create-title-input',
            'placeholder' => 'Nome da Biblioteca',
            'validator'     => true,
            'msgValidator'  => isset($msgValidatorArr['nome_completo']) ? $msgValidatorArr['nome_completo'] : null,
            ])
            <div class="pasta-privada">
                <div class="col-ico privada">
                    <i class="ico ico-cadeado ativo"></i>
                </div>
                <div class="col-texto {{$statusViewpasta}}">
                    <h4>{{$tituloViewPasta}}</h4>
                    <span>{{$subTituloViewPasta}}</span>
                </div>
            </div>
        </div>

        @include('front.includes.formulario.Btsalvar',[
            'rota'   => 'usuario.update',
            'icone'  => 'save save-branco ',
            'class'  => 'submit bt-center  btSalvarPasta nok ' . $action,
            'id'     =>  "btSalvarPasta",  
            'label'  => 'Criar Biblioteca',
            'tip'    => 'Criar a Pasta'
            ])
    </div>
