@extends('template.Paineluser')
@section('css-view')
    @include('front.PerfilForm_Incorp.Assets', ['amp' => $amp])
@endsection
@section('custom-php')
    @include('front.includes.Mobiletest')
    @php
        $mobile = false ; //isMobile($options ?? null)  ● Projeto20221201  = desativar a função em view isMobile() ;$mobile = isMobile($options ?? null);
        $customThema = $logado ? $logado->thema : '';
        $customClass = 'perfil-form';
        $arrpastas = $logado ? $logado->pastas()->all() : [];
        $pageType = 'perfil';
        $titulo = $titulo ?? null;
        if(!$titulo)
            $titulo = isset($tabela) ? (property_exists($tabela,"titulo") ? $tabela->titulo : null) : null;
        if(!$titulo)
            $titulo = data_get($seo, 'titulo', "Fraseteca");
        //custons
        $msgValidatorArr = \App\Services\MsgValidator::run($errors);
        $dados=[];
        $sexo_dados =[
                'Não Informar' => 'NI',
                'Masculino' => 'M',
                'Feminino' => 'F',
                
            ];  
        $nome_completo = $usuario->nome_completo ? $usuario->nome_completo : $usuario->name;
    @endphp
@endsection


@section('conteudo-view')

    <div class="wrapper-area-jsupload" id="jsuploadBefore"></div>
    <div id="mudaStatus" class="mudaStatus">ocioso</div>
    <section class="margin-auto full-width-content conteudo--header--painel">
        <div class="margin-auto max-width-content conteudo--header--painel--item">
            <h1 itemprop="name" class="titulo">
                {{ $titulo }} 
            </h1><span itemprop="headline" style="display:none;">{{ $titulo }}</span>
        </div>
    </section>

    <section class="margin-auto full-width-content perfil--form">            
        @include('front.PerfilForm_Incorp.Edit')
    </section>


    <section class="margin-auto full-width-content conteudo--header--painel">
        <div class="margin-auto max-width-content conteudo--header--painel--item">
            <h1 itemprop="name" class="titulo">
                Alterando a sua senha
            </h1><span itemprop="headline" style="display:none;">{{ $titulo }}</span>
        </div>
    </section>

    <section class="margin-auto full-width-content perfil--update--senha">
        @include('front.PerfilForm_Incorp.Alterarsenha')
    </section>
    

    <section class="margin-auto full-width-content conteudo--header--painel">
        <div class="margin-auto max-width-content conteudo--header--painel--item">
            <h1 itemprop="name" class="titulo">
                Excluir Conta
            </h1><span itemprop="headline" style="display:none;">{{ $titulo }}</span>
        </div>
    </section>
    <section class="margin-auto full-width-content perfil--form--excluir">
        @include('front.PerfilForm_Incorp.Excluirconta')
    </section>

@endsection
@section('js-view')
    <script src="{{ asset('js/PerfilForm.js') }}?ver={{ env('VER') }}"></script>
@endsection

