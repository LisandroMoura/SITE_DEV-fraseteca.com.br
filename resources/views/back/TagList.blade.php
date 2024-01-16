@extends('template.Usuario')

@section('css-view')
@endsection

@section('metadados')
     @include('back.includes.Backend', [
         "titulo" => "Gestão de Tags",
         "descricao" => "Fraseteca, Painel do admin - gestão de Tags"
     ])     
@endsection

@section('conteudo-menu') 
       
@endsection


@section('conteudo-view')
    @php
        $default_page="tags";

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
                                <i class="icon favorito"></i>
                                Gestão de Tags ( {{$postsCount['total'] ?? ""}} )
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
                                                'rota'   => 'admin.gestao_posts',
                                                'label'  => 'Pesquisa:',
                                                'opt' => [                                                    
                                                ]
                                            ])
                                        </li>
                                        
                                        <li>
                                            @include('back.includes.Pesquisalist',[                
                                                'rota'   => 'tags.pesquisa',
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
                                    'rota'   => 'tags.inserir',
                                    'icone'  => 'plus',
                                    'tip'  => 'Inserir Nova Tag'
                                ]) 
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Descrição</th>
                                            <th scope="col">Listas/Frases</th>
                                            <th scope="col">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tags as $tag)
                                            <tr> 
                                                <td class="w60">
                                                    <a href="{{ route('tags.edit',$tag->id)}}">
                                                    {{$tag->descricao }}
                                                    </a>
                                                </td>
                                                <td class="w40">
                                                    @php
                                                        $total = count($tag->listaPosts()) + count($tag->listaFrases());
                                                    @endphp                                                    
                                                    @if (count($tag->listaPosts()))
                                                        {{count($tag->listaPosts())}} listas  
                                                    @endif
                                                    @if (count($tag->listaFrases()))
                                                        | {{count($tag->listaFrases())}} frases  
                                                    @endif
                                                    @if (count($tag->listaPosts()) && count($tag->listaFrases()))
                                                        | Tot:({{$total}})
                                                    @endif
                                                    
                                                </td>
                                                <td class="call-actions">
                                                    {{-- Pendência ver essa rota --}}
                                                    <form class="form-box" action="{{ route('tags.edit',$tag->id)}}" method="GET">
                                                        {{ csrf_field() }}
                                                        @include('front.includes.formulario.Hidden',['input' => 'id', 'value' => $tag->id])
                                                        @include('front.includes.formulario.Btedit',['input' => 'Edit', 'label' => 'Editar','tip' => 'Editar'])
                                                    </form>
                        
                                                    {{-- Pendência ver essa rota --}}
                                                    <form ref="tag_delete{{$tag->id}}" class="form-box" 
                                                        action="
                                                        {{ route('tags.destroy',$tag->id)}}
                                                        " method="POST">
                                                        {{ csrf_field() }}
                                                        {{method_field('DELETE')}}
                                                        @method('DELETE')
                                                        @include('front.includes.formulario.Hidden',['input' => 'id','value' => $tag->id])
                                                        @include('front.includes.formulario.Btaction',[
                                                            'input' => 'add',
                                                            'aviso'  => 'confirma cuidado',
                                                            'label' => 'Excluir',
                                                            'class' => 'botao-padrao red',
                                                            'pergunta' => 'Deseja deletar para sempre?', 
                                                            'vaction'=> 'tag_delete'.$tag->id,
                                                            'tip'    => 'Destruir de vez'
                                                            ])
                                                    </form>
                                                </td>
                                            </tr> 
                                        @endforeach
                                    </tbody>
                                </table>        
                                 {{$tags->links()}}
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