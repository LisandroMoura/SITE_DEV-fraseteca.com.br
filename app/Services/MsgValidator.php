<?php
namespace App\Services;
class MsgValidator
{    
    static function run($errors)
    {
        $msgValidatorArr    =[];
        $arrMsg             =[];
        if ($errors->any()){

            // dd($errors->getMessages());
            if ( isset($errors->getMessages()['arrMsg'])){
                $arrMsg = $errors->getMessages()['arrMsg'];
            } else{
                $arrMsg = $errors->getMessages();
            }            
        }   
        //padrão antigo de validação
        if ( isset($errors->getMessages()['arrMsg'])){
            foreach ($arrMsg as $msg) {  
                $erros = explode("||", $msg);
                //$fieldsErro[$erros[1]] = $erros[2] ;            
                foreach ($erros as $key => $valor) {
                    if($valor && $key > 0){
                        if($key==1){                        
                            if(isset($msgValidatorArr[$valor]))                        
                                $msgValidatorArr[$valor] .= ' - ' . $erros[2]; 
                            else 
                                $msgValidatorArr[$valor] = $erros[2];
                        }
                    }  
                }
            }
        }else {
            foreach ($arrMsg as $key => $valor ) {  
                //$fieldsErro[$erros[1]] = $erros[2] ;   
                if($valor){
                    $msgValidatorArr[$key] = $valor[0];
                    // if($key==1){  
                    //     if(isset($msgValidatorArr[$valor]))                        
                    //         $msgValidatorArr[$valor] .= ' - ' . $arrMsg[2]; 
                    //     else 
                    //         $msgValidatorArr[$valor] = $arrMsg[2];
                    // }
                }  
            }
        }
        return $msgValidatorArr;
    } 
}
