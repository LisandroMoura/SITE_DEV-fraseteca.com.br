
@php
    if(!isset($dados)) return ;
    $observacao = $aprovacao->observacao ? $aprovacao->observacao:'';
    $idDaAprovacao = $aprovacao->id;    
    if(isset($_GET['idAprovacao'])) $idDaAprovacao = $_GET['idAprovacao'];


    use App\Services\ClearString;
    $functions= new ClearString;    

    $urlAmigavel =null;
    $canonical =null;


    if(count($dados->all())){
        $urlAmigavel = $functions->limpaCaracteresEspeciais($dados->titulo,"verifica", $dados->usuario_id);
        $canonical = $functions->limpaCaracteresEspeciais($dados->titulo,"canonical", $dados->usuario_id);
    }
        
@endphp
<section class=" margin-auto pasta--form--add aprovacao {{ $action }}">
    <h1>Aprovação: 👍️👍️👍️</h1>
    <form ref="formulario_aprova" 
    action="{{ route('aprovacao.aprovar')}}" 
    method="post" 
    enctype="multipart/form-data">
        {{ csrf_field() }}  
        @method('post')
        @include('front.includes.formulario.Hidden',['input' => 'idDaLista','value' => $dados->id,])
        @include('front.includes.formulario.Hidden',['input' => 'idDaAprovacao','value' => $idDaAprovacao,])

        <div class="container-section like-frase-box">                            
            <span><strong>Tipo de imagem para todas as frases:</strong></span>
            @include('front.includes.formulario.Radio',    ['input' => 'tipoImagemGlobal','class'=>'inline','label' => 'Default',  'value' => '0', 'checked' => 'checked' ])
            @include('front.includes.formulario.Radio',    ['input' => 'tipoImagemGlobal','class'=>'inline','label' => 'Amor',  'value' => '1', 'checked' => 'false' ])
            @include('front.includes.formulario.Radio',    ['input' => 'tipoImagemGlobal','class'=>'inline','label' => 'Degradê', 'value' => '2', 'checked' => 'false' ])
            @include('front.includes.formulario.Radio',    ['input' => 'tipoImagemGlobal','class'=>'inline','label' => 'Feminino', 'value' => '3', 'checked' => 'false' ])

            @include('front.includes.formulario.Hidden',[
                'input'  => 'tokenTipoImagem',
                'value'  => '', 
                'vmodel' => 'tokenTipoImagem',
                'ref'    => 'tokenTipoImagem',
            ])
        </div>
        <div class="container-section like-frase-box">                            
            <span><strong>Slug (url-amigável):</strong></span>                
            @include('front.includes.formulario.Input',    
            ['input' => 'urlAmigavel', 'ref' => 'urlAmigavel', "inputCol" => "", "class" => "magic w100", 'value' => $urlAmigavel])  
            @include('front.includes.formulario.Hidden',    
            ['input' => 'canonical', 'ref' => 'canonical', "class" => "magic", 'value' => $canonical])                     
        </div>

        <div class="container-section like-frase-box">                            
            <span><strong>ID Usuário autor da pasta:</strong> </span>
            @include('front.includes.formulario.Input',    
            ['input' => 'usuario_id', 'ref' => 'usuario_id', "inputCol" => "", "class" => "magic w100", 'value' => $dados->usuario_id])                    
        </div>

        <div class="container-section like-frase-box">
            <span><strong>Observações da aprovação:</strong></span>            
        </div>  
        <div class="container-section like-frase-box">    
            @if ($logado->perfil === '1')
                @include('front.includes.formulario.Textarea', [
                    'input'         => 'observacao',                                                
                    'value'         => $aprovacao->observacao,
                    'inputCol'      => 'w100',                                                
                    'class'         => 'descricao magic', 
                    'placeholder'   => 'Observações da aprovação',                                                                                        
                    'width'         => '100%', 
                    'cols'          => '5', 
                    'rows'          => '3',                                                 
                ])
            @else 
                <p>{{$observacao}}</p>
            @endif
            @include('front.includes.formulario.Btsalvar',[                
                'rota'    => 'aprovacao.resolver',
                'id'      =>  $dados->id,                                                  
                'confirma'=> 'formulario_aprova',   
                'class'   => 'botao-padrao full green',
                'vaction' => 'aprovar',                                                                                              
                'aviso'     => 'confirma info',
                'pergunta'  => 'Deseja Aprovar esta lista?',
                'lbcancela'  => 'Cancelar',
                'icone'  => 'heart',                                                    
                'label'  => 'Aprovado 👍️👍️👍️',
                'tip'    => 'Aprovar a lista'
            ])                         
        </div>  
    </form>

    <div class="container-section like-frase-box">   
        <span><strong>Observações da Rejeição:</strong></span>     
        <form ref="formulario_aprova" 
        action="{{ route('aprovacao.rejeitar')}}" 
        method="post" 
        enctype="multipart/form-data">                
            {{ csrf_field() }}                    
            @method('post')
            @include('front.includes.formulario.Hidden',['input' => 'idDaLista','value' => $dados->id,])
            @include('front.includes.formulario.Hidden',['input' => 'idDaAprovacao','value' => $idDaAprovacao,])
            @if ($logado->perfil === '1')
                @include('front.includes.formulario.Textarea', [
                    'input'         => 'observacao',                                                
                    'value'         => $aprovacao->observacao,
                    'inputCol'      => 'w100',                                                
                    'class'         => 'descricao magic', 
                    'placeholder'   => 'Observações da Reprovação: diga o que tá errado...',                                                                                        
                    'width'         => '100%', 
                    'cols'          => '5', 
                    'rows'          => '3',                                                 
                ])
            @else 
                <p>{{$observacao}}</p>
            @endif
            @include('front.includes.formulario.Btsalvar',[                
                'rota'    => 'aprovacao.resolver',
                'id'     =>  $dados->id,  
                'confirma'=> 'formulario_aprova',                                                    
                'aviso'     => 'confirma cuidado',
                'pergunta'  => 'Deseja Rejeitar esta Lista?',
                'class'  =>  "botao-padrao full red ",
                'vaction' => 'rejeitar',                                             
                'icone'  => 'cancel',                                                    
                'label'  => "Reprovado: 👎️👎️👎️",
                'tip'    => 'Rejeitar a Lista'
            ])
        </form>
    </div> 

</section>