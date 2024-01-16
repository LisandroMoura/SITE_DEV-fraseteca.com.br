<?php

namespace App\Services;

use App\Entities\Midia;
use App\Services\Mensagens;
class MidiaService 
{
    protected $service_mensagens;

    public function __construct(Mensagens $service_mensagens)
    {
        $this->service_mensagens    = $service_mensagens; 
        /**
         * Também pode ser feito assim
         * $service_mensagens = new Mensagens;
         *  */        
    }

    public function store($data)
    {
        /**
         * Aqui no Serviço, vamos validar, fazer o Update
         * Usando a biblioteca: https://packagist.org/packages/prettus/laravel-validation
         * precisa ser em try cath
         */ 
        $msg_validator  = $this->service_mensagens->mensagens_cadastro;
        try {
            $midia = Midia::create($data);         
            return [
                'sucesso'       => true,
                'titulo_msg'    => $msg_validator['titulo_sucesso'],
                'msg'           => $msg_validator['create_sucesso'],
                'registro'      => $midia->toArray(),
            ];            
        } catch (\Throwable $e) {
            return [
                'sucesso'       => false,
                'titulo_msg'    => $msg_validator['titulo_erro'],
                'msg'           => "erro",
            ];
        }
    }
    public function update($request, $id)
    {
        try {  
            $msg_validator = $this->service_mensagens->mensagens_cadastro;             
            /**
             * Upload de imagem
             * salvar apenas o ID do avatar
             * Que é apenas o id da imagem da tabela midias
            */
            $dados = $request->all();
            $midia = Midia::find($id);
            $midia->update($dados);
            return [
                'sucesso'  => true,
                'titulo_msg' => $msg_validator['titulo_sucesso'],
                'msg'      => $msg_validator['update_sucesso'],
                'registro' => $midia,
            ];            
        } catch (\Throwable $e) {
            return [
                'sucesso'       => false,
                'titulo_msg'    => $msg_validator['titulo_erro'],
                'msg'           => "error",
            ];
        }
    }
    public function delete($id)
    {        
        $msg_validator      = $this->service_mensagens->mensagens_cadastro;
        try {          
            $midia =  Midia::find($id);
            if ($midia){
                switch ($midia['tipo']) {
                    case '1':
                        //$imagem = asset('storage/images/'.$this->attributes['url']);
                        $arquivo = \storage_path(). "\\app\\public\\images\\" . str_replace('/','\\',$midia['url']);
                    break;

                    case '5':
                        //$imagem = asset('storage/images/'.$this->attributes['url']);
                        $arquivo = \storage_path(). "\\app\\public\\images\\" . str_replace('/','\\',$midia['url']);
                    break;
                    case '4':                        
                        $arquivo = \storage_path(). "\\app\\public\\" . str_replace('/','\\',$midia['url']);
                    break;    
                    case '3':
                        $arquivo = \storage_path(). "\\app\\public\\" . str_replace('/','\\',$midia['url']);
                    break;  
                    default:
                        $imagem = asset('images/_caozinho.png');
                    break;
                }
                if (file_exists($arquivo))
                    unlink($arquivo);
            }
            $deleted = Midia::find($id);
            if($deleted)
                $deleted->delete();
            return [
                'sucesso'  => true,
                'titulo_msg' => $msg_validator['titulo_sucesso'], 
                'msg'      => $msg_validator['delete_sucesso'],
                'registro' => null,
            ];            

        } catch (\Throwable $e) {
            return [
                'sucesso'       => false,
                'titulo_msg'    => $msg_validator['titulo_erro'],
                'msg'           => "Error",
            ];
        }
    }
}
?>