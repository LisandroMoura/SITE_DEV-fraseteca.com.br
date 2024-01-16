<?php
/**
 * @name LinkResetaSenha.
 * Classe que será usada para enviar o Link de Reset de senha 
 * para o email do usuário que perdeu a senha. 
 */

namespace App\Mail;
use App\Entities\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LinkResetaSenha extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */ 

    public $usuario;
    public $token_gerado;

    public function __construct(Usuario $usuario, String $token_gerado)
    {
        $this->usuario        = $usuario;
        $this->token_gerado   = $token_gerado;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        /**
         * A view será o corpo do email
         */
        return $this->view('front.LoginShow_Incorp.Resetenvialink')
                    ->subject('Fraseteca - Resetando a Sua senha')
                    ->from('no-reply@fraseteca.com.br','Fraseteca');
    }
}
