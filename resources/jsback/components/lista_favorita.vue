<template>    
 <div class="row">
    <div class="col">
        <ul class="ul-dados thumbnail">    
            <li :class="coluna" v-for="(dado, index) in this.$parent.listasFavoritasPai" :key="index">                
                
                <a v-if="dado.thumb" :href="`/${dado.urlamigavel}`" class="link-imagem col-lg-7" :title="`${dado.titulo}`"
                    :style="`width: 187px;height: 151px; background-image: url(${dado.thumb});`"
                    >
                </a>
                <a v-else :href="`/${dado.urlamigavel}`" class="link-imagem col-lg-7" :title="`${dado.titulo}`"
                    :style="`width: 187px;height: 151px; background-image: url(${dado.capa});`"
                    >
                </a>                
                <div class="texto col-lg-5">                    
                    <div class="table">
                        <div class="table-cell">
                            <a :href="`/${dado.urlamigavel}`" :title="`${dado.titulo}`">
                                {{dado.titulo}}
                            </a>
                        </div>
                    </div>                
                </div>
                <div class="barra-botoes favoritas">
                    <ul class="botoes">
                        <li class="item-botao"> 
                            <a href="#"
                            v-on:click.stop.prevent="deletaListaFavorita(dado.id, index)"
                            class="icon-trash-1"
                            :title="`Não quero mais isso. Deleta vai? ${dado.id}`"
                            >
                            <span>deletar</span>
                            </a>
                        </li>                        
                    </ul>                    
                </div>
            </li>
        </ul>
    </div>
 </div>    
</template>
<script>    
    export default {     
        props: ['propdados','opcoes'],   
        data () {
            return { 
                dados_favoritas :[], 
                opt:[],  
                coluna:"col-lg-4"             
            }
        },
        mounted() {
            this.opt                        = JSON.parse(this.opcoes) ;
            this.coluna                     = this.opt.coluna;
            this.$parent.listasFavoritasPai = JSON.parse(this.propdados);                          
        },
        watch:{        
        },
        methods:{
            deletaListaFavorita(id, index){
                let url;               
                const formData = new FormData();              
                formData.append('id',id);    
                url = `/favorita/${id}`;          
                axios.delete(url)
                .then(respo => {                     
                    if(respo.data.deleted){
                        this.$parent.listasFavoritasPai.splice(index, 1);
                        this.$toastr.s(`Sucesso! \n\r Lista favorita deletada`);
                    }                
                    else{
                        this.$toastr.e(`${respo.data.titulo_msg} ${respo.data.msg}`);              
                    }
                })
           },         
        },
    }
    
</script>

<style lang="scss">
    @import '../../sass/pages/favoritas.scss' ; 
</style>
