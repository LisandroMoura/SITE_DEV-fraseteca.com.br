import { Messenger } from "./Messenger"
import { Modal } from "./Modal"
require("../includes/Axios")
const Salvar = {
	data: {
		arrFrases: [],
		preselect: [],
		dados: [],
		pastaEmUso: "Frases",
		pastaIdEmUso: 0,
	},
	props: {
		arrPastasData: []
	},
	preLoad()
	{
		this.loadDataJSON()
		let fraseFavorita = document.querySelectorAll(".fraseFavorita")
		if (fraseFavorita)
			fraseFavorita.forEach(item => {
				item.onclick = (e) => {
					e.stopPropagation()
					e.preventDefault()
					if (e.target.attributes.data.nodeValue == "go")
						Salvar.view(e.target.attributes.idData.nodeValue)
				}
			})

		let modals = document.querySelectorAll(".modal_salvar")
		if (modals)
			modals.forEach(item => {
				item.onclick = (e) => {
					e.stopPropagation()
					e.preventDefault()
					Salvar.fechar(e.target.attributes.idData.nodeValue)
				}
			})
	},
	loadDataJSON() 
	{
		let data = document.getElementById("arrPastasData")
		if (!data) return
		data = data.innerHTML
		if (data) {
			this.props.arrPastasData = JSON.parse(data)
			if (this.props.arrPastasData.dados[0]) {
				Salvar.data.preselect = this.props.arrPastasData.dados[0]
				Salvar.data.dados = this.props.arrPastasData.dados[0]
			}
			Salvar.data.dados.forEach(element => {
				if (element.emuso == "1" || Salvar.data.dados.length == 1) {
					Salvar.data.pastaEmUso = element.titulo
					Salvar.data.pastaIdEmUso = element.id
				}
			})
		}
	},
	view(id) 
	{
		let isView = document.getElementById("salvar_" + id)
		let modal = document.getElementById("modal_salvar_" + id)
		if (isView) {
			if (isView.classList.contains("ativado")) {
				isView.classList.remove("ativado")
				modal.classList.remove("ativado")
			}
			else {
				isView.innerHTML = ""
				Salvar.createHtmlSelect(id, isView)
				isView.classList.add("ativado")
				modal.classList.add("ativado")
			}
		}
	},
	refreshPreselect(newItem = null)
	{
		Salvar.data.preselect = []
		Salvar.data.preselect = Salvar.data.dados
		if (newItem) {
			Salvar.data.preselect.push({
				id: "newitem",
				new: true,
				titulo: newItem,
				frase_id: 0,
				pasta: "",
				descricao_previa: "newItem",
				emuso: "1"
			})
		}
	},
	createHtmlSelect(id, view)
	{
		let html = `<header>Salvando em...<a class="botao-fechar-dialog bt_close_modal" idData="${id}"><i class="ico ico-fechar"></i></a></header><div class="form"><select id="selec_${id}">`
		Salvar.data.preselect.forEach(element => {
			if (element.emuso == "1") {
				html = html + `<option class="selected" data-name="${element.titulo}" selected value="${element.id}">${element.titulo}</option>`
			} else if (element.id == "newitem") {
				html = html + `<option class="newitem" value="999999">${element.titulo}</option>`
			} else {
				html = html + `<option data-name="${element.titulo}" value="${element.id}">${element.titulo}</option>`
			}
		})
		html = html + `</select>
        <button class="botao-padrao red bt_salvar_no_select"  idData="${id}">Salvar</button></div>
        `
		html = html + `<div class="options"><a class="bt_new_no_select" idData="${id}"> <span>Criar nova pasta</span></a></div>`

		const div = document.createElement("div")
		div.id = "selected_" + id
		div.classList.add("wrapper-modal-dialog")
		div.innerHTML = html
		view.appendChild(div)

		let salvarNoSelect = document.querySelectorAll(".bt_salvar_no_select")
		salvarNoSelect.forEach(item => {
			item.onclick = (e) => {
				e.stopPropagation()
				e.preventDefault()
				let pasta = Salvar.data.pastaEmUso
				let pasta_id = Salvar.data.pastaIdEmUso
				Salvar.salvarUsuarioPastaItem(id, pasta, pasta_id, Salvar.view)
			}
		})
		let bt_close_modal = document.querySelectorAll(".bt_close_modal")
		bt_close_modal.forEach(item => {
			item.onclick = (e) => {
				e.stopPropagation()
				e.preventDefault()
				let pasta = Salvar.data.pastaEmUso
				let pasta_id = Salvar.data.pastaIdEmUso
				Salvar.fechar(id)
			}
		})
		let newNoSelect = document.querySelectorAll(".bt_new_no_select")
		newNoSelect.forEach(item => {
			item.onclick = (e) => {
				e.stopPropagation()
				e.preventDefault()
				Salvar.viewCriarPasta("salvar_" + id, id)
			}
		})

		const select = document.getElementById(`selec_${id}`)
		select.addEventListener("click", Salvar.selectClick, false)
		select.id = id

	},
	selectClick(e)
	{
		if (e.target.value == "new")
			Salvar.viewCriarPasta("salvar_" + e.currentTarget.id, e.currentTarget.id)

		Salvar.data.preselect.forEach(element => {
			if (element.id == e.target.value)
				element.emuso = "1"
			else
				element.emuso = "0"
		})
		Salvar.data.pastaEmUso = e.target.options[e.target.options.selectedIndex].innerHTML
		Salvar.data.pastaIdEmUso = e.target.value
	},
	viewCriarPasta(nameId, id)
	{
		let objeto = document.getElementById(nameId)
		const div = document.createElement("div")
		div.id = "tool_" + nameId
		div.classList.add("tool-salvar__criar_pasta")
		div.classList.add("ativado")

		//criar no objeto a janela modal de criação de nova Pasta
		const html = `
        <div class='modal onTop ativado'>
            <div class='modal--wrapper dark'>        
                <div class='modal--wrapper--container'>      
                    <div class="wrapper-modal-dialog">
                        <header>Criando uma Nova pasta <a class="bt_close_nova_frase" idData="${id}"><i class="ico ico-fechar"></i></a> </header>
                        <div class="form">
                            <input type="text" class="criar_pasta_body" placeholder="Nome" id="nova_pasta_${id}" data-id="">
                            <button class="botao-padrao red" id="bt_salvar_${id}">Criar!</button>        
                        </div>
                    </div>
                </div>
            </div>
        </div>`
		div.innerHTML = html

		if (!objeto) return

		objeto.appendChild(div)

		let closeNovaFrase = document.querySelector(".bt_close_nova_frase")
		closeNovaFrase.addEventListener("click", (e) => {
			objeto.removeChild(div)
		})
		// let cancelar = document.querySelector(".bt_cancelar")
		// cancelar.addEventListener("click" , (e) =>{            
		//     objeto.removeChild(div)
		// })
		let bt_salvar = document.getElementById(`bt_salvar_${id}`)
		bt_salvar.onclick = (e) => {
			e.preventDefault()
			e.stopPropagation()
			let pasta = document.getElementById(`nova_pasta_${id}`).value
			if (pasta) {
				Salvar.data.pastaEmUso = pasta
				Salvar.data.pastaIdEmUso = "inserirNovaFrase"
				Salvar.refreshPreselect(pasta)
				Salvar.fechar(id)
				objeto.removeChild(div)
				Salvar.view(id)
			}
		}
	},
	fechar(id)
	{
		const modal = document.getElementById("modal_salvar_" + id)
		let isView = document.getElementById("salvar_" + id)
		isView.classList.remove("ativado")
		modal.classList.remove("ativado")
	},
	salvarUsuarioPastaItem(frase_id, pasta, pasta_id, cb)
	{
		debugger
		if (frase_id != "") {
			const formData = new FormData()
			formData.append("frase_id", frase_id)
			formData.append("pasta_id", pasta_id)
			formData.append("pasta", pasta)

			axios.post("/pastausuarioitem", formData)
				.then(respo => {
					debugger
					if (respo.data.message) {
						Messenger.view("Frase Salva!", "sucesso", 3000)
						let fraseMarcada = document.querySelector(".favorita-id-" + frase_id)
						let label = document.querySelector(".favorita-id-" + frase_id + " > span.label.no-interact")
						fraseMarcada.setAttribute("class", "favoritas jacurtida icon icon-star item-tools mg0")
						fraseMarcada.setAttribute("data", "jacurtida")
						fraseMarcada.setAttribute("title", "Adicionada!!!")
						fraseMarcada.children[0].classList.toggle("seguindo")

						if (label)
							label.innerHTML = "Salvo!"
						Salvar.data.preselect.forEach(element => {
							if (element.id == "newitem")
								if (element.titulo == pasta) {
									element.id = respo.data.novaPastaId
								}
						})
						cb(frase_id)
					}
					else {
						Messenger.view(`Vixi!, ${respo.data.msg}`, "error")
					}
				})
		}
	},
}
Modal.preLoad()
export { Salvar }
Salvar.preLoad()
