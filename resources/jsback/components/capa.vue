<template>    
    <div>
        <button 
        class="btn btn-success btn botao-padrao red full mt-20"
        @click.stop.prevent="$parent.mostrar=true" 
        v-show="!$parent.mostrar" >Alterar capa</button>
        <div class="mostrar" v-show="$parent.mostrar">        
            
            <div class="row justify-content-center">
                <div class="erros" v-if="this.msgErros !=''">
                    {{msgErros}}
                </div>
                <div class="col-md-12">
                    <button class="btn botao-padrao full mt-20"
                    @click.stop.prevent="$parent.lcomputador=true" 
                    v-show="!$parent.lcomputador">
                    <i class="icon icon-bt-capa-download icon-download"></i>
                    Computador</button>
                    <div class="compudator" v-show="$parent.lcomputador">
                        <div class="modal-zone">
                            <div class="wrapper">
                                <computador :opcoes="this.opcoes"></computador>                                
                            </div>
                        </div>
                    </div>   

                    <button class="btn botao-padrao full mt-20"
                    @click.stop.prevent="$parent.lunsplash=true" 
                    v-show="!$parent.lunsplash">
                    <i class="icon icon-bt-capa-unsplash icon-009-camera"></i>
                    Unsplash</button>
                    <div class="unsplash" v-show="$parent.lunsplash">
                        <div class="modal-zone">
                            <div class="wrapper">
                                <unsplash :opcoes="this.opcoes"></unsplash> 
                            </div>
                        </div>
                    </div>   

                    <button class="btn botao-padrao full mt-20"
                    @click.stop.prevent="$parent.lbiblioteca=true" 
                    v-show="!$parent.lbiblioteca" >
                    <i class="icon icon-bt-capa-libary icon-010-picture"></i>
                    Biblioteca</button>
                    <div class="biblioteca" v-show="$parent.lbiblioteca">
                        <div class="modal-zone">
                            <div class="wrapper">
                                <biblioteca :opcoes="this.opcoes"></biblioteca>                                 
                            </div>
                        </div>
                    </div>   
                </div>
            </div>           
        </div>
    </div> 
</template>

<script>    

    import computador from  './computador' ;
    import unsplash from  './unsplash' ;
    import biblioteca from  './biblioteca' ;
    export default {     
        props: ['opcoes'],         
        components:{
            computador,
            unsplash,
            biblioteca,
        },  
        data () {
            return {
                isDragging: false,    
                isErroDimensoes:false,
                dragCount:0,  
                //imgSrc:null,
                obj:'capa',
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
             onInputChange(e){                
                const files = e.target.files;   
                this.msgErros =''                
                Array.from(files).forEach(file => this.addImage(file));
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
                    this.msgErros = `Arquivo, ${file.name}. Tamanho do arquivo é superior a ${this.opt.textoTamanho}`;
                    return ;                    
                }
                //push no files
                this.files.push(file);
                this.names.push(file.name);
                const reader = new FileReader();                         
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
                            self.$toastr.e(`${file.name} - Tamanho: ${this.width} x ${this.height} | capa Largura ou altura inválida.`);
                            self.msgErros = `${file.name} - Tamanho: ${this.width} x ${this.height} | Largura ou altura inválida.`;
                            return true;
                        }
                        else{
                            valueToPush["width"]  = this.width;
                            valueToPush["height"] = this.height;
                            self.images.push(valueToPush);                              
                            self.$parent.setaCapa(this.src);
                            self.$parent.mostrar=false;
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
                            this.$toastr.e(`${element.titulo_msg} ${element.msg}`)
                            this.msgErros = `${element.titulo_msg} ${element.msg}`;
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
