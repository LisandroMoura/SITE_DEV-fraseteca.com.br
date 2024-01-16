<?php

namespace App\Http\Controllers;
use App\Entities\Categoria;
use App\Http\Requests\CategoriaCreateRequest;
use App\Http\Requests\CategoriaUpdateRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
/**
 * Class ModelBackCategoria.
 *
 * @package namespace App\Http\Controllers;
 */
class ModelBackCategoria extends Controller
{
    public function store(CategoriaCreateRequest $request)
    {
        try {
            $dados = $request->all();
            if ($dados['urlamigavel'] === '' || $dados['urlamigavel'] ==  null){                
                $dados['urlamigavel'] = strtolower(Str::kebab($dados['descricao']));                
                $dados['urlamigavel'] = str_replace(" ","-",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($dados['urlamigavel']))));
            }
            $categorium = Categoria::create($dados);
            if($categorium):                     
                $retorno =[
                    'sucesso'       => true ,
                    'titulo_msg'    => "Sucesso",
                    'msg'           => "Categoria Inserida com sucesso",
                ];
            else:                
                $retorno =[
                    'sucesso'       => false ,
                    'titulo_msg'    => "Erro:",
                    'msg'           => "Falha na alteração da Categoria",
                ];
            endif;       
        } catch (\Throwable $e) {
            $retorno =[
                'sucesso'       => false ,
                'titulo_msg'    => "Erro:",
                'msg'           => "Falha na Inclusão da Categoria",
            ];
        }
        return redirect()->back()->withErrors($retorno); 
    }
    public function update(CategoriaUpdateRequest $request, $id)
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
            $categorium = Categoria::find($id);
            $categorium->update($dados);
            if($categorium):                     
                $retorno =[
                    'sucesso'       => true ,
                    'titulo_msg'    => "Sucesso",
                    'msg'           => "Categoria editada com sucesso",
                ];
            else:                
                $retorno =[
                    'sucesso'       => false ,
                    'titulo_msg'    => "Erro:",
                    'msg'           => "Falha na alteração da Categoria",
                ];
            endif;             
          
        } catch (\Throwable $e) {
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
        $deleted = Categoria::find($id);
        if($deleted)
            $deleted->delete();
        if($deleted):                 
            $retorno =[
                'sucesso'       => true ,
                'titulo_msg'    => "Sucesso",
                'msg'           => "Categoria eliminada com sucesso" ,
            ];
        else:
            $retorno =[
                'sucesso'       => false ,
                'titulo_msg'    => 'Erro: ' ,
                'msg'           => 'Falha ao tentar deletar a categoria',
            ];
        endif;   
        return redirect()->route('back.CategoriaList','todas')->withErrors($retorno);
    }
    public function edit($id)
    {
        $categoria = Categoria::find($id);
        $options   = "";
        $usuariologado = Auth::user();     
        if($categoria)
            return view('back.CategoriaForm',[                                     
                'categoria' => $categoria,
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
    
}
