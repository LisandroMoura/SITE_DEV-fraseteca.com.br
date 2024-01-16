<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class TestaSituacaoUsuario
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
        
        if($usuariologado->status != '1') {
            $retorno =[
                'sucesso'       => false ,
                'titulo_msg'    => 'Sem permissão!',
                'msg'           => 'Parece que você não tem permissão para esta rotina!',
            ];
            return redirect()->route('login')->withErrors($retorno);
        } 
        return $next($request);
    }
}
