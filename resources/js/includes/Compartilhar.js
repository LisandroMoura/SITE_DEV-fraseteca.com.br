import { Messenger } from "./Messenger"
import { Modal } from "./Modal"
const Compartilhar = {
	// data: {
	// },
	// props: {
	//     arrPastasData: []
	// },
	//triggers iniciais
	/**
     * definir como vai ser a regra de negócio...
     */
	preLoad() {
		let abreCompartilhar = document.querySelectorAll(".abreCompartilhar")
		if (abreCompartilhar) {
			abreCompartilhar.forEach(item => {
				item.onclick = (e) => {
					e.stopPropagation()
					e.preventDefault()

					let wrapper = document.querySelector(".wrapper--compartilhar")
					if (wrapper) {

						wrapper.classList.toggle("ativado")

						if (wrapper.classList.contains("ativado"))
							Modal.view()
						else {
							Modal.closeAll()
						}
					}
				}
			})
		}

		/**
         * copiarLink
        /****************************************************************** */
		let copiarLink = document.querySelectorAll(".copiarLink")
		copiarLink.forEach(function (item) {
			item.onclick = function (e) {
				e.stopPropagation()
				e.preventDefault()
				Compartilhar.copiarLink()
			}
		})
	},
	copiarLink() {
		let testingCodeToCopy = document.querySelector("#urlamigavel")
		testingCodeToCopy.setAttribute("type", "text")
		testingCodeToCopy.select()

		try {
			var successful = document.execCommand("copy")
			var msg = successful ? "Link Copiado!" : "com falhas"

			Messenger.view(msg, "sucesso", 3000)
		} catch (err) {
			Messenger.view("Vixi!, Seu navegador não suporta este recurso", "error")
		}
	},

}
export { Compartilhar }
Compartilhar.preLoad()
