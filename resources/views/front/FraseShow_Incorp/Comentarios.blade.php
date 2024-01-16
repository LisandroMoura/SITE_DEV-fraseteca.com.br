    @php 
    $usuario_email ="";
    $usuariologado ="";
    $usuario_id=null;

    //$logado = \Auth::user(); 
    if (isset($logado)):    
        $usuario_email = $logado->email;
        $usuario_id =$logado->id;
        if ($logado->nome_completo)
            $usuariologado = $logado->nome_completo;
        else
            $usuariologado = $logado->name;
    endif;
    //response    
    
    if ($errors->any()):        
        if (isset($errors->all()['autor_nome']))            
            $usuariologado = $errors->all()['autor_nome'];

        if (isset($errors->all()['autor_nome']))            
            $usuario_email = $errors->all()['autor_email'];

         if (isset($errors->all()['body']))            
             $aguardandoModeracao = $errors->all()['body'];
    endif;
@endphp

@if ($amp)
    <div class="container comentarios-wrapper">
        <div class="row">
            <div class="col">
                <div class="titulo-comentarios ">
                        @if (count($posts->comments) == 0 )
                            <div class="titulo titulo-com-icone">
                                <h3 class="sub-titulos">ver comentários</h3>
                            </div>
                        @else                    
                            <div class="titulo titulo-com-icone amp">
                                <a href="{{$seo['canonical']}}/#comentarios" class="bt-amp-comentario">
                                    <span class="numero">({{ count($posts->getCountComments)}})</span> ver comentários...                                
                                </a>
                            </div>
                        @endif
                </div>  
            </div>
        </div>    
    </div>
@else
    
    <div class="container comentarios-wrapper">
        <div class="row" id="comentarios">
            <div class="col">
                <div class="titulo-comentarios">
                    
                        @if (count($posts->comments) == 0 )
                            @if (!isset($logado))                         
                                <div class="criar-sua-conta">
                                    Para comentar você precisa se cadastrar. <br/>  <a href="/login" title="Clique aqui para criar a sua conta" rel="no-follow"><strong> Clique aqui</strong> para criar a sua conta!</a>                                    
                                </div>
                            @else
                                <h3 class="sub-titulos titulo-com-icone">Comentários</h3>
                            @endif
                        @else
                            <h3 class="sub-titulos titulo-com-icone"> <span class="numero">{{ count($posts->getCountComments)}}</span> Comentários</h3>
                        @endif
                </div>  
            </div>
        </div>        
        {{-- Formulário de comentário --}}   
        @if (isset($logado)) 
            <div class="comentario-formulario">
                <div id="comentar">
                    <form method="post" id="form_comentar" ref="comentar" action="{{ route('comments.store')}}">
                        @csrf                    
                            <div class="preleitura">
                                
                            </div>
                            <textarea 
                                name="body" 
                                minlength="4"
                                class="comentario-input"
                                id="body"
                                cols="30" rows="10"
                                placeholder="Adicionar comentário..."></textarea>
                            <input type="hidden" name="table" id="table" value="comment_frases"/>
                            <input type="hidden" name="parent_id" id="parent_id"   value="" />
                            <input type="hidden" name="status"  value="0" />
                            <input type="hidden" name="usuario_id" value="{{ $usuario_id }}" />
                            <input type="hidden" name="post_id" value="{{ $posts->id }}" />                            
                            <input type="hidden" name="frase_id" id="frase_id"  value="{{ $posts->id }}" />                            
                            
                        <input 
                        type="submit" 
                        id="validaSubmit"
                        value="Comentar!"                         
                        class="padrao-call-action-with-validator nok">
                        
                    </form>
                </div>
            </div>            
        @endif        
        <div class="row comentarios">
            <div class="col">
                @if (isset($aguardandoModeracao))
                    <div class="aguardando-moderacao">    
                        <div class="label-aguardando">Aguardando moderação...</div>
                        <p>{{$aguardandoModeracao}}</p>                
                    </div>               
                @endif                
                <ul class="ul-coments principal">
                    @include('front.includes.Commentsdisplay', ['comments' => $posts->comments, 'post_id' => $posts->id])
                </ul>
            </div>
        </div>
    </div>
@endif
