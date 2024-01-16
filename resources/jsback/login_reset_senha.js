//require('./bootstrap');
window.Vue = require('vue');

Vue.component('retorno-msg', require('./components/retorno_msg.vue').default);

require('./mixins');
require('./mixins_validatorjs');

const app = new Vue({
    el: '#app',  
    mixins:[mixin,mixin_validatorjs],     
    data: {  
        cor:'',  
        password :'',
        password_new :'',        
        password_confirm: '' , 
        situacao: '',       
    },    
    mounted() {                  
       this.objetoRetornoMSG[0].obj = this.$refs.retorno_msg;     
       this.password =''
       this.password_new =''
       this.password_confirm= ''  
       this.situacao = 'ocultar'
    },
    updated() { 
        let msgs = [];
        let html="";
        let msg = "";
        let lok = false;
        //inicia os processos
        if (this.password_new.length > '1') {
            lok=true;
            //testa o tamanho dos caracteres
            if (this.password_new.length < '6' ){
                msg = 'Senha menor que 6 dígitos';
                msgs.push(msg);
                lok=false;                                
            }
            //testar os valores digitados
            if(this.password_new!='') {
                if(this.password_new != this.password_confirm){
                    msg ='Senhas diferentes';
                    msgs.push(msg);
                    lok=false;                    
                }
            }             
        }
        //fim dos testes
        if (!lok){            
            this.cor = 'red' ;     
            this.situacao = 'ocultar';       
            this.password = '';            
        }
        else{
            msg ='Tudo certo, pode salvar!';
            msgs.push(msg);         
            this.situacao = 'select-container col';   
            this.cor = 'green';            
            this.password = this.password_new;
        }
        msgs.forEach(element => {
            html +="<li>" + element + "</li>"; 
        });
        this.$refs.aviso.innerHTML = html;          
    },
    methods: { 
        criarConta(e){

            form = document.querySelector("#form_criar")
            btSubmit = document.querySelector("#bt_submit")
            btLoad = document.querySelector("#bt_load")
            btSubmit.classList.add("load"); 
            btLoad.classList.add("load");             
            form.submit()            
        },                
    },
});


/**
 * 
 * .row.reenviar.ocultar {
    display: none;
}

 */