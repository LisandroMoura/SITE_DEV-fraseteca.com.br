const Comentar = {
	data: {
		labreMenu: "",
	},
	preLoad() {
		let textarea = document.getElementById("body")
		let publicar = document.getElementById("validaSubmit")
		if (textarea)
			textarea.addEventListener("input", e => {
				if (textarea.getAttribute("minlength") < textarea.value.length) {
					publicar.classList.add("ok")
					publicar.classList.remove("nok")
				}
				else {
					publicar.classList.remove("ok")
					publicar.classList.add("nok")

				}
			})
		let btResponder = document.querySelectorAll(".bt-responder")
		let parent_id = document.getElementById("parent_id")
		let preleitura = document.querySelector(".preleitura")

		if (btResponder)
			btResponder.forEach(item => {
				item.onclick = (e) => {
					e.stopPropagation()
					parent_id.value = e.target.id

					preleitura.innerHTML = "<div class=\"header\">Respondendo ao comentário de: <span> "+e.target.getAttribute("data-autor")+"</span></div><div class=\"conteudo\">”..." + e.target.title + "...”</div>"
					preleitura.classList.add("ativado")
				}

			})

	},
	habilitar() {
	}
}
export { Comentar }
