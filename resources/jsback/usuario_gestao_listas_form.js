/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

window.Vue = require('vue');

import Toastr from 'vue-toastr';

Vue.use(Toastr);

Vue.component('bt-confirma', require('./components/bt_confirma.vue').default);
Vue.component('retorno-msg', require('./components/retorno_msg.vue').default);


require('./mixins_backend_admin');

const app = new Vue({
    el: '#app',  
    props: ['prop_frases','opcoes'],     
    //mixins: [confirm],
    data: {  
        //default
        objConfirma: [{mostra:'nao', evento:'', pergunta:'', aviso:''}],         
        objetoRetornoMSG:[{classe: 'card fade-out', obj:''}], 
        //custom
        mostrar:false,
        lcomputador:false,
        lunsplash:false,
        lbiblioteca:false,
        imgSrc:null, 
        capa:null,
        unsplashVar:'',
        msg:"",
        conta:0,
        errosDeValidacao:false,

        idDaLista:0,
        titulo:'',
        descricao_previa:'',
        deletados:[],
        frases:[
            {
                id    :'',
                frase :'',
                autor :'',
                id_lista:'',
                titulo:'',                
            }            
        ],
        lista_itens:'',
    },    
    mounted() {
        //default
        this.objetoRetornoMSG[0].obj    = this.$refs.retorno_msg;             
        //custom   
        this.mostrar                    = false;   
        this.capa                       = ""; //this.$refs.ref_capa.value;
        this.imgSrc                     = this.$refs.imgSrc.src;         

        this.titulo                     = this.$refs.ref_titulo.value;    
        this.idDaLista                  = this.$refs.ref_idDaLista.value;   
        this.descricao_previa           = this.$refs.ref_descricao_previa.value;                 
        this.deletados                  = this.$refs.ref_deletados.value;    
        axios.get('/api/lista/listar_json/'+this.idDaLista, {})
            .then(response => {
                this.frases = response.data                
            })
            .catch(error => {
                this.frases =error                 
        })        
    },
    updated() {
    },
    methods: { 
        //default       
        getConfirm: function (formulario, event, perg, avis ) {                         
            event.preventDefault();            
            this.objConfirma = [
                {mostra:'sim', evento:this.$refs[formulario], pergunta:perg, aviso:avis}
            ];                     
        },
        //custom
        setaCapa: function(result){
            this.$refs.imgSrc.src = result;
            this.capa  = result;
            this.imgSrc = this.$refs.imgSrc.src;
        },
        addNewFrase: function(event) {           
            this.frases.push({
                id:'0',
                frase:'',
                autor :'',
            })
        },
        removeFrase: function(index) { 
            this.deletados = this.frases[index].id+';';            
            this.frases.splice(index, 1);
        }, 
        getListaItens: function(event){   
            
            this.lista_itens="";
            this.frases.forEach(element => {
                if(element.frase!='')
                    this.lista_itens +=  element.id + '#elemento#' + element.frase + ' #elemento# ' +  element.autor  + "#lista_itens#" ;
                //String.fromCharCode(10)
            });
            
            this.errosDeValidacao = this.validator();
            if(this.errosDeValidacao){                             
                event.preventDefault();
                this.$toastr.e(`Erros: ${this.errosDeValidacao}`);
                //alert('Valida Errors: ' + this.errosDeValidacao);
            }
        },
        validator: function(){            
            var self = this;
            let msg = "";
            if (this.titulo == '')
                msg = 'Campo título tem que ser informado OK? \n';
            if (this.lista_itens == '')
                msg+= ' Precisa ter pelo menos uma frase. OK? \n';
            this.frases.forEach(element => {                
                self.conta++;
                if(element.frase==''){                    
                    self.msg += 'Opa! Parece que você esqueceu de Digitar a Frase: ' + self.conta + '. \n'                
                }                    
            });
            if(msg)
                return msg;  
            else this.$refs.formulario.submit();             
            return false;
        }
    }, 
});