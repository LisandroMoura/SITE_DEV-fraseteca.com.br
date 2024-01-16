//require('./bootstrap');
window.Vue = require('vue');

import Toastr from 'vue-toastr';
Vue.use(Toastr);


//Padrão
Vue.component('bt-confirma', require('./components/bt_confirma.vue').default);
Vue.component('retorno-msg', require('./components/retorno_msg.vue').default);

//Específico da Função
Vue.component('dispositivo', require('./components/upload_dispositivo.vue').default);
Vue.component('avatar-galeria', require('./components/avatar_galeria.vue').default);

const app = new Vue({
    el: '#app', 
    props: ['opcoes'],       
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
        getConfirm: function (formulario, event, perg, avis ) {                         
            event.preventDefault();            
            this.objConfirma = [
                {mostra:'sim', evento:this.$refs[formulario], pergunta:perg, aviso:avis}
            ];                     
        },        
    }, 
});