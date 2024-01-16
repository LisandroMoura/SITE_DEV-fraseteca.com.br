
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.Vue = require('vue');


Vue.component('bt-confirma', require('./components/bt_confirma.vue').default);
Vue.component('retorno-msg', require('./components/retorno_msg.vue').default);

require('./mixins_backend_admin');
require('./mixins_validatorjs');
const app = new Vue({
    el: '#app',  
    props: ['info','opcoes'],  
    mixins:[mixin,mixin_validatorjs],     
    data: {       
        objConfirma: [{mostra:'nao', evento:'', pergunta:'', aviso:''}],         
        objetoRetornoMSG:[{classe: 'card fade-out', obj:''}], 
        aviso:'', 
        cor:'', 
        situacao: '',
        password :'',
        password_new :'',        
        password_confirm: ''      
    },
    mounted() {
        this.objetoRetornoMSG[0].obj = this.$refs.retorno_msg;             
        this.aviso = ''
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
            this.cor = 'green';
            this.situacao = 'select-container col';
            this.password = this.password_new;
        }
        msgs.forEach(element => {
            html +="<li>" + element + "</li>"; 
        });
        this.$refs.aviso.innerHTML = html;
    }
});