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

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


//Específico da Função
Vue.component('capa', require('./components/capa.vue').default);
// Vue.component('unsplash', require('./components/unsplash.vue').default);

require('./mixins_backend_admin');
const app = new Vue({
    el: '#app',  
    props: ['prop_frases','opcoes','toolbars'],     
    mixins: [mixin],
    data: {  
        //default       
        
        objConfirma: [{mostra:'nao', evento:'', pergunta:'', aviso:''}],
        objetoRetornoMSG:[{classe: 'card fade-out', obj:''}], 
        //custom
        mostrar:false,
        lcomputador:false,
        lunsplash:false,
        lbiblioteca:false,

        imgSrc:null,         
        capa:null,   
        unsplashVar:'',    

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
        //custom   
        this.mostrar                    = false;   
        this.capa                       = this.$refs.ref_capa.value;
        
        
        this.imgSrc                     = this.$refs.imgSrc.src;        
        this.titulo                     = this.$refs.ref_titulo.value;            
        this.idDoBanner                   = this.$refs.ref_idDoBanner.value;   
        this.resumo                     = this.$refs.ref_resumo.value;         
        this.urlamigavel                = this.$refs.ref_urlamigavel.value;                 
        //this.corpo                      = this.$refs.ref_corpo.value; 
        //this.bancoDeTags                = this.$refs.ref_bancoDeTags.value;
        
     
    },
    updated() {        
    },
    methods: { 
        //default       

        pesquisarTags: function(event){
            let termo = event.currentTarget.value+','; 
            
            if(this.bancoDeTags.indexOf(termo) != -1)
                this.campoTag = termo;
            else
                this.campoTag = '';

        },
        getConfirm: function (formulario, event, perg, avis ) {                         
            event.preventDefault();
            this.objConfirma = [
                {mostra:'sim', evento:this.$refs[formulario], pergunta:perg, aviso:avis}
            ];                     
        },
        //custom
        setaCapa: function(result){
            this.$refs.imgSrc.src = result;
            this.capa  = result;
            this.imgSrc = this.$refs.imgSrc.src;
        },
        setaThumb: function(result){
            /*
            this.$refs.ref_thumb.value = result;
            this.thumb  = result;  
            */
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
        validator: function(){            
            var self = this;
            let msg = "";
            if (this.titulo == '')
                msg = 'Campo título tem que ser informado OK? \n';
            if (this.lista_itens == '')
                msg+= ' Precisa ter pelo menos uma frase. OK? \n';
            
            if(msg)
                return msg;  
            return false;
        }
    }, 
});