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
                <img src="/images/default/emo-cry.png" alt="Smile sorria :p" width="41" height="34">
                <div class="limit center">
                    <span>
                        @include('front.LoginShow_Incorp.Returnerror')
                    </span>
                </div>
                
            @endif
        @else 
            <h2>Faça seu Login</h2>
            <span class="boas-vindas">Bem vind@ a bordo do Fraseteca :)</span>
        @endif
    </header>
    <div class="conteudo--login--form">                
        <form action="https://fraseteca.com.br/login" method="post">                          
            {{ csrf_field() }}    
            @php                                
                if ($usuariologado){
                    $name=$usuariologado->name;
                }                            
                $token_reverso="newuser";
                if (isset($_GET['token_reverso']))
                    $token_reverso=$_GET['token_reverso'];

            @endphp 
            <div class="limit"><input ref="ref_name" type="text" id="name" class="field-login login-objeto w100 fonte-14" value="{{$name?? ''}}" name="name" placeholder="Seu Email"></div>                            
            <div class="limit"><input type="password" id="password" class="field-login login-objeto senha w100 fonte-14" name="password" placeholder="Sua Senha"></div>                            
            <div class="limit flex">    
                @include(
                    'front.includes.formulario.Checkbox',    
                    ['input' => 'continuaConectado',
                    'ref'           => 'continuaConectado', 
                    'label' => 'Continue conectado', 
                    'value' => '1', 
                    'checked' => 'true' 
                    ])
                <a class="esqueceu" href="{{ CustomRoute::go(route('login.resetar_senha'))}}">Esqueceu a senha?</a>    
            </div>
            <input type="hidden" name="token_reverso" value="{{$token_reverso}}">
            <div class="limit"><input type="submit" class="botao-callaction pd-2030 grande submit submit-login" value="Entrar"></div>
        </form>
    </div>
    <div class="conteudo--login--registrar">
        <a  class="botao-padrao no-border" href="{{CustomRoute::go(route("registrar", $token_reverso))}}">Quero criar uma conta!</a>                   
        <img src="{{asset("images/default/login-v01.svg")}}" width="242px" height="272px" alt="Quero criar uma conta!">
    </div>
</div>