@if (count($logado->notific))    
    <div class="container container-full corpo-notificacao">         
        <div id="notificacao-wrapper" class="notificacao-wrapper">
            <header>
                <div class="marg mgl"></div>
                <div class="center">                         
                        <span id="notific_count">Notificações({{count($logado->notific)}})</span>
                    </div>
                <div class="marg mgr">
                    <button id="btn-fechar-tudo" class="button button-notific btn-fechar"><i class="ico ico-close atencao"></i></button>
                </div>                
            </header>
            <ul class="ul_notific">
                @foreach ($logado->notific as $item)        
                    @php
                        $url = $item->cb;

                        switch ($item->tipo) {
                            case '1':
                                $url = $item->cb;
                                break;
                            case '2':
                                $url = $item->cb;
                                break;
                            case '3':
                                $url = $item->cb;
                                break;
                        }
                    @endphp
                    <li id="notific_{{$item->id}}" class="li_notific">
                        <a 
                            class="callback_item"
                            target="blank"
                            href="{{$url}}"
                            idData="{{$item->id}}">
                           <div class="icone"><i class="ico ico-aspas"></i></div>
                            <div class="texto">{{$item->texto}}</div>
                        </a>
                        <button class="button button-notific btn-marcar-item-lido" idData="{{$item->id}}">ok</button>
                    </li>
                @endforeach    
            </ul>
            <footer>
                <button class="button btn-marcar-todos" id="btn-marcar-todos">marcar todos como lido</button>
            </footer>
        </div>          
    </div>
    @php $rand = rand(0,9); @endphp
    <input type="hidden" id="token_reverso_notific" value="l{{$rand}}{{$logado->id}}">
@endif