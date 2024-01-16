@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: PerfilShow.blade.php
     * Autor: LM
     * Objetivo: Principal programa responsável por criar o HTML do perfil
     * Doc: 
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     * ● Fraseteca2023Set03 - problemas na no uso da distribuição
     *     >> 26-09-23 - ajustar o link da navegação
     *--------------------------------------------------------------------------------------------------------------*/
@endphp
@extends('template.Front')
@section('css-view')
    {{-- Folha de estilos --}}
    @include('front.PerfilShow_Incorp.Assets', ['amp' => $amp])
@endsection
@section('custom-php')
    @include('front.includes.Mobiletest')
    @php
    $mobile = false ; //isMobile($options ?? null)  ● Projeto20221201  = desativar a função em view isMobile() ;
    $customThema = $logado ? $logado->thema : '';
    $customClass = 'perfil';
    $idpost = data_get($dados, 'id', null);
    $perfil = data_get($dados, 'link-autor', '');
    $listasClass = '';
    $seguidoresClass = '';
    $seguindoClass = '';
    $classAtiva = count($arrListas) ? 'listas' : null;

    if (count($arrSeguidores)) {
        $classAtiva = $classAtiva ? $classAtiva : 'seguidores';
    }

    if (count($arrSeguindo)) {
        $classAtiva = $classAtiva ? $classAtiva : 'seguindo';
    }

    $classAtiva = $classAtiva ?? "listas";
    
    if ($classAtiva == 'listas') {
        $listasClass = 'ativa';
    }

    if ($classAtiva == 'seguidores') {
        $seguidoresClass = 'ativa';
    }

    if ($classAtiva == 'seguindo') {
        $seguindoClass = 'ativa';
    }


    @endphp
@endsection

@section('conteudo-view')
    <section class="margin-auto max-width-content conteudo--header ">
        <div class="conteudo--header-ele1 no-print ">
        </div>
        <div class="conteudo--header-ele2 ">
            @include('front.includes.Biografiaperfil', [
                'amp' => $amp,
                'dadosdoautor' => $dados,
                'tipo' => 'perfil',
            ])
        </div>
        <div class="conteudo--header-ele3 flex-end no-print archive--header ">
            @if (isset($logado))
                @if (intval($dados["id"]) != intval($logado->id))
                    @include('front.includes.formulario.Btseguindo', [
                        'amp' => $amp,
                        'url' => $seo['canonical'],
                        'seguindo' => $seguindo,
                    ])
                @endif 
            @else
                @include('front.includes.formulario.Btseguindo', [
                    'amp' => $amp,
                    'url' => $seo['canonical'],
                    'seguindo' => $seguindo,
                ])
            @endif
        </div>
    </section>
    <section class="margin-auto max-width-content conteudo ">
        <ul class="accordeon--buttoons">
            <li><a href="#" data="listas" class="bt-accordion listas {{ $listasClass }}">Bibliotecas</a></li>
            <li><a href="#" data="seguidores" class="bt-accordion seguidores {{ $seguidoresClass }}">Seguidores</a></li>
            <li><a href="#" data="seguindo" class="bt-accordion seguindo {{ $seguindoClass }}">Seguindo</a></li>
        </ul>
    </section>
    <div class="demarcador-marca no-print"></div>
    
    <section class="margin-auto max-width-content conteudo mb-50">
        <div class="accordion">
            <div class="accordion--item listas {{ $listasClass }}">
                @include('front.PerfilShow_Incorp.Item', [
                    'amp' => $amp,
                    'accordion' => 'listas',
                    'tipo' => 'minhas-pastas pastas minhas-pastas',
                    'dados' => $arrListas,
                    'lastPage' => 3,
                ])
            </div>
            
            <div class="accordion--item seguidores {{ $seguidoresClass }}">
                @include('front.PerfilShow_Incorp.Item', [
                    'amp' => $amp,
                    'accordion' => 'seguidores',
                    'tipo' => 'circulo',
                    'dados' => $arrSeguidores,
                    'description' => "Sem seguidores no momento",
                    'lastPage' => 3,    
                ])
            </div>
            <div class="accordion--item seguindo {{ $seguindoClass }}">
                @include('front.PerfilShow_Incorp.Item', [
                    'amp' => $amp,
                    'accordion' => 'seguindo',
                    'tipo' => 'circulo',
                    'dados' => $arrSeguindo,
                    'description' => "Este perfil não está seguindo ninguém no momento...",
                    'lastPage' => 3,
                ])
                @include('front.includes.Tags', [
                    'nome' => $dados['nome-autor'],
                    'dados' => $arrTagsSeguindo,
                ])
            </div>
        </div>
    </section>
    <div class="demarcador-marca no-print"></div>
@endsection
@section('js-view')
    @if (!$amp)
        <form class="form-box" action="/login" method="GET">
            @php $rand = rand(0,9); @endphp
            <input type="hidden" name="token_reverso" id="token_reverso" value="l{{ $rand }}{{ $idpost ?? 0 }}">
            <button type="submit" class="ref_call_login hidden">Login</button>
        </form>
        @if (isset($logado))
            <script src="{{ asset('js/PerfilShow.js') }}?ver={{ env('VER') }}"></script>
        @else
            <script src="{{ asset('js/PerfilShow__nolog.js') }}?ver={{ env('VER') }}"></script>
        @endif
    @endif
@endsection
