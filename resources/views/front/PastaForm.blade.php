@extends('template.Paineluser')
@section('css-view')
    @include('front.PastaForm_Incorp.Assets', ['amp' => $amp])
@endsection
@section('custom-php')
    @include('front.includes.Mobiletest')
    @php
        $mobile = false ; //isMobile($options ?? null)  ● Projeto20221201  = desativar a função em view isMobile() ;
        $customThema = $logado ? $logado->thema : '';
        $customClass = 'single-frase';
        $arrpastas = $logado ? $logado->pastas()->all() : [];
        $pageType = 'pastas';
        $titulo = $titulo ?? null;
        if(!$titulo)
            $titulo = isset($tabela) ? (property_exists($tabela,"titulo") ? $tabela->titulo : null) : null;
        if(!$titulo)
            $titulo = data_get($seo, 'titulo', "Fraseteca");

        $tituloMobile = $titulo . "...";
        //custons
        $msgValidatorArr    = \App\Services\MsgValidator::run($errors);
        $tbFrase            = null;
        $dadosItens         = [];
        $nItens             = 0;
        $capa               = asset("images/bgs/fundo-v01.svg");
        $capa_m             = asset("images/bgs/fundo-v01.svg");

        $id                 = 0;    
        //viewPasta
        $tituloActionViewPasta      = "Tornar esta Biblioteca Pública";
        $subTituloActionViewPasta   = "Todos poderão acessar";
        $tituloViewPasta            = "Esta biblioteca é privada";
        $subTituloViewPasta         = "Só você pode ver";
        $statusViewpasta            = "privada";
        $icoViewPasta               = "ico-share";
        if (isset($dados->itens))
            if (count($dados->itens)){
                $nItens = count($dados->itens); 
                foreach ($dados->itens as $key => $item) {
                    $tbFrase = $item->getFrase();
                    if ($tbFrase){
                        $item->frase        = $tbFrase->frase;
                        $item->autor        = $tbFrase->autor;
                        $item->capa         = $tbFrase->capa;
                        $item->token        = $tbFrase->token;
                        $item->statusOnView = 0;
                    }
                    else {
                        $item->capa = null;
                        $item->statusOnView = 0;
                    }
                    array_push($dadosItens,$item);
                }
            }
        if($action=='edit'){
            $titulo = $dados->titulo ?? ""; 
            $id = $dados->id ?? "";
            if(isset($dados->status))
            if ($dados->status=="2") {                        
                $tituloActionViewPasta      = "Tornar esta Pasta Secreta";
                $subTituloActionViewPasta   = "Só você poderá ver";
                $tituloViewPasta            = "Esta pasta é publica";
                $subTituloViewPasta         = "todos podem acessar";
                $statusViewpasta            = "publica";
                $icoViewPasta               = "ico-compartilhar-view";
            } 
            if(isset($dados->capa))       
            if($dados->capa) {
                $capa = $dados->capa;
                $capa_m = $dados->capa;
            }
            // if(!count($dados->itens)){
            //     $item = [];
            //     $item["id"] = 1;
            //     $item["new"] = true;
            //     $item["frase"] = "Vamos começar: clique aqui para inserir a sua frase, sua ideia ou inspiração!";
            //     $item["autor"] = "Autor da frase";
            //     $item["frase_id"] = 0;
            //     $item["capa"] = null;
            //     $item["token"] = "frase123456";
            //     $item["ordem"] = "1";
            //     $item["statusOnView"] = 0;
            //     $item["mostraimg"] = 0;
            //     array_push($dadosItens,$item);
            // }
        }


    function limitar($conteudo, $tamanho)
    {        
        $contaLetra = 0;
        $x=0;
        $retorno = '';
        $texto_quebrado = explode(' ',$conteudo);

        
        foreach($texto_quebrado as $tq) {        
            $texto = $texto_quebrado[$x] . ' ';           
            $x++;        
            $contaLetra = $contaLetra + 1;
            for($i=0; $i<strlen($tq); $i++){                
                $contaLetra++;            
                
            }        
            if ($contaLetra <= $tamanho )
                $retorno .= $texto;   
            else {                            
                // $retorno .= '..';
                return $retorno;
            }        
        }    
        
        return $retorno;
    }

    @endphp
@endsection


@section('conteudo-view')

    <div class="wrapper-area-jsupload" id="jsuploadBefore"></div>

    @if ($action=='create')
    <form id="formulario" class="form-create"  action="{{ CustomRoute::go(route('pastas.store'))}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
    @else 
    <form id="formulario" class="w100 form-edit" action="{{ CustomRoute::go(route('pastas.update',$id))}}" method="post" enctype="multipart/form-data">
        @method('PUT')
        {{ csrf_field() }}
    @endif
        <section class="margin-auto full-width-content conteudo--header--painel">
            @if ($action=='create')
                @include('front.PastaForm_Incorp.Createtitle')
            @else 
                @include('front.PastaForm_Incorp.Edittitle')
            @endif
        </section>
        <section class="margin-auto max-width-content pasta--form {{ $action }}">
            {{-- Editar pastas --}}
            <div id="mudaStatus" class="mudaStatus">ocioso</div>
            @if ($action=='create')
                @include('front.PastaForm_Incorp.Create')
            @else 
                @include('front.PastaForm_Incorp.Edit')
                @include('front.PastaForm_Incorp.Add', [
                    "action" => $action
                ])
            @endif
        </section>
    </form> 
    @include('front.PastaForm_Incorp.Json', [
        "id" => "arrFrasesData",
        "tabela" => "PastaUsuarioItem",
        "dadosItens" => $dadosItens
    ])
    <button id="btUpdateTela" class="hidden updateArrayDoInputMagic">update</button>
    @if (isset($aprovacao))
        @if (isset($_GET['idAprovacao']))
            <section class="margin-auto max-width-content wrapper-aprovacao">
                @include('front.PastaForm_Incorp.Aprovador')
            </section>
        @endif
    @endif
    {{-- Zona dos formulários --}}
    <form id="formPublicar" action="{{ route('pastas.tornarPublica')}}" method="post" enctype="multipart/form-data">
        @method('POST')
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{$id}}">
    </form>
    <form id="formDeletar" action="{{ route('pastas.destroy',$id)}}" method="post" enctype="multipart/form-data">
        @method('DELETE')
        {{ csrf_field() }}
    </form>
@endsection
@section('js-view')
    <script src="{{ asset('js/PastaForm.js') }}?ver={{ env('VER') }}"></script>
@endsection

