@extends('template.Usuario')

@section('css-view')
@endsection



@section('conteudo-menu') 
       
@endsection

@section('conteudo-view')

    @php
        $msgValidatorArr = \App\Services\MsgValidator::run($errors);

        use App\Services\ClearString;
            $functions= new ClearString;    

        $default_page="listas.inserir";     
        $idDaAprovacao = 0;

        if(isset($_GET['idAprovacao']))
            $idDaAprovacao = $_GET['idAprovacao'];

        //dados da tabela
        $idTabela=0;$titulo ="";
        $descricao_previa   ="";
        $image_create       = 1;
        $imgSrc             ="null"; //asset('img/padrao.jpg');
        $capa               ="";
        $midiaId            ="";
        $status             =2;
        $categoria_dados    =[];        
        $categoria_id       =0;
        $thumb              ="";    
        $conteudo           =10;    
        $usuario            =$logado->id;    
        $unsplashIdFotoAtual="";
        $urlAmigavel =null;
        $canonical =null;

        $rand               =rand(1,999);
        if(isset($lista)):            
            $idTabela           = $lista ? $lista->id : 0;
            $titulo             = $lista ? $lista->titulo : '';
            $status             = $lista ? $lista->status : '2';
            $categoria_id       = $lista ? $lista->categoria_id : 0;
            $descricao_previa   = $lista ? $lista->descricao_previa : 'descrição...';
            $capa               = $lista ? $lista->capa : '0';
            $midiaId            = $lista ? $lista->midia_id : 0;
            $imgSrc             = $lista ? $lista->getImagemCapaAttribute() : $capa  ;
            $thumb              = $lista ? $lista->thumb : ''; 
            $conteudo           = $lista ? $lista->conteudo : 10; 
            $usuario            = $lista ? $lista->usuario_id : $logado->id;    
            $aux = explode("&id=",$imgSrc);
            if(count($aux)>1)
                $unsplashIdFotoAtual=$aux[1];
            

         
            $urlAmigavel = $functions->limpaCaracteresEspeciais($titulo,"lista", $usuario);
            $canonical = $functions->limpaCaracteresEspeciais($titulo,"", $usuario);
            
            
        endif;
        $imgSrc = $imgSrc . "?ver=" . env("VER") . "_".$rand;
        if(isset($categorias)):
            foreach ($categorias as $key => $categoria) {                                                                                            
                $categoria_dados[$categoria->descricao] = $categoria->id;                             
            }
        endif;
        //oldCustom
        $oldCapa = old("capa");
        if(isset($oldCapa)){
            $imgSrc = $oldCapa;
            $capa = $oldCapa;
        }
        //buscar se o avatar está pendente ou não        
        $pendenteLabel="";
        $pendenteAviso="";        
        $pendenteClass = $imgSrc; //$usuario->getAvatarNoPerfilAttribute();
        $termo = "pendente";
        $pattern = '/' . $termo . '/';

        if (preg_match($pattern,$pendenteClass)){
                $pendenteLabel = 'Status:';
                $pendenteAviso='Antenção: Imagem <strong>pendente</strong> de aprovação, ainda não está visível no site!';
                $pendenteClass = "pendente";
        }
        else 
            $pendenteClass = "";        



    @endphp
    
    <div class="page" id="app">
        {{-- validatorSys será colocado aqui, via JS, pelo Mixin --}}        
        @include('front.includes.Retorno')
        <bt-confirma :confirma="objConfirma"></bt-confirma>
        @include('back.includes.Menulateral')
        @include('front.includes.Areapesquisa')
        <div class="corpo-da-pagina" >
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
                    <div id="content" class="default-form {{$default_page}}">    
                        
                        <div class="ver-site">
                            @php
                                $rotaVer = env('APP_URL') . '/' . $lista->urlamigavel;
                            @endphp
                            <a href="{{ $rotaVer }}">Ver Post</a>

                        </div>
                        <div class="bt-salvar-fixed">
                            @include('front.includes.formulario.Btsalvar', [
                                'rota' => 'post.update',
                                'id' => $idTabela,
                                'class' => 'rascunho item-bt-salvar-fixed',
                                'vaction' => 'enviarParaRascunho',
                                'icone' => 'save',
                                'tip' => 'Salvar alterações',
                            ])
                            <a href="#fim"
                                style="display: block;margin-top: 10px;background: #f0f0f0;color: #3d4745;padding: .7em;text-align: center;border-radius: 5px;box-shadow: 0 5px 10px rgba(81, 81, 81, 0.3);"><i
                                    class="ico ico-seta "></i> <span></span></a>
                        </div>


                        <div class="content-wrapper">
                            {{-- startMagic --}}                                                      
                            <?php if($idTabela == 0): ?>
                                <form 
                                ref="formulario" 
                                action="{{ route('lista.store')}}"
                                method="post" 
                                enctype="multipart/form-data"
                                >
                                <div id="view_method">
                                    <input ref="method" type="hidden" name="_method" value="">
                                </div>
                            <?php else: ?>    
                                <form ref="formulario" 
                                action="{{ route('lista.update', $idTabela)}}" 
                                method="post" 
                                enctype="multipart/form-data"
                                >                                    
                                @method('PUT')
                            <?php endif;?>   
                            {{ csrf_field() }}
                                <header>
                                    <h1>
                                        <i class="icon icone icon-005-plus title"></i>
                                        @if ($idTabela > 0)
                                            Remessa da Marta
                                        @else  
                                            Criando minha Lista de Frases
                                        @endif
                                    </h1>
                                </header>                                   
                                <section class="field">
                                    <header>
                                        <p class="aproximar">Título:</p>
                                    </header>
                                    <div class="row">                                                                    
                                            
                                            @include('front.includes.formulario.Input', [
                                                'input'         => 'titulo',
                                                'label'         => '',
                                                'old'           => old('titulo'),
                                                'inputCol'      => 'col-lg-12 titulo',
                                                'class'         => 'titulo ' ,
                                                'ref'           => 'titulo', 
                                                'vmodel'        => 'titulo',                                        
                                                'value'         =>  $titulo ,                                                 
                                                'placeholder'   => 'Título (Obrigatório)',
                                                'ajuda'         => '',                                                
                                                'validator'     => true,
                                                'msgValidator'  => isset($msgValidatorArr['titulo']) ? $msgValidatorArr['titulo'] : null,
                                                
                                            ])
                                    </div>
                                </section>                                
                                <section class="field field-preview-listas"> 
                                    @include('front.includes.formulario.Hidden',[
                                        'input' => 'unsplashIdFotoAtual',                                                         
                                        'value'=> $unsplashIdFotoAtual,
                                        'vmodel'=>'unsplashIdFotoAtual' //'vmodel'=>'avatar_icone'
                                    ])
                                </section>
                                <section class="field">                                 
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                    @include('front.includes.formulario.Select',    [
                                                    'input'  => 'categoria_id',   
                                                    'class'  => "",                     
                                                    'value'  => $categoria_id, 
                                                    'old'    => old('categoria_id'),                        
                                                    'ref'    => 'categoria_id', 
                                                    'vmodel' => 'categoria_id',
                                                    'align' => 'right',                                                                             
                                                    'dados' => $categoria_dados ,                                                    
                                                    'inputCol' => 'col-lg-12'                                                                                                         
                                                    ]) 
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section class="field mt-40">
                                    <header>
                                        <p class="aproximar"><h2 style="text-align: center">░░░░ ◉ Frases importadas da Marta ◉ ░░░░</h2></p>
                                    </header>
                                </section>
                                <section class="field">                                 
                                    <div class="row">
                                        <div class="col-lg-12">  
                                            <remessas opcoes="{{ $options }}" itens="{{ $itens }}"
                                            idDoPost="{{ $idTabela }}" />

                                            {{-- @include('back.ListaForm_Incorp.Item', ['itens' => $itens,  'idTabela' => $idTabela, 'options'  => $options]) --}}
                                        </div>
                                    </div>
                                </section>
                                <section id="fim" class="field">                                 
                                    {{-- <div class="row">
                                        <div class="col-lg-12 text-center pai">
                                            @include('front.includes.formulario.Btsalvar',[                                                            
                                                'icone'  => 'plus',
                                                'class'  => 'btn-add-frases',
                                                'vmodel' => 'categoria_id',
                                                'label' => 'Acrescentar mais Frases',
                                                'tip'  => 'Acrescentar mais Frases'
                                            ])
                                        </div>
                                    </div> --}}
                                   
                                </section>                                
                               
                                <textarea 
                                ref="lista_itens" 
                                class="frase hidden" 
                                name="lista_itens" 
                                id="lista_itens" 
                                cols="30" 
                                rows="10"></textarea>
                                @include('front.includes.formulario.Hidden',    [
                                    'input' => 'frases_old',
                                    'value' => old('lista_itens'), 
                                    'vmodel'=> 'frases_old',
                                    'ref' => 'frases_old'
                                ])
                                @include('front.includes.formulario.Hidden',    [
                                    'input' => 'idDaLista',
                                    'value' => $idTabela, 
                                    'vmodel'=> 'idDaLista',
                                    'ref' => 'idDaLista'
                                ])
                                @include('front.includes.formulario.Hidden',    [
                                    'input' => 'status',
                                    'value' => $status, 
                                    // 'vmodel'=> 'idDaLista',
                                     'ref' => 'status'
                                ])
                                @include('front.includes.formulario.Hidden',    [
                                    'input' => 'deletados',
                                    'value' => '', 
                                    'vmodel'=> 'deletados',
                                    'ref' => 'deletados'
                                ])
                                
                                @include('front.includes.formulario.Hidden',    [
                                    'input' => 'conteudo',
                                    'ref' => 'conteudo',
                                    'value' => $conteudo
                                ])
                                @include('front.includes.formulario.Hidden',[
                                    'input' => 'usuario_id', 
                                    'ref' => 'usuario_id',
                                    'value' => $usuario
                                 ])
                                
                                <section class="field">                                 
                                    <div class="row">
                                        
                                        <div class="col-md-6 float-left  zona-bt-enviar-lista ">
                                            @include('front.includes.formulario.Btsalvar',[                
                                                'rota'    => 'lista.update',
                                                'id'      =>  $idTabela,  
                                                'class'   => 'botao-padrao full green ',
                                                'vaction' => 'enviarParaRevisao',
                                                'confirma'=> 'formulario',                                                    
                                                'aviso'   => 'confirma info',
                                                'pergunta'  => 'Deseja enviar esta lista para a revisão?',
                                                'lbconfirma' => 'Enviar',  
                                                'lbcancela'  => 'Cancelar',
                                                'label'   => 'Enviar Lista para aprovação',
                                                'tip'     => 'Envie a sua nova lista de frases para revisão'
                                            ])
                                            
                                        </div>
                                    </div>
                                    
                                </section>

                            </form>
                            {{-- endMagic --}}
                        </div>

                        {{-- //usuário aprovador --}}
                        @if (
                            isset($aprovacao)                        
                        //$logado->perfil === '1'
                        )
                            @php
                                $observacao = $aprovacao->observacao ? $aprovacao->observacao:'';
                            @endphp

                            <form ref="formulario_aprova" 
                            action="{{ route('aprovacao.rejeitar')}}" 
                            method="post" 
                            enctype="multipart/form-data"
                            >
                            {{ csrf_field() }}  
                            @method('post')
                            
                                <div class="content-wrapper">
                                    <header>
                                        <h1>
                                            <i class="icon painel"></i>
                                            @if ($logado->perfil === '1')
                                                Opções do Adminstrador
                                            @else 
                                                Informações da Aprovação
                                            @endif                                            
                                        </h1>
                                    </header>    
                                    {{-- <section class="field">  
                                    
                                        <div class="row">
                                            <div class=" col-lg-12 field-input">
                                                @include('front.includes.formulario.checkbox',    ['input' => 'image_create','label' => 'Criar imagem para cada Frase?', 'value' => '1', 'checked' => $image_create == '1' ? 'true' : 'false' ])
                                            </div>
                                        </div>                                    
                                    </section> --}}

                                    <section class="field">  
                                    
                                        <div class="row">
                                            <div class=" col-lg-12 field-input">                                                
                                                <h4>Tipo de imagem para todas as frases:</h4>
                                                @include('front.includes.formulario.Radio',    ['input' => 'tipoImagemGlobal','class'=>'inline','label' => 'Default',  'value' => '0', 'checked' => 'checked' ])
                                                @include('front.includes.formulario.Radio',    ['input' => 'tipoImagemGlobal','class'=>'inline','label' => 'Amor',  'value' => '1', 'checked' => 'false' ])
                                                @include('front.includes.formulario.Radio',    ['input' => 'tipoImagemGlobal','class'=>'inline','label' => 'Degradê', 'value' => '2', 'checked' => 'false' ])
                                                @include('front.includes.formulario.Radio',    ['input' => 'tipoImagemGlobal','class'=>'inline','label' => 'Feminino', 'value' => '3', 'checked' => 'false' ])

                                                @include('front.includes.formulario.Hidden',[
                                                    'input'  => 'tokenTipoImagem',
                                                    'value'  => '', 
                                                    'vmodel' => 'tokenTipoImagem',
                                                    'ref'    => 'tokenTipoImagem',
                                                ])

                                            </div>
                                        </div>  
                                        
                                        <div class="container-section like-frase-box">                            
                                            <div class="row-input">
                                                <div class="col-md-12 mt-1 mb-5">
                                                    <h4>Slug (url-amigável):</h4>                
                                                    <div class="row">                    
                                                        <div class="col-lg-12">
                                                            @include('front.includes.formulario.Input',    
                                                            ['input' => 'urlAmigavel', 'ref' => 'urlAmigavel', "class" => "magic", 'value' => $urlAmigavel])                    
                                                        </div>
                                                    </div>
                                                    <div class="row">                                        
                                                        <div class="col-lg-12">                        
                                                            <h4>Canonical:</h4>                
                                                            {{$canonical}}
                                                            @include('front.includes.formulario.Hidden',    
                                                            ['input' => 'canonical', 'ref' => 'canonical', "class" => "magic", 'value' => $canonical])                    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>


                                    
                                    <section class="field"                                    
                                        >  
                                        <div class="row">
                                            <div class="col-md-12 mt-1 mb-5">
                                                <h4>Usuário da Lista:</h4>
                                                <div class="row">                                                    
                                                    

                                                    <div class="col-lg-1 label-area ">
                                                        <label for="">Usuário:</label>
            
                                                    </div>
                                                    <div class="col-lg-10">
                                                        @include('front.includes.formulario.Input',    
                                                        ['input' => 'usuario_id', 'ref' => 'usuario_id', 'value' => $usuario])
                                                        
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                    </section>
                                    
    
                                    <section class="field">  
                                        <div class="row">
                                            <div class="col-md-12 mt-1 mb-5">
                                                <h4>Observações da aprovação:</h4>

                                                @include('front.includes.formulario.Hidden',    [
                                                    'input' => 'idDaLista',
                                                    'value' => $idTabela, 
                                                    'vmodel'=> 'idDaLista',
                                                    'ref' => 'idDaLista'
                                                ])

                                                @include('front.includes.formulario.Hidden',    [
                                                    'input' => 'idDaAprovacao',
                                                    'value' => $idDaAprovacao,                                                     
                                                ])

                                                @include('front.includes.formulario.Hidden',[
                                                    'input' => 'resolver',
                                                    'ref'   => 'resolver',
                                                    'value' => 'resolver',                                                    
                                                ])
                                                
                                                @if ($logado->perfil === '1')
                                                    @include('front.includes.formulario.Textarea', [
                                                        'input'         => 'observacao',                                                
                                                        'value'         => $aprovacao->observacao,
                                                        'inputCol'      => 'col-lg-12',                                                
                                                        'class'         => 'descricao', 
                                                        'placeholder'   => 'Observações da aprovação',                                                                                        
                                                        'width'         => '100%', 
                                                        'cols'          => '5', 
                                                        'rows'          => '3',                                                 
                                                    ]) 
                                                @else 
                                                    <p>{{$observacao}}</p>
                                                @endif    

                                                
                                            </div>
                                        </div>  
                                        
                                        @if ($logado->perfil === '1')
                                            <div class="row">
                                                

                                                <div class="col-md-6 float-left  zona-bt-enviar-lista mb-50">
                                                    @include('front.includes.formulario.Btsalvar',[                
                                                        'rota'    => 'aprovacao.resolver',
                                                        'id'      =>  $idTabela,                                                  
                                                        'confirma'=> 'formulario_aprova',   
                                                        'class'   => 'botao-padrao flex com-icone full green',
                                                        'vaction' => 'aprovar',                                                                                              
                                                        'aviso'     => 'confirma info',
                                                        'pergunta'  => 'Deseja Aprovar esta lista?',
                                                        'lbcancela'  => 'Cancelar',
                                                        'icone'  => 'icon-save icon save',                                                    
                                                        'label'  => 'Aprovar',
                                                        'tip'    => 'Aprovar a lista'
                                                    ])                                            
                                                </div>

                                                <div class="col-md-6 float-right text-right zona-bt-rascunho mb-2">
                                                    @include('front.includes.formulario.Btsalvar',[                
                                                        'rota'    => 'aprovacao.resolver',
                                                        'id'     =>  $idTabela,  
                                                        'confirma'=> 'formulario_aprova',                                                    
                                                        'aviso'     => 'confirma cuidado',
                                                        'pergunta'  => 'Deseja Rejeitar esta Lista?',
                                                        'class'  =>  "botao-padrao flex com-icone full red",
                                                        'vaction' => 'rejeitar',                                             
                                                        'icone'  => 'icon-save icon save',                                                    
                                                        'label'  => 'Rejeitar',
                                                        'tip'    => 'Rejeitar a Lista'
                                                    ])
                                                    
                                                </div>

                                            </div>
                                        @endif    
                                    </section>                                     
                                </div>

                            </form>
                        @endif
                        {{-- Excluir Lista --}}
                        @if ($idTabela)
                            <div class="content-wrapper">
                                <header>
                                    <h1>
                                        <i class="icon atention"></i>
                                        Excluir Lista
                                    </h1>
                                </header>    
                                <section>                               
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <h3>Após excluir sua lista, é impossível reativá-la depois :(</h3>
                                        </div>    
                                        <div class="col-lg-3">
                                            @php
                                                $vaction  ='enviar_lixeira'.$idTabela;
                                                $pergunta ='Deseja realmente excluir esta Lista?';
                                                $aviso    = 'confirma cuidado';
                                            @endphp    

                                            <form ref="enviar_lixeira{{$idTabela}}" class="form-box" 
                                            action="{{ route('lista.destroy',$idTabela)}}" method="POST">
                                            {{ csrf_field() }}                                    
                                            {{method_field('DELETE')}}
                                            @method('DELETE')
                                            @include('front.includes.formulario.Hidden',['input' => 'id','value' => $idTabela])
                                            
                                            <a                                         
                                            href="" 
                                            v-on:click="getConfirm('{{$vaction}}', $event, '{{$pergunta ?? "Confirma esta operação:?"}}', '{{$aviso ?? "atencao"}}')"
                                            class="bt-link bt-rosa bt-center"                                           
                                            title="Excluir Lista">
                                            Excluir Lista
                                            </a>
                                            </form>                                                                                        
                                                
                                        </div>
                                    </div>
                                </section>
                            </div>                          
                         @endif
                         {{--Fim exluir lista  --}}
                    </div>
                </div>
            </div>

            {{-- toolbar --}}
            <div class="toolbar">
                <div class="container">
                    <div class="wrapper">
                        <div class="toolbar-sidebar"></div>
                        <div class="toolbar-content">
                            <div class="content-wrapper toolbar-content-wrapper">
                                <ul>
                                    <li>                                        
                                        <a href="#" class="">
                                            <i class="ico ico-seta-acima"></i>
                                            <span>Início</span>
                                        </a>
                                        <a href="#fim" class="">
                                            <i class="ico ico-seta-baixo "></i>
                                            <span>Fim</span>
                                        </a>
                                        <a href="#" @click.stop.prevent="enviarParaRascunho">
                                            <i class="icon-save icon save "></i>
                                            <span>Salvar</span>                
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </a>  
            </div>
            {{-- foter --}}
            @include('front.includes.Footer')
        </div> 
    </div>
@endsection
@section('js-view')   
    <script src="{{ asset('js/ListaForm.js') }}?ver={{ env('VER') }}"></script> 
@endsection