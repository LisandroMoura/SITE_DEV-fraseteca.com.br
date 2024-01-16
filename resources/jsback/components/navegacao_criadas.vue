<template>    
    <div>    

        <!-- v-show="this.$parent.show_loading"               -->
        <div class="navegacao" v-if="lastPage > 1">
            <div class="loading_navega"
                 v-show="this.$parent.show_loading"
                 >
                 
                
                <div class="table">
                    <div class="table-cell">

                        <div class="box">
                            <i class="icon-spin6 animate-spin"></i>
                            <span>carregando...</span>                            
                        </div> 
                        
                    </div>
                </div>
                
                
            </div>


            <!-- <div 
            
            class="loading_navega">                
                loading
            </div> -->


           
            <div v-if="currentPage==1">
                <span aria-hidden="true" class="custom-page-link prev disabled">
                    <span class="seta disabled"></span>
                    Anterior
                </span>   
            </div>
            <div v-else>
                <a href="#" 
                @click.stop.prevent='carregaCriadas(currentPage - 1)' 
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
                        @click.stop.prevent='carregaCriadas(index)'
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
                    @click.stop.prevent='carregaCriadas(currentPage + 1)'
                    rel="next" 
                    aria-label="Next »" 
                    class="custom-page-link next">
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
                listasCriadasFilho:[],
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
            carregaCriadas: function(acao){
                let url = `${this.path}?page=${acao}`;
                self = this;                
                self.$parent.listasCriadasPai = []
                this.$parent.show_loading=true
                axios({
                    method: 'get',
                    url: url,
                    responseType: 'json'                    
                    })
                    .then(function (response) {   
                        self.$parent.listasCriadasPai
                        self.currentPage = acao;  
                        self.listasCriadasFilho = response.data.dados.posts;  
                        self.enviarListasCriadas();
                    });            

            },            
            enviarListasCriadas () {
                this.$emit('get-lista-criadas', { dados: this.listasCriadasFilho})
                this.$parent.show_loading=false; 
                
            },
        }
    }
</script>