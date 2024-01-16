/* eslint-disable no-undef */
import { Messenger } from "./Messenger"
require("./Axios")

const Seguir = {
	data: {
		labreMenu: "",
	},
	preLoad() {
		let btfavoritaStore = document.querySelector(".favoritaStore")
		if (btfavoritaStore)
			btfavoritaStore.onclick = (e) => {
				e.stopPropagation()
				e.preventDefault()
				if (btfavoritaStore.classList.contains("enable"))
					Seguir.store(e)
				else
					Seguir.delete(e)
			}
	},
	store(e) {
		e.preventDefault()
		e.stopPropagation()
		let btfavoritaStore = document.querySelector(".favoritaStore")
		let token_reverso = document.getElementById("token_reverso").value
		let tipo = document.getElementById("tipo_para_pasta").value
		const formData = new FormData()
		formData.append("seguindo", true)
		formData.append("token_reverso", token_reverso)
		formData.append("tipo", tipo)
		
		axios.post("/pastas", formData)
			.then(respo => {
				if (respo.data.sucess) {
					Messenger.view(`${respo.data.msg}`, "sucesso")
					document.getElementById("seguindo_id").value = respo.data.data.id
					btfavoritaStore.classList.add("disable")
					btfavoritaStore.classList.remove("enable")
					btfavoritaStore.children[0].classList.toggle("seguindo")
				}
				else {
					Messenger.view(`${respo.data.titulo_msg} ${respo.data.msg}`, "error")
				}
			})
	},
	delete(e) {
		e.preventDefault()
		e.stopPropagation()
		let seguindo_id = document.getElementById("seguindo_id").value
		let btfavoritaStore = document.querySelector(".favoritaStore")
		let url = `/pastas/deletar/${seguindo_id}`
		axios.delete(url)
			.then(respo => {
				if (respo.data.sucess) {
					Messenger.view(`${respo.data.msg}`, "sucesso")
					btfavoritaStore.classList.add("enable")
					btfavoritaStore.classList.remove("disable")
					btfavoritaStore.children[0].classList.toggle("seguindo")
				}
				else {
					Messenger.view(`Vixi! ${respo.data.msg}`, "error")
				}
			})
	},
}

const SeguirTag = {
	data: {
		labreMenu: "",
	},
	preLoad() {
		let btfavoritaStore = document.querySelector(".bt-seguir")
		if (btfavoritaStore) {
			btfavoritaStore.onclick = (e) => {
				e.stopPropagation()
				e.preventDefault()
				if (btfavoritaStore.classList.contains("enable"))
					SeguirTag.seguir(e)
				else
					SeguirTag.desSeguir(e)

			}
		}
	},
	seguir(e) {
		e.preventDefault()
		e.stopPropagation()
		let token_reverso = document.getElementById("token_reverso").value
		let btfavoritaStore = document.querySelector(".bt-seguir")

		const formData = new FormData()
		formData.append("token_reverso", token_reverso)
		formData.append("action", "seguir")

		axios.post("/preferencias/seguir_tag", formData)
			.then(respo => {
				if (respo.data.sucess) {
					Messenger.view(`${respo.data.msg}`, "sucesso")
					btfavoritaStore.classList.remove("enable")
					btfavoritaStore.classList.add("seguindo")
					btfavoritaStore.innerHTML = "Seguindo" + "<span class=\"ico ico-seguindo\"></span>"
				}
				else {
					Messenger.view(`Vixi! ${respo.data.msg}`, "error")
				}
			})
	},
	desSeguir(e) {
		e.preventDefault()
		e.stopPropagation()
		let token_reverso = document.getElementById("token_reverso").value
		let btfavoritaStore = document.querySelector(".bt-seguir")

		const formData = new FormData()
		formData.append("token_reverso", token_reverso)
		formData.append("action", "deseguir")

		axios.post("/preferencias/seguir_tag", formData)
			.then(respo => {
				if (respo.data.sucess) {
					Messenger.view(`${respo.data.msg}`, "sucesso")
					btfavoritaStore.classList.add("enable")
					btfavoritaStore.classList.remove("seguindo")
					btfavoritaStore.innerHTML = "Seguir"
				}
				else {
					Messenger.view(`Vixi! ${respo.data.msg}`, "error")
				}
			})
	},
}

export { Seguir, SeguirTag }