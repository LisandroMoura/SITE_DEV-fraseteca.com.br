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
        $default_page="aprovacoes";
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
                                Gestão de Aprovações
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
                                                'rota'   => 'admin.gestao_aprovacao',
                                                'label'  => 'Pesquisa:',
                                                'opt' => [                                                    
                                                ]
                                            ])
                                        </li>                                        
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
                            <div class="container col-sm-12" id="app">                                                            
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Título</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Autor</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($aprovacaos as $aprovacao)                                        
                                            @switch($aprovacao->formatado_status)                                            
                                                @case('Aprovado')
                                                    <tr style="" class="suspenso  ">                            
                                                    @break
                                                @case('Pendente')
                                                    <tr style="" class="suspenso primario">                            
                                                    @break
                                                @case('Deletado')
                                                    <tr style="" class="suspenso table-danger">                                                        
                                                @break                        
                                                @case('Rejeitado')
                                                    <tr style="" class="suspenso ">                                                        
                                                @break
                                                @case('Deletado | email não confirmado')
                                                    <tr style="" class="suspenso table-danger">                                                        
                                                @break                                                
                                                @default
                                                    <tr>                            
                                            @endswitch                        
                                                <td>                            
                                                    {{$aprovacao->item_id}}  
                                                </td>
                                                <td>
                                                    {{$aprovacao->getTitulo()}}
                                                </td>
                                                <td>
                                                    {{$aprovacao->tipo }}
                                                </td>
                                                <td>
                                                    {{$aprovacao->getAutor()}}
                                                </td>
                                                <td>
                                                    @if ($aprovacao->formatado_status == 'Aprovado')
                                                        <span class="publicado">
                                                            {{$aprovacao->formatado_status }}    
                                                        </span>                                                        
                                                    @elseif ($aprovacao->formatado_status == 'Rejeitado')
                                                        <span class="rejeitado">
                                                            {{$aprovacao->formatado_status }}    
                                                        </span>                                                    

                                                    @elseif ($aprovacao->formatado_status == 'Pendente')
                                                        <span class="pendente">
                                                            {{$aprovacao->formatado_status }}    
                                                        </span>                                                    
                                                    @else 
                                                        {{$aprovacao->formatado_status }}
                                                    
                                                    @endif
                        
                                                </td>
                                                
                                                {{-- <td>{{$aprovacao->resumo }}</td>                         --}}
                                                <td class="call-actions">        
                                                    
                                                @if ($aprovacao->formatado_status == 'Pendente')
                                                
                                                        @switch($aprovacao->tipo)
                                                            @case("lista")
                                                                <form class="form-box" action="{{ route('lista.edit',$aprovacao->item_id)}}" method="GET">
                                                                @break
                                                            @case("pasta")
                                                                <form class="form-box" action="{{ route('pastas.edit',$aprovacao->item_id)}}" method="GET">
                                                                @break
                                                            @default
                                                                <form class="form-box" action="{{ route('admin.gestao_midias_edit',$aprovacao->item_id)}}" method="GET">    
                                                        @endswitch                                                    
                                                        
                                                        {{ csrf_field() }}                                                                        
                                                        @include('front.includes.formulario.Hidden',['input' => 'id','value' => $aprovacao->item_id])
                                                        @include('front.includes.formulario.Hidden',['input' => 'idAprovacao','value' => $aprovacao->id])
                        
                                                        @include('front.includes.formulario.Btaction',[
                                                            'input' => 'btlink',
                                                            'icone' => 'eye',  
                                                            'label' => 'Resolver!!!',
                                                            'class' => 'botao-padrao yellow',
                                                            'tip' => 'Resolver!'])
                                                        </form>
                                                    
                                                    @endif
                            
                                                
                                                    <form ref="post_delete{{$aprovacao->id}}" class="form-box" 
                                                        action="{{ route('aprovacao.destroy',$aprovacao->id)}}" method="POST">
                                                        {{ csrf_field() }}                                    
                                                        {{method_field('DELETE')}}
                                                        @method('DELETE')
                                                        @include('front.includes.formulario.Hidden',['input' => 'id','value' => $aprovacao->id])
                                                        @include('front.includes.formulario.Btaction',[
                                                            'input' => 'add',                                             
                                                            'aviso'  => 'confirma cuidado',
                                                            'label' => ' Excluir', 
                                                            'icone' => 'trash-alt',  
                                                            'class' => 'botao-padrao red',                                               
                                                            'pergunta' => 'Deseja deletar para sempre?', 
                                                            'vaction'=> 'post_delete'.$aprovacao->id,                                        
                                                            'tip'    => 'Destruir de vez'
                                                            ])
                                                    </form>
                                                </td>
                                            </tr> 
                                        @endforeach
                                    </tbody>
                                </table>        
                                {{$aprovacaos->links()}}
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