//import {Messenger} from './messenger.js'
require("../Axios")
const Galeria = { 
	data:{
		arrImages:[],
		lastPage:0,
		semResultados:false,
		ultimoTermoPesquisado:"",
		paginaAtual:1
	},
	props:{
		arrDataGaleria:[],
		Controller:""
	},   
	async preLoad(Controller){        
		//Messenger.view(`Abrindo galeria UNsplash..`, "error")    
		Galeria.props.Controller = Controller                
		Galeria.showView()
		let search = new Promise((resolve, reject) => {
			Galeria.search()
		})
		await search 
	},    
	async showView(){
		// let htmlBtAnterior = "<li class=\"navega\"><a class=\"bt-navega anterior\"  href=\"#\">Anterior</a></li>"
		// let htmlBtProximo  = "<li class=\"navega\"><a class=\"bt-navega proximo\"  href=\"#\">Pŕoximo</a></li>"
		let htmlItems      =""
		let htmlFooter     =""
		let htmlHeader = `
        <div class="unsplash-wrapper">
			<div class="wrapper-pesquisa jsupload">
				<header class="flex left">
					<a id="bt-sair-pesquisa" class="bt-sair-pesquisa"><i class="ico ico-sair ico-exit"></i></a>
					<h2>Nossa galeria</h2>
				</header>
            	<div class="corpo">     
            	`
		if (Galeria.data.semResultados)
			htmlHeader+=`<div class="void">
                        <h4>OPS!!, não encontramos nada com esse termo no Galeria</h4>
                    </div>`
		else
			htmlHeader+="<div class=\"linha image-preview\"><ul class=\"search-galeria\" id=\"unsplash-search-itens\">"
		htmlFooter+="</ul></div></div></div></div>"

		let pesquisa = document.getElementById("jsuploadBefore")
		pesquisa.innerHTML = htmlHeader + htmlItems + htmlFooter
		pesquisa.classList.add("jsupload")
		pesquisa.classList.add("ativado")  
		let btSairPesquisa = document.querySelector(".bt-sair-pesquisa")
		if(btSairPesquisa){
			btSairPesquisa.onclick = (e) =>{ 
				e.stopPropagation()               
				e.preventDefault()
				Galeria.props.Controller.sair()
			}
		}

		let inputPesquisar = document.getElementById("pesquisar")
		if(inputPesquisar)
			inputPesquisar.addEventListener("keyup", function(event) {
				event.preventDefault()                
				if (event.keyCode === 13) {
					Galeria.search(inputPesquisar.value)
				}
			})
	},
	async search(query = ""){        
		let url = ""        
		let pagina              = Galeria.data.paginaAtual                
		let clientIdGaleria    = "5acf22c8bbbefe231f79da23e26d94e3ed0a7b79672a100c1b4d07b6681b0ccb"
		let collectionDefault   = "collections/317099/photos"                
		let perPageGaleria     = "15"
		let order_by            = "latest"

		Galeria.data.semResultados=false
		if (Galeria.data.ultimoTermoPesquisado != query){
			pagina = 1
			Galeria.data.paginaAtual = pagina
		}

		if(query !="") {
			if (pagina>1)
				url = `/api/midias/avatar/${query}?page=${pagina}`
			else
				url = `/api/midias/avatar/${query}`                      
		}
		else {
			if (pagina>1)
				url = `/api/midias/avatar/null?page=${pagina}`                    
			else
				url = "/api/midias/avatar/null"                      
		}

		axios.defaults.headers.common = []
		axios({
			method: "get",
			url: url,
			responseType: "json"                    
		})
			.then(function (response) {                
                
				Galeria.data.arrImages = response.data.data
				Galeria.data.lastPage  = response.data.last_page
                
				if (response.data.data.total==0)
					Galeria.data.semResultados=true                    
                
				Galeria.data.ultimoTermoPesquisado = query
				Galeria.buildResultItens()
			})
			.catch(error => {
				console.log("Deu erro na Galeria", error )
				Galeria.data.arrImages=[]
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
		// let htmlBtAnterior = "<li class=\"navega\"><a class=\"bt-navega anterior\"  href=\"#\">Anterior</a></li>"
		// let htmlBtProximo  = "<li class=\"navega\"><a class=\"bt-navega proximo\"  href=\"#\">Pŕoximo</a></li>"
		let htmlItems      = ""
		// if (Galeria.data.paginaAtual>1) htmlItems+=htmlBtAnterior        
		Galeria.data.arrImages.forEach(image => {
			htmlItems+="<li><div class=\"item item-unsplash\">"
            
			htmlItems+=`<span class="background-box avatar" data-id="${image.id}" data-image="/storage/images/${image.url}" style="background-image:url(/storage/images/${image.url})"</span>`  
            
			htmlItems+=""
			htmlItems+="</div></li>"
		})
		// if (Galeria.data.paginaAtual < Galeria.data.lastPage) htmlItems+=htmlBtProximo

		if (Galeria.data.semResultados)
			htmlItems=`<li class="void">
                    <h4>OPS!!, não encontramos nada com esse termo no Galeria</h4>
                </li>`
        
		let unsplashSearchItens = document.getElementById("unsplash-search-itens")
		if(unsplashSearchItens)
			unsplashSearchItens.innerHTML =  htmlItems 

		Galeria.triggersItens()
		Galeria.triggersBtsNavegacao()
            
	},
	async triggersItens(){                 
		let itemGaleria = document.querySelectorAll(".item-unsplash")
		itemGaleria.forEach(item => {
			item.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()
				Galeria.addImage(e.target.getAttribute("data-image"),e.target.getAttribute("data-id"))
			}
		})        
	},
	async addImage(image,id){        
		Galeria.props.Controller.aguarde()
		let confirmarCapa = new Promise(() => {
			Galeria.props.Controller.confirmarCapa(image,"close-crop",id)
		})
		await confirmarCapa
        
	},
	async triggersBtsNavegacao(){
		let btAnterior = document.querySelector(".bt-navega.anterior")
		if(btAnterior){
			btAnterior.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()
				Galeria.aguarde()
				Galeria.data.arrImages = []
				Galeria.data.paginaAtual--
				Galeria.search(Galeria.data.ultimoTermoPesquisado)
			}
		}
		let btProximo = document.querySelector(".bt-navega.proximo")
		if(btProximo){
			btProximo.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()
				if(Galeria.data.paginaAtual < Galeria.data.lastPage){
					Galeria.aguarde()
					Galeria.data.arrImages = []
					Galeria.data.paginaAtual++
					Galeria.search(Galeria.data.ultimoTermoPesquisado)
				}
			}
		}
	}
   
}
export {Galeria}
