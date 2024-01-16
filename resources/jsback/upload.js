///require('./bootstrap');
window.Vue = require('vue');

import Toastr from 'vue-toastr';
Vue.use(Toastr);

//Padrão
Vue.component('bt-confirma', require('./components/bt_confirma.vue').default);
Vue.component('retorno-msg', require('./components/retorno_msg.vue').default);

//Específico da Função
Vue.component('upload', require('./components/upload.vue').default);

require('./mixins_backend_admin');

const app = new Vue({
    el: '#app', 
    props: ['opcoes'],       
    data: {  
       objConfirma: [{mostra:'nao', evento:'', pergunta:'', aviso:''}],         
       objetoRetornoMSG:[{classe: 'card fade-out', obj:''}],     
       tipo:""
    },    
    mounted() {                  
       this.objetoRetornoMSG[0].obj = this.$refs.retorno_msg;       
       
    },
    updated() {   
        //console.log(this.$refs.tipo.value)
        
    },
    methods: {         
        getConfirm: function (formulario, event, perg, avis ) {                         
            event.preventDefault();            
            this.objConfirma = [
                {mostra:'sim', evento:this.$refs[formulario], pergunta:perg, aviso:avis}
            ];                     
        },        
    }, 
});