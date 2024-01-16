<?php

/**--------------------------------------------------------------------------------------------------------------
 * Nome: ShowFrontFrase.php
 * Autor: LM
 * Objetivo: Controller da single de frases
 * Doc: 
 * -------------------------------------------------------
 * UPDATES:
 * -------------------------------------------------------
 * ● Projeto2023Jan10 - Melhorando o Webmaster Tools  - Tarefa: 3) Ajustes de LCP nas "single de Frase" 
 *     >> 31-01-23 - Limpar o controller de frase
*  ● Projeto2023Fev01 - Problema de LCP: mais de 2,5s (dispositivos móveis) - Dia 18/02
 *     >> 20-02-23 - inserir o parâmetro “nomeTabela” para o controller da frase. Imporante para o arquivo Seoparam_preload_imagens.blade.php. 
 *                   que vai testar se a tabela for frase para inserir o preload de imagens no corpo do html em caso de amp page.
 * ● Projeto2023Mar03 - Redirecionar páginas AMP, Parte 2
 *     >> 17-03-23 - publicações: 
*       idFrase: 7861 - https://fraseteca.com.br/frase/7861
*       idFrase: 9035 - https://fraseteca.com.br/frase/9035
*      >> 20-03-23 - Retirar o redirect via php que existia no projeto anterior
 *--------------------------------------------------------------------------------------------------------------*/

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Entities\Post;
use App\Entities\Frases;
use App\Services\PostRelacionados;
use App\Services\Biografia;
use App\Services\ParamGlobal;
use App\Services\Seo;

class ShowFrontFrase extends Controller
{
    public function show($id)
    {
        $testaAmp = ($_SERVER["REQUEST_URI"]);
        $amp = str_contains($testaAmp, "amp/") ? true : false;
        $frase = Frases::where("id", "=", $id)
            ->select("frases.id", "frases.titulo", "frases.url_longa_amigavel", "frases.frase", "frases.autor", "frases.tags", "frases.status", "frases.capa", "frases.usuario_id", 'frases.dimensoes', "frases.nomeMobile", "frases.nomeDownload", "frases.alt", "frases.created_at", "frases.anuncios", "frases.seoparam", "frases.imagemforte")
            ->first();
        $frasesSalvas = [];
        $naslistas = [];
        if ($frase) :
            $usuariologado      = Auth::user();
            $naslistas          = $this->nasListas($frase->id);
            $paramglobal        = new ParamGlobal;
            $biografia          = new Biografia;
            $postsrelservice    = new PostRelacionados;
            $seo                = new Seo;
            $options            = $paramglobal->get('arr');
            $dadosdoautor       = $biografia->get($frase->usuario_id);
            $postrel            = $postsrelservice->get($frase->id);
            $seoParam           = $seo->get($frase, "frase");

            if ($usuariologado) :
                $frasesSalvas = DB::table('pasta_usuario_item')
                    ->where([
                        ['pasta_usuario_item.usuario_id', '=',  $usuariologado->id],
                    ])
                    ->select('pasta_usuario_item.frase_id')
                    ->get();
            endif;
            $tagPosts = DB::table('tagfrases')
                ->where('tagfrases.frase_id', '=',  $id)
                ->join('tags', 'tags.id', '=', 'tagfrases.tag_id')
                ->select('tags.descricao', 'tags.urlamigavel')
                ->get();

            return view('front.FraseShow', [
                'tabela'        => $frase,
                'amp'           =>  $amp,
                'seo'           => $seoParam,
                'postrel'       => $postrel,
                'naslistas'     => $naslistas,
                'tagposts'      => $tagPosts,
                'logado'        => $usuariologado,
                'nomeTabela'    => "frases",
                'frasessalvas'  => $frasesSalvas,
                'options'       => ["paramGlobal" => ((env('APP_ENV') == 'producao' || env('APP_ENV') == 'homolog')) ? true : false],
                'dadosdoautor'  => $dadosdoautor,
            ]);
        else :
            return response()->view('404', ['exception' => []], 404);
        endif;
    }
    public function compartilharFraseAmp($id, $tipo)
    {
        $url = env("APP_URL");
        $imgSrc = asset('images/padrao.jpg');
        if ($tipo == "f") {
            $tabela = Frases::find($id);
            if ($tabela) {
                $url    = env("APP_URL") . "/frase/" . $tabela->id;
                $imgSrc = $tabela->getImagemCapaAttribute();
            }
        } else {
            $tabela = Post::find($id);
            if ($tabela) {
                $url    = env("APP_URL") . "/" . $tabela->urlamigavel;
                $imgSrc = $tabela->getImagemCapaAttribute();
            }
        }
        if ($tabela) :
            return view('compartilhar_link_amp', [
                'tabela'    => $tabela,
                'url'       => $url,
                'imgSrc'    => $imgSrc,
            ]);
        else :
            return response()->view('404', ['exception' => []], 404);
        //abort(404);
        endif;
    }
    public function nasListas($id)
    {
        $nasListas = DB::table('posts_itens')
            ->where([
                ['frase_id', '=',  $id],
            ])
            ->join('posts', 'posts.id', '=',  'posts_itens.post_id')
            ->orderBy('id', 'desc')
            ->select('posts.id', 'posts.titulo', 'posts.urlamigavel', 'posts.capa', 'posts.thumb', 'posts.midia_id')
            ->get();
        return $nasListas;
    }
}
