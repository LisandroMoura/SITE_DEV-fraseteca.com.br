@extends('template.Usuario')

@section('css-view')
@endsection

@section('metadados')
    {{-- 1 html header --}}
     @include('back.includes.Backend', [
         "titulo" => "Lista de Frases",
         "descricao" => "Lista de Frases, Editar ou criar Categorias"
     ])     
@endsection

@section('conteudo-menu') 
       
@endsection

@section('conteudo-view')

    {{-- 2 Váriáveis --}}
    @php
        $msgValidatorArr = \App\Services\MsgValidator::run($errors);
        $default_page = "categorias";     
        
        //1) dados da tabela
        $idTabela=0;        
        $descricao="";
        $resumo ="";
        $urlamigavel = "";        
        $status ="";
        $disponivel="";

        if(isset($categoria)):        
            $i=0;
            $idTabela    = $categoria ? $categoria->id : 0;            
            $descricao   = $categoria ? $categoria->descricao : '';            
            $resumo      = $categoria ? $categoria->resumo : '';
            $urlamigavel = $categoria ? $categoria->urlamigavel : '';
            $disponivel  = $categoria ? $categoria->disponivel : "0";
            $status      = $categoria ? $categoria->status : 0;
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
                                $rotaVer = env('APP_URL').'/sessao/'.$urlamigavel;
                                @endphp
                                <a href="{{$rotaVer}}">Ver</a>
                            </div>   

                            {{-- FORM DE UPDATE --}}
                            <form ref="formulario" action="{{ route('categoria.update', $idTabela)}}" method="post" enctype="multipart/form-data">
                            @method('PUT')

                        <?php else: //STORE ?>    
                            <form ref="formulario" action="{{ route('categoria.store')}}" method="post" enctype="multipart/form-data">
                        <?php endif;?>  
                        {{ csrf_field() }}
                        {{-- from --}}
                            <div class="content-wrapper">
                                <header>
                                    {{-- 3 Nome da tela --}}
                                    <h1>
                                        <i class="icon painel"></i>
                                       @if ($idTabela > 0)
                                           Editando Sessão (categoria)
                                       @else  
                                        Criando Sessão (categoria)
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
                                {{-- descricao --}}
                                <section class="field">
                                    {{-- <header>                                        
                                        <p class="aproximar"><br></p>
                                    </header> --}}
                                    <div class="row">                                                                    
                                        @include('front.includes.formulario.Input', [
                                            'input'         => 'descricao',
                                            'label'         => 'Descrição',
                                            'old'           => old('descricao'),
                                            'inputCol'      => 'col-lg-10 titulo',
                                            'class'         => 'titulo validar naovazio' ,
                                            'ref'           => 'descricao', 
                                            //'vmodel'        => 'descricao',                                        
                                            'value'         =>  $descricao ,                                                 
                                            'placeholder'   => 'Descrição resumida',
                                            'ajuda'         => '',                                                
                                            'validator'     => true,  
                                            'requerid'      => 'requerid',                                           
                                            'msgValidator'  => isset($msgValidatorArr['titulo']) ? $msgValidatorArr['titulo'] : null,])

                                    </div>
                                </section>

                                {{-- resumo --}}
                                <section class="field">                                        
                                    <div class="row">   
                                            @include('front.includes.formulario.Textarea', [
                                            'input'         => 'resumo',
                                            'label'         => 'Resumo',                                         
                                            'class'         => 'resumo validar naovazio',
                                            'ref'           => 'resumo', 
                                            //'vmodel'        => 'resumo', 
                                            'old'           => old('resumo'),                                       
                                            'value'         =>  $resumo,                                            
                                            'placeholder'   => 'Um bom resumo, faz toda a diferença...',
                                            'requerid'      => 'requerid', 
                                            'ajuda'         => 'Mínimo 110, máximo 240',
                                            'width'         => '100%', 
                                            'cols'          => '5', 
                                            'rows'          => '3', 
                                            'V_SIZE'=>'240'
                                        ]) 
                                            
                                    </div>
                                </section>

                                {{-- url amigável --}}                                
                                @if ($idTabela > 0)
                                    <section class="field">
                                        <div class="row">                                          
                                            @include('front.includes.formulario.Input', [
                                                'input'         => 'urlamigavel',
                                                'label'         => 'Slug', 
                                                'old'           => old('urlamigavel'),
                                                'inputCol'      => 'col-lg-10 urlamigavel',                                                                                    
                                                'class'         => 'urlamigavel',                                                
                                                'ref'           => 'urlamigavel',                                                 
                                                'value'         =>  $urlamigavel ,                                                
                                                'requerid'      => 'requerid',                                             
                                            ])
                                        </div>
                                    </section>                                
                                @else                                            
                                    @include('front.includes.formulario.Hidden', [
                                        'input' => 'urlamigavel',
                                    ])
                                @endif   

                                {{--Disponível para o Usuário --}}
                                <section class="field">                                    
                                    <div class="row">
                                        <div class="col-lg-2 label-area ">
                                            <label for="">
                                                Disponível para o Usuário?
                                            </label>
                                        </div>
                                        <div class=" col-lg-10 field-input">                                                                                
                                            @include('front.includes.formulario.Radio',    ['input' => 'disponivel','label' => 'Disponível para o usuário', 'value' => '1', 'checked' => $disponivel == '1' ? 'true' : 'false' ])
                                            @include('front.includes.formulario.Radio',    ['input' => 'disponivel','label' => 'Não disponível para o usuário', 'value' => '0', 'checked' => $disponivel == '0' ? 'true' : 'false'  ])
                                        </div>
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
                                            @include('front.includes.formulario.Radio',    ['input' => 'status','label' => 'Não indexar nas pesquisas, Não visível no site', 'value' => '0', 'checked' => $status == '0' ? 'true' : 'false' ])
                                            @include('front.includes.formulario.Radio',    ['input' => 'status','label' => 'Indexar nas pesquisas, visível no site', 'value' => '1', 'checked' => $status == '1' ? 'true' : 'false'  ])
                                            
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
                                                    'value'=> $categoria->aux_1,
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
                                                    'value'=> $categoria->aux_2,
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
                                                'rota'    => 'categoria.update',
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
                                            action="{{ route('categoria.destroy',$idTabela)}}" method="POST">
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