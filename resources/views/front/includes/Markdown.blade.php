<?php
    
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Markdown.blade.php
     * Autor: LM
     * Objetivo: Programa responsável pela geração de Markdow no front end
     * Doc: PENDENTE
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *  ● Projeto20221105 - Funções para MarkDown 
     *     >> 23-11-22 - Criação as funções
     * 
     *  ● Projeto20221105 - Funções para MarkDown 
     *     >> 01-12-22 - stava retornando um <br> mesmo sem o campo introdução
     * 
     *  ● Projeto2023Jan05 - Ajustes Erros AMP em caixas de texto
     *     >> 03-01-23 - Problema no metodo markLink() que estava gerando html fora do padrão AMP
     *
     *--------------------------------------------------------------------------------------------------------------*/

function runMarkDonw($string): string
{
    if(!$string) return "";

    $string = markdownTitulos($string);
    $string = markNegrito($string);
    $string = markItalico($string);
    $string = markLink($string);
    $string = quebraLinhas($string);
    return $string;
}

function markdownTitulos($markdown)
{
    $markup = preg_replace_callback(
        '/^(#+)(.+?)\n/',
        function ($matches) use ($markdown) {
            // bail if regex does not catches anything
            if ($matches[1] == "") {
                return trim($markdown);
            }

            // if there is no space after the markdown "#"s reject it.
            if (!preg_match('/\s/', $matches[2])) {
                return "#" . $matches[2];
            }

            $hash_count = strlen($matches[1]);
            // Bail if hash count is not in range of 1-6.
            if (! in_array($hash_count, range(1, 6), true)) {
                return trim($markdown);
            }

            return html_entity_decode("<h$hash_count>" . trim($matches[2]) . "</h$hash_count>");
        },
        // Adding "\n" to fit our regex.
        ltrim($markdown) . "\n"
    );
    // final cleanup
    return $markup;
    return trim(preg_replace('~[\r\n]+~', ' ', $markup));
}

function markNegrito($string): string
{
    return preg_replace('#(^|[^\*])\*\*([^\s\*]([^\*]+?)?[^\s\*])\*\*([^\*]|$)#', '$1<b>$2</b>$4', $string);
}

function markItalico($string): string
{
    //Itálico
    $regex = '#(?<=^|[^_])__(?![\s_])(?=[^_])((?>[^\\\\_]*)(?>(?:(?>\\\\_)|(?>(?!__)_[^_]*))[^\\\\_]*)*)(?<![\s\\\\]|(?=\\\\)_)__(?=[^_]|$)#';
    $string = preg_replace($regex, '<i>$1</i>', $string);
    $string = preg_replace('/\\\\([*_])/', '$1', $string);
    return $string;
}

function markLink($string): string
{
    $pattern = '/(\[.+?\])(\(.+?\))/';
    $string = preg_replace($pattern, '<a href="$2"  title="$1" target="_blank" >$1</a>', $string);
    $string = preg_replace('/(\()/', '', $string);
    $string = preg_replace('/(\))/', '', $string);
    $string = preg_replace('/(\[)/', '', $string);
    $string = preg_replace('/(\])/', '', $string);
    return $string;
}

function quebraLinhas($string): string
{
    // $string = str_replace(chr(13), '<br>', $string);
    $string = str_replace(chr(10), '<br>', $string);
    return $string;
}
