/* eslint-disable no-undef */
window.axios = require("axios")
const Post = {
	preLoad() {
		let pasta = document.getElementById("pasta")
		if (pasta) {
			pasta.onchange = function (e) {
				e.stopPropagation()
				e.preventDefault()
				Post.getImagemDaPasta(this.value)
			}
		}
		Post.triggerImagens()
	},
	async trocaPasta(arrayIMagens, pasta, tipoTela) {
		Post.limparAreaDasPastas()
		Post.criarAreaDasPastas(arrayIMagens,pasta,tipoTela)
	},

	triggerImagens(){
		let imgEscolhida = document.querySelectorAll(".imgEscolhida")
		imgEscolhida.forEach(item => {
			item.onclick = function (e) {
				e.stopPropagation()
				e.preventDefault()
				let id = e.target.attributes.data_id.nodeValue
				Post.imgEscolhida(id, item)
			}
		})
	},
	async limparAreaDasPastas(){
		const ul = document.getElementById("imagens-na-pasta")
		if(ul){
			ul.innerHTML=""
		}
	},
	async criarAreaDasPastas(arrayIMagens, pasta,tipoTela){

		tipoTela = document.getElementById("tipoTelaSelect")

		const ul = document.getElementById("imagens-na-pasta")
		if(ul){
			let body = ""
			arrayIMagens.dados.forEach(item => {
				let li = document.createElement("li")
				li.classList.add("item")
				if(tipoTela.value=="bg")
					body = `<a href="#" class="imgEscolhida" data_id="${item.id}">
						<img class="no-pointer" src="/storage/frases/template/${pasta}/${item.image}">
					</a>`
				else
					body = `<a href="#" class="imgEscolhida" data_id="${item.id}">
						<div class="no-pointer" style="width:140px; height:140px; background:${item.image};">
							<span style="color:#${item.font}">Texto texto</span>
						</div>
					</a>`
				li.innerHTML = body
				ul.appendChild(li)
			})
			Post.triggerImagens()
			// const cor = document.getElementById("corFonte")
			// if(cor){
			// 	cor.value="#ffffff"
			// 	if(pasta=="amor")
			// 		cor.value="#000000"
			// }
		}
	},
	async getImagemDaPasta(pasta) {

		if (pasta != "") {
			let tipoTela = document.getElementById("tipoTelaSelect")
			const formData = new FormData()
			formData.append("pasta", pasta)
			if(tipoTela)
				formData.append("tipoTela", tipoTela.value)
			// eslint-disable-next-line no-undef
			//   axios.post("/preferencias/seguir_tag", formData)
			await axios.post("/api/pipiefricardo", formData)
				.then(respo => {
					if (respo.data) {
						Post.trocaPasta(respo.data, pasta, respo.ncount,tipoTela.value)
					} else {
						alert("Vixi!, deu ruim")
						return
					}
				})
		}

	},

	imgEscolhida(id, element) {
		//colocar na área de transfrência todo o conteúdo Postdo
		let imgEscolhida = document.getElementById("imagemEscolhida")
		if (imgEscolhida) {
			Post.limpar()
			imgEscolhida.value = id
			element.classList.add("escolhida")
		}
		return ""
	},
	limpar() {
		let imgEscolhida = document.querySelectorAll(".imgEscolhida")
		imgEscolhida.forEach(item => {
			item.classList.remove("escolhida")
		})
	}
}
export { Post }