const Modal = {
	data: {          
		executar:null,         
	},
	preLoad(){
		document.body.addEventListener("keydown", e =>{
			e = e || window.event
			let key = e.which || e.keyCode // keyCode detection

			// let ctrl = e.ctrlKey ? e.ctrlKey : ((key === 17) ? true : false) // ctrl detection
            
			if ( key == 27 ) { //ESC
				Modal.closeAll()
			}

			// if ( key == 112 ) { //F1 press
			//     e.preventDefault();
                
			// }
			// if ( key == 113 ) { //F2 Press
			//     e.preventDefault();                
			// } 

			// if ( key == 115 ) { //F4 Press
			//     e.preventDefault();                
			// } 

		})
		// let mensagem = document.querySelector("#mensagem")
		// if(!mensagem)
		//     return 
		// let btFecharMensagem = document.querySelectorAll(".bt-fechar-msg")        
		// btFecharMensagem.forEach(item => {
		//     item.onclick = (e) => {
		//         e.stopPropagation()
		//         e.preventDefault()  
		//         Messenger.fecharMensagem()                 
		//     }            
		// });
		// Messenger.timerFechar()
	},

	// eslint-disable-next-line no-unused-vars
	view(texto = null, tipo="atencao"){
		this.limpar()
		
		let html = `
            <div class='modal--wrapper ${tipo}'>
                <a title='Fechar esta opção.' class='bt-fechar'></a>            
            </div>` 
        
		let objeto = document.createElement("div")
		objeto.id="modal"
		objeto.classList.add(tipo)                                
		objeto.innerHTML   = html         

		let app = document.querySelector("#before")       
		
		if (app) app.appendChild(objeto)
		let modal = document.querySelector("#modal")
		modal.addEventListener("click", Modal.closeAll)

	},
	closeAll(){
		Modal.remove(".modal","ativado")
		Modal.remove(".abreMenuUsuario_desk","ativado")
		Modal.remove(".menu-usuario-perfil_desk","ativado")
		Modal.remove(".abreMenuUsuario_mobile","ativado")
		Modal.remove(".menu-usuario-perfil_mobile","ativado")
		Modal.remove(".tool-salvar__criar_pasta","ativado")  
		Modal.remove(".tool.tool-salvar","ativado")
		Modal.remove(".modal_salvar","ativado")      
		Modal.remove(".wrapper--compartilhar","ativado")  
		Modal.remove(".wrapper-modal-dialog","ativo")  
		Modal.limpar()


	},        
	remove(target, classe){      
		let item = document.querySelector(target)         
		if(item) item.classList.remove(classe)
		const vforItem = document.querySelectorAll(target)
		vforItem.forEach(element => {
			element.classList.remove(classe)
		})
		if(item){
			if(!item.classList.contains("abreMenuUsuario_desk") &&!item.classList.contains("wrapper--compartilhar") && !item.classList.contains("menu-usuario-perfil_desk"))
				item.parentElement.removeChild(item)
		}
	},
	limpar(){
		let modal = document.querySelector("#modal")
		if (modal) modal.parentElement.removeChild(modal)
	}    
}
export {Modal}
