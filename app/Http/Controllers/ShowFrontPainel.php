<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UsuarioUpdateRequest;
use App\Services\UsuarioService;
use App\Services\ServiceSecurityIsSameUser;
use App\Services\Mensagens;
use App\Entities\Usuario;

class ShowFrontPainel extends Controller
{
    protected $service;
    public function __construct(
        UsuarioService $service, 
        Mensagens $service_mensagens
        )
    {
        $this->service              = $service;
        $this->service_mensagens    = $service_mensagens;
    }    
    public function painel()
    {        
        $usuariologado = Auth::user();
        return view('usuario.painel.index',[
            'titulo' => 'Painel',
            'class' => 'painel pagina pagina-usuario',
            'logado'=>$usuariologado,
        ]);
    }
    public function alterarSenha($id)
    {
        $security = new ServiceSecurityIsSameUser;
        $retorno = $security->run("usuario",$id);        
        if(!$retorno["sucesso"]){           
            return redirect()->route('login')->withErrors($retorno); 
        }
        $usuario = Usuario::find($id);
        return view('usuario.painel.perfil_alterar_senha', compact('usuario'));
    }
    public function alterarSenhaUpdate(UsuarioUpdateRequest $request, $id){
        $security = new ServiceSecurityIsSameUser;
        $retorno = $security->run("usuario",$id);        
        if(!$retorno["sucesso"]){           
            return redirect()->route('login')->withErrors($retorno); 
        }
        $mensagens_login = $this->service_mensagens->mensagens_login;
        $usuario = Usuario::find($id);
        if (! $usuario):
            $retorno =[
                'sucesso'       => false ,
                'titulo_msg'    => $mensagens_login['titulo_erro'],
                'msg'           => $mensagens_login['usuario_naoencontrado'] 
            ];
            return redirect()->back()->withErrors($retorno);
        endif;
        if(!password_verify($request->password_atual,$usuario->password)):
            $retorno =[
                'sucesso'       => false ,
                'titulo_msg'    => $mensagens_login['titulo_erro'],
                'msg'           => "Senha atual digitada não confere",
            ];
            return redirect()->back()->withErrors($retorno);
        endif;
        if($request->password_new!=$request->password_repeat){
            $retorno =[
                'sucesso'       => false ,
                'titulo_msg'    => $mensagens_login['titulo_erro'],
                'msg'           => "Senhas digitadas não são iguais!",
            ];
            return redirect()->back()->withErrors($retorno);
        }
        $mensagens_cadastro = $this->service_mensagens->mensagens_cadastro;
        $validated = $request->validate([
            'password_new' => 'max:30|min:6',
        ]);
        
        try {
            $usuario->password = bcrypt($request->all()["password_new"]);
            $usuario->save();
            if ($usuario)            
                $retorno =[
                    'sucesso'       => true ,
                    'titulo_msg'    => $mensagens_cadastro['titulo_sucesso'],
                    'msg'           => $mensagens_cadastro['usuarios_senha_update_sucesso'] ,
                ];
        } catch (\Throwable $e){
            $validatorException =  $this->service_mensagens->validatorException;
            $retorno =[
                'sucesso'       => false ,
                'titulo_msg'    => $validatorException['titulo'],
                'msg' => \App\Services\Sanitize::clearCatch($e->getMessage()) ,
            ];
        }
        return redirect()->back()->withErrors($retorno);
    }   
}