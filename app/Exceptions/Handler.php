<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;


class Handler extends ExceptionHandler

{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register() {
        $this->renderable(function (Throwable $exception, $request) {

            if(!env('APP_DEBUG', false)){
                $getMessage    = method_exists($exception, 'getMessage');
                $getStatusCode = method_exists($exception, 'getStatusCode');
                if($getMessage && !$getStatusCode){
                    $lReturn = true;
                    if ($exception->getMessage() == "Unauthenticated.") //se o erro for de usuário não autenticado... segue o baile...
                        $lReturn=false;
                    if (str_contains($exception->getMessage(),"No query results for model")){
                        $lReturn=false; //deixar seguir 404 quando não encontrar dados das tabelas
                    }
                    if($lReturn)
                        return response()->view('500', ['exception' => $exception], 500);
                }
            }
            // return parent::render($request, $exception);        
        });  
    }  
}
