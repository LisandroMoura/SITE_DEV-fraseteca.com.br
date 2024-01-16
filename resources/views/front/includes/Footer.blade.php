@php
        /**--------------------------------------------------------------------------------------------------------------
     * Nome: Footer.blade.php
     * Autor: LM
     * Objetivo: Footer do site.
     * Doc: Pendente
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     * ● Projeto2023Jan10 - Melhorando o Webmaster Tools  - Tarefa: 1) Para celular ajustar problema de LCP: mais de 2,5s (dispositivos móveis)
     *     >> 30-01-23 - Ajustar a tam amp-img para as imagens de mídias sociais em caso de páginas amp
     *--------------------------------------------------------------------------------------------------------------*/
@endphp
<footer class="footer max-width-content no-print pd-final">
    @php
        $lmsg = false;
        $amp = $amp ?? false;
        $tabela = $tabela ?? new stdClass();
        $hideFooterImage = $hideFooterImage ?? false;

        if (method_exists($tabela, 'getTable')) {
            if ($tabela->getTable() == 'frases' || $tabela->getTable() == 'posts') {
                $lmsg = true;
                if($tabela->getTable() == 'posts'){
                    if($tabela->tipo == '3')
                        $lmsg = false;
                }
            }
        }
    @endphp

    @if ($lmsg)
        <div class="footer--item texto-contato no-print">
            Se você encontrou algum problema com esta biblioteca por favor entre em contato <a
                href="/contato?page={{ $idpost ?? 'contato' }}">clicando aqui</a>
        </div>
    @endif
    <ul class="footer--item  menu-footer">
        <li><a href="{{ env('APP_URL') }}/ajuda">Como usar o Fraseteca \o/</a></li>
        <li><a href="{{ env('APP_URL') }}/termos">Termos de uso</a></li>
        <li><a href="{{ env('APP_URL') }}/politica">Política de privacidade</a></li>
        <li><a href="{{ env('APP_URL') }}/contato">Contato</a></li>
    </ul>

    <div class="footer--bottom">
        <div class="copyr">
            © 2022 Fraseteca. Todos os direitos reservados.
        </div>
        <div class="sorrisofinal">
                @if (!$amp)
                    <img data-src="/images/footer/carinha-rodape.svg" alt="Sorriso final" width="24px" height="24px"
                        class="lazy-hidden">
                @endif
        </div>
        <ul class="socials">
            <li>
                <a target="_blank" href="https://br.pinterest.com/fraseteca/_created/" rel="nofollow"
                    class="icone-imagens-midias img_pinterest" title="Pinterest">
                    @if (!$amp)
                        <img data-src="/images/social/pin-rodape.svg" width="46px" height="46px" alt="Pinterest Fraseteca" class="lazy-hidden_">
                    @else
                        @if (!$hideFooterImage)
                            <amp-img src="/images/social/pin-rodape.svg" width="46px" height="46px" alt="Pinterest Fraseteca" class="lazy-hidden_"></img-amp>
                        @endif
                    @endif
                </a>
            </li>
            <li>
                <a target="_blank" href="https://www.facebook.com/frasetecaapp" rel="nofollow"
                    class="icone-imagens-midias img_facebook" title="Facebook">
                    @if (!$amp)
                        <img data-src="/images/social/face-rodape.svg" width="46px" height="46px" alt="Facebook Fraseteca"  class="lazy-hidden_">
                    @else
                        @if (!$hideFooterImage)
                            <amp-img src="/images/social/face-rodape.svg" width="46px" height="46px" alt="Facebook Fraseteca"  class="lazy-hidden_"></amp-img>
                        @endif
                    @endif
                </a>
            </li>
            <li>
                <a target="_blank" href="https://www.instagram.com/fraseteca/" rel="nofollow"
                    class="icone-imagens-midias img_instagram" title="Instagram">
                    @if (!$amp)
                        <img data-src="/images/social/insta-rodape.svg" width="46px" height="46px" alt="Instagram Fraseteca" class="lazy-hidden_">
                    @else
                        @if (!$hideFooterImage)
                            <amp-img src="/images/social/insta-rodape.svg" width="46px" height="46px" alt="Instagram Fraseteca" class="lazy-hidden_"></amp-img>
                        @endif
                    @endif
                </a>
            </li>
        </ul>
    </div>
</footer>
