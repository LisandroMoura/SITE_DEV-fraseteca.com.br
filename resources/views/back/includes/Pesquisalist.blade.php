@php
    $filtro = ''; $i=0; $fieldCampos="";    

    if (isset($campos)){
        if($campos){
            $fieldCampos="";
        }
    }
@endphp
<div class="card pesquisa">    
    <div class="well">
        
        @if (isset($rota))
            <form name="form_search" id="form-search" action="{{ route($rota)}}" method="get">            
        @else            
            <form name="form_search" 
                    id="form-search" 
                    action="{{$url ?? '' }}"
                    method="get"
            >
        @endif              

            @if (isset($campos))
                <div class="check">
                    <strong>Pesquisar por?</strong>
                    @foreach ($campos["dados"] as $campo)            
                        <div class="inline">
                            <input type="radio" id="{{$campo}}" name="campo"
                            @if ($campos["checked"] == $campo)
                                checked
                            @endif
                            value="{{$campo}}">
                            <label for="{{$campo}}">{{$campo}}</label>
                        </div>
                    @endforeach
                </div>
            @endif
            @if (isset($id))
                <input type="hidden" name="id" id="id" value="{{$id}}">
            @endif                  
            <input type="text" name="s" id="s" 
            placeholder="{{$placeholder ?? 'pesquisar'}}" class="fa fa-search pesquisa bordas-forms hasPlaceholder mobile">            
            <button class="botao-padrao full">Buscar</button>
        </form>
    </div>    
</div>