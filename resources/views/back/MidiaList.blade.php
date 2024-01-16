@extends('template.Usuario')

@section('css-view')
@endsection

@section('metadados')
     @include('back.includes.Backend', [
         "titulo" => "Gestão de Post",
         "descricao" => "Fraseteca, Painel do admin - gestão de posts"
     ])     
@endsection

@section('conteudo-menu') 
       
@endsection


@section('conteudo-view')
    @php
        $default_page="midia";
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
                                <i class="icon icone icon-010-picture title"></i>
                                Gestão de Bibliotecas
                            </h1>
                            <a href="" class="btn bt-config icon-filter-svg"
                                    :class="abreConfigClass"
                                     @click.stop.prevent="openConfig">                                                                                
                                </a>

                                <div class="painel-config">                                    
                                    <div class="wrapp_config" :class="abreConfigClass">
                                        <ul>                                                
                                            <li>
                                                @include('back.includes.Filtro',[                
                                                    'rota'   => 'admin.gestao_midias',
                                                    'label'  => 'Filtrar:',
                                                    'opt' => [
                                                        'sistema'   => 'Imagens do Sistema',                                
                                                        'avatar_sis'   => 'Avatar do sistema',
                                                        'usuario'   => 'Capa de usuários',
                                                        'avatar'   => 'Avatar de usuários',                
                                                        'pendentes' => 'Pendentes',
                                                        'todas'     => 'Todas',
                                                    ]
                                                ])
                                            </li>
                                            
                                            <li>
                                                @include('back.includes.Pesquisalist',[                
                                                    'rota'   => 'midias_pesquisa',
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
                                    'rota'   => 'midia.inserir',
                                    'icone'  => 'plus',
                                    'tip'  => 'Inserir Novo Usuário'
                                ]) 
                                <table class="table table-hover">
                                    <thead>
                                        <tr>                    
                                            <th scope="col">ID</th>
                                            <th scope="col">Tipo</th>
                                            {{-- <th scope="col">Título</th> --}}
                                            <th scope="col">View</th>                    
                                            {{-- <th scope="col">URL</th>                     --}}
                                            <th scope="col">Usuario</th>
                                            <th scope="col">Em Uso</th>                    
                                            <th scope="col">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($midias as $midia)
                                            
                                            @switch($midia->status)
                                                @case('1')
                                                    <tr>                            
                                                    @break
                                                @case('2')
                                                    <tr style="" class="table-danger">                            
                                                    @break
                                                @case('0')
                                                    <tr style="" class="table-danger">                                                        
                                                @break
                                                
                                                @default
                                                    <tr>                            
                                            @endswitch
                                                <td>
                                                    <a href="{{ route('admin.gestao_midias_edit',$midia->id)}}">
                                                            {{$midia->id }}
                                                    </a>                                                                
                                                </td>
                                                <td>{{$midia->formatado_tipo }}</td>
                                                {{-- <td>{{$midia->titulo }}</td> --}}
                                                <td>
                                                    <a href="{{ $midia->getImagemAttribute() }}" 
                                                        target="blank" class="box-img">
                                                        <img src="{{ $midia->getImagemAttribute() }}" alt="img">
                                                    </a>
                                                </td>                        
                                                {{-- <td>
                                                    /images/conquistas/{{$midia->url}}
                                                </td> --}}
                                                <td>{{$midia->usuario->nome_completo }}</td>
                                                <td>
                                                    <a href="{{$midia->getEmUsoAttribute('url')}}">
                                                        {{$midia->getEmUsoAttribute('nome')}}
                                                    </a>
                                                </td>                        
                                                <td class="call-actions">    
                                                    <form class="form-box" action="{{ route('admin.gestao_midias_edit',$midia->id)}}" method="GET">
                                                        {{ csrf_field() }}                                                                        
                                                        @include('front.includes.formulario.Hidden',['input' => 'id','value' => $midia->id])
                                                        @include('front.includes.formulario.Btedit',['input' => 'Edit', 'label' => 'Edit','tip' => 'Editar'])
                                                    </form>                                
                                                    <form ref="midia_delete{{$midia->id}}" class="form-box" 
                                                        action="{{ route('midia.destroy',$midia->id)}}"
                                                        method="POST">
                                                        {{ csrf_field() }}                                    
                                                        {{method_field('DELETE')}}
                                                        @method('DELETE')
                                                        @include('front.includes.formulario.Hidden',['input' => 'id','value' => $midia->id])
                                                        @include('front.includes.formulario.Btaction',[
                                                            'input' => 'add',                                             
                                                            'aviso'  => 'confirma cuidado',
                                                            'label' => 'deletar',  
                                                            'class' => 'botao-padrao red',                                               
                                                            'pergunta' => 'ATENÇÃO! Deseja realmente deletar para sempre?', 
                                                            'vaction'=> 'midia_delete'.$midia->id,                                        
                                                            'tip'    => 'Destruir de vez'
                                                            ])
                                                    </form> 
                                                </td>
                                            </tr> 
                                        @endforeach
                                    </tbody>
                                </table>        
                                 {{$midias->links()}}
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