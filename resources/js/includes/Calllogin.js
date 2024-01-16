import { Modal } from "./Modal"

const CallLogin = {
	data:{
		action:"",
		callback:"",
		callbackCancel:""
	},
	preLoad(){
		let callLogin = document.querySelectorAll(".callLogin")
		let botao = document.querySelector(".ref_call_login")
		callLogin.forEach(element => {
			element.onclick = function(e) { 
				e.stopPropagation()
				e.preventDefault()   

				let perg = e.target.title || "Para salvar este conteúdo, você precisa ter cadastro e fazer login. Deseja fazer Login?"
				let titHeader  = e.target.getAttribute("data-header") || "Faça Login"
				let lblBtconfirm = e.target.getAttribute("data-lblBtconfirm") || "Faça login"
				let lblBtcancel = e.target.getAttribute("data-lblBtcancel") || "Faça login"

				CallLogin.openView(botao, perg, titHeader, lblBtconfirm, lblBtcancel, null,null)
			}
		})
	},

	openView(
		botao, 
		perg=null, 
		titHeader = null, 
		lblBtconfirm = "Confirma", 
		lblBtcancel = "Cancela", 
		cb = null, 
		callbackCancel = null
	){        
		this.limpaTudo()
		Modal.view()

		let header = " <div class=\"wrapper-modal-dialog ativo default \">"
		let footer = "</div>"        
		let htmlConfirmaJS = `
        <header>${titHeader}
            <a class="botao-fechar-dialog abreCompartilhar icone-fechar"><i class="ico ico-fechar"></i></a>
        </header>
        <div class="conteudo">
            <div class="box texto">
                <span>
                    ${perg}
                </span>
            </div>
            <div class="box botoes">
                <a id="bt_confirmar_ok" class="pointer bt_confirmar true">
                    <span>${lblBtconfirm}</span>
                </a>
                <a id="bt_cancelar" class="pointer bt_cancelar false">
                    <span>${lblBtcancel}</span>
                </a>
            </div>
        </div>
        `
		let ConfirmaJS = document.createElement("div")
		ConfirmaJS.id="confirma"
		ConfirmaJS.classList.add("container")            
		ConfirmaJS.classList.add("vue-js-component")            
                    
		ConfirmaJS.innerHTML   = header+htmlConfirmaJS+footer
        
		let app = document.querySelector("#app")            
		app.appendChild(ConfirmaJS)

		let btFechar = document.querySelector("#bt_cancelar")
		btFechar.addEventListener("click", this.fecharConfirma)

		let iconeFechar = document.querySelector(".icone-fechar")
		iconeFechar.addEventListener("click", this.fecharConfirma)


		CallLogin.data.action=botao
		CallLogin.data.callback=cb
		CallLogin.data.callbackCancel=callbackCancel        
		let btConfirmaOk = document.querySelector("#bt_confirmar_ok")
		btConfirmaOk.addEventListener("click", CallLogin.itsOk)

		return true
        
	},
	limpaTudo(){        
		let mensagem = document.querySelector("#confirma")            
		if(mensagem){
			mensagem.parentElement.removeChild(mensagem)                
		}
		Modal.closeAll()
        
	},
	fecharConfirma(){            
		let confirma = document.querySelector("#confirma")
		confirma.classList.add("fechar")

		Modal.closeAll()
		// eslint-disable-next-line no-unused-vars
		let exec = setTimeout(function (){
			let app = document.querySelector("#app")  
			app.removeChild(confirma)
			if(CallLogin.data.callbackCancel)
				CallLogin.data.callbackCancel()
		}, 200)
        
	},
	itsOk(){                    
		//preciso criar um formulário na página para ir para o login com o methodo GET        
		if(CallLogin.data.callback) {        
			CallLogin.data.callback.submit()
		}
		else{
			CallLogin.data.action.click()
		}
		Modal.closeAll()
	},

}

export {CallLogin}