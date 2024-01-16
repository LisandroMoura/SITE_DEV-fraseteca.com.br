@php
    $dadosJson  = json_encode($dadosItens);
    $nreg       = count($dadosItens);
    $count      = 0;
@endphp
<script type="application/ld+json" id="{{$id}}">
    {
        "tabela" : "{{$tabela}}",
        "titulo" : "{{$titulo}}",
        "dados" :[
            @php echo $dadosJson; @endphp
        ]
    }
</script>
<script type="application/ld+json" id="arrDataPesquisa"></script>
<button id="carregaResultadoPesquisa">carregaResultadoPesquisa</button>

