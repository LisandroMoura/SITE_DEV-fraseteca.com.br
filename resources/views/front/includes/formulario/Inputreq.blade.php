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

if (isset($msgValidator) && $msgValidator!='' )
    $msgValidacao = $msgValidator;
else 
    $msgValidacao = null;

@endphp
@if (isset($label))
    @if ($label !="")
        <div class="{{ $labelCol ?? "col-lg-2" }} label-area {{ $align ?? null }}">
            <label for="">
                {{ $label ?? null }}
                @if (isset($ajuda))
                    @if ($ajuda!="")
                        <span class="ajuda">
                            @if (isset($requerid))
                                @if ($requerid=="requerid")
                                    <span class="requerid"><i>*</i></span>            
                                @endif        
                            @endif   
                            <span class="texto-ajuda">
                                {{$ajuda}}
                            </span>                    
                        </span>
                    @endif        
                @endif
            </label>
        </div> 
    @else 
    <div class="{{ $labelCol ?? "col-lg-2" }} space-top ">

    </div>
    @endif    
@endif

<div class="{{ $inputCol ?? "col-lg-10" }} field-input" id="field-input_{{$input ?? null}}">
    
    @if (isset($vmodel))        
        <input 
        ref="ref_{{ $input ?? null }}" 
        type="hidden" 
        value="{{$oldValue ?? $value}}">  
        <input type="text" 
            v-model.lazy="{{$vmodel}}" 
            @if (isset($width)) style="width:{{$width}};" @endif 
            id="{{ $input ?? null }}" 
            class="field-form {{ $class ?? null }} @php if (isset($msgValidacao)) echo "erro"; @endphp"
            name="{{ $input ?? null}}" 
            placeholder="{{ $placeholder ?? null}}" 
            value="{{$oldValue ?? $value}}"
            >

    @else    
        <input type="text" 
            @if (isset($width)) style="width:{{$width}};" @endif 
            ref="ref_{{ $input ?? null }}"
            id="{{ $input ?? null }}" 
            class="field-form {{ $class ?? null }} @php if (isset($msgValidacao)) echo "erro"; @endphp @error($input) is-invalid @enderror" 
            name="{{ $input ?? null}}"
            placeholder="{{ $placeholder ?? null}}"
            value="{{$oldValue ?? $value}}"
            @if (isset($ref))                        
                ref="ref_{{ $input ?? null }}"
            @endif
            >
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
    