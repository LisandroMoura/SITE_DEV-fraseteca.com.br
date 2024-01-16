@php
/**--------------------------------------------------------------------------------------------------------------
* Nome: Tagposts.blade.php
* Autor: LM
* Objetivo: View responsável por escrever o Html das tags das Bibliotecas, usado na view de
*           posts e na view de frases.
* Doc: https://docs.google.com/document/d/16I2Wr6Mq70FGKYTs_WQ1_N3lLupg1mElMFDbnFJ5UBo/edit#
* -------------------------------------------------------
* UPDATES:
* -------------------------------------------------------
*
*--------------------------------------------------------------------------------------------------------------*/

$tag_Dados=[];
if (isset($tagposts) && $tags != ""):
foreach ($tagposts as $key => $tag) {
$tag_Dados[$tag->descricao] = $tag->urlamigavel;
$tag_Dados[$tag->descricao] = $tag->urlamigavel;
}
endif;

if (!isset($tag_Dados) || count($tag_Dados) == 0 ) return;
@endphp
<div class="tags no-print">
    <label class="tags--col label">tags:</label>
    <ul class="tags--col list">
        @foreach ($tag_Dados as $key => $tag)
        <li><a href="/tag/{{$tag}}" class="botao-tag" title="{{$key}}">{{$key}}</a></li>
        @endforeach
    </ul>
</div>
