<?php

namespace App\Services;
/**
 * Class Retornos.
 * Classe de retorno padrão de tratamento das Msgs de erros
 * da aplicação nesta úníca classe. Para Fins de fácil manutenção.
 * @package namespace App\Services;
 * @author  LM
 * @link    https://docs.google.com/document/d/1aerE_1MG7WRBw45WWiTVWBGIBJWln05VWjKdMw3g1rI/edit?usp=sharing
 * @version 1.0.0 - Fev-2020
 */

use App\Exceptions\ValidatorException;
use App\Services\Mensagens;


class Retornos 
{    
    protected $service_mensagens;

    public function __construct(Mensagens $service_mensagens)
    {
        $this->service_mensagens    = $service_mensagens;         
    }

    public function Try(
            $entitie = null, 
            $options = null, 
            $custom = null            
            )
    {
        $msg_validator =$this->service_mensagens->mensagens_cadastro;        
        if (!$options) $options = $msg_validator['create_sucesso'];  
        if ($options == 'delete')
            $options = $msg_validator['delete_sucesso'];
        if ($options == 'update')
            $options = $msg_validator['update_sucesso'];
        $registro = $entitie ? $entitie->toArray() : null ;
            return [
                'sucesso'       => true,
                'titulo_msg'    => $msg_validator['titulo_sucesso'],
                'msg'           => $custom ? $custom : $options,
                'registro'      => $registro,
                'arrMsg'        => null    
            ];         
            
    }

    public function Catch(ValidatorException $e = null, $options = null, $custom = null)
    {
        $msg_validator =$this->service_mensagens->mensagens_cadastro;        
        $arrMsg=[];     
        $i=0;     
        if($e):       
            foreach ($e->getMessageBag()->getMessages() as $mensagem){
                foreach ($mensagem as $msg){
                    $arrMsg[$i] = $msg;                    
                    $i++;
                }
            }
        else:
            $arrMsg[$i] = $custom;
            $custom = null;                    
        endif;
        return [
            'sucesso'       => false,
            'titulo_msg'    => $msg_validator['titulo_erro'],                
            'msg'           => $custom ? $custom : $msg_validator['validator_erro'],
            'arrMsg'        => $arrMsg,
        ];
    }

}
