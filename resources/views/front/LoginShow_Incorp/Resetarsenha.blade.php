@php
    $retorno = $errors->any() ?  $errors->all()[0] : null;
@endphp
<div class="conteudo--login">
    <header>
        @if ( $errors->any())

            @if ($retorno=="sucesso" || $retorno =="1" )

                <h2>E-mail enviado</h2>
                <span style="font-size: 34px; margin:20px;">🤜 🤛</span>
                <div class="limit center">
                    <span>
                        
                        Enviamos o link para gerar a sua nova senha para: <strong>"{{ session('email_invalido') ?? "" }}"</strong> <br/> Obs.: Verifique se o e-mail está na caixa de Spam ;)
                    </span>
                </div>

            @else 
                <h2>E-mail inválido</h2>
                <img src="/images/default/emo-sem-fundo-medo.png" alt="Smile sorria :p" width="41" height="34">
                <div class="limit center">
                    <span>
                        Vish, o e-mail <strong>"{{ session('email_invalido') ?? "" }}"</strong> é inválido. Preencha um endereço válido que vai dar certo.
                    </span>
                </div>
            @endif

        @else
            <h2>Redefinir a sua senha</h2>
            
            <div class="limit center">
                <span>
                    Esqueceu sua senha? </span>
            </div>
            <div class="limit center mt-20 mb-20">
                <p>
                    <strong> Tá tudo bem!  </strong>
                    <span style="font-size: 34px; margin:20px;">🙌</span>
                </p>
            </div>
            <div class="limit center">
                <span>Você só precisa informar seu e-mail e te
                    enviaremos o link para cadastrar uma nova senha.</span>
            </div>
        @endif
    </header>

    
    <div class="conteudo--login--form">    
        @if ($retorno=="sucesso" || $retorno =="1" )
            <div class="return">
                    <div class="limit center">
                        <a class="botao-padrao flex margin-auto" href="{{ CustomRoute::go(route('login.resetar_senha'))}}">Quero enviar o email novamente.</a></div>
            </div>

        @else 
            <form action="{{ CustomRoute::go(route('login.resetar_senha'))}}" method="post">                        
                {{ csrf_field() }}    
                <div class="limit">
                    <input type="text" id="email" class="field-login login-objeto w100 fonte-14" name="email" placeholder="Seu E-mail">
                </div>
                <div class="row reenviar limit " :class="[situacao]">
                    <input type="submit" class="botao-callaction pd-2030 grande submit submit-login" value="Enviar instruções para resetar senha">
                </div>
            </form>
        @endif             
    </div>
</div>

