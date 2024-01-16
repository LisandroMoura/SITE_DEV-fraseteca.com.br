@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: Seoparam_analytics.blade.php
     * Autor: LM
     * Objetivo: Include do google Analytics do Front-end.
     * Doc: https://docs.google.com/document/d/1bLduegET6q4eCV4iKYZvbdJrwXaM77ZCjlMEaEIzHg8/edit
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     *  ● Projeto20220805 - SEO parametros para a Single de frase
     *     >> 15-08-22 - SeoParam ocultar analytics
     *
     *  ● Projeto20220701 - SEO parametros para a Single de frase
     *     >> 05-09-22 - Melhorar lógica desta função
     *        Da forma como estava, outras páginas como as categorias e as TAGS e a INDEX
     *        não estavam incluindo o código de acompanhamento do Analytics
     * 
     *  ● Projeto2023Jan10 -  Melhorando o LCP no Webmaster Tools - Tarefa: 6) Melhorias que devem ser implementadas identificadas na Revisão
     *      >> 01-02-23 - Retirado a função de ocultar o anaçytics do SEO PARAM, pois não vemos mais a necessidade de ocultar o Analytics
     *--------------------------------------------------------------------------------------------------------------*/

@endphp
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-V66X552YG6"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-V66X552YG6');
</script>
