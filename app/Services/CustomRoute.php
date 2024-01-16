<?php
namespace App\Services;

use App\Exceptions\ValidatorException;
class CustomRoute
{    
    static function go($route) : String {
        $route = str_replace("http://d3fsumktfz5shm.cloudfront.net","https://fraseteca.com.br",$route);
        $route = str_replace("http://d14vrpqfv3ny06.cloudfront.net","https://fraseteca.com.br",$route);
        $route = str_replace("http://d2iwqd9yfj14nx.cloudfront.net","https://fraseteca.com.br",$route);
        // $route = str_replace("http://fraseteca.dev.io","https://fraseteca.com.br",$route);
        $route = str_replace("http://fraseteca.com.br","https://fraseteca.com.br",$route);
        return $route;
    }

}