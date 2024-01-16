<button 
type="submit" 
@if (isset($confirma))
@click.stop.prevent="getConfirm('{{$confirma}}', $event, '{{$pergunta ?? "Confirma esta operação:?"}}', '{{$aviso ?? "atencao"}}', '{{$vaction ?? "action"}}', '{{$lbconfirma ?? ''}}', '{{$lbcancela ?? ''}}')"
@elseif (isset($vaction))
    @click.stop.prevent="{{$vaction}}"
@endif
id={{ $id ?? "btn" }}
class=' {{ $icone ?? "" }} {{ $class ?? null }}' 
title="{{ $tip ?? "Inserir" }}"
>
    @if (isset($icone))        
        <i class="icon-{{$icone}} icon {{$icone}}"></i>
    @endif    
    @if (isset($label))
        <span>{{$label}}</span>    
    @endif    

</button>