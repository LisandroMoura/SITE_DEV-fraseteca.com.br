<template>    
    <div>        
        <button type="submit" title="Buscar Frase" class=""
        @click.stop.prevent="abrir" 
        ><i class="icon-search"></i> <span>Buscar Frase</span>
        </button>
        <div class="mostrar" v-show="this.mostrarFrasesFavoritas" >

            <div class="modal-zone-withe"> 
                <div class="header-content">                        
                    <h3 class="header-title">Encontre a sua frase:</h3>                            
                    <a class="bt-sair-pesquisa" href="#" @click.stop.prevent="sair" title="Fechar esta opção.">                                
                        <i class="ico ico-sair ico-exit"></i>
                    </a> 

                    <div class="search-frasesFavoritas">   
                        <div class="wrapper-pesquisa">
                            <input  
                            type="text" 
                            id="pesquisar" 
                            v-model.lazy="pesquisar" 
                            placeholder="pesquisar..."
                            v-on:keyup.enter="search"                     
                            >                                    
                            <input type="hidden" id="pagina" v-model.lazy="pagina">                                
                            <button 
                                class="btn bt-search"
                                @click.stop.prevent="search">
                                <i class="icon-search"></i>                                    
                            </button>                    
                        </div>                             

                    </div>               
                </div>               
                <div class="wrapper">
                    <div class="area-frasesFavoritas">  
                        
                        <div class="corpo">     
                            <div class="linha"> 
                                <div class="carregando" v-show="this.isLoading">carregando...</div>                                    
                            </div>

                            <div class="linha dados-preview"  v-show="this.estaVazio">
                                <ul>
                                    <li> 
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <span>Sua lista de frases favoritas está vazia! Que tal navegar pelo site e curtir algumas frases?</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="linha dados-preview" v-show="frasesFavoritas.length">                        
                                <ul>                             
                                    

                                    <li v-for="(frase, index) in frasesFavoritas"
                                        :key="index"
                                        @click.stop.prevent="confirmaFrase(frase.frase, frase.autor, frase.id,index)"
                                        >                                        
                                        <div class="row">
                                            <div class="col-lg-1">                                            
                                                <div class="icone">
                                                    <span class="icon-quote-right">                                                
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-10">
                                                <div class="item">
                                                    <span class="frases-box" 
                                                        :data="frase.frase"                                                        
                                                        v-text="frase.frase"
                                                    >                               
                                                    </span>                                
                                                </div>
                                                <div class="autor">
                                                    <span class="frases-box" 
                                                        :data="frase.autor"                                                        
                                                        v-text="frase.autor"
                                                    >                               
                                                    </span>
                                                </div>                                            
                                            </div>
                                            <div class="col-lg-1">                                            
                                                <div class="icone">
                                                    <span class="icon-star">                                                
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="navega">
                                        <a class="bt-navega anterior"  href="#"
                                        @click.stop.prevent="anterior"
                                        v-show="this.pagina>1"
                                        >
                                        Anterior                                       
                                        </a>                        
                                        <a class="bt-navega proximo"  href="#"
                                        @click.stop.prevent="proximo"
                                        v-show="this.pagina < this.last_page"
                                        >
                                        Próximo                                       
                                        </a>   
                                    </li>                                    
                                </ul>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</template>
<script>
//como incorporar codigo
// import { constants } from 'crypto';    
    export default {     
        props: ['opcoes'],   
        data () {
            return {          
                mostrarFrasesFavoritas:false,      
                log:"",                  
                pesquisar:'',
                termoAtual:'',
                pagina:'1',
                last_page:'',
                isLoading:false,
                opt:[],                                
                frasesFavoritas: [],                
                pai:"", 
                estaVazio:false,                    
            }
        },
        mounted() {
            this.pai = this.$parent;
            this.opt = JSON.parse(this.opcoes) 
            this.search();  
        },       
        methods:{            
            confirmaFrase(frase, autor, idDaFrase,indexFraseFavorita){
                console.log("idDaFrase:",idDaFrase)
                this.pai.setaFrase(frase, autor,idDaFrase,this.$attrs.indexdafrase);                  
                this.remove(indexFraseFavorita);
                this.sair();
            },
            abrir(){                
                this.verSejaEstaNaLista();
                this.mostrarFrasesFavoritas=true;
                 
             }, 
            sair(){                
                this.mostrarFrasesFavoritas = false;
            },
            proximo(){          
                if(this.pagina < this.last_page) {
                    this.frasesFavoritas = [];
                    this.pagina++;      
                    this.search();
                }                
            },    
            anterior(){          
                this.frasesFavoritas = [];
                this.pagina--;      
                this.search();                  
            },    
           
            search(){
                var self                = this;
                let url                 = "";
                let query               = this.pesquisar;                
                let pagina              = `${this.pagina}`;         
 
                if (this.termoAtual != this.pesquisar){
                    pagina = 1;
                    this.pagina = pagina;
                }
                if(query) {
                    if (pagina>1)
                        url = `/api/lista/listar_get_frases/${query}?page=${pagina}`;
                    else
                        url = `/api/lista/listar_get_frases/${query}`;                      
                }
                else {
                     if (pagina>1)
                        url = `/api/lista/listar_get_frases/null?page=${pagina}`;                    
                    else
                        url = `/api/lista/listar_get_frases/null`;                      
                } 

                axios.defaults.headers.common = [];    
                axios({
                    method: 'get',
                    url: url,
                    responseType: 'json'                    
                    })
                    .then(function (response) {        
                        self.last_page = response.data.last_page;
                        self.frasesFavoritas = response.data.data;                        
                        self.verSejaEstaNaLista();                 
                        self.termoAtual = self.pesquisar;
                    })
                    .catch(error => {
                        console.log("Erro na Requisição das FrasesFavoritas" );
                        self.frasesFavoritas ="";
                });                
                this.isLoading=false;
            },  
            verSejaEstaNaLista(){
                self = this;
                this.pai.frases.forEach(element => {                                    
                    if (element.id!=''){
                        let index =-1;

                        if (self.frasesFavoritas.length){                            
                            index = self.frasesFavoritas.findIndex(favor => favor.id === element.frase_id);
                        }
                        if (index > -1){                                                        
                            this.remove(index);
                        }
                    } 
                    
                    if (!self.frasesFavoritas.length)
                        self.estaVazio = true;
                        
                });
                

            },         
            remove(index){                
                this.frasesFavoritas.splice(index, 1);                
            },          
                    
        }
    }
</script>
<style lang="scss" scoped>
    .modal-zone-withe{
        display: block;
        width: 100%;
        height: 100%;
        overflow: scroll;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 99999;
        transition: 0.3s cubic-bezier(0.25, 0.8, 0.5, 1);
        background:#0d0d0d52;
        
        .header-content{
            width: 100%;
            background: #f4f5f7;
            padding: 0;
            margin-bottom: 30px;
            max-width: 950px;
            margin: 0 auto;
            position: relative;
            h3.header-title{
                text-align: left;                        
                padding-left: 20px;                    
            }
            .search-frasesFavoritas{
                position: absolute;
                top: 0px;
                height: 50px;
                width: 320px;
                left: 50%;
                margin-left: -160px;
                .wrapper-pesquisa{
                    width: 320px;
                    display: block;
                    padding: 0;                        
                    margin: 0 auto;
                    height: 50px;
                    input#pesquisar{
                        height: 50px;
                        width: 270px;
                        float: left;
                        margin: 0;
                        border-radius: 0;
                    }
                    button.btn.bt-search{
                        float: left;
                        width: 50px;
                        height: 50px;
                        background: #e52134;
                        color: #fff;
                    }
                }
            }
        }
        .wrapper{
            background: #fff;
            padding: 0;
            position: absolute;
            left: 50%;
            top: 50px;
            margin-left: -475px;
            max-width: 950px;
            box-shadow: 0 11px 15px -7px rgba(0, 0, 0, 0.2), 0 24px 38px 3px rgba(0, 0, 0, 0.14), 0 9px 46px 8px rgba(0, 0, 0, 0.12);
            border-radius: 2px;
            overflow: scroll;
            pointer-events: auto;
            transition: 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            width: 100%;
            z-index: inherit;
            display: flex;
            align-items: center;
            flex-direction: column;
            height: 80%;   
            .corpo{
                padding: 0px 0px 10px 0px;
                .linha{                       
                    &.dados-preview{
                        ul{
                            padding: 0;
                            list-style: none;
                            li{
                                display: inline-block;
                                width: 100%;
                                margin: 0;
                                padding: 10px 20px 20px 20px;
                                cursor: pointer;
                                border-bottom: 1px solid #f3f3f3;
                                &.navega{
                                    text-align: center;
                                    a{
                                        padding: 20px;
                                    }
                                }

                                &:hover{
                                    background: #c1c1c133;                                        
                                }

                                .row{
                                    .col-lg-1{
                                        text-align: center;
                                        .icone{
                                            span{
                                                font-size: 18px;
                                                line-height: 50px;
                                                &.icon-star{
                                                    color: #ccc;                                                                                                           
                                                }
                                            }
                                        }

                                    }
                                    .col-lg-10{

                                    }
                                }
                                .item{
                                    display: block;                                        
                                    float: left;                                        
                                    width: 100%;                                        

                                }
                                .autor{
                                    display: block;                                        
                                    float: left;                                        
                                    width: 100%;
                                    font-weight: 700;
                                }
                            }
                        }
                    }
                }
            }        
        }
    }


    //mobile
    @media (max-width: 768px) {           
        .modal-zone-withe .wrapper{            
            margin-left: -330px;
            max-width: 660px;
        }



    }

    @media (max-width: 640px) {

        .modal-zone-withe .wrapper{            
            left: 2%;
            margin-left: 1%;
            max-width: 94%;
        }
        .modal-zone-withe .header-content .search-frasesFavoritas{
            left: 0%;
            margin-left: 3%;
        }
   
    }
    /*Mobiles pequenos*/
    @media (max-width: 440px) {

        .modal-zone-withe .wrapper .area-frasesFavoritas .header-content h3.header-title{
            text-indent: -9000px
        }      
        
        .modal-zone-withe .wrapper .area-frasesFavoritas .header-content .search-frasesFavoritas{
            right: unset;
            left: 10px;
            width: 80%;
        }
        .modal-zone-withe .wrapper .area-frasesFavoritas .header-content .search-frasesFavoritas .wrapper-pesquisa input#pesquisar{
            width: 100%;
        }
    }
    
   
</style>
