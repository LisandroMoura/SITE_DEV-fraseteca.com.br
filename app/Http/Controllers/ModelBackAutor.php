<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Requests\AutorCreateRequest;
use App\Http\Requests\AutorUpdateRequest;
use App\Entities\Autor;
use App\Entities\AutorItem;
use App\Entities\Frases;

use App\Services\Seo;
use App\Services\SiteMap;
class ModelBackAutor extends Controller
{  
    private $totalPage = 20;  
    public function store(AutorCreateRequest $request)
    {
        $retorno    =['sucesso'=>false,'titulo_msg'=> "Xiii:",'msg'=>"Problemas ao salvar registro"];
        $autor      =[];
        try {

            $dados = $request->all();
            if($dados["idAutor"]) $autor = Autor::find($dados["idAutor"]);
            if(!$dados["dataFrases"])
                return redirect()->back()->withErrors(['sucesso'=>false,'titulo_msg'=> "Xiii:",'msg'=>"Nenhuma frase selecionada"]);
            $dados["autores_relacionados"] = $dados["pesquisar_novos_nomesH"];
            if(!$dados["nome"])
                return redirect()->back()->withErrors(['sucesso'=>false,'titulo_msg'=> "Xiii:",'msg'=>"O campo nome precisa ser informado"]);
            if(!$dados["urlamigavel"]){
                $urlAux =Str::kebab($dados["nome"]);
                $urlAux = str_replace(" ","-",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($urlAux))));            
                $dados["urlamigavel"] = strtolower($urlAux);
            }
            if(!$autor)
                $autor = Autor::create($dados);
            else {
                $autor = Autor::find($dados["idAutor"]);
                $autor->update($dados);
            }
            if($autor){
                $this->gravaAutorItem($autor->id, "1",$dados["dataFrases"]);
                // desativar a retirada do sitemap: LM: 08-nov-22
                // $sitemap = new SiteMap; $sitemap->buildAutor();
                $retorno =[
                    'sucesso'       => true ,
                    'titulo_msg'    => "Sucesso",
                    'msg'           => "Autor Inserido com sucesso",
                ];
            }                        
            return redirect()->back()->withErrors($retorno);
            
        } catch (\Throwable $e) {
            $retorno =[
                'sucesso'=> false,
                'titulo_msg'    => 'Vish!',
                'msg' => \App\Services\Sanitize::clearCatch($e->getMessage()),
            ];
            if ($request->wantsJson()) return response()->json($retorno);
            return redirect()->back()->withErrors($retorno);
        }
    }  
    public function update(AutorUpdateRequest $request, $id)
    {
        // dd(2);
        $retorno    =['sucesso'=>false,'titulo_msg'=> "Xiii:",'msg'=>"Problemas ao salvar registro"];
        $dados = $request->all();
        $urlAux =Str::kebab($dados["nome"]);
        $urlAux = str_replace(" ","-",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($urlAux))));
        if( $dados['urlamigavel'] != $urlAux  &&
            $dados['urlamigavel'] != '' && 
            $dados['urlamigavel'] != null)
            $dados['urlamigavel'] = strtolower($dados['urlamigavel']);
        else $dados['urlamigavel'] = strtolower($urlAux);
        try {
            $autor = Autor::find($id);
            $autor->update($dados);
            // desativar a retirada do sitemap: LM: 08-nov-22
            // $sitemap = new SiteMap; $sitemap->buildAutor();   
            $retorno =[
                'sucesso'       => true ,
                'msg'           => "Autor Alterado com sucesso",
            ];
            if ($request->wantsJson()) {
                return response()->json($retorno);
            }
        
        } catch (\Throwable $e) {
            $retorno =[
                'sucesso'=> false,
                'titulo_msg'    => 'Vish!',
                'msg' => \App\Services\Sanitize::clearCatch($e->getMessage()),
            ];
            if ($request->wantsJson()) return response()->json($retorno);
            return redirect()->back()->withErrors($retorno);
        }
        return redirect()->back()->withErrors($retorno);
    }
    public function destroy($id)
    {
        $deleteItem = AutorItem::where ('autor_id', $id)->delete();
        $deleted = Autor::find($id);
        if($deleted)
            $deleted->delete();
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Autor deleted.',
                'deleted' => $deleted,
            ]);
        }
        return redirect()->back()->withErrors(['sucesso'=>true,'titulo_msg'=> "Sucesso:",'msg'=>"Autor foi deletado"]);
    }
    public function gestaoAutor($filtro =  null)
    {
         $postsCount = [];
         $postsCount['total'] = Autor::where ([['id', '>', 0]])->count(); 
         $autores = Autor::where ('id', '>', 0)       
         ->orderBy('id', 'desc')
         ->paginate($this->totalPage);
         return view('back.AutorList',[                             
             'autores'   => $autores,            
             'postsCount' => $postsCount,       
         ]); 
    }
    public function autorPesquisa(Request $request)
    {
        $postsCount = [];
        $postsCount['total'] = Autor::where ([['id', '>', 0]])->count(); 
        $autores = Autor::where ('nome', 'like', '%'. $request->s . '%')
        ->orderBy('id', 'desc')
        ->paginate($this->totalPage);
        return view('back.AutorList',[                             
            'autores'   => $autores,                 
             'postsCount' => $postsCount,              
        ]);  
    }
    public function autorInserir()
    {
        $post_logado = Auth::user();         
        return view('back.AutorForm_Incorp.Criandoautor',[                                     
               'logado'   => $post_logado,
        ]);
    }
    public function showAutor($url, $currentPage = null)
    {   
        $urlComplete = env('APP_URL') . '/autor/'.$url;
        $testaAmp = ($_SERVER["REQUEST_URI"]); $amp = str_contains($testaAmp,"amp/autor/") ? true : false;       
        $seo=[]; $tabela=[]; $notific=[];$frasesSalvas=[];$totalCurtidasdoPost=0;$seguindo=[]; $curtida=[];
        $usuariologado = Auth::user();
        $autor = Autor::where([
            ["urlamigavel", "=", $url ]
        ])
        ->orWhere([
            ["urlamigavel", "=", $urlComplete ]
        ])
        ->first();             
        if($autor):
            $itens = DB::table('autor_item')
            ->where('autor_id', '=',  $autor->id)           
            ->join('autor', 'autor.id', '=', 'autor_item.autor_id')           
            ->join('frases', 'frases.id', '=', 'autor_item.tipo_id')           
            ->select('frases.id','frases.frase', 'frases.capa','autor.nome','autor.descricao')  
            ->select('frases.id as frase_id', 'frases.titulo', 'frases.frase', 'frases.status', 'frases.autor',  'frases.capa','frases.alt', 'frases.aux_1 as mostraimg')  
            ->orderBy('autor_item.id', 'desc')                     
            ->paginate(20);
            if($itens):   
                $seoParam = new Seo;          
                $seo = $seoParam->get($autor, "autor");  
                $postRel = DB::table('posts')
                ->where([
                    ['id', '!=',  0],
                    ['status', '=', "1"],
                    ['autor_id', '=', "1"],              
                ])
                ->orderBy('id', 'desc')
                ->take(4)
                ->select('posts.id','posts.titulo', 'posts.urlamigavel', 'posts.capa', 'posts.thumb','posts.midia_id')            
                ->get();

                if ($usuariologado):
                    $frasesSalvas = DB::table('pasta_usuario_item')                
                    ->join('pasta_usuarios', 
                    [
                        ['pasta_usuarios.id', '=', 'pasta_usuario_item.pasta_id'],
                    ]
                    )
                    ->where([
                        ['pasta_usuario_item.usuario_id', '=',  $usuariologado->id],                    
                        ])
                    ->select('pasta_usuario_item.frase_id')            
                    ->get();
                    $curtidasColect = \App\Entities\Curtida::where ([
                        ['post_id', "=",$autor->id],
                        ['tipo', "=","2"]
                        ])
                    ->get();
                    $totalCurtidasdoPost =  count($curtidasColect); 
                    $seguindo = \App\Entities\PastaUsuario::where([
                        ['post_id', 'like', $autor->id],                    
                        ['usuario_id' ,'=', $usuariologado->id]
                        ])->first();

                    $curtida = \App\Entities\Curtida::where([
                        ['post_id', 'like', $autor->id],
                        ['tipo', '=', "2"],
                        ['usuario_id' ,'=', $usuariologado->id]
                        ])
                        ->select('curtidas.id')
                        ->first();  
                endif;
                return view('front.AutorShow' , [
                    'tabela'                => $autor,
                    'frasessalvas'          => $frasesSalvas,
                    'postrel'               => $postRel,
                    'posts'                 => $autor,
                    'itens'                 => $itens, 
                    'amp'                   => $amp,
                    'logado'                => $usuariologado,
                    'curtida'               => $curtida, 
                    'seguindo'              => $seguindo,
                    'totalcurtidasdopost'   => $totalCurtidasdoPost,
                    'seo'                   => $seo,    
                ]);
            else :
                return response()->view('404', ['exception' => []], 404);
            endif;
        else :
            return response()->view('404', ['exception' => []], 404);
        endif;                      
    }
    public function edit($id)
    {
        $autor = Autor::find($id);
        if(!$autor)
            return redirect()->back()->withErrors(['sucesso'=>false,'titulo_msg'=> "Xiii:",'msg'=>"Este autor não ex"]);
        $frases = AutorItem::where ([
            ['tipo', '=', "1"],
            ['autor_id', '=', $autor->id],
        ])
        ->join("frases","frases.id","=","autor_item.tipo_id")        
        ->select("autor_item.id", "autor_item.autor_id","frases.id","frases.frase","frases.autor")    
        ->get();
        return view('back.AutorForm',[  
            'autor' => $autor,
            'frases' => $frases,
        ]);
    }
    public function criandoAutor(Request $request)
    {
        if(!isset($request["pesquisar_autor"])){
            $retorno =['sucesso'=> false,'titulo_msg'=> "Erro:",'msg'=> "Autor não informado"];return redirect()->back()->withErrors($retorno);
        }
        if($request["pesquisar_autor"]==""){
            $retorno =['sucesso'=> false,'titulo_msg'=> "Erro:",'msg'=> "Autor não informado"];return redirect()->back()->withErrors($retorno);
        }  
        $query="";
        $autoresParecidos=[];
        $tabAux=[];
        $AuxFrasesJaCadastradasParaAutor=[];
        $frases =[];
        $frasesNovosNomes =[];
        $frasesDeAutoresParecidos=[]; 
        $nomesJaRelacionados=[];
        $pesquisar_novos_nomesH="";
        $where = array();
        
        $frases = Frases::where ('autor', 'LIKE', '%'.$request["pesquisar_autor"].'%')        
        ->select("frases.id", "frases.frase", "frases.autor")    
        ->orderBy('frase', 'asc')
        // ->paginate(70);
        ->get();   

        $autor=Autor::where("nome", "=",$request["pesquisar_autor"])->first(); 

        $query = explode(" ",$request["pesquisar_autor"]);
        foreach ($query as $key => $item) {
            $tabAux =[];
            if(strlen($item)>2){            
                $tabAux = DB::table("frases")
                ->Where([
                    ['autor', "like", '%'.$item.'%']
                ])
                ->orWhere([
                    ['autor', "like", '%'.$item.'%']
                ])                
                ->whereNotIn("autor",[$request["pesquisar_autor"]])
                ->select("frases.autor","frases.id","frases.frase")                
                ->get();               
                if(count($tabAux)){
                    foreach ($tabAux->all() as $key => $auxItem) {                                    
                        array_push($frasesDeAutoresParecidos,[
                            'id' => $auxItem->id,
                            'autor' => $auxItem->autor,    
                        ]);                        
                    }
                }
            }
        }            
        $i = 0;
        foreach ($frasesDeAutoresParecidos as $key => $item) {
            if(!in_array($item["autor"], $autoresParecidos)){ 
                $autoresParecidos[$i]=   $item["autor"];
            }
            $i++;
        }
        if(isset($request["pesquisar_novos_nomes"])){
            $pesquisar_novos_nomesH=$request["pesquisar_novos_nomesH"].";".$request["pesquisar_novos_nomes"];  
            $query = explode(";",$pesquisar_novos_nomesH);
            $i = 0;
            foreach ($query as $key => $item) {
                $tabAux =[];
                if(trim($item)!=""){
                    $tabAux = DB::table("frases")
                    ->Where([
                        ['autor', "=", $item]   
                    ])
                    ->whereNotIn("autor",[$request["pesquisar_autor"]])
                    ->select("frases.autor","frases.id","frases.frase","frases.aux_1 as cadastrado")                
                    ->get();               
                    if(count($tabAux)){                         
                        $nomesJaRelacionados[$i]=   $item;
                        foreach ($tabAux->all() as $key => $auxItem) {  
                            $AuxFrasesJaCadastradas=AutorItem::where([
                                ["tipo","=","1"],
                                ["tipo_id","=",$auxItem->id]
                            ])
                            ->first();
                            if(!$AuxFrasesJaCadastradas){                                  
                                array_push($frasesNovosNomes,[
                                    'id' => $auxItem->id,
                                    'autor' => $auxItem->autor,
                                    'frase' => $auxItem->frase,    
                                ]);
                            }                        
                        }
                    }
                    $i++;
                }
            }                
        } 
        $i = count($nomesJaRelacionados);
        foreach ($frases as $key => $item) {
            if(!in_array($item->autor, $nomesJaRelacionados)){ 
                $nomesJaRelacionados[$i]=   $item->autor;
            }
            $i++;            
            $AuxFrasesJaCadastradasParaAutor=[];
            $AuxFrasesJaCadastradasParaAutor=AutorItem::where([
                ["tipo","=","1"],
                ["tipo_id","=",$item->id]
                ])
            ->first();
            if($AuxFrasesJaCadastradasParaAutor){
                unset($frases[$key]);                    
            }
        } 


        // return view('back.AutorForm_Incorp.Criandoautor',[                                     
        //     'logado'   => $post_logado,
        // ]);

        return view('back.AutorForm_Incorp.Criandoautor',[              
        // return view('back.AutorForm',[  
            'autor'                 => $autor,
            'pesquisar_autor'       => $request["pesquisar_autor"],                               
            'frases'                => $frases,
            'frasesNovosNomes'      => $frasesNovosNomes,
            'nomesJaRelacionados'   => $nomesJaRelacionados,
            'autoresParecidos'      => $autoresParecidos,
            'pesquisar_novos_nomesH' => $pesquisar_novos_nomesH, 
        ]);
    }    
    public function gravaAutorItem($autor_id, $tipo, $dataFrases)    
    {
        $arrFrases=explode(";",$dataFrases);
        if(count($arrFrases)){
            foreach ($arrFrases as $key => $arrFraseItemID) {
                if($arrFraseItemID!=";"){
                    $AuxFrasesJaCadastradas=AutorItem::where([
                        ["tipo","=",$tipo],
                        ["tipo_id","=",$arrFraseItemID]
                    ])
                    ->first();
                    if(!$AuxFrasesJaCadastradas){
                        $availFrase = Frases::find($arrFraseItemID);
                        if($availFrase){
                            $AutorItem              = new AutorItem;
                            $AutorItem->autor_id    = $autor_id;
                            $AutorItem->tipo        = $tipo;
                            $AutorItem->tipo_id     = $arrFraseItemID;
                            $AutorItem->save();
                        }
                    }
                }
            }
        }               
    }
}