@php

//Projeto20221103 - Page with redirect: LM 10-09-22 - retirado a barra no final da url dos endereços de compartilhamento

$link = isset($tabela) ? env('APP_URL') . '/' . $tabela->urlamigavel : null; 
$imgSrc = isset($tabela) ? env('APP_URL') . $tabela->getImagemCapaAttribute() : asset('images/padrao.jpg');
$titulo = isset($tabela) ? $tabela->titulo : '';
$post_type = 'post'; //default

if (isset($tipo)):
    if ($tipo == 'frase') {
        $post_type = 'frase';
    }
endif;

if ($post_type == 'frase') {
    $link = isset($tabela) ? env('APP_URL') . '/frase/' . $tabela->id : '';
    $imgSrc = isset($tabela) ? env('APP_URL') . $tabela->getImagemCapaAttribute() : asset('images/padrao.jpg');
    $titulo = isset($tabela) ? $tabela->frase : '';
    $titulo = substr($titulo, 0, 70);
}
@endphp

<div class="wrapper-modal-dialog wrapper--compartilhar ">
    <header>Compartilhar<a class="botao-fechar-dialog abreCompartilhar"><i class="ico ico-fechar"></i></a></header>
    <div class="conteudo">
        <ul>
            <li><a target="_blank" rel="nofollow"
                    href="http://pinterest.com/pin/create/button/?url={{ $link }}&amp;description={{ $titulo }}&amp;media={{ urlencode($imgSrc) }}"
                    title="compartilhar Pinterest" class="icon social_ pinterest_">
                        <img data-src="/images/social/pinterest-v03.svg"  
                        data-srcset="/images/social/pinterest-v03.svg 612w" 
                        class="lazy-hidden" 
                        style="width:46px; height:46px;" 
                        alt="Compartilhe no Pinterest"> 
                </a>
            </li>

            <li><a target="_blank" rel="nofollow"
                    href="https://www.facebook.com/dialog/feed?app_id=2770240719923574&link={{ $link }}&picture={{ $imgSrc }}&name={{ $titulo }}&caption=Lista%20Frases&redirect_uri={{ $link }}&display=popup"
                    title="compartilhar Facebook" class="icon">
                    <img data-src="/images/social/facebook-v03.svg"  
                        data-srcset="/images/social/facebook-v03.svg 612w" 
                        class="lazy-hidden" 
                        width="46px" height="46px"
                        style="width:46px; height:46px;" 
                        alt="Copartilhe no Facebook">                    
                </a>
            </li>
            <li>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($link . '?utm_source=whatsapp&utm_medium=referral') }}"
                    title="compartilhar WhatsApp" class="icon ">
                    <img data-src="/images/social/whats-v02.svg"  
                        data-srcset="/images/social/whats-v02.svg 612w" 
                        class="lazy-hidden" 
                        width="46px" height="46px"
                        style="width:46px; height:46px;" 
                        alt="Compartilhe no WhatsApp">
                </a>
            </li>
            <li>
                <a target="_blank" rel="nofollow"
                    href="https://twitter.com/share?text={{ $titulo }}&amp;url={{ $link }}"
                    title="compartilhar Twitter" class="icon "> 
                    <img data-src="/images/social/twitter-v02.svg"  
                        data-srcset="/images/social/twitter-v02.svg 612w" 
                        class="lazy-hidden" 
                        width="46px" height="46px"
                        style="width:46px; height:46px;" 
                        alt="Compartilhe no Twitter">                 
                </a>
            </li>
            <li>
                <a href="mailto:seuemail@email.com?Subject=Recomendado%20&body=Confira%20o%20link:%20{{ $link }}"
                    title="compartilhar Email" class="icon">
                    <img data-src="/images/social/gmail-v02.svg"  
                        data-srcset="/images/social/gmail-v02.svg 612w" 
                        class="lazy-hidden" 
                        width="46px" height="46px"
                        style="width:46px; height:46px;" 
                        alt="Compartilhe no seu email">
                </a>
            </li>
        </ul>
        <div class="incorporar">Incorporar</div>
        <div class="copiar-link">

            <input type="text" id="urlamigavel" name="urlamigavel" value="{{ $link }}">
            <a href="#copiar" title="Copiar endereço" class="btn copiar copiarLink">Copiar</a>
        </div>
    </div>

</div>
