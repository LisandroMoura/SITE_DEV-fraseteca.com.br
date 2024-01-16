<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ConquistasCreateRequest;
use App\Http\Requests\ConquistasUpdateRequest;
use App\Entities\ConquistasUsuarios; 
use App\Services\ServiceSecurityIsSameUser;
use App\Services\ParamGlobal;
use App\Entities\Conquista;
class ModelBackConquista extends Controller
{
    public function store(ConquistasCreateRequest $request)
    {
        try {
            $dados = $request->all();           
            $conquistaum = Conquista::create($dados);
            if($conquistaum):                     
                $retorno =[
                    'sucesso'       => true ,
                    'titulo_msg'    => "Sucesso",
                    'msg'           => "Conquista Inserida com sucesso",
                ];
            else:                
                $retorno =[
                    'sucesso'       => false ,
                    'titulo_msg'    => "Erro:",
                    'msg'           => "Falha na alteração da Conquista",
                ];
            endif;       
        } catch (\Throwable $e) {
            $retorno =[
                'sucesso'       => false ,
                'titulo_msg'    => "Erro:",
                'msg'           => "Falha na Inclusão da Conquista",
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
        $logado = Auth::user();  
        $paramGlobal        = new ParamGlobal;
        $options =  $paramGlobal->get('arr'); 

        $conquista = Conquista::find($id);
        return view('back.ConquistaForm',[                                     
            'conquista'          => $conquista,            
            'logado'        => $logado,            
            'options'       => $options
        ]);
    }
    public function update(ConquistasUpdateRequest $request, $id)
    {
        try {
            $dados = $request->all();   
            $conquistaum = Conquista::find($id);
            $conquistaum->update($dados);                             
            if($conquistaum):                     
                $retorno =[
                    'sucesso'       => true ,
                    'titulo_msg'    => "Sucesso",
                    'msg'           => "Conquista editada com sucesso",
                ];
            else:                
                $retorno =[
                    'sucesso'       => false ,
                    'titulo_msg'    => "Erro:",
                    'msg'           => "Falha na alteração da Conquista",
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
        $find = Conquista::find($id);
        if ($find):
            $ConquistasUsuarios = ConquistasUsuarios::where ('conquista_id', $id)->get();
            foreach ($ConquistasUsuarios as $key => $conquistaDel) {                
                $delete = ConquistasUsuarios::where('id', $conquistaDel->id)->delete ();                             
            }            
        endif;
        $deleted = Conquista::find($id);
        if($deleted)
            $deleted->delete();
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Conquistas deleted.',
                'deleted' => $deleted,
            ]);
        }
        return redirect()->back()->with('message', 'Conquistas deleted.');
    }
    public function inserir()
    {
        $logado = Auth::user();   
        $paramGlobal        = new ParamGlobal;
        $options            = $paramGlobal->get('arr');      
        return view('back.ConquistaForm',[                                     
               'logado'   => $logado,
               'options'       => $options
        ]);
    }
}