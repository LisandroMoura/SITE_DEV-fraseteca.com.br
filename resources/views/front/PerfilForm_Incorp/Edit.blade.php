<form ref="formulario" id="formulario" action="{{ route('usuario.update',$usuario->id)}}" method="post" enctype="multipart/form-data">
    @method('PUT')
    {{ csrf_field() }}
    <button id="btUpdateTela" class="hidden updateArrayDoInputMagic">update</button>
    
    {{-- 
        /////////////////////////////////////////
        AVATAR ZONE 
        /////////////////////////////////////////
    --}}
    
    <section class="avatar--crop">
        <div id="img-pronta" class="imagem-avatar">
            <img  id="capa" src="{{$usuario->getAvatarNoPerfilAttribute()}}" alt="Usuário: {{$usuario->name}}">
            <a href="#" class="bt-upload-image JSUpload"><i class="ico ico-camera"></i></a>                                        
        </div>  
        
        <div id="cropjs-zone" class="avatar-cropjs wrapper-image-cropjs no-print">
            {{-- <a href="#" class="bt-upload-de-imagens uploadJsInCrop" id="btUploadCrop" title="Alterar imagem de capa!"><i class="ico ico-upload-imagens"></i></a> --}}
            <a href="#" class="bt-cortar-capa " id="btCortar" title="Cortar Imagem - Finalizar!"><i class="ico ico-imagem"></i></a>
            <img src="{{$usuario->getAvatarNoPerfilAttribute()}}" alt="" id="srcImgCropJS">
            <textarea name="inputCapa" id="inputCapa"></textarea>
            <input type="hidden" name="avatar_icone_id" id="avatar_icone_id" value="{{$usuario->avatar_icone_id}}">
        </div>
    </section>

    {{-- 
    /////////////////////////////////////////
    CAMPOS ZONE 
    /////////////////////////////////////////
    --}}
    
    <section class="campos">
        <div class="body-row-input">
            <div class="container-section max-width-content">
                <div class="itens">                                
                    @include('front.includes.formulario.Inputreq',  [
                    'input' => 'nome_completo', 
                    'vmodel' => 'nome_completo', 
                    'value'=> $nome_completo,  
                    'labelCol' => 'w100', 
                    'inputCol' => 'w100', 
                    'class' => 'no-border w100 pd-small fonte-16',                     
                    'label'=> 'Nome de usuário', 
                    'placeholder' => 'Nome de usuário',
                    'requerid'=> 'requerid', 
                    'ajuda'=> 'Campo obrigatório. Nome que aparecerá no site',
                    'validator'     => true,
                    'msgValidator'  => isset($msgValidatorArr['nome_completo']) ? $msgValidatorArr['nome_completo'] : null,
                    ])
                </div>
            </div>
            <div class="demarcador-marca no-print"></div>
        </div>
        <div class="body-row-input">
            <div class="container-section max-width-content">
                <div class="itens">        

                    @include('front.includes.formulario.Inputreq',  [
                    'input' => 'email', 
                    'vmodel' => 'nome_completo', 
                    'value'=> $usuario->email,  
                    'labelCol' => 'w100', 
                    'inputCol' => 'w100', 
                    'class' => 'no-border w100 pd-small fonte-16',   
                    'label'=> 'Email', 
                    'placeholder' => 'Email',
                    'requerid'=> 'requerid', 
                    'ajuda'=> 'Campo obrigatório.',
                    'validator'     => true,
                    'msgValidator'  => isset($msgValidatorArr['email']) ? $msgValidatorArr['email'] : null,
                    ])
                </div>
            </div>
            <div class="demarcador-marca no-print"></div>
        </div>  
        <div class="body-row-input">
            <div class="container-section max-width-content">
                <div class="itens">        
                    @include('front.includes.formulario.Select',    [
                        'input' => 'sexo',                        
                        'value'=> $usuario->sexo,  
                        'class' => 'no-border pd-small custom full fonte-16',                          
                        'label'=> 'Sexo', 
                        'labelCol' => 'w1004', 
                        'inputCol' => 'w100', 
                        'dados' => $sexo_dados 
                    ])  

                </div>
            </div>
            <div class="demarcador-marca no-print"></div>
        </div>

        <div class="body-row-input">
            <div class="container-section max-width-content">
                <div class="itens flex-start">   
                    @include('front.includes.formulario.Textareaback',  [
                    'input' => 'informacoes_biograficas',                                     
                    'value'=> $usuario->informacoes_biograficas,  
                    'labelCol' => 'w100 pd-10', 
                    'inputCol' => 'w100 with-contador', 
                    'class' => 'no-border pd-small fonte-16',   
                    'label'=> 'Descrição', 
                    'placeholder' => 'Escreva uma breve descrição (máx. 150 caracteres)',
                    'width'=>'100%', 
                    'cols'=>'5', 
                    'rows' => '1', 
                    'validator'     => true,
                    'msgValidator'  => isset($msgValidatorArr['informacoes_biograficas']) ? $msgValidatorArr['informacoes_biograficas'] : null,         
                    'vmodel'=>'informacoes_biograficas',
                    'V_SIZE'=>'150'                                    
                    ])
                </div>
            </div>
            <div class="demarcador-marca no-print"></div>
        </div>
        <div class="body-row-input">
            <div class="container-section max-width-content">
                <div class="itens">   
                    @include('front.includes.formulario.Inputreq',  [
                    'input' => 'url',                                     
                    'value'=> $usuario->url,  
                    'class' => 'no-border pd-small fonte-16',   
                    'labelCol' => 'w100', 
                    'inputCol' => 'w100', 
                    'label'=> 'Link', 
                    'placeholder' => 'Ex: instagram.com/seuNome',
                    'width'=>'100%',   
                    'validator'     => true,
                    'msgValidator'  => isset($msgValidatorArr['url']) ? $msgValidatorArr['url'] : null,                                  
                    ])
                </div>
            </div>
            <div class="demarcador-marca no-print"></div>
        </div>  
        <div class="body-row-input">
            <div class="container-section max-width-content">
                <div class="botao-salvar">   
                    @include('front.includes.formulario.Btsalvar',[                
                        'rota'   => 'usuario.update',
                        'class'  => 'botao-padrao red full submit bt-center',
                        'id'     =>  "btSalvarPerfil",  
                        'label'  => 'Salvar Alterações',
                        'vaction'=> "validaSubmit",
                        'tip'    => 'Salvar Alterações'
                        ]) 
                    
                </div>
            </div>                            
        </div> 
    </section>
</form>