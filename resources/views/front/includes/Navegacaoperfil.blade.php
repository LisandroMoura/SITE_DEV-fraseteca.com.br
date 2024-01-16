@php
    if (!isset($lastPage))
    return;
@endphp
    @if ($lastPage > 1)
        <div class="navegacao_area"> 
        <div class="navegacao" 
        @if (isset($accordion))
            id="navega_{{$accordion}}"  
            data-atual="{{$currentPage}}"
            data-go="{{$accordion}}"
        @endif
        >
            @if ($currentPage==1)
                <div><span aria-hidden="true" class="custom-page-link disabled prev">
                    <span class="seta disabled">                        
                        @if ($amp)
                            
                        @else
                            <img src="{{asset("images/seta_prev_disable.png")}}" alt="seta <">
                        @endif                        
                    </span>
                    Anterior
                </span></div>                
            @else
                <div><a href="{{$path}}?page={{$currentPage - 1 }}&pesquisar={{$query}}"                  
                 rel="prev" data-action="{{$currentPage - 1}}" aria-label="« Previous" class="custom-page-link prev">
                    <span class="seta">
                        @if ($amp)
                            
                        @else
                            <img src="{{asset("images/seta_prev_enable.png")}}" alt="seta <">                            
                        @endif                        
                    </span>Anterior
                </a></div>
            @endif                
            @for ($i = 1; $i <= $lastPage; $i++)

                @if ($currentPage==$i)
                    <div><span aria-hidden="true" class="custom-page-link active">{{$i}}</span></div>
                @else
                    <div><a  href="{{$path}}?page={{$i}}&pesquisar={{$query}}"
                        rel="page"
                        data-action="{{$i}}"
                        class="custom-page-link"> {{$i}} </a>
                    </div>
                @endif 
            @endfor
            @if ($lastPage == $currentPage)
                <div><span aria-hidden="true" class="custom-page-link disabled next">
                    Próximo
                    <span class="seta disabled">
                        @if ($amp)
                            
                        @else
                            <img src="{{asset("images/seta_next_disable.png")}}" alt="seta >">                            
                        @endif
                        
                    </span>
                </span></div>
            @else
                <div><a href="{{$path}}?page={{$currentPage + 1 }}&pesquisar={{$query}}"                 
                rel="next" 
                aria-label="Next »" 
                data-action="{{$currentPage + 1}}"
                class="custom-page-link next">
                Próximo
                <span class="seta">
                    @if ($amp)
                            
                    @else
                        <img src="{{asset("images/seta_next_enable.png")}}" alt="seta >">                        
                    @endif                    
                </span>
                </a></div>
            @endif
            @if (isset($accordion))
                <input type="hidden" id="navega_{{$accordion}}_currentPage" value="{{$currentPage}}">
            @endif
        </div></div>
    @endif