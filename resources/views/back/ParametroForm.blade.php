@extends('template.Usuario')

@section('css-view')
@endsection

@section('metadados')
    {{-- 1 html header --}}
     @include('back.includes.Backend', [
         "titulo" => "Lista de Frases",
         "titulo_do_site" => "Lista de Frases, Editar ou criar Tags"
     ])     
@endsection

@section('conteudo-menu') 
       
@endsection

@section('conteudo-view')

    {{-- 2 Váriáveis --}}
    @php
        $msgValidatorArr = \App\Services\MsgValidator::run($errors);
        $default_page = "parametros";     
        
        //1) dados da tabela
        $idTabela=0;
        $titulo_do_site="";
        $logo ="";
        
        $urlamigavel = "";        
        $status ="";
        $disponivel="";

        if(isset($parametros)):        
            $i=0;
            $idTabela       = $parametros ? $parametros->id : 0;            
            $titulo_do_site = $parametros ? $parametros->titulo_do_site : '';
            $logo           = $parametros ? $parametros->logo : '';

            // $urlamigavel = $parametros ? $parametros->urlamigavel : '';
            // $disponivel  = $parametros ? $parametros->disponivel : "0";
            // $status      = $parametros ? $parametros->status : 0;
        endif;        
        
    @endphp
        
    <div class="page" id="app">
        {{-- validatorSys será colocado aqui, via JS, pelo Mixin --}}        
        @include('front.includes.Retorno') 
        <bt-confirma :confirma="objConfirma" ></bt-confirma>
        @include('back.includes.Menulateral')
        @include('front.includes.Areapesquisa')
        <div class="corpo-da-pagina" >
            @include('back.includes.Topo' , ["amp" => false])

            <div class="container corpo">            
                <div class="wrapper">
                    <!-- Sidebar -->
                    <div id="sidebar" class="normal" ref="ref_sidebar">
                        @include('back.includes.Menu' ,[
                            "pagina" => $default_page
                        ])
                    </div>
                    <div id="botao"
                    ref="ref_botao"
                    class="only-mobile"
                    @click.prevent.stop="abreSidebar">
                        <span class="linha "></span>
                        <span class="linha linha2"></span>
                    </div>                
                    <!-- Page Content -->
                    <div id="content" class="default-form {{$default_page}}">
                        {{-- startMagic --}}    
                        <?php if($idTabela > 0): //UPDATE ?>
                            {{-- BOTÃO VER SITE --}}
                            <div class="ver-site">
                                @php
                                $rotaVer = env('APP_URL').'/'.$urlamigavel;
                                @endphp
                                <a href="{{$rotaVer}}">Ver</a>
                            </div>
                            {{-- FORM DE UPDATE --}}
                            <form ref="formulario" action="{{ route('admin.parametros_update', $idTabela)}}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                        <?php else: //STORE ?>    
                            <form ref="formulario" action="{{ route('admin.parametros_update', $idTabela)}}" method="post" enctype="multipart/form-data">
                        <?php endif;?>  
                        {{ csrf_field() }}
                        {{-- from --}}
                            <div class="content-wrapper">
                                <header>
                                    {{-- 3 Nome da tela --}}
                                    <h1>
                                        <i class="icon painel"></i>
                                           Dados do Projeto
                                    </h1>
                                </header>
                                {{-- 
                                    -------------------------------------------
                                    -------------------------------------------
                                    -------------------------------------------
                                    4 - CAMPOS 
                                    -------------------------------------------
                                    -------------------------------------------
                                    -------------------------------------------
                                --}}
                                {{-- titulo_do_site --}}
                                <section class="field">
                                    {{-- <header>
                                        <p class="aproximar"><br></p>
                                    </header> --}}
                                    <div class="row">                                                                    
                                        @include('front.includes.formulario.Input', [
                                            'input'         => 'titulo_do_site',
                                            'label'         => 'Título do site',
                                            'old'           => old('titulo_do_site'),
                                            'inputCol'      => 'col-lg-10 titulo',
                                            'class'         => 'titulo validar ' ,
                                            'ref'           => 'titulo_do_site',                                             
                                            'value'         =>  $parametros->titulo_do_site ,                                                 
                                            'placeholder'   => 'Título do site',
                                            'ajuda'         => '',                                                
                                            'validator'     => true,  
                                            'requerid'      => 'requerid',                                           
                                            'msgValidator'  => isset($msgValidatorArr['titulo']) ? $msgValidatorArr['titulo'] : null,])

                                    </div>
                                </section>

                                {{-- logo --}}
                                <section class="field">                                        
                                    <div class="row">   
                                            @include('front.includes.formulario.Textarea', [
                                            'input'         => 'logo',
                                            'label'         => 'Logo do site',                                         
                                            'class'         => 'logo validar ',
                                            'ref'           => 'logo', 
                                            //'vmodel'        => 'logo', 
                                            'old'           => old('logo'),                                       
                                            'value'         =>  $parametros->logo,                                            
                                            'placeholder'   => 'Um bom logo, faz toda a diferença...',                                            
                                            'ajuda'         => 'Logo em 64 bits',
                                            'width'         => '100%', 
                                            'cols'          => '5', 
                                            'rows'          => '3', 
                                            
                                        ]) 
                                            
                                    </div>
                                </section>
                                <section class="field">                                        
                                    <div class="row">   
                                            @include('front.includes.formulario.Textarea', [
                                            'input'         => 'logo',
                                            'label'         => 'Logo Mobile',                                         
                                            'class'         => 'logo validar ',
                                            'ref'           => 'logo', 
                                            //'vmodel'        => 'logo', 
                                            'old'           => old('logo'),                                       
                                            'value'         =>  $parametros->logoMobile,                                            
                                            'placeholder'   => 'Um bom logo, faz toda a diferença...',                                            
                                            'ajuda'         => 'Logo Mobile em 64 bits',
                                            'width'         => '100%', 
                                            'cols'          => '5', 
                                            'rows'          => '3', 
                                            
                                        ]) 
                                            
                                    </div>
                                </section>

                            {{-- aqui form --}}
                            {{-- endMagic --}}
                            </div>
                            {{-- servidor de imagens  --}}
                            <div class="content-wrapper">                                
                                <header>
                                    <h1>
                                        <i class="icon icon painel"></i>
                                        Servidor de imagens
                                    </h1>
                                </header>    
                                {{-- Aux1 e Aux2 --}}                                
                                <section class="field">                                    
                                    <div class="row">
                                        <div class="col-lg-6 field-input ">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'servidor_imagens_app',
                                                'value'=> $parametros->servidor_imagens_app,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'App',
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'Servidor de imagens da aplicação'])

                                            </div>
                                        </div>
                                        <div class=" col-lg-6 field-input">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'servidor_imagens_usuario', 
                                                'value'=> $parametros->servidor_imagens_usuario,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'Usuario', 
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'Servidor de imagens do usuário']) 

                                            </div>
                                        </div>
                                    </div>
                                </section>                                                                
                            </div>

                            <div class="content-wrapper">                                
                                <header>
                                    <h1>
                                        <i class="icon icon painel"></i>
                                        Edição de Posts
                                    </h1>
                                </header>    
                                {{-- Aux1 e Aux2 --}}                                
                                <section class="field">                                    
                                    <div class="row">
                                        <div class="col-lg-12 field-input ">
                                            <div class="row">
                                                @include('front.includes.formulario.Textarea', [
                                                'input'         => 'convite',
                                                'label'         => 'Convite no post',                                         
                                                'class'         => 'convite validar naovazio',
                                                'ref'           => 'convite',                                                 
                                                'old'           =>  old('convite'),                                       
                                                'value'         =>  $parametros->convite,                                            
                                                'placeholder'   => 'Um bom resumo, faz toda a diferença...',
                                                'requerid'      => 'none', 
                                                'ajuda'         => 'Mínimo 110, máximo 240',
                                                'width'         => '100%', 
                                                'cols'          => '5', 
                                                'rows'          => '10',
                                                ])
                                            </div>
                                        </div>                                        
                                    </div>
                                </section>                                                                
                            </div>

                           
                            {{-- //paginações / Config  --}}
                            <div class="content-wrapper">                                
                                <header>
                                    <h1>
                                        <i class="icon icon painel"></i>
                                        Paginações / Config 
                                    </h1>
                                </header>    
                                {{-- Aux1 e Aux2 --}}                                
                                <section class="field">
                                    <div class="row">
                                        <div class="col-lg-6 field-input">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'paginate',
                                                'value'=> $parametros->paginate,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'Paginação Geral',
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'paginação geral do site'])

                                            </div>
                                        </div>
                                        <div class=" col-lg-6 field-input">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'paginatePost', 
                                                'value'=> $parametros->paginatePost,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'Paginação    Post', 
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'paginação apenas para os posts']) 

                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section class="field">
                                    <div class="row">                                        
                                        <div class=" col-lg-6 field-input">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'msg_final_listas', 
                                                'value'=> $parametros->msg_final_listas,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'Msg das Listas', 
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'Mensagens automáticas finais das Listas']) 

                                            </div>
                                        </div>
                                    </div>
                                </section>                                                                
                            </div>
                           
                            {{-- Dimensões de imagens do sistema --}}
                            <div class="content-wrapper">                                
                                <header>
                                    <h1>
                                        <i class="icon icon painel"></i>
                                        Dimensões de imagens no sistema
                                    </h1>
                                </header>                                    
                                <section class="field">                                    
                                    <div class="row">
                                        <div class="col-lg-6 field-input ">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'tamanho_upload_midia',
                                                'value'=> $parametros->tamanho_upload_midia,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'Tamanho Peso  Mídia',
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'Upload Mídia'])

                                            </div>
                                        </div>
                                        <div class=" col-lg-6 field-input">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'txt_tamanho_upload_midia', 
                                                'value'=> $parametros->txt_tamanho_upload_midia,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'Label ', 
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'txt_tamanho_upload_midia']) 

                                            </div>
                                        </div>
                                    </div>                                    
                                </section>  
                                <section class="field">                                    
                                    <div class="row">
                                        <div class="col-lg-6 field-input ">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'limit_width_upload_midia',
                                                'value'=> $parametros->limit_width_upload_midia,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'Limite Width',
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'width_upload_midia'])

                                            </div>
                                        </div>
                                        <div class=" col-lg-6 field-input">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'limit_height_upload_midia', 
                                                'value'=> $parametros->limit_height_upload_midia,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'Limite Height', 
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'height_upload_midia']) 

                                            </div>
                                        </div>
                                    </div>                                    
                                </section> 
                                <section class="field">                                    
                                    <div class="row">
                                        <div class="col-lg-6 field-input ">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'width_upload_midia',
                                                'value'=> $parametros->width_upload_midia,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'Width',
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'width_upload_midia'])

                                            </div>
                                        </div>
                                        <div class=" col-lg-6 field-input">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'height_upload_midia', 
                                                'value'=> $parametros->height_upload_midia,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'Height', 
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'height_upload_midia']) 

                                            </div>
                                        </div>
                                    </div>                                    
                                </section>   
                                <header>
                                    <h3>
                                        Dimensões Para a area do Adm 
                                    </h3>
                                </header>  
                                <section class="field">                                    
                                    <div class="row">
                                        <div class="col-lg-6 field-input ">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'tamanho_upload_adm',
                                                'value'=> $parametros->tamanho_upload_adm,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'Tamanho Adm',
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'Upload Mídia'])

                                            </div>
                                        </div>
                                        <div class=" col-lg-6 field-input">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'txt_tamanho_upload_adm', 
                                                'value'=> $parametros->txt_tamanho_upload_adm,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'Label ', 
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'txt_tamanho_upload_adm']) 

                                            </div>
                                        </div>
                                    </div>                                    
                                </section>  
                                <header>
                                    <h3>
                                        Limites Para o Avatar do usuário
                                    </h3>
                                </header>  
                                <section class="field">                                    
                                    <div class="row">
                                        <div class="col-lg-6 field-input ">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'tamanho_upload_avatar',
                                                'value'=> $parametros->tamanho_upload_avatar,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'Tamanho Avatar',
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'Upload Mídia'])

                                            </div>
                                        </div>
                                        <div class=" col-lg-6 field-input">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'txt_tamanho_upload_avatar', 
                                                'value'=> $parametros->txt_tamanho_upload_avatar,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'Label ', 
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'txt_tamanho_upload_avatar']) 

                                            </div>
                                        </div>
                                    </div>                                    
                                </section> 
                                <section class="field">                                    
                                    <div class="row">
                                        <div class="col-lg-6 field-input ">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'width_upload_avatar',
                                                'value'=> $parametros->width_upload_avatar,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'Width',
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'width_upload_avatar'])

                                            </div>
                                        </div>
                                        <div class=" col-lg-6 field-input">
                                            <div class="row">
                                                @include('front.includes.formulario.Input',  [
                                                'input' => 'height_upload_avatar', 
                                                'value'=> $parametros->height_upload_avatar,
                                                'labelCol' => 'col-lg-4', 
                                                'inputCol' => 'col-lg-8', 
                                                'label'=> 'height ', 
                                                'placeholder' => 'valores auxiliares',
                                                'requerid'=> 'nnn',
                                                'ajuda'=> 'height_upload_avatar']) 

                                            </div>
                                        </div>
                                    </div>                                    
                                </section>
                                
                                
                            </div>

                               {{-- //Configurações de Apis de terceiros --}}
                               <div class="content-wrapper">
                                <header>
                                    <h1>
                                        <i class="icon icon painel"></i>
                                        Configurações de Apis de terceiros 
                                    </h1>
                                </header>                                                             
                                <section class="field">
                                    <div class="row">
                                        @include('front.includes.formulario.Input', [
                                            'input'         => 'clientIdUnsplash',
                                            'label'         => 'Api Unsplash',
                                            'inputCol'      => 'col-lg-10 titulo',
                                            'class'         => 'titulo validar ',
                                            'value'         =>  $parametros->clientIdUnsplash,
                                            'placeholder'   => 'clientIdUnsplash',
                                            'ajuda'         => '',
                                            ])
                                    </div>
                                </section>

                                <section class="field">
                                    <div class="row">
                                        @include('front.includes.formulario.Input', [
                                            'input'         => 'collectionDefault',
                                            'label'         => 'Collection Unsplash',
                                            'inputCol'      => 'col-lg-10 titulo',
                                            'class'         => 'titulo validar ',
                                            'value'         =>  $parametros->collectionDefault,
                                            'placeholder'   => 'collectionDefault',
                                            'ajuda'         => '',
                                            ])
                                    </div>
                                </section>

                                <section class="field">
                                    <div class="row">
                                        @include('front.includes.formulario.Input', [
                                            'input'         => 'perPageUnsplash',
                                            'label'         => 'PerPage Unsplash',                                                
                                            'inputCol'      => 'col-lg-10 titulo',
                                            'class'         => 'titulo validar ' ,                                                
                                            'value'         =>  $parametros->perPageUnsplash ,                                                 
                                            'placeholder'   => 'perPageUnsplash',
                                            'ajuda'         => '',                                                
                                            ])
                                    </div>
                                </section>
                                
                                <section class="field">                                    
                                    <div class="row">                                                       
                                        @include('front.includes.formulario.Input', [
                                            'input'         => 'keyYandex',
                                            'label'         => 'Usar small img',                                                
                                            'inputCol'      => 'col-lg-10 titulo',
                                            'class'         => 'titulo validar ' ,                                                
                                            'value'         =>  $parametros->keyYandex ,                                                 
                                            'placeholder'   => 'keyYandex',
                                            'ajuda'         => '',                                                
                                            ])
                                    </div>
                                </section> 

                                <section class="field">                                    
                                    <div class="row">                                                       
                                        @include('front.includes.formulario.Input', [
                                            'input'         => 'aux_1',
                                            'label'         => 'Usar reCaptcha?',                                                
                                            'inputCol'      => 'col-lg-10 titulo',
                                            'class'         => 'titulo validar ' ,                                                
                                            'value'         =>  $parametros->aux_1 ,                                                 
                                            'placeholder'   => 'true/false',
                                            'ajuda'         => '',                                                
                                            ])
                                    </div>
                                </section> 


                            </div>

                            {{-- segunda parte  --}}
                            <div class="content-wrapper">
                                {{-- botões --}}
                                <header>
                                    <h1>
                                        <i class="icon icon painel"></i>
                                        Salvar
                                    </h1>
                                </header>    
                                <section>                               
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h3>Salvar o registro </h3>
                                        </div>                                            
                                    </div>
                                    <div class="row">
                                        
                                    </div>
                                </section>
                                 {{-- FIM  Botões de ação --}}
                                <section class="field">
                                    <div class="row">
                                        <div class="col-md-6 float-left  zona-bt-enviar-lista ">
                                            @include('front.includes.formulario.Btsalvar',[                
                                                'rota'    => 'tag.update',
                                                'id'      =>  $idTabela,  
                                                'class'   => 'callAction',
                                                'vaction' => 'salvar',
                                                // 'aviso'   => 'confirma info',
                                                // 'pergunta'  => 'Deseja Publicar o post?',
                                                //'lbconfirma' => 'Salvar',
                                                'icone'   => 'enviar',
                                                'label'   => 'Salvar registro',
                                                'tip'     => 'Salvar registro'
                                            ])
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- foter --}}
            @include('front.includes.Footer')
        </div> 
    </div>
@endsection
@section('js-view')    
    <script src="{{ asset('js/padrao_admin_editar_cadsimples.js') }}"></script>    
@endsection