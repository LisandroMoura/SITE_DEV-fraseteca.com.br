@if (isset($vmodel))       
<input 
    ref="ref_{{ $vmodel ?? null }}" 
    type="hidden" 
    value="{{$value ?? null}}">  
    <input type="hidden" v-model="{{$vmodel}}" id="{{ $input ?? null }}" name="{{ $input ?? null}}" value="{{ $value ?? null}}">
@else    
    <input @if (isset($ref)) ref="ref_{{ $ref ?? null }}"
    @endif type="hidden" id="{{ $input ?? null }}" name="{{ $input ?? null}}" value="{{ $value ?? null}}">
@endif 

