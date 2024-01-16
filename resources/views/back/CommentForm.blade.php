@extends('template.Usuario')

@section('css-view')
@endsection

@section('metadados')
    {{-- 1 html header --}}
     @include('back.includes.Backend', [
         "titulo" => "Lista de Frases",
         "descricao" => "Lista de Frases, Editar Comentários"
     ])     
@endsection

@section('conteudo-menu') 
       
@endsection

@section('conteudo-view')

    {{-- 2 Váriáveis --}}
    @php
        $msgValidatorArr = \App\Services\MsgValidator::run($errors);
        $default_page = "comentarios";     
        
        //1) dados da tabela
        $idTabela=0;    

        $descricao="";        
        $body            = "";                        
        $status          = 0;
        $usuario_id = null;
        $autor_email = '';   
        $autor_nome  = ''; 

        if(isset($comment)):        
            $i=0;
            $idTabela    = $comment ? $comment->id : 0;                        
            $body        = $comment ? $comment->body : 'Escreva aqui...';  
            $autor_email = $comment ? $comment->autor_email : '';   
            $autor_nome  = $comment ? $comment->autor_nome : '';        
            $usuario_id  = $comment ? $comment->usuario_id : 'null';
            $status      = $comment ? $comment->status : 0;
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
                            {{-- BOTÃO VER SITE  --}}
                            <div class="ver-site">
                                @php
                                if($tipo=="post")
                                    $rotaVer = "/" .$comment->post->urlamigavel;
                                else
                                    $rotaVer = "/" .$comment->frase->urlamigavel;
                                @endphp
                                <a href="{{$rotaVer}}">Ver</a>
                            </div>   

                            {{-- FORM DE UPDATE --}}
                            <form ref="formulario" action="{{ route('comments.update', $idTabela)}}" method="post" enctype="multipart/form-data">
                            @method('PUT')

                        <?php else: //STORE ?>    
                            <form ref="formulario" action="{{ route('comments.store')}}" method="post" enctype="multipart/form-data">
                        <?php endif;?>  
                        {{ csrf_field() }}
                        {{-- from --}}
                            <div class="content-wrapper">
                                <header>
                                    {{-- 3 Nome da tela --}}
                                    <h1>
                                        <i class="icon painel"></i>
                                       @if ($idTabela > 0)
                                           Editando Comments
                                       @else  
                                        Criando Comments
                                       @endif
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
                                <section class="field">
                                   
                                    <div class="row">                                                                    
                                        @include('front.includes.formulario.Input', [
                                            'input'         => 'body',
                                            'label'         => 'Corpo',
                                            'old'           => old('body'),
                                            'inputCol'      => 'col-lg-10 titulo',
                                            'class'         => 'titulo validar naovazio' ,
                                            'ref'           => 'body',                                             
                                            'value'         =>  $body ,                                                 
                                            'placeholder'   => 'Corpo do comentário',
                                            'ajuda'         => '',                                                
                                            'validator'     => true,  
                                            'requerid'      => 'requerid',                                           
                                            'msgValidator'  => isset($msgValidatorArr['titulo']) ? $msgValidatorArr['titulo'] : null,])

                                    </div>
                                </section>

                                <section class="field">
                                   
                                    <div class="row">                                                                    
                                        @include('front.includes.formulario.Input', [
                                            'input'         => 'autor_email',
                                            'label'         => 'Email',
                                            'old'           => old('autor_email'),
                                            'inputCol'      => 'col-lg-10 titulo',
                                            'class'         => 'titulo validar naovazio' ,
                                            'ref'           => 'body',                                             
                                            'value'         =>  $autor_email ,                                                 
                                            'placeholder'   => 'email',
                                            'ajuda'         => '',                                                
                                            'validator'     => true,  
                                            'requerid'      => 'requerid',                                           
                                            'msgValidator'  => isset($msgValidatorArr['autor_email']) ? $msgValidatorArr['autor_email'] : null,])

                                    </div>
                                </section>
                                <section class="field">
                                   
                                    <div class="row">                                                                    
                                        @include('front.includes.formulario.Input', [
                                            'input'         => 'autor_nome',
                                            'label'         => 'Nome',
                                            'old'           => old('autor_nome'),
                                            'inputCol'      => 'col-lg-10 titulo',
                                            'class'         => 'titulo validar naovazio' ,
                                            'ref'           => 'body',                                             
                                            'value'         =>  $autor_nome ,                                                 
                                            'placeholder'   => 'autor_nome',
                                            'ajuda'         => '',                                                
                                            'validator'     => true,  
                                            'requerid'      => 'requerid',                                           
                                            'msgValidator'  => isset($msgValidatorArr['autor_nome']) ? $msgValidatorArr['autor_nome'] : null,])

                                    </div>
                                </section>
                                {{-- status --}}
                                <section class="field">                                    
                                    <div class="row">
                                        <div class="col-lg-2 label-area ">
                                            <label for="">
                                                Status
                                            </label>
                                        </div>
                                        <div class=" col-lg-10 field-input">                                                  
                                            @include('front.includes.formulario.Radio',    ['input' => 'status','label' => 'Pendente',  'value' => '0', 'checked' => $status == '0' ? 'true' : 'false' ])
                                            @include('front.includes.formulario.Radio',    ['input' => 'status','label' => 'Aprovado',  'value' => '1', 'checked' => $status == '1' ? 'true' : 'false'  ])
                                            @include('front.includes.formulario.Radio',    ['input' => 'status','label' => 'Reprovado', 'value' => '2', 'checked' => $status == '2' ? 'true' : 'false'  ])                                            
                                        </div>
                                    </div>
                                </section>

                            {{-- aqui form --}}
                            {{-- endMagic --}}
                            </div>
                            {{-- Campos Aux  --}}
                            @if ($idTabela)
                                <div class="content-wrapper">
                                    {{-- botões --}}
                                    <header>
                                        <h1>
                                            <i class="icon icon painel"></i>
                                            Auxiliares
                                        </h1>
                                    </header>    
                                    <section>                               
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h3>Campos auxiliares da tabela</h3>
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            
                                        </div>
                                    </section>
                                    {{-- campos --}}
                                    {{-- Aux1 e Aux2 --}}                                
                                    <section class="field">                                    
                                        <div class="row">
                                            <div class="col-lg-6 field-input ">
                                                <div class="row">
                                                    @include('front.includes.formulario.Input',  [
                                                    'input' => 'aux_1',
                                                    'value'=> $comment->aux_1,
                                                    'labelCol' => 'col-lg-4', 
                                                    'inputCol' => 'col-lg-8', 
                                                    'label'=> 'Aux1',
                                                    'placeholder' => 'valores auxiliares',
                                                    'requerid'=> 'nnn',
                                                    'ajuda'=> 'campo auxiliar'])

                                                </div>
                                            </div>
                                            <div class=" col-lg-6 field-input">
                                                <div class="row">
                                                    @include('front.includes.formulario.Input',  [
                                                    'input' => 'aux_2', 
                                                    'value'=> $comment->aux_2,
                                                    'labelCol' => 'col-lg-4', 
                                                    'inputCol' => 'col-lg-8', 
                                                    'label'=> 'Aux2', 
                                                    'placeholder' => 'valores auxiliares',
                                                    'requerid'=> 'nnn',
                                                    'ajuda'=> 'campo auxiliar']) 

                                                </div>
                                            </div>
                                        </div>
                                    </section>                                                                
                                </div>
                            @endif  
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
                            @if ($tipo=="frases")
                                <input type="text" name="table" id="table" value="comment_frases"/>                                
                            @endif                            
                        </form> 

                        {{-- Excluir Lista --}}
                        @if ($idTabela)
                            <div class="content-wrapper">
                                <header>
                                    <h1>
                                        <i class="icon atention"></i>
                                        Exclusão
                                    </h1>
                                </header>    
                                <section>  
                                    {{-- exclusão --}}
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <h3>Após a exclusão, é impossível reativar o registro  :(</h3>
                                        </div>    
                                        <div class="col-lg-3">
                                            @php
                                                $vaction  ='enviar_lixeira'.$idTabela;
                                                $pergunta ='Deseja realmente excluir este item?';
                                                $aviso    = 'confirma cuidado';
                                            @endphp    

                                            <form ref="enviar_lixeira{{$idTabela}}" class="form-box" 
                                            action="{{ route('comments.destroy',$idTabela)}}" method="POST">
                                            {{ csrf_field() }}                                    
                                            {{method_field('DELETE')}}
                                            @method('DELETE')
                                            @include('front.includes.formulario.Hidden',['input' => 'id','value' => $idTabela])
                                            
                                            <a                                         
                                            href="" 
                                            v-on:click="getConfirm('{{$vaction}}', $event, '{{$pergunta ?? "Confirma esta operação:?"}}', '{{$aviso ?? "atencao"}}')"
                                            class="bt-link bt-rosa bt-center"                                           
                                            title="Excluir">
                                            Excluir
                                            </a>
                                            </form>                                                                                        
                                                
                                        </div>
                                    </div>
                                </section>
                            </div>                          
                         @endif
                         {{--Fim exluir  --}}
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