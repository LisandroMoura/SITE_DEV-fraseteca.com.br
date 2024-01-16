window.mixin = {
	data: {  
		objConfirma: [{mostra:"nao", evento:"", pergunta:"", aviso:"", titulo:"", lbconfirma:"", lbcancela:""}],         
		objetoRetornoMSG:[{classe: "card fade-out", obj:""}],   
		//custom
		labreMenu:"", 
		labreMenuPerfil:"", 
		labrePesquisa:"",       
		labreSidebar:"", 
        
	},
	methods:{
		fecharMensagem(e){
			let mensagem = document.querySelector("#mensagem")
			mensagem.classList.add("fechar")

			exec = setTimeout(function (){
				let app = document.querySelector("#app")  
				app.removeChild(mensagem)
			}, 1000)
		},
		abreSidebar(){
			if (this.labreSidebar == "ativado"){
				this.labreSidebar = ""
				this.$refs.ref_sidebar.setAttribute("class","normal")
				this.$refs.ref_botao.setAttribute("class","normal")
			}
			else{
				this.labreSidebar = "ativado"
				this.$refs.ref_sidebar.setAttribute("class","ativado")
				this.$refs.ref_botao.setAttribute("class","ativado")
			}                
		},
		abreMenu(){if(this.labreMenu=="ativado")this.labreMenu = "";else this.labreMenu = "ativado"},
		abrePesquisa(){if(this.labrePesquisa=="ativado")this.labrePesquisa = "";else this.labrePesquisa = "ativado"},
		abreMenuPerfil(){            
			if(this.labreMenuPerfil=="ativado")this.labreMenuPerfil = "";else this.labreMenuPerfil = "ativado"
		},                
		validaTamanho: function(event) {
			let conta = event.currentTarget.value.length            
			let limite = 0            
			this.$refs.ref_conta.innerHTML = conta            
			limite = this.$refs.ref_limite.innerHTML
			if(conta >= limite){               
				//event.currentTarget.setAttribute('class','red')               
				event.currentTarget.value = event.currentTarget.value.substr(0, limite)
				this.$refs.ref_conta.setAttribute("class","red")
				this.$refs.ref_limite.setAttribute("class","red")
			} else{                
				//event.currentTarget.setAttribute('class','')
				this.$refs.ref_conta.setAttribute("class","")
				this.$refs.ref_limite.setAttribute("class","")
			}           
		},       

	}
}

window.axios = require("axios")
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest"

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector("meta[name=\"csrf-token\"]")

if (token) {
	window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content
} else {
	//console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

require("./lazy")

// //função externa
// window.teste = function (event){
//     //
// };