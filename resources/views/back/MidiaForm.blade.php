@extends('template.Usuario')

@section('css-view')
@endsection

@section('metadados')
    {{-- 1 html header --}}
     @include('back.includes.Backend', [
         "titulo" => "Lista de Frases",
         "titulo" => "Lista de Frases, Gestão de Mídias"
     ])     
@endsection

@section('conteudo-menu') 
       
@endsection

@section('conteudo-view')

    {{-- 2 Váriáveis --}}
    @php
        $msgValidatorArr = \App\Services\MsgValidator::run($errors);
        $default_page = "midia";     
        
        //1) dados da tabela
        $idTabela   =0;       
        
        $tipo        ="1"; //sistema 
        $url         ="";
        $status      ="1";
        $em_uso      =""; //listas que estão usando este campo
        $titulo      ="";
        $legenda     ="";
        $descricao   ="";
        $url = "";
        //ver        
        $capa       = asset('images/padrao.jpg');
        $imgSrc     = "";

        if(isset($midia)):        
            $i=0;
            $tipo        ="1"; //sistema 
            $url         ="";
            $status      ="";
            $em_uso      =""; //listas que estão usando este campo
            $titulo      ="";
            $legenda     ="";
            $descricao   ="";
            $url = "";
            
            $idTabela    = $midia ? $midia->id : 0;            
            $tipo        = $midia ? $midia->tipo : '1';
            $url         = $midia ? $midia->url : '';
            $status      = $midia ? $midia->status : 0;
            $em_uso      = $midia ? $midia->em_uso : "";
            $titulo      = $midia ? $midia->titulo : '';
            $legenda     = $midia ? $midia->legenda : '';            
            $descricao   = $midia ? $midia->descricao : '';

            //ver
            $capa        = $midia ? $midia->getImagemAttribute() : $capa;
            $imgSrc      = $capa;
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
                                $rotaVer = env('APP_URL');
                                @endphp
                                <a href="{{$rotaVer}}">Ver</a>
                            </div>   

                            {{-- FORM DE UPDATE --}}
                            <form ref="formulario" action="{{ route('midia.update', $idTabela)}}" method="post" enctype="multipart/form-data">
                            @method('PUT')

                        <?php else: //STORE ?>    
                            <form ref="formulario" action="{{ route('midia.store')}}" method="post" enctype="multipart/form-data">
                        <?php endif;?>  
                        {{ csrf_field() }}
                        {{-- from --}}
                            {{-- Imagem de capa  --}}                           
                            @if ($idTabela)
                                <div class="content-wrapper">
                                    {{-- botões --}}
                                    <header>
                                        <h1>
                                            <i class="icon icone icon-010-picture title"></i>
                                            Preview
                                        </h1>
                                    </header>    
                                    <section>                               
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>Visualização da imagem</p>
                                            </div>                                            
                                        </div>                                        
                                    </section>
                                    {{-- CaPA Edição --}}                                    
                                    <section class="field">                                    
                                        <div class="row">
                                            <div class="col-lg-12  ">
                                                <div class="area-da-capa">
                                                    <div class="background-capa midia"
                                                    style="background-image:url(' <?php  echo $capa;?>')">                                               
                                                        @if (isset($capa))
                                                            <img 
                                                            ref="imgSrc" 
                                                            src="{{$capa}}" 
                                                            class="capa avatar form" alt="capa">
                                                        @endif                                        
                                                    </div>
                                                </div>                                        
                                                {{-- <capa opcoes="{{$options}}"></capa>                                         --}}
                                                
                                                @include('front.includes.formulario.Hidden',[
                                                    'input' => 'capa', 
                                                    'value'=> $capa,
                                                    'vmodel'=>'capa' //'vmodel'=>'avatar_icone'
                                                ])
                                                                                    
                                                @include('front.includes.formulario.Hidden',[
                                                    'input' => 'unsplashVar', 
                                                    'vmodel'=> 'unsplashVar'
                                                ])
                                            </div>                                            
                                        </div>
                                    </section>
                                </div>
                            @else 
                                {{-- upload  --}}
                                <div class="content-wrapper">
                                    {{-- botões --}}
                                    <header>
                                        <h1>
                                            <i class="icon icon painel"></i>
                                            Upload de novo Arquivo da Biblioteca
                                        </h1>
                                    </header>    
                                    <section>                               
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>Selecione o arquivo em seu compudador</p>
                                            </div>                                            
                                        </div>                                        
                                    </section>
                                    {{-- CaPA Edição --}}                                    
                                    <section class="field">                                    
                                        <div class="row">
                                            <div class="col-lg-12  ">
                                                <div class="area-da-capa">
                                                    <upload opcoes="{{$options}}"></upload>                                                     
                                                </div>                                        
                                                {{-- <capa opcoes="{{$options}}"></capa>                                         --}}                                                
                                                
                                            </div>                                            
                                        </div>
                                    </section>
                                </div>
                            @endif
                            @if ($idTabela)                                
                                <div class="content-wrapper">
                                    <header>
                                        {{-- 3 Nome da tela --}}
                                        <h1>
                                            <i class="icon icone icon-010-picture title"></i>
                                        @if ($idTabela > 0)
                                            Editando Arquivo da Biblioteca
                                        @else  
                                            Informações complementares
                                        @endif
                                        </h1>
                                    </header>     
                                
                                
                                    {{-- titulo --}}
                                    <section class="field">
                                        {{-- <header>                                        
                                            <p class="aproximar"><br></p>
                                        </header> --}}
                                        <div class="row">                                                                    
                                            @include('front.includes.formulario.Input', [
                                                'input'         => 'titulo',
                                                'label'         => 'Título',
                                                'old'           => old('titulo'),
                                                'inputCol'      => 'col-lg-10 titulo',
                                                'class'         => 'titulo' ,
                                                'ref'           => 'titulo', 
                                                //'vmodel'        => 'titulo',                                        
                                                'value'         =>  $titulo ,                                                 
                                                'placeholder'   => 'Título',
                                                'ajuda'         => '',                                                
                                                'validator'     => true,  
                                                'requerid'      => 'nono',                                           
                                                'msgValidator'  => isset($msgValidatorArr['titulo']) ? $msgValidatorArr['titulo'] : null,])

                                        </div>
                                    </section>

                                    {{-- legenda --}}
                                    <section class="field">
                                        {{-- <header>                                        
                                            <p class="aproximar"><br></p>
                                        </header> --}}
                                        <div class="row">                                                                    
                                            @include('front.includes.formulario.Input', [
                                                'input'         => 'legenda',
                                                'label'         => 'Legenda',
                                                'old'           => old('legenda'),
                                                'inputCol'      => 'col-lg-10 legenda',
                                                'class'         => 'legenda ' ,
                                                'ref'           => 'legenda',                                             
                                                'value'         =>  $legenda ,                                                 
                                                'placeholder'   => 'Legenda...',
                                                'ajuda'         => '',                                                
                                                'validator'     => true,  
                                                'requerid'      => 'nono',                                           
                                                'msgValidator'  => isset($msgValidatorArr['titulo']) ? $msgValidatorArr['titulo'] : null,])

                                        </div>
                                    </section>
                                    {{-- descricao --}}
                                    <section class="field">                                        
                                        <div class="row">   
                                                @include('front.includes.formulario.Textarea', [
                                                'input'         => 'descricao',
                                                'label'         => 'Resumo',                                         
                                                'class'         => 'descricao',
                                                'ref'           => 'descricao', 
                                                //'vmodel'        => 'descricao', 
                                                'old'           => old('descricao'),                                       
                                                'value'         =>  $descricao,                                            
                                                'placeholder'   => 'Um bom resumo, faz toda a diferença...',
                                                'requerid'      => 'no', 
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
                                                    'input'         => 'url',
                                                    'label'         => 'Url/nome', 
                                                    'old'           => old('url'),
                                                    'inputCol'      => 'col-lg-10 url',                                                                                    
                                                    'class'         => 'url',                                                
                                                    'ref'           => 'url',                                                 
                                                    'value'         =>  $url ,                                                
                                                    'requerid'      => 'requerid',                                             
                                                ])
                                            </div>
                                        </section>                                
                                    @else                                            
                                        @include('front.includes.formulario.Hidden', [
                                            'input' => 'url',
                                        ])
                                    @endif   
                                

                                    {{-- tipo --}}
                                    <section class="field">                                    
                                        <div class="row">
                                            <div class="col-lg-2 label-area ">
                                                <label for="">
                                                    Tipo
                                                </label>
                                            </div>
                                            <div class=" col-lg-10 field-input">                                                                                
                                                @include('front.includes.formulario.Radio',    ['input' => 'tipo','label' => 'Imagens do Sistema', 'value' => '1', 'checked'=> $tipo == '1' ? 'true' : 'false' ])
                                                @include('front.includes.formulario.Radio',    ['input' => 'tipo','label' => 'Capa de usuários', 'value' => '2', 'checked'  => $tipo == '2' ? 'true' : 'false' ])
                                                @include('front.includes.formulario.Radio',    ['input' => 'tipo','label' => 'Conquista', 'value' => '3', 'checked'  => $tipo == '3' ? 'true' : 'false' ])
                                                @include('front.includes.formulario.Radio',    ['input' => 'tipo','label' => 'Avatar de usuários', 'value' => '4', 'checked'=> $tipo == '4' ? 'true' : 'false' ])
                                                @include('front.includes.formulario.Radio',    ['input' => 'tipo','label' => 'Avatar do sistema', 'value' => '5', 'checked' => $tipo == '5' ? 'true' : 'false' ])                                                
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
                                                @include('front.includes.formulario.Radio',    ['input' => 'status','label' => 'Aprovada', 'value' => '1', 'checked' => $status == '1' ? 'true' : 'false'  ])
                                                @include('front.includes.formulario.Radio',    ['input' => 'status','label' => 'Pendente', 'value' => '0', 'checked' => $status == '0' ? 'true' : 'false' ])
                                                
                                            </div>
                                        </div>
                                    </section>
                                
                                {{-- aqui form --}}
                                {{-- endMagic --}}
                                </div> 
                            @endif    
                            
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
                                                    'value'=> $midia->aux_1,
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
                                                    'value'=> $midia->aux_2,
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
                            @if ($idTabela)
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
                                                    'rota'    => 'midia.update',
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
                            @endif

                            {{-- OCULTOS --}}
                            
                            @include('front.includes.formulario.Hidden',['input' => 'usuario_id','value' => $logado->id])                            
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
                                            action="{{ route('midia.destroy',$idTabela)}}" method="POST">
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
    <script src="{{ asset('js/gestao_midia_form.js') }}?ver={{env('VER')}}"></script>
@endsection