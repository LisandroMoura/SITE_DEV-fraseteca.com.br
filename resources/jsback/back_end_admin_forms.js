/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


window.Vue = require('vue');

import Toastr from 'vue-toastr';
Vue.use(Toastr);

Vue.component('bt-confirma', require('./components/bt_confirma.vue').default);
Vue.component('retorno-msg', require('./components/retorno_msg.vue').default);

Vue.component('dispositivo', require('./components/upload_dispositivo.vue').default);
//Vue.component('avatar-galeria', require('./components/avatar_galeria.vue').default);
Vue.component('capa-unsplash', require('./components/capa_unsplash.vue').default);

//Mais um componente
Vue.component('nuvem-tag', require('./components/nuvem_tag.vue').default);
Vue.component('posts-rel', require('./components/posts_rel.vue').default);
Vue.component('editor', require('./components/editor.vue').default);
Vue.component('emoji', require('./components/emoji.vue').default);


require('./mixins_backend_admin');
require('./mixins_validatorjs');

 /**
  * Não esquecer de rodar bash:  npm run dev 
  */    
const app = new Vue({
    el: '#app',  
    props: ['info','opcoes'], 
    mixins:[mixin,mixin_validatorjs],     
    data: {
        //default
        objConfirma: [{mostra:'nao', evento:'', pergunta:'', aviso:'', vaction:''}],         
        objetoRetornoMSG:[{classe: 'card fade-out', obj:''}],                          
        abreConfigClass:"",
         //custom
         mostrarComputador:false,
         mostrarGaleria:false,
         escolhido:'',
         mostrar:false,
         lcomputador:false,
         lunsplash:false,
         lbiblioteca:false,
         imgSrc:null, 
         thumb:null, 
         capa:null,
         mostraCapa:null,
         unsplashVar:'',
         msg:"",
         conta:0,
         errosDeValidacao:false,
         //resolver:"", 
         idDaLista:0,
         titulo:'',
         descricao_previa:'',
         deletados:[],
         loading:"",
         //status:0,
         frases:[
             { id :'', frase :'', frase_id:'', autor :'',id_lista:'',titulo:'',}             
         ],

         frases_old:[
            { id :'', frase :'', frase_id:'', autor :'',id_lista:'',titulo:'',}             
         ],
         lista_itens:'',
         
    },    
    mounted() {  
         //default
         this.objetoRetornoMSG[0].obj    = this.$refs.retorno_msg;             
         //custom   
         this.mostrar                    = false;   
         this.capa                       = this.$refs.ref_capa.value;
         this.imgSrc                     = this.$refs.imgSrc.src;           
         this.thumb                      = this.$refs.ref_thumb.value;     
         this.mostraCapa                 = !this.$refs.imgSrc.dataset.src.includes('null'); 
         this.titulo                     = this.$refs.ref_titulo.value;    
         //this.status                     = this.$refs.ref_status.value;             
         this.idDaLista                  = this.$refs.ref_idDaLista.value;   
         this.descricao_previa           = this.$refs.ref_descricao_previa.value;                 
         this.deletados                  = this.$refs.ref_deletados.value;                   
         this.frases_old                 = this.$refs.ref_frases_old.value;
         
         if (this.frases_old){
             //call the method
             this.getOldFrases(this.frases_old);

         }
         else {
             //here: to review
            axios.get('/api/lista/listar_json/'+this.idDaLista, {})
                .then(response => {
                    this.frases = response.data                  
                })
                .catch(error => {
                    this.frases =error;
                    
            })        
         }
         
    },   
    methods: {   
        getOldFrases(frases_old){
            let lista_itens            
            lista_itens = frases_old.split("#lista_itens#")

            let index = 0  
            //zerar o primeiro box de frases que o sistema gera
            // reset thr first BOX of PHRases the system
            this.frases = []; 
            lista_itens.forEach(item => {                
                if(item!=''){
                    let linha = item.split("#elemento#")
                    if (linha){                       
                        let arr = { id :linha[0], frase :linha[1] , frase_id:linha[2], autor :linha[3],id_lista:0,titulo:''}
                        this.frases.push(arr)                        
                    }
                }
                index++                
            });
            return '';
            
        },      
        getConfirm: function (formulario, event, perg, avis, action, lbconfirma, lbcancela ) {                         
            event.preventDefault();                
            this.objConfirma = [
                {mostra:'sim', evento:this.$refs[formulario], pergunta:perg, aviso:avis, vaction:action, lbconfirma:lbconfirma, lbcancela:lbcancela}
            ];                     
        },
        openConfig: function (){            
            if (this.abreConfigClass=="")
                this.abreConfigClass = "ativo"; 
            else
                this.abreConfigClass = "";
        },
        //custom
        setaCapa: function(result){            
            this.$refs.imgSrc.src = result;
            this.capa  = result;
            this.imgSrc = this.$refs.imgSrc.src;
        },
        setaThumb: function(result){
            this.$refs.ref_thumb.value = result;
            this.thumb  = result;  
        },

        setaFrase: function(frase, autor, idDaFrase, index){
            this.frases[index].frase_id = idDaFrase;
            this.frases[index].frase = frase;
            this.frases[index].autor = autor;           
        },

        setaEmoji: function(emoji, index){   
            let tArea       = this.$refs.textareas[index];
            let startPos    = tArea.selectionStart;
            let endPos      = tArea.selectionEnd;
            let cursorPos   = startPos;
            let tmpStr      = tArea.value;
            let insert      = emoji.data ;
            this.frases[index].frase = tmpStr.substring(0, startPos) + insert + tmpStr.substring(endPos, tmpStr.length);
            // move cursor:
            setTimeout(() => {
                cursorPos += insert.length;
                tArea.selectionStart = tArea.selectionEnd = cursorPos;
            }, 10);
            //this.frases[index].frase = emoji.data;            
        },

        addNewFrase: function(event) {           
            this.frases.push({
                id:'0',
                frase:'',
                autor :'',
            })
        },
        removeFrase: function(index) { 
            this.deletados = this.frases[index].id+';';            
            this.frases.splice(index, 1);
        }, 
        aprovar(){            
            this.$refs.formulario_aprova.setAttribute('action',"/admin/gestao/aprova/aprovar");
            //this.$refs.resolver = "aprovar";
            this.$refs.formulario_aprova.submit();             
            return false;
        },
        rejeitar(){          
            
            this.$refs.formulario_aprova.setAttribute('action',"/admin/gestao/aprova/rejeitar");
            //this.$refs.resolver = "rejeitar";
            this.$refs.formulario_aprova.submit();             
            return false;
        },
        enviarParaRevisao(){            
            if(this.idDaLista>0) 
                this.$refs.formulario.setAttribute('action',"/lista/revisao/"+this.idDaLista);
            else 
                this.$refs.formulario.setAttribute('action',"/lista/storerevisao");
            
            this.getListaItens("revisao");
        },
        enviarParaRascunho(){
            // this.status = '3';
            // this.$refs.ref_status.value = '3';
            if(this.idDaLista>0) 
                this.$refs.formulario.setAttribute('action',"/lista/"+this.idDaLista);
            else 
                this.$refs.formulario.setAttribute('action',"/lista");

            this.getListaItens("rascunho");
        },
        getListaItens: function(event){

            let self = this;
            this.frases.forEach(element => {
                if(element.frase!='')
                     self.lista_itens +=  element.id + '#elemento#' + element.frase + ' #elemento# ' + element.frase_id + ' #elemento# ' +  element.autor  + "#lista_itens#" ;                
             });
            self.$refs.lista_itens.innerHTML = self.lista_itens;
            
            if (event=="revisao") 
                this.errosDeValidacao = this.validatorEnviarRevisao();
            else
                this.errosDeValidacao = this.validator();
            if(this.errosDeValidacao){
                this.validatorJS("Atenção!!", "Reveja os campos do Cadastro", this.errosDeValidacao)
            }
        },
        validatorEnviarRevisao: function(){            
            let objetos = {}
            let temErros = false;            
            let contagem = 0;

            if (this.titulo == ''){
                objetos["titulo"]= 'Título tem que ser informado'
                temErros=true
            }
                
            // if (this.lista_itens == ''){
            //     objetos["frase_0"]= 'Insira pelo menos uma frase'
            //     temErros=true            
            // }
                
            this.frases.forEach(element => {                
                if (element.frase!='')
                    contagem++;                                   
            });

            if (contagem < 10 ){
                objetos["frase_"+ (contagem-1)]= 'A lista precisa ter, no mínimo, 10 Frases'
                temErros=true            
            }
            
            if(temErros)
                return objetos;  
            else this.$refs.formulario.submit();             
            return false;
        },

        validator: function(){                        
            let objetos = {}
            let temErros = false;

            if (this.titulo == ''){
                objetos["titulo"]= 'Você precisa escrever um título'
                temErros=true
            }
                
            // if (this.lista_itens == ''){
            //     objetos["frase_0"]= 'Insira pelo menos uma frase'
            //     temErros=true            
            // }
            
            if(temErros)
                return objetos;  
            else this.$refs.formulario.submit();             
            return false;
        },        
        setaAvatar: function(result){    
            this.capa  = result;
            this.imgSrc = result;
            this.$refs.imgSrc.src = result;
            this.avatar_icone  = result;                        

        },
        startConfirmarCapa(){      
            this.removeImage("")  
            this.loading = "loading"                                         
            this.$refs.pendenteLabel.innerHTML = ""
            this.$refs.pendenteAviso.innerHTML = ""
        },
        endConfirmarCapa(){
            this.mostraCapa = true            
            this.loading = ""
            this.$refs.imgSrc.setAttribute('class','avatar pendente');
            this.$refs.preview.setAttribute('class','preview-imagem container pendente');
            // this.$refs.pendenteLabel.innerHTML = "Quase lá!";
            // this.$refs.pendenteAviso.innerHTML = "Clique em Salvar para confirmar a alteração!";
        },
        removeImage: function(result){            
            this.capa  = 'null';
            this.imgSrc = 'null';            
            this.mostraCapa = false;
            this.$refs.imgSrc.src = "null";
            this.avatar_icone  = "null";                        
        },  

    }, 
    
});