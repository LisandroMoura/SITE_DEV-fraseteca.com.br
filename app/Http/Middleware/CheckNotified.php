<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Entities\Conquista;
class CheckNotified
{
    public function handle($request, Closure $next)
    {
        $usuario = Auth::user();        
        if ($usuario){            
            $conquistas = $usuario->conquistas_usuarios->all();            
            $notifications = [];
            foreach ($conquistas as $key => $conquista) {
                if ($conquista['notified'] == null){
                    $tbConquista = Conquista::find($conquista['conquista_id']);
                    if ($tbConquista){
                        
                        $data = [
                            "titulo"    => "Parabéns!!",
                            "descricao" => "Nova conquista(s) desbloqueada(s): ",
                            "conquistas" =>  $tbConquista->nome,
                            "icone" => $tbConquista->icone,
                        ];
                        array_push($notifications, $data);                        
                        $tbConquista->notified  = true;            
                        $tbConquista->save();
                    }
                }
            }
            //create session to show in screen
            //session(['notified' => $notifications]); // 03_dez_Remover session
        }
        return $next($request);
    }
}
