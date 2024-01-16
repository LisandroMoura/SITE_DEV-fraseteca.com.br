//require('./bootstrap');
window.Vue = require('vue');

Vue.component('retorno-msg', require('./components/retorno_msg.vue').default);

require('./mixins');
require('./mixins_validatorjs');

const app = new Vue({
    el: '#app',  
    mixins:[mixin,mixin_validatorjs],
    data: {
        name:'',
        email:'',
        password:'',
        errosDeValidacao:false,
        reg:/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
    },    
    mounted() {                  
       this.objetoRetornoMSG[0].obj = this.$refs.retorno_msg; 
       this.name                    = this.$refs.ref_name.value;
       this.email                   = this.$refs.ref_email.value ? this.$refs.ref_email.value : "";
       
       
    },
    updated() { 
                
    },
    methods: { 
        validator: function(){                        
            let objetos = {}
            let temErros = false;

            if (this.name == ''){
                objetos["name"]= 'Campo nome não pode ser em branco'
                temErros=true
            }

            if (this.email == ''){
                objetos["email"]= 'Campo Email não pode ser em branco'
                temErros=true
            }
            if(this.reg.test(this.email) == false){
                objetos["email"]= 'O email informado é inválido'
                temErros=true
            }
                
            // if (this.lista_itens == ''){
            //     objetos["frase_0"]= 'Insira pelo menos uma frase'
            //     temErros=true            
            // }
            
            if(temErros)
                return objetos;  
            else 
                return false;
        },
        criarConta(e){
            
            this.errosDeValidacao = this.validator()
            if(this.errosDeValidacao){
                this.validatorJS("Atenção!!", "Reveja os campos do Cadastro", this.errosDeValidacao)
            }
            else{
                form = document.querySelector("#form_criar")
                btSubmit = document.querySelector("#bt_submit")
                btLoad = document.querySelector("#bt_load")
                btSubmit.classList.add("load"); 
                btLoad.classList.add("load");  
                form.submit()
            }            
        },

    },
});
