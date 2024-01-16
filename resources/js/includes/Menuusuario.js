import { Modal } from "./Modal"

const MenuUsuario = {
	data: {
		labreMenu: "",
	},
	preLoad() {
		let menu = document.querySelectorAll(".abreMenuUsuario_desk")
		menu.forEach(item => {
			item.onclick = (e) => {
				let menuUsuario = document.querySelector(".menu-usuario-perfil_desk")
				if (menuUsuario.classList.contains("ativado")) {
					menuUsuario.classList.remove("ativado")
					item.classList.remove("ativado")
				}
				else {
					menuUsuario.classList.add("ativado")
					item.classList.add("ativado")
					Modal.view()
				}
			}
		})
	},
}
export { MenuUsuario }
