/* eslint-disable no-undef */
window.mixin = {
	data: {
		objConfirma: [{ mostra: "nao", evento: "", pergunta: "", aviso: "", titulo: "", lbconfirma: "", lbcancela: "" }],
		objetoRetornoMSG: [{ classe: "card fade-out", obj: "" }],
		//custom
		labreMenu: "",
		labreMenuPerfil: "",
		labrePesquisa: "",
	},
	methods: {
		fecharMensagem(e) {
			let mensagem = document.querySelector("#mensagem")
			mensagem.classList.add("fechar")

			exec = setTimeout(function () {
				let app = document.querySelector("#app")
				app.removeChild(mensagem)
			}, 1000)
			return e
		},
		abreMenu() { if (this.labreMenu == "ativado") this.labreMenu = ""; else this.labreMenu = "ativado" },
		abrePesquisa() { if (this.labrePesquisa == "ativado") this.labrePesquisa = ""; else this.labrePesquisa = "ativado" },
		abreMenuPerfil() {
			if (this.labreMenuPerfil == "ativado") this.labreMenuPerfil = ""; else this.labreMenuPerfil = "ativado"
		},
	},
}
require("../includes/Lazy")
