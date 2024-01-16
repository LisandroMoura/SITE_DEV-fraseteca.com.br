import {Messenger} from "../Messenger"
// 
//https://github.com/fengyuanchen/cropperjs/blob/master/README.md
// https://fengyuanchen.github.io/cropperjs/

import {Computador} from "./Computador"
import {Galeria} from "./Galeria"
import {Unsplash} from "./Unsplash"

const JSController = {
	data:{
		imageCrop:"",
		target:"",
		inCrop:false,
		result:""
	},
	props:{
		arrProps:[]
	},
	preLoad(target){              
		let btJSController = document.querySelectorAll(".JSUpload")
		btJSController.forEach(botao => {
			botao.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()                
				JSController.data.target= target
				JSController.showJSController(target)                
			}
		})        
		Computador.preLoadCropJS(JSController,target)
	},
    
	loadDataJSON(){
		let data = document.getElementById("arrProps").innerHTML
		if(data) { 
			this.props.arrProps = JSON.parse(data)            
			/*
            if(this.props.arrProps.dados[0])
                this.montarArray(this.props.arrProps.dados[0])
            JSController.titulo = this.props.arrProps.titulo            
            */
		}
	},
	showJSController(target){        
		JSController.clear()
		let html = ""
		let head = `<div id="pesquisa">
        <div class="wrapper-pesquisa jsupload">            
            <header class="flex">
			<a id="bt-sair-jsupload" class="bt-sair-pesquisa"><i class="ico ico-sair ico-exit"></i></a>`
		if (target=="perfil")
			head+= "<h2>Alterar Avatar</h2>"
		if (target=="pastas")
			head+= "<h2>Alterar capa</h2>"
		head+= `</header>
            <section>                  
                <ul class="ul-jsupload">`
		let footer = "</ul>"
		footer+= `</section>
            </div>
        </div>`
		if (target=="pastas") {            
			html+=`
            <li class="computador">
            <span class="btJSControllerOption computador">Procurar no seu computador</span>
            <input type="file" name="fileupload" id="fileupload" accept="image/*">
            </li>
            <li><a href="#" class="btJSControllerOption btUnsplash">Porucar na Galeria</a></li>
            <li><a href="#" class="btJSControllerOption btDeletar">Deletar imagem de capa</a></li>
            `
		}
		if (target=="perfil") {            
			html+=`
            <li><a href="#" class="btJSControllerOption galeriaAvatar">Porucar na Galeria</a>
            </li>
            <li class="computador">
            <span class="btJSControllerOption computador">Procurar no seu computador</span>
            <input type="file" name="fileupload" id="fileupload" accept="image/*">
            </li>            
            `
		}
		let pesquisa = document.getElementById("jsuploadBefore")        
		pesquisa.innerHTML = head + html + footer
		pesquisa.classList.add("jsupload")
		pesquisa.classList.add("ativado")        
		JSController.triggersBts()        
	},    
	clear(){
		let pesquisa = document.getElementById("jsuploadBefore")
		pesquisa.innerHTML = ""        
	},
	triggersBts(){
		let btSairPesquisa = document.getElementById("bt-sair-jsupload")
		if(btSairPesquisa){
			btSairPesquisa.onclick = (e) =>{ 
				e.stopPropagation()               
				e.preventDefault()
				JSController.sair()
			}
		}
		let btComputador = document.querySelector(".btJSControllerOption.computador")
		if(btComputador){
			btComputador.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()
				Computador.show(JSController.props.arrProps)
			}
		}
		let btUnsplash = document.querySelector(".btJSControllerOption.btUnsplash")
		if(btUnsplash){
			btUnsplash.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()
				Unsplash.preLoad(JSController)
			}
		}
		let btGaleria = document.querySelector(".btJSControllerOption.galeriaAvatar")
		if(btGaleria){
			btGaleria.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()
				Galeria.preLoad(JSController)
			}
		}

		let btDeletar = document.querySelector(".btJSControllerOption.btDeletar")
		if(btDeletar){
			btDeletar.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()
				JSController.removeCapa()
			}
		}
		let fileupload = document.getElementById("fileupload")
		if(fileupload){
			fileupload.onchange = (e) =>{ 
				e.stopPropagation()               
				e.preventDefault()                
				const files = e.target.files  
				this.msgErros =""                      
				Array.from(files).forEach(file => JSController.addImage(file))                
			}
		}        
	},    
	addImage(file){
		if(!file.type.match("image.*")){            
			//self.pai.$parent.validatorJS(self.pai.$parent.titulo_atencao, `${file.name} não é uma imagem válida` , null)            
			Messenger.view(`Ei! o arquivo: [${file.name}] não é uma imagem válida...`, "error")
			//this.$toastr.e(`${file.name} não é uma imagem válida`);
			//this.msgErros = `${file.name} não é uma imagem válida`
			return 
		}
		if((file.size/1024) > (1024 * 4) ){
			Messenger.view("Xiiii, Não deu... Poxa, O peso deste arquivo é muito grande! Tente enviar algo menor que 4MB ok?", "error", 10000)            
			//self.pai.$parent.validatorJS(self.pai.$parent.titulo_atencao, `Arquivo, ${file.name}. Tamanho do arquivo é superior a ${this.opt.textoTamanho}` , null)
			//this.$toastr.e(`Arquivo, ${file.name}. Tamanho do arquivo é superior a ${this.opt.textoTamanho}`);
			//this.msgErros = `Arquivo, ${file.name}. Tamanho do arquivo é superior a ${this.opt.textoTamanho}`
			return                     
		}
		//push no files

		// this.files.push(file);
		// this.names.push(file.name);        
        
		const reader = new FileReader() 
        
		reader.addEventListener("load", function () {                 
			let valueToPush ={} 
			// let temErros=false
			//let capa = this.$parent;            
			valueToPush["result"]   = this.result
			valueToPush["name"]     = file.name
			valueToPush["size"]     = file.size

			var image  = new Image()       
			image.src = this.result             
			image.onload = function () {                        
				// var width  = this.width
				// var height = this.height                        
				// if (height > self.opt.limit_height || width > self.opt.lomit_width){                            
				//     //self.$toastr.e(`${file.name} - Tamanho: ${this.width} x ${this.height} | ccc Largura ou altura inválida.`);
				//     //self.msgErros = `${file.name} - Tamanho: ${this.width} x ${this.height} | CCC Largura ou altura inválida.`;
				//     self.pai.$parent.validatorJS(self.pai.$parent.titulo_atencao, ` Esta imagem é muito grande (Recomendado: no máximo ${self.opt.limit_width} x ${self.opt.limit_height}).` , null)
				//     return false;
				// }
				// else{
				//     valueToPush["width"]  = this.width;
				//     valueToPush["height"] = this.height;
				//     self.images.push(valueToPush);                                            
				//     self.$parent.mostrar=false;
				//     return false;
				// }
				JSController.aguarde()
				JSController.confirmarCapa(this.src,"")

                
			}
		}, false)                
		reader.readAsDataURL(file)        
	},
	removeCapa(){
		let imgSrc = ""
		const capa = document.getElementById("capa")
		const capa_m = document.getElementById("capa_m")
		let inputCapa = document.getElementById("inputCapa")        
		let  srcImgCropJS = document.getElementById("srcImgCropJS")

		if(capa){                         
			if (capa.hasAttribute("src")) {
				capa.setAttribute("src","/images/bgs/fundo.png")   
				capa_m.setAttribute("src","/images/bgs/fundo.png")   
			}                
			else {
				capa.setAttribute("style", "background-image:url(\"/images/bgs/fundo.png\")")
				capa_m.setAttribute("style", "background-image:url(\"/images/bgs/fundo.png\")")
			} 
                
			capa.classList.add("auto")


			let astronauta = document.createElement("div")
			let html = "<img class=\"imagem--capa--center\" src=\"/images/default/astronauta-capa.png\" alt=\"\">"
			astronauta.classList.add("default--image")
			astronauta.innerHTML = html
			capa.appendChild(astronauta)


			let inputAutorName = document.getElementById("autorName")
			if(inputAutorName) inputAutorName.value = ""
            
			let inputAutorLink = document.getElementById("autorLink")
			if(inputAutorLink) inputAutorLink.value = ""

			JSController.data.result = imgSrc                        
			srcImgCropJS.setAttribute("src", "")
			JSController.sair("")
            
			if (inputCapa){
				inputCapa.innerHTML="delete"
			}
			JSController.mudaStatus()            
		}
	},
	confirmarCapa(imgSrc, acao, id="", autorName="",autorLink=""){        
		const capa = document.getElementById("capa")
		const capa_m = document.getElementById("capa_m")
		let inputCapa = document.getElementById("inputCapa")        
		let  srcImgCropJS = document.getElementById("srcImgCropJS")
		if(capa){
			if (capa_m){
				if (capa_m.hasAttribute("src")) 
					capa_m.setAttribute("src",imgSrc)   
				else 
					capa_m.setAttribute("style", `background-image:url("${imgSrc}")`)
			}
			if (capa.hasAttribute("src")) 
				capa.setAttribute("src",imgSrc)   
			else 
				capa.setAttribute("style", `background-image:url("${imgSrc}")`)
			if(id){
				let avatar_icone_id = document.getElementById("avatar_icone_id")
				if(avatar_icone_id)
					avatar_icone_id.value = id
			}

			if(capa.classList.contains("auto")){
				capa.classList.remove("auto")
				let astronauta = document.querySelector(".default--image")
				if (astronauta){
					capa.removeChild(astronauta)
				}
			}
				

			
            
			let inputAutorName = document.getElementById("autorName")
			if(inputAutorName) inputAutorName.value = autorName
            
			let inputAutorLink = document.getElementById("autorLink")
			if(inputAutorLink) inputAutorLink.value = autorLink            

			JSController.data.result = imgSrc                        
			srcImgCropJS.setAttribute("src", imgSrc)            
			if(acao!="close-crop") {  
				Computador.replaceCropsJS(JSController,imgSrc)
				inputCapa.innerHTML=imgSrc
                
			}else {
				if (inputCapa){
					inputCapa.innerHTML=imgSrc
				}
			}
			JSController.sair(acao)            
		}
	},
	sair(acao = null){                
		let pesquisa = document.getElementById("jsuploadBefore")
		pesquisa.classList.remove("ativado")
		setTimeout(function (){
			pesquisa.innerHTML = ""
			if(acao=="close-crop"){
				JSController.mudaStatus()
			}            
		}, 500)

	},
	mudaStatus(status="precisa salvar"){
		let mudaStatus = document.getElementById("mudaStatus")
		if (mudaStatus){
			mudaStatus.innerHTML = status
			mudaStatus.classList.add("ativo")
		}

		let btSalvarPastaFixed = document.getElementById("btSalvarPastaFixed")
		if(btSalvarPastaFixed){
			btSalvarPastaFixed.classList.add("ativo")
		}
	},
	aguarde (){        
		let cropjsZone = document.getElementById("cropjs-zone")
		if (cropjsZone){            
			cropjsZone.classList.add("aguarde")
		}
	},

	fimDoAguarde (){        
		let cropjsZone = document.getElementById("cropjs-zone")
		if (cropjsZone){            
			cropjsZone.classList.remove("aguarde")
		}
		//JSController.updateCrop()
	},
	updateCrop(){
		let imgSrc = JSController.data.imageCrop.getCroppedCanvas()    
		imgSrc = imgSrc.toDataURL() 

		const capa = document.getElementById("capa")
		const capa_m = document.getElementById("capa_m")
		let inputCapa = document.getElementById("inputCapa")        
		let  srcImgCropJS = document.getElementById("srcImgCropJS")

		if(capa){
			if (capa_m){
				if (capa_m.hasAttribute("src")) 
					capa_m.setAttribute("src",imgSrc)   
				else 
					capa_m.setAttribute("style", `background-image:url("${imgSrc}")`)
			}
			if (capa.hasAttribute("src")) 
				capa.setAttribute("src",imgSrc)   
			else 
				capa.setAttribute("style", `background-image:url("${imgSrc}")`)           
		}
		JSController.data.result = imgSrc                        
		srcImgCropJS.setAttribute("src", imgSrc)          
		inputCapa.innerHTML=imgSrc
	}
    
}
export {JSController}