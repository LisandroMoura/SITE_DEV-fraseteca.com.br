<?php

namespace App\Services;
/**
 * Class Mensagens.
 * Classe de retorno padrão de mensagens. Centralizar todas as mensagens
 * da aplicação nesta úníca classe. Para Fins de fácil manutenção.
 * @package namespace App\Services;
 * @author  LM
 * @link    https://docs.google.com/document/d/1aerE_1MG7WRBw45WWiTVWBGIBJWln05VWjKdMw3g1rI/edit?usp=sharing
 * @version 1.0.0 - Jun-2019
 */
class Mensagens 
{    
    public $mensagens_cadastro = [
        'titulo_sucesso'                => 'Beleza!!',
        'titulo_atencao'                => 'Atenção!!',
        'titulo_erro'                   => 'Vish!!',    
        'validator_erro'                => 'Verifique os campos em vermelho:',
        'create_sucesso'                => 'Inserido com sucesso',
        'update_sucesso'                => 'Alterado com sucesso',
        'delete_sucesso'                => 'Foi deletado! E descansa em paz',        
        'create_erro'                   => 'Falha na criação deste Registro',
        'update_erro'                   => 'Esta atualização falhou',
        'delete_erro'                   => 'Não foi possível deletar este registro!',        
        'lista_enviada'                 => 'Sua lista foi enviada para a revisão com sucesso!',        
        'lista_enviada_erro'            => 'Não foi possível enviar esta lista para a Revisão. Revise os campos',        
        'perfil_erro_altera_senha'      => 'A sua nova senha é igual a senha atual!', 

        'usuarios_delete_sucesso'           => 'Conta Excluída, até a próxima :(',
        'usuario_naoencontrado'             => 'Não foi localizado este usuário no sistema',                                
        'usuarios_delete_erro'              => 'Falha ao tentar deletar o usuário',        
        'usuarios_senha_update_sucesso'     => 'Senha Alterada',  
        'usuarios_suspende_sucesso'         => 'Usuário suspenso com suceso!',  
        'usuarios_reativa_sucesso'          => 'Usuário reativado com suceso!',  
        'usuarios_retirado_lixeira'         => 'Usuário retirado da Lixeira com suceso!',        
        'usuarios_update_erros'             => 'Erro ao tentar alterar o registro do usuário',        
        'posts_update_erro'                 => 'Erro ao tentar alterar o Post',        
        'posts_delete_erros'                => 'Erro ao deletar o Post',
        'comment_sucesso'                   => 'Seu Comentário foi para moderação e será publicado em breve!',
        'comment_erro'                      => 'Não foi possível enviar para a moderação seu comentário. Revise o texto',
        'quer_fazer_login_favoritar_lista'  => 'Para salvar este conteúdo, você precisa ter cadastro e fazer login. Deseja fazer Login?',
    ];
            
    public $mensagens_login = [     
        'titulo_sucesso'                        => 'Beleza!!',
        'titulo_atencao'                        => 'Atenção!!',
        'titulo_erro'                           => 'Vish!!!',
        'acesso_erro'                           => 'Usuário sem acesso a esta rotina',                
        'usuario_naoencontrado'                 => 'Não foi localizado este usuário no sistema',                
        'login_auth_bloqueado'                  => 'Este usuário não existe no sistema.',                
        'login_auth_senha_invalida'             => 'Usuário ou senha inválidos',        
        'login_verifica_email_link_sucesso'     => 'Confira seu email',
        'login_confirma_email_erro'             => 'Você já clicou nesse link',
        'login_confirma_email_sucesso'          => 'E-mail confirmado com sucesso :)',
        'login_reset_envio_link_sucesso'        => 'As instruções foram enviadas para o seu e-mail',
        'login_reset_envio_link_erro'           => 'Este email é inválido :(',        
        'login_reset_update_sucesso'            => 'Agora é só você recadastrar a sua nova senha',        
        'login_reset_update_erro'               => 'Esse link expirou :(',        
        'login_reset_update_conf_sucesso'       => 'Senha alterada',        
        'login_reset_update_conf_erro'          => 'Não foi possível alterar a sua senha. Tente novamente',        
    ];
    public $validatorException = [
        'titulo' => 'Erro de execução',
        'msg'    => 'Não foi possível executar este processo',
    ];

}
