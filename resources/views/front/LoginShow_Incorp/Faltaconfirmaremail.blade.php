@php
    $seuEmail = isset($usuariologado) ? $usuariologado->email: "";
@endphp

<div class="conteudo--login">
    <header>
        <h2>Só falta um clique...</h2> 
        <span  style="font-size: 34px; margin:20px;">👀</span>
        <div class="limit center">
            <span>
                @include('front.LoginShow_Incorp.Returnerror')
            </span>
        </div>
        <div class="limit"><p>Para continuar você só precisa clicar no link que enviamos para: <b>{{$seuEmail}}</b></p></div>
        <div class="limit"><p>Não chegou? Verifique a sua caixa de Spam ou envie o link novamente:</p></div>
        
    </header>

    <div class="conteudo--login--form">   
        <div class="return">
            
            <div class="limit center"><a  class="botao-padrao flex" href="{{CustomRoute::go(route('envia.email.cadastro')) }}" value="Reenviar o email de confirmação agora...">
            Reenviar o email de confirmação agora </a></div>    
        </div>
    </div>
</div>