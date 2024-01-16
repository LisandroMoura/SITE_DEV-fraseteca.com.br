@php
    /* start: Custom form old value*/
    $oldValue =null;
    if (!isset($value))
        $value = "";
    if (isset($old) && $old!='' )
        $oldValue = $old;
    else 
        $oldValue = null;
    /* End: Custom form old value*/

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
        <input 
        ref="ref_{{ $input ?? null }}" 
        type="hidden"        
        id="ref_{{ $input ?? null }}"
        value="{{$oldValue ?? $value}}">                        
        <textarea         
            @if (isset($V_SIZE))
                v-on:keyup="validaTamanho"   
            @endif    
            v-model.lazy="{{$vmodel}}"                        
            @if (isset($width)) style="width:{{$width}};" @endif
            name="{{ $input ?? null }}" 
            id="{{ $input ?? null }}" 
            placeholder="{{ $placeholder ?? null}}" 
            class="fadeIn second {{ $class ?? null }}"             
            @if (isset($cols)) cols="{{$cols}};" @endif
            @if (isset($rows)) rows="{{$rows}};" @endif            
            >{{$value ?? null}}</textarea>

            @if (isset($V_SIZE))
                <div class="contador">
                    <span ref="ref_conta">0</span>        
                    <span>/</span> 
                    <span ref="ref_limite">{{$V_SIZE ?? 240}}</span>
                </div>
            @endif            
    @else    
        <textarea
            @if (isset($width)) style="width:{{$width}};" @endif            
            name="{{ $input ?? null }}" 
            id="{{ $input ?? null }}" 
            placeholder="{{ $placeholder ?? null}}" 
            class="fadeIn second {{ $class ?? null }}" 
            @if (isset($cols)) cols="{{$cols}};" @endif
            @if (isset($rows)) rows="{{$rows}};" @endif        
            >{{$oldValue ?? $value}}</textarea>        
    @endif 

</div>   
    

   

    
