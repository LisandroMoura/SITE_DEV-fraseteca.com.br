@extends('template.Admin')


@section('css-view')
    @include('back.PainelShow_Incorp.Assets', ['amp' => false])
@endsection

@section('custom-php')
    @include('front.includes.Mobiletest')
    @php
        
        $mobile = false ; //isMobile($options ?? null)  ● Projeto20221201  = desativar a função em view isMobile() ;
        $customThema     = $logado ? $logado->thema : '';
        $customClass     = 'single-frase';
        $arrpastas       = $logado ? $logado->pastas()->all() : [];
        $pageType        = 'pastas';
        $titulo          = $titulo ?? null;
        $default_page    = 'painel';
        $nComments       = \App\Services\NotificAdm::getPendingQuantity('comments');
        $nCommentsFrases = \App\Services\NotificAdm::getPendingQuantity('comments_frases');
        $nAprovacao      = \App\Services\NotificAdm::getPendingQuantity('aprovacao');
    @endphp
    <style>
        nav.flex.items-center.justify-between
        {
            display: inline;
        } 
        .flex.justify-between{
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: flex-start;
            align-content: flex-end;
            width: 100%;
            justify-content: space-around;
        }

        .flex.justify-between span ,
        .flex.justify-between a  {
            display: block;
            margin: 20px;
            background: #eddf5e;
            padding: 20px;
            border-radius: 20px;    
            color: #eb5f5f;
            font-weight: 800;

        }
        .flex.justify-between span {
            background: #dadada;
            color: #b2b2b2;
        }

        
    </style>
@endsection

@section('conteudo-view')

    <section class="margin-auto full-width-content conteudo--header--painel">
        <div class="margin-auto max-width-content conteudo--header--painel--item">
            <h1 itemprop="name" class="titulo">
                {{ $titulo }}
            </h1><span itemprop="headline" style="display:none;">{{ $titulo }}</span>
        </div>
    </section>

    <section class="margin-auto full-width-content conteudo--admin">
        <aside id="sidebar" class="normal" ref="ref_sidebar">
            @include('back.includes.Menu', [
                'pagina' => $default_page,
                'amp' => false,
            ])
        </aside>
        <aside id="content" class="default-form {{ $default_page }}">
            @if ($errors->any())
                @if ($errors->first() == false && $errors->first() != 'sucesso')
                    <h1> {{ $errors->all()['1'] }}</h1>
                    <p>{{ $errors->all()['2'] }}</p>
                @endif
            @endif

            <div class="content-wrapper">
                {{-- startMagic --}}
                
                <header>
                    <h1>
                        <i class="icon icone icon-007-copy title"></i>
                        Gestão de Posts ({{$postsCount['ativos'] +$postsCount['edicao'] + $postsCount['rascunho'] }})
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
                    <div class="">
                    
                        @include('front.includes.formulario.Btadd',[                
                            'rota'   => 'post.inserir',
                            'icone'  => 'plus',
                            'tip'  => 'Inserir Novo Post'
                        ]) 
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Título</th>
                                    <th scope="col">Anúncio?</th>
                                    <th scope="col">Status</th>                    
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
                                            @if ($post->comAnuncio())
                                                <span style="display: flex; width:20px; height: 20px; background:#28a745; border-radius: 100%"></span>
                                            @else
                                                 <span style="display: flex; width:20px; height: 20px; background:#e52134; border-radius: 100%"></span>
                                            @endif
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
                                        
                                        {{-- <td class="w15">
                                            @if ($post->capa != "https://fraseteca.com.br/storage/images/thumbnail.jpg.jpg")
                                                <span class="sim"><i class="icon icone icon-010-picture"></i></span>
                                            @endif
                                            
                                        </td> --}}
                                        <td class="call-actions w45">
                                            @php
                                            $rotaVer = env('APP_URL').'/'.$post->urlamigavel;
                                            @endphp
                                            @include('front.includes.formulario.Btactionlink',[
                                                    'input' => 'btlink',
                                                    'label' => 'Ver', 
                                                    'icone' => '',  
                                                    'tip'   => 'Ver no site',
                                                    'class' => 'botao-padrao',
                                                    'rota' =>$rotaVer 
                                                    ]
                                                    )
                                                
                                            <form class="form-box" action="{{ route('post.edit',$post->id)}}" method="GET">
                                                {{ csrf_field() }}                                                                        
                                                @include('front.includes.formulario.Hidden',['input' => 'id','value' => $post->id])
                                                <button type='submit' class='botao-padrao'  title="Editar">Editar</button>
                                            </form>
                                            
                                        
                                            @if ($post->formatado_status != 'Deletado')        
                                                <form ref="post_deletar{{$post->id}}" class="form-box" 
                                                    action="{{ route('post.lixeira',$post->id)}}" method="POST">
                                                    {{ csrf_field() }}                                    
                                                    @method('PUT')
                                                    @include('front.includes.formulario.Hidden',['input' => 'id','value' => $post->id])
                                                    @include('front.includes.formulario.Btaction',[
                                                        'input' => 'add', 
                                                        'label' => 'Lixo', 
                                                        'icone' => 'icon-trash',
                                                        'class' => 'botao-padrao',
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
                                                        'label' => 'Destruir', 
                                                        'icone' => 'undo',
                                                        'class' => 'botao-padrao red',
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
                                                    'label' => 'destroy',  
                                                    
                                                    'class' => 'botao-padrao red',                                               
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
        </aside>

    </section>
    {{-- <div class="page" id="app">
        @include('front.includes.Retorno')
        <bt-confirma :confirma="objConfirma"></bt-confirma>
        @include('back.includes.Menulateral')
        @include('back.includes.Areapesquisa')
        <div class="corpo-da-pagina">
            @include('back.includes.Topo', ['amp' => false])

            <div class="container corpo">
                <div class="wrapper">
                    <!-- Sidebar -->
                    <div id="sidebar" class="normal" ref="ref_sidebar">
                        @include('back.includes.Menu', [
                            'pagina' => $default_page,
                            'amp' => false,
                        ])
                    </div>
                    
                </div>
            </div>
        </div>
    </div> --}}
@endsection
@section('js-view')
    <script src="{{ asset('js/PastaList.js') }}?ver={{ env('VER') }}"></script>
@endsection
