@extends('template.Login')

@section('css-view')
    @include('front.LoginShow_Incorp.Assets', ['amp' => $amp])
@endsection

@section('custom-php')
    @include('front.includes.Mobiletest')
    @php
        $mobile = false ; //isMobile($options ?? null)  ● Projeto20221201  = desativar a função em view isMobile() ;
        $customThema = isset($logado) ? ($logado ? $logado->thema : '') : "";
        $customClass = 'single-frase';
        $arrpastas = isset($logado) ? ($logado ? $logado->pastas()->all() : []) : [];
        $pageType = 'archive';
        //custons
        $token_reverso = $token_reverso ?? 0;
        $page= $page ?? "login";
        $usuariologado = \Auth::user();
        $seuEmail = "seu email";
        $PageTitulo = "Faça Login";
        switch ($page) {
        case 'login':
                $PageTitulo = "Faça Login";
                break;

            case 'resetar_senha':
                $PageTitulo = "Resete a sua senha";
                break;
            
                case 'resetar_senha_update':
                $PageTitulo = "Confirme a sua senha";
                break;

                case 'registrar':
                $PageTitulo = "Crie sua Conta";
                break;

                case 'falta_confirmar_email':
                $PageTitulo = "Verifique seu Email";
                break;

                case 'preferencias':
                $PageTitulo = "Qual tipo de frase você gosta?";
                break;
                
                default:
                $PageTitulo = "Faça Login";
                break;
        }
        $msgValidatorArr = \App\Services\MsgValidator::run($errors);

    @endphp
@endsection

@section('conteudo-view')
    <header class="page-header">
        @include('front.includes.Logo',["amp" => $amp,"logado" => $logado ?? null])
        <div class="demarcador-marca no-print"></div>
    </header>
    <section class="margin-auto full-width-content conteudo">

        @switch($page)
            @case("login")
                @include ('front.LoginShow_Incorp.Login')
                @break
            
            @case("registrar")
                @include ('front.LoginShow_Incorp.Registrar')
                @break
            
            @case("resetar_senha")
                @include ('front.LoginShow_Incorp.Resetarsenha')
                @break

            @case("resetar_senha_update")
                @include ('front.LoginShow_Incorp.Resetarsenhaform')
                @break

            @case("falta_confirmar_email")
                @include ('front.LoginShow_Incorp.Faltaconfirmaremail')
                @break

            @case("preferencias")
                @include ('front.LoginShow_Incorp.Preferencias')
                @break

        @endswitch   
    </section>

@endsection
@section('js-view')
    @if (!$amp)
        @if (isset($logado))
            @include('front.includes.Json', [
                'id' => 'arrPastasData',
                'tabela' => 'PastaUsuarioItem',
                'dadosItens' => $arrpastas,
            ])
            <script src="{{ asset('js/LoginShow.js') }}?ver={{ env('VER') }}"></script>
        @else
            <form ref="call_login" class="form-box" action="https://fraseteca.com.br/login" method="GET">
                @php $rand = rand(0,9); @endphp
                <input type="hidden" name="token_reverso" value="l{{ $rand }}{{ $idpost ?? 0 }}">
                <button type="submit" class="ref_call_login hidden">Login</button>
            </form>
            <script src="{{ asset('js/LoginShow__nolog.js') }}?ver={{ env('VER') }}"></script>
        @endif
    @endif
@endsection
