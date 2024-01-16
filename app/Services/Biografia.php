<?php
namespace App\Services;
/**
 * Classe comum sobre a biografia dos autores do sistema
 * @package namespace App\Services;
 * @author  LM
 * @link    
 * @version 1.0.0 - Fev-2022
 */

class Biografia
{    
    public function get($autor_id, $limitar = 80,$tipo = null)
    {
        $dados=[
            "nome-autor"   => "fraseteca",
            "avatar"       =>  asset('images/default/avatar.svg'),
            "link-autor"   => "images/default/avatar.svg",
            "em-uma-frase" => "Se descreva em uma frase breve.",
        ];

        $autor = \App\Entities\Usuario::where ('id', '=',  $autor_id)   
        ->select("usuarios.id","usuarios.name","usuarios.url", "usuarios.nome_completo", "usuarios.informacoes_biograficas", "usuarios.conquista_id", "usuarios.aux_1", "usuarios.avatar_icone_id")
        ->first()
        ;
        if($autor){
            $textoDoLink=str_replace('http://', '',$autor->url);
            $textoDoLink=str_replace('https://', '',$textoDoLink);            
            $textoDoLink=str_replace('www.', '',$textoDoLink);            
            $conquista = $autor->formatado_conquista_id;
            $conquista = null;
            if($autor->testaTopUsuario())             
                $conquista = ["nome" => "Top Usuário","icone" => "super-fan"];
            $dados=[
                "id"           => $autor->id,
                "nome-autor"   => $autor->nome_completo,
                "avatar"       => $autor->getAvatarAttribute(),
                "link-autor"   => $autor->getLinkPerfil(), //"perfil/".$autor->name. '.' .$autor->id,
                "em-uma-frase" => $autor->informacoes_biograficas,
                "url"          => $autor->url,
                "textoDoLink"  => $textoDoLink,
                "conquista"    => $conquista
            ];  
        }
        return $dados;
    } 
}
