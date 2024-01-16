<?php
namespace App\Services;
use App\Entities\Aprovacao;
use App\Entities\Comment;
use App\Entities\Lista;
use App\Entities\CommentFrases;
class NotificAdm
{    
    static function run(){
        $nComments          = Comment::where ('status', 'like',0)->count();
        $nCommentsFrases    = CommentFrases::where ('status', 'like',0)->count();
        $nAprovacao         = Aprovacao::where ('status', 'like',0)->count(); 
        $nRemessas          = Lista::where ('status', 'like',0)->count(); 
        $pending            = $nAprovacao + $nComments + $nCommentsFrases + $nRemessas ;
        return [
            'dados'             => compact('nComments', "nAprovacao"),
            'comments'          => $nComments,
            'comments_frases'   => $nCommentsFrases,
            'aprovacao'         => $nComments,
            'pending'           => $pending
        ];
    }

    static function getPendingQuantity($tabela = null)
    {
        $amount = 0;
        switch ($tabela) {
            case 'comments':
                $amount = Comment::where ('status', 'like',0)->count();
                break;

            case 'comments_frases':
                    $amount = CommentFrases::where ('status', 'like',0)->count();
                    break;
            case 'aprovacao':                
                $amount = Aprovacao::where ('status', 'like',0)->count();
                break;            
            case 'remessas':                
                    $amount = Lista::where ('status', 'like',0)->count();
                    break;  
            default:                
                break;
        }
        return $amount;
    }
}
