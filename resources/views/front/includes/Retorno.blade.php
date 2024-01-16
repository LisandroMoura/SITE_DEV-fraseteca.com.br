@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Retorno.blade.php
     * Autor: LM
     * Objetivo:  trata as mensagens das operações realizadas pelo usuário.
     * Doc: https://docs.google.com/document/d/1mfQOrtOrQ8wk6hDzcvntWgrcOnFoCLpAzmD-0t7FOWU/edit
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *
     *--------------------------------------------------------------------------------------------------------------*/
@endphp

@if ($errors->any())
    @php
        
        if (count($errors->all())) {
            $descricao = '';
            $contLines = 0;
            foreach ($errors->all() as $error) {
                $contLines++;
                if ($error != '1' && $error != 'Sucesso' && $error != 'sucesso' && $error != 'Sucess' && $error != 'sucess' && $error != '0' && $error != 'Erro' && $error != 'Erro:' && $error != 'Vish!' && $error != 'Vish!!!'):
                    $error = str_replace('||email||', '', $error);
                    $error = str_replace('||name||', '', $error);
                    $error = str_replace('||url||', '', $error);
                    $error = str_replace('||nome_completo||', '', $error);
                    $error = str_replace('||informacoes_biograficas||', '', $error);
        
                    if ($contLines == count($errors->all())) {
                        $descricao .= $error;
                    } else {
                        $descricao .= $error . ' - ';
                    }
                endif;
            }
        }
    @endphp
    @if ($errors->first() == 'sucesso' || $errors->first() == '1')
        <div id="mensagem" class="sucesso">
            <div class='corpo-da-mensagem sucesso'>
                <span class="corpo-da-mensagem--texto">{{ $descricao ?? '' }}</span>
                <a title='Fechar esta opção.' id="fechar-sucesso" class='bt-fechar-msg'>
                    <i class='ico ico ico-close sucesso'></i>
                </a>
                <div id="progress-bar"></div>
            </div>
        </div>
    @else
        <div id="mensagem" class="error">
            <div class='corpo-da-mensagem error'>
                <span class="corpo-da-mensagem--texto">{{ $descricao ?? '' }}</span>
                <a title='Fechar esta opção.' id="fechar-error" class='bt-fechar-msg'>
                    <i class='ico ico-close error'></i>
                </a>
                <div id="progress-bar"></div>
            </div>
        </div>
    @endif
@endif
