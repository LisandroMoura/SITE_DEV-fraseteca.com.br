<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Entities\Tag;
use App\Entities\Feed;
use App\Entities\Categoria;
use App\Services\Seo;

class ShowFrontArchive extends Controller
{
    public function tag($dado, $currentPage = null)
    {
        $seo = [];
        $tabela = [];
        $seguidor = "enable";
        $titulo = "";
        $resumo = "";
        $testaAmp       = ($_SERVER["REQUEST_URI"]);
        $amp = str_contains($testaAmp, "/amp/") ? true : false;
        $usuariologado = Auth::user();
        $dadoum = Tag::where([
            ['urlamigavel', 'like',  $dado],
            ['status', '=',  '1']
        ])
            ->orderBy('id', 'desc')
            ->take(1)
            ->first();
        if ($dadoum) :
            $titulo = $dadoum->descricao;
            $resumo = $dadoum->resumo;
            $tabela = DB::table('tagposts')
                ->where('tag_id', '=',  $dadoum->id)
                ->join('posts', 'tagposts.post_id', '=', 'posts.id')
                ->join('tags', 'tags.id', '=', 'tagposts.tag_id')
                ->select('posts.id', 'posts.urlamigavel', 'posts.thumb', 'posts.capa', 'posts.titulo', 'tags.descricao', 'tags.id')
                ->orderBy('posts.id', 'desc')
                ->paginate(20);
            if ($tabela) :
                if ($usuariologado) :
                    $feed = Feed::where([
                        ["usuario_id", "=", $usuariologado->id],
                        ["origem", "=", "0"],
                        ["origem_id", "=", $dadoum->id]
                    ])->first();
                    if ($feed)
                        $seguidor = "seguindo";
                endif;
                $seo                = new Seo;
                $seoParam           = $seo->get($dadoum, "tag");
                return view('front.ArchiveShow', [
                    'tabela'    => $tabela,
                    'titulo'    => $titulo ,
                    'resumo'    => $resumo ,
                    'tipo'      => "tag",
                    'seguindo'   => $seguidor,
                    'amp'     =>  $amp,
                    'logado'   => $usuariologado,
                    'seo'       => $seoParam,
                    'dado'  => $dado,
                ]);
            else :
                return response()->view('404', ['exception' => []], 404);
            endif;
        else :
            return response()->view('404', ['exception' => []], 404);
        endif;
    }
    public function categoria($dado)
    {
        $seo = [];
        $tabela = [];
        $testaAmp       = ($_SERVER["REQUEST_URI"]);
        $amp = str_contains($testaAmp, "/amp/") ? true : false;
        $usuariologado = Auth::user();
        $dadoum = Categoria::where([
            ['urlamigavel', 'like',  $dado],
            ['status', '=',  '1']
        ])
            ->orderBy('id', 'desc')
            ->take(1)
            ->first();
        if ($dadoum) :
            $tabela = DB::table('categoriaposts')
                ->where('categoriaposts.categoria_id', '=',  $dadoum->id)
                ->join('posts', 'categoriaposts.post_id', '=', 'posts.id')
                ->join('categorias', 'categorias.id', '=', 'categoriaposts.categoria_id')
                ->select('posts.id', 'posts.urlamigavel', 'posts.thumb', 'posts.capa', 'posts.titulo', 'categorias.descricao')
                ->orderBy('posts.id', 'desc')
                ->paginate(20);
            if ($tabela) :
                $seoParam     = new Seo;
                $seo          = $seoParam->get($dadoum, "sessao");
                return view('front.ArchiveShow', [
                    'tabela'    => $tabela,
                    'amp'     =>  $amp,
                    'seguindo'   => "enable",
                    'tipo'      => "cat",
                    'logado'   => $usuariologado,
                    'seo'       => $seo,
                    'dado'  => $dado,
                ]);
            else :
                return response()->view('404', ['exception' => []], 404);
            endif;
        else :
            return response()->view('404', ['exception' => []], 404);
        endif;
    }
}
