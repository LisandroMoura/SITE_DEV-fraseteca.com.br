<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\FrasesCreateRequest;
use App\Http\Requests\FrasesUpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Entities\FrasesFavoritas;
use App\Entities\Post;
use App\Entities\PostsItens;
use App\Entities\Frases;
use App\Entities\Tag;
use App\Services\ClearString;
use App\Services\Mensagens;
use App\Services\Marlon;
use App\Services\ImageCreateGenerate;
use App\Services\PostRelacionados;
use App\Services\ParamGlobal;
use App\Services\PipifFunctions;

// REVER OS PROECSSOS DE CRIAÇÃO DE IMAGEM NESTE CONTROLLER
// REVER O METHODO DESTROY PAR DELETAR FISICAMENTE UMA IMAGEM
class ModelBackFrase extends Controller
{
    protected $service_mensagens;
    protected $postRelacionados;
    protected $imageCreate;

    public function __construct(
        Mensagens  $service_mensagens,
        ImageCreateGenerate $imageCreate,
        PostRelacionados  $postRelacionados
    ) {
        $this->service_mensagens = $service_mensagens;
        $this->imageCreate  = $imageCreate;
        $this->postRelacionados = $postRelacionados;
    }

    public function store(FrasesCreateRequest $request)
    {
        try {
            $validated = $request->validate([
                'url_longa_amigavel' => 'required',
            ]);
            $dados = $request->all();
            $frases = Frases::create($dados);
            $retorno = [
                'sucesso'     => true,
                'titulo_msg'  => 'Certo!',
                'msg'         => 'Registro inserido',
                'data'        => $frases->toArray(),
            ];
            if ($request->wantsJson()) {
                return response()->json($retorno);
            }
            return redirect()->back()->withErrors($retorno);
        } catch (\Throwable $e) {
            $retorno = [
                'sucesso' => false,
                'titulo_msg'    => 'Vish!',
                'msg' => 'Erro nesta rotina',
            ];
            if ($request->wantsJson()) return response()->json($retorno);
            return redirect()->back()->withErrors($retorno);
        }
    }

    public function save(FrasesUpdateRequest $dados)
    {
        $mensagens_cadastro = $this->service_mensagens->mensagens_cadastro;
        $lgeraImagem = false;
        $tipo_imagem = "0";

        if (!isset($dados->all()['frase_id'])) {
            $response = [
                'sucess'     => false,
                'titulo_msg' => $mensagens_cadastro['titulo_erro'],
                'msg'        => "Não informado Id",
                'data'       => null,
            ];
        } else {
            $id = $dados->all()['frase_id'];
            $frase_old = Frases::find($id);
            $ver = "01";
            if ($frase_old) :
                if ($dados->all()['frase'] != $frase_old->frase)
                    $lgeraImagem = true;
                if ($dados->all()['autor'] != $frase_old->autor)
                    $lgeraImagem = true;
                $tipo_imagem = $frase_old->$tipo_imagem;
            endif;
            //run repository
            $execucao = Frases::find($id);
            $execucao->update($dados->all());
            $response = [
                'sucesso'       => true,
                'titulo_msg'    => $mensagens_cadastro['titulo_sucesso'],
                'msg'           => "Frase: " . $id . " alterada com sucesso!",
                'data'      => $execucao->toArray(),
            ];
            if ($lgeraImagem)
                $this->imageCreate->run(
                    "frase_" . $id . "_" . $ver,
                    $dados->all()['frase'],
                    $dados->all()['autor'],
                    $tipo_imagem //03_dez ajuste do ERROR: Undefined index: tipo_imagem
                );
        }
        return response()->json($response);
    }

    public function update(FrasesUpdateRequest $request, $id)
    {
        $dados = $request->all();
        $file  = $dados["capa"];
        $response = "";
        try {
            $validated = $request->validate([
                "file"   => 'mimes:jpg,bmp,png'
            ]);
            //code...
        } catch (\Throwable $th) {
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => "Ops",
                'msg'           => "Formato de imagem incorreto.",
                'data'          => [],
            ];
            return redirect()->back()->withErrors($retorno);
        }
        if (substr($file, 0, 10) == "data:image") {
            if ($dados["capaupload"] == "trancado") {
                $retorno = [
                    'sucesso'       => false,
                    'titulo_msg'    => "Ops",
                    'msg'           => "Imagem está trancada, tente destrancá-la antes de alterar a capa",
                    'data'          => [],
                ];
                return redirect()->back()->withErrors($retorno);
            }
            //rodar o upload ad imagem
            $image_string = str_replace("data:image/png;base64,", "", $file);
            $image_string = str_replace("data:image/jpeg;base64,", "", $image_string);
            $image_string = base64_decode($image_string);

            $im = imagecreatefromstring($image_string);


            $nome = "frase_" . $id . "_01";
            if ($dados["alt"] != "") {
                $ClearString = new ClearString;
                $alt = $ClearString->limpaCaracteresEspeciais($dados["alt"]);

                $nome = $alt . "-" . $id;
                $pre = $this->imageCreate->preDeleteImageFrases($id);
                $this->imageCreate->generateLogFrasesUpdate($id, "U");
                // $frase = Frases::find($id);
                // if($frase){
                //     if ($frase->cdn!=1 && $frase->capa!="")                    
                //         $arquivo_que_sera_deletado = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$frase->capa);
                //     if (file_exists($arquivo_que_sera_deletado))
                //         unlink($arquivo_que_sera_deletado);
                //     // deletar o arquivo webp e pendente.webp
                //     if (file_exists($arquivo_que_sera_deletado.".webp"))
                //         unlink($arquivo_que_sera_deletado.".webp");
                //     if (file_exists($arquivo_que_sera_deletado."_pdwebp.jpg"))
                //         unlink($arquivo_que_sera_deletado."_pdwebp.jpg");
                // }
            }
            $imgSrc = "storage/frases/" . $nome . ".jpg";
            imagejpeg($im,  $imgSrc, 100);
            imagedestroy($im);
            $dados["capa"] = "/" . $imgSrc;
            $dados["physical_name"] = "/" . $imgSrc;
            $dados["capaupload"] = "trancado";
            $copy = $this->imageCreate->createPdwebp($imgSrc);
        }
        try {
            $frase = Frases::find($id);
            // ● 24-ago-22 LM Projeto20220804 - SEO parametros para a Single de frase
            $analytics              = $dados["analytics"] ?? false;
            $lazyOn                 = $dados["lazyOn"] ?? false;
            $preloadImages          = $dados["preloadImages"] ?? false;
            $preloadFonte           = $dados["preloadFonte"] ?? false;
            $lazyAds                = $dados["lazyAds"] ?? false;
            $tipoAnuncio            = $dados["tipoAnuncio"] ?? false;

            $dados["seoparam"]      = $analytics . ";" . $lazyOn . ";" . $preloadImages . ";" . $preloadFonte . ";" . $tipoAnuncio . ";false;" . $lazyAds . ";" ;
            $dados["anuncios"]      = $dados["anuncios"] ?? "false";
            $dados["imagemforte"]   = $dados["imagemforte"] ?? "";
            if(isset($dados["imagemforte"]))
                $dados["imagemforte"] = $frase->capa."|".$frase->dimensoes;
            
            $frase->update($dados);
            $retorno = [
                'sucesso'       => true,
                'titulo_msg'    => "Sucesso!",
                'msg'           => "Registro alterdo com sucesso",
            ];
            if (isset($dados['txtTagsNovas']))
                if ($dados['txtTagsNovas']) {
                    $tagsParaGravar = explode(",", $dados['txtTagsNovas']);
                    foreach ($tagsParaGravar as $key => $tag) {
                        if ($tag != '') :
                            $this->postRelacionados->novaTag($tag, $id);
                            $this->postRelacionados->salvaTagFrases($tag, $id);
                        endif;
                    }
                }
            if (isset($dados['tags']))
                if ($dados['tags']) {
                    $tagsParaGravar = explode(",", $dados['tags']);
                    foreach ($tagsParaGravar as $key => $tag) {
                        if ($tag != '') :
                            $this->postRelacionados->salvaTagFrases($tag, $id);
                        endif;
                    }
                    $this->postRelacionados->limpaTagFrases($tagsParaGravar, $id);
                }
            if ($request->wantsJson()) {
                return response()->json($response);
            }
        } catch (\Throwable $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => "erro neste processo"
                ]);
            }
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => "erro de execução",
                'msg'           => '',
            ];
        }
        return redirect()->back()->withErrors($retorno);
    }

    public function destroy($id)
    {
        $retorno = [];
        $FraseFavoritaColect = FrasesFavoritas::where('frase_id', $id)->delete();
        $PostitensColect = PostsItens::where('frase_id', $id)->delete();
        $fraseDeletada = Frases::find($id);
        $deleted = Frases::find($id);
        if ($deleted) $deleted->delete();
        if ($deleted) :
            if ($fraseDeletada) {
                $pre = $this->imageCreate->preDeleteImageFrases($id);
                $this->imageCreate->generateLogFrasesUpdate($id, "D");
                // if ($fraseDeletada->cdn!=1 && $fraseDeletada->capa!="")                    
                //     $arquivo_que_sera_deletado = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$fraseDeletada->capa);
                // if (file_exists($arquivo_que_sera_deletado))
                //     unlink($arquivo_que_sera_deletado);                    
                // // deletar o arquivo webp e pendente.webp
                // if (file_exists($arquivo_que_sera_deletado.".webp"))
                //     unlink($arquivo_que_sera_deletado.".webp");
                // if (file_exists($arquivo_que_sera_deletado."_pdwebp.jpg"))
                //     unlink($arquivo_que_sera_deletado."_pdwebp.jpg");

            }
            $mensagens_cadastro = $this->service_mensagens->mensagens_cadastro;
            $retorno = [
                'sucesso'       => true,
                'titulo_msg'    => $mensagens_cadastro['titulo_sucesso'],
                'msg'           => $mensagens_cadastro['delete_sucesso'],
            ];

        else :
            $mensagens_cadastro = $this->service_mensagens->mensagens_cadastro;
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => $mensagens_cadastro['titulo_sucesso'],
                'msg'           => $mensagens_cadastro['posts_delete_erros'],
            ];
        endif;

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Frases deleted.',
                // 'deleted' => $deleted,
            ]);
        }
        //mudar aqui a rota
        return redirect()->route('admin.gestao_frases', 'todas')->withErrors($retorno);
    }

    public function lixeira($id)
    {
        $mensagens_cadastro = $this->service_mensagens->mensagens_cadastro;
        try {
            $frase = Frases::find($id);
            $frase->status = "9";
            $frase->save();
            $retorno = [
                'sucesso'       => true,
                'titulo_msg'    => $mensagens_cadastro['titulo_sucesso'],
                'msg'           => $mensagens_cadastro['update_sucesso'],
            ];
            return redirect()->back()->withErrors($retorno);
        } catch (\Throwable $e) {
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => $mensagens_cadastro['titulo_erro'],
                'msg'           => $mensagens_cadastro['posts_update_erros'],
            ];
            return redirect()->back()->withErrors($retorno);
        }
    }

    public function retirarLixeira($id)
    {
        try {
            $frase = Frases::find($id);
            $frase->status = "1";
            $frase->save();
            $mensagens_cadastro = $this->service_mensagens->mensagens_cadastro;
            $retorno = [
                'sucesso'       => true,
                'titulo_msg'    => $mensagens_cadastro['titulo_sucesso'],
                'msg'           => $mensagens_cadastro['update_sucesso'],
            ];
            return redirect()->back()->withErrors($retorno);
        } catch (\Throwable $e) {
            $mensagens_cadastro = $this->service_mensagens->mensagens_cadastro;
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => $mensagens_cadastro['titulo_erro'],
                'msg'           => $mensagens_cadastro['posts_update_erros'],
            ];
            return redirect()->back()->withErrors($retorno);
        }
    }

    public function zerarPipif(FrasesUpdateRequest $request)
    {

        $id = $request->all()["id"];
        $retorno = [
            'sucesso'       => false,
            'titulo_msg'    => "Erro:",
            'msg'           => "Registro não encontrado",
        ];

        if (!isset($id)) {
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => "Erro:",
                'msg'           => "Registro não encontrado",
            ];
            return redirect()->back()->withErrors($retorno);
        }
        $frase = Frases::find($id);
        if ($frase) {

            if($frase->capaupload=="trancado"){
                $retorno = [
                    'sucesso'       => false,
                    'titulo_msg'    => "Ops:",
                    'msg'           => "Imagem está trancada, não podemos rodar o PipiF",
                ];
                return redirect()->back()->withErrors($retorno);
            }


            $frase->parametros = "";
            $frase->save();

            $retorno = [
                'sucesso'       => true,
                'titulo_msg'    => "Ok:",
                'msg'           => "TUDO ZERAAADOOO",
            ];
            return redirect()->route('frase.edit', $id)->withErrors($retorno);
        }
    }
    /**
     * Gerar imagens para Download
     *
     * @param FrasesUpdateRequest $request
     * @return void
     */
    public function postPipifgeraIMagemParaDownloadFromCopy(FrasesUpdateRequest $request)
    {
        /**
         * 
         * iniciar os parametros recebidos do Form
         * ● Projeto20221201 - 11-12-22 -  Methodo Adaptado para também gerar a imagem 
         *   jpeg das frases com o status de "trancadas para edição" de toda uma lista.         
         */ 
        $postId                 = $request->all()["id"];
        $qualidade              = $request->all()["qualidade"] ?? "100";
        /**
         * Buscar as Frases da Lista
         */
        $PostitensColect = PostsItens::where(
            [
                ['post_id' , "=", $postId],
                ['tipo' , "=", '1']
            ])->get();
        foreach ($PostitensColect as $key => $item) {
            /**
             * Posicionar-se na tabela frase
             */
            $frase = [];
            $frase = Frases::find($item->frase_id);
            if ($frase) {
                /**
                 * executar o metodo individual por frase da PipiF
                 */
                // ● Projeto20221201 - gerar a cópia jpeg também para as frases trancadas
                $path = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$frase->capa);
                if (!file_exists($path)){
                    $retorno = [
                        'sucesso'       => false,
                        'titulo_msg'    => "Não achei a imagem Principal para a frase :" . $frase->id,
                        'msg'           => "Deu pau!. " . $frase->capa ,
                    ];
                    return redirect()->back()->withErrors($retorno);
                }

                    

                //execução do methodo principal do serviço para esta feature
                //● Projeto20221201 - 11-12-22 - Remoção do parâmetro não utiliado "id" da assinatura do methodo
                $retornoDownload = \App\Services\PipifFunctions::geraIMagemParaDownloadFromCopy($frase->capa,$path,$qualidade);


                // dd($frase->capa,$retornoDownload);
                // 19-ago-2022: LM - ● Projeto20220801 - Download de JPEG
                if(isset($retornoDownload["path"])){
                    $frase->nomeDownload = $retornoDownload["path"];
                    $frase->save();
                }
            }
        }
        /**
         * retornar para o formulário das lista
         */
        $retorno = [
            'sucesso'       => true,
            'titulo_msg'    => "PipiF Imagem para Download:",
            'msg'           => "PipiEf Executada. " ,
        ];
        return redirect()->back()->withErrors($retorno);
    }

    /**
     * ● Projeto20221203 - 22-12-22
     * Novo padrão de imagens = Foi definido que vamos usar 
     * o padrão simples de duas imagens apenas: Uma jpg principal, e a outra em webp.
     *
     * @param FrasesUpdateRequest $request
     * @return void
     */
    public function postPipifNovoPadraoImagens(FrasesUpdateRequest $request)
    {
        $postId                 = $request->all()["id"];
        $qualidade              = $request->all()["qualidade"] ?? "100";
        $qtItens = 0;
        /**
         * Buscar as Frases da Lista
         */
        $PostitensColect = PostsItens::where(
            [
                ['post_id' , "=", $postId],
                ['tipo' , "=", '1']
            ])->get();
        foreach ($PostitensColect as $key => $item) {
            /**
             * Posicionar-se na tabela frase
             */
            $frase = [];
            $frase = Frases::find($item->frase_id);
            if ($frase) {
                /**
                 * executar o metodo individual por frase da PipiF
                 */
                $path = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$frase->capa);
                if (!file_exists($path)){
                    $retorno = [
                        'sucesso'       => false,
                        'titulo_msg'    => "Não achei a imagem Principal para a frase :" . $frase->id,
                        'msg'           => "Deu pau!. " . $frase->capa ,
                    ];
                    return redirect()->back()->withErrors($retorno);
                }
                //execução do methodo principal do serviço para esta feature
                $retornoNovoPadrao   = \App\Services\PipifFunctions::novoPadraoImagens($frase->capa,$path,$frase->nomeDownload,$qualidade);
                $frase->nomeDownload = $retornoNovoPadrao["nomeDownload"] ?? $frase->nomeDownload;
                $frase->save();
                $qtItens++;
            }
        }
        /**
         * retornar para o formulário das lista
         */
        $retorno = [
            'sucesso'       => true,
            'titulo_msg'    => "Novo padrão de imagens executado para: (" . $qtItens . ") itens",
            'msg'           => "PipiEf Executada." ,
        ];
        return redirect()->back()->withErrors($retorno);
    }

    public function postPipif(FrasesUpdateRequest $request)
    {
        /**
         *iniciar os parametros recebidos do Form
         */
        $postId = $request->all()["id"];
        $pasta_bg = $request->all()["pasta_bg"] ?? "";
        $qualidade = $request->all()["qualidade"] ?? "100";
        $pasta_chapado = $request->all()["pasta_chapado"] ?? "";
        $frasesNaoExecutadas = "Tudo certo";

        $padraochapado = $request->all()["padraochapado"] ?? "";

        if($padraochapado=="padraochapado")
            $pasta_bg = "padraochapado";

        /**
         * Buscar as Frases da Lista
         */
        $PostitensColect = PostsItens::where(
            [
                ['post_id' , "=", $postId],
                ['tipo' , "=", '1']
            ])->get();
        foreach ($PostitensColect as $key => $item) {
            /**
             * Posicionar-se na tabela frase
             */
            $frase = [];
            $frase = Frases::find($item->frase_id);
            if ($frase) {
                /**
                 * executar o metodo individual por frase da PipiF
                 */
                if($frase->capaupload!="trancado"){
                    $fraseRetorno = $this->pipifRunIndividual($frase,$pasta_bg,$pasta_chapado,$qualidade); 
                    /**
                     * se houve algum problema na execução, trazer na tela
                     */
                    if(!$fraseRetorno["sucesso"]){
                        if($frasesNaoExecutadas == "Tudo Certo") $frasesNaoExecutadas="";
                        $frasesNaoExecutadas .= " - " . $fraseRetorno["msg"]; 
                    }
                }
            }
        }
        /**
         * retornar para o formulário das lista
         */
        $retorno = [
            'sucesso'       => true,
            'titulo_msg'    => "PipiF:",
            'msg'           => "PipiEf Executada. " . $frasesNaoExecutadas ,
        ];
        return redirect()->back()->withErrors($retorno);
    }

    public function pipifRunIndividual($frase,$pasta_bg,$pasta_chapado,$qualidade)
    {
        /**
         * Buscar os parametros desta frase
         */
        if($frase->capaupload=="trancado"){
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => "Ops:",
                'msg'           => "Imagem está trancada, não podemos rodar o PipiF",
            ];
            return $retorno;
        }
        $parametros = \App\Services\PipifFunctions::retornaParametros($frase->parametros,true);


        /**
         * instanciar as funções do Pipif
         */
        $qualidade = $qualidade ?? $parametros["qualidade"];
        $parametros["qualidade"] = $qualidade;

        $ImageCreateGenerate = new PipifFunctions(
            $parametros["fonte"], 
            $parametros["corFonte"], 
            $parametros["fonteAutor"], 
            $parametros["sizeFonte"], 
            $parametros["quebra"], 
            $parametros["align"], 
            $parametros["sizeAutor"], 
            $parametros["marginTop"], 
            $parametros["marginRight"], 
            $parametros["marginBottom"], 
            $parametros["marginLeft"], 
            $qualidade);

        if($pasta_bg == "padraochapado") {
            $tipoTela           = "padraochapado";
            $pasta              = $pasta_chapado;
            $items              = \App\Services\PipifFunctions::buscaPaletasBG("$pasta_chapado");
            $imagemEscolhida    = \App\Services\PipifFunctions::escolhaIMagemAleatoria("chapado",$items);


        }
        else{
            if ($ImageCreateGenerate->validateIsBg($frase->frase, $frase->autor)) {
                $tipoTela           = "bg";
                $pasta              = $pasta_bg;
                $items              = \App\Services\PipifFunctions::buscaImagensBG("$pasta_bg");
                $imagemEscolhida    = \App\Services\PipifFunctions::escolhaIMagemAleatoria("bg",$items);
            } else {
                $tipoTela           = "chapado";
                $pasta              = $pasta_chapado;
                $items              = \App\Services\PipifFunctions::buscaPaletasBG("$pasta_chapado");
                $imagemEscolhida    = \App\Services\PipifFunctions::escolhaIMagemAleatoria("chapado",$items);
            }
        }       
        /**
         * Abaixo, vamos garantir que seja preservado sempre o mesmo fundo da frase, ou seja, aplique-se
         * sempre o último fundo gerado para aquela imagem, Caso queira mudar o BG da frase, nós podemos
         * executar o PipiF direto na edição da single de Frase.
         */
        if($frase->parametros !="" && $pasta_bg != "padraochapado" && $pasta_bg ==$parametros["pasta"]){
            // 17-ago-22, LM Bug de não gerar imagem correta
            //o sistema esta trazendo dos parâmetros da frase o campo $parametros["imagemEscolhida"]
            // que pode ter um numero diferente do item, dentro da pasta escolhida la no post;
            $imagemEscolhida= $parametros["imagemEscolhida"];
        }

        /**
         * execução do PipiF, propriamente dita
         */
        $capa = $frase->capa;
        $autor = $frase->autor ?? "";
        if($capa=="")
            $capa = $ImageCreateGenerate->getNameFrase("frase",substr($frase->frase,0,110),"",$frase->id);

        // if($frase->id == "2887") dd($capa, $frase->frase, $frase->capa);
        $retorno = $ImageCreateGenerate->run($capa,
                                            $frase->frase, 
                                            $autor, 
                                            $tipoTela,
                                            $pasta,
                                            $imagemEscolhida,
                                            count($items),
                                            "singular");
        
        /**
         * Retornar as falhas da execução
         */
        if(!$retorno["sucess"]){
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => "Erro:",
                'msg'           => "Frase: " .$frase->id. " deu problema: " .  $retorno["msg"],
            ];
            return $retorno;
        }
        
        /**
         * Agora, Vamos salvar os parametros que foram executados
         */
        $strParametros          = $parametros = \App\Services\PipifFunctions::retornaStrParametros($parametros,$tipoTela,$pasta,$imagemEscolhida);
        $nomeMobile             = $retorno["path"]."_mobile.webp";
        
        if(isset($retorno["mobile"])) $retorno["dimensoes"] .="|".$retorno["mobile"]["width"]."x".$retorno["mobile"]["height"];
        $frase->dimensoes       = $retorno["dimensoes"];
        $frase->parametros      = $strParametros;
        $frase->nomeMobile      = $nomeMobile;
        // $frase->capa            = $capa;
        // $frase->physical_name   = $capa;

        $frase->capa            = $retorno["path"];
        $frase->physical_name   = $retorno["path"];

        // 19-ago-2022: LM - ● Projeto20220801 - Download de JPEG
        if(isset($retorno["nomeDownload"]["path"])){
            $frase->nomeDownload = $retorno["path"]."_download.jpg";
        }

        $frase->save();

        $retorno = [
            'sucesso'       => true,
            'titulo_msg'    => "Ok:",
            'msg'           => "Frase: " .$frase->id. " rodou com sucesso",
        ];
        return $retorno;
    }

    /**
     * ● Processo auxiliar do PipiF usado para regerar as imagens de download jpg 
     *   das imagens com o Status de TRANCADAS 
     * ● Projeto20221201 - Regerar Jpg para imagens trancadas - 10-12-22
     * ● Requeriments: 
     *   - Gerar as imagens para uma single de frase. Existe outro processo na "lista" para executar em bloco
     * @param FrasesUpdateRequest $request
     * @return void
     */
    public function regerarAuxiliaresPipif(FrasesUpdateRequest $request)
    {
        $id = $request->all()["id"];
        //criticar e existência da Frase
        $frase = Frases::find($id);
        if (!$frase) {
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => "Ops:",
                'msg'           => "Alqum problema como ID da frase, contate o Admim do sistema",
            ];
            return redirect()->back()->withErrors($retorno);
        }

        // - Iniciar a instância do PipiF 
        //   para informar alguns parâmetros (dentre eles a qualidade da compressão da imagem)
        $parametros = \App\Services\PipifFunctions::retornaParametros($frase->parametros,true);

        // criticando o nome físico da imagem
        $path = \storage_path(). "/app/public/frases/" . str_replace('/storage/frases/','',$frase->capa);
        if (!file_exists($path)) {
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => "Ops:",
                'msg'           => "Alqum problema como nome físico da imagem: $path, contate o ADMIN",
            ];
            return redirect()->back()->withErrors($retorno);
        }

        //Execução do processo
        $retornoDownload = \App\Services\PipifFunctions::geraIMagemParaDownloadFromCopy($frase->capa,$path,$parametros["qualidade"]);

        //testa se a execução for OK, para gravar o registro na tabela
        if(isset($retornoDownload["path"])){
            $frase->nomeDownload = $retornoDownload["path"];
            $frase->save();
        }

        $retorno = [
            'sucesso'       => true,
            'titulo_msg'    => "Ok:",
            'msg'           => "Imagens Auxiliares geradas com sucesso",
        ];
        return redirect()->route('frase.edit', $id)->withErrors($retorno);
    }

    public function iniciarPipif(FrasesUpdateRequest $request)
    {
        $id = $request->all()["id"];
        $retorno = [
            'sucesso'       => false,
            'titulo_msg'    => "Erro:",
            'msg'           => "Registro não encontrado",
        ];

        if (!isset($id)) {
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => "Erro:",
                'msg'           => "Registro não encontrado",
            ];
            return redirect()->back()->withErrors($retorno);
        }
        $frase = Frases::find($id);
        if ($frase) {

            if($frase->capaupload=="trancado"){
                $retorno = [
                    'sucesso'       => false,
                    'titulo_msg'    => "Ops:",
                    'msg'           => "Imagem está trancada, não podemos rodar o PipiF",
                ];
                return redirect()->back()->withErrors($retorno);
            }
            $parametros = \App\Services\PipifFunctions::retornaParametros($frase->parametros,true);
            if(isset($request->all()["tipoTela"]))
                $tipoTela = $request->all()["tipoTela"];
            $ImageCreateGenerate = new PipifFunctions(
                $parametros["fonte"], 
                $parametros["corFonte"], 
                $parametros["fonteAutor"], 
                $parametros["sizeFonte"], 
                $parametros["quebra"], 
                $parametros["align"], 
                $parametros["sizeAutor"], 
                $parametros["marginTop"], 
                $parametros["marginRight"], 
                $parametros["marginBottom"], 
                $parametros["marginLeft"], 
                $parametros["qualidade"]);

            $imagemEscolhida= $parametros["imagemEscolhida"];
            if ($ImageCreateGenerate->validateIsBg($frase->frase, $frase->autor)) {
                $tipoTela = "bg";
                $pasta = \App\Services\PipifFunctions::escolhaPastaAleatoria("bg");
                $items = \App\Services\PipifFunctions::buscaImagensBG("$pasta");
                $imagemEscolhida  = \App\Services\PipifFunctions::escolhaIMagemAleatoria("bg",$items);

            } else {
                $tipoTela = "chapado";
                $pasta = \App\Services\PipifFunctions::escolhaPastaAleatoria("chapado");
                $items = \App\Services\PipifFunctions::buscaPaletasBG("$pasta");
                $imagemEscolhida  = \App\Services\PipifFunctions::escolhaIMagemAleatoria("chapado",$items);
            }

            $autor = $frase->autor ?? "";
            $capa = $frase->capa;
            if($capa=="")
                $capa = $ImageCreateGenerate->getNameFrase("frase",substr($frase->frase,0,110),"",$frase->id);
            $retorno = $ImageCreateGenerate->run($capa,
                                                $frase->frase, 
                                                $autor, 
                                                $tipoTela,
                                                $pasta,
                                                $imagemEscolhida,
                                                count($items),
                                                "singular");
            
            if(!$retorno["sucess"]){

                $retorno = [
                    'sucesso'       => false,
                    'titulo_msg'    => "Erro:",
                    'msg'           => "Erro na execução do PIPIF: " . $retorno["msg"],
                ];
                return redirect()->route('frase.edit', $id)->withErrors($retorno);
            }
            $strParametros =  $parametros = \App\Services\PipifFunctions::retornaStrParametros($parametros,$tipoTela,$pasta,$imagemEscolhida);
            $nomeMobile   = $retorno["path"]."_mobile.webp";
            
            if(isset($retorno["mobile"])) $retorno["dimensoes"] .="|".$retorno["mobile"]["width"]."x".$retorno["mobile"]["height"];
            $frase->dimensoes  = $retorno["dimensoes"];
            $frase->parametros = $strParametros;
            $frase->nomeMobile = $nomeMobile;
            $frase->capa       = $retorno["path"];
            $frase->physical_name = $retorno["path"];

            // 19-ago-2022: LM - ● Projeto20220801 - Download de JPEG
            if(isset($retorno["nomeDownload"]["path"])){
                $frase->nomeDownload = $retorno["path"]."_download.jpg";
            }
            
            $frase->save();

            $retorno = [
                'sucesso'       => true,
                'titulo_msg'    => "Ok:",
                'msg'           => "IMagem gerada com sucesso",
            ];
            return redirect()->route('frase.edit', $id)->withErrors($retorno);
        }
        return redirect()->route('frase.edit', $id)->withErrors($retorno);
    }

    public function runPipif(FrasesUpdateRequest $request)
    {
        $id = $request->all()["id"];
        $retorno = [
            'sucesso'       => false,
            'titulo_msg'    => "Erro:",
            'msg'           => "Registro não encontrado",
        ];

        if (!isset($id)) {
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => "Erro:",
                'msg'           => "Registro não encontrado",
            ];
            return redirect()->back()->withErrors($retorno);
        }
        $frase = Frases::find($id);
        if ($frase) {

            if($frase->capaupload=="trancado"){
                $retorno = [
                    'sucesso'       => false,
                    'titulo_msg'    => "Ops:",
                    'msg'           => "Imagem está trancada, não podemos rodar o PipiF",
                ];
                return redirect()->back()->withErrors($retorno);
            }


            $dados = $request->all();
            //pegar os parâmetro informados em tela mesclando com os demais
            $parametros = \App\Services\PipifFunctions::retornaParametros($frase->parametros,true);
            //salvar os parametros que vem da execução do form
            $parametros["corFonte"]     = $dados["corFonte"]; 
            $parametros["sizeFonte"]    = $dados["sizeFonte"]; 
            $parametros["quebra"]       = $dados["quebra"]; 
            $parametros["align"]        = $dados["align"] ;
            $parametros["marginTop"]    = $dados["marginTop"] ;
            $parametros["marginRight"]  = $dados["marginRight"];
            $parametros["marginBottom"] = $dados["marginBottom"];
            $parametros["marginLeft"]   = $dados["marginLeft"];
            $parametros["qualidade"]    = $dados["qualidade"];

            $tipoTela = $parametros["tipoTela"];
            $ImageCreateGenerate = new PipifFunctions(
                $parametros["fonte"], 
                $parametros["corFonte"], 
                $parametros["fonteAutor"], 
                $parametros["sizeFonte"], 
                $parametros["quebra"], 
                $parametros["align"], 
                $parametros["sizeAutor"], 
                $parametros["marginTop"], 
                $parametros["marginRight"], 
                $parametros["marginBottom"], 
                $parametros["marginLeft"], 
                $parametros["qualidade"]);

            $capa = $frase->capa;
            $autor = $frase->autor ?? "";
            if($autor=="null" || $autor==null ) $autor="";
            if($capa=="")
                $capa = $ImageCreateGenerate->getNameFrase("frase",substr($frase->frase,0,110),"",$frase->id);

            $retorno = $ImageCreateGenerate->run($capa,
                                                $frase->frase, 
                                                $autor, 
                                                $tipoTela,
                                                $dados["pasta"],
                                                $dados["imagemEscolhida"],
                                                0,
                                                "singular");
            
            if(!$retorno["sucess"]){
                $retorno = [
                    'sucesso'       => false,
                    'titulo_msg'    => "Erro:",
                    'msg'           => "Erro na execução do PIPIF: " . $retorno["msg"],
                ];
                return redirect()->route('frase.edit', $id)->withErrors($retorno);
            }
            $strParametros =  $parametros = \App\Services\PipifFunctions::retornaParametrosDeForm($parametros,$dados);

            if(isset($retorno["mobile"])) $retorno["dimensoes"] .="|".$retorno["mobile"]["width"]."x".$retorno["mobile"]["height"];
            $frase->parametros      = $strParametros;
            $nomeMobile             = $retorno["path"]."_mobile.webp";
            $frase->dimensoes       = $retorno["dimensoes"];
            $frase->parametros      = $strParametros;
            $frase->nomeMobile      = $nomeMobile;
            $frase->capa            = $retorno["path"];
            $frase->physical_name   = $retorno["path"];

            // 19-ago-2022: LM - ● Projeto20220801 - Download de JPEG
            if(isset($retorno["nomeDownload"]["path"])){
                $frase->nomeDownload = $retorno["path"]."_download.jpg";
            }

            $frase->save();
            $retorno = [
                'sucesso'       => true,
                'titulo_msg'    => "Ok:",
                'msg'           => "IMagem ALTERADA COM SUCESSOOO!",
            ];
            return redirect()->route('frase.edit', $id)->withErrors($retorno);
        }
        return redirect()->route('frase.edit', $id)->withErrors($retorno);
    }

    public function ricardo(Request $request)
    {
        
        $tipoTela = $request["tipoTela"];
        $pasta    = $request["pasta"];
        
        if($tipoTela == "bg")
            $items = \App\Services\PipifFunctions::buscaImagensBG("$pasta");
        else    
            $items = \App\Services\PipifFunctions::buscaPaletasBG("$pasta");
        
        $data = [];
        $nitens=0;
        $data["message"]=true;
        $data["dados"]=[];

        if($tipoTela == "bg")
            foreach ($items as $key => $item) {
                $nitens++;
                $numeros = explode(".png", $item);
                if($numeros[1])
                    $id = $numeros[0]; 

                array_push($data["dados"],[
                    'image' => $id.".png" ,
                    "id" => $id,
                    "font" => "",
                ]);
            }
        else{
            foreach ($items as $key => $item) {
                $nitens++;
                $numeros = explode(".cor", $item);
                if($numeros[0])
                    $id = $numeros[0]; 
                $cor = explode("_#",$item);

                array_push($data["dados"],[
                    'image' => $cor[0] ,
                    "id" => $id,
                    "font" => $cor[1],
                ]);
            }
        }
        $data["ncount"] = $nitens;
        return response()->json($data);
    }

    public function frasesInserir()
    {
        $usuariologado = Auth::user();
        $paramGlobal    = new ParamGlobal;
        $global         = $paramGlobal->get('arr');
        $options = json_encode([
            'tipo' => 'multiple',
            'width'             => $global['limit_width'],
            'height'            => $global['limit_height'],
            'tamanho'           => $global['tamanho_upload_adm'],
            'textoTamanho'      => $global['txt_tamanho_upload_adm'],
            'clientIdUnsplash'  => $global['clientIdUnsplash'],
            'collectionDefault' => $global['collectionDefault'],
            'perPageUnsplash'   => $global['perPageUnsplash'],
            'keyYandex'         => $global['keyYandex'],
            'convite'           => $global['convite'],
        ]);
        return view('back.FraseForm', [
            'logado'   => $usuariologado,
            'options'  => $options
        ]);
    }

    public function edit($id)
    {
        $post = Frases::find($id);
        $paramGlobal    = new ParamGlobal;
        $global         = $paramGlobal->get();
        $usuariologado  = Auth::user();
        $lduplicadas    = false;
        $items          = [];
        $pasta          = "";
        if ($post) {
            $marlon = new Marlon;
            $arrFrases = $marlon->getSituacaoDaFrase($id);
            $tagsum  = Tag::all();

            $parametros = \App\Services\PipifFunctions::retornaParametros($post->parametros, false);
            if($parametros){
                $pasta = $parametros["pasta"];
                if($parametros["tipoTela"]=="chapado") {
                    $items = \App\Services\PipifFunctions::buscaPaletasBG("$pasta");
                } else {
                    $items = \App\Services\PipifFunctions::buscaImagensBG("$pasta");
                }
            }
            return view('back.FraseForm', [
                'tabela'        => $post,
                'lduplicadas'   => $lduplicadas,
                'tagsum'        => $tagsum,
                "parametros"    => $parametros,
                'arrFrases'     => $arrFrases,
                "pastaItems"    => $items,
                "pasta"         => $pasta,
                'logado'        => $usuariologado,
                'options'       => $global,
            ]);
        } else {
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => "Erro:",
                'msg'           => "Registro não encontrado",
            ];
            return redirect()->back()->withErrors($retorno);
        }
    }

    public function compartilharFraseAmp($id, $tipo)
    {
        $url = env("APP_URL");
        $imgSrc = asset('images/padrao.jpg');
        if ($tipo == "f") {
            $tabela = Frases::find($id);
            if ($tabela) {
                $url    = env("APP_URL") . "/frase/" . $tabela->id;
                $imgSrc = $tabela->getImagemCapaAttribute();
            }
        } else {
            $tabela = Post::find($id);
            if ($tabela) {
                $url    = env("APP_URL") . "/" . $tabela->urlamigavel;
                $imgSrc = $tabela->getImagemCapaAttribute();
            }
        }
        if ($tabela) :
            return view('compartilhar_link_amp', [
                'tabela'    => $tabela,
                'url'       => $url,
                'imgSrc'    => $imgSrc,
            ]);
        else :
            return response()->view('404', ['exception' => []], 404);
        endif;
    }

    public function listarJson($query)
    {
        $global_PaginatePost      = 6;
        if ($query != 'null') {
            $registros = Frases::where([
                ['frase', 'like', '%' . $query . '%'],
                ['status', '!=',  '9'],
            ])
                ->orderBy('id', 'desc')
                ->paginate($global_PaginatePost)
                ->all();
            $total  =  Frases::where([
                ['frase', 'like', '%' . $query . '%'],
                ['status', '!=',  '9'],
            ])
                ->count();
            if ($total == 0) {
                $registros = Frases::where([
                    ['titulo', 'like', '%' . $query . '%'],
                    ['status', '!=',  '9'],
                ])
                    ->orderBy('id', 'desc')
                    ->paginate($global_PaginatePost)
                    ->all();
                $total  =  Frases::where([
                    ['titulo', 'like', '%' . $query . '%'],
                    ['status', '!=',  '9'],
                ])
                    ->count();
            }
        } else {
            $registros = Frases::where([['status', '!=',  '9'],])
                ->orderBy('id', 'desc')
                ->paginate($global_PaginatePost)
                ->all();
            $total  = Frases::all()->count();
        }
        $frases['registros'] = $registros;
        $frases['total'] = $total;
        $frases['paginate'] = $global_PaginatePost;
        $frases['ultimapagina'] = ceil($total / $global_PaginatePost);
        return response()->json($frases);
    }

    public function imageCreate(FrasesCreateRequest $request)
    {
        $ver    = "01";
        $req    = $request->all();
        $id     = $req["id"];
        $nome   = "frase_" . $id . "_" . $ver;
        $frase  = Frases::find($id);
        if (!$frase) return;
        if ($frase->capaupload == "trancado") {
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => "Ops",
                'msg'           => "Imagem está trancada",
                'data'          => [],
            ];
            return redirect()->back()->withErrors($retorno);
        }
        if ($frase->alt != "") {
            $ClearString = new ClearString;
            $alt = $ClearString->limpaCaracteresEspeciais($frase->alt);
            $nome = $alt . "-" . $id;
            $pre = $this->imageCreate->preDeleteImageFrases($id);
            $this->imageCreate->generateLogFrasesUpdate($id, "U");
        }
        $data = $this->imageCreate->run($nome, $req["frase"], $req["autor"], $req["tipo_imagem"]);

        if ($data["srcIgm"]) :
            //salvar o endereço
            $dados = Frases::find($req["id"]);
            if ($dados) :
                $dados->capa            = "/" . $data["srcIgm"];
                $dados->physical_name   = "/" . $data["srcIgm"];
                $dados->save();
            endif;
        endif;

        $retorno = [
            'sucesso'       => true,
            'titulo_msg'    => "Sucesso",
            'msg'           => "Imagem criada com sucesso",
            'data'          => $data,
        ];
        if ($req["wantsJson"]) {
            return response()->json($retorno);
        }


        //return response()->json($retorno);
        return redirect()->back()->withErrors($retorno);
    }
}
