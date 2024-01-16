import { Modal } from "./Modal"

const CallConfirm = {
	data:{
		action:"",
		callback:""
	},
	preLoad(){
		// let CallConfirm = document.querySelectorAll(".CallConfirm")
		// let bt_login = document.querySelector(".ref_call_login")
		// CallConfirm.forEach(element => {
		//     element.onclick = function(e) { 
		//         let title = e.target.title || "Para salvar este conteúdo, você precisa ter cadastro e fazer login. Deseja fazer Login?"
		//         e.stopPropagation();
		//         e.preventDefault();                
		//         CallConfirm.openView(bt_login, title, "confirma info", "Que tal fazer login?")
		//     }
            
		// });

	},
	openView(botao, perg=null, tipo = null, tit = null, form = null, cb = null, confirmar = "Confirma" , cancelar = "Cancelar",classBt=""){
		this.limpaTudo()
		Modal.view()

		
		let header = "<div class=\"wrapper-modal-dialog ativo default \">"
		let footer = "</div>" 
	
		let htmlConfirmaJS = `
        <header>${tit}
            <a class="botao-fechar-dialog abreCompartilhar icone-fechar"><i class="ico ico-fechar"></i></a>
        </header>
        <div class="conteudo">
            <div class="box texto">
                <span>
                    ${perg}
                </span>
            </div> 
			<div class="box botoao ${tipo}">
                <a id="bt_confirmar_ok" class="pointer botao-padrao border-red true ${classBt}">
                    <span>${confirmar}</span>
                </a>
				<a id="bt_cancelar" class="botao-padrao pointer bt_cancelar false ${tipo}">
						<span>${cancelar}</span>
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

		CallConfirm.data.action=botao
		CallConfirm.data.callback=cb
		let btConfirmaOk = document.querySelector("#bt_confirmar_ok")
        
		btConfirmaOk.addEventListener("click", CallConfirm.itsOk)
		return true
        
	},
	limpaTudo(){        
		let mensagem = document.querySelector("#confirma")            
		if(mensagem){
			mensagem.parentElement.removeChild(mensagem)                
		}
		Modal.closeAll()
        
	},
	fecharConfirma(e){            
		let confirma = document.querySelector("#confirma")
		confirma.classList.add("fechar")
		Modal.closeAll()
		let exec = setTimeout(function (){
			let app = document.querySelector("#app")  
			app.removeChild(confirma)
		}, 200)
	},
	itsOk(e){                    
		//preciso criar um formulário na página para ir para o login com o methodo GET
		CallConfirm.data.action.submit()
		Modal.closeAll()
	},


}

export {CallConfirm}