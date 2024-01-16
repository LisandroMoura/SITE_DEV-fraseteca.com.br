<?php
namespace App\Http\Controllers;
use App\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\TagCreateRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Services\ServiceSecurityIsSameUser;
use App\Entities\Tag;
use App\Entities\TagPost;
use App\Entities\TagFrases;
use App\Services\TagsMarta;

class ModelBackTag extends Controller
{
  
    public function show()
    {
        return response()->view('404', ['exception' => []], 404);
    }
    
    public function store(TagCreateRequest $request)
    {
        try {            
            $dados = $request->all();
            if ($dados['urlamigavel'] === '' || $dados['urlamigavel'] ==  null){                
                $dados['urlamigavel'] = strtolower(Str::kebab($dados['descricao']));                
                $dados['urlamigavel'] = str_replace(" ","-",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($dados['urlamigavel']))));
            }
            if($dados['token']==""){
                $tagsMarta = new TagsMarta;
                $stringToken = $tagsMarta->geraChave($dados['descricao']);
                $dados['token'] = $stringToken;
            }
            $tagum = Tag::create($dados);
            if($tagum):                     
                $retorno =[
                    'sucesso'       => true ,
                    'titulo_msg'    => "Sucesso",
                    'msg'           => "tag Inserida com sucesso",
                ];
            else:                
                $retorno =[
                    'sucesso'       => false ,
                    'titulo_msg'    => "Erro:",
                    'msg'           => "Falha na alteração da tag",
                ];
            endif; 
            
        } catch (ValidatorException $e) {
            $retorno =[
                'sucesso'       => false ,
                'titulo_msg'    => "Erro:",
                'msg'           => "Falha na Inclusão da tag",
            ];
        }
        return redirect()->back()->withErrors($retorno); 
    }
    public function edit($id)
    {
        $security = new ServiceSecurityIsSameUser;
        $retorno = $security->isAdm();        
        if(!$retorno["sucesso"]){            
            return redirect()->route('login')->withErrors($retorno); 
        }
        $tag = Tag::find($id);
        $options   = "";
        $usuariologado = Auth::user();     
        if($tag)
            return view('back.TagForm',[                                     
                'tag' => $tag,
                'logado'   => $usuariologado,
                'options'  => $options
            ]);
        else {
            $retorno =[
                'sucesso'       => false ,
                'titulo_msg'    => "Erro:",
                'msg'           => "Registro não encontrado",
            ];
            return redirect()->back()->withErrors($retorno); 
        }
    }
    public function update(TagUpdateRequest $request, $id)
    {
        try {
            $dados = $request->all();
            $urlAux = strtolower(Str::kebab($dados['descricao']));
            $urlAux = str_replace(" ","-",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($urlAux))));
            if( $dados['urlamigavel'] != $urlAux  &&
                $dados['urlamigavel'] != '' && 
                $dados['urlamigavel'] != null)
                $dados['urlamigavel'] = strtolower($dados['urlamigavel']);
            else $dados['urlamigavel'] = strtolower($urlAux);

            if($dados['token']==""){
                $tagsMarta = new TagsMarta;
                $stringToken = $tagsMarta->geraChave($dados['descricao']);
                $dados['token'] = $stringToken;
            }
            $Tagum = Tag::find($id);
            $Tagum->update($dados);           
            if($Tagum):                     
                $retorno =[
                    'sucesso'       => true ,
                    'titulo_msg'    => "Sucesso",
                    'msg'           => "tag editada com sucesso",
                ];
            else:                
                $retorno =[
                    'sucesso'       => false ,
                    'titulo_msg'    => "Erro:",
                    'msg'           => "Falha na alteração da tag",
                ];
            endif;             
        } catch (ValidatorException $e) {
            $retorno =[
                'sucesso'       => false ,
                'titulo_msg'    =>"erro de execução",
                'msg'           =>'' ,
            ];             
        }
        return redirect()->back()->withErrors($retorno); 
    }
    public function destroy($id)
    {
        $tagpost = TagPost::where('tag_id', '=',  $id)->get();            
        foreach ($tagpost as $key => $item) {                # code..                
            $item->delete($id);
        }
        $tagfrases = TagFrases::where('tag_id', '=',  $id)->get();            
        foreach ($tagfrases as $key => $item) {                # code..                
            $item->delete($id);
        }
        $deleted = Tag::find($id);
        if($deleted) $deleted->delete();

        if($deleted):                 
            $retorno =[
                'sucesso'       => true ,
                'titulo_msg'    => "Sucesso",
                'msg'           => "Ttag eliminada com sucesso" ,
            ];
        else:            
            $retorno =[
                'sucesso'       => false ,
                'titulo_msg'    => 'Erro: ' ,
                'msg'           => 'Falha ao tentar deletar a tag',
            ];        
        endif;     
        return redirect()->route('back.TagList','todas')->withErrors($retorno);
    }
}
