
import Vue from "vue"
window.Vue = require("vue")


import Toastr from "vue-toastr"
Vue.use(Toastr)


//require('./bootstrap');

//import '../../public/fonts/fontastic/styles.css';

import _ from "lodash"


Vue.component("bt-confirma", require("./components/bt_confirma.vue").default)
Vue.component("retorno-msg", require("./components/retorno_msg.vue").default)

//importar o css das galerias e dos avatares?
//import '../../public/fonts/css/fontello.css';

require("./mixins_backend_admin")

/**
 * Não esquecer de rodar bash:  npm run dev 
 */
const app = new Vue({
	el: "#app",
	props: ["info", "opcoes"],
	mixins: [mixin],
	data: {
		//default
		objConfirma: [{ mostra: "nao", evento: "", pergunta: "", aviso: "" }],
		objetoRetornoMSG: [{ classe: "card fade-out", obj: "" }],
		abreConfigClass: ""

	},
	mounted() {
		//default      
		this.objetoRetornoMSG[0].obj = this.$refs.retorno_msg
	},
	methods: {
		getConfirm: function (formulario, event, perg, avis) {
			event.preventDefault()
			this.objConfirma = [
				{ mostra: "sim", evento: this.$refs[formulario], pergunta: perg, aviso: avis }
			]
		},
		openConfig: function () {
			if (this.abreConfigClass == "")
				this.abreConfigClass = "ativo"
			else
				this.abreConfigClass = ""

		}
	},

})