/* eslint-disable no-undef */
import { Messenger } from "./Messenger"
require("./Axios")

const Seguidores = {
	data: {          
		labreMenu:"",         
	},
	preLoad(){
		let btSeguirPerfil = document.querySelector(".bt-seguir")
		if(btSeguirPerfil){
			btSeguirPerfil.onclick = (e) => {
				e.stopPropagation()
				e.preventDefault()              
				if (btSeguirPerfil.classList.contains("enable"))
					Seguidores.seguirPerfil(e)
				else 
					Seguidores.desSeguirPerfil(e)            
			}
		}
	},
	seguirPerfil(e){
		e.preventDefault()
		e.stopPropagation()
		let token_reverso = document.getElementById("token_reverso").value
		let btSeguirPerfil = document.querySelector(".bt-seguir")
        
		const formData = new FormData()          
		formData.append("token_reverso",token_reverso)
		formData.append("action","seguir")

		axios.post("/preferencias/seguir_perfil",formData)
			.then(respo => {            
				if(respo.data.sucess){
					Messenger.view(`Sucesso! ${respo.data.msg}`, "sucesso")
					btSeguirPerfil.classList.remove("enable")
					btSeguirPerfil.classList.add("seguindo")
					btSeguirPerfil.innerHTML = "Seguindo" + "<span class=\"ico ico-seguindo\"></span>"
				}                
				else{
					Messenger.view(`${respo.data.titulo_msg} ${respo.data.msg}`, "error")                
				}
			})        
	},
	desSeguirPerfil(e){
		e.preventDefault()
		e.stopPropagation()
		let token_reverso = document.getElementById("token_reverso").value
		let btSeguirPerfil = document.querySelector(".bt-seguir")
        
		const formData = new FormData()          
		formData.append("token_reverso",token_reverso)
		formData.append("action","deseguir")

		axios.post("/preferencias/seguir_perfil",formData)
			.then(respo => {            
				if(respo.data.sucess){
					Messenger.view(`Sucesso! ${respo.data.msg}`, "sucesso")
					btSeguirPerfil.classList.add("enable")
					btSeguirPerfil.classList.remove("seguindo")
					btSeguirPerfil.innerHTML = "Seguir"
				}                
				else{
					Messenger.view(`Vixi! ${respo.data.msg}`, "error")                
				}
			})        
	},
}
export {Seguidores}
