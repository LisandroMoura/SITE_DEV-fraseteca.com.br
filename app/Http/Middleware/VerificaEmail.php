<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class VerificaEmail
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
        if ($usuariologado){
            $confirmado = Auth::user()->email_verificado_dt;                
            if (!$confirmado || $confirmado == '' ) {            
                return redirect()->route('falta.confirmar.email');
            }
        }
        
        return $next($request);
    }
}
