/* eslint-disable no-undef */
require("./Axios")
const LoadMore = {
	data: {
		data: "",
	},
	preLoad() {
		let btLoadMore = document.getElementById("btLoadMore")
		if (btLoadMore)
			btLoadMore.onclick = (e) => {
				e.stopPropagation()
				e.preventDefault()
				if (btLoadMore.classList.contains("enable")) {
					LoadMore.load(
						e.target.href,
						e.target.attributes["data-canonical"].nodeValue,
						e.target.attributes["data-pageatual"].nodeValue,
					)
				}
			}
	},
	async load(href, canonical, pageAtual) {
		LoadMore.loading()
		let lastPage = "1"
		axios({
			method: "get",
			url: href,
			responseType: "json"
		})
			.then(function (response) {
				LoadMore.limpar()
				lastPage = response.data.dados.ultimas.last_page
				LoadMore.addMore(response.data.dados.ultimas.data)
				LoadMore.remontarBotaoDeNavegacao(parseInt(pageAtual) + 1, canonical, lastPage)
			})
			.then(function () {
				LoadMore.rolarPagina(parseInt(pageAtual) + 1)
			})
		return ""

	},
	async limpar() {
		let wrapper = document.querySelector(".wrapper-loadMaisListas")
		if (!wrapper) return
		wrapper.innerHTML = ""
	},
	async loading() {
		let wrapper = document.querySelector(".wrapper-loadMaisListas")
		if (!wrapper) return
		wrapper.innerHTML = "<span>loading....</loading>"
	},
	async addMore(dados) {
		//pegar a ul que devemos accrescentar
		let ul = document.getElementById("ultimas")
		if (!ul) return
		let url = ""
		let capa = ""
		let titulo = ""
		let bodyDados = ""
		dados.forEach(item => {
			url = "/" + item.urlamigavel
			capa = item.thumb ? item.thumb : item.capa
			titulo = item.titulo
			let liDados = document.createElement("li")
			bodyDados = `<div class="relacionados--imagens">
                <a href="${url}" title="${titulo}">
					<img src="${capa}" alt="${titulo}" width="192px" height="130px">
				</a>
            </div>
            <div class="relacionados--texto">               
				<a href="${url}" title="${titulo}">${titulo}</a>
            </div>`
			liDados.innerHTML = bodyDados
			ul.appendChild(liDados)
		})
	},
	async remontarBotaoDeNavegacao(currentPage, canonical, lastPage) {
		let header = ""
		let bodyDados = ""
		let footer = ""

		if (lastPage == currentPage) {
			bodyDados += "<a rel=\"no-follow\" alt=\"Bom, chegamos ao fim\" class=\"disable botao-padrao full\" id=\"btLoadMore\">Ohh, acabou-se o que era doce :(</a>"
		} else {
			bodyDados += `<a href="${canonical}?page=${currentPage + 1}" data-canonical="${canonical}" data-pageatual="${currentPage}" rel="no-follow" alt="quero ver mais listas de frases" class="enable botao-padrao full " id="btLoadMore">carregar mais frases</a>`
		}
		const html = header + bodyDados + footer
		const div = document.createElement("div")
		div.classList.add("navegacao_area")
		div.innerHTML = html
		let wrapper = document.querySelector(".wrapper-loadMaisListas")
		wrapper.appendChild(div)
		LoadMore.preLoad()
		return
	},

	rolarPagina(to) {
		const rollpage = document.getElementById("rollpage-" + to - 1)
		if (rollpage) {
			rollpage.scrollIntoView()
		}

	},
}
export { LoadMore }
