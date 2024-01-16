@php
    $cont = 0;
    $nivel = isset($nivel) ? $nivel : 0;
    $class = '';
    $classReplies = 'semrecuo';
    if ($cont == 0) $class = 'primeironivel';
    $classLazy = "lazy-hidden";
        
@endphp
@foreach ($comments as $comment)
    @if ($comment->parent_id > 0)
        <ul class="comentarios--publicacao--item respostas item-{{ $cont }}">
    @endif
    @php
        $cont++;
        $avatar = $comment->getAvatarUser();
        if (count($comment->replies)) $classReplies = 'comrecuo';
        else $classReplies = 'semrecuo';
    @endphp
    <li class="li-comentario linha">
        <div class="coluna1">
            <div class="icone-autor">
                @if ($avatar['link-autor'] != '')
                    <a class="link-autor" href="/{{ $avatar['link-autor'] }}"
                        title="Que tal ver o perfil de {{ $comment->autor_nome }}?">
                        <img
                        @if ($classLazy=="") src="{{$avatar['imagem']}}" @else data-src="{{ $avatar['imagem'] }}" @endif 
                        alt="{{ $comment->autor_nome }}"
                        class="avatar photo imagem-post {{ $classLazy }} no-print"
                        >
                    </a>
                @else
                <img
                    @if ($classLazy=="") src="{{$avatar['imagem']}}" @else data-src="{{ $avatar['imagem'] }}" @endif 
                    alt="{{ $comment->autor_nome }}"
                    class="avatar photo imagem-post {{ $classLazy }} no-print"
                    >
                @endif
            </div>
        </div>
        <div class="coluna2">
            <div class="autor-do-comentario-zone">
                <div class="conquista-do-usuario">
                    <div class="conquista">
                        @if (isset($avatar['conquista']['nome']))
                            <div class="icone-box"><i
                                    class="icone {{ $avatar['conquista']['icone'] ?? 'super-fan' }}"></i></div>
                            <div class="icone-label">{{ $avatar['conquista']['nome'] }}</div>
                        @endif
                    </div>
                </div>
                <div class="nome-do-autor-e-data">
                    @if ($avatar['link-autor'] != '')
                        <a class="link-autor" href="/{{ $avatar['link-autor'] }}"
                            title="Que tal ver o perfil de {{ $comment->autor_nome }}?">
                            <span class="nome-do-autor"> {{ $comment->autor_nome }} </span>
                        </a>
                    @else
                        <span class="nome-do-autor"> {{ $comment->autor_nome }} </span>
                    @endif
                    <div class="data-comentario-content">
                        <span class="data-normal"> {{ $comment->getDataComment('normal') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-corpo-comentario">
            <div class="texto-comentario">
                {{ $comment->body }}
            </div>
            @include('front.includes.Commentsdisplay', [
                'comments' => $comment->replies,
                'nivel' => $cont,
            ])
        </div>
    </li>
    @if ($comment->parent_id == 0)
        @php if (count($comments) == $cont) $classReplies = 'semrecuo'; @endphp
        <li class="li-resposta {{ $classReplies }}">
            <div class="botao-responder">
                <a
                    @if (isset($logado)) 
                        href="#comentarios"
                        rel="nofollow"
                        title="<b>Respondendo á {{ $comment->autor_nome }}:</b> {{ $comment->body }}" 
                        class="btn box bt-responder"                                                    
                        id="{{ $comment->id }}"                            
                    @else
                        href="/login"
                        rel="nofollow"
                        title="Para poder comentar no site, você precisa ter cadastro e fazer login. Deseja fazer Login?" 
                        class="btn box callLogin_" @endif>Responder</a>
                <a href="#comentarios" class="bt-responder-go"></a>
            </div>
        </li>
    @else
        </ul>
    @endif
@endforeach
