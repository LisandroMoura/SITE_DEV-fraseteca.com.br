/* eslint-disable no-unused-vars */
const InputMagic = {    
	preLoad(){
		let magicInputSelector = document.querySelectorAll(".magic-input-selector")        
		if(magicInputSelector){
			magicInputSelector.forEach(seletor => {
				seletor.onclick = (e) => {
					e.stopPropagation()
					e.preventDefault()
					let btModoEdicao = document.getElementById("bt-modo-de-edicao")
					let dataId = e.target.getAttribute("data-id")                    

					let wrapper  = document.getElementById("wrapper-magic-input_" + dataId)
					if (wrapper) {
						//trigger do leave do opbjeto
						let input = document.getElementById(dataId)
						if(input){
							input.onblur = (e) =>{
								//se estiver no modo de edição
								if(btModoEdicao){
									if(btModoEdicao.classList.contains("ativo"))
										InputMagic.attribSeletor(dataId,seletor)                                        
								}   
							}
						}
						let btConfirm = document.getElementById("bt-confirm-magic-"+ dataId)
						if (btConfirm){                            
							btConfirm.onclick = (bt) => {
								bt.stopPropagation()
								bt.preventDefault()
								seletor.classList.remove("hide")
								wrapper.classList.remove("show")
								InputMagic.attribSeletor(dataId,seletor)
								InputMagic.toggleBtMagicOut()
							}
						}
						//triggers para cada wrapper de cada seletor - btCancel e btConfirm 
						let btCancel = document.getElementById("bt-cancel-magic-"+ dataId)
						if (btCancel){
							btCancel.onclick = (bt) => {
								bt.stopPropagation()
								bt.preventDefault()                                
								seletor.classList.remove("hide")
								wrapper.classList.remove("show")
								InputMagic.cancelaValorDeImput(dataId,seletor)
								InputMagic.toggleBtMagicOut()
							}
						}

						let dataTipo = e.target.getAttribute("data-tipo")
						let indexid  = e.target.getAttribute("data-indexid")

						if(dataTipo){
							if(dataTipo=="without-icon") {                                  
								let btEdit = document.querySelector(".bt-edit-frase-fox.edit_id"+indexid) 
								if(btEdit){
									btEdit.click()
									return 
								}
							}
						}
						InputMagic.toggleSeletor(dataId, seletor,"listner",wrapper,null,false)
					}
				}
			})
		}

		let btToggleTitle = document.querySelector(".bt-toggle-titulo")
		if(btToggleTitle){
			btToggleTitle.onclick = (e) => {
				e.stopPropagation()
				e.preventDefault()

				let dataId = e.target.getAttribute("data-id")  
				let h1 = document.querySelector("h1."+dataId)
				if(h1){
					h1.click()
				}
			}
		}

		let form  = document.getElementById("formulario")       
		let btSalvarPasta = document.getElementById("btSalvarPasta")

		let createTitleInput  = document.querySelector(".create-title-input")                
		if (createTitleInput){
			createTitleInput.addEventListener("paste", (e) => {
				let paste = (e.clipboardData || window.clipboardData).getData("text")
				InputMagic.validaNoCreate(createTitleInput, paste)
			})            
			createTitleInput.onblur = (e) => {
				InputMagic.validaNoCreate(e)
			}
		}
		//listners de teclas de atalhos
		document.body.addEventListener("keydown", e =>{
			e = e || window.event
			let key = e.which || e.keyCode // keyCode detection
			// eslint-disable-next-line no-unused-vars
			let ctrl = e.ctrlKey ? e.ctrlKey : ((key === 17) ? true : false) // ctrl detection        
			
			
			if ( key == 13 ) { //enter                
				if (e.target.getAttribute("id") != "pesquisar" && 
                ! e.target.classList.contains("pesquisar") ){
					e.stopPropagation()
					e.preventDefault()                    
				}                
				InputMagic.validaNoCreate(e)
				let dataId = e.target.getAttribute("id")
				let btConfirm = document.getElementById("bt-confirm-magic-"+ dataId)
				if(btConfirm)
					btConfirm.click()  
				let seletor  = document.querySelector(".create-title-input")    
				


				if (seletor)
					if (btSalvarPasta)
						if(!btSalvarPasta.classList.contains("nok"))
							btSalvarPasta.click()
                
			}
			if ( key == 27 ) { //ESC                
				let dataId = e.target.getAttribute("id")
				let btCancel = document.getElementById("bt-cancel-magic-"+ dataId)
				if(btCancel)
					btCancel.click()
			}
			//validar o tuitulo na criação..
			if (form){                     
				if(form.classList.contains("form-create")){                
					let seletor  = document.querySelector(".create-title-input")
					if (seletor){                              
						if(e.target.id=="titulo"){ 
							if(e.target.value !="" && e.target.value.length > 0)
								btSalvarPasta.classList.remove("nok")
							else 
								btSalvarPasta.classList.add("nok")
						}
					}    
				}
			} 
		})         
	},
	toggleApenasUm(dataId, toogle){
		//seletor Frase        
		let seletorF = document.querySelector(".magic-input-selector.frase_" + dataId)
		let wrapperF  = document.getElementById("wrapper-magic-input_frase_" + dataId)

		let input = document.getElementById("frase_"+dataId)
		let height = seletorF.offsetHeight


		if(input)
			if(height > 30) 
				input.setAttribute ("style", "height: "+height+"px;") 


		if (wrapperF){        
			if(toogle){
				seletorF.classList.remove("hide")
				wrapperF.classList.remove("show")
				wrapperF.classList.remove("hide-buttons")
				InputMagic.attribSeletor("frase_"+dataId,seletorF)

			}
			else{
				seletorF.classList.add("hide")
				wrapperF.classList.add("show")
				wrapperF.classList.add("hide-buttons")
			}            
		}
		//seletor autor
		let seletorA = document.querySelector(".magic-input-selector.autor_" + dataId)
		let wrapperA  = document.getElementById("wrapper-magic-input_autor_" + dataId)
		if (wrapperA){            
			if(toogle){
				seletorA.classList.remove("hide")
				wrapperA.classList.remove("show")
				wrapperA.classList.remove("hide-buttons")
				InputMagic.attribSeletor("autor_"+dataId,seletorA)

			}
			else{
				seletorA.classList.add("hide")
				wrapperA.classList.add("show")
				wrapperA.classList.add("hide-buttons")
			}            
		}
	},
	habilitaTudo(){
		let magicInputSelector = document.querySelectorAll(".magic-input-selector")
		if(magicInputSelector){
			magicInputSelector.forEach(seletor => {           
				let dataId = seletor.getAttribute("data-id")
				let wrapper  = document.getElementById("wrapper-magic-input_" + dataId)
				if (wrapper){
					seletor.classList.add("hide")                    
					wrapper.classList.add("show")
					wrapper.classList.add("hide-buttons")
				}               
			})
		}
	},

	desabilitaTudo(){
		let magicInputSelector = document.querySelectorAll(".magic-input-selector")
		if(magicInputSelector){
			magicInputSelector.forEach(seletor => {                
				let dataId = seletor.getAttribute("data-id")
				let wrapper  = document.getElementById("wrapper-magic-input_" + dataId)
				if (wrapper){
					seletor.classList.remove("hide")
					wrapper.classList.remove("show")
					wrapper.classList.remove("hide-buttons")
					InputMagic.attribSeletor(dataId,seletor)
				}               
			})
		}
        
	},
    
	toggleSeletor(dataId,seletor,tipo,wrapper,callBack,manterAtivo){        
		//let wrapper  = document.getElementById("wrapper-magic-input_" + dataId)
		let input = document.getElementById(dataId)
		let height = seletor.offsetHeight

		if (wrapper) {
			if(manterAtivo){
				seletor.classList.remove("hide")
				wrapper.classList.add("show")
			}else {
				seletor.classList.toggle("hide")
				wrapper.classList.toggle("show")                
			}
			if(input){
				input.setAttribute ("style", "height: "+height+"px;") 
				input.focus()

				InputMagic.toggleIcone(dataId)

				if (input.classList.contains("com-botoes-magic-out"))
					InputMagic.toggleBtMagicOut()
				//aki, verificar se o tipo de seletor é de habilitar fora
			}
		}    
	},
	toggleBtMagicOut(){        
		let colBtOptions = document.querySelector(".botoes-form-wrapper.to-hide-in-edit")
		if (colBtOptions){
			colBtOptions.classList.toggle("ativo")
		}
		let colBtMagicOut = document.querySelector(".coluna-botoes-magic-out.to-show-in-edit")
		if (colBtMagicOut){
			colBtMagicOut.classList.toggle("ativo")
		}
	},
	toggleIcone(dataId){

        
		let icon = document.querySelector(`span.ico.ico-lapis.${dataId}`)        
		if(icon){
			icon.classList.toggle("hide")
		}
	},
	attribSeletor(dataId,seletor){        
		let input = document.getElementById(dataId)        
		if (input)            
            
			if (input.value) {                
				seletor.innerHTML = input.value   
				InputMagic.toggleIcone(dataId)             
				let btUpdateTela = document.getElementById("btUpdateTela")
				if(btUpdateTela){
					btUpdateTela.click()
				}
				InputMagic.validaNoCreate(seletor)                
			}
	},    
	cancelaValorDeImput(dataId,seletor){
		let input = document.getElementById(dataId)
		if (input)
			if (input.value){
				input.value = seletor.innerHTML   
				InputMagic.toggleIcone(dataId)
			}
	},
	triggerBtsModo(dataId){
		let botoesDeModo = document.querySelectorAll("."+dataId)        
		botoesDeModo.forEach(item => {
			item.classList.toggle("ativo")            
		})
	},
	sairBtsModo(dataId){
		let botoesDeModo = document.querySelectorAll("."+dataId)        
		botoesDeModo.forEach(item => {
			item.classList.remove("ativo")
		})
	},
	validaNoCreate(e,paste = ""){
		let btSalvarPasta = document.getElementById("btSalvarPasta")
		let valor = ""
        
		if(btSalvarPasta) {                          
			if (e instanceof KeyboardEvent){                       
				if(e.target.id=="titulo"){ 
					if(e.target.value !="")
						btSalvarPasta.classList.remove("nok")
					else 
						btSalvarPasta.classList.add("nok")
				}
			}
			else {
				if(paste!=""){
					btSalvarPasta.classList.remove("nok")
					return
				}                     
				if (e.nodeName=="H1" || e.nodeName=="H2" || e.nodeName=="DIV"){
					valor = e.innerHTML
				}
				else {
					valor = e.value ?  e.value: e.target.value
				}
				if(valor !="")
					btSalvarPasta.classList.remove("nok")
				else 
					btSalvarPasta.classList.add("nok") 
			}            
		}

	}

}
export {InputMagic}
