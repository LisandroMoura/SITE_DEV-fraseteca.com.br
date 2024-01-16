<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Entities\Post;
use App\Entities\Frases;
use App\Services\Seo;
use Illuminate\Http\Request;

class ShowFrontPesquisa extends Controller
{
    public function pesquisa($termo, Request $request)
    {
        $pesquisa = $request->all();
        $query = data_get($pesquisa, 'pesquisar');
        $tipo = "todos";
        $posts = [];
        $frases = [];

        //remover da pesquisa a paravra frase
        $query = strtolower($query);
        $query = str_replace("frases para a", "", $query);
        $query = str_replace("frases para o", "", $query);
        $query = str_replace("frases para", "", $query);

        $query = str_replace("frase para a", "", $query);
        $query = str_replace("frase para o", "", $query);
        $query = str_replace("frase para", "", $query);

        $query = str_replace("frases sobre a", "", $query);
        $query = str_replace("frases sobre o", "", $query);
        $query = str_replace("frases sobre", "", $query);
        
        $query = str_replace("frase sobre a", "", $query);
        $query = str_replace("frase sobre o", "", $query);
        $query = str_replace("frase sobre", "", $query);

        $query = str_replace("frases de", "", $query);
        $query = str_replace("frases do", "", $query);
        $query = str_replace("frases da", "", $query);

        $query = str_replace("frase de", "", $query);
        $query = str_replace("frase do", "", $query);
        $query = str_replace("frase da", "", $query);

        $query = str_replace("frases ", "", $query);
        $query = str_replace("frases", "", $query);
        $query = str_replace("frase ", "", $query);
        $query = str_replace("frase", "", $query);


        if (isset($pesquisa['tipo'])) {
            $tipo = $pesquisa['tipo'];
        }

        switch ($tipo) {
            case 'frases':
                $frases = Frases::where('frase', 'like', '%' . $query . '%')
                    ->orWhere(
                        [
                            ['status', '=',  '1'],
                            ['autor', 'like',  '%' . $query . '%']
                        ]
                    )
                    ->select("frases.id", "frases.status","frases.titulo", "frases.url_longa_amigavel", "frases.frase", "frases.autor", "frases.capa")
                    ->orderBy('frase', 'asc')
                    ->paginate(20);
                break;
            case 'listas':
                $posts = Post::where('titulo', 'like', '%' . $query . '%')
                    ->select("posts.titulo", "posts.urlamigavel", "posts.capa", "posts.thumb")
                    ->orderBy('titulo', 'asc')
                    ->paginate(20);
                break;
            default:
                $posts = Post::where('titulo', 'like', '%' . $query . '%')
                    ->select("posts.titulo", "posts.urlamigavel", "posts.capa", "posts.thumb")
                    ->orderBy('titulo', 'asc')
                    ->paginate(20);

                $frases = Frases::where('frase', 'like', '%' . $query . '%')
                    ->orWhere(
                        [
                            ['status', '=',  '1'],
                            ['autor', 'like',  '%' . $query . '%']
                        ]
                    )
                    ->orderBy('frase', 'asc')
                    ->paginate(20);
                break;
        }
        if ($posts || $frases) :
            $seo                = new Seo;
            $seoParam           = $seo->get(null, "search");
            $usuariologado = Auth::user();
            $frasesSalvas = [];
            if ($usuariologado) :
                $frasesSalvas = DB::table('pasta_usuario_item')
                    ->where([
                        ['pasta_usuario_item.usuario_id', '=',  $usuariologado->id],
                    ])
                    ->select('pasta_usuario_item.frase_id')
                    ->get();
            endif;


            return view('front.SearchShow', [
                'posts'    => $posts,
                'frasessalvas' => $frasesSalvas,
                'frases'    => $frases,
                'logado'   => $usuariologado,
                'amp'      => false,
                'seo'      => $seoParam,
            ]);
        else :
            return response()->view('404', ['exception' => []], 404);
        endif;
    }
}
