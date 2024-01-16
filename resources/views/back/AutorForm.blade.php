@extends('template.Usuario')
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
         "titulo" => "Lista de Frases",
         "nome" => "Lista de Frases, Editar ou criar autors"
     ])     
@endsection
@section('conteudo-menu')       
@endsection
@section('conteudo-view')
    @php
        $msgValidatorArr = \App\Services\MsgValidator::run($errors);
        $default_page = "autor";     

        //1) dados da tabela       
        $nome               ="";
        $titulo             ="";
        $descricao          ="";
        $urlamigavel        ="";    
        $status             ="";
        $index_search       ="1";
        $idTabela           =0;
        $autores_relacionados="";
        if(isset($autor)){  
            $idTabela=$autor->id;   
            $nome=$autor->nome;
            $titulo=$autor->titulo;
            $descricao =$autor->descricao;
            $urlamigavel = $autor->urlamigavel;   
            $index_search=$autor->index_search;
            $autores_relacionados=$autor->$autores_relacionados ?? null;
        }
     
    @endphp
    <div class="page" id="app">
        @include('front.includes.Retorno') 
        <bt-confirma :confirma="objConfirma" ></bt-confirma>
        @include('back.includes.Menulateral')
        @include('front.includes.Areapesquisa')
        <div class="corpo-da-pagina" >
            @include('back.includes.Topo' , ["amp" => false])
            <div class="container corpo">            
                <div class="wrapper">                    
                    <div id="sidebar" class="normal" ref="ref_sidebar">
                        @include('back.includes.Menu' ,["pagina" => $default_page])
                    </div>
                    <div id="botao" ref="ref_botao" class="only-mobile" @click.prevent.stop="abreSidebar">
                        <span class="linha "></span>
                        <span class="linha linha2"></span>                        
                    </div>                 
                    <div id="content" class="default-form {{$default_page}}">                                                
                        <div class="content-wrapper">
                            <header>
                                <h1><i class="icon painel"></i>Editando Autores..</h1>                          
                                <a href="{{ route('autor.inserir') }}" style="position: absolute;right: 20px;top: 4px;">nova pesquisa</a>
                            </header>                     
                            <form ref="formulario" action="{{ route('autor.update',$idTabela)}}" method="post" enctype="multipart/form-data">                                
                                {{ csrf_field() }}
                                @method('PUT')
                                <div class="content-wrapper">
                                    <header>
                                        <h2>
                                        Configurações
                                        </h2>
                                    </header> 
                                    <section class="field">
                                    
                                        <div class="row">                                                                    
                                            <div class="col-lg-2 label-area ">
                                                <label for="id">ID</label>
                                            </div>
                                            <div class="col-lg-10 field-input">
                                                <input type="text" name="idAutorE" id="idAutorE" disabled @if (isset($autor) ) value="{{$autor->id}}" @endif>
                                                <input type="hidden" name="idAutor" id="idAutor" @if (isset($autor) ) value="{{$autor->id}}" @endif>
                                            </div>
                                        </div>
                                    </section>      
                                    <section class="field">                                            
                                        <div class="row">                                                                    
                                            @include('front.includes.formulario.Input', [
                                                'input'         => 'nome',
                                                'label'         => 'Nome',
                                                'old'           => old('nome'),
                                                'inputCol'      => 'col-lg-10 titulo',
                                                'class'         => 'titulo validar naovazio' ,
                                                'ref'           => 'nome', 
                                                'value'         =>  $nome ,                                                 
                                                'placeholder'   => 'Nome',
                                                'ajuda'         => '',                                                
                                                'validator'     => true,  
                                                'requerid'      => 'requerid',                                           
                                                'msgValidator'  => isset($msgValidatorArr['titulo']) ? $msgValidatorArr['titulo'] : null,])        
                                        </div>
                                    </section>
                                    <section class="field">                                            
                                        <div class="row">                                                                    
                                            @include('front.includes.formulario.Input', [
                                                'input'         => 'titulo',
                                                'label'         => 'Título para SEO',
                                                'old'           => old('titulo'),
                                                'inputCol'      => 'col-lg-10 titulo',
                                                'class'         => 'titulo validar naovazio' ,
                                                'ref'           => 'titulo', 
                                                'value'         =>  $titulo ,                                                 
                                                'placeholder'   => 'Título para SEO',
                                                'ajuda'         => '',                                                
                                                'validator'     => true,  
                                                'requerid'      => 'requerid',                                           
                                                'msgValidator'  => isset($msgValidatorArr['titulo']) ? $msgValidatorArr['titulo'] : null,])        
                                        </div>
                                    </section>
                                    <section class="field">
                                        <div class="row">                                                                    
                                            @include('front.includes.formulario.Input', [
                                                'input'         => 'urlamigavel',
                                                'label'         => 'Url Amigável',
                                                'old'           => old('urlamigavel'),
                                                'inputCol'      => 'col-lg-10 titulo',
                                                'class'         => 'titulo validar naovazio' ,
                                                'ref'           => 'urlamigavel', 
                                                "ajuda"         => "Insira o caminho completo do link: ex: https://fraseteca.com.br/autor/cora-coralina",
                                                'value'         =>  $urlamigavel ,                                                 
                                                'placeholder'   => 'Insira o caminho completo do link: ex: https://fraseteca.com.br/autor/cora-coralina',                                                                    
                                            ])
                                        </div>
                                    </section>
                                   
                                    {{-- descricao --}}
                                    <section class="field">                                        
                                        <div class="row">   
                                                @include('front.includes.formulario.Textarea', [
                                                'input'         => 'descricao',
                                                'label'         => 'Descrição',                                         
                                                'class'         => 'descricao validar naovazio',
                                                'ref'           => 'descricao', 
                                                'old'           => old('descricao'),                                       
                                                'value'         =>  $descricao,                                            
                                                'placeholder'   => 'descrição do autor...',
                                                'cols'          => '5', 
                                                'rows'          => '3',  
                                            ]) 
                                        </div>
                                    </section>
                                    {{-- url amigável --}}                                     
                                    
                                    {{--Indexa no google?--}}
                                    <section class="field">                                    
                                        <div class="row">
                                            <div class="col-lg-2 label-area ">
                                                <label for="">
                                                    Indexa no google?
                                                </label>
                                            </div>
                                            <div class=" col-lg-10 field-input">                                                                                
                                                @include('front.includes.formulario.Radio',    ['input' => 'index_search','label' => 'Sim', 'value' => '1', 'checked' => $index_search == '1' ? 'true' : 'false' ])
                                                @include('front.includes.formulario.Radio',    ['input' => 'index_search','label' => 'Não ', 'value' => '0', 'checked' => $index_search == '0' ? 'true' : 'false'  ])
                                            </div>
                                        </div>
                                    </section>
                                    <section class="field">                                    
                                        <div class="row">
                                            <div class="col-lg-2 label-area ">
                                                <label for="">
                                                    Autores Relacionados
                                                </label>
                                            </div>
                                            <div class=" col-lg-10 field-input">                                                                                
                                                <textarea id="autores_relacionassdos" cols="30" value="{{$autor->autores_relacionados ?? ""}}" rows="10">{{$autor->autores_relacionados ?? ""}}</textarea>
                                            </div>
                                        </div>
                                    </section>

                                    {{-- botoes de salvar--}}
                                    <div class="content-wrapper">
                                    {{-- FIM  Botões de ação --}}
                                    <section class="field">                                 
                                        <div class="row">                                        
                                            <div class="col-md-6 float-left  zona-bt-enviar-lista ">
                                                @include('front.includes.formulario.Btsalvar',[                
                                                    'rota'    => 'autor.update',
                                                    'id'      =>  $idTabela,  
                                                    'class'   => 'callAction',
                                                    'vaction' => 'salvar',
                                                    'icone'   => 'user',                                                    
                                                    'label'   => 'Salvar registro',
                                                    'tip'     => 'Salvar registro'
                                                ])
                                            </div> 
                                            <div class="col-md-6 float-left ">
                                                <a href="{{$urlamigavel}}" title="Ver no site" target="blank" class="btn btn bt-call bt-ver icon-hand-pointer-o btn-add-card"
                                                    style="    
                                                    max-height: 38px;
                                                    background: #e52134;
                                                    color: #fff;">
                                                    <i class="fa fa- icon  "></i>
                                                    Visualisar Autor no site
                                                </a>
                                            </div>                                            
                                        </div>
                                    </section>                                
                                </div>

                                    <section class="field">                                    
                                        <div class="row">
                                            <div class="col-lg-2 label-area ">
                                                <label for="">
                                                    Frases relacionadas
                                                </label>
                                            </div>
                                            <div class=" col-lg-10 field-input">  
                                                <h1>Total de Frases relacionadas: {{count($frases)}}</h1>     
                                                
                                                <table class="table table-hover" style="border:1px solid #efefef">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" style="border-right:1px solid #efefef">
                                                                id
                                                            </th>
                                                            <th scope="col">Frase</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>  
                                                        @foreach ($frases as $frase)   
                                                            <tr class="frase_item">                                                            
                                                                <td style="width: 10%;border-right:1px solid #efefef;text-align:center;vertical-align: middle;">
                                                                    {{$frase->id}}
                                                                </td>
                                                                <td style="width: 90%;">
                                                                    {{$frase->frase}}
                                                                    <br />                                                            
                                                                    <strong>{{$frase->autor}}</strong>
                                                                    <a href="/frases/edit/{{$frase->id}}" target="blanck"> <i class="icon-wrench"></i> Editar Frase</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>                                                                     
                                            </div>
                                        </div>
                                    </section>
                                    
                                </div> 
                        
                            </form>

                            <form ref="pesquisar_autor" action="{{ route('autor.criando_autor')}}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" id="pesquisar_autor" name="pesquisar_autor" value="{{$nome}}" class="">
                                <button class="botao-buscar-autor" style="width:100%;">Buscar novas frases com os nomes já relacionados</button>
                            </form>
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
    <script src="{{ asset('js/criando_autores_vue.js') }}?ver={{env('VER')}}"></script>    
@endsection