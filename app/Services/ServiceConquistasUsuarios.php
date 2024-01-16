<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Entities\Conquista;
use App\Entities\ConquistasUsuarios;

/**
 * Class Mensagens.
 * Classe de retorno padrão de mensagens. Centralizar todas as mensagens
 * da aplicação nesta úníca classe. Para Fins de fácil manutenção.
 * @package namespace App\Services;
 * @author  LM
 * @link    https://docs.google.com/document/d/1aerE_1MG7WRBw45WWiTVWBGIBJWln05VWjKdMw3g1rI/edit?usp=sharing
 * @version 1.0.0 - Jun-2019
 */
class ServiceConquistasUsuarios
{    
    public function buscaConquistasUsuarios($id = null)
    {
        $avail = DB::table('conquistas_usuarios')
            ->where('usuario_id', '=',  $id)           
            ->join('conquista', 'conquistas_usuarios.conquista_id', '=', 'conquista.id')           
            ->select('conquistas_usuarios.*', 'conquista.nome', 'conquista.descricao', 'conquista.icone')            
            ->get();
        if($avail):                        
            return $avail;
        else :
            return null;
        endif;
    }
    public function salvaConquistasUsuarios($conquista_id = null, $id = null)
    {
        $avail = ConquistasUsuarios::where ([
            ['usuario_id'   , '=',  $id ],                    
            ['conquista_id' , '=',  $conquista_id]
        ])        
        ->take(1)
        ->first();
        if(!$avail):                        
            $dados = new ConquistasUsuarios;
            $dados->usuario_id      = $id;
            $dados->conquista_id    = $conquista_id;                            
            $dados->save();
        endif; 
    }      
    public function novaConquista($tag = null, $id = null)
    {   
        $tagum = Conquista::where ('descricao',  $tag)
        ->orderBy('descricao', 'asc')
        ->take(1)
        ->first();
        if(!$tagum) :
            $dados = new Conquista;
            $dados->descricao  = $tag ;            
            $tag  = str_replace(" ","-",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($tag))));
            $dados->urlamigavel = $tag;            
            $dados->save();
        endif;           
    }    
    public function salvaConquista($tag = null, $id = null)
    {
        $tagum = Conquista::where ('descricao',  $tag)
        ->orderBy('descricao', 'asc')
        ->take(1)
        ->first();
        if($tagum) : 
            $tagPost = Conquista::where ('descricao',  $tag)
            ->orderBy('descricao', 'asc')
            ->take(1)
            ->first();
            $tagPost = Conquista::where([
                ['tag_id' , '=',  $tagum->id ],                    
                ['usuario_id' ,'=',  $id]
            ])
            ->first();

            if(!$tagPost):
                $dados = new Conquista;
                $dados->tag_id  = $tagum->id ;
                $dados->usuario_id = $id;                            
                $dados->save();
            endif;                    
        endif;       
    }
    
    public function limpaConquistasUsuarios(array $postsParaGravar, $id)
    {
        $ConquistasUsuarios = ConquistasUsuarios::where ('usuario_id', $id)->get();
        foreach ($ConquistasUsuarios as $key => $conquistaRel) {
            //if(!in_array($conquistaRel->conquista_id, $postsParaGravar)){
                $delete = ConquistasUsuarios::where('id', $conquistaRel->id)->delete ();             
            //}
        }
    }
    
}
