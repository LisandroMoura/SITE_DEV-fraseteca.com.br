/* eslint-disable no-undef */
//require('./bootstrap');
import Vue from "vue"

window.Vue = require("vue")

// Vue.component("retorno-msg", require("./components/retorno_msg.vue").default)

require("./Vue/Mixins")
require("./Vue/Mixinsvalidator")

// eslint-disable-next-line no-unused-vars
const app = new Vue({
	el: "#app",
	mixins: [mixin, mixin_validatorjs],
	data: {
		cor: "",
		password: "",
		password_new: "",
		password_confirm: "",
		situacao: "",
	},
	mounted() {
		this.objetoRetornoMSG[0].obj = this.$refs.retorno_msg
		this.password = ""
		this.password_new = ""
		this.password_confirm = ""
		this.situacao = "ocultar"
	},
	updated() {
		// this.testaFormulario()
	},
	methods: {
		criarConta(e) {
			form = document.querySelector("#form_criar")
			btSubmit = document.querySelector("#bt_submit")
			btLoad = document.querySelector("#bt_load")
			btSubmit.classList.add("load")
			btLoad.classList.add("load")
			form.submit()
			return e
		},
		keyPress($event) {
			this.testaFormulario($event)
			
		},
		testaFormulario($event) {
			let msgs = []
			let html = ""
			let msg = ""
			let lok = false
			let novaSenha = document.getElementById("password_new").value
			let confirmaSenha =document.getElementById("password_confirm").value

			if($event.target.id == "password_new")
				novaSenha += $event.key 
			if($event.target.id == "password_confirm")
				confirmaSenha += $event.key 


			// if(document.getElementById("password_new"))
			// 	novaSenha = document.getElementById("password_new").value

			// if(document.getElementById("password_confirm"))
			// 	confirmaSenha = document.getElementById("password_confirm").value

			//inicia os processos
			if (novaSenha.length > "1") {
				lok = true
				//testa o tamanho dos caracteres
				if (novaSenha.length < "6") {
					msg = "Senha menor que 6 dígitos"
					msgs.push(msg)
					lok = false
				}
				//testar os valores digitados
				if (novaSenha != "") {
					if (novaSenha != confirmaSenha) {
						msg = "Senhas diferentes"
						msgs.push(msg)
						lok = false
					}
				}
			}
			//fim dos testes
			if (!lok) {
				this.cor = "#E41833"
				this.situacao = "ocultar"
				this.password = ""
			}
			else {
				msg = "Tudo certo, pode salvar!"
				msgs.push(msg)
				this.situacao = "select-container col"
				this.cor = "#69B579"
				this.password = novaSenha
			}
			msgs.forEach(element => {
				html += "<li>" + element + "</li>"
			})
			this.$refs.aviso.innerHTML = html
		},
	},
})
/**
 * 
 * .row.reenviar.ocultar {
	display: none;
}

 */