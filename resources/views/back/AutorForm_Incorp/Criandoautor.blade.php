
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
        use Illuminate\Support\Str;
        $msgValidatorArr = \App\Services\MsgValidator::run($errors);
        $default_page = "autor";     
        if(!isset($autoresParecidos)) $autoresParecidos=[];
        if(!isset($pesquisar_autor)) $pesquisar_autor="";
        if(!isset($pesquisar_novos_nomesH)) $pesquisar_novos_nomesH=""; 
        if(!isset($frasesNovosNomes)) $frasesNovosNomes=[]; 
        //1) dados da tabela
        $termoPesquisado    ="";
        $idTabela           =0;        
        $nome               ="";
        $descricao          ="";
        $urlamigavel        ="";        
        $status             ="";
        $index_search       ="1";
        $dataFrases         ="";      
        
        if(isset($autor)){        
            $nome=$autor->nome;
            $descricao =$autor->descricao;
            $urlamigavel = $autor->urlamigavel;   
            $index_search=$autor->index_search;
        }
        if(!isset($frases)) $frases=[];        
        if(isset($pesquisar_autor)){
            if($pesquisar_autor!=""){                
                $urlAux = Str::kebab($pesquisar_autor);                    
                $urlAux = str_replace(" ","-",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($urlAux))));            
                $urlamigavel = env('APP_URL') . '/autor/' .  strtolower($urlAux);
            }                 
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
                                <h1><i class="icon painel"></i>Criando Autores, @if ($pesquisar_autor)termo=<span style="background: #c9fbce;display: inline;padding: 2px 10px;">{{$pesquisar_autor}}</span>@endif</h1>                          
                                <a href="{{ route('autor.inserir') }}" style="position: absolute;right: 20px;top: 4px;">nova pesquisa</a>
                            </header>                     
                            <form ref="pesquisar_autor" action="{{ route('autor.criando_autor')}}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                            <section class="field">
                                @if (!$pesquisar_autor)
                                    <div class="row">
                                        <div class="col-lg-2 label-area ">
                                            <label for="">Novo autor</label>
                                        </div>
                                    
                                        <div id="field-input_autor" class="col-lg-10 titulo field-input pai">
                                            
                                                <input type="text" id="pesquisar_autor" name="pesquisar_autor" placeholder="digite o nome do novo autor..." class="">
                                                <button class="botao-buscar-autor" style="position: absolute;right: 20px;top: 4px;">ok</button>
                                            </form>
                                        </div>                                    
                                    </div>
                                @else 
                                    <input type="hidden" id="pesquisar_autor" name="pesquisar_autor" value="{{$pesquisar_autor}}" class="">
                                    
                                @endif
                                
                                @if (count($frases) || count($frasesNovosNomes) )
                                    <div class="resultado">
                                        <br>
                                        <div class="resultado-header" style="display: flex;justify-content: space-between;">
                                            <div>    
                                                @if (isset($autor) )
                                                    <h1>- <strong>
                                                        <span style="display: inline-block;padding:08px; background:hsl(64, 100%, 53%)">ATENÇÃO!</span>
                                                         Autor já cadastrado no sistema com o ID: {{$autor->id}}</strong>
                                                    </h1>
                                                    <p>- As seguintes frases abaixo AINDA não foram cadastradas para este autor:</p>                                                    
                                                @endif                                            
                                             <STRONg>Total:</STRONg><span ref="total">{{count($frases)+count($frasesNovosNomes)}}</span> resultados
                                            </div>
                                            <div>
                                                <a href="3" v-on:click.stop.prevent="desmarcarTudo" >Desmarcar tudo</a> | 
                                                <a href="2" v-on:click.stop.prevent="marcarTudo">Marcar tudo</a>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="tabela-de-resultados">
                                            <table class="table table-hover" style="border:1px solid #efefef">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="border-right:1px solid #efefef">
                                                            Seleção
                                                        </th>
                                                        <th scope="col">Frase</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $i=0; $tbaux=[]; @endphp
                                                    @foreach ($frases as $frase)                                                       
                                                        @if (str_contains($frase->autor,$pesquisar_autor))   
                                                            @php $dataFrases.=$frase->id.";";@endphp                                                         
                                                            <tr class="frase_item" id="trFrase_{{$frase->id}}" data-autor="{{$frase["autor"]}}">                                                            
                                                                <td style="width: 10%;border-right:1px solid #efefef;text-align:center;vertical-align: middle;">
                                                                    <input type="checkbox" 
                                                                    ref="frase_id_{{$frase->id}}" 
                                                                    name="frase_id_{{$frase->id}}" 
                                                                    id="frase_id_{{$frase->id}}" 
                                                                    class="frase_checkbox"
                                                                    value="{{$frase->id}}" 
                                                                    v-on:click="atualisaDataFrasesItem"
                                                                    checked>
                                                                </td>
                                                                <td style="width: 90%;">
                                                                    ({{$frase->id}}) {{$frase->frase}}
                                                                    <br />
                                                                
                                                                    <strong>{{$frase->autor}}</strong>
                                                                    | <a href="/frases/edit/{{$frase->id}}" target="blanck"> <i class="icon-wrench"></i> Editar Autor na frase</a>
                                                                    | <a href="#" v-on:click.stop.prevent="removerDestaLista" data-id="{{$frase->id}}" > <i class="icon-trash-1"></i>remover desta lista</a>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            <tr class="frase_item" id="trFrase_{{$frase->id}}" style="background: rgb(253, 253, 207)" data-autor="{{$frase["autor"]}}">                                                            
                                                                <td style="width: 10%;border-right:1px solid #efefef;text-align:center;vertical-align: middle;">
                                                                    <input type="checkbox" 
                                                                    ref="frase_id_{{$frase->id}}" 
                                                                    name="frase_id_{{$frase->id}}" 
                                                                    id="frase_id_{{$frase->id}}" 
                                                                    class="frase_checkbox"
                                                                    value="{{$frase->id}}" 
                                                                    v-on:click="atualisaDataFrasesItem"
                                                                    >
                                                                </td>
                                                                <td style="width: 90%;">
                                                                    ({{$frase->id}}) {{$frase->frase}}
                                                                    <br />                                                                
                                                                    <strong>{{$frase->autor}}</strong>
                                                                    | <a href="/frases/edit/{{$frase->id}}" target="blanck"> <i class="icon-wrench"></i> Editar Autor na frase</a>
                                                                    | <a href="#" v-on:click.stop.prevent="removerDestaLista" data-id="{{$frase->id}}" > <i class="icon-trash-1"></i>remover desta lista</a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @php
                                                            $tbaux[$i]=$frase->id;
                                                            $i++;
                                                        @endphp
                                                                                                            
                                                    @endforeach
                                                    @foreach ($frasesNovosNomes as $frase)
                                                        @if (!in_array($frase["id"],$tbaux))
                                                            @php $dataFrases.=$frase["id"].";";@endphp
                                                            <tr class="frase_item" id="trFrase_{{$frase["id"]}}" style="background: rgb(147, 209, 211)" data-autor="{{$frase["autor"]}}">                                                              
                                                                <td style="width: 10%;border-right:1px solid #efefef;text-align:center;vertical-align: middle;">
                                                                    <input type="checkbox" 
                                                                    ref="frase_id_{{$frase["id"]}}" 
                                                                    name="frase_id_{{$frase["id"]}}" 
                                                                    id="frase_id_{{$frase["id"]}}" 
                                                                    class="frase_checkbox"
                                                                    value="{{$frase["id"]}}" 
                                                                    v-on:click="atualisaDataFrasesItem"
                                                                    checked>
                                                                </td>
                                                                <td style="width: 90%;">
                                                                    ({{$frase["id"]}}) {{$frase["frase"]}}
                                                                    <br />                                                                
                                                                    <strong>{{$frase["autor"]}}</strong>
                                                                    | <a href="/frases/edit/{{$frase["id"]}}" target="blanck"> <i class="icon-wrench"></i> Editar Autor</a>
                                                                    | <a href="#"  v-on:click.stop.prevent="removerDestaLista" data-id="{{$frase["id"]}}"> <i class="icon-trash-1"></i>remover desta lista</a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>                                            
                                        </div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-lg-2 label-area ">
                                            <label for="">Outros nomes similares</label>
                                        </div>
                                        <div id="field-input_autor" class="col-lg-10 pai">
                                            <div class="caixatag-acriando-autor adcionar">
                                                <ul class="item-nuvem">
                                                    @php $i=0; @endphp
                                                    @foreach ($autoresParecidos as $parecido)
                                                        @if (!in_array($parecido, $nomesJaRelacionados))
                                                            @if ($parecido != $pesquisar_autor)
                                                                <li class="item-tag">
                                                                    <a href="#" v-on:click.stop.prevent="adicionaOutrosNomesSimilaresNaBusca" data-id="{{$i}}" data-value="{{$parecido}};">{{$parecido}}</a>
                                                                </li>
                                                                @php $i++; @endphp    
                                                            @endif
                                                        @endif
                                                    @endforeach                                                
                                                </ul>
                                            </div>
                                        </div>                                    
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-lg-2 label-area ">
                                            <label for="">Novo nome</label>
                                        </div>                                    
                                        <div id="field-input_autor" class="col-lg-10 titulo field-input pai">  
                                            <input type="text" id="pesquisar_novos_nomes" name="pesquisar_novos_nomes" placeholder="Buscar por outro autor, separe com ponto-e-vírgula ;" value="" class="">                                            
                                        </div>                                                                           
                                    </div>  
                                    <div class="row">
                                        <div class="col-lg-2 label-area ">
                                        </div>
                                        <div id="field-input_autor" class="col-lg-10 titulo field-input pai">
                                            <button class="botao-buscar-autor" style="width:100%;">acrescentar novo nome</button>
                                        </div> 
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-10 label-area ">
                                        </div>
                                        <div id="field-input_autor" class="col-lg-10 pai">
                                            <div class="caixatag-acriando-autor adcionar">  
                                                <h2>Autores encontrados:</h2>            
                                                <label for="">Basta clicar em algum dos autores abaixo para remover suas respectivas frases relação acima. </label>  
                                                <ul class="item-nuvem">
                                                    <li data="" class="item-tag disable">{{$pesquisar_autor}}</li> 
                                                    @php $i=0; @endphp
                                                    @foreach ($nomesJaRelacionados as $nome)
                                                        @if ($nome != $pesquisar_autor)
                                                            <li data="" class="item-tag">
                                                                <a href="" class="fechar"  v-on:click.stop.prevent="removeNomesJaRelacionados" data-id="{{$i}}" data-value="{{$nome}}">
                                                                    remover: {{$nome}}
                                                                </a>
                                                            </li>  
                                                            @php $i++; @endphp  
                                                        @endif
                                                    @endforeach                                                    
                                                </ul>
                                            </div>
                                        </div>                                    
                                    </div>  
                                    <hr/>                                    
                                @else 
                                    @if ($pesquisar_autor!="")
                                        <div class="row">
                                            <div class="col-lg-12 label-area ">
                                                <label for="">Não achei nenhuma frase para este autor</label>                                            
                                            </div>
                                        </div>
                                        @if (count($autoresParecidos ))
                                            <div class="row">
                                                <div class="col-lg-2 label-area ">
                                                    <label for="">Outros nomes similares</label>
                                                </div>
                                                <div id="field-input_autor" class="col-lg-10 pai">
                                                    <div class="caixatag-acriando-autor adcionar">
                                                        <ul class="item-nuvem">
                                                            @php $i=0; @endphp
                                                            @foreach ($autoresParecidos as $parecido)
                                                                @if (!in_array($parecido, $nomesJaRelacionados))
                                                                    @if ($parecido != $pesquisar_autor)
                                                                        <li class="item-tag">
                                                                            <a href="#" v-on:click.stop.prevent="adicionaOutrosNomesSimilaresNaBusca" data-id="{{$i}}" data-value="{{$parecido}};">{{$parecido}}</a>
                                                                        </li>
                                                                        @php $i++; @endphp    
                                                                    @endif
                                                                @endif
                                                            @endforeach                                                
                                                        </ul>
                                                    </div>
                                                </div>                                    
                                            </div>
                                            <hr/>
                                            <div class="row">
                                                <div class="col-lg-2 label-area ">
                                                    <label for="">Novo nome</label>
                                                </div>                                    
                                                <div id="field-input_autor" class="col-lg-10 titulo field-input pai">  
                                                    <input type="text" id="pesquisar_novos_nomes" name="pesquisar_novos_nomes" placeholder="Buscar por outro autor, separe com ponto-e-vírgula ;" value="" class="">                                            
                                                </div>                                                                           
                                            </div>  
                                            <div class="row">
                                                <div class="col-lg-2 label-area ">
                                                </div>
                                                <div id="field-input_autor" class="col-lg-10 titulo field-input pai">
                                                    <button class="botao-buscar-autor" style="width:100%;">acrescentar novo nome</button>
                                                </div> 
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            </section>
                            </form>

                            
                            @if ($pesquisar_autor)
                                <form ref="formulario" action="{{ route('autor.store')}}" method="post" enctype="multipart/form-data">                                
                                    {{ csrf_field() }}
                                    <textarea name="dataFrases" class="textarea_hidden" ref="dataFrases" id="dataFrases" cols="30" rows="10">{{$dataFrases}}</textarea>
                                    <input type="hidden" id="pesquisar_novos_nomesH" name="pesquisar_novos_nomesH" value="{{$pesquisar_novos_nomesH}}" class="">
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
                                                    //'vmodel'        => 'nome',                                        
                                                    'value'         =>  $pesquisar_autor ,                                                 
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
                                                    //'vmodel'        => 'titulo',                                        
                                                    'value'         =>  "" ,                                                 
                                                    'placeholder'   => "Título para SEO, ex: Frases de " .$pesquisar_autor,
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
                                                    //'vmodel'        => 'nome',                                        
                                                    'value'         =>  $urlamigavel ,                                                 
                                                    'placeholder'   => 'urlamigavel',                                                                    
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
                                                    //'vmodel'        => 'descricao', 
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
                                    </div> 
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
                                                        'label'   => 'Criar página de autor',
                                                        'tip'     => 'Criar página de autor'
                                                    ])
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </form>
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
    <script src="{{ asset('js/criando_autores_vue.js') }}?ver={{env('VER')}}"></script>    
@endsection