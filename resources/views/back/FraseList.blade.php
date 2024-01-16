@extends('template.Admin')


@section('css-view')
    @include('back.PainelShow_Incorp.Assets', ['amp' => false])
@endsection

@section('custom-php')
    {{-- @include('front.includes.Mobiletest') --}}
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


    use App\Services\Marlon;
    $marlon= new Marlon;       

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
                        Gestão de Frases
                        ({{$frasesCount['google'] +$frasesCount['lixeira'] + $frasesCount['naoindexa'] +$frasesCount['duplicada']+$frasesCount['duplicadaemuso']+$frasesCount['preanalise'] +$frasesCount['reprovada'] }})
                    </h1>
                    <span>Google: <strong style="color:#20ad83">{{ $frasesCount['google'] }}</strong> | </span>
                    <span>NoIndex: {{ $frasesCount['naoindexa'] }} | </span>
                    <span>Lixo: {{ $frasesCount['lixeira'] }} | </span>
                    <span>Duplicada: {{ $frasesCount['duplicada'] }} | </span>
                    <span>DupEmUso: {{ $frasesCount['duplicadaemuso'] }} | </span>
                    <span>Análise: {{ $frasesCount['preanalise'] }} | </span>
                    <span>reprovada: {{ $frasesCount['reprovada'] }} | </span>
                    
                    <a href="" class="btn bt-config icon-filter-svg" :class="abreConfigClass"
                        @click.stop.prevent="openConfig">
                    </a>

                    <div class="painel-config">
                        <div class="wrapp_config" :class="abreConfigClass">
                            <ul>
                                <li>
                                    @include('back.includes.Filtro', [
                                        'rota' => 'admin.gestao_frases',
                                        'label' => 'Filtrar:',
                                        'opt' => [
                                            'todos' => 'Todos',
                                            'google' => 'Google',
                                            'preanalise' => 'Análise',
                                            'naoindexa' => 'NoIndex',
                                            'lixeira' => 'Lixeira',
                                            'duplicada' => 'Duplicada',
                                            'duplicadaemuso' => 'EmUso',
                                            'reprovada' => 'Reprov',
                                        ],
                                    ])
                                </li>

                                <li>
                                    @include('back.includes.Pesquisalist',[                
                                        'rota'   => 'frases_pesquisa',
                                        'campos' => [
                                            "dados"   => ["id","frase","token"],
                                            "checked" => "frase",                                                        
                                        ],
                                        // 'id'     => $logado->id,   
                                        'placeholder'  => 'Procurar por...',           
                                    ])
                                    {{-- @include('back.includes.Pesquisalist', [
                                        'rota' => 'frases_pesquisa',
                                        // 'id'     => $logado->id,
                                        'placeholder' => 'Procurar por...',
                                    ]) --}}
                                </li>
                            </ul>
                        </div>
                    </div>
                </header>

                {{-- corpo --}}
                <section>
                    <div class="">

                        @include('front.includes.formulario.Btadd', [
                            'rota' => 'post.inserir',
                            'icone' => 'plus',
                            'tip' => 'Inserir Novo Post',
                        ])
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <tr>
                                    <th scope="col">Frase</th>
                                    {{-- <th scope="col">Autor</th> --}}
                                    <th scope="col">Lista/Post</th>
                                    <th scope="col">Status</th>
                                    {{-- <th scope="col">Token</th> --}}
                                    <th scope="col">Ações</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($frases as $frase)
                                    @php
                                        $arrFrases = $marlon->getSituacaoDaFrase($frase->id);
                                    @endphp
                                    @switch($frase->formatado_status)
                                        @case('Em pré-análise')
                                            <tr style="" class="suspenso table-secondary">
                                            @break

                                            @case('Não indexa')
                                            <tr style="" class="suspenso table-secondary">
                                            @break

                                            @case('Lixeira')
                                            <tr style="" class="suspenso table-danger">
                                            @break

                                            @case('Reprovada')
                                            <tr style="color:red" class="suspenso">
                                            @break

                                            @case('Duplicada')
                                            <tr style="color:rgb(255, 81, 0)" class="table-danger">
                                            @break

                                            @case('Duplicada Em Uso')
                                            <tr style="color:rgb(4, 8, 245)" class="table-secondary">
                                            @break

                                            @default
                                            <tr>
                                        @endswitch
                                        <td class="w50">
                                            <a href="{{ route('frase.edit', $frase->id) }}"
                                                @if ($frase->formatado_status == 'Google') class="ok"                                                                 
                                                            @elseif ($frase->formatado_status == 'Reprovada')    
                                                                class="rejeitado" @endif>
                                                {{ $frase->frase }}
                                            </a>
                                        </td>
                                        {{-- <td class="w15">
                                            {{ $frase->autor }}
                                        </td> --}}
                                        <td class="w15">

                                            @foreach ($arrFrases as $item)
                                                @if ($item['idDopost'])
                                                    <a
                                                        href="{{ route('post.edit', $item['idDopost']) }}">{{ $item['tituloPost'] }}</a>
                                                @else
                                                    {{ $item['tituloPost'] }}
                                                @endif
                                                |
                                            @endforeach
                                        </td>
                                        <td class="w15">
                                            @if ($frase->formatado_status == 'Google')
                                                <span class="publicado">
                                                    {{ $frase->formatado_status }}
                                                </span>
                                            @elseif ($frase->formatado_status == 'Reprovada')
                                                <span class="rejeitado">
                                                    {{ $frase->formatado_status }}
                                                </span>
                                            @elseif ($frase->formatado_status == 'Lixeira')
                                                <span class="danger">
                                                    {{ $frase->formatado_status }}
                                                </span>
                                            @elseif ($frase->formatado_status == 'Duplicada Em Uso')
                                                <span class="none">Dupl. mas em Uso
                                                </span>
                                            @else
                                                <span class="atention">
                                                    {{ $frase->formatado_status }}
                                                </span>
                                            @endif

                                        </td>

                                        {{-- <td>{{ $frase->token }}</td> --}}
                                        <td class="call-actions w45">
                                            @php
                                                $rotaVer = env('APP_URL') . '/frase/' . $frase->id;
                                            @endphp
                                            @include(
                                                'front.includes.formulario.Btactionlink',
                                                [
                                                    'input' => 'btlink',
                                                    'label' => 'ver',
                                                    'icone' => '',
                                                    'tip' => 'Ver no site',
                                                    'class' => 'btn botao-padrao bt-ver icon-hand-pointer-o',
                                                    'rota' => $rotaVer,
                                                ]
                                            )

                                            <form class="form-box" action="{{ route('frase.edit', $frase->id) }}"
                                                method="GET">
                                                {{ csrf_field() }}
                                                @include(
                                                    'front.includes.formulario.Hidden',
                                                    ['input' => 'id', 'value' => $frase->id]
                                                )
                                                @include(
                                                    'front.includes.formulario.Btaction',
                                                    ['input' => 'Edit', 'label' => 'Edit', 'tip' => 'Editar', 'class' => 'botao-padrao']
                                                )
                                            </form>


                                            @if ($frase->formatado_status != 'Lixeira')
                                                <form ref="frase_deletar{{ $frase->id }}" class="form-box"
                                                    action="{{ route('frase.lixeira', $frase->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    @method('PUT')
                                                    @include(
                                                        'front.includes.formulario.Hidden',
                                                        ['input' => 'id', 'value' => $frase->id]
                                                    )
                                                    @include(
                                                        'front.includes.formulario.Btaction',
                                                        [
                                                            'input' => 'add',
                                                            'label' => 'Lixo',
                                                            'icone' => 'icon-trash',
                                                            'class' => 'botao-padrao btn-warning',
                                                            'aviso' => 'confirma aviso',
                                                            'pergunta' =>
                                                                'Desejas enviar para a lixeira a Frase?',
                                                            'vaction' => 'frase_deletar' . $frase->id,
                                                            'tip' => 'Enviar para a lixeira a Frase',
                                                        ]
                                                    )
                                                </form>
                                            @else
                                                <form ref="frase_retirar_lixeira{{ $frase->id }}" class="form-box"
                                                    action="{{ route('frase.retirarLixeira', $frase->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    @method('PUT')
                                                    @include(
                                                        'front.includes.formulario.Hidden',
                                                        ['input' => 'id', 'value' => $frase->id]
                                                    )
                                                    @include(
                                                        'front.includes.formulario.Btaction',
                                                        [
                                                            'input' => 'add',
                                                            'label' => 'Restaura',
                                                            'icone' => 'icon-share',
                                                            'class' => 'botao-padrao btn-success',
                                                            'aviso' => 'confirma aviso',
                                                            'pergunta' =>
                                                                'Desejas tirar da lixeira a Frase?',
                                                            'vaction' =>
                                                                'frase_retirar_lixeira' . $frase->id,
                                                            'tip' => 'Voltar o item para a base',
                                                        ]
                                                    )
                                                </form>
                                            @endif
                                            <form ref="frase_delete{{ $frase->id }}" class="form-box"
                                                action="{{ route('frases.destroy', $frase->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                @method('DELETE')
                                                @include(
                                                    'front.includes.formulario.Hidden',
                                                    ['input' => 'id', 'value' => $frase->id]
                                                )
                                                @include(
                                                    'front.includes.formulario.Btaction',
                                                    [
                                                        'input' => 'add',
                                                        'label' => 'Destroy',
                                                        'aviso' => 'confirma cuidado',
                                                        'icone' => 'icon-trash',
                                                        'class' => 'btn-danger botao-padrao red',
                                                        'pergunta' => 'Deseja deletar para sempre?',
                                                        'vaction' => 'frase_delete' . $frase->id,
                                                        'tip' => 'Destruir de vez',
                                                    ]
                                                )
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $frases->links() }}
                    </div>


                </section>
                {{-- endMagic --}}
                <p>Listados: <strong>{{count($frases)}}</strong> no total de: <strong>{{$frasesCount['google'] +$frasesCount['lixeira'] + $frasesCount['naoindexa'] }}</strong> Frases</p>
                @if ($frasesCount['lixeira'] > 0)
                    <a  href="{{ route('marlon.limparlixeira',"0")}}"
                        class="botao-padrao com-icone flex">
                        <span class="ico ico-lixeira"></span>
                            Limpar a Lixeira de Frases?
                    </a>                                 
                @endif
                
                
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
    <script src="{{ asset('js/PainelShow.js') }}?ver={{ env('VER') }}"></script>
@endsection
