window.validator = {
	data: {          
		//custom      
	},         
	methods:{        
		//methodo principal de entrada
		validatorJS(titulo=null, texto = null, campos = null, tipo="atencao"){

			this.validatorLimpaTudo(tipo)
            
			let htmlValidatorJS = `                        
                <div class='corpo-da-mensagem ${tipo}'>
                    <img src='/img/semaforo_amarelo.png'>
                    <strong>${titulo} </strong> ${texto}
                    <a title='Fechar esta opção.' id="fechar-${tipo}"
                     class='bt-fechar-msg'>
                        <i class='icon-fechar-fino-preto icon-cancel icon icone icon-x'></i>
                    </a>
                </div>`            
			if (tipo=="sucesso"){
				htmlValidatorJS = `                        
                <div class='corpo-da-mensagem ${tipo}'>
                    <img src='/img/semaforo_verde.png'>
                    <strong>${titulo} </strong> ${texto}
                    <a title='Fechar esta opção.' id="fechar-${tipo}"
                     class='bt-fechar-msg'>
                        <i class='icon-fechar-fino-branco icon-cancel icon icone icon-x'></i>
                    </a>
                </div>`
			}
			if (tipo=="erro"){
				htmlValidatorJS = `                        
                <div class='corpo-da-mensagem ${tipo}'>
                    <img src='/img/semaforo_vermelho.png'>
                    <strong>${titulo} </strong> ${texto}
                    <a title='Fechar esta opção.' id="fechar-${tipo}"
                     class='bt-fechar-msg'>
                        <i class='icon-fechar-fino-branco icon-cancel icon icone icon-x'></i>
                    </a>
                </div>`
			}
             
			let validatorJs = document.createElement("div")
			validatorJs.id="mensagem"
			validatorJs.classList.add(tipo)            
                        
			validatorJs.innerHTML   = htmlValidatorJS         

			let app = document.querySelector("#app")            
			app.appendChild(validatorJs)
			let btFechar = document.querySelector(`#fechar-${tipo}`)
			btFechar.addEventListener("click", this.fecharMensagem)

			if(campos){
				Object.keys(campos).forEach( campo => {
					this.validatorJSInput(campo, campos[campo])
				})
			}
            
			return true

		},
		validatorLimpaTudo(tipo){
			//limpando as caixas de Mensagens
			let mensagem = document.querySelector("#mensagem")            
			if(mensagem){
				mensagem.parentElement.removeChild(mensagem)                
			}
			//removendo validatorSys            
			let validatorSys = document.querySelectorAll(".validatorSys")
			if(validatorSys.length > 0){
				validatorSys.forEach(elemento => {
					elemento.innerHTML=""                  
				})
			}

			//memovendo ValidatorJS
			let objetosRemover = document.querySelectorAll(".validatorRemove")
			if(objetosRemover.length > 0){
				objetosRemover.forEach(elemento => {
					elemento.parentElement.removeChild(elemento)                    
				})
			}
			//Limpando
			let objetosClear = document.querySelectorAll(".validatorClear")
			if(objetosClear.length > 0){
				objetosClear.forEach(elemento => {
					elemento.classList.remove(tipo)                    
				})
			}
		},
		fecharMensagem(e){
			let mensagem = document.querySelector("#mensagem")
			mensagem.classList.add("fechar")

			exec = setTimeout(function (){
				let app = document.querySelector("#app")  
				app.removeChild(mensagem)
			}, 1000)
		},
	},
	listners:{
		load(){            
			let self = this   
			/**
             * btFecharMensagem
             /****************************************************************** */
			let btFecharMensagem = document.querySelectorAll(".btFecharMensagem")             
			btFecharMensagem.forEach(function(item){
				item.onclick = function(e) {
					e.stopPropagation()
					e.preventDefault()
					window.validator.methods.fecharMensagem(e)
				}
			})                     
		},
	},
}
window.validator.listners.load()