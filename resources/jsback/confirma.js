window.confirma = {
	data: {          
		//custom     
		action:"" 
	},         
	methods:{        
		//methodo principal de entrada
		getConfirm: function ( event, perg, avis, tit ) {
			this.htmlConfirma(event,perg, avis, tit)
		},         
		htmlConfirma(botao, perg=null, avis = null, tit = null){
			this.limpaTudo()
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
                <div class="box botoao ${avis}">
                    <a id="bt_confirmar_ok" class="pointer botao-padrao border-red true ">
                        <span>Confirma</span>
                    </a>
                    <a id="bt_cancelar" class="botao-padrao pointer bt_cancelar false ">
                            <span>Cancela</span>
                        </a>
                </div>
            </div>
            
            `
			let ConfirmaJS = document.createElement("div")
			ConfirmaJS.id="confirma"
			ConfirmaJS.classList.add("container")            
			ConfirmaJS.classList.add("vue-js-component")            
                        
			ConfirmaJS.innerHTML   = header+htmlConfirmaJS+footer

			//aqui, é que temos que rever, onde vamos colocar o objeto no doom
			let app = document.querySelector("#app")            
			app.appendChild(ConfirmaJS)

			let btFechar = document.querySelector("#bt_cancelar")
			btFechar.addEventListener("click", this.fecharConfirma)

			window.confirma.data.action=botao
			let btConfirmaOk = document.querySelector("#bt_confirmar_ok")
            
			btConfirmaOk.addEventListener("click", this.itsOk)
			return true

		},
		itsOk(e){            
			window.confirma.data.action.click()
		},

		limpaTudo(){
			//limpando as caixas de Mensagens
			let mensagem = document.querySelector("#confirma")            
			if(mensagem){
				mensagem.parentElement.removeChild(mensagem)                
			}
            
		},
		fecharConfirma(e){            
			let confirma = document.querySelector("#confirma")
			confirma.classList.add("fechar")

			exec = setTimeout(function (){
				let app = document.querySelector("#app")  
				app.removeChild(confirma)
			}, 200)
		},
	},
	listners:{
		load(){            
			let self = this                        
		},
	},
}
window.confirma.listners.load()
  