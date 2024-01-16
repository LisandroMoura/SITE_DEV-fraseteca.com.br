//require('./bootstrap');
window.Vue = require('vue');

// import Toastr from 'vue-toastr';
// Vue.use(Toastr);
//
// import Vue2TouchEvents from 'vue2-touch-events'
// Vue.use(Vue2TouchEvents)

Vue.component('bt-confirma', require('./components/bt_confirma.vue').default);
Vue.component('retorno-msg', require('./components/retorno_msg.vue').default);

//Carrosel favoritas
Vue.component('navegacao-favorita', require('./components/navegacao_favorita.vue').default);
Vue.component('listas-favorita', require('./components/lista_favorita.vue').default);

Vue.component('navegacao-frases-favorita', require('./components/navegacao_frases_favorita.vue').default);
Vue.component('frases-favoritas', require('./components/frases_favoritas.vue').default);


require('./mixins_backend_admin');
require('./mixins_validatorjs');

const app = new Vue({
    el: '#app',  
    mixins:[mixin,mixin_validatorjs],     
    data: {      
        objConfirma: [{mostra:'nao', evento:'', pergunta:'', aviso:''}], 
        objetoRetornoMSG:[{classe: 'card fade-out', obj:''}],            
        show_frases:true,                
        show_favoritas:false,                
        listasFavoritasPai:[],        
        listasFrasesPai:[],  
        computedHeight: 'auto', 
        cardHelper:"",
        slideIndex:1,
        timerHelp:0,
        timerDefault:30,
        timerRetro:30,
        timerHandle:0,
        contadorHandle:0,

    },    
    mounted() {                  
       this.objetoRetornoMSG[0].obj = this.$refs.retorno_msg; 
       this.cardHelper = this.$refs.card_helper;   
       
       this.goHelpers(1)
       
    },
    updated() {           
    },
    methods: {  
        abreFavoritas: function () {
            this.show_favoritas = true;            
            this.show_frases    = false;            
        },        
        getFavoridas (transfer) {
            this.listasFavoritasPai = transfer.dados.data;
        },        
        abreFrases: function () {
            this.show_favoritas = false;            
            this.show_frases    = true;            
        },        
        getFrases (transfer) {
            this.listasFrasesPai = transfer.dados.data;
        },
        goHelpers(n) {

            let i;
            let helpers = document.getElementsByClassName("card_helper_item")
            let dots    = document.getElementsByClassName("dot")
                        
            if(helpers[0]) {
                if (n > helpers.length) {this.slideIndex = 1}
                if (n < 1) {this.slideIndex = helpers.length}
                for (i = 0; i < helpers.length; i++) {
                    helpers[i].style.display = "none";
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" selected", "");
                }            
                dots[this.slideIndex-1].className += " selected";
                helpers[this.slideIndex-1].style.display = "block"

                clearTimeout(this.timerHandle)
                this.timerHelpers()

            }

            
        },
        currentHelpers(n){
            clearTimeout(this.timerHandle)              
            this.goHelpers(this.slideIndex = n)
            this.timerHelp=1
            this.timerRetro=this.timerDefault
        },

        timerHelpers(){
                let self = this            
            // self.timerHelp++
            // self.timerRetro--
            
            // if (self.timerRetro <= 0)
            //     self.timerRetro = 0;

            // let percentual=0            
            // percentual = Math.round ( (self.timerHelp * 100 ) / (self.timerDefault), 1)            
            // let barraLoading = document.getElementsByClassName("card_helper_barra_loading")                                    
            // barraLoading[0].style.width = percentual + "%"
            
            // if(self.timerHelp>=self.timerDefault){
            //     
            //     self.currentHelpers(this.slideIndex+1)
            // }                                                                

            clearTimeout(self.timerHandle)
            clearTimeout(self.contadorHandle)            
            this.timerHandle = setTimeout(function(){ self.contador() }, 1000);
        },
        contador(){
            let self = this            
            self.timerHelp++
            self.timerRetro--

            if (self.timerRetro <= 0)
                self.timerRetro = 0;

            let percentual=0            
            percentual = Math.round ( (self.timerHelp * 100 ) / (self.timerDefault), 1)            
            let barraLoading = document.getElementsByClassName("card_helper_barra_loading")                                    
            barraLoading[0].style.width = percentual + "%"
            
            if(self.timerHelp>=self.timerDefault){
                clearTimeout(self.timerHandle)
                clearTimeout(self.contadorHandle)
                self.currentHelpers(this.slideIndex+1)
            }
            self.contadorHandle = setTimeout(function(){ self.contador() }, 1000)
        },        
    },
});
