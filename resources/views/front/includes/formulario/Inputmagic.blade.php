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


<div class="magic-input-frame {{$class}} " id="wrapper-magic-input_{{$input ?? null}}">
    
    @if (isset($vmodel))        
        <input 
        ref="ref_{{ $input ?? null }}" 
        type="hidden" 
        value="{{$oldValue ?? $value}}">  
        <input type="text" 
            v-model.lazy="{{$vmodel}}" 
            @if (isset($dataIndex))            
                data-index="{{$contaLinhas-1}}"
            @endif
            @if (isset($width)) style="width:{{$width}};" @endif 
            id="{{ $input ?? null }}" 
            class="magic-input {{ $class ?? null }} @php if (isset($msgValidacao)) echo "erro"; @endphp"
            name="{{ $input ?? null}}" 
            placeholder="{{ $placeholder ?? null}}" 
            value="{{$oldValue ?? $value}}"
            >

    @else    
        <input type="text" 
            @if (isset($width)) style="width:{{$width}};" @endif 
            ref="ref_{{ $input ?? null }}"
            id="{{ $input ?? null }}" 
            @if (isset($dataIndex))            
                data-index="{{$contaLinhas-1}}"
            @endif
            class="magic-input  {{ $class ?? null }} @php if (isset($msgValidacao)) echo "erro"; @endphp @error($input) is-invalid @enderror" 
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
    {{-- <a class="magic-buttons bt-confirm-magic" data-target="{{$input ?? 0 }}" id="bt-confirm-magic-{{$input ?? '0'}}"><span class="ico ico-salvar-edicao-frases"></span></a>
    <a class="magic-buttons bt-cancel-magic" data-target="{{$input ?? 0 }}" id="bt-cancel-magic-{{$input ?? '0'}}"><span class="ico ico-cancelar-edicao-frases"></span></a> --}}
</div>

