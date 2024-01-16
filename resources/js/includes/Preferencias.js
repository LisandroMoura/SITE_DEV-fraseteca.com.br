const Preferencias = {
	preLoad() {
		let tags = document.querySelectorAll(".tag-item")
		if (tags)
			tags.forEach(item => {
				item.onclick = (e) => {
					e.stopPropagation()
					e.preventDefault()
					e.target.classList.toggle("ativado")
					Preferencias.habilitar()
				}
			})
	},
	habilitar() {
		let existe = 0
		let tags = document.querySelectorAll(".tag-item")
		const arrTags = document.getElementById("arrTags")
		if (arrTags)
			arrTags.value = ""
		if (!tags) return
		tags.forEach(item => {
			if (item.classList.contains("ativado")) {
				arrTags.value = item.getAttribute("data-id") + ";" + arrTags.value
				existe = 1
			}
		})

		if (existe) {
			let publicar = document.getElementById("validaSubmit")
			if (publicar) {
				publicar.classList.add("ok")
				publicar.classList.remove("nok")
			}
		}
		else {
			let publicar = document.getElementById("validaSubmit")
			if (publicar) {
				publicar.classList.add("nok")
				publicar.classList.remove("ok")
			}
		}
	},

}
export { Preferencias }