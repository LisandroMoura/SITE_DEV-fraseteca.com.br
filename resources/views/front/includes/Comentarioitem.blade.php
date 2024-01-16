@php
/**
* -------------------------------------------------------
* UPDATES:
* -------------------------------------------------------
*  ● Projeto2023Jan01 - Imagens quebradas em LazyLoad
*     >> 01-01-23 - inserido data-srcset na tag img
*
*
 */ 

    $cont = 0;
    // $nivel_pai = 1;
    $nivel = isset($nivel) ? $nivel : 0;
    $classLazy = "lazy-hidden";
    $totaldeitems = count($comments);
@endphp
@foreach ($comments as $comment)
    @if ($comment->parent_id > 0)
        <ul class="comentarios--corpo respostas item-{{ $cont }}">
    @endif
    @php
        $cont++;
        $avatar = $comment->getAvatarUser();
        if (count($comment->replies)) $classtipo = 'with-reply';        
        else $classtipo = 'semrecuo';
    @endphp
    <li class="comentarios--corpo--item {{ $classtipo ?? ""}} @if($cont == 1 && $nivel == 0)start @endif ">
        <a class="avatar-link" href="{{$avatar['link-autor'] ?? ""}}">
            <img 
                @if ($classLazy=="") src="{{$avatar['imagem']}}" @else data-srcset="{{ $avatar['imagem'] }}" @endif 
                alt="autor do comentário" 
                @if($nivel == 0) width="56" height="56" @else width="37" height="37" @endif 
                class="avatar photo imagem-post {{ $classLazy }} no-print" >
        </a>
        <div class="comentario-wrapper ">
            <header class="">
                <span class="nome"><a href="{{$avatar['link-autor'] ?? ""}}">{{ $comment->autor_nome }}</a></span>
                <i class="ico ico-selo"></i>
                <span class="time-format">{{ $comment->getDataComment('normal') }}</span>
            </header>
            <div class="comentario @if (count($comments) == $cont) final @endif ">
                {{ $comment->body }}
            </div> 
            @include('front.includes.Comentarioitem', [
                'comments' => $comment->replies,
                'nivel' => $cont,
                'classtipo' => '', 
            ])
        </div>
        
    </li>
    @if ($comment->parent_id == 0)
        {{-- @if (count($comments) == $cont) --}}
            <div class="botao-responder  last ">
                @include('front.includes.Comentarioresponder', [
                    "title" => $comment->body,
                    "autor" => $comment->autor_nome,
                ])
            </div>
        {{-- @endif --}}
    @else
        
        </ul>
    @endif
@endforeach