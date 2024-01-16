/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');

Vue.component('bt-confirma', require('./components/bt_confirma.vue').default);
Vue.component('retorno-msg', require('./components/retorno_msg.vue').default);

//Específico da Função
Vue.component('dispositivo', require('./components/upload_dispositivo.vue').default);
Vue.component('avatar-galeria', require('./components/avatar_galeria.vue').default);
Vue.component('data-custom', require('./components/data_custom.vue').default);

//importar o css das galerias e dos avatares?
//import '../../public/fonts/css/fontello.css';

import VuejsClipper from 'vuejs-clipper'
Vue.use(VuejsClipper)

import '../sass/backend/uploaders.scss' ;     
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
        objConfirma: [{mostra:'nao', evento:'', pergunta:'', aviso:'',  lbconfirma:'', lbcancela:''}],         
        objetoRetornoMSG:[{classe: 'card fade-out', obj:''}],         
        mostrarComputador:false,
        mostrarGaleria:false,        
        escolhido:'',
        imgSrc:null, 
        avatar_icone:null,        
        //campos textarea
        informacoes_biograficas:'',   
        avatar_icone_id:'' ,
        loading:false,          
        //campos cheqbox       
        ch_receber_news:'',
        ch_receber_comentarios_notificacao:'',        
        email:'',
        nome_completo:'',        
        data_nascimento:'',        
        parentPropName: 'myCustomerName',
        reg:/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
        //vuejs-clipper
        origemGaleria:true,
        src: '',
        area:0,
        result: '',
        pixel: ''
         
    },    
    mounted() {  
        //default      
        this.objetoRetornoMSG[0].obj             = this.$refs.retorno_msg;             
        //custom
        this.mostrarComputador                   = false;   
        this.mostrarGaleria                      = false;
        this.origemGaleria                      = false;
        this.escolhido                           = this.$refs.ref_escolhido.value;
        this.avatar_icone                        = this.$refs.ref_avatar_icone.value;
        this.imgSrc                              = this.$refs.imgSrc.src;   
        this.informacoes_biograficas             = this.$refs.ref_informacoes_biograficas.value;         
        this.avatar_icone_id                     = this.$refs.ref_avatar_icone_id.value;         
        this.$refs.ref_conta.innerHTML           = this.informacoes_biograficas.length;      
        this.ch_receber_news                     = this.$refs.ref_receber_news.value == '1' ? true : false; 
        this.ch_receber_comentarios_notificacao  = this.$refs.ref_receber_comentarios_notificacao.value == '1' ? true : false; 

        this.data_nascimento                     = this.$refs.ref_data_nascimento.value;          
        this.email                               = this.$refs.ref_email.value;          
        this.nome_completo                       = this.$refs.ref_nome_completo.value;    
        
        //trigger to dragSubject Ranger
        this.$refs.ranger.dragSubject$.subscribe(() => {
        // This happens whenever zooming, moving and rotating occur.
            this.vaiZoom()
        })



    },   
    methods: {         
        getConfirm: function (formulario, event, perg, avis ) {                         
            event.preventDefault();            
            this.objConfirma = [
                {mostra:'sim', evento:this.$refs[formulario], pergunta:perg, aviso:avis}
            ];                     
        },
        //vuejs-clipper
        vaiZoom () {            
            let percentual = 0;
            if(this.$refs.ranger.value !="NaN")
                percentual = this.$refs.ranger.value;
            let zoom = 1 + (percentual/100)
            this.$refs.clipper.setWH$.next(zoom)
        },        
        getResult () {
            let self = this
            const canvas = this.$refs.clipper.clip({maxWPixel: 300})
            this.pixel = `${canvas.width} x ${canvas.height}`
            this.result = canvas.toDataURL('image/jpeg')
            this.$refs.imgSrc.src = this.result;
            this.avatar_icone  = this.result;            
            setTimeout(function(){
                self.validaSubmit("")
            },500)
        },
        //vuejs-clipper
        clip () {
            this.getResult()
            const a = document.createElement('A')
            a.download = 'result.jpg'
            a.href = this.result
            a.target = '_blank'
            a.click()
        },
        //custom
        isEmailValid: function() {
            return (this.email == "")? "" : (this.reg.test(this.email)) ? 'has-success' : 'has-error';
        },
        validaSubmit(e){   
            let objetos = {}
            let temErros = false;            
            if(this.nome_completo==''){
                objetos["nome_completo"]= 'Nome é obrigatório'
                temErros=true                
            }                          
            if(this.email==""){
                objetos["email"]= 'O email é obrigatório'
                temErros=true                            
            } else {
                if(this.reg.test(this.email) == false){
                    objetos["email"]= 'O email informado é inválido'
                    temErros=true
                }
            }
            if(!temErros) 
              this.$refs.formulario.submit();                
            else
                this.validatorJS("Atenção!!", "Reveja os campos do Cadastro", objetos)
            
        },         
        startConfirmarCapa(){      
            this.removeImage("")  
            this.loading = true
            this.$refs.imgSrc.setAttribute('class','avatar pendente');
            this.$refs.preview.setAttribute('class','preview-imagem perfil container pendente');             
            this.$refs.pendenteLabel.innerHTML = ""
            this.$refs.pendenteAviso.innerHTML = ""
        }, 
        setaAvatar: function(result, id = null){
            this.avatar_icone_id = id;
            this.$refs.imgSrc.src = result;
            this.avatar_icone  = result;   
            //vuejs-clipper 
            this.src = result;
        },        
        endConfirmarCapa(){
            this.mostraCapa = true            
            this.loading = false
            this.$refs.imgSrc.setAttribute('class','avatar pendente');
            this.$refs.preview.setAttribute('class','preview-imagem perfil container pendente');
            this.$refs.pendenteLabel.innerHTML = "Quase lá!";
            this.$refs.pendenteAviso.innerHTML = "Clique em Salvar para confirmar a alteração!";

        },
        removeImage: function(result){             
            this.avatar_icone_id = null;
            this.$refs.imgSrc.src = "";
            this.avatar_icone  = "";            
        },
        validaTamanho: function(event) {
            let conta = event.currentTarget.value.length;            
            let limite = 0;            
            this.$refs.ref_conta.innerHTML = conta            
            limite = this.$refs.ref_limite.innerHTML
            if(conta >= limite){               
               //event.currentTarget.setAttribute('class','red')               
               event.currentTarget.value = event.currentTarget.value.substr(0, limite)
               this.$refs.ref_conta.setAttribute('class','red')
               this.$refs.ref_limite.setAttribute('class','red')
            } else{                
                //event.currentTarget.setAttribute('class','')
                this.$refs.ref_conta.setAttribute('class','')
                this.$refs.ref_limite.setAttribute('class','')
            }              
        },
        check_receber_news: function(event) {            
            this.$refs.ref_receber_news.value = this.ch_receber_news ? 1 : 0            
        },
        check_receber_comentarios_notificacao: function(event) {            
            this.$refs.ref_receber_comentarios_notificacao.value = this.ch_receber_comentarios_notificacao ? 1 : 0            
        }
        ,
        getDataCustom (data) {            
            this.data_nascimento = data;
        },
    }, 
    
});