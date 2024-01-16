@php
    $retorno = $errors->any() ?  $errors->all()[0] : null;
@endphp
<div class="conteudo--login">
    <header>
        @if ( $errors->any())

            @if ($retorno=="sucesso" || $retorno =="1" )

                <h2>Senha Alterada</h2>
                <img src="/images/default/emo-feliz.png" alt="Smile sorria :p" width="41" height="34">
                <div class="limit center">
                    <span>
                        Cheque seu email. Enviamos informações de como gerar a sua nova senha para: <strong>"{{ session('email_invalido') ?? "" }}"</strong> 
                    </span>
                </div>

            @else 
                <h2>OPS!!!</h2>
                <img src="/images/default/emo-sem-fundo-medo.png" alt="Smile sorria :p" width="41" height="34">
                <div class="limit center">
                    <span>
                        Foram encontrados erros ao alterar senha:
                    </span>
                    <p>
                        @include('front.LoginShow_Incorp.Returnerror')
                    </p>
                </div>
            @endif
            
        @else
            <h2>Quase lá...</h2>
            <img src="/images/default/emo-feliz.png" alt="Smile sorria :p" width="41" height="34">
            <span>Cadastre uma <strong> nova senha</strong></span>
        @endif
    </header>

    
    <div class="conteudo--login--form">    
        @if ($retorno=="sucesso" || $retorno =="1" )
            <div class="limit"><h3> Cheque seu email. Enviamos informações para você de como gerar a sua nova senha.</h3></div>    
            <div class="limit"><a class="botao-padrao" href="{{ CustomRoute::go(route('login.resetar_senha'))}}">Quero enviar o email novamente.</a></div>
        @else 
            <form action="{{ CustomRoute::go(route('login.resetar_senha_update_confirm'))}}" method="post">                        
                {{ csrf_field() }}    
                @method('PUT')
                <input type="hidden" name="token" value="{{ $token ?? null}}">                        
            
                <div class="limit"><input id="email" type="hidden" name="email" class="fonte-14" value="{{ $email ?? old('email') }}"></div>
                <div class="limit"><input id="email_disable" type="email" class="w100 fonte-14 form-control login-objeto @error('email') is-invalid @enderror" name="email_disable" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus disabled></div>
                <div class="limit"><input id="password_new" type="password" class="w100 fonte-14 form-control login-objeto @error('password_new') is-invalid @enderror" name="password_new" required autocomplete="new-password" placeholder="Nova senha" v-on:keyup="keyPress($event)" v-model.lazy="password_new" ></div>
                <div class="limit"><input id="password_confirm" type="password" class="w100 fonte-14 form-control login-objeto" name="password_confirm" required autocomplete="new-password" placeholder="Repetir nova senha" v-on:keyup="keyPress($event)" v-model.lazy="password_confirm" ></div>
                <div class="limit"><input id="password" type="hidden" name="password" v-model.lazy="password" ></div>
            
                <div class="limit reenviar" :class="[situacao]">
                    <input type="submit" class="botao-callaction pd-2030 grande submit submit-login" value="Salvar nova senha">
                </div>
                
            </form>
        @endif   
        {{-- <div class="well aviso">
            <ul ref="aviso" :style="{ color: cor }">
                
            </ul>                    
        </div> --}}
        {{-- <script src="{{ asset('js/LoginShow__resetarsenha__vue.js') }}"></script>            --}}
    </div>
</div>

