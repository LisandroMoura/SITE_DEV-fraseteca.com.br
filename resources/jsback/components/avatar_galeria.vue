<template>    
    <div>

        <!-- INICIO -->
        <a href="#"
        class="icon icon-galeria"
        @click.stop.prevent="abrir" 
        ></a>       
        <div class="mostrar" v-show="$parent.mostrarGaleria" 
        v-if="$parent.escolhido!='computador'"
        >
            
            <div class="modal-zone">
                <div class="wrapper">
                    <div class="uploader"
                        :class="{dragging: isDragging}">
                        <div >
                            <div class="header-content">                        
                                <h3 class="header-title">Galeria de Avatar</h3>
                                <a id="bt-sair" class="bt-sair-pesquisa bt-sair"><i class="ico ico-sair ico-exit"></i></a>
                            </div>
                            <!-- FIM corpo -->
                            <div class="erros" v-if="this.msgErros !=''">{{msgErros}}</div>
                            <div class="corpo">     
                                <div class="linha">     
                                    <div class="search-images avatar-galeria">
                                        <input
                                        type="text" 
                                        id="pesquisar" 
                                        v-model.lazy="pesquisar" 
                                        placeholder="digite um tema..."
                                        v-on:keyup.enter="search"                    
                                        >
                                        
                                        <input type="hidden" id="pagina" v-model.lazy="pagina">
                                        <i class="fas fa-search"></i>
                                        <button 
                                            class="btn btn-sucess avatar-galeria"
                                            @click.stop.prevent="search">
                                            GO!
                                        </button>                    
                                    </div>    

                                    <div class="carregando" v-show="this.isLoading">carregando...</div>    
                                    
                                </div>
                                <div class="linha image-preview" v-show="images.length">
                                    
                                    <ul>
                                        <li class="navega" v-show="this.pagina>1">
                                            <a class="bt-navega anterior"  href="#"
                                            @click.stop.prevent="anterior"
                                            >
                                            Anterior
                                            <span class="name" v-text="this.pagina-1"></span>
                                            </a>                        
                                        </li>
                                        <li v-for="(image, index) in images" :key="index">
                                            <div class="item" :id="image.id">
                                                
                                                <span                                                 
                                                class="background-box" 
                                                    :data="'/storage/images/'+image.url"
                                                    @click.stop.prevent="confirmarCapa('/storage/images/' + image.url, image.id)"
                                                    v-bind:style="{ backgroundImage: 'url(/storage/images/' + image.url + ')' }" 
                                                >                               
                                                </span>


                                                <!-- <span 
                                                    v-if="image.tipo==3"
                                                    class="background-box" 
                                                    :data="'/storage/'+image.url"
                                                    @click.stop.prevent="confirmarCapa('/storage/' + image.url,image.id)"
                                                    v-bind:style="{ backgroundImage: 'url(/storage/' + image.url + ')' }" 
                                                >                               
                                                </span> -->

                                                <!-- <img :src="image.urls.thumb" :alt="`id Upload ${index}`"> -->
                                                
                                                <!-- <div class="autor-foto">
                                                    <a :href="image.user.links.html" target="blank">
                                                        <span class="name" v-text="image.user.name"></span>
                                                    </a>
                                                </div> -->
                                            </div>
                                        </li>
                                        <li class="navega" v-show="this.pagina < this.last_page">
                                            <a class="bt-navega proximo"  href="#"
                                            @click.stop.prevent="proximo"
                                            >
                                            Próximo
                                            <span class="name" v-text="this.pagina"></span>
                                            </a>                        
                                        </li>
                                    </ul>
                                </div>    
                            </div>
                            <!-- FIM corpo -->
                        </div>
                    </div>
                </div>                
            </div>
        </div>        
    </div>
</template>

<script>    
    export default {     
        props: ['opcoes'],   
        data () {
            return {
                isDragging: false,    
                isErroDimensoes:false,
                dragCount:0,                  
                pesquisar:'amor',
                termoAtual:'',                
                last_page:'',
                pagina:'1',
                isLoading:false,
                editor:'',
                opt:[],                
                names: [],
                images: [],
                images_clone: [],                
                files: [],
                msgErros:''
            }
        },
        mounted() {              
            this.opt = JSON.parse(this.opcoes)               
            this.search();             
        },
         methods:{
             abrir(){
                 this.$parent.mostrarGaleria=true;
                 this.$parent.escolhido='galeria';
             },  
            confirmarCapa(imgSrc,id){
                let self = this;
                //new
                this.$parent.origemGaleria = true;
                this.$parent.startConfirmarCapa()   
                this.$parent.setaAvatar(imgSrc,id);
                //new
                setTimeout(function(){
                    self.$parent.endConfirmarCapa()
                },500)

                this.sair();
                
            },
            sair(){                                
                this.$parent.mostrarGaleria = false;
            },
            proximo(){         
                if(this.pagina < this.last_page) {
                    this.images = [];
                    this.pagina++;      
                    this.search();
                }
                
            },    
            anterior(){          
                this.images = [];
                this.pagina--;      
                this.search();                  
            },    
            search(){
                var self                = this;
                let url                 = "";
                let query               = ""; //this.pesquisar;                
                let pagina              = `${this.pagina}`;                
                let clientIdUnsplash    = self.opt.clientIdUnsplash;                
                let collectionDefault   = self.opt.collectionDefault;                
                let perPageUnsplash     = self.opt.perPageUnsplash;
                let order_by            = 'latest';    


                let tipo=0;
                
                if (this.termoAtual != this.pesquisar){
                    pagina = 1;
                    this.pagina = pagina;
                } 
                //Definir o default e a pesquisa
                if(query) {
                    if (pagina>1)
                        url = `/api/midias/avatar/${query}?page=${pagina}`;
                    else
                        url = `/api/midias/avatar/${query}`;                      
                }
                else {
                     if (pagina>1)
                        url = `/api/midias/avatar/null?page=${pagina}`;                    
                    else
                        url = `/api/midias/avatar/null`;                      
                } 
                //url = `/api/lista/listar_midias/${collectionDefault}?page=1&per_page=${perPageUnsplash}&order_by=latest&client_id=${clientIdUnsplash}&page=${pagina}&query=${query}&per_page=${perPageUnsplash}&order_by=${order_by}`;                    
                axios.defaults.headers.common = [];    
                axios({
                    method: 'get',
                    url: url,
                    responseType: 'json'                    
                    })
                    .then(function (response) {                                               
                        self.last_page = response.data.last_page;
                        self.images = response.data.data;
                        self.termoAtual = self.pesquisar;
                    })
                    .catch(error => {
                        console.log("Erro na Requisição da biblioteca" );
                        self.images ="";
                });
                this.isLoading=false;
            },
            onInputChange(e){                                
                //Array.from(files).forEach(file => this.addImage(file));
            },
            
            getFileSize(size){
                const fSEXT = ['Bytes', 'KB', 'MB', 'GB'];
                let i = 0;
                while(size > 900){
                    size /= 1024;
                    i++;
                }
                return `${(Math.round(size * 100) / 100)} ${fSEXT[i]}`;
            },
            remove(index){                
                this.images.splice(index, 1);
                this.files.splice(index, 1);
            },                      
        },       
    }
</script>

<style lang="scss" scoped>
//    @import '../../sass/backend/uploaders.scss' ;     
</style>
