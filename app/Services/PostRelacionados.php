<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Entities\CategoriaPost;
use App\Entities\Tag;
use App\Entities\TagPost;
use App\Entities\TagFrases;
use App\Entities\PostsRelacionado;
use App\Services\TagsMarta;

/**
 * Classe padrão para os posts reçacionados
 * @package namespace App\Services;
 * @author  LM
 * @version 1.0.0 - Jun-2019
 */
class PostRelacionados 
{    
    public function get($id = null,$take = 4)
    {
        $nRegistrosEncontrados = 0;
        $quantoFalta = 0;
        $avail = DB::table('posts_relacionados')
        ->where('post_id', '=',  $id)           
        ->join('posts', 'posts_relacionados.post_rel', '=', 'posts.id')           
        ->select('posts_relacionados.*', 'posts.titulo', 'posts.urlamigavel', 'posts.capa', 'posts.thumb','posts.midia_id')            
        ->take($take)
        ->get();              
        if($avail) $nRegistrosEncontrados = count($avail);  
        $quantoFalta = $take - $nRegistrosEncontrados;
        if($quantoFalta>0):
            $relacionados = DB::table('posts')
            ->where([
                ['id', '!=',  $id],
                ['status', '=', "1"],              
            ])
            ->orderBy('id', 'desc')
            ->take($quantoFalta)
            ->select('posts.id','posts.titulo', 'posts.urlamigavel', 'posts.capa', 'posts.thumb','posts.midia_id')            
            ->get();
            return $relacionados;  
        endif;      
        return $avail;
    }    
    public function buscaPostRel($id = null)
    {
        $avail = DB::table('posts_relacionados')
            ->where('post_id', '=',  $id)           
            ->join('posts', 'posts_relacionados.post_rel', '=', 'posts.id')           
            ->select('posts_relacionados.*', 'posts.titulo', 'posts.urlamigavel', 'posts.capa', 'posts.thumb','posts.midia_id') 
            ->get();
        if($avail):                        
            return $avail;
        else :
            return null;
        endif;
    }
    public function salvaPostRel($post = null, $id = null)
    {
        $avail = PostsRelacionado::where ([
                ['post_id' , '=',  $id ],                    
                ['post_rel' ,'=',  $post]
        ])        
        ->take(1)
        ->first();
        if(!$avail):                        
            $dados = new PostsRelacionado;
            $dados->post_id  = $id;
            $dados->post_rel = $post;                            
            $dados->save();
        endif; 
    }      
    public function novaTag($tag = null, $id = null)
    {   
        $tagum = Tag::where ('descricao',  $tag)
        ->orderBy('descricao', 'asc')
        ->take(1)
        ->first();
        if(!$tagum) :
            $dados = new Tag;
            $dados->descricao = $tag ;            
            $dados->resumo = $tag ;            
            $tag  = str_replace(" ","-",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($tag))));
            $dados->urlamigavel = $tag;
            $tagsMarta = new TagsMarta;
            $stringToken  = $tagsMarta->geraChave($tag);
            $dados->token = $stringToken;
            $dados->save();
        endif;           
    }    
    public function salvaTagPost($tag = null, $id = null)
    {
        $tagum = Tag::where ('descricao',  $tag)
        ->orderBy('descricao', 'asc')
        ->take(1)
        ->first();
        if($tagum) : 
            $tagPost = Tag::where ('descricao',  $tag)
            ->orderBy('descricao', 'asc')
            ->take(1)
            ->first();
            $tagPost = TagPost::where([
                ['tag_id' , '=',  $tagum->id ],                    
                ['post_id' ,'=',  $id]
            ])
            ->first();

            if(!$tagPost):
                $dados = new TagPost;
                $dados->tag_id  = $tagum->id ;
                $dados->post_id = $id;                            
                $dados->save();
            endif;                    
        endif;       
    }
    public function salvaTagFrases($tag = null, $id = null)
    {
        $tagum = Tag::where ('descricao',  $tag)
        ->orderBy('descricao', 'asc')
        ->take(1)
        ->first();
        if($tagum) :             
            $tagFrases = TagFrases::where([
                ['tag_id' , '=',  $tagum->id ],                    
                ['frase_id' ,'=',  $id]
            ])
            ->first();
            if(!$tagFrases):
                $dados = new TagFrases;
                $dados->tag_id  = $tagum->id ;
                $dados->frase_id = $id;                            
                $dados->save();
            endif;                    
        endif;       
    }
    public function limpaTagPost(array $tagsParaGravar, $id)
    {
        $tagPostColect = TagPost::where ('post_id', $id)->get();
        foreach ($tagPostColect as $key => $tagPost) {
            $tagum = Tag::where ('id',  $tagPost->tag_id)->take(1)->first();
            if($tagum){
                if(!in_array($tagum->descricao, $tagsParaGravar)){                    
                    $delete = TagPost::where('id', $tagPost->id)->delete ();             
                }   
            }
        }
    }
    public function limpaTagFrases(array $tagsParaGravar, $id)
    {
        $tagFrasesColect = TagFrases::where ('frase_id', $id)->get();
        foreach ($tagFrasesColect as $key => $tagFrase) {
            $tagum = Tag::where ('id',  $tagFrase->tag_id)->take(1)->first();
            if($tagum){
                if(!in_array($tagum->descricao, $tagsParaGravar)){                    
                    $delete = TagFrases::where('id', $tagFrase->id)->delete ();             
                }   
            }
        }
    }
    public function limpaPostRel(array $postsParaGravar, $id)
    {
        $postRelColect = PostsRelacionado::where ('post_id', $id)->get();
        foreach ($postRelColect as $key => $postRel) {
            if(!in_array($postRel->post_rel, $postsParaGravar)){
                $delete = PostsRelacionado::where('id', $postRel->id)->delete ();             
            }
        }
    }
    public function gravaCategoria($categoria = null, $id = null)
    {
        $avail = CategoriaPost::where([
            ['categoria_id' , '=',  $categoria ],                    
            ['post_id' ,'=',  $id]
        ])->first();
        if(!$avail):
            $dados = new CategoriaPost;
            $dados->categoria_id  = $categoria ;                        
            $dados->post_id = $id;            
            $dados->save();
        endif;
        $avail = CategoriaPost::where([            
            ['post_id' ,'=',  $id],
            ['categoria_id' , '!=',  $categoria ]                    
        ])->first();
        if($avail):
            $delete = CategoriaPost::where('id', $avail->id)->delete (); 
        endif;
    }
}
