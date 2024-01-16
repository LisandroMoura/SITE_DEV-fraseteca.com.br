<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Entities\Lista;

use Closure;

class SecurityIsSameUser
{
    /**
     * Handle a[1n incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $rota=""; $action=""; $id="1"; $userId="1";
        $usuariologado = Auth::user();    
        $arrpath = explode("/",$request->getpathInfo());

        if (isset($arrpath[1])) $rota = $arrpath[1];            
        
        if (isset($arrpath[2])) $action = $arrpath[2];            
        
        if (isset($arrpath[3])) $id = $arrpath[3];            
        
        //se for Lista
        
        if($rota=="lista"){
            $lista = Lista::find($request->id);
            if($lista)
                $userId=$lista->usuario_id;                
        }
        

        if($rota=="listas"){
            $lista = Lista::find($id);
            if($lista)
                $userId=$lista->usuario_id;
        }
        if($rota=="usuario")
            $userId=$id;
       

        //testar se o usuário tem acesso ou não há esta rotina
        $lnext=false;                
        if ($usuariologado){            
            if($usuariologado->id == $userId)
                $lnext=true; 
            if($usuariologado->perfil === '1')
                $lnext=true;    
        }

        if(!$lnext){
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => "Ops",
                'msg'           => "Você não tem acesso a esta rotina!5",            
                'arrMsg'        => [],
            ];
            
            return redirect()->route('login')->withErrors($retorno);        
        }          

        return $next($request);
    }
}
