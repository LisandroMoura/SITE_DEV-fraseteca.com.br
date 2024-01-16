@extends('template.Usuario')

@section('css-view')
@endsection

@section('metadados')
    {{-- 1 html header --}}
     @include('back.includes.Backend', [
         "titulo" => "Lista de Frases",
         "descricao" => "Lista de Frases, Editar ou criar Usuários"
     ])     
@endsection

@section('conteudo-menu') 
       
@endsection

@section('conteudo-view')

    {{-- 2 Váriáveis --}}
    @php
        $msgValidatorArr = \App\Services\MsgValidator::run($errors);
        $default_page    = "usuarios";
        
        //1) dados da tabela
        $informacoes_biograficas="";
        $idTabela               =0;        
        $pasta                  ="";
        $nome_completo          ="";
        $name                   ="";
        $email                  ="";
        $status                 ="";
        $email                  ="";
        $email_verificado_dt    ="";        

        if(isset($usuario)):        
            $i=0;
            $idTabela               = $usuario ? $usuario->id : 0;            
            $informacoes_biograficas= $usuario ? $usuario->informacoes_biograficas : '';
            $pasta                  = $usuario ? $usuario->pasta  :'';
            $nome_completo          = $usuario ? $usuario->nome_completo :'';
            $name                   = $usuario ? $usuario->name :'';
            $email                  = $usuario ? $usuario->email  :'';
            $email_verificado_dt    = $usuario ? $usuario->email_verificado_dt :'';
            $status                 = $usuario ? $usuario->status :'0';
            //1) receber o campo que vem da tabela do usuário ( aqui seria o conquista_id)
            $conquista_id           = $usuario ? $usuario->conquista_id : null;
            $conquistas             = "";
        endif;
        
        //2 Conquistas: arrays vazios
        $conquista_Dados          = [];
        $conquistasDoUser         = [];
        $listatConquistas         = [];
        if (!isset($tbConquistasDoUser)) $tbConquistasDoUser=[];
        if (!isset($usuario)) $usuario=[];
        //aqui no caso não precisaria explodir a lista conquistas
        foreach ($tbConquistasDoUser as $key => $conquistaUser) {
            # code...
            $listatConquistas[] = $conquistaUser->nome;
        }
        if(isset($conquistasum)):
            foreach ($conquistasum as $key => $conquista) {
                if(!in_array($conquista->nome,$listatConquistas)){
                    //$bancoDeConquistas.=$conquista->descricao.',';
                    $conquista_Dados[$conquista->nome] = $conquista->id;                             
                }
                else{
                    $conquistasDoUser[$conquista->nome] = $conquista->id; 
                }
            }
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
                                $rotaVer = env('APP_URL').'/perfil/'.$name.".".$idTabela;
                                @endphp
                                <a href="{{$rotaVer}}">Ver</a>
                            </div>   

                            {{-- FORM DE UPDATE --}}
                            <form ref="formulario" action="{{ route('usuario.update', $idTabela)}}" method="post" enctype="multipart/form-data">
                            @method('PUT')

                        <?php else: //STORE ?>    
                            <form ref="formulario" action="{{ route('usuario.store')}}" method="post" enctype="multipart/form-data">
                        <?php endif;?>  
                        {{ csrf_field() }}
                        {{-- from --}}
                            <div class="content-wrapper">
                                <header>
                                    {{-- 3 Nome da tela --}}
                                    <h1>
                                        <i class="icon icone icon-zynga title"></i>
                                       @if ($idTabela > 0)
                                           Editando Usuários
                                       @else  
                                        Criando Usuários
                                       @endif
                                    </h1>
                                    <p>
                                        Login pode ser feito pelo ID: 
                                        <strong>{{$name}} </strong>
                                        Ou pelo email: 
                                        <strong>{{$email}} </strong>
                                    </p>
                                    <section>
                                        <h2>Visão do GM</h2>
                                        <p>
                                            <a href="{{"/perfil/".$usuario->name. '.' .$usuario->id}}" 
                                                title="Veja como este perfil é visto no site" 
                                                style="padding:15px;"
                                                class="bt-ver-perfil">Ver Perfil (site)</a>
                                                |
                                            <a href="{{route("usuario.edit", $usuario->id)}}" 
                                                title="Veja como este perfil é visto no site" 
                                                style="padding:15px;"
                                                class="bt-ver-perfil">Editar o seu perfil</a>
                                                |
                                            <a href="{{"/feed?token_reverso=".$usuario->id}}" 
                                                title="Veja como este perfil é visto no site" 
                                                style="padding:15px;"
                                                class="bt-ver-perfil">Ver seu feed</a>
                                                |
                                            <a href="{{"/minhas-frases?token_reverso=".$usuario->id}}" 
                                                    title="Veja como este perfil é visto no site" 
                                                    style="padding:15px;"
                                                    class="bt-ver-perfil">Ver suas pastas</a>
                                        </p>
             
                                        @if(!$usuario->pastaExiste()=="" && $usuario->email_verificado_dt)
                                            <a class="btn-sucess" href="#recriar_pasta" style="background:#cf371c;padding: .7em 25px; display: block;width: 310px;border-radius: 5px;">
                                            <span class="icon-zynga" style="color:#fff"> ATENÇÂO! Pasta não existe, precisamos REcriar Estutura de Pastas</span></a>
                                        @endif

                                        <br>
                                        <br>
                                        <p>

                                            @if (!$usuario->email_verificado_dt)
                                                <a class="btn-sucess" href="#recriar_pasta" style="background:#cf371c;padding: .7em 25px; display: block;width: 310px;border-radius: 5px;">
                                                <span class="icon-zynga" style="color:#fff"> Email ainda não verificado 🙁</span></a>
                                            @endif
                                        </p>

                                    </section>


                                    
                                    
                                    
                                    @php $imagem     = $usuario->getAvatarNoPerfilAttribute(); @endphp                                                                       
                                    <img src="{{$imagem}}" alt="perfil" style="width: 123px;margin: 0 auto;display: block;border-radius: 100%;position: absolute;top: -22px;right: 0;">
                                </header>                      

                                {{-- name --}}                                
                                <section class="field">
                                    <div class="row">                                          
                                        @include('front.includes.formulario.Input', [
                                            'input'         => 'name',
                                            'label'         => 'Id: Login', 
                                            'old'           => old('name'),
                                            'inputCol'      => 'col-lg-10 name',                                                                                    
                                            'class'         => 'name validar naovazio',                                                
                                            'ref'           => 'name',                                                 
                                            'value'         =>  $name ,                                             
                                            'ajuda'         => 'Login do usuário, muda o id do usuário no sistema',
                                            'requerid'      => '',                                             
                                        ])
                                    </div>
                                </section>


                                {{-- name --}}                                
                                <section class="field">
                                    <div class="row">                                          
                                        @include('front.includes.formulario.Input', [
                                            'input'         => 'nome_completo',
                                            'label'         => 'Nome de usuário', 
                                            'old'           => old('nome_completo'),
                                            'inputCol'      => 'col-lg-10 name',                                                                                    
                                            'class'         => 'name validar naovazio',                                                
                                            'ref'           => 'nome_completo',                                                 
                                            'value'         =>  $nome_completo,
                                            'ajuda'         => 'Nome do usuário',
                                            'requerid'      => 'requerid',                                             
                                        ])
                                    </div>
                                </section>


                                {{-- Email --}}                                
                                <section class="field">
                                    <div class="row">                                          
                                        @include('front.includes.formulario.Input', [
                                            'input'         => 'email',
                                            'label'         => 'email', 
                                            'old'           => old('email'),
                                            'inputCol'      => 'col-lg-10 email',                                                                                    
                                            'class'         => 'email validar naovazio',
                                            'ref'           => 'email',
                                            'value'         =>  $email ,                                             
                                            'ajuda'         => 'Email do usuário',
                                            'requerid'      => 'requerid',                                             
                                        ])
                                    </div>
                                </section>
                                {{-- Email --}}                                
                                <section class="field">
                                    <div class="row">                                          
                                        @include('front.includes.formulario.Input', [
                                            'input'         => 'email_verificado_dt',
                                            'label'         => 'Email Verificado', 
                                            'old'           => old('email_verificado_dt'),
                                            'inputCol'      => 'col-lg-10 email_verificado_dt',                                                                                    
                                            'class'         => 'validasr ',
                                            'ref'           => 'email_verificado_dt',
                                            'value'         =>  $email_verificado_dt ,               
                                            'placeholder'   =>  "Email ainda não verificado! Ex: 2021-10-25" ,                                                                                         
                                            'ajuda'         => 'Data da Verificação do email ex: 2021-10-25',
                                             
                                        ])
                                    </div>
                                </section>
                                {{-- informacoes_biograficas --}}
                                <section class="field">                                        
                                    <div class="row">   
                                            @include('front.includes.formulario.Textarea', [
                                            'input'         => 'informacoes_biograficas',
                                            'label'         => 'Bio',                                         
                                            'class'         => 'informacoes_biograficas ',
                                            'ref'           => 'informacoes_biograficas', 
                                            //'vmodel'        => 'resumo', 
                                            'old'           => old('informacoes_biograficas'),                                       
                                            'value'         =>  $informacoes_biograficas,                                            
                                            'placeholder'   => 'Um bom resumo, faz toda a diferença...',
                                            //'requerid'      => 'requerid', 
                                            'ajuda'         => 'Mínimo 110, máximo 240',
                                            'width'         => '100%', 
                                            'cols'          => '5', 
                                            'rows'          => '3', 
                                            'V_SIZE'=>'240'
                                        ]) 
                                            
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
                                            @include('front.includes.formulario.Radio',    ['input' => 'status','label' => 'Pendente(email)', 'value' => '0', 'checked' => $status == '0' ? 'true' : 'false' ])
                                            @include('front.includes.formulario.Radio',    ['input' => 'status','label' => 'Ativo', 'value' => '1', 'checked' => $status == '1' ? 'true' : 'false'  ])
                                            @include('front.includes.formulario.Radio',    ['input' => 'status','label' => 'Suspenso', 'value' => '1', 'checked' => $status == '2' ? 'true' : 'false'  ])
                                            @include('front.includes.formulario.Radio',    ['input' => 'status','label' => 'Lixeira', 'value' => '1', 'checked' => $status == '3' ? 'true' : 'false'  ])

                                        </div>
                                    </div>
                                </section>

                            {{-- aqui form --}}
                            {{-- endMagic --}}
                            </div> 


                             {{-- Conquistas  --}}
                             @if ($idTabela)
                             <div class="content-wrapper">
                                 {{-- botões --}}
                                 <header>
                                     <h1>
                                         <i class="icon icon painel"></i>
                                         Conquistas
                                     </h1>
                                 </header>    
                                 <section>                               
                                     <div class="row">
                                         <div class="col-lg-12">
                                             <p>Todas as <strong>conquistas</strong> disponíveis para este usuário.</p>
                                         </div>                                            
                                     </div>                                        
                                 </section>
                                 {{-- campos --}}
                                 {{-- Conquistas --}}                                
                                 <section>                                                                   
                                    <div class="row">
                                        <div class="col">

                                            {{-- 
                                                // Aqui criar o .vue das conquistas                                                
                                                // criar o hidden com as conquistas
                                                // Não esquecer de salvar as conquistas_usuarios
                                                
                                            --}}
                                             <conquistas 
                                            opcoes="{{$options}}"
                                            listaconquistas="{{json_encode($conquistasDoUser)}}"
                                            conquistadados="{{json_encode($conquista_Dados)}}"
                                            ></conquistas>  
                                            @include('front.includes.formulario.Hidden', [
                                                'input'         => 'conquistas',
                                                'label'         => 'Conquistas',                                         
                                                'class'         => 'conquistas',                                        
                                                'ref'           => 'conquistas', 
                                                'vmodel'        => 'conquistas',
                                                'ajuda'         => 'Separe com vírgulas',
                                                'value'         =>  $conquistas ,                                        
                                                'class'         => 'conquistas',
                                            ]) 
                                        </div>
                                    </div>
                                </section>                                                                
                             </div>
                         @endif



                            {{-- PASTA  --}}
                            @if ($idTabela)
                                <div class="content-wrapper">
                                    {{-- botões --}}
                                    <header>
                                        <h1>
                                            <i class="icon icon painel"></i>
                                            Pasta
                                        </h1>
                                    </header>    
                                    <section>                               
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>Você poderá <strong>RE</strong>criar a estrutura de pastas para o usuário, caso tenha dado alguma falha na criação.</p>
                                            </div>                                            
                                        </div>                                        
                                    </section>
                                    {{-- campos --}}
                                    {{-- pasta --}}                                
                                    <section class="field">                                    
                                        <div class="row">
                                            <div class="col-lg-6 field-input ">
                                                <div class="row">
                                                    @include('front.includes.formulario.Input',  [
                                                    'input' => 'pasta',
                                                    'value'=> $pasta,
                                                    'labelCol' => 'col-lg-4', 
                                                    'inputCol' => 'col-lg-8', 
                                                    'label'=> 'Pasta',
                                                    'placeholder' => 'pasta',
                                                    'requerid'=> 'nnn',
                                                    'ajuda'=> 'pasta do sistema'])

                                                </div>
                                            </div>
                                      
                                        </div>
                                    </section>                                                                
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
                                                    'value'=> $usuario->aux_1,
                                                    'labelCol' => 'col-lg-4', 
                                                    'inputCol' => 'col-lg-8', 
                                                    'label'=> 'Top Usuário?',
                                                    'placeholder' => 'valores auxiliares',
                                                    'requerid'=> 'nnn',
                                                    'ajuda'=> '"Sim" para colocar o usuário como TOP no TOPO'])

                                                </div>
                                            </div>
                                            <div class=" col-lg-6 field-input">
                                                <div class="row">
                                                    @include('front.includes.formulario.Input',  [
                                                    'input' => 'aux_2', 
                                                    'value'=> $usuario->aux_2,
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
                                            <p>Salvar o registro </p>
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
                                                'rota'    => 'usuario.update',
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

                        @if ($idTabela)
                            <div class="content-wrapper" id="recriar_pasta">
                                <header>
                                    <h1>
                                        <i class="icon atention"></i>
                                        Recriar Estrutura de Pasta
                                    </h1>
                                </header>    
                                <section>                               
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <h3>Sistema de REcriação da pasta do usuário</h3>
                                            <p>Além de criar a pasta, o sistema vai criar um arquivo chamado <b>avatar.svg</b> e outro <b>index.php</b> dentro desta pasta</p>
                                            <p>PS: só será criada esta pasta, caso ela não exista no sistema, se a pasta já existir, o sistema fará NADA.</p>
                                        </div>    
                                        <div class="col-lg-3">
                                            @php
                                                $vaction  ='recriar_pasta'.$idTabela;
                                                $pergunta ='Confirma o processo de recriar a pasta do usuário?';
                                                $aviso    = 'confirma cuidado';
                                            @endphp    

                                            <form ref="recriar_pasta{{$idTabela}}" class="form-box" 
                                            action="{{ route('usuario.recriarPasta')}}" method="POST">
                                            {{ csrf_field() }}                                    
                                            @method('POST')
                                            @include('front.includes.formulario.Hidden',['input' => 'id','value' => $idTabela])
                                            
                                            <a                                         
                                            href="" 
                                            v-on:click="getConfirm('{{$vaction}}', $event, '{{$pergunta ?? "Confirma esta operação:?"}}', '{{$aviso ?? "atencao"}}')"
                                            class="bt-link bt-rosa bt-center"                                           
                                            title="Recriar">
                                            Recriar AGORA JÁ!
                                            </a>
                                            </form>                                                                                        
                                                
                                        </div>
                                    </div>
                                </section>
                            </div>

                            {{-- Excluir Lista --}}
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
                                            action="{{ route('usuario.destroy',$idTabela)}}" method="POST">
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

                            {{-- Tabela de listas --}}
                            <div class="content-wrapper">
                                <header>
                                    <h1>
                                        <i class="icon painel"></i>
                                        Listas deste usuário
                                    </h1>
                                </header>    
                                <section>                               
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Editar Lista</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Link do User</th>                                                                                
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach ($listas as $lista)
                                            
                                                        @switch($lista->formatado_status)
                                                            @case('Publicada')
                                                                <tr style="" class="suspenso table-secondary">                            
                                                                @break
                                                            @case('Revisão')
                                                                <tr style="" class="suspenso table-info">
                                                                @break
                                                            
                                                                @case('Deletada')
                                                                <tr style="" class="suspenso table-danger">                                                        
                                                                @break
                                                            @default                        
                                                                <tr>                            
                                                        @endswitch
                                                            {{-- <th>{{$lista->id}}</th> --}}
                                                            <td>
                                                                @if ($lista->formatado_status == 'Publicada')
                                                                    <a href="{{$lista->formatado_link}}">Lista:{{$lista->formatado_titulo }}</a>
                                                                @else
                                                                    @if ($lista->formatado_status != 'Deletada')
                                                                        <a href="{{ route('lista.edit',$lista->id)}}">Lista:{{$lista->formatado_titulo }}</a>                                    
                                                                    @else 
                                                                        <a>{{$lista->formatado_titulo }}</a>                                    
                                                                    @endif                                
                                                                @endif                            
                                                            </td>                                                                                    
                                                            <td>{{$lista->formatado_status }}</td>
                                                            <td><a href="{{$lista->getLinkAttribute() }}">User: {{$lista->formatado_titulo }}</a></td>
                                                            
                                                            <td>      
                                                                @if ( $lista->formatado_status=='Publicada' || $lista->formatado_status=='Em Edição')
                                                                    <form class="form-box" 
                                                                        action="{{ route('lista.edit',$lista->id)}}" method="GET">
                                                                        {{ csrf_field() }}                                                                        
                                                                        @include('front.includes.formulario.Hidden',['input' => 'id','value' => $lista->id])
                                                                        @include('front.includes.formulario.Btedit',['input' => 'Edit', 'label' => '','tip' => 'Editar'])
                                                                    </form>
                                                                @endif
                                                                @if ($lista->formatado_status=='Em Edição')
                                                                    <form ref="solicita_revisao{{$lista->id}}" class="form-box" id="revisao_{{$lista->id}}" 
                                                                        action="{{ route('lista.revisao',$lista->id)}}" method="POST">
                                                                            {{ csrf_field() }}                                    
                                                                            @method('PUT')
                                                                            @include('front.includes.formulario.Hidden',['input' => 'id','value' => $lista->id])
                                                                            @include('front.includes.formulario.Btaction',[
                                                                                'input' => 'add',
                                                                                'label' => '', 
                                                                                'aviso'  => 'confirma info',
                                                                                'pergunta' => 'Deseja solicitar a revisão desta lista?', 
                                                                                'vaction'=> 'solicita_revisao'.$lista->id,
                                                                                'tip' => 'Solicitar Revisão'
                                                                            ])
                                                                    </form>
                                                                @endif                            
                                                                
                                                                @if ($lista->formatado_status == 'Em Edição' || $lista->formatado_status == 'Revisão')                                                                
                                                                    @if ($lista->formatado_status == 'Revisão' )
                                                                        <form ref="cancela_revisao{{$lista->id}}" class="form-box" 
                                                                            action="{{ route('lista.cancelarRevisao',$lista->id)}}" method="POST">                                    
                                                                            {{ csrf_field() }}                                    
                                                                            @method('PUT')
                                                                            @include('front.includes.formulario.Hidden',['input' => 'id','value' => $lista->id])
                                                                            @include('front.includes.formulario.Btaction',[
                                                                                'input' => 'add', 
                                                                                'label' => '', 
                                                                                'aviso'  => 'confirma atencao',
                                                                                'pergunta' => 'Confirma cancelar esta revisão da lista?', 
                                                                                'vaction'=> 'cancela_revisao'.$lista->id,
                                                                                'icone'=> 'stop-circle',
                                                                                'tip' => 'Cancelar Revisão'
                                                                                ])
                                                                        </form>                                                                                         
                                                                    @endif                                    
                                        
                                                                    <form ref="enviar_lixeira{{$lista->id}}" class="form-box" action="{{ route('lista.lixeira',$lista->id)}}" method="POST">
                                                                        {{ csrf_field() }}                                    
                                                                        @method('PUT')
                                                                        @include('front.includes.formulario.Hidden',['input' => 'id','value' => $lista->id])
                                                                        @include('templates.formularios.bt_deletar',[
                                                                            'input' => 'add', 
                                                                            'label' => '', 
                                                                            'aviso'  => 'confirma cuidado',
                                                                            'pergunta' => 'ATENÇÃO! Deseja realmente deletar?', 
                                                                            'vaction'=> 'enviar_lixeira'.$lista->id,
                                                                            'tip' => 'Mover para a Lixeira'
                                                                            ])
                                                                    </form>                                                 
                                                                @endif
                                                                @if ($lista->formatado_status == 'Deletada' )
                                                                    <form ref="removerLixeira{{$lista->id}}" class="form-box" 
                                                                        action="{{ route('lista.removerLixeira',$lista->id)}}" method="POST">
                                                                        {{ csrf_field() }}                                    
                                                                        @method('PUT')
                                                                        @include('front.includes.formulario.Hidden',['input' => 'id','value' => $lista->id])
                                                                        @include('front.includes.formulario.Btaction',[
                                                                            'input' => 'add', 
                                                                            'label' => '', 
                                                                            'icone' => 'undo',
                                                                            'aviso'  => 'confirma aviso',
                                                                            'pergunta' => 'Deseja retirar da lixeira esta lista?', 
                                                                            'vaction'=> 'removerLixeira'.$lista->id,
                                                                            'tip' => 'Retirar da Lixeira'
                                                                            ])
                                                                    </form>
                                                                @endif
                                        
                                                            </td>
                                                        </tr> 
                                                    @endforeach
                                            </tbody>
                                        </table>
                            
                                        </div>
                                    </div>
                                </section>
                            </div>

                            {{-- Frases Favoritas deste  --}}

                            @if (isset($usuario) ) 
                                <div class="content-wrapper">
                                <header>
                                    <h1>
                                        <i class="icon favorito"></i>
                                        Frases curtidas e favoritadas por este usuário
                                    </h1>
                                </header>    
                                <section>                               
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">idFrase</th>
                                                    <th scope="col">Descrição da Frase</th>                                                    
                                            </thead>
                                            <tbody>

                                                @foreach ($frasesFavoritas as $frase)                                                
                                                    <tr>
                                                        <td>{{$frase->frase_id }}</td>
                                                        <td>{{$frase->frase }}</td>                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                            
                                        </div>
                                    </div>
                                </section>
                            </div>
                                
                            @endif
                            
                            
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
    <script src="{{ asset('js/padrao_admin_editar_cadsimples.js') }}?ver={{env('VER')}}"></script>    
@endsection