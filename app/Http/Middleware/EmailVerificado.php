<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class EmailVerificado
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
        $confirmado = Auth::user()->email_verificado_dt;                
        if (!$confirmado || $confirmado == '' ) {            
            return redirect()->route('usuario.verifica');
        }
        return $next($request);
    }
}
