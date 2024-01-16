<template>    
    <div>
        <!-- INICIO -->
        <a href="#"
        class="icon icon-computador"
        @click.stop.prevent="abrir" 
        ></a>       
        <div 
            class="mostrar" 
            v-show="$parent.mostrarComputador" 
            v-if="$parent.escolhido!='galeria'"
            >
            <div class="modal-zone">
                <div class="wrapper">
                    <div class="uploader"
                        :class="{dragging: isDragging}">
                        <div>
                            <div class="header-content">                        
                                <h3 class="header-title">Imagem do computador</h3>
                                <a id="bt-sair" class="bt-sair-pesquisa bt-sair"><i class="ico ico-sair ico-exit"></i></a>                
                            </div>                                                     
                            <div class="container">                                
                                <div class="row">                                    
                                    <div class="col">                                        
                                        <h3 class="helper">Dimensões Permitidas:</h3>   
                                        <p>
                                            <span class="helper" v-text="'Tamanho máximo: ' + this.opt.textoTamanho"></span>
                                        </p>
                                        <p>
                                            <span class="helper" v-text="'Largura Máxima:  ' + this.opt.width + 'px'"></span>
                                        </p>  
                                        <p>
                                            <span class="helper" v-text="'Altura Máxima: ' + this.opt.height + 'px'"></span>
                                        </p>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="file-input">
                                            <span class="icon icon-computador"></span>    
                                            <span class="label">Procurar no Computador</span>
                                            <input ref="fileupload" type="file" name="file" id="file" @change="onInputChange" accept="image/*">                                            
                                        </div>
                                    </div>                                    
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>        
    </div>
</template>

<script>    
   /**
    * // import {uploaders} from  '../../sass/backend/uploaders.scss';
    * // import uploaders from  '../../sass/backend/uploaders.scss';
    * */
    

    export default {     
        props: ['opcoes'],   
        data () {
            return {
                isDragging: false,    
                isErroDimensoes:false,
                dragCount:0,  
                //imgSrc:null,
                opt:[],
                files: [],
                names: [],
                images: [],
                msgErros:''
            }
        },
        mounted() {              
            this.opt = JSON.parse(this.opcoes)   
            //this.imgSrc = this.$refs.ref_imgSrc.src;         
        },
        methods:{   
             abrir(){
                 let file = document.querySelector("#file");    
                 if (file.files.length){
                    this.clear()
                 }
                 this.$parent.mostrarComputador=true;
                 this.$parent.escolhido='computador';
             },
             clear(){
                 const input = this.$refs.fileupload;
                input.type = 'text';
                input.type = 'file';
             },                   
             onInputChange(e){                    
                const files = e.target.files;    
                this.msgErros =''                               
                Array.from(files).forEach(file => this.addImage(file));
                this.$parent.fazendoUpload=true;

            },
            addImage(file){
                var self = this;                
                if (file.type == "image/gif"){
                    this.$parent.validatorJS(this.$parent.titulo_atencao, `Não é permitido Upload de arquivos .gif ` , null)                    
                    return ;
                }
                if(!file.type.match('image.*')){
                    //aqui
                    this.$parent.validatorJS(this.$parent.titulo_atencao, `Formato de imagem é inválido` , null)                    
                    return ;
                }
                if((file.size/1024) > this.opt.tamanho ){                    
                    this.$parent.validatorJS(this.$parent.titulo_atencao, `O tamanho desta imagem é superior a ${this.opt.textoTamanho}` , null)                    
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
                            //aqui
                            self.$parent.validatorJS(self.$parent.titulo_atencao, ` Esta imagem é muito grande (Recomendado: no máximo ${self.opt.width} x ${self.opt.height}).` , null)
                            return ;
                        }
                        else{
                            valueToPush["width"]  = this.width;
                            valueToPush["height"] = this.height;                            
                            //new
                            self.$parent.startConfirmarCapa()
                            self.images.push(valueToPush);                              
                            self.$parent.setaAvatar(this.src);
                            self.$parent.mostrarComputador=false;
                            self.$parent.mostraCropZone=true
                            //new
                            setTimeout(function(){
                                self.$parent.endConfirmarCapa()
                            },800)
                            return false;
                        }                     
                    };
                }, false);                
                reader.readAsDataURL(file);
                //
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
                        if(element.sucesso==false){
                            //aqui
                            this.$parent.validatorJS(this.$parent.titulo_sucesso, `${element.titulo_msg} ${element.msg}`, null, 'sucesso')                            
                        }                            
                        else
                            //aqui                            
                            this.$parent.validatorJS(this.$parent.titulo_atencao, `${element.titulo_msg} ${element.msg}`, null)
                    });
                    this.images=[];
                    this.files =[];
                    this.names =[];
                })
            },
            sair(){                
                let self = this;
                this.$parent.mostrarComputador = false;    
            },            
        }
    }

</script>

<style lang="scss">
    // @import '../../sass/backend/uploaders.scss' ; 
</style>
