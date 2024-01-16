@extends('template.Admin')


@section('css-view')
    @include('back.PainelShow_Incorp.Assets', ['amp' => false])
@endsection

@section('custom-php')
    @include('front.includes.Mobiletest')
    @php
        
        $mobile = false ; //isMobile($options ?? null)  ● Projeto20221201  = desativar a função em view isMobile() ;
        $customThema = $logado ? $logado->thema : '';
        $customClass = 'single-frase';
        $arrpastas = $logado ? $logado->pastas()->all() : [];
        $pageType = 'pastas';
        $titulo = $titulo ?? null;

        $default_page = 'painel';

        $nComments = \App\Services\NotificAdm::getPendingQuantity('comments');
        $nCommentsFrases = \App\Services\NotificAdm::getPendingQuantity('comments_frases');
        $nAprovacao = \App\Services\NotificAdm::getPendingQuantity('aprovacao');


    @endphp
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
                        Remessas da Marta ({{$postsCount['ativos'] +$postsCount['edicao'] + $postsCount['rascunho'] }})
                    </h1>
                    {{-- <span>Publicados: <strong style="color:#20ad83">{{$postsCount['ativos']}}</strong> | </span>                                
                    <span>Edicao: {{$postsCount['edicao']}} | </span>
                    <span>Rascunho: {{$postsCount['rascunho']}} </span> --}}
                    <a href="" class="btn bt-config icon-filter-svg"
                        :class="abreConfigClass"
                        @click.stop.prevent="openConfig">                                                                                
                    </a>

                    <div class="painel-config">                                    
                        <div class="wrapp_config" :class="abreConfigClass">
                            <ul>                                                
                                <li>
                                    @include('back.includes.Filtro',[                
                                        'rota'   => 'lista_pesquisa',
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
                                        'rota'   => 'lista_pesquisa',
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
                            'rota'   => 'lista.inserir',
                            'icone'  => 'plus',
                            'tip'  => 'Inserir Novo Post'
                        ]) 
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Título</th>
                                    <th scope="col">Status</th>                    
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listas as $lista)       
                                    @switch($lista->formatado_status)
                                        @case('Rascunho')
                                            <tr class="suspenso"  >                            
                                            @break
                                        @case('Em Revisão')
                                            <tr class="suspenso table-secondary" style="background: rgb(253, 224, 60); opacity:0.5">                            
                                            @break
                                        @case('Deletado')
                                            <tr style="" class="suspenso table-danger">                                                        
                                        @break

                                        @case('Publicado')
                                        <tr class="suspenso table-secondary" style="background: rgb(36, 219, 113); opacity:0.5; text-decoration: line-through; pointer-events: none">                            
                                        @break

                                        @case('Deletado | email não confirmado')
                                            <tr style="" class="suspenso table-danger">                                                        
                                        @break
                                        
                                        @default
                                            <tr>                            
                                    @endswitch                        
                                        <td class="w50">
                                            <a href="{{ route('lista.edit',$lista->id)}}">
                                                    {{$lista->titulo }}
                                            </a>                                                                
                                        </td>
                                        <td class="w15">
                                            @if ($lista->formatado_status == 'Publicado')
                                                <span class="publicado">
                                                    {{$lista->formatado_status }}    
                                                </span>
                                            @else 
                                                {{$lista->formatado_status }}
                                            @endif

                                        </td>
                                        
                                        {{-- <td class="w15">
                                            @if ($lista->capa != "https://fraseteca.com.br/storage/images/thumbnail.jpg.jpg")
                                                <span class="sim"><i class="icon icone icon-010-picture"></i></span>
                                            @endif
                                            
                                        </td> --}}
                                        <td class="call-actions w45">
                                            @php
                                            $rotaVer = env('APP_URL').'/'.$lista->urlamigavel;
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
                                                
                                            <form class="form-box" action="{{ route('lista.edit',$lista->id)}}" method="GET">
                                                {{ csrf_field() }}                                                                        
                                                @include('front.includes.formulario.Hidden',['input' => 'id','value' => $lista->id])
                                                <button type='submit' class='botao-padrao'  title="Editar">Editar</button>
                                            </form>
                                            
                                        
                                            @if ($lista->formatado_status != 'Deletado')        
                                                <form ref="post_deletar{{$lista->id}}" class="form-box" 
                                                    action="{{ route('lista.lixeira',$lista->id)}}" method="POST">
                                                    {{ csrf_field() }}                                    
                                                    @method('PUT')
                                                    @include('front.includes.formulario.Hidden',['input' => 'id','value' => $lista->id])
                                                    @include('front.includes.formulario.Btaction',[
                                                        'input' => 'add', 
                                                        'label' => 'Lixo', 
                                                        'icone' => 'icon-trash',
                                                        'class' => 'botao-padrao',
                                                        'aviso'  => 'confirma aviso',
                                                        'pergunta' => 'Desejas enviar para a lixeira o Post?', 
                                                        'vaction'=> 'post_deletar'.$lista->id,
                                                        'tip' => 'Enviar para a lixeira o Post'
                                                        ])
                                                </form>
                                            @else     
                                                <form ref="post_retirar_lixeira{{$lista->id}}" class="form-box" 
                                                    action="{{ route('lista.retirarLixeira',$lista->id)}}" method="POST">
                                                    {{ csrf_field() }}                                    
                                                    @method('PUT')
                                                    @include('front.includes.formulario.Hidden',['input' => 'id','value' => $lista->id])
                                                    @include('front.includes.formulario.Btaction',[
                                                        'input' => 'add', 
                                                        'label' => 'Destruir', 
                                                        'icone' => 'undo',
                                                        'class' => 'botao-padrao red',
                                                        'aviso'  => 'confirma aviso',
                                                        'pergunta' => 'Desejas tirar da lixeira o Post?', 
                                                        'vaction'=> 'post_retirar_lixeira'.$lista->id,
                                                        'tip' => 'Tirar da lixeira o Post'
                                                        ])
                                                </form>
                                            @endif
                                            <form ref="post_delete{{$lista->id}}" class="form-box" 
                                                action="{{ route('lista.destroy',$lista->id)}}" method="POST">
                                                {{ csrf_field() }}                                    
                                                {{method_field('DELETE')}}
                                                @method('DELETE')
                                                @include('front.includes.formulario.Hidden',['input' => 'id','value' => $lista->id])
                                                @include('front.includes.formulario.Btaction',[
                                                    'input' => 'add',                                             
                                                    'aviso'  => 'confirma cuidado',
                                                    'icone' => 'icon-trash',  
                                                    'label' => 'destroy',  
                                                    
                                                    'class' => 'botao-padrao red',                                               
                                                    'pergunta' => 'Deseja deletar para sempre?', 
                                                    'vaction'=> 'post_delete'.$lista->id,                                        
                                                    'tip'    => 'Destruir de vez'
                                                    ])
                                            </form>
                                        </td>
                                    </tr> 
                                @endforeach
                            </tbody>
                        </table>        
                        {{$listas->links()}}
                    </div>
                
                    
                </section>
                {{-- endMagic --}}   
                {{-- <p>Listados: <strong>{{count($listas)}}</strong> no total de: <strong>{{$postsCount['ativos'] +$postsCount['edicao'] + $postsCount['rascunho'] }}</strong> posts</p>      --}}
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
