<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Entities\Lista;
use App\Entities\ListaItem;
use App\Entities\Frases;
use App\Entities\Midia;
use App\Services\ClearString;
use App\Services\Retornos;

/**
 * Class ListaService.
 *
 * @package namespace App\Services;
 */
class ListaService 
{
    protected $retornos;
    protected $clearstring;
    public function __construct(Retornos $retornos, ClearString $clearstring)
    {
        $this->retornos             = $retornos; 
        $this->clearstring          = $clearstring; 
    }
    public function store($request)
    {
        $dados = $request->all();
        try {
            $lista = Lista::create($dados);
            if($lista){
                // $this->uploadBiblioteca($request, $lista->id);
                $this->gravaListaItem($dados, $lista->id);
            }            
            return $this->retornos->Try($lista);            

        } catch (\Throwable $e) {   
            return $this->retornos->Catch($e);
        }
    }
    public function update($request, $id)
    {
        try {
            if ($request['status'] == "9"){
                $lista = Lista::find($id);
                $lista->update($request);
                return $this->retornos->Try($lista, "delete");                
            }
            if (isset($request['capa'])):            
                $unsplash   = explode("images.unsplash.com",$request['capa']);
                $biblioteca = explode("public/images/",$request['capa']);
                if(count($unsplash)>1 || count($biblioteca)>1):
                    $request['midia_id'] = 0;            
                endif;
            endif;
            $lista = Lista::find($id);
            $lista->update($request->all());
            if($lista){                
                // $this->uploadBiblioteca($request, $id);                
                $this->gravaListaItem($request, $lista->id);
            }
            return $this->retornos->Try($lista, "update");                      
        } catch (\Throwable $e) {
            return $this->retornos->Catch($e);            
        }
    }
    public function uploadBiblioteca($request, $id)
    {        
        $i_have_file = false;
        $titulo="";
        $unsplashIdFotoAtual = "";
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $i_have_file=true;
            $imagemTemporaria=$request->file('file')->getPathName();
            $extension      = $request->file->extension();
            $titulo = Str::kebab($request->file('file')->getClientOriginalName());
        }
        $data = $request->all();

        if($data['result'] != "") {            
            $i_have_file=true;
            $titulo = Str::kebab("lista".$id.".jpg");
        }
        if($data['unsplashIdFotoAtual'] != "") {
            $aux = explode("&id=",$data['unsplashIdFotoAtual']);
            if(count($aux)>1)
                $unsplashIdFotoAtual=$aux[1];
        }
        if ($i_have_file)
        {   
            $nomeCompleto   = "lista".$id.".jpg";
            $imgCrop        = "";
            if($data['result'] != "") {
                $imagemTemporaria=$data['result'];                    
                $extension = "jpg";
            }                    
            else
                $imagemTemporaria=$request->file('file')->getPathName();

            //Upload  - 2) Criar um Objeto Img Jpeg com base na 
            switch ($extension) {
                case 'jpg':
                    $im = imagecreatefromjpeg($imagemTemporaria);
                    break;

                case 'jpeg':
                        $im = imagecreatefromjpeg($imagemTemporaria);
                        break;
                
                case 'png' :
                    $im = imagecreatefrompng($imagemTemporaria);
                break;   

                case 'gif' :
                    $im = imagecreatefromgif($imagemTemporaria);
                break;  

                case 'webp' :
                    $im = imagecreatefromwebp($imagemTemporaria);                    
                break;   
                
                default:
                    $im = imagecreatefromjpeg($imagemTemporaria);
                    break;
            }            
            //variavel como será inserida no banco - Substituir o processo de Upload 
            $upload="usuarios/".$request['usuario_id']."/lista".$id.'.jpg';            
            $upload_thumb="/storage/usuarios/".$request['usuario_id']."/lista".$id.'_thumb.jpg';            
            
            if($upload){

                //procurar a Midia;                    
                //$save_to_path=asset("storage/usuarios/".$request['usuario_id'].'/'. $nomeCompleto);

                //Upload - 3) Definir o caminho do arquivo e o nome
                $save_to_path       ="storage/usuarios/".$request['usuario_id']."/lista".$id.'.jpg';
                $save_to_path_thumb ="storage/usuarios/".$request['usuario_id']."/lista".$id.'_thumb.jpg';

                //HERE ImgCrop system
                $thumbCrop = $im; //$\App\Service\ImgCrop::thumb($im,340,340); 
                //pendente              

                //Upload  - 4) Criar a imagem no formato 
                imagejpeg($im, $save_to_path,40);
                imagejpeg($thumbCrop, $save_to_path_thumb,40);
                
                //Upload  - 5) Destruir o objeto criado
                imagedestroy($im);
                imagedestroy($thumbCrop);
                                
                $midia = Midia::find($request['midia_id']);
                
                if(!$midia){
                    $midia = Midia::create([
                        'tipo'         => '3',
                        'titulo'       => $titulo, 
                        'url'          => $upload,
                        'status'       => '0',                            
                        'usuario_id'   => $request['usuario_id'],                            
                        'em_uso'       => $id,
                        'aux_2'        => $unsplashIdFotoAtual,
                    ]);
                } else {                    
                    $midia['url']   = $upload;  
                    $midia['aux_2'] = $unsplashIdFotoAtual;
                    $midia->save();
                }
                
            }
            //salvar o campo mídia na tabela Listas
            //deletar o campo capa
            $lista = Lista::find($id);
            if ($lista):                    
                if ($midia){
                    $lista->midia_id    = $midia['id'] ? $midia['id'] : "";
                    $lista->thumb       = $upload_thumb;                    
                }                    
                $lista->capa  = "";
                $lista->save();
            endif;
        }
        return true;
    }
    public function delete($id)
    {        
        try { 
            $listaItem = ListaItem::where('lista_id', '=',  $id)->get();            
            foreach ($listaItem as $key => $item) {                # code..                
                $item->delete($id);
            }
            $deleted = Lista::find($id);
            if($deleted)
                $deleted->delete();          
            return $this->retornos->Try(null, "delete");

        } catch (\Throwable $e) {
            return $this->retornos->Catch($e,"delete");            
        }
    }
    public function gravaListaItem($data, $lista_id)
    {   
        $lista_itens = explode("#lista_itens#",$data['lista_itens']);

        
        $request =[];
        foreach ($lista_itens as $key => $item) {
            if($item!=''):
                $linha          = explode("#elemento#", $item);
                $id             = $linha[0];
                $frase          = $linha[1];
                $frase_id       = $linha[2];                        
                $autor          = $linha[3];                

                array_push($request,[
                    'id'       => $id,
                    'frase'    => $frase, 
                    'frase_id' => $frase_id, 
                    'autor'    => $autor, 
                    'lista_id' => $lista_id,
                    'status'   => 0,           
                ]);                                                
            endif;
        }
        foreach ($request as $key => $req) {
            if($req['id']==0):
                $dados = new ListaItem;
                $dados->frase          = $req['frase'];
                $dados->autor          = $req['autor'];
                $dados->lista_id       = $req['lista_id'];
                // $dados->frase_id       = $this->getFraseID($req['frase_id'],$req['frase']);
                $dados->status         = 0;               
                $dados->save();                
            else:
                $dados = ListaItem::find($req['id']);
                if($dados){
                    $dados->frase          = $req['frase'];
                    $dados->autor          = $req['autor'];                                      
                    // $dados->frase_id       = $this->getFraseID($req['frase_id'],$req['frase']);                        
                    $dados->save();
                }
            endif;           
        }
        $deletados = explode(";",$data['deletados']);        
        if(isset($deletados) && $deletados!=''){            
            foreach ($deletados as $deleta) {   
                $listaItem = ListaItem::find($deleta);             
                if($listaItem)
                    $listaItem->delete();
            }
        }                
    }
    public function getFraseID($frase_id,$frase)
    {
        if ($frase_id): 
            if($frase_id>0){
                return $frase_id;
            }
        endif;
        /**
         * Buscar a Frase por TOKEN
         */        
        $token = $this->clearstring->geraChave($frase);
        $avail= Frases::where("token","=",$token)->first();
        if($avail)
            return $avail->id;        
        return 0;
    }
    public function criaNovaFrase($req)
    {
        $ClearString= new ClearString;
        $aux = $ClearString->limpaCaracteresEspeciais($req['frase']);
        $dados = new Frases;
            $dados->frase               = $req['frase'] ;
            $dados->url_longa_amigavel  = $aux;
            $dados->origem              = "1" ; //1. Origem das Listas de Frases
            $dados->autor               = $req['autor'];
            $dados->id_origem           = $req['id'];
            $dados->status              = 1;
        $dados->save(); 
        return $dados->id;
    }
}

?>

        