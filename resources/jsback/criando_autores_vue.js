window.Vue = require('vue').default;
import Toastr from 'vue-toastr';
Vue.use(Toastr);

// import '../../public/fonts/fontastic/styles.css';
    
Vue.component('bt-confirma', require('./components/bt_confirma.vue').default);
// Vue.component('retorno-msg', require('./components/retorno_msg.vue').default);
// Vue.component('conquistas', require('./components/conquistas.vue').default);

import '../sass/backend/uploaders_admin.scss' ;     
require('./mixins_backend_admin');
require('./mixins_validatorjs');

const app = new Vue({
    el: '#app',  
    props: ['opcoes'],         
    mixins:[mixin,mixin_validatorjs],     
    data: {  
        objConfirma: [{mostra:'nao', evento:'', pergunta:'', aviso:''}],
        objetoRetornoMSG:[{classe: 'card fade-out', obj:''}],         
        dataFrases:''
    },    
    mounted() {
        this.objetoRetornoMSG[0].obj    = this.$refs.retorno_msg;        
        // this.dataFrases                 = this.$refs.dataFrases.value;        
    },
    updated() {},
    methods: { 
        getConfirm: function (formulario, event, perg, avis ) {                         
            event.preventDefault();
            this.objConfirma = [
                {mostra:'sim', evento:this.$refs[formulario], pergunta:perg, aviso:avis}
            ];                     
        },
        salvar(){
            this.errosDeValidacao = this.validatorSalvar();
            if(this.errosDeValidacao)
                this.validatorJS("Atenção!!", "Reveja os campos do Cadastro", this.errosDeValidacao)            
        },        
        validatorSalvar: function(){            
            let objetos = {}
            let temErros = false;
            
            let campos = document.querySelectorAll(".validar")
            let camposCollection=Array.from(campos)		

            camposCollection.forEach(function(campo){
                if(campo.classList.contains("naovazio")){
                    if (campo.value == ""){
                        objetos[campo.id]='Este campo tem que ser informado'
                        temErros=true                    
                    }
                }
            })
          
            if(temErros)
                return objetos;  
            else this.$refs.formulario.submit();             
            return false;
        },
        marcarTudo(){            
            let frases = document.querySelectorAll(".frase_checkbox")
            if(frases)
                frases.forEach(frase_checkbox => {
                    frase_checkbox.checked=true                    
                });
            this.atualisaDataFrases()
        },
        desmarcarTudo(){
            let frases = document.querySelectorAll(".frase_checkbox")
            if(frases)
                frases.forEach(frase_checkbox => {
                    frase_checkbox.checked=false                    
                });
            this.atualisaDataFrases()    
        },
        removerDestaLista(event){
            let id= event.target.getAttribute("data-id")
            let trFrase = document.getElementById(`trFrase_${id}`)
            if (trFrase){
                this.executaRemocao(trFrase)
                this.recalculaFrases()
            }
            this.atualisaDataFrases()
        },
        recalculaFrases(){
            let frases = document.querySelectorAll(".frase_checkbox")
            let count=0
            if(frases)
                frases.forEach(frase_checkbox => {
                    count++
                });
                this.$refs.total.innerHTML=count     
            
        },
        adicionaOutrosNomesSimilaresNaBusca(event){
            let tag = event.target
            let novoAutor = event.target.getAttribute("data-value")
            let pesquisa = document.getElementById("pesquisar_novos_nomes")
            if(pesquisa){
                pesquisa.value += novoAutor
                this.executaRemocao(tag.parentElement)
            }
        },
        removeNomesJaRelacionados(event){
            let tag     = event.target
            let autor   = event.target.getAttribute("data-value")
            let Frases  = document.querySelectorAll(".frase_item")
            if(Frases)
                Frases.forEach(trFrase => {
                    if(trFrase.getAttribute("data-autor") == autor){
                        this.executaRemocao(trFrase)                        
                    }                  
                })
            this.executaRemocao(tag.parentElement)
            this.atualisaDataFrases()
        },
        executaRemocao(item){
            item.parentElement.removeChild(item)
        },
        atualisaDataFrases(){
            this.$refs.dataFrases.value = ""
            let frases = document.querySelectorAll(".frase_checkbox")
            let id_frase=""
            if(frases){
                frases.forEach(frase_checkbox => {
                    if(frase_checkbox.checked)
                        id_frase = id_frase + frase_checkbox.value+";"                    
                });
                this.$refs.dataFrases.value=id_frase
            }
        },
        atualisaDataFrasesItem(event){
            this.atualisaDataFrases()
        }

    }, 
});