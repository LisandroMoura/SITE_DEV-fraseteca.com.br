@php

    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Comentarios.blade.php
     * Autor: LM
     * Objetivo: View responsável por escrever o Html de tudo que se refere a comentário no sistema.
     * Doc: https://docs.google.com/document/d/1xuuWY47G_zuFF6w6TZEtoKvxey-6tuQS9shNkDofyr8/edit#
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     * 
     * 
     *--------------------------------------------------------------------------------------------------------------*/

    $usuario_email = $logado->email ?? '';
    $usuariologado = $logado->id ?? '';
    $usuario_id = $logado->id ?? null;
    if (isset($logado)):
        if ($logado->nome_completo) {
            $usuariologado = $logado->nome_completo;
        } else {
            $usuariologado = $logado->name;
        }
    endif;
    if ($errors->any()):
        if (isset($errors->all()['autor_nome'])) {
            $usuariologado = $errors->all()['autor_nome'];
        }
        if (isset($errors->all()['autor_nome'])) {
            $usuario_email = $errors->all()['autor_email'];
        }
        if (isset($errors->all()['body'])) {
            $aguardandoModeracao = $errors->all()['body'];
        }
endif;
@endphp

@if ($amp)
        <a href="{{  data_get($seo,"canonical","/login"); }}#comentario-titulo" class="botao-padrao botao--comentarios--amp "> 
            @if (count($tabela->comments) == 0) 
                Quero comentar 
            @else  
                ({{ count($tabela->getCountComments) }}) ver comentarios... 
            @endif
        </a>
@else
    {{-- header titulo --}}
    <div class="comentarios--header" id="comentario-titulo">
        @if (count($tabela->comments) == 0)
            @if (!isset($logado))
                <div class="texto">
                    Para comentar você precisa se cadastrar. <br/> <a href="/login" title="Clique aqui para criar a sua conta" rel="no-follow"><strong> Clique aqui</strong> para criar a sua conta!</a>
                </div>
            @else
                <h2>Comentários</h2>
            @endif
        @else
            <h2><span class="numero">{{ count($tabela->getCountComments) }}</span> Comentários</h2>
        @endif
    </div>
    {{-- Formulário de comentário --}}    
    @if (isset($logado))
        <div class="preleitura"></div>
        <div class="comentarios--form">
            <form method="post" id="form_comentar" ref="comentar" action="{{ route('comments.store') }}">
                @csrf
                <textarea name="body" minlength="4" class="comentario-input w100" id="body" cols="30" rows="1" placeholder="Adicionar comentário..."></textarea>
                <input type="hidden" name="table" id="table" value="comment_{{ $tabela->getTable() }}"/>
                <input type="hidden" name="parent_id" id="parent_id" value="" />
                <input type="hidden" name="status" value="0" />
                <input type="hidden" name="usuario_id" value="{{ $usuario_id }}" />
                <input type="hidden" name="post_id" value="{{ $tabela->id }}" />
                <input type="hidden" name="frase_id" id="frase_id"  value="{{ $tabela->id }}" />    
                <input type="hidden" name="autor_ip" value="{{$_SERVER['REMOTE_ADDR']}}" />
                <input type="submit" id="validaSubmit" value="Publicar!" class="padrao-call-action-with-validator nok">
            </form>
        </div>
    @endif
    {{-- comentários da publicação --}}
    @if (isset($aguardandoModeracao))
        <div class="aguardando-moderacao">
            <div class="label-aguardando">Aguardando moderação...</div>
            <p>{{ $aguardandoModeracao }}</p>
        </div>
    @endif
    <ul class="comentarios--corpo principal">
        @include('front.includes.Comentarioitem', [
            'comments'  => $tabela->comments,
            'post_id'   => $tabela->id,
        ])
    </ul>
@endif
