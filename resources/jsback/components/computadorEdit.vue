<template>    
    <div>         
        <div class="computador-edit">
            <div class="uploader"
                :class="{dragging: isDragging}">
                <div class="erros" v-if="this.msgErros !=''">
                    {{msgErros}}
                </div>
                <div>                    
                    <i class="fas fa-cloud-upload-alt"></i>    
                    <div>
                        <span class="helper" v-text="'Barra - Tamanho máximo do arquivo: ' + this.opt.textoTamanho"></span>
                    </div> 
                    <div>
                        <p>Barra -  Dimensões Permitidas:</p>   
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
                        
                        <div v-if="this.opt.tipo === 'multiple'">
                            <input type="file" name="fileEdit" id="fileEdit" @change="onInputChange" multiple accept="image/*">
                        </div>                                                        
                        <div v-else>
                            <input type="file" name="fileEdit" id="fileEdit" @change="onInputChange" accept="image/*">
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
                //imgSrc:null,
                opt:[],
                files: [],
                names: [],
                images: [],
                editor:'',                
                msgErros:'',
                
            }
        },  
        mounted() {    

            this.opt = JSON.parse(this.opcoes)               
            this.editor = this.$parent;                
                
            
        },
        methods:{
            confirmarCapa(imgSrc){                 
                this.editor.setaImagem(imgSrc);                
                this.sair();
            },
            sair(){                
                let capa = this.$parent;
                capa.$parent.lcomputador = false;
                //self.$parent.setaCapa(this.src);
            },                   
            onInputChange(e){                           
                const files = e.target.files;                   
                this.msgErros =''
                Array.from(files).forEach(file => this.addImage(file));
                // this.editor.setaImagem("teste");
            },
            addImage(file){
                //console.log("change");     
                var self = this;
                if(!file.type.match('image.*')){
                    this.$toastr.e(`${file.name} não é uma imagem válida`);
                    this.msgErros = `${file.name} não é uma imagem válida`
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
                reader.addEventListener("load", function () {                 
                    let valueToPush ={}; 
                    let temErros=false;
                    let capa = self.$parent;

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
                            self.$toastr.e(`${file.name} - Tamanho: ${this.width} x ${this.height} | comp Largura ou altura inválida.`);
                            self.msgErros = `${file.name} - Tamanho: ${this.width} x ${this.height} | Largura ou altura inválida.`;
                            return true;
                        }
                        else{
                            valueToPush["width"]  = this.width;
                            valueToPush["height"] = this.height;
                            self.images.push(valueToPush);                            
                            self.confirmarCapa(this.src);                            
                            self.$parent.mostrar=false;
                            return false;
                        }                     
                    };
                }, false);                
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

.computador-edit{
    .uploader {
        width: 100%;
        background: #007bff;
        color: #fff;
        text-align: center;
        padding: 40px 15px;
        border-radius: 10px;
        border: 2px dashed #fff;
        font-size: 20px;
        position: relative;

        &.dragging{
            background: #fff;
            color: #007bff;
            border: 2px dashed #007bff;

            .file-input label{
                background: #007bff;
                color: #fff;
            }
        }
    }

    
    i.fas.fa-cloud-upload-alt {
        font-size: 58px;
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
    
}    
</style>
