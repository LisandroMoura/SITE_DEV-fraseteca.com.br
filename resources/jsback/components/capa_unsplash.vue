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
                                <h3 class="header-title">Fotos do <a href="https://unsplash.com?utm_source=trello&amp;utm_medium=referral&amp;utm_campaign=api-credit" target="blank">Unsplash</a></h3>
                                <a id="bt-sair" class="bt-sair-pesquisa bt-sair"><i class="ico ico-sair ico-exit"></i></a>                
                            </div>
                            <!-- FIM corpo -->
                            <div class="erros" v-if="this.msgErros !=''">
                                {{msgErros}}
                            </div>
                            <div class="corpo">     
                                <div class="linha">     
                                    <div class="search-images">
                                        <form action="#">                                        
                                            <input
                                            type="text" 
                                            id="pesquisar" 
                                            v-model.lazy="pesquisar" 
                                            placeholder="digite um tema..."
                                            v-on:keyup.enter="search"                    
                                            >
                                            
                                            <input type="hidden" id="pagina" v-model.lazy="pagina">                                        
                                            <i class="icon-search"></i>
                                            <button 
                                                class="btn btn-sucess avatar-galeria"
                                                @click.stop.prevent="search">
                                                GO!
                                            </button>      
                                        </form>              
                                    </div>    

                                    <div class="carregando" v-show="this.isLoading">carregando...</div>    
                                    
                                    
                                </div>
                                <div class="void" v-show="l_void">
                                    <h4>OPS!!, não encontramos nada com esse termo no Unsplash</h4>
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
                                                :data="image.urls.thumb"
                                                @click.stop.prevent="confirmarCapa(image.urls.regular+'&fm=jpg'+'&id='+image.id,image.urls.thumb+'&fm=jpg'+'&id='+image.id)"
                                                v-bind:style="{ backgroundImage: 'url(' + image.urls.thumb + '&fm=jpg)' }" 
                                                >                               
                                                </span>

                                                <div class="autor-foto">
                                                    <a :href="image.user.links.html" target="blank">
                                                        <span class="name" v-text="image.user.name"></span>
                                                    </a>
                                                </div>
                                               
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
                pesquisar:'',
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
                msgErros:'',
                l_void:false,
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
             toDataURL(src, callback, outputFormat){
                let img = new Image()
                img.crossOrigin = 'Anonymous';
                img.onload = function() {
                    var canvas = document.createElement('CANVAS');
                    var ctx = canvas.getContext('2d');
                    var dataURL;
                    canvas.height = this.naturalHeight;
                    canvas.width = this.naturalWidth;
                    ctx.drawImage(this, 0, 0);
                    outputFormat= "image/jpeg";
                    dataURL = canvas.toDataURL(outputFormat);
                    callback(dataURL);
                };
                img.src = src;
                if (img.complete || img.complete === undefined) {
                    img.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
                    img.src = src;
                }
            },
            confirmarCapa(imgSrc,thumb){

                this.$parent.mostraCropZone=true

                this.$parent.unsplashIdFotoAtual = imgSrc
                let self = this                  
                self.toDataURL(imgSrc,
                    function(dataUrl) {
                        self.PosConfirmarCapa(dataUrl,'')
                    }
                )
             },
             PosConfirmarCapa(imgSrc,thumb){                  
                this.$parent.startConfirmarCapa()                
                let self = this                  
                this.$parent.setaAvatar(imgSrc)
                //this.$parent.setaThumb(thumb)
                //new
                setTimeout(function(){
                    self.$parent.endConfirmarCapa()                    
                },2000)                
                this.sair()
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
             traduzir(){
                this.l_void=false;
                this.isLoading=true;
                this.images = [];
                var self  = this;
                let keyYandex = self.opt.keyYandex;
                let query = this.pesquisar;
                let url = `https://translate.yandex.net/api/v1.5/tr.json/translate?key=${keyYandex}&text=${query}&lang=pt-en`; 
                if(query){
                    axios.defaults.headers.common = [];                                        
                    axios.get(url,{
                        headers: {                            
                        },
                    })                    
                    .then(response => {
                        if(response.data.text[0] ){
                            self.pesquisar = response.data.text[0];                                                        
                            self.search();
                        }
                        else{
                            self.log= "não foi possível traduzir.";
                        }                        
                    })
                    .catch(error => {                        
                        self.images ="";
                    })
                }
                else{                    
                    //self.search();
                }                
            },   
            search(){
                var self                = this;
                let url                 = "";
                let query               = this.pesquisar;                
                let pagina              = `${this.pagina}`;                
                let clientIdUnsplash    = self.opt.clientIdUnsplash;                
                let collectionDefault   = self.opt.collectionDefault;                
                let perPageUnsplash     = self.opt.perPageUnsplash;
                let order_by            = 'latest';      
                
                if (this.termoAtual != this.pesquisar){
                    pagina = 1;
                    this.pagina = pagina;
                }                   
                if(query)                    
                    url = `https://api.unsplash.com/search/?client_id=${clientIdUnsplash}&page=${pagina}&query=${query}&per_page=${perPageUnsplash}&order_by=${order_by}&fm=jpeg`;                    
                else 
                    url = `https://api.unsplash.com/${collectionDefault}?page=1&per_page=${perPageUnsplash}&order_by=latest&client_id=${clientIdUnsplash}&page=${pagina}&query=${query}&per_page=${perPageUnsplash}&order_by=${order_by}&fm=jpeg`;
           
                axios.defaults.headers.common = [];
                axios({
                    method: 'get',
                    url: url,
                    responseType: 'json'                    
                    })
                    .then(function (response) {
                        if(query){                                 
                            self.images = response.data.photos.results;
                            self.last_page = response.data.photos.total_pages;
                            //add                            
                            if (response.data.photos.total =="0")
                                self.l_void=true
                        }else{                            
                            self.last_page = 50;
                            //add
                            let count_reg=0;
                            response.data.forEach(element => {                                  
                                self.images.push(element);
                                //add
                                count_reg++
                            });
                            //add
                            if (count_reg==0)
                                self.l_void=true
                        }

                        self.termoAtual = self.pesquisar;
                    })
                    .catch(error => {
                        console.log("Deu erro no Unsplash" );
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
