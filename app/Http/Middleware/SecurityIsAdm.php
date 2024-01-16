<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class SecurityIsAdm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $usuariologado = Auth::user();            
        //testar se o usuário tem acesso ou não há esta rotina
        $lnext=false;                
        if ($usuariologado){
            if($usuariologado->perfil === '1')
                $lnext=true;            
        }
        if(!$lnext){
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => "Ops!!!",
                'msg'           => "Você não tem acesso a esta rotina!",            
                'arrMsg'        => [],
            ];
            
            return redirect()->route('login')->withErrors($retorno);        
        }          

        return $next($request);
    }
}
