<?php
namespace App\Services;
class PluguinTeste
{    
    /**
     * Projeto20221110 - Problema com as imagens webp
     *  - Casos da página 1 do wsc - sera testado no corpo da página
     *    testar se o erro é em relação ao link do Facebook
     * @param String $id
     * @return boolean
     */
    static function problemaWebpCase1(String $id):bool
    {
        $result = false;
        switch ($id) {
            case '7879':
                $result = true;
                break;
            case '7916':
                $result = true;
                break;
            case '1676':
                $result = true;
                break;
            case '20273':
                $result = true;
                break;
            case '7509':
                $result = true;
                break;
            case '3476':
                $result = true;
                break;
            case '8281':
                $result = true;
                break;
            case '15224':
                $result = true;
                break;
            case '10792':
                $result = true;
                break;
            case '7137':
                $result = true;
                break;
        }
        return $result;
    }

    /**
     * Projeto20221110 - Problema com as imagens webp
     *  - Casos da página 2 do wsc - será testad ono HEAD
     *  - testar se o erro é em relação a metatag do Pinterest
     * @param String $id
     * @return boolean
     */
    static function problemaWebpCase2(String $id):bool
    {
        $result = false;
        switch ($id) {
            case '2926':
                $result = true;
                break;
            case '15075':
                $result = true;
                break;
            case '11208':
                $result = true;
                break;
            case '8556':
                $result = true;
                break;
            case '7335':
                $result = true;
                break;
            case '683':
                $result = true;
                break;
            case '12167':
                $result = true;
                break;
            case '15073':
                $result = true;
                break;
            case '4648':
                $result = true;
                break;
            case '13065':
                $result = true;
                break;
        }
        return $result;
    }

    /**
     * Projeto20221110 - Problema com as imagens webp
     *  - Casos da página 3 do wsc - será testad ono HEAD
     *  - testar se o erro é em relação aos dados estruturados     *
     * @param String $id
     * @return boolean
     */
    static function problemaWebpCase3(String $id):bool
    {
        $result = false;
        switch ($id) {
            case '7518':
                $result = true;
                break;
            case '610':
                $result = true;
                break;
            case '14931':
                $result = true;
                break;
            case '3190':
                $result = true;
                break;
            case '21138':
                $result = true;
                break;
            case '14547':
                $result = true;
                break;
            case '7384':
                $result = true;
                break;
            case '11838':
                $result = true;
                break;
            case '10997':
                $result = true;
                break;
            case '14958':
                $result = true;
                break;
        }
        return $result;
    }

    /**
     * Projeto20221110 - Problema com as imagens webp
     *  - Casos da página 4 do wsc- sera testado no corpo da página
     *  - testar se o erro está na composição do Link com a Imagem webp
     * @param String $id
     * @return boolean
     */
    static function problemaWebpCase4(String $id):bool
    {
        $result = false;
        switch ($id) {
            case '12633':
                $result = true;
                break;
            case '15294':
                $result = true;
                break;
            case '10355':
                $result = true;
                break;
            case '3996':
                $result = true;
                break;
            case '3605':
                $result = true;
                break;
            case '12476':
                $result = true;
                break;
            case '20518':
                $result = true;
                break;
            case '4604':
                $result = true;
                break;
            case '6826':
                $result = true;
                break;
            case '7662':
                $result = true;
                break;
        }
        return $result;
    }   

    /**
     * Projeto20221201 - Nova Tag de imagem dentro do sistema.
     *  - Testar se a página é a FraseDeDeus (id = 41)
     * @param String $id
     * @return boolean
     */
    static function Projeto20221201(String $id):bool
    {
        // $result = false;
        // switch ($id) {
        //     case '41':
        //         $result = true;
        //         break;
        //     case '21491': //frase
        //         $result = true;
        //         break;
        //     case '38':
        //         $result = true;
        //         break;
        //     case '130':
        //         $result = true;
        //         break;
        //     // case '3605':
        //     //     $result = true;
        //     //     break;
        //     // case '12476':
        //     //     $result = true;
        //     //     break;
        //     // case '20518':
        //     //     $result = true;
        //     //     break;
        //     // case '4604':
        //     //     $result = true;
        //     //     break;
        //     // case '6826':
        //     //     $result = true;
        //     //     break;
        //     // case '7662':
        //     //     $result = true;
        //     //     break;
        // }
        // Projeto20221201 = 15-12, Abertura para todas as listas e frases
        return true;
    }

    /**
     * Projeto20221203 - Pesquisa sobre content-type: image/webp 21-dez-22.
     *  - Testar se a página é a FraseDeDeus (id = 41) ou da Frida Kahlo
     * @param String $id
     * @return boolean
     */
    static function Projeto20221203(String $id):bool
    {
        $result = false;
        switch ($id) {
            case '41':
                $result = true;
                break;
            case '66': //coraCoralina
                $result = true;
                break;
            case '101': //frase
                $result = true;
                break;
        }
        return $result;
    }
}
