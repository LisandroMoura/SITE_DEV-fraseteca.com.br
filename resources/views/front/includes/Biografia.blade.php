@php
    
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Biografia.blade.php
     * Autor: LM
     * Objetivo: View responsável por escrever o Html da biografia do autor das Bibliotecas
     * Doc: https://docs.google.com/document/d/1bUiO9kFYJfJetuAqwzyP4SeXJpyeP0tUm_R0HjDAmOQ/edit#
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *  ● Projeto2023Jan01 - Imagens quebradas em LazyLoad
     *     >> 01-01-23 - inserido data-srcset na tag img
     *
     *--------------------------------------------------------------------------------------------------------------*/
    
    
    $dados = $dadosdoautor ?? null;
    $tipo = $tipo ?? 'normal';
    $conquista = 'Top Usuário';
    $icone_conquista = 'super-fan';
    $hiddeImgFromAmp = $hiddeImgFromAmp ?? false;
    if (!isset($dados)) {
        return '';
    } //04_dez
    
@endphp
<div class="biografia">
    <div class="biografia--col biografia--col--linhaUm">
        <div class="demarcador-marca no-print"></div>
    </div>
    <div class="biografia--col biografia--col--conteudo">
        <div class="biografia--col--conteudo--avatar">
            <a @if ($tipo != 'perfil') href="/{{ $dados['link-autor'] }}" @endif
                title="Perfil de {{ $dados['nome-autor'] }}">
                @if ($amp)
                    @if (!$hiddeImgFromAmp)
                        <amp-img class="lazy-hidden avatar perfil" media="(min-width: 55px)" src="{{ $dados['avatar'] }}" width="55" height="55" layout="fixed" alt="Perfil de {{ $dados['nome-autor'] }}"></amp-img>
                    @endif
                @else
                    <img class="lazy-hidden avatar perfil" src="{{ $dados['avatar'] }}"
                        data-srcset="{{ $dados['avatar'] }}" width="55" height="55"
                        alt="Perfil de {{ $dados['nome-autor'] }}">
                @endif
            </a>
        </div>
        <div class="biografia--col--conteudo--texto">
            <div class="biografia--col--conteudo--texto-label">inserido por</div>
            <div class="biografia--col--conteudo--texto-autor">
                <a itemprop="author" @if ($tipo != 'perfil') href="/{{ $dados['link-autor'] }}" @endif
                    title="Perfil de {{ $dados['nome-autor'] }}">
                    <span>{{ $dados['nome-autor'] }}</span>
                    <i class="ico ico-selo"></i>
                </a>
            </div>
        </div>

    </div>
    <div class="biografia--col biografia--col--linhaDois">
        <div class="demarcador-marca no-print"></div>
    </div>
</div>
