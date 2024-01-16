@extends('template.Usuario')

@section('css-view')
@endsection

@section('metadados')
     @include('back.includes.Backend', [
         "titulo" => "Gestão autor",
         "descricao" => "Fraseteca, Painel do admin - gestão Autores"
     ])     
@endsection

@section('conteudo-menu') 
       
@endsection


@section('conteudo-view')
    @php        
        $default_page="autor";
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
                        {{-- startMagic --}}
                        <p>
                            <form class="form-box" 
                            action="{{ route('autor.inserir','0')}}" method="GET">
                            {{ csrf_field() }}                                    
                            @method('PUT')
                            <button>
                                <span class="icon-user" style="color:#fff" > Criar página de autor
                            </button>
                            </form>  
                        </p>
                        <header>
                            <h1>
                                <i class="icon favorito"></i>
                                Autores já criados ( {{$postsCount['total']}} ) 
                            </h1>
                            <a href="" class="btn bt-config icon-filter-svg"
                                :class="abreConfigClass"
                                 @click.stop.prevent="openConfig">                                                                                
                            </a>
                            
                            <a href="{{ route('admin.gestao_autor','todos') }}">ver todos</a>

                            <div class="painel-config">                                    
                                <div class="wrapp_config" :class="abreConfigClass">
                                    <ul>                                                
                                        <li>
                                            @include('back.includes.Filtro',[                
                                                'rota'   => 'admin.autor',
                                                'label'  => 'Pesquisa:',
                                                'opt' => [                                                    
                                                ]
                                            ])
                                        </li>
                                        
                                        <li>
                                            @include('back.includes.Pesquisalist',[                
                                                'rota'   => 'autor.pesquisa',
                                                // 'id'     => $logado->id,   
                                                'placeholder'  => 'Procurar por nome',           
                                            ])
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </header>

                        {{-- corpo --}}
                        <section>
                            <div class="container col-sm-12" >
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Descrição</th>
                                            {{-- <th scope="col">Resumo</th> --}}
                                            <th scope="col">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($autores as $autor)
                                            <tr> 
                                                
                                                <td class="w70">
                                                    <a href="{{ route('autor.edit',$autor->id)}}">
                                                    {{$autor->nome }}
                                                    </a>
                                                </td>
                                                <td class="call-actions w30">   
                                                    @php
                                                        $rotaVer =$autor->urlamigavel;
                                                        @endphp
                                                        @include('front.includes.formulario.Btactionlink',[
                                                                'input' => 'btlink',
                                                                'label' => 'Ver',                                                                
                                                                'tip'   => 'Ver no site',
                                                                'class' => 'botao-padrao ',
                                                                'rota' =>$rotaVer 
                                                                ]
                                                                )                                                 
                                                    <form class="form-box" action="{{ route('autor.edit',$autor->id)}}" method="GET">
                                                        {{ csrf_field() }}
                                                        @include('front.includes.formulario.Hidden',['input' => 'id','value' => $autor->id])
                                                        @include('front.includes.formulario.Btedit',['input' => 'Edit', 'label' => 'Edit','tip' => 'Editar'])
                                                    </form>

                                                    {{-- Pendência ver essa rota --}}
                                                    <form ref="autor_delete{{$autor->id}}" class="form-box" 
                                                        action="
                                                        {{ route('autor.destroy',$autor->id)}}
                                                        " method="POST">
                                                        {{ csrf_field() }}
                                                        {{method_field('DELETE')}}
                                                        @method('DELETE')
                                                        @include('front.includes.formulario.Hidden',['input' => 'id','value' => $autor->id])
                                                        
                                                        @include('front.includes.formulario.Btaction',[
                                                            'input' => 'add',
                                                            'aviso'  => 'confirma cuidado',
                                                            'label' => 'deletar',
                                                            'class' => 'botao-padrao red',
                                                            'pergunta' => 'Deseja deletar para sempre?', 
                                                            'vaction'=> 'autor_delete'.$autor->id,
                                                            'tip'    => 'Destruir de vez'
                                                            ])
                                                    </form>
                                                </td>
                                            </tr> 
                                        @endforeach
                                    </tbody>
                                </table>        
                                {{$autores->links()}}
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