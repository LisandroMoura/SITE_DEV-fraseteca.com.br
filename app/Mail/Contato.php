<?php
/**
 * @name Contato.
 * Classe que será usada para enviar o Link de Reset de senha 
 * para o email do usuário que perdeu a senha. 
 */

namespace App\Mail;
use App\Entities\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Contato extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */ 

    public $nome;
    public $email;
    public $assunto;
    public $mensagem;

    public function __construct(String $nome, String $email, String $assunto, String $mensagem )
    {
        $this->nome     = $nome;
        $this->email    = $email;
        $this->assunto  = $assunto;
        $this->mensagem = $mensagem;
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
        return $this->view('front.LoginShow_Incorp.Recebemoscontato')
                    ->subject('Fraseteca - Contato Recebido')
                    ->from('contato@fraseteca.com.br','Fraseteca');
    }
}
