@extends('template.Usuario')

@section('css-view')
@endsection

@section('metadados')
    @include('back.includes.Backend', [
        'titulo' => 'Gestão de Comentários',
        'descricao' => 'Fraseteca, Painel do admin - gestão de comentários',
    ])
@endsection

@section('conteudo-menu')
@endsection


@section('conteudo-view')
    @php
    $default_page = 'comentarios';
    @endphp

    <div class="page" id="app">
        @include('front.includes.Retorno')
        <bt-confirma :confirma="objConfirma"></bt-confirma>
        @include('back.includes.Menulateral')
        @include('front.includes.Areapesquisa')
        <div class="corpo-da-pagina">
            @include('back.includes.Topo', ['amp' => false])

            <div class="container corpo">
                <div class="wrapper">
                    <!-- Sidebar -->
                    <div id="sidebar" class="normal" ref="ref_sidebar">
                        @include('back.includes.Menu', [
                            'pagina' => $default_page,
                        ])
                    </div>
                    <div id="botao" ref="ref_botao" class="only-mobile" @click.prevent.stop="abreSidebar">
                        <span class="linha "></span>
                        <span class="linha linha2"></span>

                    </div>

                    <!-- Page Content -->
                    <div id="content" class="default-form {{ $default_page }}">
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
                                    <i class="icon favorito"></i>
                                    Gestão de Comentários
                                    ({{ $postsCount['aprovados'] + $postsCount['pendente'] + $postsCount['rejeitados'] }})
                                </h1>
                                <span>Aprovados: <strong style="color:#20ad83">{{ $postsCount['aprovados'] }}</strong> |
                                </span>
                                <span>pendente: {{ $postsCount['pendente'] }} | </span>
                                <span>rejeitados: {{ $postsCount['rejeitados'] }} </span>
                                <a href="" class="btn bt-config icon-filter-svg" :class="abreConfigClass"
                                    @click.stop.prevent="openConfig">
                                </a>

                                <div class="painel-config">
                                    <div class="wrapp_config" :class="abreConfigClass">
                                        <ul>
                                            <li>
                                                @include('back.includes.Filtro', [
                                                    'rota' => 'admin.gestao_comments',
                                                    'label' => 'Filtrar:',
                                                    'opt' => [
                                                        'pendente' => 'Pendentes',
                                                        'aprovados' => 'Aprovados',
                                                        'rejeitados' => 'Rejeitados',
                                                        'todos' => 'Todos',
                                                    ],
                                                ])
                                            </li>

                                            <li>
                                                @include('back.includes.Pesquisalist', [
                                                    'rota' => 'comments_pesquisa',
                                                    // 'id'     => $logado->id,
                                                    'placeholder' => 'Procurar por...',
                                                ])
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </header>

                            {{-- corpo --}}
                            <section>
                                <div class="container col-sm-12">

                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Autor</th>
                                                <th scope="col">Resumo</th>
                                                <th scope="col">Post</th>
                                                <th scope="col">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($comments as $comment)
                                                @switch($comment->status)
                                                    @case('1')
                                                        <tr style="" class="table-success">
                                                        @break

                                                        @case('2')
                                                        <tr style="" class="table-danger">
                                                        @break

                                                        @case('0')
                                                        <tr style="" class="table-warning">
                                                        @break

                                                        @default
                                                        <tr>
                                                    @endswitch
                                                    <td>

                                                        @if ($tipo == 'comment_frases')
                                                            <a
                                                                href="{{ route('admin.comments_frases_editar', $comment->id) }}">
                                                                {{ $comment->id }}
                                                            </a>
                                                        @else
                                                            <a
                                                                href="{{ route('admin.gestao_comments_edit', $comment->id) }}">
                                                                {{ $comment->id }}
                                                            </a>
                                                        @endif

                                                    </td>
                                                    <td>{{ $comment->autor_nome }}</td>
                                                    <td>{{ substr($comment->body, 0, 70) }}</td>
                                                    <td>
                                                        @if ($tipo == 'comment_frases')
                                                            <a
                                                                href="{{ env('APP_URL') }}/frases/edit/{{ $comment->frase->id }}">
                                                                {{ $comment->frase->titulo }}
                                                            </a>
                                                        @else
                                                            <a
                                                                href="{{ env('APP_URL') }}/posts/edit/{{ $comment->post->id }}">
                                                                {{ $comment->post->titulo }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td class="call-actions">
                                                        @if ($tipo == 'comment_frases')
                                                            <form class="form-box"
                                                                action="{{ route('admin.comments_frases_editar', $comment->id) }}"
                                                                method="GET">
                                                                {{ csrf_field() }}
                                                                @include(
                                                                    'front.includes.formulario.Hidden',
                                                                    ['input' => 'id', 'value' => $comment->id]
                                                                )
                                                                @include(
                                                                    'front.includes.formulario.Btedit',
                                                                    [
                                                                        'input' => 'Edit',
                                                                        'label' => 'Edit',
                                                                        'tip' => 'Editar',
                                                                    ]
                                                                )
                                                            </form>
                                                        @else
                                                            <form class="form-box"
                                                                action="{{ route('admin.gestao_comments_edit', $comment->id) }}"
                                                                method="GET">
                                                                {{ csrf_field() }}
                                                                @include(
                                                                    'front.includes.formulario.Hidden',
                                                                    ['input' => 'id', 'value' => $comment->id]
                                                                )
                                                                @include(
                                                                    'front.includes.formulario.Btedit',
                                                                    [
                                                                        'input' => 'Edit',
                                                                        'label' => 'Editar',
                                                                        'tip' => 'Editar',
                                                                    ]
                                                                )
                                                            </form>
                                                        @endif

                                                        <form ref="comment_delete{{ $comment->id }}"
                                                            class="form-box"
                                                            action="{{ route('comments.destroy', $comment->id) }}"
                                                            method="POST">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            @method('DELETE')
                                                            @include(
                                                                'front.includes.formulario.Hidden',
                                                                ['input' => 'id', 'value' => $comment->id]
                                                            )
                                                            @include(
                                                                'front.includes.formulario.Btaction',
                                                                [
                                                                    'input' => 'add',
                                                                    'aviso' => 'confirma cuidado',
                                                                    'label' => 'deletar',
                                                                    'class' => 'botao-padrao red',
                                                                    'pergunta' =>
                                                                        'ATENÇÃO! Deseja realmente deletar para sempre?',
                                                                    'vaction' =>
                                                                        'comment_delete' . $comment->id,
                                                                    'tip' => 'Destruir de vez',
                                                                ]
                                                            )
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $comments->links() }}
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
