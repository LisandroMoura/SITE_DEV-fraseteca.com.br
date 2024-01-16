/* eslint-disable no-unused-vars */
// import _ from "lodash"
import {InputMagic} from "./Inputmagic"
import {Pesquisa} from "./Pastaspesquisa"
import _ from "lodash"  // how to import loadsh https://www.labnol.org/code/import-lodash-211117

//docs==> https://www.npmjs.com/package/emoji-picker-element
import "emoji-picker-element"

// import {Messenger} from './messenger.js'
// import {Upload} from "./messenger.js"

const Controller = {
	data:{        
		arrFrases:[],
		arrFrasesDelete:[],
		titulo:"",
		callback:""
	},
	props:{
		arrFrasesData:[]
	},
	preLoad(){
		this.loadDataJSON()
		let btAddNewItem = document.querySelector(".bt-addNewItem")
		if(btAddNewItem){
			btAddNewItem.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()
				Controller.addNewItem()
			}
		}
		Controller.triggersBtsFraseBox()
		Controller.triggerValidaAddNew()        
		let btUpdateTela = document.getElementById("btUpdateTela")
		if(btUpdateTela){
			btUpdateTela.onclick = (e) =>{
				Controller.updateArrayDoInputMagic()
			}
		}
		let btBuscarNoSite = document.getElementById("bt-buscar-no-site")
		if(btBuscarNoSite){
			btBuscarNoSite.onclick = (e) =>{ 
				e.stopPropagation()
				e.preventDefault()
				Pesquisa.abrePesquisa([])
			}
		}        
		let carregaResultadoPesquisa = document.getElementById("carregaResultadoPesquisa")
		if(carregaResultadoPesquisa){
			carregaResultadoPesquisa.onclick = (e) =>{ 
				e.stopPropagation()
				e.preventDefault()
				Controller.carregaPesquisa()
			}
		}
		let btSalvarPasta = document.getElementById("btSalvarPasta")
		if(btSalvarPasta){
			btSalvarPasta.onclick = (e) =>{ 
				e.stopPropagation()
				e.preventDefault()
				let process = Controller.verificaSePrecisaClicarEmCortar()                
				if (process){
					let btCortar = document.getElementById("btCortar")  
					if(btCortar){
						let cortar = new Promise((resolve, reject) => {
							btCortar.click()
						})
					}                    
				}                 
				let salvarBT = new Promise((resolve, reject) => {
					Controller.salvar()
				})                
			}
		}
		let btSalvarPastaFixed = document.getElementById("btSalvarPastaFixed")
		if(btSalvarPastaFixed){
			btSalvarPastaFixed.onclick = (e) =>{ 
				e.stopPropagation()
				e.preventDefault()                
				let process = Controller.verificaSePrecisaClicarEmCortar()                 
                
				if (process){                
					let btCortar = document.getElementById("btCortar")  
					if(btCortar){
						let cortar = new Promise((resolve, reject) => {
							btCortar.click()
						})
					}                    
				}                 
				let salvarBT = new Promise((resolve, reject) => {
					Controller.salvar()
				})                
			}
		}

		let openEmoji = document.querySelectorAll(".open-emoji")
		openEmoji.forEach(emoji => {
			emoji.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()
				Controller.toggleEmojis(e)
			}
		})

		let sairEmoji = document.querySelectorAll(".bt-sair-emoji")
		sairEmoji.forEach(botao => {
			botao.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()
				Controller.toggleEmojis("closeall")
			}
		})
		

		let emojiPickerArr = document.querySelectorAll("emoji-picker")

		emojiPickerArr.forEach(emojiPicker => {
			emojiPicker.addEventListener("emoji-click", event => {
				Controller.setaEmoji(event.detail.unicode,event)
			}) 
		})
        
	},
	toggleEmojis(e){
		if(e=="closeall"){
			let wrapper = document.querySelectorAll(".wrapper-emoji-picker")
			wrapper.forEach(element => {
				element.classList.remove("ativo")
			})
			let emoji = document.querySelectorAll("emoji-picker")
			emoji.forEach(element => {
				element.classList.remove("ativo")
			})
			return 
		}
		let dataId = e.target.getAttribute("data-id")
		let wrapper = document.querySelector(".wrapper-emoji-" + dataId)
		if (wrapper){
			wrapper.classList.toggle("ativo")
		}
		let emoji = document.querySelector(".picker-" + dataId)
		if (emoji){
			emoji.classList.toggle("ativo")
		}

		console.log()

	},
	setaEmoji(emoji,e){   
		let dataId = e.target.getAttribute("data-id")
		let tArea       = document.getElementById(dataId)
		let startPos    = tArea.selectionStart
		let endPos      = tArea.selectionEnd
		let cursorPos   = startPos
		let tmpStr      = tArea.value
		let insert      = emoji 

		if(!tArea) return
		tArea.value = tmpStr.substring(0, startPos) + insert + tmpStr.substring(endPos, tmpStr.length) 

		// let openEmoji = document.querySelector(".open-emoji." +  dataId)
		// if(openEmoji) {
		setTimeout(() => {
			cursorPos += insert.length
			tArea.selectionStart = tArea.selectionEnd = cursorPos
			Controller.toggleEmojis("closeall")
		}, 10)        
	// }
	},
	loadDataJSON(){
		let data = document.getElementById("arrFrasesData").innerHTML
		if(data) { 
			this.props.arrFrasesData = JSON.parse(data)            
			if(this.props.arrFrasesData.dados[0])
				this.montarArray(this.props.arrFrasesData.dados[0])
			Controller.titulo = this.props.arrFrasesData.titulo
		}
	},
	montarArray(props){
		//pegar os dados de frases
		Controller.data.arrFrases = props
		Controller.data.arrFrases = _.orderBy(Controller.data.arrFrases, ["ordem"], ["asc"])
	},
	triggerValidaAddNew(){
		let novaFrase = document.getElementById("novaFrase")
		let btAddNewItem = document.querySelector(".bt-addNewItem")
		if(novaFrase && btAddNewItem)
			novaFrase.addEventListener ("input", e => {
				if(novaFrase.getAttribute("minlength") < novaFrase.value.length ){
					btAddNewItem.classList.add("ok")
					btAddNewItem.classList.remove("nok")
				}                
				else {
					btAddNewItem.classList.remove("ok")
					btAddNewItem.classList.add("nok")
				}
			})
	},
	triggersBtsFraseBox(){
		//botoes Sobe e desce        
		let btsDesce = document.querySelectorAll(".bt_desce")
		if(btsDesce)
			btsDesce.forEach(botao => {
				botao.onclick = (e) =>{
					e.stopPropagation()
					e.preventDefault()
					Controller.trocaOrdem("desce",e.target.getAttribute("data-ordem"),e.target.getAttribute("data-index"))
				}
			})
 
		let btsSobe = document.querySelectorAll(".bt_sobe")
		if(btsSobe)
			btsSobe.forEach(botao => {
				botao.onclick = (e) =>{
					e.stopPropagation()
					e.preventDefault()
					Controller.trocaOrdem("sobe",e.target.getAttribute("data-ordem"),e.target.getAttribute("data-index"))
				}
			})

		let bttoggleImagem = document.querySelectorAll(".bt-action-toggle-imagem")
		if(bttoggleImagem){
			bttoggleImagem.forEach(botao => {
				botao.onclick = (e) =>{
					e.stopPropagation()
					e.preventDefault()
					Controller.toggleImagem(e,e.target.getAttribute("data-index"),e.target.getAttribute("data-id"))
				}
			})
		}
		let btExcluir = document.querySelectorAll(".bt-action-excluir")
		if(btExcluir){
			btExcluir.forEach(botao => {
				botao.onclick = (e) =>{
					e.stopPropagation()
					e.preventDefault()
					Controller.excluir(e,e.target.getAttribute("data-index"),e.target.getAttribute("data-id"))
				}
			})
		}
		let btEdit = document.querySelectorAll(".bt-edit-frase-fox")
		if(btEdit){
			btEdit.forEach(botao => {
				botao.onclick = (e) =>{
					e.stopPropagation()
					e.preventDefault()
					InputMagic.toggleApenasUm(e.target.getAttribute("data-id"), e.target.classList.contains("ativo"))
					Controller.toggleToolsEditFrase(e.target.getAttribute("data-id"))                    
				}
			})
		}
		let btCancel = document.querySelectorAll(".bt-action-cancelar")
		if(btCancel){
			btCancel.forEach(botao => {
				botao.onclick = (e) =>{
					e.stopPropagation()
					e.preventDefault()
					let dataId = e.target.getAttribute("data-id")
					let seletorF = document.querySelector(".magic-input-selector.frase_"+dataId)
					let seletorA = document.querySelector(".magic-input-selector.autor_"+dataId)
					let wrapperMagicInputFrase = document.getElementById("wrapper-magic-input_frase_"+dataId)
					let wrapperMagicInputAutor = document.getElementById("wrapper-magic-input_autor_"+dataId)
					InputMagic.cancelaValorDeImput("frase_"+e.target.getAttribute("data-id"),seletorF)                    
					InputMagic.cancelaValorDeImput("autor_"+e.target.getAttribute("data-id"),seletorA)
					Controller.toggleToolsEditFrase(e.target.getAttribute("data-id"))                    
					seletorF.classList.remove("hide")
					seletorA.classList.remove("hide")                    
					wrapperMagicInputFrase.classList.remove("show")
					wrapperMagicInputAutor.classList.remove("show")                    
				}
			})
		}
		let btSalvarFraseEditada = document.querySelectorAll(".bt-salvar-frase-editada")
		if(btSalvarFraseEditada){
			btSalvarFraseEditada.forEach(botao => {
				botao.onclick = (e) =>{
					e.stopPropagation()
					e.preventDefault()
					let dataId = e.target.getAttribute("data-id")
					let seletorF = document.querySelector(".magic-input-selector.frase_"+dataId)
					let seletorA = document.querySelector(".magic-input-selector.autor_"+dataId)

					InputMagic.attribSeletor("frase_"+dataId,seletorF)
					InputMagic.attribSeletor("autor_"+dataId,seletorA)                    
					InputMagic.toggleApenasUm(e.target.getAttribute("data-id"), e.target.classList.contains("ativo"))
					Controller.toggleToolsEditFrase(e.target.getAttribute("data-id"))                    
                    
				}
			})
		} 
        
	},
	clear(){
		let arrFrases = document.getElementById("arrFrases")
		if (arrFrases)
			arrFrases.innerHTML=""
	},
	toggleToolsEditFrase(id){
		let ulEdicao = document.getElementById("ul_edicao_"+ id)
		let ulView   = document.getElementById("ul_view_"+ id)
		if(ulEdicao){
			ulEdicao.classList.toggle("ativo")
			ulView.classList.toggle("ativo")
		}


	},
	recriarViewsFraseBox(mantemAtivo){
		Controller.clear()
		let index = 0
		let html = ""
		let head = "<div class=\"corpo-das-frases page-break com-recuo\">"
		let footer = "</div>"
		let arrLlength = Controller.data.arrFrases.length
		Controller.data.arrFrases.forEach(element => {
			html+=Controller.view(element, index,arrLlength)
			index++
		})
		let arrFrases = document.getElementById("arrFrases")
		arrFrases.innerHTML = head + html + footer
		InputMagic.preLoad()
		Controller.triggersBtsFraseBox()
		if(mantemAtivo)
			InputMagic.habilitaTudo()
		Controller.mudaStatus()        
	},
	view(dados, index,arrLlength){
		let ordenacao = ""  
		let classtoggleImage = ""
		let autor = dados.autor ? dados.autor : "sem autor"
		let autorValue = dados.autor ? dados.autor : ""
		let frase_id = dados.frase_id ? dados.frase_id : 0
		let noEdit = dados.frase_id ? "noEdit" : ""
		let classEditavel = dados.frase_id ? "" : "editavel"
		let classNova = dados.new ? "nova" : ""
		let ordemStr = ""
		if (autor == "null" || autor == null) {
			autor       = ""
			autorValue  =""
		}
		if(dados.id==9999999){
			classEditavel = "editavel"
			classNova = "nova"
		}
		ordemStr = dados.ordem   
		
		if(dados.ordem<=9){
			ordemStr = "0" + dados.ordem
		}
		if(Controller.testaSrcDeImagem(dados.capa))
			ordenacao = "comcapa"
		if (index>0 && index < arrLlength-1)
			ordenacao += " ambos "        
		if (dados.mostraimg=="1")    
			classtoggleImage = "ativo"        
		let view =`
        <div class="frase--box ${classEditavel} ${classNova} pastas">
            <div class="ordem-da-frase">${ordemStr}</div>            
            <div data-tipo="without-icon" data-indexid="${dados.id}"  data-index="${index}" data-id="frase_${dados.id}" data-fraseId="${frase_id}" class="magic-input-selector frase frase_${dados.id} ${noEdit}" id="txt_frase_${dados.id}">${dados.frase}</div>`
		if (!dados.frase_id)
			view +=`    
                <div data-tipo="without-icon" data-indexid="${dados.id}" class="magic-input-frame painel pagina pagina-usuario " id="wrapper-magic-input_frase_${dados.id}">            
                    <input id="ref_frase_${dados.id}" type="hidden" name="frase_${dados.id}" value="${dados.frase}">
                    <textarea name="frase_${dados.id}" id="frase_${dados.id}" data-index="${index}" placeholder="Digite aqui a sua ideia, a sua inspiração!" class="magic-input magic-input-frase">${dados.frase}</textarea>                    
                    <a class="magic-buttons bt-cancel-magic" data-target="frase_${dados.id}" id="bt-cancel-magic-frase_${dados.id}"><span class="ico ico-exit"></span></a>
                    <a class="magic-buttons bt-confirm-magic" data-target="frase_${dados.id}" id="bt-confirm-magic-frase_${dados.id}">ok</a>
                </div>`
		view +=`
            <div data-tipo="without-icon" data-indexid="${dados.id}" data-id="autor_${dados.id}" data-fraseId="${frase_id}" data-index="${index}" class="magic-input-selector autor_${dados.id} autor ${noEdit}">${autor}</div>`

		if (!dados.frase_id)
			view +=`
                <div data-tipo="without-icon" data-indexid="${dados.id}"  class="magic-input-frame autor_input without-icon" id="wrapper-magic-input_autor_${dados.id}">
                    <input type="text" data-index="${index}" ref="ref_autor_${dados.id}" id="autor_${dados.id}" class="magic-input autor_input magic-input-autor" name="autor_${dados.id}" placeholder="Nome do autor" value="${autorValue}">                    
                    <a class="magic-buttons bt-cancel-magic" data-target="autor_${dados.id}" id="bt-cancel-magic-autor_${dados.id}"><span class="ico ico-exit"></span></a>
                    <a class="magic-buttons bt-confirm-magic" data-target="autor_${dados.id}" id="bt-confirm-magic-autor_${dados.id}">ok</a>
                </div>`

		else {
			view +=`<input id="frase_${dados.id}" name="frase_${dados.id}" type="hidden" value="${dados.frase}">`
			view +=`<input type="hidden" data-index="${index}" ref="ref_autor_${dados.id}" id="autor_${dados.id}" class="magic-input autor_input magic-input-autor" name="autor_${dados.id}" placeholder="Nome do autor" value="${autorValue}">`
		}
                
		if (Controller.testaSrcDeImagem(dados.capa) && dados.mostraimg=="1" )
			view +=`<div class="frase_imagem">                
                    <img src="${dados.capa}" alt="${dados.frase}" width="auto" data-srcset="${dados.capa} 1070w, ${dados.capa} 443w" sizes="(max-width: 1070px) 100vw, 1070px" class="imagem-post lazy-hidden no-print">
                </div>`

		view +=`
            <div class="no-print">

                <div class="tools pastas">`
		view+=`
                    <ul id="ul_edicao_${dados.id}" class="frases_em_edicao ">                        
						<li>
							<a href="" 
								title="Salvar!"                                 
								data-id="${dados.id}"                                
								class="bt-salvar-frase-editada edit_id${dados.id} ativo">ok</a>
						</li>
						<li>
                            <a  href="#" title="Cancelar"
                                data-id="${dados.id}"
                                class="bt-action-cancelar item-tools excluir ativo">
                                <span class="ico ico-exit"></span>
                            </a>
                        </li>
                        
                    </ul>
                    `
		if (dados.frase_id){
			view +=`<ul id="ul_view_${dados.id}" class="pastas ativo">`
		}
		else {
			view +=`<ul id="ul_view_${dados.id}" class="pastas editavel ativo">`
		}
		view +=`
                        <li> `
		if (dados.frase_id)
			view +=`
                            <a href="#"
                            data-id="${dados.id}"
                            data-index="${index}"
                            title="Habilitar imagem da frase" id="bt-action-toggle-imagem" class="bt-action-toggle-imagem item-tools toggle ${classtoggleImage}"><span class="ico ico-imagem ${classtoggleImage}"></span></a>
                        </li>`
		else 
			view +=`
                        <li><a href="#"
                            data-id="${dados.id}"
                        	data-index="${index}"
                            title="Edite a sua frase!" 
                            id="bt-edit-frase-fox" class="bt-edit-frase-fox item-tools toggle-edit-frase ${classtoggleImage} edit_id${dados.id}"><span class="ico ico-lapis ${classtoggleImage}"></span></a>
                        </li><li><a href="#"
                            data-id="${dados.id}"
                            data-index="${index}"
                            title="Esta frase não possue imagem. Mas o sistema poderá gerá-la depois!" 
                            id="bt-no-action-toggle-imagem" class="bt-no-action-toggle-imagem item-tools toggle ${classtoggleImage}"><span class="ico ico-imagem ${classtoggleImage}"></span></a>
                        </li>`
		view +=`
                        <li>
                            <a href="#" title="Excluir esta frase" 
                            data-id="${dados.id}"
                            data-index="${index}"
                            id="bt-action-excluir" class="bt-action-excluir item-tools excluir"><span class="ico ico-exit"></span></a>
                        </li>
                    </ul>
                </div>
                <div class="ordenacao ${ordenacao}">
                    <ul>`
		if (index>0) 
			view +=`<li><a href="#" data-index="${index}" data-ordem="${dados.ordem}" class="bt_sobe" title="Sobe"><span class="ico ico-seta-acima"></span></a></li>`
		if(index < arrLlength-1)
			view +=`<li><a href="#" data-index="${index}" data-ordem="${dados.ordem}" class="bt_desce" title="Desce"><span class="ico ico-seta-baixo"></span></a></li>`
		view +=`</ul>
                </div>
            </div>
        </div>
        `
		return view
	},
	testaSrcDeImagem(capa){
		if (capa==null)
			return false

		if (capa=="")
			return false

		if(capa.indexOf("null") == 0)
			return false

		return true
	},    
	trocaOrdem(direct,ordemAtual,index){
		let isModoEdicao = Controller.isModoEdicao()

		if(isModoEdicao) 
			Controller.updateArrayDoInputMagic()

		index = parseInt(index)
		ordemAtual = parseInt(ordemAtual)

		if (direct=="sobe"){
			Controller.data.arrFrases[index-1].ordem = ordemAtual
			Controller.data.arrFrases[index].ordem = ordemAtual-1
		}
		else {
			//desce
			Controller.data.arrFrases[index+1].ordem = ordemAtual
			Controller.data.arrFrases[index].ordem = ordemAtual+1
		}
		Controller.data.arrFrases = _.orderBy(Controller.data.arrFrases, ["ordem"], ["asc"])

		Controller.recriarViewsFraseBox(isModoEdicao)        
	},
	addNewItem(){
		let novaFrase = document.getElementById("novaFrase")
		let novoAutor = document.getElementById("novoAutor")
		let inputPasta_id = document.getElementById("pasta_id")
        
		let newAutor = novoAutor.value ? novoAutor.value : "" 
		if (newAutor == "null") newAutor = "sem autor"

		if(novaFrase){
			let idOrdem=Controller.data.arrFrases.length+1  
            
			Controller.data.arrFrases.push({
				id:idOrdem,
				new:true,
				ordem:idOrdem,
				frase_id:0,
				frase:novaFrase.value,
				mostraimg:"0",
				pasta_id:parseInt(inputPasta_id.value),
				autor:newAutor,
				status:"0",
				capa:null,
				//0: normal, 1:add, 2:edit, 9:delete
				statusOnView:1                
			})
			novaFrase.value=""
			Controller.recriarViewsFraseBox(Controller.isModoEdicao())
		}
	},
	updateArrayDoInputMagic(){
		//precisa atualizar a frase e o autor que vem do InputMagic.js
		let mudouStatus = false
		let arrayMagicTextarea = document.querySelectorAll("textarea.magic-input-frase")
		if(arrayMagicTextarea){            
			arrayMagicTextarea.forEach(element => {
				if(Controller.data.arrFrases[element.getAttribute("data-index")].frase != element.value){
					Controller.data.arrFrases[element.getAttribute("data-index")].frase = element.value
					mudouStatus=true
				}
			})
		}
		let arrayMagicAutor = document.querySelectorAll("input.magic-input-autor")
		if(arrayMagicAutor){
			arrayMagicAutor.forEach(element => {
				if(Controller.data.arrFrases[element.getAttribute("data-index")].autor != element.value){
					Controller.data.arrFrases[element.getAttribute("data-index")].autor = element.value
					mudouStatus=true
				}                    
			})
		}
		let magicTitulo = document.querySelector("input.magic-input-titulo")
		if(magicTitulo){
			if (magicTitulo.value != Controller.titulo)
				mudouStatus=true            
		}

		if(mudouStatus)
			Controller.mudaStatus()
	},
	isModoEdicao(){
		let isEdicao = false
		let btModoEdicao = document.getElementById("bt-modo-de-edicao")
		if(btModoEdicao){
			if(btModoEdicao.classList.contains("ativo")){
				isEdicao=true
			}
		}
		return isEdicao
	},
	excluir(element,index, idData){
		Controller.data.arrFrasesDelete.push({
			id:Controller.data.arrFrases[index].id,
			pasta_id:parseInt(Controller.data.arrFrases[index].pasta_id),
			frase_id:Controller.data.arrFrases[index].frase_id,
			statusOnView:9
		})
		Controller.data.arrFrases.splice(index,1)
		let iOrdem = 1
		Controller.data.arrFrases.forEach(itemArr => {
			itemArr.ordem = iOrdem
			iOrdem++
		})
		Controller.recriarViewsFraseBox(Controller.isModoEdicao())

	},    
	toggleImagem(element,index, idData){        
		if(Controller.data.arrFrases[index].mostraimg=="0"){
			Controller.data.arrFrases[index].mostraimg = "1"

		}            
		else {
			Controller.data.arrFrases[index].mostraimg = "0"
		}
            
		element.target.classList.toggle("ativo")
		element.target.firstChild.classList.toggle("ativo")
		Controller.recriarViewsFraseBox(Controller.isModoEdicao())
		Controller.mudaStatus()
	},
	mudaStatus(status="precisa salvar"){
		let mudaStatus = document.getElementById("mudaStatus")
		if (mudaStatus){
			mudaStatus.innerHTML = status
			mudaStatus.classList.add("ativo")
		}

		let btSalvarPastaFixed = document.getElementById("btSalvarPastaFixed")
		if(btSalvarPastaFixed){
			btSalvarPastaFixed.classList.add("ativo")
		}

		Controller.atualisaNItens()
	},
	carregaPesquisa(){
		let arrDataPesquisa = document.getElementById("arrDataPesquisa").innerHTML
		if(arrDataPesquisa){
			let data = JSON.parse(arrDataPesquisa)            
			let idOrdem=Controller.data.arrFrases.length+1 
			let inputPasta_id = document.getElementById("pasta_id")
			let icont = 0
			data.dados[0].forEach(element => {
				Controller.data.arrFrases.push({
					id:0,
					new:true,
					ordem:idOrdem,
					frase_id:element.frase_id,
					frase:element.frase,
					mostraimg:"0",
					pasta_id:parseInt(inputPasta_id.value),
					autor:element.autor,
					status:"0",
					capa:element.capa,
					//0: normal, 1:add, 2:edit, 9:delete
					statusOnView:1
				})
				idOrdem++                
				icont++
			})
			Controller.recriarViewsFraseBox(Controller.isModoEdicao())
		}
	},
	atualisaNItens(){
		let arrLlength = Controller.data.arrFrases.length

		let nitens = document.getElementById("nitens")
		if(nitens){
			nitens.value = arrLlength
		}
		let arrItens = ""
		Controller.data.arrFrases.forEach(element => {                
			if(element.frase!=""){
				if (element.new)                
					arrItens +=  0 + "#elemento#" + element.ordem + "#elemento#" + element.frase_id + "#elemento#" + element.frase + "#elemento#" +  element.autor  + "#elemento#" + element.mostraimg + "#lista_itens#" 
				else
					arrItens +=  element.id + "#elemento#" + element.ordem + "#elemento#" + element.frase_id + "#elemento#" + element.frase + "#elemento#" +  element.autor  + "#elemento#" + element.mostraimg + "#lista_itens#" 
			}
                
		})
		//atualisa os itens da página
		let arrItemsTexarea = document.getElementById("arrItens")
		if(arrItemsTexarea)
			arrItemsTexarea.innerHTML = arrItens

		let arrFrasesDelete = document.getElementById("arrFrasesDelete")
		if(arrFrasesDelete){
			let arrFrases = ""
			Controller.data.arrFrasesDelete.forEach(element => {                
				arrFrases +=  element.id + ";" 
			})
			arrFrasesDelete.innerHTML = arrFrases
		}
	},
	verificaSePrecisaClicarEmCortar(){
		let imgPronta = document.getElementById("img-pronta")
		let cropjsZone = document.getElementById("cropjs-zone")

		if (!imgPronta || !cropjsZone) return false

		if(imgPronta.classList.contains("emedicao")) return true
		if(cropjsZone.classList.contains("emedicao")) return true
		return false
	},
	async salvar(){ 
        
		let formulario = document.getElementById("formulario")
		if(formulario){
			//validar alguma coisa, e submeter
			formulario.submit()
		}
	},
}
export {Controller}