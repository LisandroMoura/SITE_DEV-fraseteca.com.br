@extends('template.Email')

@section('css-view')
@endsection

@section('conteudo-menu')    
@endsection

@section('conteudo-view')    

@php
    //cores
$cor_da_foto		="#ffffff";
$cor_predominante	="#ffffff";
$cor_bg				="#f9f8f8";
$cor_dark			="#555454";
$cor_font			="#242424";
$cor_btn			="#9abb3c";
$link="";
$url="";
@endphp

<table align="center" border="0" 
        cellpadding="0" 
        cellspacing="0" 
        height="100%" 
        width="100%"  
        style="margin:0 auto;max-width: 600px;"
        >
        <tbody>  
            
            <tr>
                <td align="center" valign="top">
                    <table class="master-table" 
                     cellpadding="0" 
                    cellspacing="0" style="margin:0 auto;"
                    bgcolor="<?php echo $cor_bg;?>"
                    >
                        <tbody>	                            
                            <tr height="84" style="bacground:<?php echo $cor_predominante;?>" bgcolor="<?php echo $cor_predominante;?>" >
                                <td 
                                    height="84" 
                                    style="height:84px; padding:0;" align="bottom">										
                                    
                                    <table 
                                        class="responsive-table" 
                                        border="0" 
                                        cellpadding="0" 
                                        cellspacing="20" 
                                        valign="middle" 
                                        style="text-align:center;">
                                        <tr>

                                            <tr height="15"><td>&nbsp;</td></tr>

                                            <td style="text-align:center;">
                                                <a href="<?php echo $link;?>" 
                                                    title="Fraseteca" 
                                                    style="text-align:center;width: 100%;display: block;text-align: center;">
                                                    <img
                                                    src="{{env('APP_URL')}}/images/logo-v03.png"
                                                    width="109px" 
                                                    height="28px" border="0" 
                                                    alt="fraseteca" style="border:0;  display: block; margin: 0 auto; ">                                                </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="text-align:center;">
                                                <h1 style="margin: 20px 0 10px 0;">
                                                    Bora alterar sua senha?</h1>                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;">
                                                <p style="font-size: 18px; font-family: 'Open Sans', Arial, sans-serif; font-weight: 400;">
                                                Olá <strong>{{ $usuario->nome_completo ?? $usuario->name }}</strong>, tudo bem?
                                                    Recebemos um pedido para alterar sua senha no Fraseteca. Para alterar a senha clique neste link:
                                                </p>
                                            </td>
                                        </tr>     
											
                                        <tr><td align="center" valign="top">
                                            <table border="0" cellspacing="0" cellpadding="0">
                                            <tbody><tr><td align="center" valign="top"> 
                                                
                                                @if ($usuario)
                                                    @php
                                                        $email   = $usuario->email;
                                                        $token   = $token_gerado;
                                                        $url_app = env('APP_URL');
                                                    @endphp
                                                    {{-- <a href="{{$url_app}}login/resetar_senha_update/email={{$email}}&token={{$token}}" class="button btn btn-primary btn-lg">clique aqui para cadastrar sua nova senha</a> --}}
                                                    <a 
                                                        class="button btn btn-primary btn-lg"
                                                        style="background-color: #20ad83; padding: 38px; -webkit-border-radius: 3px; border-radius: 3px; font-size: 28px; font-family: 'Open Sans', Arial, sans-serif; font-weight: 400; color: #ffffff; text-decoration: none; display: inline-block; -webkit-text-size-adjust:none;mso-hide:all;" data-hs-link-id="1"
                                                        href="{{ CustomRoute::go(route('login.resetar_senha_update',
                                                        [
                                                        'email' => $email,
                                                        'token' => $token
                                                        ]
                                                        ))}}">
                                                        <strong>alterar minha senha</strong>
                                                        </a>
                                                    

                                                @endif

                                            </td></tr>
                                            </tbody></table>
                                            </td>
                                        </tr>											
                                        
                                        
                                        <tr>
                                            <td style="text-align:center;">
                                                <table border="0" cellspacing="0" cellpadding="0">
                                                    <tbody><tr><td align="center" valign="top">                                                
                                                        <p style="font-size: 18px; font-family: 'Open Sans', Arial, sans-serif; font-weight: 400;">
                                                            Se você não solicitou sua troca de senha, basta apagar
                                                            este e-mail e tudo vai continuar do jeito que é ;)
                                                        </p>        
                                                    </td></tr>
                                                    </tbody></table>
                                                
                                            </td>                                            
                                        </tr>            

                                        <tr height="45px" class="last-tr-height"><td>&nbsp;</td></tr>
                                        
                                    </table>
                                </td>
                            </tr>
                            {{-- texto do header --}}

                            
                        <?php /**F IM DO CORPO **/ ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    
@endsection
@section('js-view')


@endsection