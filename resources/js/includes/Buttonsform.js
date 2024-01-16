import {InputMagic} from "./Inputmagic"
import {CallConfirm} from "./Callconfirm"
import {JSController} from "./jspuload/Controller"
const ButtonsForm = {
	preLoad(){
		let buttons = document.querySelectorAll(".botoes-form-item")
		buttons.forEach(item => {		
			item.onclick = (e) => {
				e.stopPropagation()
				e.preventDefault()
				if(item.classList.contains("magic")){
					if(item.classList.contains("ativo"))
						InputMagic.desabilitaTudo()
					else
						InputMagic.habilitaTudo()
				}

				if(item.classList.contains("view-pasta")){
					ButtonsForm.toogleViewpasta("toggle")
				}

				ButtonsForm.toggle(item)
				if(item.classList.contains("config")){
					ButtonsForm.toogleMenuConfig("toggle")
				}
			}
		})
		let butClear = document.getElementById("clear")
		if (butClear){
			butClear.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()
				let arrFrases = document.getElementById("arrFrases")
				if (arrFrases)
					arrFrases.innerHTML=""
			}
		}
		let butClicaFora = document.querySelector(".menu-config-clica-fora")
		if (butClicaFora){
			butClicaFora.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()
				ButtonsForm.toogleMenuConfig("sair")                
			}
		}
		let butClicaForaViewPasta = document.querySelector(".menu-view-pasta-clica-fora")
		if (butClicaForaViewPasta){
			butClicaForaViewPasta.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()                
				ButtonsForm.toogleViewpasta("sair")
			}
		}
		const btConfigItens = document.querySelectorAll(".item-menu-config")
		if (btConfigItens){
			btConfigItens.forEach(item => {
				item.onclick = (e) => {                    
					if (!item.classList.contains("alterarCapa")){ 
						e.stopPropagation()
						e.preventDefault()
					}
                    
					if (item.classList.contains("tornarPublica")){
						//pegar o formId e submeter 
						let form = document.getElementById("formPublicar")
						if (form)
							form.submit()
					}
					if (item.classList.contains("alterarCapa")){                        
						//pegar o id do botao de editar a capa e clicar                        
						ButtonsForm.toogleMenuConfig("sair")
						JSController.showJSController("pastas")
					}
					
					if (item.classList.contains("deletar")){    
						let form = document.getElementById("formDeletar")
						if (form){
							let dataTipo = e.target.getAttribute("data-tipo")
							let tipo = "center"
							let bt_confirma = document.querySelector("#formDeletar")                                                
							let title = e.target.title || "Após excluído, o registro não poderá ser restaurado"
							let title_header = "Tem Certeza?"
							if(dataTipo){
								if(dataTipo=="direto"){
									bt_confirma.submit()
									return
								}
							}
							CallConfirm.openView(bt_confirma, title, tipo, title_header,form,ButtonsForm.toogleMenuConfig("sair"), "Excluir")                            
						}                     
					}
				}
			})
		}
	},
	toggle(item){
		item.classList.toggle("ativo")
		let ico = item.firstElementChild
		if (ico){
			ico.classList.toggle("ativo")
		}
	},
	desativar(target) {
		let button = document.querySelector(".botoes-form-item."+ target)        
		if (button) {
			ButtonsForm.toggle(button)
		}
	},
	toogleMenuConfig(action = null){
		let wrapper = document.querySelector(".wrapper-menu-config")
		if (wrapper){
			wrapper.classList.toggle("ativo")

			if (action=="sair"){
				let btConfig = document.querySelector(".botoes-form-item.config")
				if (btConfig){
					ButtonsForm.toggle(btConfig)
				}
			}
		}
	},
	toogleViewpasta(action = null){
		let wrapper = document.querySelector(".wrapper-menu-view-pasta")
		if (wrapper){
			wrapper.classList.toggle("ativo")
			if (action=="sair"){
				let btConfig = document.querySelector(".botoes-form-item.view-pasta")
				if (btConfig){
					ButtonsForm.toggle(btConfig)
				}
			}
		}
	},

}
export {ButtonsForm}