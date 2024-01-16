<template>    
    <div class="w100">
        <div class="area-unsplash">

            <div class="erros" v-if="this.msgErros !=''">
                {{msgErros}}
            </div>
            <div class="header-content">                        
                <h3 class="header-title">Fotos do <a href="https://unsplash.com?utm_source=trello&amp;utm_medium=referral&amp;utm_campaign=api-credit" target="blank">Unsplash</a></h3>
                <a class="bt-sair-pesquisa" href="#" @click.stop.prevent="sair" title="Fechar esta opção.">
                    <i class="ico ico-sair ico-exit"></i>
                </a>                
            </div>

            <div class="row-header">
                <div class="col-header">                    
                    <label for="">Pesquisar por:</label>
                    <input type="input" ref="unsplashIdFotoAtual" name="unsplashIdFotoAtual" id="unsplashIdFotoAtual" :value="this.unsplashIdFotoAtual" >
                    <button 
                        class="btn btn-sucess byId"
                        @click.stop.prevent="searchById">
                       <i class="icon icone icon-search"></i>
                    </button>
                </div>
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
                            <i class="fas fa-search"></i>
                            <button 
                                class="btn btn-sucess"
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
                        <li v-for="(image, index) in images"
                            :key="index">

                            <div class="item" v-if="image.data">                                
                                
                                <span class="background-box" 
                                    :data="image.data.thumb"
                                    @click.stop.prevent="confirmarCapa(image.data.regular+'&fm=jpg'+'&id='+image.id,image.data.small+'&fm=jpg'+'&id='+image.id)"
                                    v-bind:style="{ backgroundImage: 'url(' + image.data.thumb + '&fm=jpg)' }" 
                                >                               
                                </span>                               
                            </div>    
                            <div class="item" v-else>                                
                                <span class="background-box" 
                                    :data="image.urls.thumb"
                                    @click.stop.prevent="confirmarCapa(image.urls.regular+'&fm=jpg'+'&id='+image.id,image.urls.small+'&fm=jpg'+'&id='+image.id)"
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
        </div>
    </div> 
</template>
<script>
//como incorporar codigo
//import { constants } from 'crypto';    
    export default {     
        props: ['opcoes'],   
        data () {
            return {                
                log:"",                  
                pesquisar:'',
                termoAtual:'',
                pagina:'1',
                last_page:'',
                isLoading:false,
                opt:[],                
                names: [],
                images: [],                
                images_clone: [],
                msgErros:'',
                l_void:false,
                unsplashIdFotoAtual:''
            }
        },
        mounted() {
            var capa = this.$parent;
            if (capa.$vnode.componentOptions.tag != 'capa' && capa.$vnode.componentOptions.tag != 'thumb' )
                this.editor = this.$parent;
            
            this.unsplashIdFotoAtual = this.$parent.$parent.$refs.ref_unsplashIdFotoAtual ? this.$parent.$parent.$refs.ref_unsplashIdFotoAtual.value : null;    

            this.opt = JSON.parse(this.opcoes)
            if(capa.$vnode.componentOptions.tag == 'thumb')            
                this.unsplashIdFotoAtual = this.$parent.$parent.$refs.ref_unsplashIdFotoAtualThumb ? this.$parent.$parent.$refs.ref_unsplashIdFotoAtualThumb.value : null
            this.search();
        },       
        methods:{
            confirmarCapa(imgSrc, thumb){
                var capa = this.$parent;                
                // imgSrc = imgSrc.replace("fm=jpg","fm=webp")                    
                // thumb  = thumb.replace("fm=jpg","fm=webp")                    
                if (capa.$vnode.componentOptions.tag == 'capa'){                    
                    capa.$parent.setaCapa(imgSrc);
                    //capa.$parent.setaThumb(thumb);
                    capa.$parent.mostraCropZone=true
                    //new
                    setTimeout(function(){
                        capa.$parent.endConfirmarCapa();                        
                    },800)

                    this.sair()
                }
                else if (capa.$vnode.componentOptions.tag == 'thumb'){                                        
                    capa.$parent.setaThumb(thumb); 
                    capa.sair();
                }                
                else {
                    capa.setaImagem(imgSrc);
                    this.sair()
                }                
            },
            sair(){                
                var capa = this.$parent;
                if (capa.$vnode.componentOptions.tag == 'capa'){
                    capa.$parent.lunsplash = false;
                }
                else
                if (capa.$vnode.componentOptions.tag == 'editor')
                {
                    this.$parent.lunsplash = false;
                }else
                {
                    capa.sair();
                }               
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
                    self.search();
                }                
            },
            searchById(){
                var self                = this;

                let id = this.$refs.unsplashIdFotoAtual.value

                id = id.replace("https://unsplash.com/photos/","");

                let url                 = "";                
                let clientIdUnsplash    = self.opt.clientIdUnsplash;   
                let dados = {}
                url = `https://api.unsplash.com/photos/${id}/?client_id=${clientIdUnsplash}&fm=jpg`;                    
                axios.defaults.headers.common = [];    
                axios({
                    method: 'get',
                    url: url,
                    responseType: 'json'                    
                    })
                    .then(function (response) {
                        self.images = []
                        dados = {
                            'data': response.data.urls,
                            'id': response.data.id
                        }
                        //console.log(response.data.id)
                        self.images.push(dados);
                    })
                    .catch(error => {
                        console.log("Deu erro no Unsplash" );                        
                });
                this.isLoading=false;
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
                    url = `https://api.unsplash.com/search/?client_id=${clientIdUnsplash}&page=${pagina}&query=${query}&per_page=${perPageUnsplash}&order_by=${order_by}&fm=jpg`;                    
                else 
                    url = `https://api.unsplash.com/${collectionDefault}?page=1&per_page=${perPageUnsplash}&order_by=latest&client_id=${clientIdUnsplash}&page=${pagina}&query=${query}&per_page=${perPageUnsplash}&order_by=${order_by}&fm=jpg`;                    
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
            addImage(file){
                var self = this;
                
                if(!file.type.match('image.*')){
                    this.$toastr.e(`${file.name} não é uma imagem válida`);
                    this.msgErros = `${file.name} não é uma imagem válida`;
                    return ;
                }
                if((file.size/1024) > this.opt.tamanho ){
                    this.$toastr.e(`Arquivo, ${file.name}. Tamanho do arquivo é superior a ${this.opt.textoTamanho}`);
                    this.msgErros = `Arquivo, ${file.name}. Tamanho do arquivo é superior a ${this.opt.textoTamanho}`
                    return ;                    
                }
                //push no files
                this.files.push(file);
                this.names.push(file.name);
                const reader = new FileReader();
                //definindo o listner do evento onload (ao carregar)
                //push em images
                //reader.onload = (event)=> this.images.push(event.target.result, file.name);                
                reader.addEventListener("load", function () {                 
                    let valueToPush ={}; 
                    let temErros=false;
                    var resultado = this.result;
                    valueToPush["result"]   = this.result;
                    valueToPush["name"]     = file.name;
                    valueToPush["size"]     = file.size;

                    var image  = new Image();       
                    image.src = this.result;             
                    image.onload = function (resultado) {                        
                        var width  = this.width;
                        var height = this.height;
                        if (height > self.opt.height || width > self.opt.width){                            
                            self.$toastr.e(`${file.name} - Tamanho: ${this.width} x ${this.height} | uns Largura ou altura inválida.`);
                            self.msgErros = `${file.name} - Tamanho: ${this.width} x ${this.height} | Largura ou altura inválida.`
                            return true;
                        }
                        else{
                            valueToPush["width"]  = this.width;
                            valueToPush["height"] = this.height;
                            self.images.push(valueToPush);                              
                            self.$parent.setaCapa(this.src);
                            self.$parent.mostrar=false; 
                            
                            self.$parent.$parent.mostraCropZone=true
                            //new

                            setTimeout(function(){
                                self.$parent.$parent.endConfirmarCapa();
                               
                            },800)

                            return false;
                        }                     
                    };
                }, false);
                //carregar...
                reader.readAsDataURL(file);
                
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
                //this.$toastr.s(`Imagem ${index+1}, removida com sucesso!  `);
                this.images.splice(index, 1);
                this.files.splice(index, 1);
            },          
            upload(e){
                e.preventDefault();
                e.stopPropagation();                
                const formData = new FormData();
                this.files.forEach(file => {
                    formData.append('images[]',file, file.name );
                });
                axios.post('/admin/gestao/midias/upload',formData)
                .then(respo => {
                    respo.data.forEach(element => {
                        if(element.sucesso==false)
                            {
                                this.$toastr.e(`${element.titulo_msg} ${element.msg}`);
                                this.msgErros = `${element.titulo_msg} ${element.msg}`
                            }
                        else
                            this.$toastr.s(`${element.titulo_msg} ${element.msg}`);
                    });
                    this.images=[];
                    this.files =[];
                    this.names =[];
                })
            },            
        }
    }
</script>
<style lang="scss" scoped>
    .unsplash {
        width: 100%;
        background: #dadada;
        color: #000;
        text-align: center;
        padding: 40px 15px;
        border-radius: 10px;
        border: 2px dashed #fff;
        font-size: 20px;
        position: relative;       
    }
   
   .corpo{
       padding: 12px;
   }
   .row-header{
        display: block;
        width: 100%;
        margin: 0 auto;
        padding: 0 15px;
        .col-header{
            display: block;
            margin: 15px 0 ;
            label{
                float: left;
                margin: 4px 0 0 0;
            }
            input#unsplashIdFotoAtual{
                float: left;
                width: 130px;
                margin: 2px 0 0 5px;
            }
            button{
                margin: 0 0 0 6px;
                padding: 4px;
                float: left;
                i.icon{
                    font-size: 15px;
                    margin: 0;
                }   
            }
        }
   }
   .header-content{
        width: 100%;
        background: #f4f5f7;
        position: relative;
   }

   h3.header-title {
        width: 100%;
        text-align: center;
        font-size: 16px;
        line-height: 50px;
        color:#172b4d;
        font-weight: 600;
        a{
            color:#172b4d;
        }
    }
    .bt-sair{
        font-size: 20px;
        position: absolute;
        top: 10px;
        right: 15px;
        color: #42526e;
    }
    .search-images{
        position: relative;
        display: block;
        width: 100%;
        margin: 10px auto;
        #pesquisar{
            background: #fff;
            box-shadow: inset 0 0 0 2px #dfe1e6;
            width: 100%;
            padding-left: 36px;
            font-size: 16px;
            text-align: left;
        }
        button{
            display: none;
            &.byId{
                display: block;
            }

        }
        i.fas.fa-search {
            position: absolute;
            top: 27px;
            left: 20px;
        }
    }
    

    .image-preview {
        display: flex;
        flex-wrap: wrap;
        margin: 20px 0 ;            
        ul{
            padding: 0;
            li{
                display: inline-block;
                float: left;
                width: 140px;
                height:98px;
                margin: 5px;
                padding: 0px;                
                &.navega{
                    display: table
                }

                .item{
                    display: block;
                    width: 100%;
                    height: 100%;
                    position: relative;
                    overflow: hidden;
                    img{
                        max-width: 100%;
                        min-height: 100%;
                    }
                    .background-box{
                        background-color: #dfe1e6;
                        background-size: cover;
                        border-radius: 8px;
                        display: block;
                        height: 100%;
                        overflow: hidden;
                        position: relative;
                        width: 100%;
                        cursor: pointer;
                    }
                    .autor-foto{
                        position: absolute;
                        bottom: 0;
                        left:0;                        
                        font-size: 14px;
                        width: 100%;
                        padding: 2px;
                        text-align: center;                     
                        &:hover{
                            background: #00000078;
                            a{                            
                            color:#fff;
                            }
                            
                        }
                    }

                }
                a.bt-navega{
                    background: #ccc;
                    color: #000;
                    display: table-cell;
                    height: 100%;
                    text-align: center;
                    vertical-align: middle;
                }                
            }
        }        
        .image-wrapper {
            position: relative;
            display: flex;
            width: 160px;
            height: 160px;    
            flex-direction: column;
            margin: 10px;
            justify-content: space-between;
            background: #fff;
            box-shadow: 5px 5px 20px black;
            overflow: hidden;

            img {
                max-width: 160px;

            }            
            .detalhes {
                position: absolute;
                width: 100%;
                font-size: 12px;
                background: #545a61;
                color: #f8f9fa;
                display: flex;
                flex-direction: column;
                align-items: self-start;
                padding: 6px;
                bottom: 0px;
                border: 1px dashed #989696;
                .name {
                    overflow: hidden;
                }                
            }
            .lixeira{
                position: absolute;
                display: block;
                right: 6px;                
                bottom: 10px;
                width: 20px;
                height: 20px;
                cursor: pointer;
                i.far.fa-trash-alt{
                    font-size: 14px;

                }
            }
        }
    }
    

    .upload-control {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        background: #fff; 
        text-align: right;
        border-top-left-radius: 7px;
        border-top-right-radius: 7px;
        padding: 10px;
        padding-bottom: 4px;
        button, label{
            background: #007bff;
            border: 2px solid #87bdf7;
            border-radius: 7px;
            color: #fff;
            position: relative;
            width: auto;
            font-size: 16px;
            padding: 5px 10px;                
            margin: 5px 0;
            cursor: pointer;
        }
        label{
            position: relative;
            margin-right: 5px;
        }

    }
    
    
</style>
