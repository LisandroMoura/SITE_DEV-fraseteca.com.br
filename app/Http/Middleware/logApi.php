<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class logApi
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
        
        
        if($request->expectsJson()){

            

            $data = ['name'=> $request->get('name'),'password'  => $request->get('password')];   

            if (Auth::attempt($data, true)):                
                return $next($request);
            else :
                return response()->json([
                    'access_token' => "false",
                    'token_type' => 'bearer',
                    'expires_in' => ""
                  ]);
            endif;            
        }
    }
}
