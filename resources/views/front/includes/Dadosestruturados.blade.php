@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Dadosestruturados.blade.php
     * Autor: LM
     * Objetivo: Include do responsável pela inclusão do JSON dos dados estrturados 
     * Doc: PENDENTE
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *  ● Projeto2023Jan10 -  Melhorando o LCP no Webmaster Tools - Tarefa: 6) Melhorias que devem ser implementadas identificadas na Revisão
     *      >> 01-02-23 - Retirado os testes em relação ao $boolteste3 do Projeto Projeto20221110
     *--------------------------------------------------------------------------------------------------------------*/
@endphp
<script type="application/ld+json">
{
    "@context":"http://schema.org",
    "@type":"NewsArticle","name":"{{$titulo ?? 'Fraseteca'}}",
    "headline":"{{$titulo ?? 'Fraseteca'}}",
    "url":"{{$canonical ?? 'https://fraseteca.com.br'}}",
    "description":" {{$resumo ?? 'Fraseteca'}}",
    "datePublished" :"{{$publishedtime ?? '2019-08-09T08:00:00+08:00'}}",
    "dateModified" :"{{$modifiedtime ?? '2019-08-09T08:00:00+08:00'}}",
    "author":{
        "@type":"Person",
        "name":"por Fraseteca",
        "url":"https://fraseteca.com.br"
    },
    "image":{
        "@type":"ImageObject",
        "url":"{{$image ?? 'https://fraseteca.com.br/images/logo-v06.svg'}}",
        "description":"{{$titulo ?? 'Fraseteca'}}",
        "width":{{ $imagewidth ?? '150' }},
        "height":{{$imageheight ?? '33'}}
    },    
    "mainEntityOfPage":{
        "@type":"WebPage",
        "@id":"https://fraseteca.com.br/"
    },
    "publisher":{
        "@type":"Organization",
        "name":"fraseteca.com.br",
        "logo":{
            "@type":"ImageObject",
            "url":"https://fraseteca.com.br/images/logo-v06.svg",
            "width":150,
            "height":33
        }
    }
}
</script>