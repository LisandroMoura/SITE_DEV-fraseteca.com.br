// import {Messenger} from './messenger.js'
//require('../axios');
import Cropper from "cropperjs"
const Computador = { 
	props:{
		arrDataComputador:[]
	},   
	preLoad(){
	},
	preLoadCropJS(Controller,target){
		let w=1076
		let h=250
		if(target=="perfil"){
			w=200
			h=200
		}
		window.addEventListener("DOMContentLoaded", function () {
			var croppable = false
			let  srcImgCropJS = document.getElementById("srcImgCropJS")
			if(srcImgCropJS){                
				Controller.data.imageCrop = new Cropper(srcImgCropJS, {
					// aspectRatio: 1,
					viewMode: 3,
					fillColor: "#fff",
					background:true,
					// // minContainerWidth:1137,
					// // minCanvasWidth:1137,
					minCropBoxWidth:w,
					minCropBoxHeight:h,                 
					ready: function () {
						Controller.fimDoAguarde()
                        
					},                      
					cropmove:function(){
						Controller.mudaStatus()
						//Computador.justUpdateCropsJSZone(Controller)
                        
					}
				})
			} 

		})
	},
	async justUpdateCropsJSZone(Controller){
		let imgPronta = document.getElementById("img-pronta")
		let cropjsZone = document.getElementById("cropjs-zone")
		let autorName = ""
		let autorLink = ""
		if (!imgPronta || !cropjsZone) return
		let croppedCanvas = Controller.data.imageCrop.getCroppedCanvas()        

		let inputAutorName = document.getElementById("autorName")
		if(inputAutorName) autorName = inputAutorName.value
        
		let inputAutorLink = document.getElementById("autorLink")
		if(inputAutorLink) autorLink = inputAutorLink.value        
		Controller.confirmarCapa(croppedCanvas.toDataURL(),"no-close-crop","",autorName,autorLink)
	},
	async closeCropsJSZone(Controller){
		let imgPronta = document.getElementById("img-pronta")
		let cropjsZone = document.getElementById("cropjs-zone")
		let autorName = ""
		let autorLink = ""
		if (!imgPronta || !cropjsZone) return

		let croppedCanvas = Controller.data.imageCrop.getCroppedCanvas()        

		let inputAutorName = document.getElementById("autorName")
		if(inputAutorName) autorName = inputAutorName.value
        
		let inputAutorLink = document.getElementById("autorLink")
		if(inputAutorLink) autorLink = inputAutorLink.value        
        
		Controller.confirmarCapa(croppedCanvas.toDataURL(),"close-crop","",autorName,autorLink)        
		imgPronta.classList.remove("emedicao")
		cropjsZone.classList.remove("emedicao")
	},
	async replaceCropsJS(Controller,imgSrc){        
		Controller.data.imageCrop.replace(imgSrc, false)        
		let showCrop = new Promise((resolve, reject) => {
			Computador.showCropsJSZone(Controller)    
		})
		await showCrop    
	},
	async showCropsJSZone(Controller){
		let imgPronta = document.getElementById("img-pronta")
		let cropjsZone = document.getElementById("cropjs-zone")
		if (!imgPronta || !cropjsZone) return
		if(!Controller.data.inCrop){            
			imgPronta.classList.toggle("emedicao")
			cropjsZone.classList.toggle("emedicao")
		}
		// let btControllerInCrop = document.querySelectorAll(".uploadJsInCrop")
		// btControllerInCrop.forEach(botao => {
		//     botao.onclick = (e) =>{
		//         e.stopPropagation()
		//         e.preventDefault()                               
		//         Controller.data.inCrop = true                
		//         Controller.showController(Controller.data.target)                                
		//     }
		// });

		/*teste*/
		let btCortar = document.getElementById("btCortar")  
		if(btCortar)      
			btCortar.onclick = (e) =>{
				e.stopPropagation()
				e.preventDefault()                               
				Controller.data.inCrop = false
				Computador.closeCropsJSZone(Controller)                                
			}        
	},
    
}
export {Computador}
