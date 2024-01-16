/**
* First we will load all of this project's JavaScript dependencies which
* includes Vue and other libraries. It is a great starting point when
* building robust, powerful web applications using Vue and Laravel.
*/
import Vue from "vue"
window.Vue = require("vue")

import Toastr from "vue-toastr"
Vue.use(Toastr)

// import "../../public/fonts/fontastic/styles.css"

Vue.component("bt-confirma", require("./components/bt_confirma.vue").default)
Vue.component("retorno-msg", require("./components/retorno_msg.vue").default)

Vue.component("conquistas", require("./components/conquistas.vue").default)


//Componentes
// import "../sass/backend/uploaders_admin.scss"
require("./mixins_backend_admin")
require("./mixins_validatorjs")

import { Messenger } from "../js/includes/Messenger"
      
require("./mixins_backend_admin")
require("./mixins_validatorjs")

const app = new Vue({
	el: "#app",  
	props: ["opcoes"],         
	mixins:[mixin,mixin_validatorjs],     
	data: {  
		//default               
		objConfirma: [{mostra:"nao", evento:"", pergunta:"", aviso:""}],
		objetoRetornoMSG:[{classe: "card fade-out", obj:""}], 
		conquistas:""
	},    
	mounted() {
		//default
		this.objetoRetornoMSG[0].obj    = this.$refs.retorno_msg
		this.conquistas                 = this.$refs.ref_conquistas.value     
		Messenger.preLoadPhp()   
	},
	updated() {        
	},
	methods: { 
		//default       
		getConfirm: function (formulario, event, perg, avis ) {                         
			event.preventDefault()
			this.objConfirma = [
				{mostra:"sim", evento:this.$refs[formulario], pergunta:perg, aviso:avis}
			]                     
		},
		//custom
		salvar(){
			this.errosDeValidacao = this.validatorSalvar()
			if(this.errosDeValidacao)
				this.validatorJS("Atenção!!", "Reveja os campos do Cadastro", this.errosDeValidacao)            
		},        
		validatorSalvar: function(){            
			let objetos = {}
			let temErros = false
            
			let campos = document.querySelectorAll(".validar")
			let camposCollection=Array.from(campos)		

			camposCollection.forEach(function(campo){
				if(campo.classList.contains("naovazio")){
					if (campo.value == ""){
						objetos[campo.id]="Este campo tem que ser informado"
						temErros=true                    
					}
				}
			})
          
			if(temErros)
				return objetos  
			else this.$refs.formulario.submit()             
			return false
		},
	}, 
})