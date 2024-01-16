//require('./bootstrap');
window.Vue = require('vue');

Vue.component('bt-confirma', require('./components/bt_confirma.vue').default);
Vue.component('retorno-msg', require('./components/retorno_msg.vue').default);

require('./mixins_backend_admin');

const app = new Vue({
    el: '#app',  
    mixins:[mixin],
    data: {      
        objConfirma: [{mostra:'nao', evento:'', pergunta:'', aviso:''}], 
        objetoRetornoMSG:[{classe: 'card fade-out', obj:''}],        
    },    
    mounted() {                  
       this.objetoRetornoMSG[0].obj = this.$refs.retorno_msg;       
    },
    updated() {           
    },
    methods: {       
    },
});
