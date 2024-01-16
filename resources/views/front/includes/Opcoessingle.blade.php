@php
    $ip = $_SERVER['REMOTE_ADDR'];
    $seguindo = $seguindo ?? null;
    $curtida = $curtida ?? null;
    $curtidaid = '';
    $seguindoid = '';
    $tipo = '0';
    $compartilharstr = 'p';
    $tipoparapasta = '0';
    if (!isset($tabela)) {
        $tabela = 'post';
    }
    if ($tabela == 'autor') {
        $tipo = '2';
        $tipoparapasta = '2';
        $compartilharstr = 'a';
    }
    if (!isset($totalcurtidasdopost)) {
        $totalcurtidasdopost = 0;
    }
    $favoritaoptions = ['classe' => 'enable', 'fnAjax' => 'nointeract'];
    if (isset($logado)) {
        if (isset($seguindo)) {
            $seguindoid = $seguindo->id;
        }
        if ($seguindo) {
            $favoritaoptions = ['classe' => 'disable', 'fnAjax' => 'favoritaDelete'];
        } else {
            $favoritaoptions = ['classe' => 'enable', 'fnAjax' => 'favoritaStore'];
        }
        if ($logado->id == $tabela->autor_id || $logado->id == $tabela->usuario_id) {
            $favoritaoptions = ['classe' => 'nointeract', 'fnAjax' => 'nointeract'];
        }
        if ($curtida) {
            $curtidaid = $curtida->id;
            $curtida_options = [
                'classe' => 'disable',
                'total' => $totalcurtidasdopost,
            ];
        } else {
            $curtida_options = [
                'classe' => 'enable',
                'total' => $totalcurtidasdopost,
                'fnAjax' => 'curtidaStore',
            ];
        }
    } else {
        $curtida_options = [
            'classe' => 'disable',
            'total' => $totalcurtidasdopost,
            'fnAjax' => 'delete',
        ];
        if ($curtida) {
            $curtidaid = $curtida->id;
            $curtida_options = [
                'classe' => 'enable',
                'total' => $totalcurtidasdopost,
            ];
        }
    }
@endphp
@if ($amp)
    <div class="opcoes--single no-print">
        <ul class="ul-opcoes--single">
            <li>
                <a id="btCurtirPost" href="/login"
                    title="@if (!isset($logado)) Para poder curtir esta lista de Frases você precisa estar logado ao sistema! Deseja fazer login? @else Curtir Lista @endif"
                    rel="nofollow" class="botao-opcoes btCurtirPost @if ($curtidaid) disable @endif ">
                    <span class="totalcurtidas no-interact" id="totalCurtidasHtml">{{ $totalcurtidasdopost }}</span>
                    <amp-img src="/images/icones/24x24/curtir-v01.svg" width="24px" height="24px" layout="{{ $layout ?? 'fixed' }}"></amp-img>
                </a>
            </li>
            <li>
                <a href="/login" class="botao-opcoes favoritaStore {{ $favoritaoptions['classe'] }} "
                    id="{{ $favoritaoptions['fnAjax'] }}" title="Seguir esta pasta">
                    <amp-img src="/images/icones/24x24/seguir-v01.svg" width="24px" height="24px" layout="{{ $layout ?? 'fixed' }}"></amp-img>
                </a>
            </li>
            <li>
                <a href="/login" class="botao-opcoes abreCompartilhar" title="Compartilhar">
                    <amp-img src="/images/icones/24x24/compartilhar-v01.svg" width="24px" height="24px" layout="{{ $layout ?? 'fixed' }}"></amp-img>
                </a>
            </li>
            <li>
                <a href="/login" class="botao-opcoes imprimir last" title="Imprimir">
                    <amp-img src="/images/icones/24x24/print-v01.svg" width="24px" height="24px" layout="{{ $layout ?? 'fixed' }}"></amp-img>
                </a>
            </li>
        </ul>
    </div>
@else
    @if (!isset($logado))
        <form ref="call_login" class="form-box" action="/login" method="GET">
            {{ csrf_field() }}
            @method('GET')
            @include('front.includes.formulario.Btaction', [
                'input' => 'call_login',
                'label' => ' Login',
                'aviso' => 'confirma info',
                'class' => 'hidden',
                'titulo' => 'Que tal fazer Login?',
                'pergunta' =>
                    'Para salvar este conteúdo, você precisa ter cadastro e fazer login. Deseja fazer Login?', //$mensagens->mensagens_cadastro['quer_fazer_login_favoritar_lista'],  //07_dez
                'vaction' => 'call_login',
            ])
        </form>
    @else
        @php $rand = rand(0,9); @endphp
        <input type="hidden" id="token_reverso" name="token_reverso" value="l{{ $rand }}{{ $idpost }}">
        <input type="hidden" id="curtida_id" ref="ref_curtidaid" value="{{ $curtidaid }}" />
        <input type="hidden" id="tipo" ref="ref_tipo" value="{{ $tipo }}" />
        <input type="hidden" id="tipo_para_pasta" ref="ref_tipo_pasta" value="{{ $tipoparapasta }}" />
        <input type="hidden" id="seguindo_id" value="{{ $seguindoid }}" />
        <input type="hidden" id="totalCurtidas" ref="ref_totalCurtidas" value="{{ $totalcurtidasdopost }}" />
    @endif
    <div class="opcoes--single no-print pai">
        <ul>
            <li>
                <a id="btCurtirPost" href="/login"
                    title="@if (!isset($logado)) Para poder curtir esta lista de Frases você precisa estar logado ao sistema! Deseja fazer login? @else Curtir Lista @endif"
                    rel="nofollow" class="botao-opcoes btCurtirPost @if ($curtidaid) disable @endif ">
                    <span class="totalcurtidas no-interact" id="totalCurtidasHtml">{{ $totalcurtidasdopost }}</span>
                    <span data-src="@if ($curtidaid) /images/icones/24x24/curtir-on-v01.svg @else /images/icones/24x24/curtir-v01.svg @endif" class="ico lazy-background lazy-curtir @if ($curtidaid) curtido @endif"></span>
                </a>
            </li>
            <li>
                <a href="/login" class="botao-opcoes favoritaStore {{ $favoritaoptions['classe'] }} "
                    id="{{ $favoritaoptions['fnAjax'] }}" title="Seguir esta pasta">
                    <span data-src="/images/icones/24x24/seguir-v01.svg" class="ico lazy-background lazy-seguir @if ($seguindo) seguindo @endif"></span>
                </a>
            </li>
            <li>
                
                <a href="#" class="botao-opcoes abreCompartilhar" title="Compartilhar">
                    <span data-src="/images/icones/24x24/compartilhar-v01.svg"  class="ico lazy-background lazy-compartilhar"></span>
                </a>
            </li>
            <li>
                <a href="#" class="botao-opcoes imprimir last" title="Imprimir">
                    <span data-src="/images/icones/24x24/print-v01.svg" class="ico lazy-background lazy-print"></span>
                </a>
            </li>
        </ul>

    </div>
@endif
