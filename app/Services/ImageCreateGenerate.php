<?php
/****
 * 
 * ● Projeto2023Apr05 - Desativar a alteração de nome do arquivo mobile em renomear nome da imagem para as frases
 * 
 */
namespace App\Services;

use App\Entities\Frases;
use App\Services\ClearString;
use App\Services\PipifFunctions;

/**
 * Class ImageCreateGenerate.
 * Classe para criação de imagens de Frases
 * 
 * @package namespace App\Services;
 * @author  LM
 * @link    https://docs.google.com/document/d/1aerE_1MG7WRBw45WWiTVWBGIBJWln05VWjKdMw3g1rI/edit?usp=sharing
 * @version 1.0.0 - Ago-2020
 */
class ImageCreateGenerate {    

    protected $tamanhofonte;
    protected $tamanhofonteAutor;
    protected $qtLetrasPorLinha;
    protected $margens;
    protected $pdTopo;
    protected $fonte;
    protected $fonteAutor;
    

    public function __construct()
    {
        /**
         * usando o methodo construtor, vc não precisa fazer o seguinte:
         * $repository = new ListaRepository();
         */
        $this->tamanhofonte      = 40;
        $this->tamanhofonteAutor = 22;
        $this->qtLetrasPorLinha  = 22;
        $this->pdTopo            = 80;       
        $this->margens = [
            "topo"      => "20",
            "right"     => "20",
            "bottom"    => "20",
            "left"      => "20",
        ];       

        //refatorar: pegar da pasta Storage/frase/templates          
        $this->fonte = 'storage/frases/template/LatoBold.ttf';         
        $this->fonteAutor = 'storage/frases/template/LatoLightItalic.ttf';         
        
    }
    public function transformaEmWebp($tipo, $id, $capa, $usuario_id){
        $return =[];        
        $limpeza = explode("?ver=",$capa);
        if(isset($limpeza[1])) 
            $capa = $limpeza[0];
        $extensao=explode(".",$capa);
        // Testar o tipo de transformação   ???
        // testar o formato da imagem   ??? 
        // alterar a extensão do arquivo para webp
        // criar o objeto im
        // criar o arquivo webp fisicamente
        // testar se o arquivo existe
        if($tipo=="f"){
            $save_to_path = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$capa);                        

        } else{
            //bsucar o endereço local da imagem de capa da lista            
            //$save_to_path ="storage/usuarios/".$usuario_id."/capa_pasta_".$id.'.jpg';             
            $save_to_path = \storage_path(). "/app/public/usuarios/" . str_replace('/storage/usuarios/','',$capa);                        

        }
        
        if(!file_exists($save_to_path)){            
            $return = [
                "sucess" => false,            
                "imagemConvertida" => $capa,            
            ];
            return $return; 

        }
        //testar a extensão;
        if(!isset($extensao[1])){
            $return = [
                "sucess" => false,            
                "imagemConvertida" => $capa,            
            ];
            return $return; 
        }
        switch ($extensao[1]) {
            case 'png':
                $im = imagecreatefrompng($save_to_path);        
                $nomeDaImagem = str_replace("png", "webp", $capa);       
                break;

            case 'jpg':
                $im = imagecreatefromjpeg($save_to_path); 
                $nomeDaImagem = str_replace("jpg", "webp", $capa);                
                break;
            case 'jpeg':
                $im = imagecreatefromjpeg($save_to_path);        
                $nomeDaImagem = str_replace("jpeg", "webp", $capa);       
                break;
            case 'webp':
                # code...
                $return = [
                    "sucess" => false,            
                    "imagemConvertida" => $capa,            
                ];
                return $return;
                break;
            default:
                $return = [
                    "sucess" => false,            
                    "imagemConvertida" => $capa,            
                ];
                return $return;
                break;
        }
        $nomeDaImagem = substr($nomeDaImagem, 1,strlen($nomeDaImagem));
        imagewebp($im,  $nomeDaImagem, 90 );        
        imagedestroy($im);
        $return = [
            "sucess" => true,            
            "imagemConvertida" => "/".$nomeDaImagem,            
        ];
        return $return; 
    }
    
    public function verificaWebpPendente($capa)
    {
        $copy           ="";
        $logException   =[];  
        $return         =[];
        $execucao       =0;   
        $capaArr        =explode("?",$capa);
        $lWebp          =false;
        $lpendwebp      =false;
        if(isset($capaArr[0]))
            $capa=$capaArr[0];

        $file_to_search                = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$capa);        
        $file_to_searcheWebP           = $file_to_search.".webp";
        $file_to_searchWebpPendente    = $file_to_search."_pdwebp.jpg";        

        if(file_exists($file_to_search)){
            if(file_exists($file_to_searcheWebP)) $lWebp=true;
            if(file_exists($file_to_searchWebpPendente)) $lpendwebp=true;

            if(!$lWebp && !$lpendwebp){            
                $copy = copy($file_to_search, $file_to_search."_pdwebp.jpg");        
            }
            $return = [
                "execucao" => $execucao,
                "copy"     => $copy,
                "logException" => $logException
            ];
        }        
        return $return;        
    }
    public function renameFile($type,$alt,$capa,$id=null)
    {
        $logException=[];  
        $execucao=0;   
        $copy="";   


        if($type=="frase"){
            $ClearString       = new ClearString;
            $alt             = $ClearString->limpaCaracteresEspeciais($alt);
            $extensao        = ".jpg";

            if (strpos($capa, '.png') !== false) $extensao = ".png";
            if (strpos($capa, '.webp') !== false) $extensao = ".webp";

            $capaArr         = explode("?",$capa);
            $newCapa         = "/storage/frases/".$alt."-".$id."$extensao";
            if(isset($capaArr[0]))
                $capa=$capaArr[0];


            $file_to_replace = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$capa);
            $newName         = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$alt."-".$id."$extensao");

            //significa que para esta frase já foi gerado webp, devemos apenas renomear este arquivo
            $file_to_replaceWebP = $file_to_replace.".webp";

            // ● Projeto202207 - LM 26-ago-22 - Processos, Alterar o nome da imagem jpeg de download também, quando alterarmos o nome fisico da imagem de capa
            $download = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$capa) . "_download.jpg";


            // dd($download, $newName);
            if(file_exists($download)){
                rename($download, $newName."_download.jpg");
            }
            
           // desativar a geração do mobile rename

            // // buscar a imagem no padrão antigo
            // $mobile = "frase_".$id."_01.webp_mobile.webp";
            // $mobile = \storage_path(). "/app/public/frases/" . $mobile;


            // // Projeto20221201 - caso a imagem mobile não exista no padrão antigo, buscar no padrão atual
            // if(!file_exists($mobile)){
            //     $mobile = $file_to_replace . "_mobile.webp";
            // }
            
            // //● Projeto20221201 - 12-12-22 - Garantir que a imagem mobile sempre exista, indiferente de onde é executado.
            // if(!file_exists($mobile)){
            //     $im = PipifFunctions::getImgObject($capa,$file_to_replace);
            //     $arrMobile = PipifFunctions::gerarMobileIMageStatic($im,$newName,"bg","100",$capa);
            // }

            // rename($mobile, $newName."_mobile.webp");
            
            if (file_exists($file_to_replace)){
                array_push($logException,[
                    "descr" => "file repleced",
                    "file" => $file_to_replace,
                    "newCapa" => $newCapa,
                    "newMobile"     => $newCapa."_mobile.webp",
                    /*Projeto20221201 - 12-12-22 - 
                    * - Garantir que ao renomear a imagem principal da frase,
                    *   também seja renomeado o arquivo de download. 
                    *   Já estava sendo alterado o nome físico do arquivo, porém não estava gravando no DB
                    */ 
                    "newDownload"   => $newCapa."_download.jpg",
                    "type" => "webp"
                ]);
                $execucao = rename($file_to_replace, $newName);
                /**
                 * quando for renomeado o arquivo original devemos:
                 * - renomer o arquivo webp também (caso exista)
                 * - renomear o arquivo _pdwebp.jpg (caso exista) (retirar em 26-ago-22)
                 * - e Gerar o arquivo pendente Webp ainda não exista (retirar em 26-ago-22)
                 */

                if(file_exists($file_to_replaceWebP)){
                    rename($file_to_replaceWebP, $newName.".webp");
                }

                // if(file_exists($file_to_replaceWebpPendente)){
                //     rename($file_to_replaceWebpPendente, $newName."_pdwebp.jpg");
                //     $lpendRenomed=true;
                // }    

                // if(!$lpendRenomed && !$lWebpRenomed){
                //     $copy = copy($newName, $newName."_pdwebp.jpg");
                // }
                $this->generateLogFrasesUpdate($id,"R");
                
            }
            else {
                array_push($logException,[
                    "descr" => "file not Found",
                    "file" => $file_to_replace,
                    "newCapa" => "",
                    "type" => "webp"
                ]);
            }            
        }
        $return = [
            "execucao" => $execucao,
            "copy"     => $copy,
            "logException" => $logException
        ];
        return $return;
    }
    public function run($nome,$texto,$autor = null, $tipo_imagem = "0"){

        # code...
        $clearstring = new ClearString;
        
        $texto = $clearstring->limpeza($texto);
        $texto = $this->limpeza($texto);
        $texto = urldecode($texto);                 
        $texto = $clearstring->removeEmoji($texto);        
        $totCaracteres = strlen($texto);    
        $data = Array();
        if ($totCaracteres < 100):
            //normal box 612
            $src = $this->imageDefault($totCaracteres,$nome,$texto,$autor,$tipo_imagem);
        else:
            //tamanho maior com marca dágua
            $src = $this->imageBig($totCaracteres,$nome,$texto,$autor,$tipo_imagem);
        endif;

        $copy = $this->createPdwebp("$src");

        $data["srcIgm"] = $src;
        return $data;
    }
    public function createPdwebp(String $src) 
    {
        $file = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$src);        
        if(!file_exists($file))
            $file = \storage_path(). "/app/public/frases/" . str_replace('storage/frases/','',$src);                
        return copy($file, $file."_pdwebp.jpg");
    }
    public function generateLogFrasesUpdate($id, $action)
    {
        # code..
        $fileToLog = \storage_path(). "/app/public/frases/action_".$action."_frase_".$id.".log";        
        $fileBuild = $action.";frase_".$id."\n";            
        $fp = fopen($fileToLog, 'w');
        fwrite($fp, $fileBuild);
        fclose($fp);
        // $fisicoFile = \storage_path(). "/app/public/frases/action_".$action."_frase_".$id.".log";
        // if (file_exists($fisicoFile)){
        //     $fileBuild = $action.";frase_".$id."\n";            
        //     $fp = fopen($fisicoFile, 'a');
        //     fwrite($fp, $fileBuild);
        //     fclose($fp);            
        // }

    }
    public function preDeleteImageFrases($id)
    {
        $lok = false;
        $frase = Frases::find($id);
        $arquivo_que_sera_deletado="";
        $arquivo_antigo="";

        if($frase){
            $arquivo_antigo = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',"frase_".$id."_01.jpg");
            if ($frase->cdn!=1 && $frase->capa!="")                    
                $arquivo_que_sera_deletado = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$frase->capa);

            if (file_exists($arquivo_que_sera_deletado)){
                unlink($arquivo_que_sera_deletado);
                $lok = true;
            }

            // deletar o arquivo webp e pendente.webp
            if (file_exists($arquivo_que_sera_deletado.".webp")){
                unlink($arquivo_que_sera_deletado.".webp");
                $lok = true;
            }                
            if (file_exists($arquivo_que_sera_deletado."_pdwebp.jpg")){
                unlink($arquivo_que_sera_deletado."_pdwebp.jpg");
                $lok = true;
            }                

            if (file_exists($arquivo_antigo)){
                unlink($arquivo_antigo);
                $lok = true;
            }

            if (file_exists($arquivo_antigo.".webp")){
                unlink($arquivo_antigo.".webp");
                $lok = true;
            }                
            if (file_exists($arquivo_antigo."_pdwebp.jpg")){
                unlink($arquivo_antigo."_pdwebp.jpg");
                $lok = true;
            }            
        }
        return $lok;
    }

    public function runChangeFormat($origem,$id,$usuario_id,$texto,$formato){

        # code...        
        if ($origem == "unsplash") { 
            $src = str_replace("webp",$formato,$texto);            
        }  

        else if ($origem == "upload") {
            $src = "/" . $this->upload($usuario_id,$texto,$formato,$origem);
            //$src = $this->imageBig($totCaracteres,$nome,$texto,$autor);            

        }
        else if ($origem == "biblioteca") {
            //criar objeto do tipo imagem com o endereço
            //fazer o upload
            //salvar na tabela midia o arquivo
            //retornar o arquivo src
            $src = "/" . $this->upload($usuario_id,$texto,$formato,$origem);            
        }   
        else {}
        $data["srcIgm"] = $src;
        return $data;
    }
    public function upload($autor_id,$texto,$formato,$origem)
    {
        $fileToReplace = $texto;
        $im = imagecreatefromwebp($fileToReplace);        
        $src = str_replace("webp",$formato,$texto);        
        
        $src = str_replace("http://localhost/","",$src);
        $src = str_replace("http://192.168.15.107/","",$src);
        $src = str_replace("http://listafrases.dev.io/","",$src);
        $src = str_replace("https://fraseteca.com.br/","",$src);

        imagejpeg($im,  $src, 70 );
        //destroy
        imagedestroy($im);        
        return $src;
        

        //retornar o arquivo src
    }
    public function imageDefault($totCaracteres, $nome,$texto,$autor,$tipo_imagem) {
        //Definir o tamanhoDafonte e o nº de caracteres em cada linha
        $tamanhofonte       = $this->tamanhofonte;        
        $qtLetrasPorLinha   = $this->qtLetrasPorLinha ;
        $pdTopo             = $this->pdTopo ;
        $fonte              = $this->fonte ;
        $vLinha             = 300;
        $fatorPulo          = 30;
        $areaDoTexto        = 560;
        $nLinhas = $this->getnLines($texto, $tamanhofonte,$fonte,0, $pdTopo, $areaDoTexto);

        if($autor){
            $nLinhas++;
            $pdTopo = ceil($vLinha  - ( $fatorPulo * ($nLinhas)));
        }            
        else
            $pdTopo = ceil($vLinha  - ( $fatorPulo * ($nLinhas - 1)));

        $randow=rand(1,10);
        if ($tipo_imagem=="0") $randow=rand(1,23);
        if ($tipo_imagem=="1") $randow=rand(1,15);
        if ($tipo_imagem=="2") $randow=rand(1,5);
        if ($tipo_imagem=="3") $randow=rand(1,5);
        //refatorar: pegar da pasta /storage/frases/template
        $arqTemplate = "storage/frases/template/".$tipo_imagem."/template612_612_$randow.jpg";

        //criando a imagem
        $im     = imagecreatefromjpeg($arqTemplate);
        if ($tipo_imagem!="2") {
            $cor    = imagecolorallocate( $im, 255, 255, 255 );
            imagecolorallocate($im, 255, 255, 255);
        }
        else {
            $cor    = imagecolorallocate( $im, 0, 0, 0 );
            imagecolorallocate($im, 0, 0, 0);
        }

        $this->writeMultilineText($im, $tamanhofonte, $cor, $fonte, $texto, $autor, $this->tamanhofonteAutor, 40, $pdTopo, $areaDoTexto,10,0);
        
        //refatorar: local de destino de salvamento do arquivo da frase
        $imgSrc = "storage/frases/".$nome.".jpg";
        //imagewebp($im,  $imgSrc, 90 );            
        imagejpeg($im,  $imgSrc, 70 );        
        //destroy
        imagedestroy($im);   
        return $imgSrc;      
    }
    public function imageBig($totCaracteres, $nome,$texto,$autor,$tipo_imagem) {
        
        $qtLetrasPorLinha   = $this->qtLetrasPorLinha ;
        $pdTopo             = $this->pdTopo ;
        $fonte              = $this->fonte ;
        $tamanhofonte       = 27;        
        $nLinhas            = ceil($totCaracteres / $qtLetrasPorLinha);
        $textoaux           = wordwrap($texto, 18, "\n");

        //if ($autor) $textoaux.= "\n" . '"' . $autor . '"';

        $size               = imagettfbbox($tamanhofonte, 0, $fonte, $textoaux);
        $xsize              = abs($size[0]) + abs($size[2])+20;
        $ysize              = abs($size[5]) + abs($size[1])+20;

        //area total da imagem
        $im                 = imagecreatetruecolor($xsize + 80, $ysize +200);
        $cor                = imagecolorallocate( $im, 0, 0, 0 );        

        //background        
        $background = "storage/frases/template/".$tipo_imagem."/bg.jpg";
        list($src_w,$src_h,$src_type) = getimagesize($background);        
        $src = imagecreatefromjpeg($background);

        //duplicando o Bg (repeat)
        $curr_y = 0;
        while($curr_y < ( $ysize + 200)){
            imagecopy($im, $src, 0, $curr_y, 0, 0, $xsize + 80, $ysize + 200);
            $curr_y += $src_h;
        }
        //MarcaDágua        
        $marcadagua = "storage/frases/template/marcadagua.gif";
        $marcadagua_src = imagecreatefromgif($marcadagua);
        imagecopymerge( $im, $marcadagua_src, 140, $ysize + 110, 0, 0, 117, 70, 100);

        //Escrever o Texto
        $padtop = abs($size[5])+60;
        imagettftext($im, $tamanhofonte, 0, abs($size[0])+40, $padtop, $cor, $fonte, $textoaux);
        $start_xx = 50;
        $start_y = $ysize ;

        //Impressão do autor
        if ($autor) {
            //$autor = '— ' . $autor . ' —'; 
            $font_autor_width = $tamanhofonte - 12;
            $start_x =80;

            $autorDim = imagettfbbox($font_autor_width, 0, $this->fonteAutor, $autor); 
            $start_xx = $start_x + round(($xsize - $autorDim[4] - $start_x) / 2); 

            imagettftext($im, $font_autor_width, 0, $start_xx , $start_y + 70, $cor, $this->fonteAutor, $autor);
        }

        //refatorar: local de destino de salvamento do arquivo da frase        
        $imgSrc = "storage/frases/".$nome.".jpg";
        imagejpeg($im,  $imgSrc, 70 );
        //destroy
        imagedestroy($im);        
        imagedestroy($src);        

        return $imgSrc;

    }

    public function writeMultilineText($image, $font_size, $color, $font, $text,$autor,$font_autor_width, $start_x, $start_y, $max_width,$quebra,$startX) { 
        //split the string 
        //build new string word for word 
        //check everytime you add a word if string still fits 
        //otherwise, remove last word, post current string and start fresh on a new line 
        $words = explode(" ", $text); 
        $string = ""; 
        $tmp_string = ""; 
        $start_xx = 68 ;
        $curr_width= "";
    
        for($i = 0; $i < count($words); $i++) { 
            $tmp_string .= $words[$i]." "; 
    
            //check size of string 
            $dim = imagettfbbox($font_size, 0, $font, $tmp_string); 
    
            if($dim[4] < ($max_width - $start_x)) { 
                $string = $tmp_string; 
                $curr_width = $dim[4];
            } else { 
                $i--; 
                $tmp_string = ""; 

                if($curr_width > 480)
                    $start_xx = 58;                
                // dd(
                //     $max_width - $curr_width - $start_x,
                //     $max_width,
                //     $curr_width,
                //     $start_x, 
                //     $start_xx,
                //     $string
                // );
                //$start_xx =  round(($max_width - $curr_width - $start_x) / 2) ;        
                //$start_xx = $start_x + round(($max_width - $curr_width - $start_x) / 2);        
                imagettftext($image, $font_size, 0, $start_xx, $start_y, $color, $font, $string); 
    
                $string = ""; 
                //$start_y += abs($dim[5]) + $quebra * 2; 
                $start_y += 30 * 2; 
                $curr_width = 0;
            } 
        } 
    
        
        //$start_xx = $start_x + round(($max_width - $dim[4] - $start_x) / 2);           
        imagettftext($image, $font_size, 0, $start_xx, $start_y, $color, $font, $string);

        if ($autor){
            $autorDim = imagettfbbox($font_autor_width, 0, $font, $autor); 
            //$start_xx = $start_x + round(($max_width - $autorDim[4] - $start_x) / 2);        
            
            imagettftext($image, $font_autor_width, 0, $start_xx , $start_y + 50, $color, $font, $autor);
        }
    }    

    public function getnLines($texto, $tamanhofonte,$fonte,$start_x, $start_y, $max_width) {
        # code...
        $words = explode(" ", $texto); 
        $string = ""; 
        $tmp_string = ""; 
        $nlinhas=1;

        for($i = 0; $i < count($words); $i++) { 
            $tmp_string .= $words[$i]." "; 

            $dim = imagettfbbox($tamanhofonte, 0, $fonte, $tmp_string);            
            if($dim[4] < ($max_width - $start_x)) { 
                $string = $tmp_string; 
                $curr_width = $dim[4];
            } else { 
                $i--; 
                $tmp_string = ""; 
                $string = "";             
                $curr_width = 0;
                $nlinhas++;
            } 
        }
        return $nlinhas;

    }
    public function limpeza($string)
    {       
       //Caracteres especiais
       $string = str_replace("🚶‍♀","",$string);
       $string = str_replace("“","",$string);
       $string = str_replace("”","",$string);
       $string = str_replace(chr(10),"",$string);
       $string = str_replace("❤️","",$string);
       $string = str_replace("⛔️","",$string);
       $string = str_replace("✌️","",$string);
       $string = str_replace("⭐️","",$string);
       $string = str_replace("⚽️","",$string);
       $string = str_replace("🏋️‍♀️","",$string);
       $string = str_replace("⛹️‍♀️","",$string);
       $string = str_replace("🏊‍♀","",$string);
       $string = str_replace("⛹️‍♀️","",$string);
       $string = str_replace("⛺️","",$string);
       $string = str_replace("☹️","",$string);
       $string = str_replace("🏃‍♀","",$string);
       $string = str_replace("🤷‍♀","",$string);
       $string = str_replace("♥️","",$string);
       $string = str_replace("🤷🏼‍♀️","",$string);
       $string = str_replace("💭","",$string);
       $string = str_replace("💬","",$string);
       $string = str_replace("👩‍💼","",$string);
       $string = str_replace("⁠","",$string);
       $string = str_replace("⁠","",$string);
       $string = str_replace("&#8288;","",$string);
       $string = str_replace("&nbsp;","",$string);
       



       //🙏🙌💪🏃‍♀
       // Match Emoticons
       $regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
       $clear_string = preg_replace($regex_emoticons, '', $string);
   
       // Match Miscellaneous Symbols and Pictographs
       $regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
       $clear_string = preg_replace($regex_symbols, '', $clear_string);
   
       // Match Transport And Map Symbols
       $regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
       $clear_string = preg_replace($regex_transport, '', $clear_string);
   
       // Match Miscellaneous Symbols
       $regex_misc = '/[\x{2600}-\x{26FF}]/u';
       $clear_string = preg_replace($regex_misc, '', $clear_string);
   
       // Match Dingbats
       $regex_dingbats = '/[\x{2700}-\x{27BF}]/u';
       $clear_string = preg_replace($regex_dingbats, '', $clear_string);

       
   
       return $clear_string;
    }
    public function removeEmoji($text){
        return preg_replace('/[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0077}\x{E006C}\x{E0073}\x{E007F})|[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0073}\x{E0063}\x{E0074}\x{E007F})|[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0065}\x{E006E}\x{E0067}\x{E007F})|[\x{1F3F4}](?:\x{200D}\x{2620}\x{FE0F})|[\x{1F3F3}](?:\x{FE0F}\x{200D}\x{1F308})|[\x{0023}\x{002A}\x{0030}\x{0031}\x{0032}\x{0033}\x{0034}\x{0035}\x{0036}\x{0037}\x{0038}\x{0039}](?:\x{FE0F}\x{20E3})|[\x{1F441}](?:\x{FE0F}\x{200D}\x{1F5E8}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F466})|[\x{1F469}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F469})|[\x{1F469}\x{1F468}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F468})|[\x{1F469}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F48B}\x{200D}\x{1F469})|[\x{1F469}\x{1F468}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F48B}\x{200D}\x{1F468})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F9B0})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F9B0})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F9B0})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F9B0})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F9B0})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B0})|[\x{1F575}\x{1F3CC}\x{26F9}\x{1F3CB}](?:\x{FE0F}\x{200D}\x{2640}\x{FE0F})|[\x{1F575}\x{1F3CC}\x{26F9}\x{1F3CB}](?:\x{FE0F}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FF}\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FE}\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FD}\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FC}\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FB}\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F9B8}\x{1F9B9}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F9DE}\x{1F9DF}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F46F}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93C}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FF}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FE}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FD}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FC}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FB}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F9B8}\x{1F9B9}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F9DE}\x{1F9DF}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F46F}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93C}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{200D}\x{2642}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{2695}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{2695}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{2695}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{2695}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{2695}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2695}\x{FE0F})|[\x{1F476}\x{1F9D2}\x{1F466}\x{1F467}\x{1F9D1}\x{1F468}\x{1F469}\x{1F9D3}\x{1F474}\x{1F475}\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F934}\x{1F478}\x{1F473}\x{1F472}\x{1F9D5}\x{1F9D4}\x{1F471}\x{1F935}\x{1F470}\x{1F930}\x{1F931}\x{1F47C}\x{1F385}\x{1F936}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F483}\x{1F57A}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F6C0}\x{1F6CC}\x{1F574}\x{1F3C7}\x{1F3C2}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}\x{1F933}\x{1F4AA}\x{1F9B5}\x{1F9B6}\x{1F448}\x{1F449}\x{261D}\x{1F446}\x{1F595}\x{1F447}\x{270C}\x{1F91E}\x{1F596}\x{1F918}\x{1F919}\x{1F590}\x{270B}\x{1F44C}\x{1F44D}\x{1F44E}\x{270A}\x{1F44A}\x{1F91B}\x{1F91C}\x{1F91A}\x{1F44B}\x{1F91F}\x{270D}\x{1F44F}\x{1F450}\x{1F64C}\x{1F932}\x{1F64F}\x{1F485}\x{1F442}\x{1F443}](?:\x{1F3FF})|[\x{1F476}\x{1F9D2}\x{1F466}\x{1F467}\x{1F9D1}\x{1F468}\x{1F469}\x{1F9D3}\x{1F474}\x{1F475}\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F934}\x{1F478}\x{1F473}\x{1F472}\x{1F9D5}\x{1F9D4}\x{1F471}\x{1F935}\x{1F470}\x{1F930}\x{1F931}\x{1F47C}\x{1F385}\x{1F936}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F483}\x{1F57A}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F6C0}\x{1F6CC}\x{1F574}\x{1F3C7}\x{1F3C2}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}\x{1F933}\x{1F4AA}\x{1F9B5}\x{1F9B6}\x{1F448}\x{1F449}\x{261D}\x{1F446}\x{1F595}\x{1F447}\x{270C}\x{1F91E}\x{1F596}\x{1F918}\x{1F919}\x{1F590}\x{270B}\x{1F44C}\x{1F44D}\x{1F44E}\x{270A}\x{1F44A}\x{1F91B}\x{1F91C}\x{1F91A}\x{1F44B}\x{1F91F}\x{270D}\x{1F44F}\x{1F450}\x{1F64C}\x{1F932}\x{1F64F}\x{1F485}\x{1F442}\x{1F443}](?:\x{1F3FE})|[\x{1F476}\x{1F9D2}\x{1F466}\x{1F467}\x{1F9D1}\x{1F468}\x{1F469}\x{1F9D3}\x{1F474}\x{1F475}\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F934}\x{1F478}\x{1F473}\x{1F472}\x{1F9D5}\x{1F9D4}\x{1F471}\x{1F935}\x{1F470}\x{1F930}\x{1F931}\x{1F47C}\x{1F385}\x{1F936}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F483}\x{1F57A}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F6C0}\x{1F6CC}\x{1F574}\x{1F3C7}\x{1F3C2}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}\x{1F933}\x{1F4AA}\x{1F9B5}\x{1F9B6}\x{1F448}\x{1F449}\x{261D}\x{1F446}\x{1F595}\x{1F447}\x{270C}\x{1F91E}\x{1F596}\x{1F918}\x{1F919}\x{1F590}\x{270B}\x{1F44C}\x{1F44D}\x{1F44E}\x{270A}\x{1F44A}\x{1F91B}\x{1F91C}\x{1F91A}\x{1F44B}\x{1F91F}\x{270D}\x{1F44F}\x{1F450}\x{1F64C}\x{1F932}\x{1F64F}\x{1F485}\x{1F442}\x{1F443}](?:\x{1F3FD})|[\x{1F476}\x{1F9D2}\x{1F466}\x{1F467}\x{1F9D1}\x{1F468}\x{1F469}\x{1F9D3}\x{1F474}\x{1F475}\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F934}\x{1F478}\x{1F473}\x{1F472}\x{1F9D5}\x{1F9D4}\x{1F471}\x{1F935}\x{1F470}\x{1F930}\x{1F931}\x{1F47C}\x{1F385}\x{1F936}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F483}\x{1F57A}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F6C0}\x{1F6CC}\x{1F574}\x{1F3C7}\x{1F3C2}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}\x{1F933}\x{1F4AA}\x{1F9B5}\x{1F9B6}\x{1F448}\x{1F449}\x{261D}\x{1F446}\x{1F595}\x{1F447}\x{270C}\x{1F91E}\x{1F596}\x{1F918}\x{1F919}\x{1F590}\x{270B}\x{1F44C}\x{1F44D}\x{1F44E}\x{270A}\x{1F44A}\x{1F91B}\x{1F91C}\x{1F91A}\x{1F44B}\x{1F91F}\x{270D}\x{1F44F}\x{1F450}\x{1F64C}\x{1F932}\x{1F64F}\x{1F485}\x{1F442}\x{1F443}](?:\x{1F3FC})|[\x{1F476}\x{1F9D2}\x{1F466}\x{1F467}\x{1F9D1}\x{1F468}\x{1F469}\x{1F9D3}\x{1F474}\x{1F475}\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F934}\x{1F478}\x{1F473}\x{1F472}\x{1F9D5}\x{1F9D4}\x{1F471}\x{1F935}\x{1F470}\x{1F930}\x{1F931}\x{1F47C}\x{1F385}\x{1F936}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F483}\x{1F57A}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F6C0}\x{1F6CC}\x{1F574}\x{1F3C7}\x{1F3C2}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}\x{1F933}\x{1F4AA}\x{1F9B5}\x{1F9B6}\x{1F448}\x{1F449}\x{261D}\x{1F446}\x{1F595}\x{1F447}\x{270C}\x{1F91E}\x{1F596}\x{1F918}\x{1F919}\x{1F590}\x{270B}\x{1F44C}\x{1F44D}\x{1F44E}\x{270A}\x{1F44A}\x{1F91B}\x{1F91C}\x{1F91A}\x{1F44B}\x{1F91F}\x{270D}\x{1F44F}\x{1F450}\x{1F64C}\x{1F932}\x{1F64F}\x{1F485}\x{1F442}\x{1F443}](?:\x{1F3FB})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F8}\x{1F1F9}\x{1F1FA}](?:\x{1F1FF})|[\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F0}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1FA}](?:\x{1F1FE})|[\x{1F1E6}\x{1F1E8}\x{1F1F2}\x{1F1F8}](?:\x{1F1FD})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F7}\x{1F1F9}\x{1F1FF}](?:\x{1F1FC})|[\x{1F1E7}\x{1F1E8}\x{1F1F1}\x{1F1F2}\x{1F1F8}\x{1F1F9}](?:\x{1F1FB})|[\x{1F1E6}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1ED}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F7}\x{1F1FB}](?:\x{1F1FA})|[\x{1F1E6}\x{1F1E7}\x{1F1EA}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FE}](?:\x{1F1F9})|[\x{1F1E6}\x{1F1E7}\x{1F1EA}\x{1F1EC}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F7}\x{1F1F8}\x{1F1FA}\x{1F1FC}](?:\x{1F1F8})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EB}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F0}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1F7})|[\x{1F1E6}\x{1F1E7}\x{1F1EC}\x{1F1EE}\x{1F1F2}](?:\x{1F1F6})|[\x{1F1E8}\x{1F1EC}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F3}](?:\x{1F1F5})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1EE}\x{1F1EF}\x{1F1F2}\x{1F1F3}\x{1F1F7}\x{1F1F8}\x{1F1F9}](?:\x{1F1F4})|[\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}](?:\x{1F1F3})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F4}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FF}](?:\x{1F1F2})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1EE}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1F1})|[\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1ED}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FD}](?:\x{1F1F0})|[\x{1F1E7}\x{1F1E9}\x{1F1EB}\x{1F1F8}\x{1F1F9}](?:\x{1F1EF})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EB}\x{1F1EC}\x{1F1F0}\x{1F1F1}\x{1F1F3}\x{1F1F8}\x{1F1FB}](?:\x{1F1EE})|[\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1ED})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EA}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}](?:\x{1F1EC})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F9}\x{1F1FC}](?:\x{1F1EB})|[\x{1F1E6}\x{1F1E7}\x{1F1E9}\x{1F1EA}\x{1F1EC}\x{1F1EE}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F7}\x{1F1F8}\x{1F1FB}\x{1F1FE}](?:\x{1F1EA})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1EE}\x{1F1F2}\x{1F1F8}\x{1F1F9}](?:\x{1F1E9})|[\x{1F1E6}\x{1F1E8}\x{1F1EA}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F8}\x{1F1F9}\x{1F1FB}](?:\x{1F1E8})|[\x{1F1E7}\x{1F1EC}\x{1F1F1}\x{1F1F8}](?:\x{1F1E7})|[\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F6}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}\x{1F1FF}](?:\x{1F1E6})|[\x{00A9}\x{00AE}\x{203C}\x{2049}\x{2122}\x{2139}\x{2194}-\x{2199}\x{21A9}-\x{21AA}\x{231A}-\x{231B}\x{2328}\x{23CF}\x{23E9}-\x{23F3}\x{23F8}-\x{23FA}\x{24C2}\x{25AA}-\x{25AB}\x{25B6}\x{25C0}\x{25FB}-\x{25FE}\x{2600}-\x{2604}\x{260E}\x{2611}\x{2614}-\x{2615}\x{2618}\x{261D}\x{2620}\x{2622}-\x{2623}\x{2626}\x{262A}\x{262E}-\x{262F}\x{2638}-\x{263A}\x{2640}\x{2642}\x{2648}-\x{2653}\x{2660}\x{2663}\x{2665}-\x{2666}\x{2668}\x{267B}\x{267E}-\x{267F}\x{2692}-\x{2697}\x{2699}\x{269B}-\x{269C}\x{26A0}-\x{26A1}\x{26AA}-\x{26AB}\x{26B0}-\x{26B1}\x{26BD}-\x{26BE}\x{26C4}-\x{26C5}\x{26C8}\x{26CE}-\x{26CF}\x{26D1}\x{26D3}-\x{26D4}\x{26E9}-\x{26EA}\x{26F0}-\x{26F5}\x{26F7}-\x{26FA}\x{26FD}\x{2702}\x{2705}\x{2708}-\x{270D}\x{270F}\x{2712}\x{2714}\x{2716}\x{271D}\x{2721}\x{2728}\x{2733}-\x{2734}\x{2744}\x{2747}\x{274C}\x{274E}\x{2753}-\x{2755}\x{2757}\x{2763}-\x{2764}\x{2795}-\x{2797}\x{27A1}\x{27B0}\x{27BF}\x{2934}-\x{2935}\x{2B05}-\x{2B07}\x{2B1B}-\x{2B1C}\x{2B50}\x{2B55}\x{3030}\x{303D}\x{3297}\x{3299}\x{1F004}\x{1F0CF}\x{1F170}-\x{1F171}\x{1F17E}-\x{1F17F}\x{1F18E}\x{1F191}-\x{1F19A}\x{1F201}-\x{1F202}\x{1F21A}\x{1F22F}\x{1F232}-\x{1F23A}\x{1F250}-\x{1F251}\x{1F300}-\x{1F321}\x{1F324}-\x{1F393}\x{1F396}-\x{1F397}\x{1F399}-\x{1F39B}\x{1F39E}-\x{1F3F0}\x{1F3F3}-\x{1F3F5}\x{1F3F7}-\x{1F3FA}\x{1F400}-\x{1F4FD}\x{1F4FF}-\x{1F53D}\x{1F549}-\x{1F54E}\x{1F550}-\x{1F567}\x{1F56F}-\x{1F570}\x{1F573}-\x{1F57A}\x{1F587}\x{1F58A}-\x{1F58D}\x{1F590}\x{1F595}-\x{1F596}\x{1F5A4}-\x{1F5A5}\x{1F5A8}\x{1F5B1}-\x{1F5B2}\x{1F5BC}\x{1F5C2}-\x{1F5C4}\x{1F5D1}-\x{1F5D3}\x{1F5DC}-\x{1F5DE}\x{1F5E1}\x{1F5E3}\x{1F5E8}\x{1F5EF}\x{1F5F3}\x{1F5FA}-\x{1F64F}\x{1F680}-\x{1F6C5}\x{1F6CB}-\x{1F6D2}\x{1F6E0}-\x{1F6E5}\x{1F6E9}\x{1F6EB}-\x{1F6EC}\x{1F6F0}\x{1F6F3}-\x{1F6F9}\x{1F910}-\x{1F93A}\x{1F93C}-\x{1F93E}\x{1F940}-\x{1F945}\x{1F947}-\x{1F970}\x{1F973}-\x{1F976}\x{1F97A}\x{1F97C}-\x{1F9A2}\x{1F9B0}-\x{1F9B9}\x{1F9C0}-\x{1F9C2}\x{1F9D0}-\x{1F9FF}]/u', '', $text);
    }
}
