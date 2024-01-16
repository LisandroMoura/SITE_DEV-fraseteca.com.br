@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Institucional.blade.php
     * Autor: LM
     * Objetivo: VView responsável por escrever o Html das páginas institucionais no sistema.
     * Doc: https://docs.google.com/document/d/1KSt08koIjCSEidCr-2Q-9MFQUQuxOUDLPMYUxdYTc-4/edit
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *● Fraseteca2023Set03 - problemas na no uso da distribuição
     *   date: 26-set-2023   
     *   ajuste do endereço da validação do  formulario de contato
     *
     *--------------------------------------------------------------------------------------------------------------*/
    
    function putFormContato($str)
    {
        $formAssunto = '<div class="form-field field-assunto"><select name="assunto" id="assunto" placeholder="assunto">
            <option value="notselected" selected >Escolha o Assunto...</option>
            <option value="Dúvida">Dúvida</option>
            <option value="Sugestão">Sugestão</option>
            <option value="Erro">Erro</option>
            <option value="Direito autoral">Direito Autoral</option>
            <option value="Anunciante">Anunciante</option>
        </select></div>';
    
        $forSuaMensagem = '<div class="form-field"><textarea name="sua_mensagem" id="sua_mensagem" cols="30" rows="3" placeholder="Sua mensagem"></textarea></div>';
    
        $form =
            '<div class="form-wapper">
                    <div class="form-field first"><input type="text" name="nome" placeholder="Seu Nome"/></div>
                    <div class="form-field"><input type="email" name="email" placeholder="Seu E-mail"/></div>' .
            $formAssunto .
            $forSuaMensagem .
            '
                    <button type="button" id="bt-g-recaptcha-submit" class="g-recaptcha botao-callaction grande" data-action="submit">Enviar</button></div>';
    
        $str = str_replace('[form-contato]', $form, $str);
        $str = str_replace('[br]', '<br class="mostrar">', $str);
        return $str;
    }
    $classAmp = $amp == true ? 'amp-ativo' : '';
@endphp

<div class="corpo-institucional page-break {{ $classAmp }} {{ $tabela->urlamigavel }}">

    @if ($tabela->urlamigavel == 'contato')
        <div class="form">
            {{-- Fraseteca2023Set03 --}}
            @if (env("APP_ENV")=="local")
                <form id="form01Contato" class="form-contato" action="http://fraseteca.dev.io/conato/validate" method="POST">
            @else
                <form id="form01Contato" class="form-contato" action="https://fraseteca.com.br/conato/validate" method="POST">
            @endif
                {{ csrf_field() }}
                @method('post')
                <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                <input type="hidden" name="action" value="validate_captcha">
    @endif
    @php
        $auxCorpo = $tabela->corpo;
        $hasFormcontato = explode('[form-contato]', $tabela->corpo);
        if (count($hasFormcontato) > 1) {
            $auxCorpo = putFormContato($auxCorpo);
        }
        echo nl2br($auxCorpo);
        
    @endphp

    @if ($tabela->urlamigavel == 'contato')
        </form>

</div>
@endif
</div>
