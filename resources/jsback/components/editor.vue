<template>    
    <div>        
        <div class="container">
            <div class="wrapper-editor">
                <div class="barra-botoes">
                    <ul>                                        
                        <li>
                            <a href="#Frase"
                            v-on:click.stop.prevent="fimLinha"
                            class=""
                            title="Marcar Linha"
                            >&&</a>
                        </li>

                        <li>
                            <a href="#Frase"
                            v-on:click.stop.prevent="autor"
                            class="icon icon-user"
                            title="Autor"
                            ></a>
                        </li>

                        <li>
                            <a href="#Frase"
                            v-on:click.stop.prevent="colar"
                            class="icon icon-007-copy"
                            title="Colar"
                            ></a>
                        </li>

                        <span class="divisor"></span>
                        
                        <li>
                            <a href="#Frase"
                            v-on:click.stop.prevent="anuncio('normal')"
                            class="icon icon-megaphone"
                            title="Anúncio Normal"
                            ></a>
                        </li>

                        <li>
                            <a href="#Frase"
                            v-on:click.stop.prevent="anuncio('left')"
                            class="icon icon-006-list"
                            title="Anúncio left"
                            ></a>
                        </li>

                        <li>
                            <a href="#Frase"
                            v-on:click.stop.prevent="anuncio('article')"
                            class="icon icon-files-o"
                            title="Anúncio In Article"
                            ></a>
                        </li>

                        <span class="divisor"></span>
                        
                        <li>
                            <a href="#Convite"
                            v-on:click.stop.prevent="convite"
                            class="icon icon-friendster"
                            title="Convidar usuários para cadastro"
                            ></a>
                        </li>

                        <span class="divisor"></span>

                        <li>
                            <a href="#Frase"
                            v-on:click.stop.prevent="bold"
                            class="icon-bold"
                            title="Negrito"
                            ></a>
                        </li>
                           <li>
                            <a href="#h"
                            v-on:click.stop.prevent="setH2"
                            class="icon-h2"
                            title="Selecionar texto antes, e aplique H2"
                            >H2</a>
                        </li>

                        <li>
                            <a href="#h"
                            v-on:click.stop.prevent="setH3"
                            class="icon-h3"
                            title="Selecionar texto antes, e aplique H3"
                            >H3</a>
                        </li>

                        <li>
                            <a href="#Frase"
                            v-on:click.stop.prevent="fimLinha"
                            class="icon icon-trash-o"
                            title="Limpar Formatação"
                            ></a>
                        </li>
                        <span class="divisor"></span>
                        <li>
                            <a href="#Frase"
                            v-on:click.stop.prevent="abre"
                            class="icon icon-009-camera"
                            title="Imagens"
                            ></a>
                        </li>

                    </ul>                    
                    <div class="mostraBotoes" v-show="mostraBotoes">                        
                        <button class="btn btn-dark"
                        @click.stop.prevent="lcomputador=true" 
                        v-show="!lcomputador" >computador
                        </button>
                        <div class="unsplash" v-show="lcomputador">
                            <div class="modal-zone">
                                <div class="wrapper">
                                    <ImageUploader :opcoes="this.opcoes"></ImageUploader> 
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-dark"
                        @click.stop.prevent="lunsplash=true" 
                        v-show="!lunsplash" >Unsplash</button>
                        <div class="unsplash" v-show="lunsplash">
                            <div class="modal-zone">
                                <div class="wrapper">
                                    <unsplash :opcoes="this.opcoes"></unsplash> 
                                </div>
                            </div>
                        </div>   

                        <button class="btn btn-dark"
                        @click.stop.prevent="lbiblioteca=true" 
                        v-show="!lbiblioteca" >Biblioteca</button>
                        <div class="biblioteca" v-show="lbiblioteca">
                            <div class="modal-zone">
                                <div class="wrapper">
                                    <biblioteca :opcoes="this.opcoes"></biblioteca>                                 
                                </div>
                            </div>
                        </div>

                    </div>
                    
                </div>
                                       
                <textarea    
                    ref="ref_corpo"                         
                    v-model="corpo"
                    id="corpo"
                    name="corpo"
                    style="width:100%"                  
                    class="fadeIn second"                                 
                    rows="20" 
                    >                    
                    </textarea>                
            </div>
        </div>   
    </div>     
</template>

<script>         
     import ImageUploader from  './imageUploader' 
     import unsplash from  './unsplash' ;
     import biblioteca from  './biblioteca' ;
     

    export default {     
        props: ['opcoes','vcorpo','iddopost'],  
        components:{            
            unsplash,
            biblioteca,
            ImageUploader,
        }, 
        data () {
            return { 
                corpo:"",  
                mostrar:false,
                mostraBotoes:false,
                lcomputador:false,
                lunsplash:false,
                lbiblioteca:false,
                
            }
        },
        mounted() {              
            this.opt = JSON.parse(this.opcoes);            
            this.$refs.ref_corpo.value= this.vcorpo;
            
        },
        watch:{
            pesquisar: function (novoValor, velhoValor) {
                if(velhoValor !="" && velhoValor != novoValor) {                    
                    this.pagina='1';
                }
            }
        },
        methods:{
            setaImagem(result){
                
                let tArea       = this.$refs.ref_corpo;
                let voldCorpo   = this.corpo;
                let startPos    = tArea.selectionStart;
                let endPos      = tArea.selectionEnd;
                let cursorPos   = startPos;
                let tmpStr      = tArea.value;
                let insert      = "<img>" + result + "</img>";
                this.corpo = tmpStr.substring(0, startPos) + insert + tmpStr.substring(endPos, tmpStr.length);
                // move cursor:
                setTimeout(() => {
                    cursorPos += insert.length;
                    tArea.selectionStart = tArea.selectionEnd = cursorPos;
                }, 10);

                this.mostraBotoes = !this.mostraBotoes;
            },
            abre(){
                this.corpo = this.$refs.ref_corpo.value;                
                this.mostraBotoes = !this.mostraBotoes;
            },
            bold(){
                let tArea       = this.$refs.ref_corpo;
                let voldCorpo   = this.corpo;
                let startPos    = tArea.selectionStart;
                let endPos      = tArea.selectionEnd;
                let cursorPos   = startPos;
                let tmpStr      = tArea.value;                
                let selecao     = tmpStr.substring(startPos, endPos);
                let tagHtml     = "<b>" + selecao + "</b>";   
                this.corpo      = tmpStr.replace(selecao, tagHtml);
            },
            setH2(){
                let tArea       = this.$refs.ref_corpo;
                let voldCorpo   = this.corpo;
                let startPos    = tArea.selectionStart;
                let endPos      = tArea.selectionEnd;
                let cursorPos   = startPos;
                let tmpStr      = tArea.value;                
                let selecao     = tmpStr.substring(startPos, endPos);
                let tagHtml     = "<h2>" + selecao + "</h2>";   
                this.corpo      = tmpStr.replace(selecao, tagHtml);
            },

            setH3(){
                let tArea       = this.$refs.ref_corpo;
                let voldCorpo   = this.corpo;
                let startPos    = tArea.selectionStart;
                let endPos      = tArea.selectionEnd;
                let cursorPos   = startPos;
                let tmpStr      = tArea.value;                
                let selecao     = tmpStr.substring(startPos, endPos);
                let tagHtml     = "<h3>" + selecao + "</h3>";   
                this.corpo      = tmpStr.replace(selecao, tagHtml);
            },

            caixa(){
                let tArea       = this.$refs.ref_corpo;
                let voldCorpo   = this.corpo;
                let startPos    = tArea.selectionStart;
                let endPos      = tArea.selectionEnd;
                let cursorPos   = startPos;
                let tmpStr      = tArea.value;                
                let selecao  = tmpStr.substring(startPos, endPos);
                let caixa    = "<caixa>" + selecao + "</caixa>";   
                this.corpo = tmpStr.replace(selecao, caixa);
            },
            autor(){
                let tArea       = this.$refs.ref_corpo;
                let voldCorpo   = this.corpo;
                let startPos    = tArea.selectionStart;
                let endPos      = tArea.selectionEnd;
                let cursorPos   = startPos;
                let tmpStr      = tArea.value;                
                let selecao     = tmpStr.substring(startPos, endPos);
                let caixa       = "<autor>" + selecao + "</autor>";   
                let temp        = tmpStr.substring(0, startPos) 
                                + caixa
                                + tmpStr.substring(endPos, tmpStr.length);
                this.corpo =temp;                
            },
            colar(){},
            fimLinha(){
                let tArea       = this.$refs.ref_corpo;
                let voldCorpo   = this.corpo;
                let startPos    = tArea.selectionStart;
                let endPos      = tArea.selectionEnd;
                let cursorPos   = startPos;
                let tmpStr      = tArea.value;
                let insert      ="&&";                
                this.corpo = tmpStr.substring(0, startPos) + insert + tmpStr.substring(endPos, tmpStr.length);
                // move cursor:
                setTimeout(() => {
                    cursorPos += insert.length;
                    tArea.selectionStart = tArea.selectionEnd = cursorPos;
                }, 10);
            },
            anuncio(tipo){
                let tArea       = this.$refs.ref_corpo;
                let voldCorpo   = this.corpo;
                let startPos    = tArea.selectionStart;
                let endPos      = tArea.selectionEnd;
                let cursorPos   = startPos;
                let tmpStr      = tArea.value;
                let insert      ="\n<anuncio>\n"+tipo+"@@\n</anuncio>&&\n";                
                this.corpo = tmpStr.substring(0, startPos) + insert + tmpStr.substring(endPos, tmpStr.length);
                // move cursor:
                setTimeout(() => {
                    cursorPos += insert.length;
                    tArea.selectionStart = tArea.selectionEnd = cursorPos;
                }, 10);
            },

            convite(){
                let tArea       = this.$refs.ref_corpo;
                let voldCorpo   = this.corpo;
                let startPos    = tArea.selectionStart;
                let endPos      = tArea.selectionEnd;
                let cursorPos   = startPos;
                let tmpStr      = tArea.value;
                let texto       = this.opt.convite ? this.opt.convite :'Ei Você sabia que neste site você pode fazer a sua própria lista de frases, salvar as suas frases favoritas em sua seleção e muito mais? <br><br>Que tal aproveitar que você já está por aqui, clicar <a target="_blank" rel="nofollow" href="https://listafrases.com/login/registrar/cadastro">neste link</a> e experimentar? <br><br> (Pedimos apenas seu email, um cadastro muito mais rápido que qualquer outro site :))';
                let insert      ="<convite>"+texto+"</convite>\n&&\n";                
                this.corpo = tmpStr.substring(0, startPos) + insert + tmpStr.substring(endPos, tmpStr.length);
                // move cursor:
                setTimeout(() => {
                    cursorPos += insert.length;
                    tArea.selectionStart = tArea.selectionEnd = cursorPos;
                }, 10);
            },

            ///////////////                            
        }
    }
</script>

<style lang="scss" scoped>
    .modal-zone {
        display: block;
        width: 100%;
        height: 100%;
        overflow: scroll;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 99999;
        transition: .3s cubic-bezier(.25,.8,.5,1);
        background: #0d0d0d52;

        .wrapper{
            background: #fff;
            padding:0;
            position: absolute;
            right: 0%;
            top: 0%;
            margin-left:0px;            
            max-width: 350px;            
            box-shadow: 0 11px 15px -7px rgba(0,0,0,.2), 0 24px 38px 3px rgba(0,0,0,.14), 0 9px 46px 8px rgba(0,0,0,.12);
            border-radius: 2px;
            overflow: scroll;
            pointer-events: auto;
            transition: .3s cubic-bezier(.25,.8,.25,1);
            width: 100%;
            z-index: inherit;
        }
        
    }

    i.fas.fa-cloud-upload-alt {
        font-size: 58px;
    }

    .file-input {
        width: 200px;
        margin: 0 auto;
        position: relative;
        height: 60px;
    }

    label, input {
        background: #fff;
        color: #007bff;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        padding:10px;
        margin: 10px auto;
        cursor: pointer;
    }
    input{
        opacity: 0;
        z-index: -2;
    }
    .image-preview {
        display: flex;
        flex-wrap: wrap;
        margin: 20px 0 ;            

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
    
    .barra-botoes {
        display: block;
        float: left;
        top:0;
        bottom:inherit;
        padding: 0px 5px;
        width: 100%;
        border: 1px solid #f2f6fc;
        border-radius: 4px;
        padding: 1px;
        display: flex;
        white-space: pre-line;
        -webkit-box-flex: 0;
        user-select: none;
        border-bottom: 1px solid #f2f6fc;
        border-radius: 4px 4px 0 0;
        background-color: #fff;
        z-index: 1;
        
       
        ul{
            list-style: none;
            padding: 0;
            display: contents;
            li > a{
                display: inline-block;
                /* text-indent: -9000px; */
                padding: 5px;
                float: left;
                margin: 10px 5px;
                min-width: 30px;
                font-size: 14px;
                color: rgba(0,0,0,0.8);
                background: #e9e9eb;
                height: 30px;
                border-radius: 5px;                  
            }
           
            .divisor{
                display: block;
                float: left;
                height: 30px;
                border-left: 1px solid #e5e5e5;
                margin: 10px 6px 0 4px;
            }   
        }
        .mostraBotoes{
            float: left;
            margin: 6px 6px 0px;
        } 
    }
    .wrapper-editor{
        height: 580px;
        width: 100%;
        display: block;
        position: relative;
        margin: 20px 0px 30px 0;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 2px 12px 0px;
    }
    textarea#corpo{
        font-size: 15px;
        line-height: 1.5;
        resize: none;
        outline: 0 none;
        border: 1px solid #f2f2f3;
        font-family: Menlo, "Ubuntu Mono", Consolas, "Courier New", "Microsoft Yahei", "Hiragino Sans GB", "WenQuanYi Micro Hei", sans-serif;
        position: absolute;
        width: 100%;
        height: calc(100% - 54px);
        top: 54px;
        left: 0;
        margin: 0;
        padding: 20px 20px 60px 20px;
        overflow-y: scroll;
        color: #2c3e50;
        box-sizing: border-box;
        /* box-sizing: border-box; */
        cursor: text;
        border-bottom: 1px solid #f2f2f3;
        border-bottom-left-radius: 4px;
        border-bottom-right-radius: 4px;
        /* box-shadow: rgba(0, 0, 0, 0.1) 0px 2px 12px 0px; */
    }    
</style>
