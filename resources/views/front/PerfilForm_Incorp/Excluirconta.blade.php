<form ref="formulario" class="callBack" action="{{ route('usuario.excluirPerfil',$usuario->id)}}" method="post">
    {{ csrf_field() }}
    @method('PUT')
    {{-- área da imagem de Perfil / trocar imagem --}}

    <section class="campos alterar--senha">
        <div class="body-row-input">
            <div class="container-section max-width-content mb-10">
                <div class="aviso-ao-excluir">
                    <span>Após excluir sua conta, é impossível reativá-la depois :(</span>
                </div>
            </div>                           
        </div>                
    </section>        
    <section class="campos alterar--senha">
        <div class="body-row-input">
            <div class="container-section max-width-content mb-50">
                <div class="botao-salvar">
                        <button type="submit" data-label-botao="Confirmar" 
                        data-titulo="Tem Certeza?"
                        data-classbt="sem-destaque" 
                        title="Após excluído, o perfil não poderá ser restaurado" 
                        class="botao-padrao full submit bt-center excluir callConfirm">
                            Excluir Conta
                        </button>
                </div>
            </div>                            
        </div>  
    </section>                      
</form>