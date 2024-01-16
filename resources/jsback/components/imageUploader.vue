<template>    
    <div class="uploader midias"
        @dragenter="OnDragEnter"
        @dragleave="OnDragLeave"
        @dragover.prevent
        @drop="OnDrop"
        :class="{dragging: isDragging}" >
        <div class="header-content">                        
            <h3 class="header-title">Imagem do seu Computador</a></h3>

            <a class="bt-sair-pesquisa" href="#" @click.stop.prevent="sair" title="Fechar esta opção.">
                <i class="fa fa-times"></i>
            </a>                
        </div>
        <div class="corpo">     
            <div class="linha">
                <div class="erros" v-if="this.msgErros !=''">
                    {{msgErros}}
                </div>
                
                <div v-show="!images.length">
                    <i class="fas fa-cloud-upload-alt"></i>    
                    <div >
                        <span class="helper" v-text="'Tamanho máximo do arquivo: ' + this.opt.textoTamanho"></span>
                    </div> 
                    <div >
                        <p>Dimensões Permitidas:</p>   
                        <p>
                            <span class="helper" v-text="'Largura Máxima,' + this.opt.width + 'px'"></span>
                        </p>  

                        <p>
                            <span class="helper" v-text="'Altura Máxima,' + this.opt.height + 'px'"></span>
                        </p>  
                        
                    </div> 

                    <div  v-if="this.opt.tipo === 'multiple'" >Arraste sua imagem aqui</div>
                    <div  v-if="this.opt.tipo === 'multiple'">ou</div>

                                        
                    <div class="file-input">
                        <span class="icon icon-computador"></span>    
                        <span class="label">Procurar no Computador Up</span>
                        <div v-if="this.opt.tipo === 'multiple'">
                            <input  ref="fileupload" type="file" name="file" id="file" value="" @change="onInputChange" multiple accept="image/*">
                        </div>                                                        
                        <div v-else>
                            <input ref="fileupload" type="file" name="file" id="file" value="" @change="onInputChange" accept="image/*">
                        </div>                
                    </div>
                </div>
                
                <div class="image-preview" v-show="images.length">
                    <div class="image-wrapper" 
                        v-for="(image, index) in images" 
                        :key="index">
                        <img :src="image.result" :alt="`id Upload ${index}`">
                        <div class="detalhes">
                            <span class="name" v-text="image.name"></span>
                            <!-- <span class="size" v-text="`${parseInt(files[index].size / 1024)} KB`"></span> -->
                            <span class="size" v-text="getFileSize(image.size)"></span>                    
                            <span class="size" v-text="image.width + 'px X ' + image.height + 'px'"></span>  
                        </div>
                        <div class="lixeira"
                            @click="remove(index)">
                            <i class="far fa-trash-alt icon-trash"></i>
                        </div>
                    </div>
                </div>
                <div class="content-wrapper" v-show="images.length">
                        <section class="field">
                            <div class="row">
                                <div class="col-lg-12 label-area ">
                                    <label for="">
                                        Selecione o tipo de imagem
                                    </label>
                                </div>
                                <div class=" col-lg-12 ">
                                    <div class="form-check-inline">
                                        <input type="radio" v-model="tipo" name="tipo" id="1" value="1" checked="checked" class="form-check-input">
                                        <span class="form-check-label ">Imagens do Sistema</span>
                                    </div>                                    
                                    <div class="form-check-inline">
                                        <input type="radio" v-model="tipo" name="tipo" id="2" value="2" false="" class="form-check-input">
                                        <span class="form-check-label ">Capa de usuários</span>
                                    </div>
                                    <div class="form-check-inline">
                                        <input type="radio" v-model="tipo" name="tipo" id="3" value="3" false="" class="form-check-input">
                                        <span class="form-check-label ">Conquistas</span>
                                    </div>
                                    <div class="form-check-inline">
                                        <input type="radio" v-model="tipo" name="tipo" id="4" value="4" false="" class="form-check-input">
                                        <span class="form-check-label ">Avatar de usuários</span>
                                    </div> 
                                    <div class="form-check-inline">
                                        <input type="radio" v-model="tipo" name="tipo" id="5" value="5" false="" class="form-check-input">
                                        <span class="form-check-label ">Avatar do sistema</span>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div> 
                <div class="upload-control" v-show="images.length">
                    <label class="btn" for="file">Selecionar outro?</label>
                    <button class="btn callAction" @click="upload">
                        <i class="icon-enviar icon enviar"></i>
                        <span>Upload</span>
                    </button>
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
                opt:[],
                files: [],
                names: [],
                images: [],
                msgErros:'',
                tipo:"1",                
                pai:[]
            }
        },
        mounted() {              
            this.opt = JSON.parse(this.opcoes);
            this.pai = this.$parent               
        },
        methods:{        
            OnDragEnter(e){    
                if(this.opt.tipo != 'multiple') return;
                e.preventDefault();
                this.dragCount++;
                this.isDragging=true;                
            },
            OnDragLeave(e){
                if(this.opt.tipo != 'multiple') return;
                e.preventDefault();
                this.dragCount--;                
                if(this.dragCount <=0)   
                    this.isDragging=false;
            },           
            OnDrop(e){
                if(this.opt.tipo != 'multiple') return;
                e.preventDefault();
                e.stopPropagation();
                this.isDragging=false;
                const files = e.dataTransfer.files;                
                Array.from(files).forEach(file => this.addImage(file));                
            },            
             onInputChange(e){                   
                const files = e.target.files;                                   
                this.msgErros =''
                Array.from(files).forEach(file => this.addImage(file));                 
            },
            addImage(file){                     
                var self = this;
                var pai  = this.$parent
                
                if(!file.type.match('image.*')){
                    //aqui
                    pai.$parent.validatorJS(pai.$parent.titulo_atencao, `${file.name} não é uma imagem válida` , null)                    
                    return false;
                }
                if((file.size/1024) > this.opt.tamanho ){
                    //aqui
                    pai.$parent.validatorJS(pai.$parent.titulo_atencao, `Arquivo, ${file.name}. Tamanho do arquivo é superior  ${this.opt.textoTamanho}` , null)                                        
                    return false;                    
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
                    valueToPush["result"]   = this.result;
                    valueToPush["name"]     = file.name;
                    valueToPush["size"]     = file.size;

                    var image  = new Image();       
                    image.src = this.result;             
                    image.onload = function () {  
                        //carregar o sistema ofiginal de mensagens de erro
                        var width  = this.width;
                        var height = this.height;                        
                        if (height > self.opt.height || width > self.opt.width){                            
                            pai.$parent.validatorJS(pai.$parent.titulo_atencao, ` Esta imagem é muito grande (Recomendado: no máximo ${self.opt.width} x ${self.opt.height}).` , null)
                            return false;                            
                        }
                        else{
                            valueToPush["width"]  = this.width;
                            valueToPush["height"] = this.height;
                            self.images.push(valueToPush);                                                        
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
                this.images.splice(index, 1);
                this.files.splice(index, 1);
            },
            sair(){                
                this.$parent.lcomputador = false;                
            },
            upload(e){
                e.preventDefault();
                e.stopPropagation();                
                
                let imgSrc = ''         
                const formData = new FormData();
                this.files.forEach(file => {
                    formData.append('images[]',file, file.name );
                    formData.append('tipo',this.tipo);
                });
                
                axios.post('/admin/gestao/midias/upload',formData)
                .then(respo => {
                    respo.data.forEach(element => {
                        if(element.sucesso==false)                            
                            this.pai.$parent.validatorJS(this.pai.$parent.titulo_atencao, `${element.titulo_msg} ${element.msg}` , null)
                        else 
                            {                            
                                this.pai.$parent.validatorJS("Sucesso!!", "Upload realizado com sucesso", "", "sucesso")                                            
                                if (this.pai.$vnode.componentOptions.tag == 'editor')
                                    imgSrc = element.imgSrc
                            }
                    });
                    this.images=[];
                    this.files =[];
                    this.names =[];
                    //volta e fecha                    
                    if (imgSrc){
                        //retorna o metodo de
                        this.$parent.setaImagem(imgSrc);                
                        this.sair();
                    }
                        

                })
            },            
        }
    }
</script>

