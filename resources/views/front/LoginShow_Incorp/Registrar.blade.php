@php
    $retorno = $errors->any() ?  $errors->all()[0] : null;
@endphp
<div class="conteudo--login">
    <header>

        @if ( $errors->any())
            @if ($retorno=="sucesso" || $retorno =="1" )
                <h2>Tudo certo!</h2>
                <img src="/images/default/emo-feliz.png" alt="Smile sorria :p" width="41" height="34">
                <div class="limit center">
                    <span>
                        @include('front.LoginShow_Incorp.Returnerror')
                    </span>
                </div>
            @else
                <h2>Ops!</h2>
                <img src="/images/default/emo-sem-fundo-medo.png" alt="Smile sorria :p" width="41" height="34">
                <div class="limit center">
                    <span>
                        @include('front.LoginShow_Incorp.Returnerror')
                    </span>
                </div>
                
            @endif
        @else 
            <h2>Crie a sua conta</h2>
            <span class="boas-vindas">Bem vind@ a bordo do Fraseteca :)</span>
        @endif
        
    </header>

    <div class="conteudo--login--form">                
        <form action="{{ CustomRoute::go(route('usuario.criar'))}}" id="form_criar" method="post">                        
            {{ csrf_field() }}    
            <div class="limit">@include('front.includes.formulario.Input', ['input' => 'name','value'  => old('name') ? old('name') : "",'class' => 'w100 login-objeto fonte-14','placeholder' => 'Nome de usuário','validator'=> true,'msgValidator'  => isset($msgValidatorArr['name']) ? $msgValidatorArr['name'] : null,])</div>
            <div class="limit">@include('front.includes.formulario.Input',  ['input' => 'email','value'=> old('email') ? old('email') : "",'placeholder' => 'Seu Email','class' => 'w100 login-objeto fonte-14','old'=> old('email'),'validator'=> true,'msgValidator'  => isset($msgValidatorArr['email']) ? $msgValidatorArr['email'] : null,])</div>
            <div class="limit">@include('front.includes.formulario.Password',['input' => 'password','value' => old('password') ? old('password') : "",'class' => 'w100 login-objeto fonte-14','placeholder' => 'Senha (mínimo 6 caracteres)','validator'=> true,'msgValidator'  => isset($msgValidatorArr['password']) ? $msgValidatorArr['password'] : null])</div>
            <div class="limit flex pd-15">@include('front.includes.formulario.Checkbox',  ['input' => 'receber_news','value'=> old('receber_news') ? old('receber_news') : "",'class' => 'circular login-objeto w100 aceito','placeholder' => 'Receber News','label' => 'aceito receber novidades do Fraseteca','value' => '1','checked' => 'true',])</div>
        
            <div class="well aviso">
                <span>Ao clicar em criar conta, você está de acordo com os <a href="/termos"> <strong> termos de serviço</strong></a> do Fraseteca.</span>
            </div>
            <input type="hidden" name="token_reverso" value="{{$token_reverso}}">
            <div class="limit"><input type="submit" class="botao-callaction pd-2030 grande submit submit-login" value="Criar!"></div>
        </form>

    </div>
    <div class="conteudo--login--registrar">
        <img src="{{asset("images/default/login-v01.svg")}}" width="242px" height="272px" alt="Quero criar uma conta!">
    </div>
</div>