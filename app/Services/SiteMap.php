<?php

namespace App\Services;
/**
 * Class Functions.
 * Classe padrão pas as Funções da aplicação
 * similar ao arquivo functions do Wordpress
 * @package namespace App\Services;
 * @author  LM
 * @link    
 * @version 1.0.0 - Jun-2019
 */
use App\Entities\Post;
use App\Entities\Tag;
use App\Entities\Categoria;
use App\Entities\Frases;
use App\Entities\Autor;

class SiteMap 
{    
    public function build()
    {
        $header='<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';
        $footer="</urlset>";
        $body="";

        //home
        $home='<url>
                <loc>'.env("APP_URL").'</loc>
                <lastmod>2020-04-21T21:20:48+00:00</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.8</priority>
            </url>';

        //geração dos posts    
        $arrPosts=$this->buscaPosts()->all();
        $strPost="";
        foreach ($arrPosts as $key => $post) {            
            $strPost.= '<url>
            <loc>'.env("APP_URL")."/".$post->urlamigavel.'</loc>
            <lastmod>'. $post->updated_at->format('Y-m-d\Th:i:s').'+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
            </url>';            
        }

        //geração das Tags    
        $arrTags=$this->buscaTags()->all();
        $strTag="";
        foreach ($arrTags as $key => $tag) {
            # code...
            $strTag.= '<url>
            <loc>'.env("APP_URL")."/tag/".$tag->urlamigavel.'</loc>
            <lastmod>'. $tag->updated_at->format('Y-m-d\Th:i:s').'+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
            </url>';            
        }
        //geração das Categorias    
        $arrCats=$this->buscaCagetorias()->all();
        $strCat="";
        foreach ($arrCats as $key => $cat) {
            # code...
            $strCat.= '<url>
            <loc>'.env("APP_URL")."/sessao/".$cat->urlamigavel.'</loc>
            <lastmod>'. $cat->updated_at->format('Y-m-d\Th:i:s').'+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
            </url>';            
        }
        
        $sitemapBuild = $header.$home.$strPost.$strCat.$strTag.$footer;               
        //gerar o arquivo Fisicamente                       
        $fp = fopen(public_path('sitemap.xml'), 'w');
        $sitemap = fwrite($fp, $sitemapBuild);
        fclose($fp);
        return "";
    }
    public function buildAutor()
    {
        $header='<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';
        $footer="</urlset>";
        $body="";

        //home
        $home='';

        $autor = Autor::where(
            'index_search', '=',  '1'
        )->get();
        if(!$autor) return ;
        $arrFrases=$autor->all();
        $strFrase="";
        foreach ($arrFrases as $key => $frase) {
            if(str_contains($frase->urlamigavel,"/autor/")){
                $strFrase.= '<url>
                <loc>'.$frase->urlamigavel.'</loc>
                <lastmod>'. $frase->updated_at->format('Y-m-d\Th:i:s').'+00:00</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.8</priority>
                </url>';
            }
        }        
        $sitemapBuild = $header.$home.$strFrase.$footer;               
        //gerar o arquivo Fisicamente                       
        $fp = fopen(public_path('sitemap_autor.xml'), 'w');
        $sitemap = fwrite($fp, $sitemapBuild);
        fclose($fp);
        return "";
    }
    public function buildFrases($part)
    {
        $header='<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';
        $footer="</urlset>";
        $body="";

        //home
        $home='<url>
                <loc>'.env("APP_URL").'</loc>
                <lastmod>2020-04-21T21:20:48+00:00</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.8</priority>
            </url>';

        
        //geração das Frases
        $arrFrases=$this->buscaFrases($part)->all();
        $strFrase="";
        foreach ($arrFrases as $key => $frase) {
            # code...
            $strFrase.= '<url>
            <loc>'.env("APP_URL")."/frase/".$frase->id.'</loc>
            <lastmod>'. $frase->updated_at->format('Y-m-d\Th:i:s').'+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
            </url>';            
        }        
        
        $sitemapBuild = $header.$home.$strFrase.$footer;               
        //gerar o arquivo Fisicamente                       
        $fp = fopen(public_path("sitemap_frases_part$part.xml"), 'w+');
        $sitemap = fwrite($fp, $sitemapBuild);
        fclose($fp);
        return "";
    }
    public function buscaPosts()
    {
        $data = Post::where(
            'status', '=',  '1'
        )->get();
        if($data):                        
            return $data;
        else :
            return null;
        endif;
    }
    public function buscaTags()
    {
        $data = Tag::where(
            [
                ['status', '=',  '1'],
                ['disponivel', '=',  '1'],
            ] 
        )->get();
        if($data):                        
            return $data;
        else :
            return null;
        endif;
    }
    public function buscaCagetorias()
    {
        $data = Categoria::where(
            [
                ['status', '=',  '1'],
                ['disponivel', '=',  '1'],
            ]            
        )->get();
        if($data):                        
            return $data;
        else :
            return null;
        endif;
    }
    public function buscaFrases($part)
    {
        $de=0; $para = 10000;

        switch ($part) {
            case '1':
                $de=1; $para = 5000;
                break;
            
                case '11':
                    $de=1; $para = 1000;
                    break;
                
                case '12':
                    $de=1001; $para = 2000;
                    break;
                    case '121':
                        $de=1001; $para = 1500;
                        break;
                    case '122':
                        $de=1501; $para = 2000;
                        break;
                
                case '13':
                    $de=2001; $para = 3000;
                    break;
                
                case '14':
                    $de=3001; $para = 4000;
                    break;
            
                case '15':
                    $de=4001; $para = 5000;
                    break;
            
            case '2':
                $de=5001; $para = 10000;
                break;
            
            case '3':
                $de=1001; $para = 15000;
                break;
            
            case '4':
                $de=15001; $para = 20000;
                break;
            
            case '5':
                $de=20001; $para = 25000;
                break;
            
            case '6':
                $de=1; $para = 100;
                break;
            
        }
        
        $data = Frases::where(
            [
                ['status', '=',  '1'],
                ['titulo', '!=',  ''],
                ['id', '>=', $de],
                ['id', '<=', $para],
            ]            
        )->get();
        if($data):                        
            return $data;
        else :
            return null;
        endif;
    }
//the end class    
}
