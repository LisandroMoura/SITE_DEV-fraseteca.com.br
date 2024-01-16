@extends('template.Usuario')

<style>
    @media (min-width: 1200px){
        .container.corpo{            
            max-width: 98% !important;
        }
    
    }
</style>


@section('css-view')
@endsection

@section('metadados')
     @include('back.includes.Backend', [
         "titulo" => "Gestão de usuários",
         "descricao" => "Fraseteca, Painel do admin - gestão de usuários"
     ])     
@endsection

@section('conteudo-menu') 
       
@endsection


@section('conteudo-view')
    @php        
        $default_page="usuarios";

    @endphp

<div class="page" id="app">
    @include('front.includes.Retorno')
    <bt-confirma :confirma="objConfirma"></bt-confirma>
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
                    @if ( $errors->any())
                        @if ($errors->first() == false && $errors->first() !='sucesso' )
                            <h1> {{$errors->all()['1']}}</h1>
                            <p>{{$errors->all()['2']}}</p>
                        @endif     
                    @endif
                    <div class="content-wrapper">
                        {{-- startMagic --}}
                        <header>
                            <h1>
                                <i class="icon icone icon-zynga title"></i>
                                Gestão de Usuários ({{$postsCount["todos"]}})                                 
                            </h1>
                            <p>Emails: verificados ({{$postsCount["verificados"]}}) | não verificados (<span style="color:#dc3545">{{$postsCount["naoverificados"]}}</span>)</p>
                            <a href="" class="btn bt-config icon-filter-svg"
                                :class="abreConfigClass"
                                 @click.stop.prevent="openConfig">                                                                                
                            </a>

                            <div class="painel-config">                                    
                                <div class="wrapp_config" :class="abreConfigClass">
                                    <ul>                                                
                                        <li>
                                            @include('back.includes.Filtro',[                
                                                'rota'   => 'admin.gestao_usuarios',
                                                'label'  => 'Filtrar:',
                                                'opt' => [
                                                    'ativos'    => 'Ativos',                
                                                    'suspensos' => 'Suspensos',                
                                                    'lixeira'   => 'Lixeira',
                                                    'todos'     => 'Todos',
                                                ]
                                            ])
                                        </li>
                                        
                                        <li>
                                            @include('back.includes.Pesquisalist',[                
                                                'rota'   => 'usuarios_pesquisa',
                                                // 'id'     => $logado->id,   
                                                'placeholder'  => 'Procurar por...',           
                                            ])
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </header>
                       

                        {{-- corpo --}}
                        <section>                               
                        
                            <div class="container col-sm-12" id="app">                        
                                @include('front.includes.formulario.Btadd',[                
                                    'rota'   => 'usuario.inserir',
                                    'icone'  => 'plus',
                                    'tip'  => 'Inserir Novo Usuário'
                                ]) 
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            {{-- <th scope="col">ID</th> --}}
                                            <th scope="col">Nome</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Email Verific</th>
                                            <th scope="col">Foto</th>                                            
                                            <th scope="col">Pasta Física</th>
                                            {{-- <th scope="col">Biografia</th>                     --}}
                                            <th scope="col">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach ($usuarios as $usuario)
                                            @php
                                                $avatar = $usuario->getAvatarAttribute() ? $usuario->getAvatarAttribute()  : "";
                                            @endphp
                                          
                                                <td class="w15">
                                                    <a href="{{ route('admin.gestao_usuarios_edit',$usuario->id)}}">
                                                            {{$usuario->name }}
                                                    </a>                                                                
                                                </td>
                                                <td class="w15">{{$usuario->email }}</td>

                                                <td class="w30">
                                                    @if ($usuario->email_verificado_dt)
                                                    <span style="background:#28a745;padding:5px;color: #fff; backgroung:">{{$usuario->email_verificado_dt}}</span>                                                                                                                
                                                    @else
                                                        <span style="background:#e52134;padding:5px;color: #fff; backgroung:">no! 🙁</span>
                                                    @endif
                                                </td>
                                    
                                                <td class="w15">    
                                                    <img src="{{$avatar}}" alt="ee" style="border-radius:100%;">
                                                </td>
                                                
                                                <td>
                                                    @if ($usuario->pastaExiste())
                                                        <span style="background:#e52134;padding:5px;color: #fff; backgroung:">{{$usuario->pastaExiste()}}</span>
                                                        
                                                    @endif
                                                </td>
                                                {{-- <td>R$ {{number_format($usuario->valor, 2,',','.' ) }}</td> --}}
                                                {{-- <td>{{$usuario->informacoes_biograficas ?? ""}}</td> --}}
                                                <td class="call-actions">
                                                    @if ($usuario->formatado_perfil!='Admin')                                
                                                        
                                                        <form class="form-box" action="{{ route('admin.gestao_usuarios_edit',$usuario->id)}}" method="GET">
                                                            {{ csrf_field() }}                                                                        
                                                            @include('front.includes.formulario.Hidden',['input' => 'id','value' => $usuario->id])
                                                            @include('front.includes.formulario.Btedit',['input' => 'Edit', 'label' => 'Edit','tip' => 'Editar'])
                                                        </form>
                                                        
                                                        @if ($usuario->formatado_status == 'Suspenso')
                                                            
                                                            <form ref="usuario_reativar{{$usuario->id}}" class="form-box" 
                                                                action="{{ route('usuario.reativar',$usuario->id)}}" method="POST">
                                                                {{ csrf_field() }}                                    
                                                                @method('PUT')
                                                                @include('front.includes.formulario.Hidden',['input' => 'id','value' => $usuario->id])
                                                                @include('front.includes.formulario.Btaction',[
                                                                    'input' => 'add', 
                                                                    'label' => 'Reativar', 
                                                                    'icone' => 'undo',                                            
                                                                    'class' => 'botao-padrao',
                                                                    'aviso'  => 'confirma aviso',
                                                                    'pergunta' => 'Desejas reativar usuário?', 
                                                                    'vaction'=> 'usuario_reativar'.$usuario->id,
                                                                    'tip' => 'Reativando o usuário'
                                                                    ])
                                                            </form>
                                                        @else
                                                            <form ref="usuario_suspender{{$usuario->id}}" class="form-box" 
                                                                action="{{ route('usuario.suspender',$usuario->id)}}" method="POST">
                                                                {{ csrf_field() }}                                    
                                                                @method('PUT')
                                                                @include('front.includes.formulario.Hidden',['input' => 'id','value' => $usuario->id])
                                                                @include('front.includes.formulario.Btaction',[
                                                                    'input' => 'add', 
                                                                    'label' => 'suspende', 
                                                                    'icone' => 'user-times',
                                                                    'class' => 'botao-padrao',
                                                                    'aviso'  => 'confirma info',
                                                                    'pergunta' => 'Desejas suspender o usuário?', 
                                                                    'vaction'=> 'usuario_suspender'.$usuario->id,
                                                                    'tip' => 'Suspendendo o usuário'
                                                                    ])
                                                            </form>
                        
                                                        @endif
                                                        @if ($usuario->formatado_status != 'Deletado')        
                                                            <form ref="usuario_deletar{{$usuario->id}}" class="form-box" 
                                                                action="{{ route('usuario.deletar',$usuario->id)}}" method="POST">
                                                                {{ csrf_field() }}                                    
                                                                @method('PUT')
                                                                @include('front.includes.formulario.Hidden',['input' => 'id','value' => $usuario->id])
                                                                @include('front.includes.formulario.Btaction',[
                                                                    'input' => 'add', 
                                                                    'label' => 'lixo', 
                                                                    'class' => 'botao-padrao red',
                                                                    'aviso'  => 'confirma aviso',
                                                                    'pergunta' => 'Desejas enviar para a lixeira o usuário?', 
                                                                    'vaction'=> 'usuario_deletar'.$usuario->id,
                                                                    'tip' => 'Enviar para a lixeira o usuário'
                                                                    ])
                                                            </form>
                                                        @else     
                                                            <form ref="usuario_retirar_lixeira{{$usuario->id}}" class="form-box" 
                                                                action="{{ route('usuario.retirarLixeira',$usuario->id)}}" method="POST">
                                                                {{ csrf_field() }}                                    
                                                                @method('PUT')
                                                                @include('front.includes.formulario.Hidden',['input' => 'id','value' => $usuario->id])
                                                                @include('front.includes.formulario.Btaction',[
                                                                    'input' => 'add', 
                                                                    'label' => 'saiDoLixo', 
                                                                    'icone' => 'undo',
                                                                    'class' => 'botao-padrao',
                                                                    'aviso'  => 'confirma aviso',
                                                                    'pergunta' => 'Desejas tirar da lixeira o usuário?', 
                                                                    'vaction'=> 'usuario_retirar_lixeira'.$usuario->id,
                                                                    'tip' => 'Tirar da lixeira o usuário'
                                                                    ])
                                                            </form>
                                                        @endif
                                                        <form ref="usuario_delete{{$usuario->id}}" class="form-box" 
                                                            action="{{ route('usuario.destroy',$usuario->id)}}" method="POST">
                                                            {{ csrf_field() }}                                    
                                                            {{method_field('DELETE')}}
                                                            @method('DELETE')
                                                            @include('front.includes.formulario.Hidden',['input' => 'id','value' => $usuario->id])
                                                            @include('front.includes.formulario.Btaction',[
                                                                'input' => 'add',                                             
                                                                'aviso'  => 'confirma cuidado',
                                                                'label' => 'destroy',  
                                                                'class' => 'botao-padrao red',                                               
                                                                'pergunta' => 'Deseja deletar para sempre?', 
                                                                'vaction'=> 'usuario_delete'.$usuario->id,                                        
                                                                'tip'    => 'Destruir de vez'
                                                                ])
                                                        </form> 

                                                        {{-- ver perfil --}}

                                                        <a href="{{"/perfil/".$usuario->name. '.' .$usuario->id}}" 
                                                           title="Veja como este perfil é visto no site" 
                                                           class="botao-padrao">Ver</a>                                                       
                        
                                                    @else
                                                        <span class="btn_restrito">restrito</span>                                
                                                    @endif
                        
                        
                                                </td>
                                            </tr> 
                                        @endforeach
                                    </tbody>
                                </table>        
                                 {{$usuarios->links()}}
                            </div>

                        

                            
                         
                            
                        </section>
                        {{-- endMagic --}}     
                    </div>                      
                </div>
            
            </div>               
        </div>

        {{-- foter --}}
        @include('front.includes.Footer')
    </div> 
</div>
  

@endsection
@section('js-view')
    <script src="{{ asset('js/default.js') }}"></script>
@endsection