<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Exceptions\ValidatorException;
use App\Entities\Post;
use App\Entities\ListaItem;
use App\Entities\PostsItens;
use App\Entities\Frases;

use App\Services\Mensagens;
use App\Services\MidiaService;



/**
 * Class PostService.
 *
 * @package namespace App\Services;
 */
class PostService 
{
    protected $service_mensagens;
    protected $midia_service;

    public function __construct(
        Mensagens $service_mensagens,
        Midiaservice $midia_service)
    {
        /**
         * usando o methodo construtor, vc não precisa fazer o seguinte:
         * $repository = new PostRepository();
         */
        $this->service_mensagens    = $service_mensagens; 
        $this->midia_service        = $midia_service; 
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
        //$msg_validator = $this->validator->mensagens_cadastro;        
        $msg_validator  = $this->service_mensagens->mensagens_cadastro;

        try {
                        
            // Criptografar a senha 
            if(isset($data['password'])) $data['password'] = bcrypt($data['password']);            
            
            //Campo remember_token
            if(isset($data['remember_token'])) $data['remember_token'] = Str::random(60);            
            
            //Setando o campo resumo para o google default:
            $data['resumo'] = $data['titulo'] + ": as melhores frases curtas, para status e frases bonitas estão aqui! " + $data['titulo'] + " da publicação para compartilhar.";
            //tratativa para o campo resumo
            $Post    = Post::create($data);            
            $mensagem   = $msg_validator['Posts_cadastro_sucesso'];
            $titulos    = $this->validator;
            return [
                'sucesso'       => true,
                'titulo_msg'    => "",
                'msg'           => $mensagem,
                'registro'      => $Post->toArray(),
            ];            

        } catch (ValidatorException $e) {

            $mensagem = $msg_validator['Posts_cadastro_erros'];
            return [
                'sucesso'       => false,
                'titulo_msg'    => $mensagem,
                'msg'           => $e->getMessageBag(),
            ];
        }
    }

    public function update($request, $id)
    {
        try {              
            $dados = $request->all();
            $msg_validator = $this->service_mensagens->mensagens_cadastro;
            $Post = Post::find($id);
            $Post->update($dados);
            return [
                'sucesso'  => true,
                'titulo_msg'  => $msg_validator['titulo_sucesso'],
                'msg'       => $msg_validator['update_sucesso'],
                'registro' => $Post,
            ];            

        } catch (ValidatorException $e) {
            return [
                'sucesso'       => false,
                'titulo_msg'    => $msg_validator['posts_update_erros'],
                'msg'           => $e->getMessageBag(),
            ];
        }
    }

    public function delete($id)
    {        
        $msg_validator      = $this->service_mensagens->mensagens_cadastro;
        try {        
            $deleted = Post::find($id); if($deleted) $deleted->delete();  
            return [
                'sucesso'  => true,
                'msg'      => $msg_validator['delete_sucesso'],
                'registro' => null,
            ];            

        } catch (ValidatorException $e) {
            return [
                'sucesso'       => false,
                'titulo_msg'    => $msg_validator['posts_delete_erros'],
                'msg'           => $e->getMessageBag(),
            ];
        }
    }
    public function extraiStringCorpo($id, $corpo, $listaId)
    {
        $arr_lista_iten=[];
        $arr_str_corpo=[];
        $ordem=0;
        $aux_1="";
        $linhas = explode("&&",$corpo) ;
        foreach ($linhas as $linha ) { 
            $i=0;        
            $idFrase    = 0;
            $fraseArrr  = explode("||",$linha);
            if ($linha!="")                
                if(substr(trim($linha),0,9) =="<anuncio>"){
                    $frases = Frases::find('1');
                        if ($frases){                         
                            $ordem++;
                            array_push($arr_str_corpo,[
                                "frase" => $frases->id,
                                "ordem" => $ordem,
                                "tipo" => "2",
                                "aux_1" => $aux_1,
                                "mostraimg" => false,
                            ]);                                
                        }
                }
                else if (substr(trim($linha),0,9) =="<convite>") {  
                    $frases = Frases::find('1');
                        if ($frases){                         
                            $ordem++;
                            array_push($arr_str_corpo,[
                                "frase" => $frases->id,
                                "ordem" => $ordem,
                                "aux_1" => $aux_1,
                                "tipo" => "4",
                                "mostraimg" => false,
                            ]);                                
                        }
                }
                if (isset($fraseArrr[1])){
                    
                    $idFrase = str_replace("id:", "", $fraseArrr[1]);                
                    
                    if($idFrase>0) {           
                        
                        $frases = Frases::find($idFrase);
                        if ($frases){                         
                            $ordem++;
                            array_push($arr_str_corpo,[
                                "frase" => $frases->id,
                                "ordem" => $ordem,
                                "aux_1" => $aux_1,
                                "tipo" => "1",
                                "mostraimg" => false,
                            ]);                                
                        }                     
                    }       
                    
                }
        }
        //passo dois: pegar o post itens
        $lista_itens = ListaItem::where ('lista_id', $listaId)->get();
        $ordem=0;
        foreach ($lista_itens as $key => $lista_item) {
            # code...
            $frase = Frases::where("id_origem", $lista_item->id)->first();
            if (isset($frase)){ 
                $ordem++;
                array_push($arr_lista_iten,[
                    "frase" => $frase->id,
                    "ordem" => $ordem,
                    "tipo" => "1",
                    "mostraimg" => false,
                ]);                                
             }
        }        
        echo "Numero de itens no array do corpo: " . count($arr_str_corpo) . " <br> " ;

        echo "Numero d intes no Lista_itens:" .  count($arr_lista_iten);        
        echo "<br><br><br>";
                
        

        if(count($arr_str_corpo) >= count($arr_lista_iten))
            return $arr_str_corpo;
        else 
            return $arr_lista_iten;
    }

    public function arrayStringCorpo($id, $corpo, $listaId)
    {
        # code...        
        $arr_str_corpo=[];
        $ordem=0;
        $linhas = explode("&&",$corpo) ;

        //frases na tabela post_itens
        //ve se nao ta tabela post_item com outro ID
        $postsItensAux = PostsItens::where(
            [
                ['post_id',$id],                
            ]
        )->get();
        $frasesDaPostItem=[];
        foreach ($postsItensAux as $key => $item) {
            # code...
            $frases = Frases::find($item->frase_id);
            if($frases){
                array_push($frasesDaPostItem,[                   
                    "id" => $item->id,
                    "frase" => $frases->frase,
                    "substr_frase" => substr($frases->frase,0,20),
                    "aux_2" => $item->aux_2,
                ]);
            }
        }


        foreach ($linhas as $linha ) { 
            $i=0;        
            $idFrase    = 0;
            $fraseArrr  = explode("||",$linha);
            $presente="false";

            if ($linha!="")
                
                if (isset($fraseArrr[1])){
                    
                    $idFrase = str_replace("id:", "", $fraseArrr[1]);
                    $aux_frase = str_replace("||id:", "", $linha);
                    $aux_frase = str_replace("||", "", $aux_frase);
                    $aux_frase = str_replace("\r", "", $aux_frase);
                    $aux_frase = str_replace("\n", "", $aux_frase);
                    $presenteNA  = "NA";
                    //$aux_frase = str_replace($idFrase, "", $aux_frase);
                    
                    if($idFrase>=0) {           
                        
                        $substr_frase = substr($aux_frase,0,20);

                        $frases = Frases::find($idFrase);
                        if ($frases){                         
                            $ordem++;                            
                            $postsItens = PostsItens::where(
                                [
                                    ['post_id',$id],
                                    ['frase_id',$frases->id]
                                ]
                            )->get();

                             //dd(count($postsItens),$id, $frases->id);
                            if(count($postsItens)>0){
                                $presente="true";
                            } else{
                                foreach ($frasesDaPostItem as $key => $item) {
                                    # code...
                                    if(in_array($substr_frase, $item)){
                                        $presente = "CAD";                                   
                                    }
                                }
                            }
                            array_push($arr_str_corpo,[
                                "frase_id" => $frases->id,
                                "frase" => $frases->frase,
                                "ordem" => $ordem,                                
                                "tipo" => "1",
                                "presente" => $presente,
                            ]);                                
                        }
                        else{
                            
                            
                            foreach ($frasesDaPostItem as $key => $item) {
                                # code...
                                if(in_array($substr_frase, $item)){
                                    $presenteNA = "CAD";                                   
                                }
                            }

                            array_push($arr_str_corpo,[
                                "frase_id" => $idFrase,
                                "frase" => $aux_frase,
                                "ordem" => $ordem,                                
                                "tipo" => "1",
                                "presente" => $presenteNA,
                            ]);                         
                        }                     
                    }       
                    
                }
        }        
        //buscar duplicidade nos registros
        $temp_arr_str_corpo=[];
        $index=0;
        foreach ($arr_str_corpo as $key => $item) {
            # code...
            $aux = substr($item["frase"],0,20);
            array_push($temp_arr_str_corpo,[                   
                "frase" => $aux,  
                "index" => $index                 
            ]);
            $index++;            
        }     
        
        $duplicates = $this->getDuplicates($temp_arr_str_corpo, $arr_str_corpo);        
        
        return $duplicates;
        
    }
    public function getDuplicates($array,$arr_str_corpo)    
    {
       
        $count=0;
        $aux_arr = array_count_values(array_column($array, 'frase'));
        foreach ($aux_arr as $key => $value) {
            # code...
            if($value>1){
                $arr_str_corpo[$count]["presente"] = "DTXT";
            }
            $count++;                
        } 

        return $arr_str_corpo;
        //return array_unique( array_diff_assoc( $array, array_unique( $array ) ) );
    }
}
?>