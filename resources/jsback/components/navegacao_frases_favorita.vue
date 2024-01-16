<template>    
    <div>                  
        <div class="navegacao" v-if="lastPage > 1">
            <div v-if="currentPage==1">
                 <span aria-hidden="true" class="custom-page-link prev disabled">
                     <span class="seta disabled"></span>
                     Anterior                     
                </span>   
            </div>
            <div v-else>
                <a href="#" 
                @click.stop.prevent='carregaFavoritas(currentPage - 1)' 
                rel="prev" aria-label="« Previous" class="custom-page-link prev">
                <span class="seta"></span>
                Anterior</a>
            </div>

            <div class="" 
                v-for="index in total">                
                <div v-if="currentPage==index">                
                    <span aria-hidden="true" class="custom-page-link active">{{index}}</span>
                </div>
                <div v-else>
                    <a  href="path?page=index" 
                        @click.stop.prevent='carregaFavoritas(index)'
                        class="custom-page-link"> {{index}} </a>
                </div>                
            </div>
            
            <div v-if ="lastPage == currentPage" >
                <span aria-hidden="true" class="custom-page-link next disabled">
                    Próximo
                    <span class="seta disabled"></span>
                </span>            
            </div>
            <div v-else>
                <a href="" 
                @click.stop.prevent='carregaFavoritas(currentPage + 1)'
                rel="next" 
                aria-label="Next »" 
                class="custom-page-link next ">
                Próximo
                <span class="seta"></span>
                </a> 
            </div> 
        </div>
    </div>     
</template>
<script>    
    export default {     
        props: ['opcoes'],   
        data () {
            return { 
                listasFavoritasFilho:[],
                total       :3,
                path        :"",
                lastPage    :1,
                perPage     :0,
                currentPage :1,                
                opt:[]
            }
        },
        mounted() {                 
            this.opt         = JSON.parse(this.opcoes) ;
            this.total       = Math.ceil(this.opt.total / this.opt.perPage);            
            this.path        = this.opt.path;
            this.lastPage    = this.opt.lastPage;                     
            this.perPage     = this.opt.perPage;
            this.currentPage = this.opt.currentPage;
        },
        watch:{        
        },
        methods:{  
            carregaFavoritas: function(acao){
                let url = `${this.path}?page=${acao}`;
                self = this;                
                axios({
                    method: 'get',
                    url: url,
                    responseType: 'json'                    
                    })
                    .then(function (response) {                                                                       
                        self.currentPage = acao;  
                        self.listasFavoritasFilho = response.data.dados.frases;  
                        self.enviarFrases();
                    });            
            },          
            enviarFrases () {
                this.$emit('get-frases', { dados: this.listasFavoritasFilho})
            },
            
        }
    }
</script>

<style lang="scss" scoped>
        
</style>
