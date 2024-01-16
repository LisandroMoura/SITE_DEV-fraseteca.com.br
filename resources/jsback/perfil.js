
window.Vue = require('vue');
Vue.component('bt-confirma', require('./components/bt_confirma.vue').default);
Vue.component('retorno-msg', require('./components/retorno_msg.vue').default);

Vue.component('navegacao-favorita', require('./components/navegacao_favorita.vue').default);
Vue.component('listas-favorita', require('./components/lista_favorita.vue').default);

Vue.component('navegacao-criadas', require('./components/navegacao_criadas.vue').default);
Vue.component('listas-criadas', require('./components/lista_criadas.vue').default);


Vue.component('v-style', {
    render: function (createElement) {
        return createElement('style', this.$slots.default)
    }
});

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
require('./mixins');
const app = new Vue({
    el: '#app',   
    mixins:[mixin],        
    data: {  
       //custom
       show_favoritas:true,
       show_listas:false,
       show_loading:false,
       computedHeight: 'auto',
       listasFavoritasPai:[],
       listasCriadasPai:[],

    },    
    mounted() {                  
       this.objetoRetornoMSG[0].obj = this.$refs.retorno_msg;       
    },
    updated() {           
    },
    methods: {          
        getConfirm: function (formulario, event, perg, avis ) {                         
            event.preventDefault();            
            this.objConfirma = [
                {mostra:'sim', evento:this.$refs[formulario], pergunta:perg, aviso:avis}
            ];                     
        }, 
        abreFavoritas: function () {
            this.show_favoritas = true;
            this.show_listas = false;
        },
        abreListas: function () {
            this.show_listas = true;
            this.show_favoritas = false;            
        },
        getFavoridas (transfer) {
            this.listasFavoritasPai = transfer.dados.data;
        },
        getListasCriadas (transfer) {
            this.listasCriadasPai = transfer.dados.data;
        },

               
    }, 
});
