<template>
    
    <div id="confirma" class="container vue-js-component ">

        <div v-for="option in confirma" class="vue-js-modal">
            <div v-if="option.mostra === 'sim'" class="modal-zone">
                <div v-bind:class="option.aviso" class="wrapper-modal-dialog ativo default" >
                    <header>                        
                        <div v-if="option.aviso === 'confirma cuidado'">
                            <i class="icon bt-confirma icon-exclamation-triangle "></i>
                            <span v-if="option.titulo">
                                {{option.titulo}}
                            </span>
                            <span v-else>
                                Cuidado!
                            </span>
                        </div>                        
                        <div v-else-if="option.aviso === 'confirma aviso'">
                            <i class="icon bt-confirma icon-exclamation-triangle "></i>
                            <span v-if="option.titulo">
                                {{option.titulo}}
                            </span>
                            <span v-else>
                                Atenção! 
                            </span>
                        </div>                                        
                        <div v-else>
                            <i class="icon bt-confirma icon-exclamation-triangle "></i> 
                            <span v-if="option.titulo">
                                {{option.titulo}}
                            </span>
                            <span v-else>
                                Atenção!
                            </span>                            
                        </div> 
                        <a class="botao-fechar-dialog abreCompartilhar icone-fechar" v-on:click.stop.prevent="cancelar(option.evento)"><i class="ico ico-fechar"></i></a>
                    </header>
                    <div class="conteudo">
                        <div class="box texto">
                            <span v-if="option.pergunta">
                                {{option.pergunta}}
                            </span>   
                        </div>

                        <div class="box botoes">
                            <a href="#"  v-on:click.stop.prevent="confirmar(option.evento, option.vaction)" class="true botao-padrao red true">
                                <span v-if="option.lbconfirma">
                                    {{option.lbconfirma}}
                                </span> 
                                <span v-else>
                                    Confirma
                                </span>                         
                            </a>        
                            <a href="#"  v-on:click.stop.prevent="cancelar(option.evento)"  class="false botao-padrao white true">                                
                                <span v-if="option.lbcancela">
                                    {{option.lbcancela}}
                                </span> 
                                <span v-else>
                                    Cancela
                                </span>                            
                            </a>
                        </div>
                    </div>
                </div>
            </div>        
        </div>            
    </div>
    
</template>
<script>
    // usando as variáveis antes do data
    //let nextTodoId = 1;   
    export default {
        props: ['confirma'],
        data () {
            return {              
               
            }
        },

        computed: {                        
            
        },
        watch:{
            
        },
        filters:{
            
        },
        methods: {
            confirmar:function(evento, action = null){                     
                
                if (action){
                    this.confirma[0].mostra = 'não';
                    let pai = this.$parent;
                    pai[action]();

                }
                else {
                    evento.submit(); 
                }
            },
            cancelar:function(){
                this.confirma[0].mostra = 'não';
            }

            
        },
        mounted() {
            
        },	
    }
</script>