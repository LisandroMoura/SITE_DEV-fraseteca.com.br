<div class="topo-do-site {{env("APP_ENV")}}">
    <div class="container">
        <div class="row">            
            <div class="col-3 side-a" >                
                @if ($amp)
                    @include('back.includes.Menubotoes',["amp" => true]) 
                    @include('front.includes.Logo',["amp" => true])                                                                
                @else
                    @include('back.includes.Menubotoes',["amp" => false]) 
                    @include('front.includes.Logo',["amp" => false])
                @endif
                
            </div>    
            <div class="col-6 side-b" >
                {{-- @include('back.menu-botoes') --}}                
                <div class="no-mobile"> 
                    @if ($amp)
                        
                    @else
                        @include('back.includes.Menuicons')
                    @endif                    
                </div>                
            </div>    
            <div class="col-3 side-c " >
                
                <div class="only-mobile"> 
                    @if ($amp)
                    @else
                        @include('back.includes.Menuicons', ["mobile" => true])
                    @endif
                </div>                

                <div class="float-right">
                        @include('back.includes.Acesso',["amp" => false])
                        @include('back.includes.Pesquisa',["amp" => false])                        
                    
                </div>                
            </div>


        </div>
    </div>    
</div>