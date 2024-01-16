<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CurtidaCreateRequest;
use App\Http\Requests\CurtidaUpdateRequest;
use App\Entities\Curtida;
class ModelBackCurtida extends Controller{
    public function store(CurtidaCreateRequest $request)
    {
        $usuariologado = Auth::user();
        if (!$usuariologado){
            return response()->json([
                'error'   => true,
                'message' => "Usuário não logado"
            ]);
        }
        try {            
            $token_reverso = $request->get('token_reverso') ? $request->get('token_reverso') : null;            
            $token_reverso = substr($token_reverso,2,strlen($token_reverso)); 
            $dados = $request->all();
            $dados["usuario_id"] = $usuariologado->id; 
            $dados["post_id"] = $token_reverso;
            $dados["ip"]=$_SERVER['REMOTE_ADDR'];
            $curtida = Curtida::create($dados);
            $response = [
                'sucess'        => true,
                'titulo_msg'    => "",
                'msg'           => "Curtiu :)",
                'data'          => $curtida->toArray(),
                'sucesso'       => true,
            ];
            if ($request->wantsJson()) return response()->json($response);                
            return redirect()->back()->with('message', $response['message']);
        } catch (\Throwable $e) {
            if ($request->wantsJson()) 
                return response()->json(['error' => true, ]);
            $response =[
                'sucesso'       => false ,
                'titulo_msg'    => "Vish!",
                'msg'           => "Erro curtindo a Lista" ,
            ];
            return redirect()->back()->withErrors($response);
        }
    }
    public function update(CurtidaUpdateRequest $request, $id)
    {
        try {
            $curtida = new Curtida;
            $curtida->update($request->all());
            $response = ['message' => 'Curtida updated.','data'    => $curtida->toArray(),];
            if ($request->wantsJson()) return response()->json($response);
            return redirect()->back()->with('message', $response['message']);
        } catch (\Throwable $e) {
            if ($request->wantsJson()) return response()->json(['error' => true,]);
            $response =[
                'sucesso'       => false ,
                'titulo_msg'    => "Vish!",
                'msg'           => "Erro em update curtindo a Lista" ,
            ];
            return redirect()->back()->withErrors($response);
        }
    }
    public function destroy($id)
    {
        $deleted = Curtida::find($id);
        if($deleted) $deleted->delete();
        $response = [
            'sucess'        => true,
            'titulo_msg'    => "",
            'msg'           => "DesCurtiu :(",
            'sucesso'       => true,
        ];
        return redirect()->back()->withErrors($response);
    }
    public function deletar($id)
    {
        $deleted = Curtida::find($id);
        if($deleted) $deleted->delete();
        $response = [
            'sucess'        => true,
            'titulo_msg'    => "",
            'msg'           => "DesCurtiu :(",
            'sucesso'       => true,
        ];        
        return response()->json($response);                
    }
}
