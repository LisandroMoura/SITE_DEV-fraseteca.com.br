<?php
/**--------------------------------------------------------------------------------------------------------------
 * Nome: Postsitens.blade.php
 * Autor: LM
 * Objetivo: View responsável por escrever o Html das frases da biblioteca. Principal view por criar
 *           o html da caixa de frase do sistema.
 * Doc: https://docs.google.com/document/d/1VdyOnzQ2C3qXEn9GOOqJAEoVRlBVIJ3JI-zMCyxTHlg/edit
 * -------------------------------------------------------
 * UPDATES:
 * -------------------------------------------------------
 *  ● Projeto20221203 - Imagem com height 346px no cache do google
 *     >> 31-12-22 - Aplicar a mesma regra de imagens webp para páginas as páginas amp
 *     >> 31-12-22 - Aplicar a regra de sizes também
 *     >> 31-12-22 - Abrir esta regra do webp images para todas as publicações
 *     >> 31-12-22 - Limpeza de código
 *  ● Projeto2023Jan02 - Imagem com height 346px no cache do google
 *     >> 01-01-23 - comentar o testes lógicos em relação ao dispositivo $mobile
 *     >> 01-01-23 - remover o teste do dispositivo mobile via srevidor
 *  ● Projeto2023Jan04 - Imagens em AMP distorcidas
 *     >> 03-01-23 - Para páginas AMP, o height das imagens do tipo Chapadas, ou seja
 *                   aquelas que não tem altura fixa como 612, o sistema estava limitando
 *                   para 612px. Fazendo uma distorção da imagem na visualizaçao
 *  ● Projeto2023Jan06 - ● Dois é dimais:
 *     >> 13-01-23 - Remover o span de copiar frase - adaptar o script para pegar a div $frase_id.
 *  ● Projeto2023Jan10 - Melhorando o Webmaster Tools  - Tarefa: 1) Para celular ajustar problema de LCP: mais de 2,5s (dispositivos móveis)
 *     >> 26-01-23 - Remover tudo em relação a $lAtrasoAmp - não precisa atrasar imagens em páginas amp, a definição como padrão o lazy de imagens e o momentolazy
 *     >> 26-01-23 - Remover o teste se a imagem de capa existe, if (!file_exists($path))
 *     >> 26-01-23 - Remover também o teste sobre as dimensões da imagem pelo methodo padrão do php getimagesize()
 *     >> 26-01-23 - A criação do metodo getMarkdownByString() na ()Entidade Post) e a inserção do mesmo nesta view
 *     >> 26-01-23 - e novo html dos botões de salvar, imagem (download) e copiar, de acordo com o lazyload
 *     >> 31-01-23 - Trazer para AMP pages os ícones de salvar, imagem (download) e copiar
 *  ● Projeto2023Mar01 - Melhorando o CLS em Amp page
 *     >> 10-03-23 - Remoção de um width="612" na chamada da newImg include
 *     >> 10-03-23 - Ocultar a chamada da tag <amp-img> dos botões de copiar, download e salvar
 *  ● Projeto2023Apr01 - Tirar o LAzyLoad para os botões de opções do FraseBox
 *     >> 12-03-23 - Provisóriamente criar os arquivos Postsitens_tools_botoes.blade e Postsitens_tools_botoes_preiodo_de_teste.blade
 *--------------------------------------------------------------------------------------------------------------*/

if (!isset($tbFrase)) {
    $tbFrase = [];
}
$arrayfrasessalvas = [];
$contador = 0;
$contFrases=0;
$ancoras = 0;
if (count($frasessalvas)) {
    $arrayfrasessalvas = $frasessalvas->all();
}

$width = '612px';
$height = '612px';

//15-ago-22: LM SeoParam lazyOn
$seoparam = [];
if (isset($tabela->seoparam)) {
    $seoparam = explode(';', $tabela->seoparam);
}
$lazyImgInicial = false;
if (isset($seoparam[4])) {
    if ($seoparam[4] == 'true') {
        $lazyImgInicial = true;
    }
}

$lAnuncioNormal = false;
if (isset($seoparam[5])) {
    if ($seoparam[5] == '2') {
        $lAnuncioNormal = true;
    }
}

?>
<div class="conteudo--wrapepr">
    @foreach ($itens as $item)
        @php
            $contador++;
            $classLazy = false;

            if($item->tipo == '1'){
                $contFrases++;
                $fetchpriority = false;
                if ($amp){
                    $fetchpriority = true;

                    if ($contFrases > 1 )
                        $fetchpriority = false;
                }
            }

            $classLazy = true;
            $lazyImgInicial = false;

            if ($contador > 0 ) {
                $lazyImgInicial = true;
            }
            
            $capa = $item->capa; //iniciando a variável capa para cada frase da lista
            
            $alt = substr($item->frase, 0, 120);
            $item->frase_id = $item->id;
            if (!isset($item->tipo)) {
                $item->tipo = 1;
            }
            /**============================================================
             * INicio do controle de dimensões das imagens = LM - 27/jul/22
             * ============================================================*/
            //parâmetros iniciais
            $width = '612px';
            $height = '612px';
            $temWidth = false;
            $temHeight = false;
            $capa = $item->capa;
        
            if ($capa != null) {
                //Verificar Se as dimensões da imagem foram geradas pela pipiEf
                if ($item->dimensoes != '') {
                    $dataDim = explode('|', $item->dimensoes);
                    if (isset($dataDim[0])) {
                        $dimensoesDesk = explode('x', $dataDim[0]);
                        $width = '612px';
                        $temWidth = true;
                        if (isset($dimensoesDesk[1])) {
                            $height = $dimensoesDesk[1] . 'px';
                            $temHeight = true;
                        }
                    }
                } 
            }

            // Validação importante!!!!
            // em caso de páginas Amp, a imagem precisa ser uma imagem válida, ter altura e largura
            // caso alguma destas regras não forem atendidas, não imprimir a imagem no documento
            if ($amp) {
                if (!$temWidth || !$temHeight) {
                    $capa = null;
                }
                
            }
        @endphp
        {{-- Anchor Item --}}
        @if ($item->tipo == '3')
            <div class="conteudo--anchor--item  item-{{ $contador }}" id="{{ $item->aux_2 }}">
                <div class="conteudo--anchor--item--title">
                    @php $ancoras++; @endphp
                    <h2><span class="numero">{{ $ancoras }}.</span> {{ $item->aux_1 }}</h2>
                </div>
            </div>
        @endif
        {{-- Projeto20221105 - 23-11-22 LM - Campo caixa de parágrafo no item  --}}
        @if ($item->tipo == '5')
            <div class="conteudo-paragrafo margin-maior conteudo--paragrafo--item  item-{{ $contador }}"
                id="{{ $item->aux_2 }}">
                <div class="conteudo--paragrafo--item--title">
                    @php echo $tabela->getMarkdownByString($item->aux_1); @endphp
                </div>
            </div>
        @endif
        {{--
            22/06/22 - LM: 
            - Remover anucios de dentro do corpo das frases 
        --}}
        @if ($item->tipo == '2' && !$amp && $anuncios == 'true')
            @if ($options['paramGlobal'])
                {{-- 
                    16-ago-22 - LM: 
                    - Anúncios tipo Normal 
                --}}
                @if ($lAnuncioNormal)
                    <div class="anuncio">
                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6159622292805097"
                            crossorigin="anonymous"></script>
                        <ins class="adsbygoogle" style="display:inline-block;width:350px;height:350px"
                            data-ad-client="ca-pub-6159622292805097" data-ad-slot="2754897871"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                @endif
            @else
                <div class="anuncio teste no-print"></div>
            @endif
        @endif
        {{-- Invite item --}}
        @if ($item->tipo == '4' && !$logado)
            <div class="convite no-print">Você sabia que neste site você pode fazer a sua própria lista de frases,
                salvar as suas frases favoritas em sua seleção e muito mais? <br><br>Que tal aproveitar que você já está
                por aqui, clicar <a target="_blank" rel="nofollow" href="/registrar/newuser">neste link</a> e
                experimentar? (Pedimos apenas seu email, um cadastro muito mais rápido que qualquer outro site :))</div>
        @endif
        {{-- Phrase item #default --}}
        @if ($item->tipo == '1')
            @if (isset($logado))
                <a class="modal_salvar" @if (!$amp) idData="{{ $item->frase_id }}" @endif
                    title="Cancelar/ESC" id="modal_salvar_{{ $item->frase_id }}"></a>
            @endif
            <div class="frase--box">
                {{-- imagem da frase --}}
                @if ($item->mostraimg == '1')
                    @if ($capa)
                        <div class="picture">
                            <a @if ($item->status == '1') href="/frase/{{ $item->frase_id }}" @endif
                                title="{{ $alt . ' - ' . $item->alt }}">
                                @include('front.includes.Newimg', [

                                    'width' => $width,
                                    'validadeLCPAmp' => true,
                                    'contFrases' => $contFrases,
                                    'height' => $height,
                                    'imgsrc' => $item->nomeDownload,
                                    'amp'   => $amp,
                                    'validateImag' => false,
                                    'lazyLoad' => $lazyImgInicial,
                                    'fetchpriority' => $fetchpriority,
                                    'class' => $tabela->tipo == 3 ? 'institucional' : '',
                                    'alt' => $item->frase,
                                ])
                            </a>
                        </div>
                    @endif
                @endif
                {{-- frasebox --}}

                <blockquote class="frase" id="frase_{{ $item->item_id }}">{{ $item->frase }}</blockquote>
                {{-- autor --}}
                @if ($item->autor)
                    @php
                        $autorDaFrase = App\Entities\AutorItem::where([['tipo', '=', '1'], ['tipo_id', '=', $item->frase_id]])
                            ->join('autor', 'autor.id', '=', 'autor_item.autor_id')
                            ->select('autor.id', 'autor.nome', 'autor.urlamigavel')
                            ->first();
                    @endphp
                    @if ($autorDaFrase)
                        @if (!str_contains($autorDaFrase->urlamigavel, $_SERVER['REQUEST_URI']))
                            <div class="autor">
                                <a href="{{ $autorDaFrase->urlamigavel }}"
                                    title="página do Autor {{ $autorDaFrase->nome }}">{{ $item->autor }}</a>
                            </div>
                        @else
                            <div class="autor">{{ $item->autor }}</div>
                        @endif
                    @else
                        <div class="autor">{{ $item->autor }}</div>
                    @endif
                @endif
                {{-- tools botões --}}
                @if (isset($tabela))
                    @if ($tabela->id == "41")
                        @include('front.PostShow_Incorp.Postsitens_tools_botoes_preiodo_de_teste')
                    @else
                        @include('front.PostShow_Incorp.Postsitens_tools_botoes')
                    @endif    
                @else
                    @include('front.PostShow_Incorp.Postsitens_tools_botoes')

                @endif
                
            </div>
        @endif
    @endforeach
</div>
