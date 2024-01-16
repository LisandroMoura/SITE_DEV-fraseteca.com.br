//require('./bootstrap');
window.Vue = require('vue');

Vue.component('emoji', require('./components/emoji.vue').default);
const app = new Vue({
    el: '#app',      
    data: {  
    },    
    mounted() {                  

    },
    updated() {           
    },
    methods: {         
    }, 
});