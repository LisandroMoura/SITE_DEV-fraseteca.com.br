<button    
    type='{{ $type ?? "submit" }}'     
    @if (isset($vaction))
        ref="ref_{{ $input ?? null }}" 
        v-on:click="getConfirm('{{$vaction}}', $event, '{{$pergunta ?? "Confirma esta operação:?"}}', '{{$aviso ?? "atencao"}}', '{{$titulo ?? ""}}', '{{$lbconfirma ?? ''}}', '{{$lbcancela ?? ''}}')"
        datapergunta="{{$pergunta ?? 'Confirma esta operação:?'}}"
        dataaviso="{{$aviso ?? 'atencao'}}"
        datatitulo="{{$titulo ?? ''}}"
        datalbconfirma="{{$lbconfirma ??'Confirma'}}"
        datalbcancela="{{$lbcancela ?? 'Cancela'}}"
        class='btn btn-xs {{ $class ?? "btn-secondary" }}  {{ $icone ?? "" }} {{$vaction}}' 
    @endif

    class='botao-padrao {{ $class ?? "btn-secondary" }}  {{ $icone ?? "" }} ' 
    title="{{ $tip ?? "Executar" }}">    
    @if (isset($icone))
        <i class="fa fa-{{$icone}}">{{ $label ?? ''}}</i>        
    @else 
        <i class="fa fa-user">{{ $label ?? ''}}</i>        
    @endif
    
    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
</button>

