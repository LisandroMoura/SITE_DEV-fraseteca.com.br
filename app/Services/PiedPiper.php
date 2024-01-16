<?php

namespace App\Services;
use App\Exceptions\ValidatorException;

/**
 * Class PiedPiper.
 *
 * @package namespace App\Services;
 */
class PiedPiper
{
    public function run($nomeOriginal)
    {
        try {
            // Validações... 
            // pendencia:: concatenar o endereço da capa???? com o nome origrinal do arquivo

            $nomeOriginal = str_replace('https://listafrases.com','',$nomeOriginal);
            $nomeOriginal = str_replace('https://fraseteca.com.br','',$nomeOriginal);

            $urlBruta = \storage_path(). "/app/public/usuarios/" . str_replace('/storage/usuarios/','',$nomeOriginal);


            if(!file_exists($urlBruta)){            
                $return = [
                    "sucess" => false,            
                    'titulo_msg'    => "O programa do Dinesh falhou de novo :(",
                    'msg'           => $nomeOriginal,            
                ];
                return $return; 
            }
            
            $extension = "jpg"; 


            if (strpos($urlBruta,".png")) $extension = "png"; 
            if (strpos($urlBruta,".gif")) $extension = "gif"; 
            if (strpos($urlBruta,".webp")) $extension = "webp"; 
            switch ($extension) {
                case 'jpg':
                    $imBruta = imagecreatefromjpeg($urlBruta);
                    break;
                case 'png':
                    $imBruta = imagecreatefrompng($urlBruta);
                    break;
                case 'gif':
                    $imBruta = imagecreatefromgif($urlBruta);
                    break;
                case 'webp':
                    $imBruta = imagecreatefromwebp($urlBruta);
                    break;
            }

            $arquivos       = [];
            $arquivos[0]    = $this->corte($imBruta, $nomeOriginal, "full");
            $imgFull        = $arquivos[0]["imgFull"];
            $arquivos[1]    = $this->corte($imgFull, $nomeOriginal, "mobile");
            $arquivos[2]    = $this->corte($imgFull, $nomeOriginal, "thumb");

            //destruir os objetos criados
            imagedestroy($arquivos[0]["imgFull"]);
            imagedestroy($arquivos[1]["imgFull"]);
            imagedestroy($arquivos[2]["imgFull"]);
            imagedestroy($imgFull);
            imagedestroy($imBruta);
            
            // rodar a compressão
            foreach ($arquivos as $key => $arquivo) {
                $this->compressao($arquivo["path"]);
            }

            return [
                'sucesso'       => true,
                'titulo_msg'    => "Gilfoyle diz:",
                'msg'           => "O programa do Dinesh surpreendentemente funcionou",
                'arquivos'      => $arquivos
            ];
        } catch (ValidatorException $e) {

            return [
                'sucesso'       => false,
                'titulo_msg'    => "O programa do Dinesh falhou de novo :(",
                'msg'           => $e->getMessageBag(),
            ];
        }
    }
    public function compressao($fileAddres)
    {
        $iMagick = new \Imagick($fileAddres);
        $compression = 56; // set from 75-85 generally
        $iMagick->setImageCompressionQuality($compression);
        $iMagick->setImageFormat("webp");
        $iMagick->stripImage(); // saves lot by removing meta
        $save_to_path = str_replace(".jpg", ".webp", $fileAddres);
        $iMagick->writeImage($save_to_path);
        $iMagick->destroy();
        $this->destroy($fileAddres);
    }
    public function corte($im, $nomeOriginal, $tipo)
    {
        $imgCrop = $this->cerebroDeAton($im, $tipo);
        $retorno  = $this->salvar($imgCrop, $nomeOriginal, $tipo);
        return $retorno;
    }
    function destroy($arquivo_que_sera_deletado)
    {
        if (file_exists($arquivo_que_sera_deletado))
            unlink($arquivo_que_sera_deletado);
    }
    public function salvar($imgCrop, $nomeOriginal, $tipo)
    {
        //pendencia::  automatizar o local para gravação dos arquivos
        $nomeOriginal = str_replace(".jpg","",$nomeOriginal);
        $save_to_path = \storage_path(). "/app/public/usuarios/" . str_replace('/storage/usuarios/','',$nomeOriginal."_$tipo.jpg");

        // $save_to_path = "/home/ubuntu/repositorio/zona51/labPhp/piedpiper/" . $nomeOriginal . "_$tipo.jpg";
        //tratamento da imagem e salvar fisicamente o arquivo
        imagealphablending($imgCrop, true); // setting alpha blending on
        imagesavealpha($imgCrop, true); // save alphablending setting (important)
        imagejpeg($imgCrop, $save_to_path);
        return [
            "imgFull"  => $imgCrop,
            "path" => $save_to_path,
            "width" =>  imagesx($imgCrop),
            "height" => imagesy($imgCrop)
        ];
    }
    public function cerebroDeAton($im, $tipo = null)
    {
        $largura_original   = imagesx($im);
        $altura_original    = imagesy($im);
        $eixoX              = 0; // $largura_original / 2;
        $eixoY              = 0; //$altura_original / 2;
        $tipo               = $tipo ?? "full";
        //tratamento do tipo de corte que será feito
        switch ($tipo) {
            case 'full':
                $globals = [
                    "width" => 853,
                    "height" => 265,
                ];
                //se altura ou largura da imagem enviada for maior que o padrão: 
                // centralizar o cursor do corte (no caso os eixos X e Y) 
                if ($largura_original > ($globals['width']))
                    $eixoX = ($largura_original / 2) - ($globals['width'] / 2);
                if ($altura_original > ($globals['height']))
                    $eixoY  = ($altura_original / 2) - ($globals['height'] / 2);

                /*
                 * Caso o a imagem de upload for Menor que o padrão (largura ou altura),
                 * devemos criar uma imagem grande o suficiente para que possamos cortar nas dimensões 
                 * 1070 x 350
                 */
                if ($largura_original < ($globals['width'])) {
                    //capturar o percentual em que a imagem enviada é menor (na largura) que o padrão
                    $perW = ($globals['width'] * 100) / $largura_original;
                    $perW = round(ceil($perW * 100) / 100, 6);
                    $perW = $perW / 100;

                    //capturar o percentual em que a imagem enviada é menor (na altura) que o padrão
                    $perH = ($globals['height'] * 100) / $altura_original;
                    $perH = round(ceil($perH * 100) / 100, 6);
                    $perH = $perH / 100;

                    /** escolher o maior percentual para aplicar a imagem que será cortada, ou seja criar uma imagem grande o suficiente
                     * que dê para cortar no tamanho padrão da capa. Por isso é que tenho que testar o maior percentual, para ter certeza
                     * que o corte será feito
                     */
                    $per = max($perW, $perH);
                    $new_w = $largura_original * $per;
                    $new_h = $altura_original * $per;
                    $output = imagecreatetruecolor($new_w, $new_h);
                    imagecopyresized($output, $im, 0, 0, 0, 0, $new_w, $new_h, $largura_original, $altura_original);
                    $im = $output;
                    imagedestroy($output);
                }
                break;

            case 'mobile':
                $globals = [
                    "width" => 416,
                    "height" => "203",
                ];
                // $eixoX  = ($largura_original / 2) - ($globals['width'] / 2);
                // $eixoY  = ($altura_original / 2) - ($globals['height'] / 2);
                 // redimencionar (diminuir) a imagem para melhor aproveitamento do corte em caso de thumbnail
                $per = 0.7666;
                $new_w = $largura_original * $per;
                $new_h = $altura_original * $per;
                $output = imagecreatetruecolor($new_w, $new_h);
                imagecopyresized($output, $im, 0, 0, 0, 0, $new_w, $new_h, $largura_original, $altura_original);
                $eixoX  = ($new_w / 2) - ($globals['width'] / 2);
                $eixoY  = 0;
                $im = $output;
                //debug 
                // imagejpeg($output, "/home/ubuntu/repositorio/zona51/labPhp/piedpiper/@maior.jpg");
                imagedestroy($output);
                break;

            case 'thumb':
                $globals = [
                    "width" => 191,
                    "height" => "130",
                ];
                // redimencionar (diminuir) a imagem para melhor aproveitamento do corte em caso de thumbnail
                $per = 0.4950;
                $new_w = $largura_original * $per;
                $new_h = $altura_original * $per;
                $output = imagecreatetruecolor($new_w, $new_h);
                imagecopyresized($output, $im, 0, 0, 0, 0, $new_w, $new_h, $largura_original, $altura_original);
                $eixoX  = ($new_w / 2) - ($globals['width'] / 2);
                $eixoY  = 0;
                $im = $output;
                //debug 
                // imagejpeg($output, "/home/ubuntu/repositorio/zona51/labPhp/piedpiper/@maior.jpg");
                imagedestroy($output);
                break;
            default:
                $globals = [
                    "width" => 1070,
                    "height" => 350,
                ];
                break;
        }

        $largura_escolhida  = $globals['width'];
        $altura_escolhida   = $globals['height'];
        //fazer o corte 
        $im2 = imagecrop($im, [
            'x' => $eixoX,
            'y' => $eixoY,
            'width' => $largura_escolhida,
            'height' => $altura_escolhida
        ]);
        return $im2;
    }
}
