//require('./bootstrap');
window.Vue = require('vue');
Vue.component('bt-confirma', require('./components/bt_confirma.vue').default);
Vue.component('retorno-msg', require('./components/retorno_msg.vue').default);
const app = new Vue({
    el: '#app',      
    data: {  
        descricao:'',
        objConfirma: [{mostra:'nao', evento:'', pergunta:'', aviso:''}],         
        objetoRetornoMSG:[{classe: 'card fade-out', obj:''}],     
    },    
    mounted() {      
        this.descricao               = this.$refs.ref_descricao.value;                     
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