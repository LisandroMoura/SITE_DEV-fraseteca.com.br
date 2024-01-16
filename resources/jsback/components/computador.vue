<template>    
    <div class="w100">
        <div class="uploader"
            :class="{dragging: isDragging}">
            <div>
                <div class="header-content">                        
                    <h3 class="header-title">Imagem do computador</h3>
                    <a class="bt-sair-pesquisa" href="#" @click.stop.prevent="sair" title="Fechar esta opção.">
                        <i class="ico ico-sair ico-exit"></i>
                    </a>                
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
                            
                            <div class="file-input " :class="this.pai.obj">
                                <span class="icon icon-computador"></span>    
                                <span class="label">Procurar no Computador Lista</span>
                                <input ref="fileupload" type="file" name="file" id="file" @change="onInputChange" accept="image/*">                                            
                            </div>
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
                pai:'',
                msgErros:''
            }
        },
        mounted() {
            this.opt = JSON.parse(this.opcoes)   
            this.pai = this.$parent;            
        },
        methods:{
            confirmarCapa(imgSrc){      
                let anterior = this.pai;
                let pagina = anterior.$parent.pagina

                anterior.$parent.mostraCropZone=true

                if (anterior.$vnode.componentOptions.tag == 'capa'){                    
                    if(pagina || pagina != 'post'){
                        anterior.$parent.setaCapa(imgSrc); //setaCapa    
                    }
                    //capa.$parent.setaThumb(imgSrc); //setaThumb
                    this.sair() //fecha a tela
                    /*
                    #RN: - quando for selecionada a imgem do Computador para capa
                    a imagem de Thumb ficará a mesma imagem principal
                    */
                }
                else 
                if (anterior.$vnode.componentOptions.tag == 'thumb'){

                    anterior.$parent.setaThumb(imgSrc);  //setaThumb
                    anterior.sair(); //sair do Obj Thumb                   
                }
            },
            sair(){                
                var capa = this.$parent;
                if (capa.$vnode.componentOptions.tag == 'capa'){
                    capa.$parent.lcomputador = false;
                }
                else
                {
                    capa.sair();
                }
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
            },
            addImage(file){
                let self = this;
                if(!file.type.match('image.*')){
                    self.pai.$parent.validatorJS(self.pai.$parent.titulo_atencao, `${file.name} não é uma imagem válida` , null)
                    //this.$toastr.e(`${file.name} não é uma imagem válida`);
                    this.msgErros = `${file.name} não é uma imagem válida`
                    return ;
                }
                if((file.size/1024) > this.opt.tamanho ){
                    self.pai.$parent.validatorJS(self.pai.$parent.titulo_atencao, `Arquivo, ${file.name}. Tamanho do arquivo é superior a ${this.opt.textoTamanho}` , null)
                    //this.$toastr.e(`Arquivo, ${file.name}. Tamanho do arquivo é superior a ${this.opt.textoTamanho}`);
                    //this.msgErros = `Arquivo, ${file.name}. Tamanho do arquivo é superior a ${this.opt.textoTamanho}`
                    return ;                    
                }
                //push no files
                this.files.push(file);
                this.names.push(file.name);
                const reader = new FileReader(); 
                
                reader.addEventListener("load", function () {                 
                    let valueToPush ={}; 
                    let temErros=false;
                    let capa = this.$parent;
                    var resultado = this.result;
                    valueToPush["result"]   = this.result;
                    valueToPush["name"]     = file.name;
                    valueToPush["size"]     = file.size;

                    var image  = new Image();       
                    image.src = this.result;             
                    image.onload = function (resultado) {                        
                        var width  = this.width;
                        var height = this.height;                        
                        if (height > self.opt.limit_height || width > self.opt.lomit_width){                            
                            //self.$toastr.e(`${file.name} - Tamanho: ${this.width} x ${this.height} | ccc Largura ou altura inválida.`);
                            //self.msgErros = `${file.name} - Tamanho: ${this.width} x ${this.height} | CCC Largura ou altura inválida.`;
                            self.pai.$parent.validatorJS(self.pai.$parent.titulo_atencao, ` Esta imagem é muito grande (Recomendado: no máximo ${self.opt.limit_width} x ${self.opt.limit_height}).` , null)
                            return false;
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
            // upload(e){
            //     e.preventDefault();
            //     e.stopPropagation();                
            //     const formData = new FormData();
            //     this.files.forEach(file => {
            //         formData.append('images[]',file, file.name );
            //     });
            //     axios.post('/admin/gestao/midias/upload',formData)
            //     .then(respo => {
            //         respo.data.forEach(element => {
            //             if(element.sucesso==false)
            //             {
            //                 this.$toastr.e(`${element.titulo_msg} ${element.msg}`);
            //                 this.msgErros = `${element.titulo_msg} ${element.msg}`
            //             }
            //             else
            //                 this.$toastr.s(`${element.titulo_msg} ${element.msg}`);
            //         });
            //         this.images=[];
            //         this.files =[];
            //         this.names =[];
            //     })
            // },            
        }
    }
</script>

