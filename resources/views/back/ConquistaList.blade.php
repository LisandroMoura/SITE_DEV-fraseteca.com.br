@extends('template.Usuario')

@section('css-view')
@endsection

@section('metadados')
     @include('back.includes.Backend', [
         "titulo" => "Gestão de Conquistas",
         "descricao" => "Fraseteca, Painel do admin - gestão de Conquistas"
     ])     
@endsection

@section('conteudo-menu') 
       
@endsection


@section('conteudo-view')
    @php
       
        $default_page="conquistas";

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
                                <i class="icon icone icon-star title "></i>
                                Gestão de conquistas
                            </h1>
                            <a href="" class="btn bt-config icon-filter-svg"
                                :class="abreConfigClass"
                                 @click.stop.prevent="openConfig">                                                                                
                            </a>

                            <div class="painel-config">                                    
                                <div class="wrapp_config" :class="abreConfigClass">
                                    <ul>                                                
                                                                                
                                        <li>
                                            @include('back.includes.Pesquisalist',[                
                                                'rota'   => 'aprovacao_pesquisa',
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
                            <div class="container col-sm-12" >                               
                                @include('front.includes.formulario.Btadd',[                
                                    'rota'   => 'conquista.inserir',
                                    'icone'  => 'plus',
                                    'tip'  => 'Inserir Novo conquista'
                                ]) 
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Título</th>                                            
                                             <th scope="col">Icone</th> 
                                            <th scope="col">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($conquistas as $conquista)
                                            <tr> 
                                                <td class="w50">
                                                    <a href="{{ route('conquista.edit',$conquista->id)}}">
                                                    {{$conquista->nome }}
                                                    </a>
                                                </td>


                                                <td class="w15">
                                                    <a href="{{ route('conquista.edit',$conquista->id)}}">                                                    
                                                    <img src="{{$conquista->icone}}" alt="">
                                                    </a>
                                                </td>
                                              
                        
                                                <td class="call-actions w15">
                                                    {{-- Pendência ver essa rota --}}
                                                    <form class="form-box" action="{{ route('conquista.edit',$conquista->id)}}" method="GET">
                                                        {{ csrf_field() }}
                                                        @include('front.includes.formulario.Hidden',['input' => 'id','value' => $conquista->id])
                                                        @include('front.includes.formulario.Btedit',['input' => 'Edit', 'label' => 'Edit','tip' => 'Editar'])
                                                    </form>
                        
                                                    {{-- Pendência ver essa rota --}}
                                                    <form ref="conquista_delete{{$conquista->id}}" class="form-box" 
                                                        action="
                                                        {{ route('conquista.destroy',$conquista->id)}}
                                                        " method="POST">
                                                        {{ csrf_field() }}
                                                        {{method_field('DELETE')}}
                                                        @method('DELETE')
                                                        @include('front.includes.formulario.Hidden',['input' => 'id','value' => $conquista->id])
                                                        @include('front.includes.formulario.Btaction',[
                                                            'input' => 'add',
                                                            'aviso'  => 'confirma cuidado',
                                                            'label' => 'Deletar',
                                                            'class' => 'botao-padrao red',
                                                            'pergunta' => 'Deseja deletar para sempre?', 
                                                            'vaction'=> 'conquista_delete'.$conquista->id,
                                                            'tip'    => 'Destruir de vez'
                                                            ])
                                                    </form>
                                                </td>
                                            </tr> 
                                        @endforeach
                                    </tbody>
                                </table>        
                                 {{$conquistas->links()}}
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