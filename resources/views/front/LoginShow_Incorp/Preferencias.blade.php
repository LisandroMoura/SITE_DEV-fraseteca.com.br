<div class="conteudo--login">
    <header>
        <h2>Qual tipo de frase você gosta?</h2>
        <span>Escolha os assuntos que você curte:</span>
    </header>

    <div class="conteudo--login--form">
        <div class="margin-auto max-width-content mb-30">
            @include('front.includes.Tags', [
                'tagposts' => $tagsMaisAcessadas,
                'classe' => 'tagsHome preferencias',
                'classeItem' => 'tag-item',
                'semTitulo' => true,
            ])
        </div>
        <form id="updatePreferencias" action="{{ CustomRoute::go(route('usuario.salvarPreferencias')) }}" method="post">
            @method('POST')
            {{ csrf_field() }}
            <input type="hidden" id="arrTags" name="arrTags" value="">
            <div class="limit"><button id="validaSubmit" type="submit"
                    class="botao-callaction pd-2030 grande btn btn-link reenviar bt-quero nok">Confirmar!</button></div>
        </form>
    </div>
    <div class="conteudo--login--registrar">
        <img src="{{asset("images/default/login-v01.svg")}}" width="242px" height="272px" alt="Quero criar uma conta!">
    </div>
</div>
<script src="{{ asset('js/LoginShow__preferencias.js') }}?ver={{ env('VER') }}"></script>
