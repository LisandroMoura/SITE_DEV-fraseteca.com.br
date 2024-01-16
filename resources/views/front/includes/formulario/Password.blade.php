@php
    if (isset($msgValidator) && $msgValidator!='' )
        $msgValidacao = $msgValidator;
    else 
        $msgValidacao = null;
@endphp
@if (isset($label))
    <div class="{{ $labelCol ?? "col-lg-2" }} label-area {{ $align ?? null }}">
        <label for="">
            {{ $label ?? null }}
            @if (isset($ajuda))
                @if ($ajuda!="")
                    <span class="ajuda">
                        (?)
                        <span class="texto-ajuda">
                            {{$ajuda}}
                        </span>                    
                    </span>
                @endif        
            @endif
        </label>
    </div>
@endif
<div class="{{ $inputCol ?? "col-lg-10" }} field-input">
    @if (isset($requerid))
        @if ($requerid=="requerid")
            <span class="requerid"><i>*</i>obrigatório</span>            
        @endif        
    @endif 
    @if (isset($vmodel))
        <input type="password" v-model="{{$vmodel}}" value="{{ $value ?? null }}" id="{{ $input ?? null }}" class="{{$class ?? ""}} fadeIn third @php if (isset($msgValidacao)) echo 'erro'; @endphp" name="{{ $input ?? null}}"  placeholder="{{$placeholder ?? null}}">        
    @else    
        <input type="password"  value="{{ $value ?? null }}" id="{{ $input ?? null }}" class="{{$class ?? ""}} fadeIn third @php if (isset($msgValidacao)) echo 'erro'; @endphp" name="{{ $input ?? null}}" placeholder="{{ $placeholder ?? null}}">
    @endif 
    @if (isset($validator))
        <div id="validator_{{ $input ?? '' }}" class="area-aviso validatorSys @if (isset($msgValidacao)) mostrar @endif">                
            <div class="erro-icone">!</div>
            <div class="erro-descricao">{{$msgValidacao ?? ''}}
                <div class="area-arow">
                    <div class="erro-descricao-arow"></div>                            
                </div>
            </div>
        </div>  
    @endif            
</div>
<div class="field">
    <div class="helpers">                
            
       
    </div>    
</div>        
    