<div class="form-check {{ $class ?? "form-checkbox" }}">
    @php
        if (isset($checked)):
            if($checked=="true")
                $checked = "checked";        
        endif;
    @endphp    
    <input 
    @if (isset($vmodel))        
        v-model.lazy="{{$vmodel}}"                 
    @endif    
    @if (isset($vEvent))
        v-on:change="{{$vEvent}}($event)"
    @endif
    @if (isset($ref))
        ref="ref_{{ $input ?? null }}"
    @endif
    type="checkbox"         
    id="{{ $input ?? null }}" 
    name="{{ $input ?? null }}" 
    value="{{ $value ?? null }}"     
    {{ $checked ?? null }}
    class="{{ $class ?? "checkbox" }}"    
    >
    @if (isset($pai))
        <input type="hidden" 
            id="{{ $pai ?? null }}" 
            name="{{ $pai ?? null}}" 
            value="{{ $value ?? null}}"
            ref="ref_{{ $pai ?? null }}"            
            >
    @endif    
        <span class="form-check-label click-checkbox {{ $class ?? "checkbox" }}" data-object="{{ $input ?? null }}">
        {{ $label ?? null }}
    </span>
</div>