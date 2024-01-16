<?php
namespace App\Services;
use App\Entities\Midia;
use App\Entities\Post;
class Thumbnail
{    
    public function get($capa, $idPost = null)
    {
        $postCapa=0;
        if($idPost):
            $post  = Post::find($idPost);   
            if ($post){
                $postCapa = $post->midia_id;
                $capa = $post->thumb;
                if($capa==""){                    
                    $capa = $post->capa;                    
                }                    
            }
        endif;        
        if($capa=="" || $capa=="null"):        
            $midia  = Midia::find($postCapa);
            if($midia){  
                switch ($midia['tipo']) {
                    case '1':
                        $capa = asset('storage/images/'.$midia['url']);
                    break;
                    case '4':
                        $capa = asset('storage/'.$midia['url']);
                    break;    
                    case '3':
                        $capa = asset('storage/'.$midia['url']);
                    break;  
                    default:
                        $capa = asset("storage/images/thumbnail.jpg.jpg");
                    break;
                }              
            }
            else {
                $capa = asset("storage/images/thumbnail.jpg.jpg");
            }
        endif;
        return $capa;
    } 
}
