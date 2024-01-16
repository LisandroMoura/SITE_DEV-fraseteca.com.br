//require('./bootstrap');
window.Vue = require('vue');

Vue.component('retorno-msg', require('./components/retorno_msg.vue').default);

require('./mixins');

const app = new Vue({
    el: '#app',  
    mixins:[mixin],
    data: {         
    },    
    mounted() {                  
       this.objetoRetornoMSG[0].obj = this.$refs.retorno_msg;       
    },
    updated() {           
    },
    methods: {                  
    },
});
