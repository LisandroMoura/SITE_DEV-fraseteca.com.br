/* eslint-disable no-undef */
/* eslint-disable no-unused-vars */
//import {Messenger} from './messenger.js'
require("../Axios")
const Unsplash = { 
	data:{
		arrImages:[],
		lastPage:0,
		semResultados:false,
		ultimoTermoPesquisado:"",
		paginaAtual:1
	},
	props:{
		arrDataUnsplash:[],
		Controller:""
	},   
	async preLoad(Controller){                
		Unsplash.props.Controller = Controller                
		Unsplash.showView()
		let search = new Promise((resolve, reject) => {
			Unsplash.search()
		})
		await search 
	},    
	async showView(){
		// eslint-disable-next-line no-unused-vars
		// let htmlBtAnterior = "<li class=\"navega\"><a class=\"bt-navega anterior\"  href=\"#\">Anterior</a></li>"
		// let htmlBtProximo  = "<li class=\"navega\"><a class=\"bt-navega proximo\"  href=\"#\">Pŕoximo</a></li>"
		let htmlItems      =""
		let htmlFooter     =""
		let htmlHeader = `
        <div class="unsplash-wrapper">
			<div class="wrapper-pesquisa jsupload">
				<header class="flex left">
					<a id="bt-sair-pesquisa" class="bt-sair-pesquisa bt-sair"><i class="ico ico-sair ico-exit"></i></a>
					<h2>Fotos do <a href="https://unsplash.com?utm_source=lf20&amp;utm_medium=referral&amp;utm_campaign=api-credit" target="blank">Unsplash</a></h2>
				</header>
				<div class="corpo">     
				<div class="linha">     
					<div class="search-images">                    
							<input type="text" id="pesquisar" placeholder="digite um tema...">                            
							<input type="hidden" id="pagina">
							<i class="fas fa-search"></i>
					</div>
				</div>`
		if (Unsplash.data.semResultados)
			htmlHeader+=`<div class="void">
                        <h4>OPS!!, não encontramos nada com esse termo no Unsplash</h4>
                    </div>`
		else
			htmlHeader+="<div class=\"linha image-preview\"><ul id=\"unsplash-search-itens\">"
		htmlFooter+="</ul></div></div></div></div>"

		let pesquisa = document.getElementById("jsuploadBefore")
		pesquisa.innerHTML = htmlHeader + htmlItems + htmlFooter
		pesquisa.classList.add("jsupload")
		pesquisa.classList.add("ativado")  
		let btSairPesquisa = document.querySelector(".bt-sair")
		if(btSairPesquisa){
			btSairPesquisa.onclick = (e) =>{ 
				e.stopPropagation()               
				e.preventDefault()
				Unsplash.props.Controller.sair()
			}
		}

		let inputPesquisar = document.getElementById("pesquisar")
		if(inputPesquisar)
			inputPesquisar.addEventListener("keyup", function(event) {
				event.preventDefault()                
				if (event.keyCode === 13) {
					Unsplash.search(inputPesquisar.value)
				}
			})
	},
	async search(query = "dog"){        
		let url = ""        
		let pagina              = Unsplash.data.paginaAtual                
		let clientIdUnsplash    = "5acf22c8bbbefe231f79da23e26d94e3ed0a7b79672a100c1b4d07b6681b0ccb"
		let collectionDefault   = "collections/317099/photos"                
		let perPageUnsplash     = "15"
		let order_by            = "latest"

		Unsplash.data.semResultados=false
		if (Unsplash.data.ultimoTermoPesquisado != query){
			pagina = 1
			Unsplash.data.paginaAtual = pagina
		}
		if(query !="")                    
			url = `https://api.unsplash.com/search/?client_id=${clientIdUnsplash}&page=${pagina}&query=${query}&per_page=${perPageUnsplash}&order_by=${order_by}&fm=jpg&crop=faces&fit=crop&h=320&w=750`                    
		else 
			url = `https://api.unsplash.com/${collectionDefault}?page=1&per_page=${perPageUnsplash}&order_by=latest&client_id=${clientIdUnsplash}&page=${pagina}&query=${query}&per_page=${perPageUnsplash}&order_by=${order_by}&fm=jpg&w=750`                                
		axios.defaults.headers.common = []
		axios({
			method: "get",
			url: url,
			responseType: "json"                    
		})
			.then(function (response) {                
				if(query){
					Unsplash.data.arrImages = response.data.photos.results
					Unsplash.data.lastPage  = response.data.photos.total_pages
					if (response.data.photos.total =="0")
						Unsplash.data.semResultados=true                    
				}else{                                                
					Unsplash.data.lastPage  = 50
					let count_reg=0
					response.data.forEach(element => {                                                          
						Unsplash.data.arrImages.push(element)                    
						count_reg++
					})
					if (count_reg==0)
						Unsplash.data.semResultados=true
				}
				Unsplash.data.ultimoTermoPesquisado = query
				Unsplash.buildResultItens()
			})
			.catch(error => {
				console.log("Deu erro no Unsplash", error )
				Unsplash.data.arrImages=[]
			})
	},
	async aguarde (){        
		let htmlItems=`<li class="aguarde">
            <h4>aguarde...</h4>
        </li>`
		let unsplashSearchItens = document.getElementById("unsplash-search-itens")
		if(unsplashSearchItens)
			unsplashSearchItens.innerHTML =  htmlItems 

	},
	async buildResultItens (){
		let htmlBtAnterior = "<li class=\"navega\"><a class=\"bt-navega anterior\"  href=\"#\">Anterior</a></li>"
		let htmlBtProximo  = "<li class=\"navega\"><a class=\"bt-navega proximo\"  href=\"#\">Pŕoximo</a></li>"
		let htmlItems      = ""
		if (Unsplash.data.paginaAtual>1)
			htmlItems+=htmlBtAnterior        
		Unsplash.data.arrImages.forEach(image => {            
			htmlItems+="<li><div class=\"item item-unsplash\">"
			if(image.data)
				htmlItems+=`<span class="background-box" data-autor-name="${image.user.name}" data-autor-link="${image.user.links.html}" data-image="${image.data.regular+"&fm=jpg&w=1136"}" style="background-image:url(${image.data.thumb})"</span>`  
			else
				htmlItems+=`<span class="background-box" data-autor-name="${image.user.name}" data-autor-link="${image.user.links.html}" data-image="${image.urls.regular+"&fm=jpg&w=1136"}" style="background-image:url(${image.urls.thumb})"</span>`  
			htmlItems+=`
            <div class="autor-foto">
                <a href="${image.user.links.html}" target="blank">
                    <span class="name">${image.user.name}</span>
                </a>
            </div>`
			htmlItems+="</div></li>"
		})
		if (Unsplash.data.paginaAtual < Unsplash.data.lastPage)
			htmlItems+=htmlBtProximo

		if (Unsplash.data.semResultados)
			htmlItems=`<li class="void">
                    <h4>OPS!!, não encontramos nada com esse termo no Unsplash</h4>
                </li>`
        
		let unsplashSearchItens = document.getElementById("unsplash-search-itens")
		if(unsplashSearchItens)
			unsplashSearchItens.innerHTML =  htmlItems 

		Unsplash.triggersItens()
		Unsplash.triggersBtsNavegacao()
            
	},
	async triggersItens(){                 
		let itemUnsplash = document.querySelectorAll(".item-unsplash")
		itemUnsplash.forEach(item => {
			item.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()
				Unsplash.addImage(e.target.getAttribute("data-image"),e.target.getAttribute("data-autor-name"),e.target.getAttribute("data-autor-link"))
			}
		})        
	},
	async addImage(image,autorName="",autorLink=""){        
		Unsplash.props.Controller.aguarde()
		let confirmarCapa = new Promise(() => {
			// ponto
			Unsplash.props.Controller.confirmarCapa(image,"run-crop","",autorName,autorLink)
		})
		await confirmarCapa
        
	},
	async triggersBtsNavegacao(){
		let btAnterior = document.querySelector(".bt-navega.anterior")
		if(btAnterior){
			btAnterior.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()
				Unsplash.aguarde()
				Unsplash.data.arrImages = []
				Unsplash.data.paginaAtual--
				Unsplash.search(Unsplash.data.ultimoTermoPesquisado)
			}
		}
		let btProximo = document.querySelector(".bt-navega.proximo")
		if(btProximo){
			btProximo.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()
				if(Unsplash.data.paginaAtual < Unsplash.data.lastPage){
					Unsplash.aguarde()
					Unsplash.data.arrImages = []
					Unsplash.data.paginaAtual++
					Unsplash.search(Unsplash.data.ultimoTermoPesquisado)
				}
			}
		}
	}
}
export {Unsplash}
