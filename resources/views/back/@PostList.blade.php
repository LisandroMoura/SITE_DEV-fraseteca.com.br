@extends('template.Admin')
<style>
    @media (min-width: 1200px){
        .container.corpo{            
            max-width: 90% !important;
        }
    
    }
</style>
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
        $default_page="posts";
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
                                    <i class="icon icone icon-007-copy title"></i>
                                    Gestão de Posts-Listas ({{$postsCount['ativos'] +$postsCount['edicao'] + $postsCount['rascunho'] }})
                                </h1>
                                <span>Publicados: <strong style="color:#20ad83">{{$postsCount['ativos']}}</strong> | </span>                                
                                <span>Edicao: {{$postsCount['edicao']}} | </span>
                                <span>Rascunho: {{$postsCount['rascunho']}} </span>
                                <a href="" class="btn bt-config icon-filter-svg"
                                    :class="abreConfigClass"
                                     @click.stop.prevent="openConfig">                                                                                
                                </a>

                                <div class="painel-config">                                    
                                    <div class="wrapp_config" :class="abreConfigClass">
                                        <ul>                                                
                                            <li>
                                                @include('back.includes.Filtro',[                
                                                    'rota'   => 'admin.gestao_posts',
                                                    'label'  => 'Filtrar:',
                                                    'opt' => [
                                                        'edicao'        => 'Em edição',
                                                        'publicados'    => 'Publicado',                
                                                        'rascunho'      => 'Rascunho',                
                                                        'lixeira'       => 'Lixeira',
                                                        'todos'         => 'Todos',
                                                        'institucional'  => 'Institucional',
                                                    ]
                                                ])
                                            </li>
                                            
                                            <li>
                                                @include('back.includes.Pesquisalist',[                
                                                    'rota'   => 'posts_pesquisa',
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
                                <div class="container col-sm-12">
                                
                                    @include('front.includes.formulario.Btadd',[                
                                        'rota'   => 'post.inserir',
                                        'icone'  => 'plus',
                                        'tip'  => 'Inserir Novo Post'
                                    ]) 
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Título</th>
                                                <th scope="col">Status</th>                    
                                                <th scope="col">Com Capa?</th>
                                                <th scope="col">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($posts as $post)                    
                                                @switch($post->formatado_status)
                                                    @case('Rascunho')
                                                        <tr style="" class="suspenso table-secondary">                            
                                                        @break
                                                    @case('Em edição')
                                                        <tr style="" class="suspenso table-secondary">                            
                                                        @break
                                                    @case('Deletado')
                                                        <tr style="" class="suspenso table-danger">                                                        
                                                    @break

                                                    @case('Deletado | email não confirmado')
                                                        <tr style="" class="suspenso table-danger">                                                        
                                                    @break
                                                    
                                                    @default
                                                        <tr>                            
                                                @endswitch                        
                                                    <td class="w50">
                                                        <a href="{{ route('post.edit',$post->id)}}">
                                                                {{$post->titulo }}
                                                        </a>                                                                
                                                    </td>
                                                    <td class="w15">
                                                        @if ($post->formatado_status == 'Publicado')
                                                            <span class="publicado">
                                                                {{$post->formatado_status }}    
                                                            </span>
                                                        @else 
                                                            {{$post->formatado_status }}
                                                        @endif

                                                    </td>
                                                    
                                                    <td class="w15">
                                                        @if ($post->capa != "https://fraseteca.com.br/storage/images/thumbnail.jpg.jpg")
                                                            {{-- <img src="{{$post->capa}}" alt="capa" style="max-height:70px;"> --}}
                                                            <span class="sim"><i class="icon icone icon-010-picture"></i></span>
                                                        @endif
                                                        
                                                    </td>
                                                    <td class="call-actions w45">
                                                        @php
                                                        $rotaVer = env('APP_URL').'/'.$post->urlamigavel;
                                                        @endphp
                                                        @include('front.includes.formulario.Btactionlink',[
                                                                'input' => 'btlink',
                                                                'label' => '', 
                                                                'icone' => '',  
                                                                'tip'   => 'Ver no site',
                                                                'class' => 'btn bt-call bt-ver icon-hand-pointer-o',
                                                                'rota' =>$rotaVer 
                                                                ]
                                                                )
                                                            
                                                        <form class="form-box" action="{{ route('post.edit',$post->id)}}" method="GET">
                                                            {{ csrf_field() }}                                                                        
                                                            @include('front.includes.formulario.Hidden',['input' => 'id','value' => $post->id])
                                                            @include('front.includes.formulario.Btedit',['input' => 'Edit', 'label' => '','tip' => 'Editar'])
                                                        </form>
                                                        
                                                    
                                                        @if ($post->formatado_status != 'Deletado')        
                                                            <form ref="post_deletar{{$post->id}}" class="form-box" 
                                                                action="{{ route('post.lixeira',$post->id)}}" method="POST">
                                                                {{ csrf_field() }}                                    
                                                                @method('PUT')
                                                                @include('front.includes.formulario.Hidden',['input' => 'id','value' => $post->id])
                                                                @include('front.includes.formulario.Btaction',[
                                                                    'input' => 'add', 
                                                                    'label' => '', 
                                                                    'icone' => 'icon-trash',
                                                                    'class' => 'bt-call btn-warning',
                                                                    'aviso'  => 'confirma aviso',
                                                                    'pergunta' => 'Desejas enviar para a lixeira o Post?', 
                                                                    'vaction'=> 'post_deletar'.$post->id,
                                                                    'tip' => 'Enviar para a lixeira o Post'
                                                                    ])
                                                            </form>
                                                        @else     
                                                            <form ref="post_retirar_lixeira{{$post->id}}" class="form-box" 
                                                                action="{{ route('post.retirarLixeira',$post->id)}}" method="POST">
                                                                {{ csrf_field() }}                                    
                                                                @method('PUT')
                                                                @include('front.includes.formulario.Hidden',['input' => 'id','value' => $post->id])
                                                                @include('front.includes.formulario.Btaction',[
                                                                    'input' => 'add', 
                                                                    'label' => '', 
                                                                    'icone' => 'undo',
                                                                    'class' => 'btn-success',
                                                                    'aviso'  => 'confirma aviso',
                                                                    'pergunta' => 'Desejas tirar da lixeira o Post?', 
                                                                    'vaction'=> 'post_retirar_lixeira'.$post->id,
                                                                    'tip' => 'Tirar da lixeira o Post'
                                                                    ])
                                                            </form>
                                                        @endif
                                                        <form ref="post_delete{{$post->id}}" class="form-box" 
                                                            action="{{ route('post.destroy',$post->id)}}" method="POST">
                                                            {{ csrf_field() }}                                    
                                                            {{method_field('DELETE')}}
                                                            @method('DELETE')
                                                            @include('front.includes.formulario.Hidden',['input' => 'id','value' => $post->id])
                                                            @include('front.includes.formulario.Btaction',[
                                                                'input' => 'add',                                             
                                                                'aviso'  => 'confirma cuidado',
                                                                'icone' => 'icon-trash',  
                                                                'class' => 'btn-danger',                                               
                                                                'pergunta' => 'Deseja deletar para sempre?', 
                                                                'vaction'=> 'post_delete'.$post->id,                                        
                                                                'tip'    => 'Destruir de vez'
                                                                ])
                                                        </form>
                                                    </td>
                                                </tr> 
                                            @endforeach
                                        </tbody>
                                    </table>        
                                    {{$posts->links()}}
                                </div>
                            
                                
                            </section>
                            {{-- endMagic --}}   
                            <p>Listados: <strong>{{count($posts)}}</strong> no total de: <strong>{{$postsCount['ativos'] +$postsCount['edicao'] + $postsCount['rascunho'] }}</strong> posts</p>     
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