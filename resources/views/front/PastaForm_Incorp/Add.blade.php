<section class="margin-auto pasta--form--add">
    <header>
        @if (isset($dados->itens))
            @if (count($dados->itens))
                <h2>Adicionar mais frases</h2>
            @else 
                <h2>Adicionar frase</h2>
            @endif
        @endif
    </header>
    <div class="container-section like-frase-box">
        <div class="row-input">
            @include('front.includes.formulario.Textareaback',  [
            'input' => 'novaFrase', 
            'minlength' => '10',
            'labelCol' => '',
            'placeholder' => 'no mínimo 10 letras',
            'inputCol' => 'w100',
            'class' => 'magic novaFrase',
            'emoji' => true
            ])
        </div>
        <div class="row-input coluna--novo--autor">
            @include('front.includes.formulario.Inputreq',  [
            'input' => 'novoAutor', 
            'vmodel' => 'novoAutor', 
            'labelCol' => '',
            'inputCol' => 'novo-autor',
            'class' => 'magic novoAutor',
            'placeholder' => 'Escreva o autor (não obrigatório)',
            ])
            <a href="" class="botao-novo-autor botao-padrao red circular w50 bt-ok bt-addNewItem nok">Ok!</a>
        </div>
        <div class="row-input">
            <a href=""  id="bt-buscar-no-site" class="botao-padrao full bt-buscar-no-site">Buscar no site</a>
        </div>
        <input name="pasta_id" id="pasta_id" type="hidden" value="{{$id}}">
        <div class="row-input">
            @include('front.includes.formulario.Btsalvar',[
                'rota'   => 'usuario.update',
                'icone'  => 'save save-branco',
                'class'  => 'submit bt-center botao-padrao full  btSalvarPasta',
                'id'     =>  "btSalvarPasta",  
                'label'  => 'Salvar Biblioteca',
                'tip'    => 'Salvar'
                ])

                @include('front.includes.formulario.Btsalvar',[
                    'rota'   => 'usuario.update',
                    'icone'  => 'save save-branco',
                    'class'  => 'botao-callaction flex branco submit bt-center btSalvarPastaFixed',
                    'id'     =>  "btSalvarPastaFixed",  
                    'label'  => 'Salvar agora?',
                    'tip'    => 'Documento está pendente, você precisa Salvar!'
                    ])
        </div>
        
    </div>
</section>