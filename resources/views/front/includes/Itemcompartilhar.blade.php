<div class="items-para-compartilhar">
    <ul>
        <li><a target="_blank" rel="nofollow"
                href="http://pinterest.com/pin/create/button/?url={{ $link }}%2F&amp;description={{ $titulo }}&amp;media={{ urlencode($imgSrcShared) }}"
                title="compartilhar Pinterest" class="icon social pinterest">
                <img alt="{{ $titulo }}" height="60" width="60" src="/images/pinterest.svg" />
            </a>
        </li>
        <li><a target="_blank" rel="nofollow"
                href="https://www.facebook.com/dialog/feed?app_id=2770240719923574&link={{ $link }}&picture={{ $imgSrcShared }}&name={{ $titulo }}&caption=Lista%20Frases&redirect_uri={{ $link }}/&display=popup"
                title="compartilhar Facebook" class="icon social facebook">
                <img alt="{{ $titulo }}" height="60" width="60" src="/images/facebook.svg" />
            </a>
        </li>
        <li>
            <a target="_blank" rel="nofollow"
                href="https://twitter.com/share?text={{ $titulo }}&amp;url={{ $link }}%2F"
                title="compartilhar Twitter" class="icon social twitter">
                <img alt="{{ $titulo }}" height="60" width="60" src="/images/twitter.svg" />
            </a>
        </li>
        <li>
            <a href="mailto:seuemail@email.com?Subject=Recomendado%20&body=Confira%20o%20link:%20{{ $link }}"
                title="compartilhar Email" class="icon social email">
                <img alt="{{ $titulo }}" height="60" width="60" src="/images/email.svg" />
            </a>
        </li>
        <li>
            <a href="https://api.whatsapp.com/send?text={{ urlencode($link . '/?utm_source=whatsapp&utm_medium=referral') }}"
                title="compartilhar WhatsApp" class="icon social whatsapp">
                <img alt="{{ $titulo }}" height="60" width="60" src="/images/whatsapp-logo.png" />
            </a>
        </li>
    </ul>
</div>
<div class="copiar-link">
    <input type="text" id="urlamigavel" name="urlamigavel" ref="ref_urlamigavel" value="{{ $link }}">
    <a v-on:click.stop.prevent="copiarLink" href="#copiar" title="Copiar endereço"
        class="btn copiar copiarLink">COPIAR</a>
</div>
