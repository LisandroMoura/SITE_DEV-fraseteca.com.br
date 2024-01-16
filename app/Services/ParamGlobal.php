<?php
namespace App\Services;
use App\Entities\ParametroGlobal;
/**
 * Classe comum sobre os parâmetros globais da aplicação
 * @package namespace App\Services;
 * @author  LM
 * @link    
 * @version 1.0.0 - Fev-2022
 */

class ParamGlobal
{    
    public function get($tipo = null)
    {
        $options=[];        
        $global = ParametroGlobal::first();
        $ambiente = new Ambiente;

        if (!$global)
            return $options;

        if($tipo=='arr')
            $options = [
                'tipo'                      => 'singles',
                'titulo_do_site'            => $global['titulo_do_site'],
                'logo'                      => $global['logo'],
                'logoMobile'                => $global['logoMobile'],
                'servidor_imagens_app'      => $global['servidor_imagens_app'],
                'servidor_imagens_usuario'  => $global['servidor_imagens_usuario'],
                'paginate'                  => $global['paginate'],
                'tamanho_upload_adm'        => $global['tamanho_upload_adm'],
                'txt_tamanho_upload_adm'    => $global['txt_tamanho_upload_adm'],
                'tamanho_upload_avatar'     => $global['tamanho_upload_avatar'],
                'txt_tamanho_upload_avatar' => $global['txt_tamanho_upload_avatar'],
                'width_upload_avatar'       => $global['width_upload_avatar'],
                'height_upload_avatar'      => $global['height_upload_avatar'],        
                'paginatePost'              => $global['paginatePost'],
                'width'                     => $global['width_upload_midia'],
                'height'                    => $global['height_upload_midia'],
                'limit_width'               => $global['limit_width_upload_midia'],
                'limit_height'              => $global['limit_height_upload_midia'],                
                'tamanho'                   => $global['tamanho_upload_midia'],
                'textoTamanho'              => $global['txt_tamanho_upload_midia'] ,
                'clientIdUnsplash'          => $global['clientIdUnsplash'] ,
                'collectionDefault'         => $global['collectionDefault'] ,
                'perPageUnsplash'           => $global['perPageUnsplash'] ,
                'keyYandex'                 => $global['keyYandex'] , 
                'msgFinalListas'            => $global['msg_final_listas'] , 
                'reCaptcha'                 => $global['aux_1'] ,
                'convite'                   =>$global['convite'] ,
                'paramGlobal'               => $ambiente->isProducao()
            ];  
        else 
            $options = json_encode([
                'tipo'                      => 'single',
                'titulo_do_site'            => $global['titulo_do_site'],
                'logo'                      => $global['logo'],
                'logoMobile'                => $global['logoMobile'],
                'servidor_imagens_app'      => $global['servidor_imagens_app'],
                'servidor_imagens_usuario'  => $global['servidor_imagens_usuario'],
                'paginate'                  => $global['paginate'],
                'tamanho_upload_adm'        => $global['tamanho_upload_adm'],
                'txt_tamanho_upload_adm'    => $global['txt_tamanho_upload_adm'],
                'tamanho_upload_avatar'     => $global['tamanho_upload_avatar'],
                'txt_tamanho_upload_avatar' => $global['txt_tamanho_upload_avatar'],
                'width_upload_avatar'       => $global['width_upload_avatar'],
                'height_upload_avatar'      => $global['height_upload_avatar'],        
                'paginatePost'              => $global['paginatePost'],
                'width'                     => $global['width_upload_midia'],
                'height'                    => $global['height_upload_midia'],
                'limit_width'               => $global['limit_width_upload_midia'],
                'limit_height'              => $global['limit_height_upload_midia'],                
                'tamanho'                   => $global['tamanho_upload_midia'],
                'textoTamanho'              => $global['txt_tamanho_upload_midia'] ,
                'clientIdUnsplash'          => $global['clientIdUnsplash'] ,
                'collectionDefault'         => $global['collectionDefault'] ,
                'perPageUnsplash'           => $global['perPageUnsplash'] ,
                'keyYandex'                 => $global['keyYandex'] , 
                'msgFinalListas'            => $global['msg_final_listas'] , 
                'convite'                   => $global['convite'],
                'reCaptcha'                 => $global['aux_1'] ,
                'paramGlobal'               => $ambiente->isProducao()
            ]);  

        return $options;
    } 
}
