<?php

namespace App\Http\Middleware;

use Closure;

class HtmlCompressor
{
    /**
     * Handle an incoming request.
     * Docummentation: https://pt.stackoverflow.com/questions/152798/como-compactar-a-sa%C3%ADda-de-um-html-em-laravel
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $pageOk=  $response->headers->get('content-type');

        if (is_null($pageOk)) return $next($request);
        
        if (str_contains($response->headers->get('content-type'), 'text/html')) {
            $search = [
                '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
                '/[^\S ]+\</s',  // strip whitespaces before tags, except space
                '/(\s)+/s'       // shorten multiple whitespace sequences
            ];

            $replace = [
                '>',
                '<',
                '\\1'
            ];

            $response->setContent(preg_replace($search, $replace, $response->getContent()));
            
            return $response;
        }
        return $next($request);
        
    }
}
