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
    <input 
    ref="ref_{{ $input ?? null }}" 
    type="hidden" 
    value="{{$oldValue ?? $value}}">  
    <textarea         
        @if (isset($V_SIZE))
            maxlength="{{$V_SIZE}}"   
        @endif          
        @if (isset($minlength))            
            minlength="{{$minlength}}"   
        @endif

        @if (isset($dataIndex))            
            data-index="{{$contaLinhas-1}}"
        @endif
        

        @if (isset($width)) style="width:{{$width}};" @endif
        name="{{ $input ?? null }}" 
        id="{{ $input ?? null }}" 
        placeholder="{{ $placeholder ?? null}}" 
        class="fadeIn second magic-input {{ $class ?? null }}"             
        @if (isset($cols)) cols="{{$cols}};" @endif
        @if (isset($rows)) rows="{{$rows}};" @endif            
        >{{$value ?? null}}
    </textarea>

    @if (isset($emoji))
        @if ($emoji)
            <div class="wrapper-emoji-picker wrapper-emoji-{{ $input ?? "" }}">
                <emoji-picker  data-id="{{ $input ?? "" }}"  class="picker-{{ $input ?? "" }}"></emoji-picker>
                <a class="bt-sair-emoji"><i class="ico ico-sair ico-exit"></i></a>          
            </div>
            <svg class="open-emoji"
                data-id="{{ $input ?? "" }}" 
                style="max-height:20px; cursor:pointer" xmlns="http://www.w3.org/2000/svg" 
                width="18" 
                height="18" 
                viewBox="0 0 106.059 106.059" 
                fill="gray">
                <path d="M90.544 90.542c20.687-20.684 20.685-54.341.002-75.024-20.688-20.689-54.347-20.689-75.031-.006-20.688 20.687-20.686 54.346.002 75.034 20.682 20.684 54.341 20.684 75.027-.004zM21.302 21.3c17.494-17.493 45.959-17.495 63.457.002 17.494 17.494 17.492 45.963-.002 63.455-17.494 17.494-45.96 17.496-63.455.003-17.498-17.498-17.496-45.966 0-63.46zM27 69.865s-2.958-11.438 6.705-8.874c0 0 17.144 9.295 38.651 0 9.662-2.563 6.705 8.874 6.705 8.874C73.539 86.824 53.03 85.444 53.03 85.444S32.521 86.824 27 69.865zm6.24-31.194a6.202 6.202 0 1 1 12.399.001 6.202 6.202 0 0 1-12.399-.001zm28.117 0a6.202 6.202 0 1 1 12.403.001 6.202 6.202 0 0 1-12.403-.001z"></path>
            </svg>            
        @endif    
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

    <a class="magic-buttons bt-confirm-magic" data-target="{{$input ?? 0 }}" id="bt-confirm-magic-{{$input ?? '0'}}"><span class="ico ico-salvar-edicao-frases"></span></a>
    <a class="magic-buttons bt-cancel-magic" data-target="{{$input ?? 0 }}" id="bt-cancel-magic-{{$input ?? '0'}}"><span class="ico ico-cancelar-edicao-frases"></span></a>
</div>

