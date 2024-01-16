<?php
namespace App\Services;
class Anuncios
{    
    static function get($tipoAnuncio){
        $tipo="";
        $tipoArr = explode("@@",$tipoAnuncio);
        foreach ($tipoArr as $key => $value) {
            $value = str_replace("<anuncio>", "", $value);
            $value = str_replace("</anuncio>", "", $value);            
            if(trim($value)!="")
                $tipo = $value;
        }
        if (Ambiente::Producao()){
            // switch ($tipo) {
            //     case 'normal':
            //         $codeAds= '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-6159622292805097" data-ad-slot="6042966650" data-ad-format="auto" data-full-width-responsive="true"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';
            //         break;

            //     case 'left':
            //         $codeAds= '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-6159622292805097"data-ad-slot="3505923919"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';
            //         break;
                
            //     case 'article':
            //         $codeAds= '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:block; text-align:center;"data-ad-layout="in-article" data-ad-format="fluid" data-ad-client="ca-pub-6159622292805097" data-ad-slot="3842234797"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';
            //         break;

            //     default:                    
            //         $codeAds= '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:block; text-align:center;"data-ad-layout="in-article" data-ad-format="fluid" data-ad-client="ca-pub-6159622292805097" data-ad-slot="3842234797"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';
            //         break;
            // }
            //$codeAds= '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:block; text-align:center;"data-ad-layout="in-article" data-ad-format="fluid" data-ad-client="ca-pub-6159622292805097" data-ad-slot="3842234797"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';
            // $return= '<div class="anuncio ' . $tipo. '"> '. $codeAds.'</div>';
        }
        else{
            $codeAds= '<span class="localhost"> ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## Anúncio Ambiente Teste: '.$tipo.' #   ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## </span>';
            $return= '<div class="anuncio ' . $tipo. '"> '. $codeAds.'</div>';            
        }        
        return $return;
    }
}
