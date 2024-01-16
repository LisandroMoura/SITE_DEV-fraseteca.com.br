<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Entities\Lista;
use App\Entities\PastaUsuario;

/**
 * Class ImageCreateGenerate.
 * Classe para criação de imagens de Frases
 * 
 * @package namespace App\Services;
 * @author  LM
 * @link    https://docs.google.com/document/d/1aerE_1MG7WRBw45WWiTVWBGIBJWln05VWjKdMw3g1rI/edit?usp=sharing
 * @version 1.0.0 - Ago-2020
 */
class ServiceSecurityIsSameUser {    

    public function run($rota,$id,$action=null)
    {
        # code...                
        $usuariologado = Auth::user();
        $userId="0";
        
        /**
         * ==============================================
         *             Tratamento para listas
         * ==============================================
         */
        if($rota=="listas"){
            $lista = Lista::find($id);
            if($lista){
                $userId=$lista->usuario_id;
                //trata a situação da lista
                if($action=="destroy")
                    if($lista->status>"2"){

                        $retorno = [
                            'sucesso'       => false,
                            'titulo_msg'    => "Ops",
                            'msg'           => "Lista não pode ser deletada",
                            'arrMsg'        => [],
                        ];
                        return $retorno;             
                    }
            }                
        }

        if($rota=="pastas"){
            $pasta = PastaUsuario::find($id);
            if($pasta){
                $userId=$pasta->usuario_id;
                //trata a situação da lista
                if($usuariologado->id != $userId && $usuariologado->perfil != 1){                
                    $retorno = [
                        'sucesso'       => false,
                        'titulo_msg'    => "Ops",
                        'msg'           => "Você não tem acesso a essa rotina",
                        'arrMsg'        => [],
                    ];
                    return $retorno;
                }
                if($pasta->status=="2" && $usuariologado->perfil != 1){
                    $retorno = [
                        'sucesso'       => false,
                        'titulo_msg'    => "Ops",
                        'msg'           => "Não é possível editar esta pasta! Ela está aguardando moderação!",
                        'arrMsg'        => [],
                    ];
                    return $retorno;
                }

                if($pasta->status=="1"){
                    $retorno = [
                        'sucesso'       => false,
                        'titulo_msg'    => "Ops",
                        'msg'           => "Não é possível editar esta pasta! Ela já está publicada no site!",
                        'arrMsg'        => [],
                    ];
                    return $retorno;
                }


            }                
        }

        /**
         * ==============================================
         *  Tratamento para usuarios. securitys
         ** ==============================================
         * 
         */
        if($rota=="usuario")
            $userId=$id;


        
        //testar se o usuário tem acesso ou não há esta rotina
        $lnext=false;                
        if ($usuariologado){            
            if($usuariologado->id == $userId)
                $lnext=true; 
            if($usuariologado->perfil === '1')
                $lnext=true;    
        }

        $retorno = [
            'sucesso'       => true,
            'titulo_msg'    => "ok",
            'msg'           => "Você tem acesso a esta rotina!",            
            'arrMsg'        => [],
        ];  
        
        
        if(!$lnext){
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => "Ops",
                'msg'           => "Você não tem acesso a esta rotina! Não é sua",            
                'arrMsg'        => [],
            ];
        }     
        return $retorno;             
    }    

    public function isAdm($var = null)
    {
        $usuariologado = Auth::user();                    
        $lnext=false;                
        if ($usuariologado){
            if($usuariologado->perfil === '1')
                $lnext=true;            
        }
        if(!$lnext){
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => "Vish!!!",
                'msg'           => "Você não tem acesso a esta rotina!",            
                'arrMsg'        => [],
            ];
            
            return $retorno;
        }          

        $retorno = [
            'sucesso'       => true,
            'titulo_msg'    => "yes",
            'msg'           => "Você tem acesso a esta rotina!",            
            'arrMsg'        => [],
        ];

        return $retorno;

    }

}
