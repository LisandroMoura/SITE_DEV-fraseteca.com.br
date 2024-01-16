@extends('template.Usuario')

@section('css-view')
@endsection

@section('metadados')
     @include('back.includes.Backend', [
         "titulo" => "Painel de Admin",
         "descricao" => "Fraseteca, Painel de opções do usuário"
     ])     
@endsection

@section('conteudo-menu') 
       
@endsection

@section('conteudo-view')
    @php
       
        $default_page="marlon";
        $de="1";
        $para="300";

    @endphp
    <div class="page" id="app">
        @include('front.includes.Retorno')
        <bt-confirma :confirma="objConfirma"></bt-confirma>
        @include('back.includes.Menulateral')
        @include('front.includes.Areapesquisa')
        <div class="corpo-da-pagina" >
            @include('back.includes.Topo', ["amp" => false])

            <div class="container corpo">            
                <span class="ver" style="position: absolute;bottom: 0;right: 0;font-size: 12px;color:#d0caca">V:{{env("VER")}}</span>       
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
                        {{-- startMagic --}}
                        <div class="container">
                            <h1> <i class="icon icon-zynga"> </i> Cão Robô Revisador de Frases: marlon Farejador</h1>
                        </div>

                        {{-- Sitemaps --}}
                        <div class="content-wrapper">                            
                            <header>
                                <h1>                                    
                                    Logs de execução do Marlon
                                </h1>
                            </header>

                            <section>                                                                                               
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>
                                            <a href="/exec_marlon.xml"> - LogDoMarlon.xml (Ver)</a>
                                        </h3>
                                    </div>                                            
                                </div>                                
                            </section>                             
                        </div>

                        {{-- Parâmetros --}}
                        <div class="content-wrapper">                            
                            <header>
                                <h1>
                                    <i class="icon favorito"></i>
                                    Opções
                                </h1>
                            </header>

                            {{-- marta Golpista --}}
                        <div class="content-wrapper">                            
                            <header>
                                <h1>
                                    <i class="icon favorito"></i>
                                    Importar Remessas da Marta.golpista
                                </h1>
                                <img class="imagem-marta" src="http://marta.golpista/storage/imagens/marta_a_golpista.png" alt="">
                            </header>

                            <section>                                                                                               
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>Basta importar</h3>                                                                                
                                    </div>                                            
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <form class="form-box" 
                                        action="{{ route('marlon.martaimporta','0')}}" method="GET">
                                         {{ csrf_field() }}                                    
                                          @method('PUT')
                                          <button>
                                            <span class="icon-zynga" style="color:#fff" > importar
                                            </button>
                                      </form>                                    
                                    </div>
                                </div>                                
                            </section>                             
                        </div>

                            <section>                                                                                               
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>Tudo o que o marlon pode fazer.</h3>
                                    </div>                                            
                                </div>
                                <div class="row">
                                    <div class="col marlon">
                                        <ul>
                                            <li>
                                                <a href="{{ route('marlon.token',["0","0,100"])}}" class="btn bt-call  marlon">
                                                    <span class="icon-zynga" style="color:#000" >REGERAR TOKENS
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('marlon.titulo',"0")}}" class="btn bt-call btn-success marlon">
                                                    <span class="icon-zynga" style="color:#000" >1º Arrumar títulos em brancos
                                                </a>

                                            </li>
                                            <li>
                                                <a href="{{ route('marlon.duplicadas',"0")}}" class="btn bt-call btn-success marlon">
                                                    <span class="icon-zynga" style="color:#000" >2º Verificar se tem frases Duplicadas no BanCão
                                                </a>
                                                Isso pode demorar
                                            </li>
                                            <li>
                                                <a href="{{ route('marlon.duplicadasemuso',"0")}}" class="btn bt-call btn-success marlon">
                                                    <span class="icon-zynga" style="color:#000">3º Verificar frases duplicadas em uso   
                                                </a>
                                                Isso pode demorar
                                            </li>                                           

                                            <li>
                                                <a href="{{ route('marlon.deletarduplicadas',"0")}}" class="btn bt-call btn-success marlon">
                                                    <span class="icon-zynga" style="color:#000">4º Setar deletado frases duplicadas não utilizadas   
                                                </a>
                                                Isso pode demorar
                                            </li> 
                                            
                                            <li>
                                                <a href="{{ route('marlon.limparlixeira',"0")}}" class="btn bt-call btn-success marlon">
                                                    <span class="icon-zynga" style="color:#000">5º Limpar a Lixeira de Frases
                                                </a>
                                                Isso pode demorar

                                                {{-- Gerar Imagens  --}}                        
                                                @if (isset($nalixeira))
                                                    <div class="content-wrapper">                            
                                                        <header>
                                                            <h1>
                                                                <i class="icon favorito"></i>
                                                                Frases que não podem ser deletadas ainda!
                                                            </h1>
                                                            <p>
                                                                Pois estão sendo Usadas em publicações!
                                                            </p>
                                                        </header>
                                                        <section>
                                                            <h1>TOTAL: {{count($nalixeira)}}</h1>
                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">id</th> 
                                                                        <th scope="col">Frase</th>
                                                                        <th scope="col">Titulo</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($nalixeira as $item)
                                                                        <tr>
                                                                            <td class="w15">                                                                                                                
                                                                                <a href="/frases/edit/{{$item["id"]}}">{{$item["id"]}} - ver </a>
                                                                            </td>
                                                                            <td class="w15">
                                                                                {{$item["frase"]}}
                                                                            </td>
                                                                            <td class="w15">
                                                                                {{$item["titulo"]}}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </section>
                                                    </div>
                                                 @endif


                                            </li> 
                                            
                                            <li>
                                                <a href="{{ route('marlon.reverduplicadas',"0")}}" class="btn bt-call btn-success marlon">
                                                    <span class="icon-zynga" style="color:#000"> 6º Rever Frases em uso duplicada
                                                </a>
                                                Rode isso depois do item 5º
                                            </li> 

                                            <li>
                                                <p>
                                                    <a href="{{ route('marlon.pequenas',"0")}}" class="btn bt-call btn-success marlon">
                                                        <span class="icon-zynga" style="color:#000" >7º Validar tamanho das Descrições das frases
                                                    </a>                                                    
                                                </p>

                                                <ul>
                                                    <li>
                                                        <h6>Frases muito pequenas não devem indexar! <br>
                                                            Critérios: <br>
                                                            - título tem que term no mínimo 30 caracteres<br>
                                                            - Frase tem que term no mínimo 70 caracteres</h6>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="{{ route('marlon.getpalavroes',"0")}}" class="btn bt-call btn-success marlon">
                                                    <span class="icon-zynga" style="color:#000" >Otp: Atualisar banco de dados de Palavroes
                                                </a>
                                            </li>  
                                            <li>
                                                <a href="{{ route('marlon.caracteresruins',"0")}}" class="btn bt-call btn-success marlon">
                                                    <span class="icon-zynga" style="color:#000" >Otp: Ver se tem palavrões ou caracteres ruins nas frases
                                                </a>
                                            </li>    


                                            <li>
                                                <a href="{{ route('marlon.martaimporta',"0")}}" class="btn bt-call btn-success marlon">
                                                    <span class="icon-zynga" style="color:#000" >Importar da Marta Golpista
                                                </a>
                                            </li>    
                                            
                                            

                                        </ul>
                                    </div>
                                </div>                                
                            </section>                             
                        </div>
                        {{-- Pré-análise --}}
                        <div class="content-wrapper">                            
                            <header>
                                <h1>
                                    <i class="icon favorito"></i>
                                    Rodar a Pré-análise...
                                </h1>
                            </header>

                            <section>                                                                                               
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>Analisar e validar todas as frases do bancão que estão com o Status "Pré-análise".</h3>
                                        <p>As que estiverem ok, vão ser setadas com o Status <span class="publicado">
                                            Google    
                                        </span></p>
                                        <p>
                                            PS: Rode este processo, depois de todos os outros acima (até o 7º), e Isso pode demorar pra caramba...
                                        </p>
                                    </div>                                            
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <form class="form-box" 
                                        action="{{ route('marlon.preanalise','0')}}" method="GET">
                                         {{ csrf_field() }}                                    
                                          @method('PUT')
                                          <button>
                                            <span class="icon-zynga" style="color:#fff" > Fareijar
                                            </button>
                                      </form>                                    
                                    </div>
                                </div>                                
                            </section>                             
                        </div>
                        
                        {{-- Gerar Imagens  --}}                        
                        @if (isset($dados))
                            <div class="content-wrapper">                            
                                <header>
                                    <h1>
                                        <i class="icon favorito"></i>
                                        Frases pendentes de imagens...
                                    </h1>
                                </header>
                                <section>
                                    <h1>TOTAL pendentes: {{count($dados)}}</h1>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">id</th> 
                                                <th scope="col">Frase</th>
                                                <th scope="col">Titulo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dados as $item)
                                                <tr>
                                                    <td class="w15">                                                                                                                
                                                        <a href="/frases/edit/{{$item["id"]}}">{{$item["id"]}} - ver </a>
                                                    </td>
                                                    <td class="w15">
                                                        {{$item["frase"]}}
                                                    </td>
                                                    <td class="w15">
                                                        {{$item["titulo"]}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </section>
                            </div>
                        @endif
                        <div class="content-wrapper">                            
                            <header>
                                <h1>
                                    <i class="icon favorito"></i>
                                    Listar imagens Crachadas && Gerar imagens automáticas...
                                </h1>
                            </header>
                            <section>                                                                                               
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>Listar / Gerar imagem automática para todas as frases já validadas.</h3>
                                        <p>O processo vai rodar para todas as frases que tiverem o Status <span class="publicado">
                                            Google </span> e que ainda não tenham  imagens cadastradas
                                        </p>
                                    </div>                                            
                                </div>
                                <section class="field">                                               
                                    <div class="col-lg-12">                                                                    
                                        <h3>Caso for executar algum ajuste, saiba:</h3>
                                        <ul>
                                            <li>1 - Se a frases estiver <span style="color:red">TRANCADA </span> este processo não vai rodar para quela frase</li>
                                            <li>2 - Dê preferência rode este processo na Lista Mandatory da frase, fica mais organizado o processo</li>
                                            <li>3 - Este processo vai gerar as imagens <strong>pendente.webp</strong> para as frases que foram regeradas</li>
                                            <li>4 - Rode este processo de 300 a 700 itens por vêz </li>
                                        </ul>
                                    </div> 
                                </section>
                                <div class="row">
                                    <div class="col">
                                        <form class="form-box" 
                                        action="{{ route('marlon.gerarimagens',"0")}}" method="GET">
                                         {{ csrf_field() }}                                    
                                          @method('PUT')
                                         <input type="hidden" name="id" id="id" value="0" >
                                          De:<input type="text" name="de" id="de" value="1" >
                                          Para:<input type="text" name="para" id="para" value="300" >
                                          
                                          <p>
                                             Considerar itens ja feitos? 
                                          </p>

                                          <p>
                                            @include('front.includes.formulario.Radio',    
                                            [
                                                'input' => 'rever',
                                                'label' => 'Sim', 
                                                'value' => '1', 
                                                'checked' => 'false' 
                                            ])                                          
                                          @include('front.includes.formulario.Radio',
                                          [
                                              'input' => 'rever',
                                              'label' => 'Não', 
                                              'value' => '0', 
                                              'checked' => 'true' ]
                                          )

                                          </p>
                                          
                                          <p>
                                            Listar ou Executar frases  com pendências de Imagens? 
                                        </p>

                                        <p>
                                          @include('front.includes.formulario.Radio',    
                                          [
                                              'input' => 'listar',
                                              'label' => 'Listar apenas', 
                                              'value' => '1', 
                                              'checked' => 'true' 
                                          ])                                          
                                        @include('front.includes.formulario.Radio',
                                        [
                                            'input' => 'listar',
                                            'label' => 'Executar', 
                                            'value' => '0', 
                                            'checked' => 'false' ]
                                        )

                                        </p>
                                        <p>
                                            @include('front.includes.formulario.Textarea',
                                          [
                                              'input' => 'lote',
                                              'label' => 'Lote:', 
                                              'value' => '', 
                                              'placeholder'  => 'Cole aqui a String gerada pela Mônica',
                                              'cols'          => '5', 
                                              'rows'          => '6', 
                                              
                                              ]
                                          )
                                        </p>

                                          <button>
                                            <span class="icon-zynga" style="color:#fff" > Pega bolfo!
                                            </button>
                                      </form>                                                                          
                                    </div>                                        
                                </div>                                
                            </section>                             
                        </div>
                       
                        {{-- endMagic --}}    
                    </div>  
                </div>               
            </div>

            {{-- foter --}}
            @include('front.includes.Footer')
        </div> 
    </div>
@endsection
@section('js-view')    
    <script src="{{ asset('js/back_end_favoritas.js') }}?ver={{env('VER')}}"></script>
@endsection