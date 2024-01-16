<div class="form-check {{ $class ?? null }}">
    @php
        if (isset($checked)):

            if($checked=="true") {                
                $checked = "checked";
            }                
        endif;        
    @endphp   
    @if ($checked=="checked")
        <input 
        ref="ref_{{ $input ?? null }}" 
        type="hidden" 
        value="{{$oldValue ?? $value}}"> 
    @endif
    @if (isset($vmodel))        
        <input class="form-check-input"  v-model="{{$vmodel}}" ref="{{ $input ?? null }}" type="radio" name="{{ $input ?? null }}" id="{{ $value ?? null }}" value="{{ $value ?? null }}" {{ $checked ?? null }}>        
    @else 
        <input class="form-check-input"  type="radio" name="{{ $input ?? null }}" id="{{ $value ?? null }}" value="{{ $value ?? null }}" {{ $checked ?? null }}>
    @endif
    <span class="form-check-label click-checkbox " data-object="{{ $input ?? null }}">
        {{ $label ?? null }}
    </span>
</div>