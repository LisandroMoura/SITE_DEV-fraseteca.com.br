<?php

namespace App\Services;

/**
 * Classe para retornar todos os parâmetros usados no SEOPAGE
 * @package namespace App\Services;
 * @author  LM
 * @link    
 * @version 1.0.0 - Fev-2022
 * 
 *   ● Projeto2023Fev01 - Problema de LCP: mais de 2,5s (dispositivos móveis) - Dia 18/02
 *    >> 20-02-23 - No methodo get, buscar a imagem de download da tabela frase (quando tiver)
 *                  impedindo o carregamento desnecessário da imagem de capa
 * 
 */

class Seo
{
    public function get($tabela, $param)
    {
        $robot          = 'INDEX, FOLLOW';
        $resumo         = "Fraseteca, a sua biblioteca de frases!";
        $width          = '612';
        $height         = '612';
        $titulo         = "Fraseteca, a sua biblioteca de frases!";
        $canonical      = env('APP_URL');
        /**
         * ● Bugs fraseteca 22/jun/22 LM
         * Referenced AMP URL is not an AMP
         * Algumas páginas estavam retornando como página AMP a home do site
         */
        $ampCanonical   = null;
        $image          = asset("img/padrao.jpg");
        switch ($param) {
            case 'perfil':
                $titulo      = "Perfil: " . $tabela->nome_completo;
                $canonical   = env('APP_URL') . "/" . $param . "/" . $tabela->name . "." . $tabela->id;
                $ampCanonical = "";
                $resumo      = "Perfil do usuário $tabela->nome_completo do site Fraseteca. " . $tabela->informacoes_biograficas;
                $image       = asset("img/padrao.jpg");
                $robot       = 'noindex, follow';
                break;
            case 'tag':
                $titulo      = $tabela->descricao;
                $canonical   = env('APP_URL') . "/" . $param . "/" . $tabela->urlamigavel;
                $ampCanonical = env('APP_URL') . "/" . $param . "/amp/" . $tabela->urlamigavel;
                $resumo      = "Tag: "  . $tabela->descricao;
                $image       = asset("img/padrao.jpg");
                break;
            case 'sessao':
                $titulo       = $tabela->descricao;
                $canonical    = env('APP_URL') . "/" . $param . "/" . $tabela->urlamigavel;
                $ampCanonical = env('APP_URL') . "/" . $param . "/amp/" . $tabela->urlamigavel;
                $resumo       = "Categoria / sessão: "  . $tabela->descricao;
                $image        = asset("img/padrao.jpg");
                break;
            case 'post':
                $titulo         = $tabela->titulo;
                $canonical      = env('APP_URL') . "/" . $tabela->urlamigavel;
                $ampCanonical   = null;
                if ($tabela->tipo == 1)
                    $ampCanonical   = env('APP_URL') . "/amp/" . $tabela->urlamigavel;
                $resumo         = $tabela->resumo;
                $image = asset($tabela->capa);
                if ($titulo == "Como podemos Ajudar?") $titulo = "Central de Ajuda";
                if ($titulo == "Termos de uso do Fraseteca") $titulo = "Termos de Uso";
                if ($titulo == "Entre em contato!") $titulo = "Entre em Contato";
                if ($titulo == "Política de Privacidade do Fraseteca") $titulo = "Política de Privacidade";

                break;
            case 'frase':
                $titulo        = mb_substr($tabela->frase, 0, 70,'UTF-8');
                $canonical     = env('APP_URL') . "/frase/" . $tabela->id;
                $ampCanonical  = env('APP_URL') . "/amp/frase/" . $tabela->id;
                $resumo        = "Frase: " . $tabela->frase;
                $image         = asset($tabela->nomeDownload ?? $tabela->capa);
                $width         = '612';
                $height        = '612';
                if ($tabela->status != "1") $robot  = 'noindex,noarchive,nofollow';
                break;
            case 'todas-as-listas':
                $titulo         = "Todas as Listas de Frases";
                $canonical      = env('APP_URL') . "/page/todas-as-listas/";
                $ampCanonical   = env('APP_URL') . "/page/amp/todas-as-listas/";
                $resumo         = "Toadas as listas do site Fraseteca";
                $image          = asset("img/padrao.jpg");
                break;
            case 'todas-as-tags':
                $titulo         = "Todas as Tags";
                $canonical      = env('APP_URL') . "/page/todas-as-tags/";
                $ampCanonical   = env('APP_URL') . "/page/amp/todas-as-tags/";
                $resumo         = "Toadas as Tags do site Fraseteca";
                $image          = asset("img/padrao.jpg");
                break;
            case 'toplistas':
                $titulo         = "Top Listas do site Fraseteca";
                $canonical      = env('APP_URL') . "/pages/top-listas/";
                $ampCanonical   = env('APP_URL') . "/pages/amp/top-listas/";
                $resumo         = "Top Listas do site Fraseteca";
                $image          = asset("img/padrao.jpg");
                break;
            case 'homepage':
                $titulo         = "Fraseteca, a sua biblioteca de frases!";
                $canonical      = env('APP_URL');
                $ampCanonical   = null;
                $resumo         = "Top Listas do site Fraseteca";
                $image          = asset("img/padrao.jpg");
                break;
            case 'autor':
                $strPage = "";
                if (isset($_GET['page']))
                    $strPage = " - página " . $_GET['page'];
                if ($tabela->titulo)
                    $titulo      = $tabela->titulo . $strPage;
                else
                    $titulo      = "Autor: " . $tabela->nome . $strPage;
                $canonical   = $tabela->urlamigavel;
                $aux = str_replace(env('APP_URL') . "/", "", $tabela->urlamigavel);
                if (str_contains($tabela->urlamigavel, env('APP_URL'))) {
                    $ampCanonical = env('APP_URL') . "/amp/" . $aux;
                } else {
                    echo "ops";
                    $ampCanonical = env('APP_URL') . "/amp/" . $tabela->urlamigavel;
                }
                $resumo      = "autor: "  . $tabela->descricao . $strPage;
                $image       = asset("img/padrao.jpg");
                if ($tabela->index_search != "1")
                    $robot = 'noindex, follow';
                break;
        }
        $seo = [];
        $seo['titulo']          = $titulo;
        $seo['page']            = $param;
        $seo['resumo']          = $resumo;
        $seo['canonical']       = $canonical;
        $seo['canonical_amp']   = $ampCanonical;
        $seo['published_time']  = $tabela ? $tabela->updated_at : "";
        $seo['modified_time']   = $tabela ? $tabela->created_at : "";
        $seo['image']           = $image;
        $seo['image_width']     = $width;
        $seo['image_height']    = $height;
        $seo['robots']          = $robot;
        return $seo;
    }
}
