<?php

/**--------------------------------------------------------------------------------------------------------------
 * Nome: ShowFrontPost.php
 * Autor: LM
 * Objetivo: Programa responsável por buscar no banco de dados todas as informações que precisamos em relação 
 *           ao Post (Biblioteca). Além de tratar o que foi digitado pelo cliente, prepara todos os dados que 
 *           serão servidos a view (front).
 * Doc: https://docs.google.com/document/d/1JZxjvK3O_GZvPXlife9R40_uorZRKeTH3H72mQeVEVo/
 * -------------------------------------------------------
 * UPDATES:
 * -------------------------------------------------------
 *  ● Projeto2023Jan02 - Imagem com height 346px no cache do google
 *     >> 01-01-23 - Passar como false a variável mobile para a view do ítem
 *
 *  ● Projeto2023Jan10 - ● Projeto2023Jan10 - Melhorando o Webmaster Tools - Tarefa: 1) Para celular ajustar problema de LCP: mais de 2,5s (dispositivos móveis)
 *     >> 25-01-23 - Remover o uso da classe ParamGlobal ($options) deste programa
 *
 *  ● Projeto2023Mar02 - Redirecionar as páginas AMP para não Amp
 *     >> 16-03-23 - Foi feito um teste do redirect via laravel apenas para as seguintes 
 *        publicações: 86-frases-de-deus-para-status, 46-frases-da-cora-coralina
 * 
 *  ● Projeto2023Mar04 - Redirecionar páginas AMP, Parte 3
 *     >> 20-03-23 - Retirar o redirect via php que existia
 *--------------------------------------------------------------------------------------------------------------*/


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Entities\Post;
use App\Entities\PostsItens;
use App\Entities\Curtida;
use App\Entities\PastaUsuario;
use App\Services\Biografia;
use App\Services\PostRelacionados;
use App\Services\Seo;

class ShowFrontPost extends Controller
{
    public function show($urlamigavel)
    {
        
        $seo = [];
        $frasessalvas = [];
        $curtida = [];
        $seguindo = [];
        $postitens = [];
        $postrel = [];
        $totalcurtidasdopost = 0;
        $dadosdoautor = [];
        $testaamp = ($_SERVER["REQUEST_URI"]);
        $amp = str_contains($testaamp, "amp/") ? true : false;
        $poststipe = Post::where('urlamigavel', 'like',  $urlamigavel)->select("posts.tipo")->first();
        if (!$poststipe) return response()->view('404', ['exception' => []], 404);

        //Projeto20221105 - 23-11-22 LM - fornecer o campo introdução a view
        if ($poststipe->tipo == "1")
            $posts = Post::where('urlamigavel', 'like',  $urlamigavel)
                ->select("posts.id", "posts.titulo", "posts.urlamigavel", "posts.capa", "posts.thumb",  "posts.mobile", "posts.resumo", "posts.tags", "posts.autor_id", "posts.imprime_capa", "posts.tipo", "posts.autorName", "posts.autorLink", "posts.anuncios", "posts.seoparam", "posts.momentolazy", "posts.imagemforte", "posts.introducao")
                ->first();
        else {
            if ($amp) return response()->view('404', ['exception' => []], 404);
            $posts = Post::where('urlamigavel', 'like',  $urlamigavel)
                ->select("posts.id", "posts.titulo", "posts.urlamigavel", "posts.corpo", "posts.capa",  "posts.thumb",  "posts.mobile", "posts.tags", "posts.resumo", "posts.autor_id", "posts.imprime_capa", "posts.tipo", "posts.anuncios")
                ->first();
        }
        if ($posts) :

            // ● Projeto2023Mar02 - Redirecionar as páginas AMP para não Amp
            if($posts->id == '41' && $amp)
                return redirect('/86-frases-de-deus-para-status', 301);

            if($posts->id == '66' && $amp)
                return redirect('/46-frases-da-cora-coralina', 301);

            // ● Projeto2023Mar03 - Redirecionar páginas AMP, Parte 2
            if($posts->id == '10' && $amp)
                return redirect('/101-frases-do-augusto-cury', 301);

            if($posts->id == '219' && $amp)
                return redirect('/frases-do-sigmund-freud', 301);

            if($posts->id == '101' && $amp)
                return redirect('/30-frases-da-frida-kahlo', 301);
            
            if($posts->id == '9' && $amp)
                return redirect('/120-frases-inteligentes', 301);

            if($posts->id == '269' && $amp)
                return redirect('/frases-de-carl-gustav-jung', 301);

            $usuariologado = Auth::user();
            if ($usuariologado) :
                $frasessalvas = DB::table('pasta_usuario_item')
                    ->join(
                        'pasta_usuarios',
                        [
                            ['pasta_usuarios.id', '=', 'pasta_usuario_item.pasta_id'],
                        ]
                    )
                    ->where([
                        ['pasta_usuario_item.usuario_id', '=',  $usuariologado->id],
                    ])
                    ->select('pasta_usuario_item.frase_id')
                    ->get();

                $seguindo = PastaUsuario::where([
                    ['post_id', 'like', $posts->id],
                    ['usuario_id', '=', $usuariologado->id]
                ])->first();

                $curtida = Curtida::where([
                    ['post_id', 'like', $posts->id],
                    ['usuario_id', '=', $usuariologado->id]
                ])->select('curtidas.id')->first();
            endif;
            $tagposts = DB::table('tagposts')
                ->where('tagposts.post_id', '=',  $posts->id)
                ->join('tags', 'tags.id', '=', 'tagposts.tag_id')
                ->select('tags.id', 'tags.descricao', 'tags.urlamigavel', 'tags.disponivel')
                ->get();
            $biografia           = new Biografia;
            $postsrelservice     = new PostRelacionados;
            $seo                 = new Seo;
            $seoparam            = $seo->get($posts, "post");
            $dadosdoautor        = $biografia->get($posts->autor_id);
            $postrel             = $postsrelservice->get($posts->id, 5);
            $postitens           = $this->getPostsItens($posts->id);
            $totalcurtidasdopost = $this->getCurtidas($posts->id);

            return view('front.PostShow', [
                'frasessalvas'          => $frasessalvas ?? null,
                'seguindo'              => $seguindo,
                'amp'                   => $amp,
                'curtida'               => $curtida,
                'tabela'                => $posts,
                'seo'                   => $seoparam,
                'itens'                 => $postitens,
                'postrel'               => $postrel,
                'nomeTabela'                => "posts",
                'tagposts'              => $tagposts,
                'logado'                => $usuariologado,
                'options'               => ["paramGlobal" => ( (env('APP_ENV') == 'producao' || env('APP_ENV') == 'homolog') ) ? true : false ],
                'totalcurtidasdopost'   => $totalcurtidasdopost,
                'dadosdoautor'          => $dadosdoautor,
                // Projeto20221201 - Nova Tag de imagem dentro do sistema.
                // 'arrTeste'     => $arrTeste,
            ]);
        else :
            return response()->view('404', ['exception' => []], 404);
        endif;
    }
    public function compartilhar()
    {

        return response()->view('404', ['exception' => []], 404);

        // $usuariologado = Auth::user();
        // return view('front.compartilhar',[                                   
        //     'logado'   => $usuariologado,
        //     'tabela' => [], 
        //     'url'   => [],
        // ]);

    }
    public function getPostsItens($id)
    {
        $postitens = PostsItens::where('post_id', '=',  $id)
            ->join('frases', 'posts_itens.frase_id', '=', 'frases.id')
            ->select('posts_itens.id as item_id', 'posts_itens.ordem', 'posts_itens.capa as item_capa', 'posts_itens.mostraimg', 'posts_itens.aux_1', 'posts_itens.aux_2', 'posts_itens.tipo', 'posts_itens.post_id', 'frases.id', 'frases.titulo', 'frases.frase', 'frases.status', 'frases.autor',  'frases.capa', 'frases.dimensoes', 'frases.nomeDownload', 'frases.nomeMobile', 'frases.alt')
            ->orderby("posts_itens.ordem")
            ->get();
        return $postitens;
    }
    public function getCurtidas($id = null)
    {
        $curtidascolect = Curtida::where('post_id', $id)->get();
        return count($curtidascolect);
    }
}
