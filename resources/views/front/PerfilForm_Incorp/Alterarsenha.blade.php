<form ref="formulario" action="{{ route('usuario.alterar_senha_update',$usuario->id)}}" method="post" enctype="multipart/form-data">
    @method('PUT'){{ csrf_field() }}

    <div class="wrapper-area-jsupload wrapper-area-trocar-senha" id="trocarSenhaBefore"></div>

    {{-- área da imagem de Perfil / trocar imagem --}}

    <section class="campos alterar--senha">
        <div class="body-row-input">
            <div class="container-section max-width-content mb-10">
                <div class="itens">                                
                    
                    @include('front.includes.formulario.Password',  [
                        'input' => 'abre_trocar_senha',
                        'label'=> 'Senha Atual',
                        'class' => 'abrir_trocar_senha',
                        'value' => '............',
                        'labelCol' => 'w100 abrir_trocar_senha', 
                        'inputCol' => 'w100',                                                                                 
                    ])
                </div>
            </div>
            <div class="demarcador-marca no-print"></div>
        </div>
    </section>
</form>