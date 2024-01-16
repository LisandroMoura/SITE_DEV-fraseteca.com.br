<?php
namespace App\Services;

use App\Services\ClearString;

use Illuminate\Support\Arr;
use PhpParser\Node\Expr\Cast\Object_;

// use PhpParser\Node\Expr\Cast\Object_;
// use SebastianBergmann\Type\ObjectType;

/**
 * Pipief
 * @package namespace App\Services;
 * @author  LM
 * @link    
 * @version 1.0.0 - Jul-2022
 */

class PipifFunctions
{    
    protected $tamanhofonte;
    protected $tamanhofonteAutor;
    protected $qtLetrasPorLinha;
    protected $margens;
    protected $pdTopo;
    protected $path;
    protected $fonte;
    protected $fonteAutor;
    protected $corFonte;
    protected $sizeFonte;
    protected $quebra;
    protected $align;
    protected $sizeAutor;
    protected $marginTop;
    protected $marginRight;
    protected $marginBottom;
    protected $marginLeft;
    protected $qualidade;

    /**
     * Construtuor
     */
    public function __construct(
        $fonte,
        $corFonte,
        $fonteAutor,
        $sizeFonte,
        $quebra,
        $align,
        $sizeAutor,
        $marginTop,
        $marginRight,
        $marginBottom,
        $marginLeft,
        $qualidade
    ) {
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
        // $this->path = '/home/ubuntu/repositorio/zona51/labPhp/pipif/';
        // $this->path = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$capa);                        
        $this->path = \storage_path();                        

            // $this->path = \storage_path(). "/app/public/usuarios/" . str_replace('/storage/usuarios/','',$capa);                        

    


        $this->corFonte     = $corFonte;
        $this->fonte        = $fonte;
        $this->fonteAutor   = $fonteAutor;
        $this->sizeFonte    = $sizeFonte;
        $this->quebra       = $quebra ?? 0;
        $this->align        = $align;
        $this->sizeAutor    = $sizeAutor;
        $this->marginTop    = $marginTop ?? 0;
        $this->marginRight  = $marginRight ?? 0;
        $this->marginBottom = $marginBottom ?? 0;
        $this->marginLeft   = $marginLeft ?? 0 ;
        $this->qualidade    = $qualidade;
    }
    /**
     * run function
     * Dispara todo o Processo
     * @param [String] $nome
     * @param [String] $texto
     * @param [String] $autor
     * @param [String] $tipo - 1 (bg) ou 2 (Chapado) 
     * @param string $pasta - tem a ver com a template (por ex: Default, Amor, Degradê, Feminino )
     * @return void
     */
    public function run(String $nome, String $texto, String $autor = "", $tipoTela = "bg", $pasta = "0", $imagemEscolhida = "1",$nItensNaPasta,$execucao)
    {
        

        $clearstring    = new ClearString;
        $texto          = $clearstring->limpeza($texto);
        $texto          = urldecode($texto);
        $texto          = $clearstring->removeEmoji($texto);
        $totCaracteres  = strlen($texto);

        $nome = str_replace(".jpg",".webp",$nome);
        $nome = str_replace(".jpeg",".webp",$nome);
        $nome = str_replace(".png",".webp",$nome);
        
        $retorno       = [];
        if($tipoTela == "padraochapado"){

            // dd($pasta, $imagemEscolhida,$nItensNaPasta);
            $retorno = $this->chapado($nome, $texto, $autor, $pasta, $imagemEscolhida,$nItensNaPasta,$execucao);
            return $retorno;
        }

        // Definir automáticamente o numero de caracteres// ou deixar em tela (definir isso melhor)
        if ($totCaracteres > 100) 
            $tipoTela == "chapado";
        if ($tipoTela == "bg") :
            $retorno = $this->bg($nome, $texto, $autor, $pasta, $imagemEscolhida,$nItensNaPasta,$execucao);
        else :
            $retorno = $this->chapado($nome, $texto, $autor, $pasta, $imagemEscolhida,$nItensNaPasta,$execucao);
            // $retorno = $this->chapado($totCaracteres, $nome, $texto, $autor, $pasta, $imagemEscolhida);
        endif;
        return $retorno;
    }

/**
     * Responsável por gerar as imagens Mobile.web
     * ● Projeto20221201 - 12-12-22 - Transformar este methodo em statico 
     *   para facilitar o acesso externo
     *
     * @param Object $im
     * @return array
     */
    public static function gerarMobileIMageStatic(Object $im,$path, $tipo = "bg", $qualidade,$nome = ""):array 
    {

        $largura_original   = imagesx($im);
        $altura_original    = imagesy($im);

        $new_w = "346";
        $new_h = "346";

        if($tipo=="chapado"){
            $new_w = $largura_original  * (52.28 / 100); //aplicar uma regra aqui
            $new_h = $altura_original  * (52.28 / 100); //aplicar uma regra aqui
        }

        //criar o retangulo quadrado
        $output = imagecreatetruecolor($new_w, $new_h);
        
        //redimencionar
        // imagecopyresized($output, $im, 0, 0, 0, 0, $new_w, $new_h, $largura_original, $altura_original);
        imagecopyresampled($output, $im, 0, 0, 0, 0, $new_w, $new_h, $largura_original, $altura_original);
        // imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        imagewebp($output,  $path."_mobile.webp",$qualidade);
        imagedestroy($output);
        
        return [
            "width"     => $new_w,
            "height"    => $new_h,
            "nome"      => $nome . "_mobile.webp",
            "path"      => $path."_mobile.webp"
        ];
    }

    /**
     * Criação da imagem do tamanho 600x600
     *
     * @param Int $totCaracteres - o numero de caracteres que será processado
     * @param String $nome - o nome fisico da imagem
     * @param String $texto - a frase que será criada
     * @param String $autor - autor para a frase
     * @param String $pasta - tipo 
     * @return String 
        *  "sucess"    => true, 
        *  "msg"       => "arquivo gerado com sucesso",
        * "fullpath"   => caminho completo da imagem,
        *  "path"      => nome fisico da imagem,
        * "dimensoes"  => retornar width e Height
     */
    public function bg(String $nome, String $texto, $autor, String $pasta, String $imagemEscolhida,$nItensNaPasta,$execucao)
    {
        //Definir o tamanhoDafonte e o nº de caracteres em cada linha
        $tamanhofonte       = $this->sizeFonte;
        $pdTopo             = $this->marginTop;
        $pdBottom           = $this->marginBottom;
        $limite             = 612;

        if($this->align == "1") {
            $pdTopo         = 0;
            $pdBottom       = 0;
            $limite         = 456;
        }
        
        $vLinha             = 300; // rever
        $fatorPulo          = 30;  // rever
        $areaDoTexto        = 612 - $this->marginLeft - $this->marginRight;
        $retorno            = $this->calculaArea($texto, $tamanhofonte, $this->fonte, $this->marginLeft, $pdTopo, $areaDoTexto);
        $nLinhas            = $retorno["nlinhas"];
        $alturaTotal        = intval($retorno["maxHeight"] * $nLinhas);
        $alturaTotal        = intval($alturaTotal + ($this->quebra * 2 * $nLinhas));

        if ($autor !=="") {
            $nLinhas++;
            // $pdTopo = ceil($vLinha  - ($fatorPulo * ($nLinhas)));

            // $alturaTotal = intval($alturaTotal + ($this->quebra + 20));

        } 
        else
            //$pdTopo = ceil($vLinha  - ($fatorPulo * ($nLinhas - 1)));
        if($execucao=="randow"){
            $imagemEscolhida = rand(1, $nItensNaPasta);
        }

        /**
         * Cálculo para a altura TOTAL da imagem
         */
        $ysize = ($retorno["maxHeight"]*$nLinhas) + (($this->quebra*2) * $nLinhas) + $pdTopo + $pdBottom;
        
        if($ysize > $limite)
            return [
                "sucess"     => false,
                "msg"        => "Texto muito grande para o padrão BG",
                "fullpath"   => "",
                "mobile"     => "",
                "path"       => "",
                "dimensoes"  => "612x612"
            ];

        
            // $this->path. "/app/public/usuarios/" . str_replace('/storage/usuarios/','',$capa);
            // $this->path = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$capa);


        $arqTemplate = $this->path . "/app/public/frases/template/" . $pasta . "/$imagemEscolhida.png";
        if (!file_exists($arqTemplate))
            return [
                "sucess" => false,
                "msg"    => "Falha ao obter O arquivo de template  $arqTemplate ",
            ];
        /**
         * Aqui, a imagem de template já foi escolhida
         */
        $im  = imagecreatefrompng($arqTemplate);

        /**
         * imagecolorallocate — Allocate a color for an image
         * Returns a color identifier representing the color composed of the given RGB components.
         * se o tipo de pasta for diferente de degradê o fundo é branco, caso contrário é preto
         */

        $split_hex_color = str_replace("#", "", $this->corFonte);
        $split_hex_color = str_split($split_hex_color, 2);

        $rgb1 = hexdec($split_hex_color[0]);
        $rgb2 = hexdec($split_hex_color[1]);
        $rgb3 = hexdec($split_hex_color[2]);

        if ($pasta != "2") {
            $cor    = imagecolorallocate($im, $rgb1, $rgb2, $rgb3);
            imagecolorallocate($im, $rgb1, $rgb1, $rgb1);
        } else {
            $cor    = imagecolorallocate($im, 0, 0, 0);
            imagecolorallocate($im, 0, 0, 0);
        }

        if ($this->align == "1") //middle
            $mgTop = (612 - $ysize) / 2;
        else 
            $mgTop = $this->marginTop;

        $this->cerebro($im, $tamanhofonte, $cor, $this->fonte, $texto, $autor, $this->sizeAutor, $this->marginLeft, $mgTop+ $retorno["maxHeight"] , $areaDoTexto, $this->quebra, 0);
        //refatorar: local de destino de salvamento do arquivo da frase
        //rever - tornar isso mais portável
        // $path = "/home/ubuntu/repositorio/zona51/labPhp/pipif/storage/frases/" . $nome;

        $path = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$nome);   

        imagewebp($im,  $path, $this->qualidade );

        $mobile = $this->gerarMobileIMageStatic($im,$path,"bg",$this->qualidade,$nome);

        /**
         * 19-ago-2022: LM ● Projeto20220801 - Download de JPEG
         * Criar a imagem para download
         */
        // $arrDownload = [];
        $arrDownload = $this->geraIMagemParaDownload($im,$path);
        
        //destroy
        imagedestroy($im);
        return [
            "sucess"     => true,
            "msg"        => "arquivo gerado com sucesso",
            "fullpath"   => $path,
            "mobile"     => $mobile,
            "nomeDownload"  => $arrDownload,
            "path"       => $nome,
            "dimensoes"  => "612x612"
        ];
    }

    public function  chapado(String $nome, String $texto, String $autor, String $pasta, String $corEscolhida,$nItensNaPasta,$execucao)
    {
        /**
         * processar a largura da área disponível para imprimir o texto 
         */
        $areaDoTexto        = 612 - $this->marginLeft - $this->marginRight;

        /**
         * Buscar o numero de linhas que iremos usar, a altura da maior linha na área
         */
        $retorno            = $this->calculaArea($texto, $this->sizeFonte, $this->fonte, $this->marginLeft, $this->marginTop, $areaDoTexto);
        $nLinhas            = $retorno["nlinhas"];


        /**
         * Cálculo de linhas em relação ao autor
         */
        if ($autor) {
            $nLinhas++;
        } 

        if($this->marginBottom=="") $this->marginBottom=0;
        if($this->marginTop=="") $this->marginTop=0;
        if($this->quebra=="") $this->quebra=7;
        /**
         * Cálculo para a altura TOTAL da imagem
         */
        $ysize = ($retorno["maxHeight"]*$nLinhas) + (($this->quebra*2) * $nLinhas)  + $this->marginTop + $this->marginBottom; 
        

        /**
         * Criação da imagem
         */
        $im = imagecreatetruecolor(612, $ysize);

        /**
         * Tratamendo da cor com a paleta de cores, em caso de uma escolha randomica
         */

        $arrCor = explode("_#",$corEscolhida);
        if(isset($arrCor[0]))
            $corEscolhida = $arrCor[0];
        if($execucao=="randow"){
            //cor excolhida devera ser
            $corEscolhida = rand(1, $nItensNaPasta);
        }

        /**
         * Aplicação da cor de fundo (que virá da template)
         */
        $bg = $this->getRgbColor($corEscolhida);
        $background = imagecolorallocate($im, $bg["r"], $bg["g"], $bg["b"]);
        imagefill($im, 0, 0, $background);

        /**
         * Cor da Fonte
         */
        if(isset($arrCor[1]))
            $rgb    = $this->getRgbColor("#".$arrCor[1]);
        else    
            $rgb    = $this->getRgbColor($this->corFonte);

        if ($pasta != "2") {
            $cor    = imagecolorallocate($im, $rgb["r"], $rgb["g"], $rgb["b"]);
            imagecolorallocate($im, $rgb["r"], $rgb["g"], $rgb["b"]);
        } else {
            $cor    = imagecolorallocate($im, 0, 0, 0);
            imagecolorallocate($im, 0, 0, 0);
        }

        /**
         * execução
         */
        $this->cerebro($im, $this->sizeFonte, $cor, $this->fonte, $texto, $autor, $this->sizeAutor, $this->marginLeft, $this->marginTop + $retorno["maxHeight"], $areaDoTexto, $this->quebra, 0);

        /**
         * Aplicação da marcadágua (bg no rodape)
         */
        $bgrodape = "storage/frases/paletas/bgs/$corEscolhida.png";
        if (!file_exists($bgrodape))
            $bgrodape = "storage/frases/paletas/bgs/#000000.png";

        $bgrodape_src = imagecreatefrompng($bgrodape);

        $background = imagecolorallocatealpha($bgrodape_src,0,0,0,127);
        imagecolortransparent($bgrodape_src, $background);
        imagealphablending($bgrodape_src, false);
        imagesavealpha($bgrodape_src, true);
        imagecopymerge($im, $bgrodape_src, 0, $ysize-93 , 0, 0, 612, 120, 100);
        
        /**
         * Criar o arquivo Fisicamente
         */
        $path = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$nome);  
        imagewebp($im,  $path, $this->qualidade );

        /**
         * Criar o Mobile respectivo
         */
        $mobile = $this->gerarMobileIMageStatic($im,$path,"chapado",$this->qualidade,$nome);
    
        /**
         * 19-ago-2022: LM ● Projeto20220801 - Download de JPEG
         * Criar a imagem para download
         */

        // $arrDownload   = [];
        $arrDownload   = $this->geraIMagemParaDownload($im,$path);
        
        /**
         * destroy e retorno
         *///
        imagedestroy($im);
        return [
            "sucess"        => true,
            "msg"           => "arquivo gerado com sucesso",
            "fullpath"      => $path,
            "mobile"        => $mobile,
            "nomeDownload"  => $arrDownload,
            "path"          => $nome,
            "dimensoes"     => "612x" . $ysize
        ];
    }

    /**
     * Função principal de escrita do Texto nas imagens da Frase
     *
     * @param Object $image - Objeto de imagem
     * @param String $tamanhofonte - Tamanho da fonte definida no constructor
     * @param String $color - c
     * @param String $font
     * @param String $text
     * @param String $autor
     * @param String $font_autor_width
     * @param String $start_x
     * @param String $start_y
     * @param String $max_width
     * @param String $quebra
     * @param [type] $startX
     * @return void
     */
    public function cerebro(Object $image, String $tamanhofonte, String $color, String $font, String $text, String $autor, String $font_autor_width, String $start_x, String $start_y, String $max_width, String $quebra, $startX)
    {
        $words = explode(" ", $text);
        $string = "";
        $tmp_string = "";
        $start_xx = $this->marginLeft;
        $nlinhas=1;
        $contaLinhas=0;
        for ($i = 0; $i < count($words); $i++) {
            $tmp_string .= $words[$i] . " ";
            //tratativas em recalçao ao tamanho da palava individual
            $dimensoesDaPalavraIndividual = imagettfbbox($tamanhofonte, 0, $font, $words[$i]);
            $tamanhoPossivel = $max_width - $start_x;
            if($tamanhoPossivel < $dimensoesDaPalavraIndividual[4]){
                $nlinhas++;

                imagettftext($image, $tamanhofonte, 0, $start_xx, $start_y, $color, $font, str_replace($words[$i],"",$tmp_string));
                $start_y += abs($dimensoesDaPalavraIndividual[5]) + $quebra * 2;

                

                $arrayDePalavrasDaQuebra = $this->retornaQuebraDeLinhas($words[$i],$font,$tamanhoPossivel);
                foreach ($arrayDePalavrasDaQuebra as $key => $palavra) {
                    $nlinhas++;
                    $contaLinhas++;

                    if($contaLinhas < count($arrayDePalavrasDaQuebra)){
                        imagettftext($image, $tamanhofonte, 0, $start_xx, $start_y, $color, $font, $palavra."-");
                        $start_y += abs($dimensoesDaPalavraIndividual[5]) + $quebra * 2;
                    }
                    else {
                        $tmp_string = $palavra . " ";
                    }
                } 
            } 
            else{
                $dim = imagettfbbox($tamanhofonte, 0, $font, $tmp_string);
                if ($dim[4] - 30 < ($max_width - $start_x)) {
                    $string = $tmp_string;
                    $curr_width = $dim[4];
                } else {
                    $i--;
                    $tmp_string = "";
                    $nlinhas++;
                    imagettftext($image, $tamanhofonte, 0, $start_xx, $start_y, $color, $font, $string);
                    $string = "";
                    $start_y += abs($dim[5]) + $quebra * 2;
                }
            }
        }
        //$start_xx = $start_x + round(($max_width - $dim[4] - $start_x) / 2);           
        imagettftext($image, $tamanhofonte, 0, $start_xx, $start_y, $color, $font, $string);

        if ($autor) {
            // $autorDim = imagettfbbox($font_autor_width, 0, $this->fonteAutor, $autor);
            //$start_xx = $start_x + round(($max_width - $autorDim[4] - $start_x) / 2);        
            imagettftext($image, $font_autor_width, 0, $start_xx, $start_y + 50, $color, $this->fonteAutor, $autor);
            
        }

    }

    public function retornaQuebraDeLinhas(String $palavra, $fonte, $tamanhoPossivel): array
    {
        $palavraAux = "";
        $ncont = 0;
        $novaPalavra=[];
        for ($i=0; $i < strlen($palavra); $i++) { 
            $palavraAux .= substr($palavra,$i, 1);
            $dimensoesDaPalavraIndividual = imagettfbbox(42, 0, $fonte, $palavraAux . "-");
            if(($tamanhoPossivel-30) < $dimensoesDaPalavraIndividual[4]){
                $novaPalavra[$ncont] = $palavraAux;
                $ncont++;
                $palavraAux = "";
            }
        }
        $ncont++;
        $novaPalavra[$ncont] = $palavraAux;
        return $novaPalavra;
    }

    /**
     * Retorna o nº de Linhas necessárias para a construção da imagem
     */
    public function calculaArea(String $texto, String $tamanhofonte, String $fonte, String $start_x, String $start_y, String $max_width)
    {
        $words = explode(" ", $texto);
        $tmp_string = "";
        $nlinhas = 1;

        $maxHeight = 0;
        $height = 0;

        for ($i = 0; $i < count($words); $i++) {
            $tmp_string .= $words[$i] . " ";

            //tratativas em recalçao ao tamanho da palava individual
            $dimensoesDaPalavraIndividual = imagettfbbox($tamanhofonte, 0, $fonte, $words[$i]);
            $tamanhoPossivel = $max_width - $start_x;
            if($tamanhoPossivel < $dimensoesDaPalavraIndividual[4]){
                $nlinhas++;
                $arrayDePalavrasDaQuebra = $this->retornaQuebraDeLinhas($words[$i],$fonte,$tamanhoPossivel);
                foreach ($arrayDePalavrasDaQuebra as $key => $palavra) {
                    $nlinhas++;
                } 
            }  else {
                $dim = imagettfbbox($tamanhofonte, 0, $fonte, $tmp_string);
                $maxHeight = max(($dim[5] * -1),$maxHeight);
                $height = $dim[5] * -1;
                if ($dim[4] - 30 < ($max_width - $start_x)) {
                
                } else {
                    $i--;
                    $tmp_string = "";
                    $nlinhas++;
                }
            }
        }

        if($maxHeight < "40")
            $maxHeight = "40";
        return [
            "maxHeight" => $maxHeight,
            "nlinhas"    => $nlinhas,
        ];
    }

    public static function buscaImagensBG(String $pasta)
    {
        
        $imagens = [];
        $path = \storage_path();

        if(!file_exists($path."/app/public/frases/template/".$pasta)) {
            return [];
        }

        $handle = opendir($path."/app/public/frases/template/".$pasta);

        if ($handle) {
            while (($entry = readdir($handle)) !== FALSE) {
                $arrFiles[] = $entry;
            }
        }
        $items = [];
        foreach ($arrFiles as $key => $file) {
            # code...
            $extensao = explode(".",$file);
            if($extensao[1]) {
                array_push($items,$file."?" . rand(1, 999));
            }
        }
        return $items;
    }

    public static function buscaPaletasBG(String $pasta)
    {
        $path = \storage_path();

        if(!file_exists($path."/app/public/frases/paletas/".$pasta)) {
            return [];
        }

        $handle = opendir($path."/app/public/frases/paletas/".$pasta);
        if ($handle) {
            while (($entry = readdir($handle)) !== FALSE) {
                $arrFiles[] = $entry;
            }
        }
        $items = [];
        foreach ($arrFiles as $key => $file) {
            # code...
            $extensao = explode(".",$file);
            if($extensao[1]) {
                $arq = explode(".cor",$file);
                array_push($items,$arq[0]);
            }
        }
        return $items;
    }

    public function validateIsBg(String $frase = null,String $autor = null) : bool
    {
        # code...
        /**
         * testar a quantidade de caracteres
         */
        $total = strlen($frase);
        if($total >= 90)
            return false;

        /**
         * testar o numero de linhas e o tamanho do arquivo
         */
        $pdTopo             = $this->marginTop;
        $pdBottom           = $this->marginBottom;
        $limite             = 612;

        if($this->align == "1") {
            $pdTopo         = 0;
            $pdBottom       = 0;
            $limite         = 456;
        }

        $areaDoTexto        = 612 - $this->marginLeft - $this->marginRight;
        $retorno            = $this->calculaArea($frase, $this->sizeFonte, $this->fonte, $this->marginLeft, $pdTopo, $areaDoTexto);
        $nLinhas            = $retorno["nlinhas"];
        $alturaTotal        = intval($retorno["maxHeight"] * $nLinhas);
        $alturaTotal        = intval($alturaTotal + ($this->quebra * 2 * $nLinhas));

        if ($autor)
            $nLinhas++;

        $ysize = ($retorno["maxHeight"]*$nLinhas) + (($this->quebra*2) * $nLinhas) + $pdTopo + $pdBottom;

        if($ysize > $limite)
            return false;
        
        return true;
    }
    public function getRgbColor(String $color) : Array
    {
        $split_hex_color = str_replace("#", "", $color);
        $split_hex_color = str_split($split_hex_color, 2);

        // dd($split_hex_color);

        $rgb1 = hexdec($split_hex_color[0]);
        $rgb2 = hexdec($split_hex_color[1]);
        $rgb3 = hexdec($split_hex_color[2]);

        return [
            "r" => $rgb1,
            "g" => $rgb2,
            "b" => $rgb3,
        ];
    }

    public static function retornaStrParametros(array $parametros = [],$tipoTela = "bg",$pasta = "default",$imagemEscolhida) : String
    {
        $str =  "";
        $cont = 0;
        foreach ($parametros as $key => $item) {
            $cont++;
            if($cont == 13)
                $str .= $pasta.",";
            else if($cont == 14)
                $str .= $imagemEscolhida .",";
            else if(count($parametros) == $cont)
                $str .= $tipoTela;
            else 
                $str .= $item.",";
        }
        return $str;
    }

    public static function retornaParametrosDeForm(array $parametros = [],array $dados = []) : String
    {
        $str =
        $parametros["fonte"] .",".
        $dados["corFonte"] .",".
        $parametros["fonteAutor"] .",".
        $parametros["sizeFonte"] .",".
        $dados["quebra"] .",".
        $dados["align"] .",".
        $parametros["sizeAutor"] .",".
        $dados["marginTop"] .",".
        $dados["marginRight"] .",".
        $dados["marginBottom"] .",".
        $dados["marginLeft"] .",".
        $dados["qualidade"] .",".
        $dados["pasta"] .",".
        $dados["imagemEscolhida"] .",".
        $dados["tipoTela"]
        ;
        return $str;
    }

    public static function retornaParametros(String $parametros = null, $retornaDefault = false) : array
    {
        if($parametros=='') $parametros = null;
        $parametros = $parametros ?? null;
        if(!$retornaDefault  && !$parametros) return [];


        $parametros = $parametros ?? "storage/frases/template/fontes/montserrat/bold.ttf,#ffffff,storage/frases/template/fontes/montserrat/regular.ttf,38,10,1,22,80,0,80,80,100,cororido,000000_#fffd61.cor,chapado";
        $parametros = explode(",",$parametros);
        return [
            "fonte"          => $parametros[0],
            "corFonte"       => $parametros[1],
            "fonteAutor"     => $parametros[2],
            "sizeFonte"      => $parametros[3],
            "quebra"         => $parametros[4],
            "align"          => $parametros[5],
            "sizeAutor"      => $parametros[6],
            "marginTop"      => $parametros[7],
            "marginRight"    => $parametros[8],
            "marginBottom"   => $parametros[9],
            "marginLeft"     => $parametros[10],
            "qualidade"      => $parametros[11],
            "pasta"          => $parametros[12],
            "imagemEscolhida"=> $parametros[13],
            "tipoTela"       => $parametros[14],
        ];
    }

    public function getNameFrase($type,$alt,$capa,$id=null)
    {
        if($type=="frase"){
            $ClearString       = new ClearString;
            $alt             = $ClearString->limpaCaracteresEspeciais($alt);
            $newCapa         = "/storage/frases/".$alt."-".$id.".webp";
        }
        return $newCapa;
    }

    public static function escolhaPastaAleatoria(String $tipo = "chapado") : String
    {
        if($tipo=="bg") {
            $arrPastas = ["amor","aniver","deus","denoite","familia","feminino","friends","girls","motivacao","pensativo","sad","pets","manha"];
            $retorno = "pensativo";
        } else {
            $arrPastas = ["preto","cororido"];
            $retorno = "cororido";
        }
        $rond = rand(1,count($arrPastas));
        $amir = 0;
        foreach ($arrPastas as $key => $value) {
            $amir++;
            if($rond == $amir){
                $retorno = $value;
            }
        }
        return $retorno;
    }
    /**
     * Escolher aleatoriamente qual imagem será de fundo
     *
     * @param string $tipo
     * @param array $items
     * @return String
     */
    public static function escolhaIMagemAleatoria(String $tipo = "chapado", array $items = []) : String
    {
        $rond = rand(1,count($items));
        $amir = 0;
        if($tipo=="bg") {
            $retorno = "2";
        } else {
            $retorno = "#000000_#fffd61";
        }
        foreach ($items as $key => $value) {
            $amir++;
            if($rond == $amir){
                if($tipo=="bg") {
                    $item = explode(".png?",$value);
                    $retorno = $item[0];
                }else {
                    $retorno = $value;
                }
            }
        }
        return $retorno;
    }
    /**
     * Methodo responsável por gerar a imagem jpg para download
     * precisa informar a variável $im do tipo objeto, e o caminho fisico do arquivo
     *
     * @param Object $im
     * @param [type] $path
     * @return array
     */
    public function geraIMagemParaDownload(Object $im,$path):array  
    {
        # code...
        $largura_original   = imagesx($im);
        $altura_original    = imagesy($im);

        imagejpeg($im,  $path."_download.jpg",$this->qualidade);

        return [
            "width"     => $largura_original,
            "height"    => $altura_original,
            "path"      => $path."_download.jpg"
        ];

    }

    /**
     * Methodo parecido ao mehodo anterior, porém cria a variável $im do tipo objeto
     * com base em uma capa.
     *
     * @param String $id
     * @param String $capa
     * @param [type] $path
     * @param [type] $qualidade
     * @return array
     */
    public static function geraIMagemParaDownloadFromCopy(String $capa,$path,$qualidade):array  
    {
        $im         = null;
        $extension  = PipifFunctions::getExtension($capa);
        
        //caso não tenha nenhuma extensão, sair do fluxo
        if(!$extension) return [];
        // caso formato for diferente de um dos dois abaixo, sair do fluxo
        if($extension != "jpg" && $extension != "webp" ) return [];

        // criar o objeto im
        switch ($extension) {
            case 'jpg':
                $im = imagecreatefromjpeg($path);
            break;
            case 'webp' :
                $im = imagecreatefromwebp($path);                    
            break;   
        }
        
        if(!$im) return [];
        
        # dimensões...
        $largura_original   = imagesx($im);
        $altura_original    = imagesy($im);

        //salvar o arquivo em disco
        imagejpeg($im,  $path."_download.jpg",$qualidade);
        imagedestroy($im);

        return [
            "width"     => $largura_original,
            "height"    => $altura_original,
            "path"      => $capa."_download.jpg"
        ];
    }

    /**
     * ● Projeto20221203 - 22-12-22
     * Novo padrão de imagens = Foi definido que vamos usar 
     * o padrão simples de duas imagens apenas: Uma jpg principal, e a outra em webp.
     *  = Renomear o jpg para o novo padrão, ou criar caso não exista
     *
     * @param String $capa
     * @param [type] $path
     * @param [type] $qualidade
     * @return array
     */
    public static function novoPadraoImagens(String $capa,$pathCapa,$nomeDownload,$qualidade):array  
    {

        //definição do novo nome para download
        $newPathDownload = str_replace(".webp",".jpg",$pathCapa);
        
        //testar se arquivo de download existe
        $pathDownload = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$nomeDownload);
        
        
        // dd($pathDownload,$newPathDownload,file_exists($pathDownload)) ;

        if(file_exists($pathDownload)){
            rename($pathDownload, $newPathDownload);
        }
        else{
            //Criar o arquivo jpeg a partir da imagem de capa
            $extension  = PipifFunctions::getExtension($capa);
        
            //caso não tenha nenhuma extensão, sair do fluxo
            if(!$extension) return [];
            // caso formato for diferente de um dos dois abaixo, sair do fluxo
            if($extension != "jpg" && $extension != "webp" ) return [];

            // criar o objeto im
            switch ($extension) {
                case 'jpg':
                    $im = imagecreatefromjpeg($pathCapa);
                break;
                case 'webp' :
                    $im = imagecreatefromwebp($pathCapa);                    
                break;   
            }
            
            //salvar o arquivo em disco
            imagejpeg($im,  $newPathDownload,$qualidade);
            imagedestroy($im);
        }
        //retornar os parâmetros
        return [
            "width"         => "612",
            "height"        => "612",
            "nomeDownload"  => str_replace(".webp",".jpg",$capa)
        ];
    }

    /**
     * Methodo para obter o objeto de imagem através de uma url (string) informada
     * ● Projeto20221201 = 12-12-22
     * @param String|null $capa
     * @param [type] $path
     * @return object
     */
    public static function getImgObject(String $capa = null,$path): object
    {
        $extension  = PipifFunctions::getExtension($capa);
        $im = null;
        switch ($extension) {
            case 'jpg':
                $im = imagecreatefromjpeg($path);
            break;
            case 'webp' :
                $im = imagecreatefromwebp($path);                    
            break;   
        }

        return $im;
    }
    
    /**
     * Methodo para obter a extenção de um arquivo através de uma string
     * ● Projeto20221201 = 12-12-22
     * @param String|null $capa
     * @return String
     */
    public static function getExtension(String $capa = null): String
    {
        $arrExtension = explode(".", $capa);

        if(isset($arrExtension[1])){
            $extension = $arrExtension[1];    
        }
        if(isset($arrExtension[2])){
            $extension = $arrExtension[2];    
        }
        if(isset($arrExtension[3])){
            $extension = $arrExtension[3];    
        }
        if(isset($arrExtension[4])){
            $extension = $arrExtension[4];    
        }

        return $extension;
    }
    public function editarImagemTranca(String $var = null)
    {
        # code...
    }
}
