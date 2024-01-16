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
        $default_page="frases";

        use App\Services\Marlon;
        $marlon= new Marlon;        
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
                            <p>
                                <form class="form-box" 
                                action="{{ route('marlon.preanalise','0')}}" method="GET">
                                {{ csrf_field() }}                                    
                                @method('PUT')
                                <button>
                                    <span class="icon-zynga" style="color:#fff" > Fareijar Pré-Análise
                                </button>
                                </form>  
                            </p>
                            <header>
                                <h1>
                                    <i class="icon icone icon-bold title"></i>
                                    an <span class="icon-zynga" style="color:#000" ></span>
                                     de Frases/Single ({{$frasesCount['google'] +$frasesCount['lixeira'] + $frasesCount['naoindexa'] +$frasesCount['duplicada']+$frasesCount['duplicadaemuso']+$frasesCount['preanalise'] +$frasesCount['reprovada'] }})
                                </h1>
                                <ul class="ul-menu-filtro">
                                    <li>
                                        <a class="menu-filtro" href="{{route('admin.gestao_frases', 'google')}}">
                                            <span>Google: <strong style="color:#20ad83">{{$frasesCount['google']}}</strong> | </span>
                                        </a>
                                        <a class="menu-filtro" href="{{route('admin.gestao_frases', 'duplicada')}}">
                                            <span>Duplic: {{$frasesCount['duplicada']}} | </span>
                                        </a>
                                        <a class="menu-filtro" href="{{route('admin.gestao_frases', 'duplicadaemuso')}}">
                                            <span>Duplic.Uso: {{$frasesCount['duplicadaemuso']}} | </span>
                                        </a>
                                        <a class="menu-filtro" href="{{route('admin.gestao_frases', 'preanalise')}}">
                                            <span>Pré-análise: {{$frasesCount['preanalise']}} | </span>
                                        </a>
                                        <a class="menu-filtro" href="{{route('admin.gestao_frases', 'reprovada')}}">
                                            <span>Reprov: {{$frasesCount['reprovada']}} | </span>
                                        </a>
                                        <a class="menu-filtro" href="{{route('admin.gestao_frases', 'lixeira')}}">
                                            <span>Lixeira: {{$frasesCount['lixeira']}} | </span>
                                        </a>
                                        <a class="menu-filtro" href="{{route('admin.gestao_frases', 'naoindexa')}}">
                                            <span>Não indexar: {{$frasesCount['naoindexa']}} </span>
                                        </a>
                                    </li>
                                </ul>
                                
                                <a href="" class="btn bt-config icon-filter-svg"
                                    :class="abreConfigClass"
                                     @click.stop.prevent="openConfig">                                                                                
                                </a>

                                <div class="painel-config">                                    
                                    <div class="wrapp_config" :class="abreConfigClass">
                                        <ul>                                                
                                            <li>
                                                @include('back.includes.Filtro',[                
                                                    'rota'   => 'admin.gestao_frases',
                                                    'label'  => 'Filtrar:',
                                                    'opt' => [                                                        
                                                        'duplicada'  => 'Duplicadas',
                                                        'duplicadaemuso'  => 'Duplicadas Em uso',
                                                        'preanalise'  => 'Em pré-análise',                                                        
                                                        'google'     => 'Indexar no Google',
                                                        'naoindexa'   => 'Não indexa',
                                                        'lixeira'     => 'Lixeira',
                                                        'reprovada'   => 'Reprovada',
                                                        'todas'       => 'Todas',
                                                    ]
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
                                            </li>
                                            <li>
                                            <a  href="{{env('APP_URL')}}/admin/marlon/"
                                                    class="btn bt-call btn-success marlon">
                                                    <span class="icon-zynga" style="color: rgb(255, 255, 255);">
                                                    Marlon Farejador
                                                </span></a>
                                            </li>  

                                            <li>
                                                <a  href="{{ route('marlon.limparlixeira',"0")}}"
                                                        class="btn bt-call btn-success marlon">
                                                        <span class="icon-zynga" style="color: rgb(255, 255, 255);">
                                                            Limpar a Lixeira de Frases
                                                    </span></a>
                                             </li>  


                                             
                                        </ul>
                                    </div>
                                </div>
                            </header>

                            {{-- corpo --}}
                            <section> 
                                <div class="container col-sm-12">
                                
                                    @include('front.includes.formulario.Btadd',[                
                                        'rota'   => 'frase.inserir',
                                        'icone'  => 'plus',
                                        'tip'  => 'Inserir Nova Frase'
                                    ]) 
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Frase</th>
                                                <th scope="col">Autor</th>
                                                <th scope="col">Lista/Post</th>
                                                <th scope="col">Status</th>                    
                                                <th scope="col">Token</th>
                                                <th scope="col">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($frases as $frase)     
                                            
                                                @php
                                                    $arrFrases=$marlon->getSituacaoDaFrase($frase->id);

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
                                                        <a href="{{ route('frase.edit',$frase->id)}}"
                                                            @if ($frase->formatado_status=="Google")
                                                                class="ok"                                                                 
                                                            @elseif ($frase->formatado_status == 'Reprovada')    
                                                                class="rejeitado"
                                                            @endif                                                            
                                                            >
                                                                {{$frase->frase }}
                                                        </a>                                                                
                                                    </td>
                                                    <td class="w15">
                                                        {{$frase->autor }}
                                                    </td>
                                                    <td class="w15">                  
                                                                                              
                                                        @foreach ($arrFrases as $item)                                                        
                                                            @if ($item["idDopost"])
                                                                <a href="{{ route('post.edit',$item["idDopost"])}}">{{$item["tituloPost"]}}</a>                                                                    
                                                            @else
                                                                {{$item["tituloPost"]}}                                                          
                                                            @endif 
                                                            |
                                                        @endforeach  
                                                    </td>
                                                    <td class="w15">
                                                        @if ($frase->formatado_status == 'Google')
                                                            <span class="publicado">
                                                                {{$frase->formatado_status }}    
                                                            </span>
                                                        @elseif ($frase->formatado_status == 'Reprovada')
                                                            <span class="rejeitado">
                                                                {{$frase->formatado_status }}    
                                                            </span>
                                                        @elseif ($frase->formatado_status == 'Lixeira')
                                                            <span class="danger">
                                                                {{$frase->formatado_status }}    
                                                            </span>  
                                                        @elseif ($frase->formatado_status == 'Duplicada Em Uso')
                                                            <span class="none">Dupl. mas em Uso
                                                            </span>    
                                                          
                                                        @else
                                                            <span class="atention">
                                                                {{$frase->formatado_status }}
                                                            </span>
                                                        @endif

                                                    </td>
                                                    
                                                    <td>{{$frase->token }}</td>                        
                                                    <td class="call-actions w45">
                                                        @php
                                                        $rotaVer = env('APP_URL').'/frase/'.$frase->id;
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
                                                            
                                                        <form class="form-box" action="{{ route('frase.edit',$frase->id)}}" method="GET">
                                                            {{ csrf_field() }}                                                                        
                                                            @include('front.includes.formulario.Hidden',['input' => 'id','value' => $frase->id])
                                                            @include('front.includes.formulario.Btedit',['input' => 'Edit', 'label' => '','tip' => 'Editar'])
                                                        </form>
                                                        
                                                    
                                                        @if ($frase->formatado_status != 'Lixeira')        
                                                            <form ref="frase_deletar{{$frase->id}}" class="form-box" 
                                                                action="{{ route('frase.lixeira',$frase->id)}}" method="POST">
                                                                {{ csrf_field() }}                                    
                                                                @method('PUT')
                                                                @include('front.includes.formulario.Hidden',['input' => 'id','value' => $frase->id])
                                                                @include('front.includes.formulario.Btaction',[
                                                                    'input' => 'add', 
                                                                    'label' => '', 
                                                                    'icone' => 'icon-trash',
                                                                    'class' => 'bt-call btn-warning',
                                                                    'aviso'  => 'confirma aviso',
                                                                    'pergunta' => 'Desejas enviar para a lixeira a Frase?', 
                                                                    'vaction'=> 'frase_deletar'.$frase->id,
                                                                    'tip' => 'Enviar para a lixeira a Frase'
                                                                    ])
                                                            </form>
                                                        @else     
                                                            <form ref="frase_retirar_lixeira{{$frase->id}}" class="form-box" 
                                                                action="{{ route('frase.retirarLixeira',$frase->id)}}" method="POST">
                                                                {{ csrf_field() }}                                    
                                                                @method('PUT')
                                                                @include('front.includes.formulario.Hidden',['input' => 'id','value' => $frase->id])
                                                                @include('front.includes.formulario.Btaction',[
                                                                    'input' => 'add', 
                                                                    'label' => '', 
                                                                    'icone' => 'icon-share',
                                                                    'class' => 'bt-call btn-success',
                                                                    'aviso'  => 'confirma aviso',
                                                                    'pergunta' => 'Desejas tirar da lixeira a Frase?', 
                                                                    'vaction'=> 'frase_retirar_lixeira'.$frase->id,
                                                                    'tip' => 'Voltar o item para a base'
                                                                    ])
                                                            </form>
                                                        @endif
                                                        <form ref="frase_delete{{$frase->id}}" class="form-box" 
                                                            action="{{ route('frases.destroy',$frase->id)}}" method="POST">
                                                            {{ csrf_field() }}                                    
                                                            {{method_field('DELETE')}}
                                                            @method('DELETE')
                                                            @include('front.includes.formulario.Hidden',['input' => 'id','value' => $frase->id])
                                                            @include('front.includes.formulario.Btaction',[
                                                                'input' => 'add',                                             
                                                                'aviso'  => 'confirma cuidado',
                                                                'icone' => 'icon-trash',  
                                                                'class' => 'btn-danger',                                               
                                                                'pergunta' => 'Deseja deletar para sempre?', 
                                                                'vaction'=> 'frase_delete'.$frase->id,                                        
                                                                'tip'    => 'Destruir de vez'
                                                                ])
                                                        </form>
                                                    </td>
                                                </tr> 
                                            @endforeach
                                        </tbody>
                                    </table>        
                                    {{$frases->links()}}
                                </div>
                            
                                
                            </section>
                            {{-- endMagic --}}   
                            <p>Listados: <strong>{{count($frases)}}</strong> no total de: <strong>{{$frasesCount['google'] +$frasesCount['lixeira'] + $frasesCount['naoindexa'] }}</strong> Frases</p>     


                            @if ($frasesCount['lixeira'] > 0)
                                <a  href="{{ route('marlon.limparlixeira',"0")}}"
                                    class="btn bt-call btn-success marlon">
                                    <span class="icon-zynga" style="color: rgb(255, 255, 255);">
                                        Limpar a Lixeira de Frases
                                </span></a>                                 
                            @endif
                            
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