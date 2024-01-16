<?php
/**--------------------------------------------------------------------------------------------------------------
 * Nome: Postsitens_tools_botoes.blade.php
 * Autor: LM
 * Objetivo: View include responsável por escrever o Html dos botões de opções da caixa FraseBox
 * Doc: --
 * -------------------------------------------------------
 * UPDATES:
 * -------------------------------------------------------
 *  ● Projeto2023Apr01 - Tirar o LAzyLoad para os botões de opções do FraseBox
 *     >> 12-03-23 - Criar a include e inserir nos itens
 *     >> 12-03-23 - Inicialmente apenas inserir para as publicações 
 *           - (id:41 = 83 Frases de DEUS para Status) - implelemtado no arquivo Postsitens_tools_botoes_preiodo_de_teste.blade.php
 *     >> 12-03-23 - Refatorado o código, tirando a parte de validações AMP 
 *--------------------------------------------------------------------------------------------------------------*/
?>
<div class="tools no-print">
    <ul>
        <li>
            @if (isset($logado))
                @php $jacurtida = false; foreach ($arrayfrasessalvas as $key => $frasesFav) {if ($frasesFav->frase_id == $item->frase_id) {$jacurtida = true;}} @endphp
                @if ($jacurtida)
                    <a title="Já está em suas frases favoritas!" 
                        class="padrao-icone favoritas jacurtida">
                        <span data-src="/images/icones/24x24/seguir-on-v01.svg" class="ico lazy-background autoload lazy-seguir seguindo no-interact"></span>
                        <span class="label">Salvo!</span>
                    </a>
                @else
                    <a href="/login" rel="nofollow" idData="{{ $item->frase_id }}" data="go" title="Adicionar a suas Frases Favoritas." 
                        class="padrao-icone favoritas fraseFavorita favorita-id-{{ $item->frase_id }}" >
                        <span data-src="/images/icones/24x24/seguir-v01.svg" class="ico lazy-background autoload lazy-seguir"></span>
                        <span class="label no-interact">Salvar</span>
                    </a>
                @endif
            @else
                <a href="/login" data="go" rel="nofollow" title="Que tal salvar esta frase em suas Frases Favoritas?" 
                    class="padrao-icone callLogin_ item-tools favoritas icon favorita-id-{{ $item->frase_id }} mg0">
                    <span data-src="/images/icones/24x24/seguir-v01.svg" class="ico lazy-background autoload lazy-seguir no-interact"></span>
                    <span class="label no-interact">Salvar</span>
                </a>
            @endif
        </li>
        @if ($item->status == '1')
            <li>
                <a href="/frase/{{ $item->frase_id }}" title="{{ 'Ver a Frase: ' . $alt . ' - ' . $item->alt }}" class="padrao-icone icon icon imagem item-tools" >
                    <span data-src="/images/icones/24x24/imagem-v01.svg" class="ico lazy-background autoload lazy-imagem"></span>
                    <span class="label">Download</span>
                </a>
            </li>
        @else
            <li>
                <a title="{{ 'Frase: ' . $alt . ' - ' . $item->alt }}" class="padrao-icone icon icon imagem item-tools jacurtida">
                    <span data-src="/images/icones/24x24/imagem-v01.svg" class="ico lazy-background autoload lazy-imagem"></span>
                    <span class="label">Download</span>
                </a>
            </li>
        @endif
        <li>
            <a href="#" title="Copiar" idData="{{ $item->item_id }}" class="padrao-icone item-tools copiar icon icone copiarFraseFavorita" >
                <span data-src="/images/icones/24x24/copiar-v01.svg"  class="ico lazy-background autoload lazy-copiar no-interact"></span>
                <span class="label no-interact">Copiar</span>
            </a>
        </li>
    </ul>
</div>
@if (isset($logado))
    <div class="tool tool-salvar" id="salvar_{{ $item->frase_id }}"></div>
@endif
