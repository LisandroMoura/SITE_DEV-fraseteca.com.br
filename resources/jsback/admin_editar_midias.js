/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));


// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('usuarios-ajax', require('./components/TabelaUsuariosAjax.vue').default);
// Vue.component('tabela-usuarios', require('./components/TabelaUsuarios.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 /**
  * Não esquecer de rodar bash:  npm run dev 
  */
const app = new Vue({
    el: '#app',  
    props: ['info'],  
    data: {
        titulo : 'Título vindo do App.js',
        //campos textarea
        informacoes_biograficas:'',      
        //campos cheqbox       
        ch_receber_news:'',
        ch_receber_comentarios_notificacao:'',
    },    
    mounted() {        
        this.informacoes_biograficas             = this.$refs.ref_informacoes_biograficas.value;         
        this.$refs.ref_conta.innerHTML           = this.informacoes_biograficas.length;      
        this.ch_receber_news                     = this.$refs.ref_receber_news.value == '1' ? true : false; 
        this.ch_receber_comentarios_notificacao  = this.$refs.ref_receber_comentarios_notificacao.value == '1' ? true : false; 
    },
    updated() {            
        // if(this.V_SIZE_informacoes_biograficas){                  
        //     this.informacoes_biograficas = this.informacoes_biograficas.substr(0, this.$refs.ref_limite.innerHTML)
        //     this.$refs.ref_conta.innerHTML = this.informacoes_biograficas.length            
        //     this.$refs.ref_conta.setAttribute('class','')            
        //     this.$refs.ref_limite.setAttribute('class','')
        //     this.cor = '#000'
        // }
    },
    methods: {        
        validaTamanho: function(event) {
            conta = event.currentTarget.value.length 
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
    }, 
});