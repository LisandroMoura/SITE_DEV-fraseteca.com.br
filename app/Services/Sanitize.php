<?php
namespace App\Services;

use App\Exceptions\ValidatorException;
class Sanitize
{    
    public function run(String $campo)
    {
        // $campo = preg_replace('/[^[:alpha:]_]/', '',$campo);
        // $campo = preg_replace('/[^[:alnum:]_]/', '',$campo);
        $campo = preg_replace("/(from|select|insert|delete|where|drop table|show tables|like|grant|revoke|#|\*|--|\\\\)/i","",$campo);
        $campo = str_replace("document.location","",$campo);
        $campo = str_replace("Image()","",$campo);
        $campo = str_replace(".src","",$campo);
        $campo = str_replace("localStorage","",$campo);
        $campo = str_replace("javascript","",$campo);
        $campo = str_replace("onload","",$campo);
        $campo = str_replace("UNION","",$campo);
        $campo = str_replace("ORDER BY","",$campo);
        $campo = str_replace("script","",$campo);
        $campo = str_replace("/","",$campo);
        return $campo;
    }
    static function clearCatch(String $data = null)
    {
        $storage = storage_path();
        $path = public_path();
        $data = str_replace($path,"",$data);
        $data = str_replace($storage,"",$data);
        return $data;
    }
    static function clearCatchValidatorException(ValidatorException $e = null) {
        $data="";
        if($e){
            $storage = storage_path();
            $path = public_path();
            foreach ($e->getMessageBag()->getMessages() as $mensagem){
                foreach ($mensagem as $msg){
                    $msg = str_replace($path,"",$msg);
                    $msg = str_replace($storage,"",$msg);
                    $data.= $msg . " - ";
                }
            }
        }
        return $data;
    }
}