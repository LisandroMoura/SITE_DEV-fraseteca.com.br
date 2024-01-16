/**
* First we will load all of this project's JavaScript dependencies which
* includes Vue and other libraries. It is a great starting point when
* building robust, powerful web applications using Vue and Laravel.
*/

//require('./bootstrap');
window.Vue = require('vue');

import '../../public/fonts/fontastic/styles.css';

Vue.component('bt-confirma', require('./components/bt_confirma.vue').default);
Vue.component('retorno-msg', require('./components/retorno_msg.vue').default);
Vue.component('capa', require('./components/capa.vue').default);
Vue.component('dispositivo', require('./components/upload_dispositivo.vue').default);
//Vue.component('avatar-galeria', require('./components/avatar_galeria.vue').default);
Vue.component('capa-unsplash', require('./components/capa_unsplash.vue').default);


Vue.component('upload', require('./components/upload.vue').default);


import '../sass/backend/uploaders_admin.scss' ;     
require('./mixins_backend_admin');
require('./mixins_validatorjs');

const app = new Vue({
    el: '#app',  
    props: ['prop_frases','opcoes','toolbars'],     
    mixins: [mixin, mixin_validatorjs],
    data: {  
        //default       
        
        objConfirma: [{mostra:'nao', evento:'', pergunta:'', aviso:''}],
        objetoRetornoMSG:[{classe: 'card fade-out', obj:''}], 
        //custom
        mostrar:false,

        mostrarThumb:false,
        lcomputador:false,
        lunsplash:false,
        lbiblioteca:false,

        //atender a funcionalidade de Thumb para unsplash e computador
        lunsplashThumb:false,
        lcomputadorThumb:false,

        imgSrc:null,         
        capa:null,   
        unsplashVar:'',    
        unsplashIdFotoAtual:'',

        msg:"",
        conta:0,
        errosDeValidacao:false,
        idDoBanner:0,
        titulo:'',        
        resumo:'',                
        urlamigavel:'',        
       
    },    
    mounted() {
        //default
        this.objetoRetornoMSG[0].obj    = this.$refs.retorno_msg;             
        this.mostrar                    = false;   
        //this.unsplashIdFotoAtual        = this.$refs.ref_unsplashIdFotoAtual.value; 
        // this.capa                       = this.$refs.ref_capa.value;
        // this.imgSrc                     = this.$refs.imgSrc.src;                
        //this.idDoBanner                 = this.$refs.ref_idDoBanner.value;
        
    },
    updated() {        
    },
    methods: { 
        //default 
        setaCapa: function(result){            
            this.$refs.imgSrc.src = result;
            this.capa  = result;
            this.imgSrc = this.$refs.imgSrc.src;
        },
        setaThumb: function(result){
            // this.$refs.ref_thumb.value = result;
            // this.thumb  = result;  
        },
        //custom
        salvar(){
            this.errosDeValidacao = this.validatorSalvar();
            if(this.errosDeValidacao)
                this.validatorJS("Atenção!!", "Reveja os campos do Cadastro", this.errosDeValidacao)            
        },        
        validatorSalvar: function(){            
            let objetos = {}
            let temErros = false;
            
            let campos = document.querySelectorAll(".validar")
            let camposCollection=Array.from(campos)		

            camposCollection.forEach(function(campo){
                if(campo.classList.contains("naovazio")){
                    if (campo.value == ""){
                        objetos[campo.id]='Este campo tem que ser informado'
                        temErros=true                    
                    }
                }
            })
            if(temErros)
                return objetos;  
            else this.$refs.formulario.submit();             
            return false;
        },
    }, 
});