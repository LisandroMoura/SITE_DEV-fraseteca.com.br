<?php

namespace App\Http\Controllers;
use App\Http\Requests\parametros_globaisCreateRequest;
use App\Entities\ParametroGlobal;
class ModelBackParametroGlobal extends Controller
{
    public function index()
    {
        $parametrosGlobais = ParametroGlobal::all();
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $parametrosGlobais,
            ]);
        }
        return view('parametrosGlobais.index', compact('parametrosGlobais'));
    }
    public function store(parametros_globaisCreateRequest $request)
    {
        try {
            $parametrosGlobai =ParametroGlobal::create($request->all());
            $response = [
                'message' => 'ParametroGlobal created.',
                'data'    => $parametrosGlobai->toArray(),
            ];
            if ($request->wantsJson()) {

                return response()->json($response);
            }
            return redirect()->back()->with('message', $response['message']);
        } catch (\Throwable $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => "erro nesta função"
                ]);
            }

            return redirect()->back()->withErrors($e)->withInput();
        }
    }
    public function show($id)
    {
        $parametrosGlobai = ParametroGlobal::find($id);
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $parametrosGlobai,
            ]);
        }
        return view('parametrosGlobais.show', compact('parametrosGlobai'));
    }
    public function edit($id)
    {
        $parametrosGlobai = ParametroGlobal::find($id);
        return view('parametrosGlobais.edit', compact('parametrosGlobai'));
    }
    public function update(parametros_globaisCreateRequest $request, $id)
    {
        try {
            $dados = $request->all(); 
            $parametros = ParametroGlobal::find($id);
            $parametros->update($dados);           
            if($parametros):                     
                $retorno =[
                    'sucesso'       => true ,
                    'titulo_msg'    => "Sucesso",
                    'msg'           => "Parâmetros editados com sucesso",
                ];
            else:                
                $retorno =[
                    'sucesso'       => false ,
                    'titulo_msg'    => "Erro:",
                    'msg'           => "Falha na alteração de parâmetros",
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
        $deleted = ParametroGlobal::find($id);
        if($deleted) $deleted->delete();
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'ParametroGlobal deleted.',
                'deleted' => $deleted,
            ]);
        }
        return redirect()->back()->with('message', 'ParametroGlobal deleted.');
    }
}
