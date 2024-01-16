@php
    /* start: Custom form old value*/
    $oldValue =null;
    if (!isset($value))
        $value = "";
    if (isset($old) && $old!='' )
        $oldValue = $old;
    else 
        $oldValue = null;

    if($oldValue)    
        $value = $oldValue;
    /* End: Custom form old value*/
@endphp
@if (isset($label))
    @if ($label !="")
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
    @else 
    <div class="{{ $labelCol ?? "col-lg-2" }} space-top ">

    </div>
    @endif    
@endif
<div class="{{ $inputCol ?? "col-lg-10" }} field-input">
    <select 
        name="{{ $input ?? null }}" 
        id="{{ $input ?? null }}"  
        class="field-form {{ $class ?? input-field }} "
        >
        @if (isset($requerid))
            @if ($requerid=="requerid")
                <span class="requerid"><i>*</i>obrigatório</span>            
            @endif        
        @endif
        @foreach ($dados as $key => $dado)        
            <?php $selected = $value==$dado ? 'selected' : '' ?>
            <option value="{{$dado}}" {{$selected}} >
                @if ($key != $dado )
                    {{$key}}                
                @else
                    {{$dado}}
                @endif
                
            </option>                            
        @endforeach       
    </select>
    <i class="icone-select icon-down-dir"></i>
</div>