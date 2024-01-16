import {Messenger} from "./Messenger"
require("./Axios")

const Curtir = {
	data: {          
		labreMenu:"",         
	},
	preLoad(){
		let btCurtirPost = document.querySelector("#btCurtirPost")
		if(btCurtirPost)
			btCurtirPost.onclick = (e) => {
				e.stopPropagation()
				e.preventDefault()
				if (!btCurtirPost.classList.contains("disable"))
					Curtir.curtidaStore(e)                
				else 
					Curtir.curtidaDelete(e)
			}
	},
	curtidaStore(e){
		e.preventDefault()
		e.stopPropagation()
		let token_reverso = document.getElementById("token_reverso").value        
		let curtida_id = document.getElementById("curtida_id").value  
		let tipo = document.getElementById("tipo").value  
		let totalCurtidas = document.getElementById("totalCurtidas").value
		let totalCurtidasHtml = document.querySelector("#totalCurtidasHtml")
		let btCurtirPost = document.querySelector("#btCurtirPost")        
		const formData = new FormData()          
		formData.append("token_reverso",token_reverso)
		formData.append("tipo",tipo)
		axios.post("/curtida",formData)
			.then(respo => {
				if(respo.data.sucess){
					Messenger.view(`${respo.data.msg}`, "sucesso",3000)                
					e.target.classList.add("jaCurtida")
					curtida_id = respo.data.data.id
					document.getElementById("curtida_id").value = curtida_id
					totalCurtidas++
					totalCurtidasHtml.innerHTML = totalCurtidas
					document.getElementById("totalCurtidas").value = totalCurtidas
					btCurtirPost.classList.add("disable")
					btCurtirPost.classList.remove("enable")
					btCurtirPost.children[1].classList.toggle("curtido")
				} 
				else{
					Messenger.view(`${respo.data.titulo_msg} ${respo.data.msg}`, "error") 
				}
			})        
	},
	curtidaDelete(e){
		e.preventDefault()
		e.stopPropagation()
		let token_reverso = document.getElementById("token_reverso").value        
		let curtida_id = document.getElementById("curtida_id").value         
		let totalCurtidas = document.getElementById("totalCurtidas").value
		let totalCurtidasHtml = document.querySelector("#totalCurtidasHtml")
		let btCurtirPost = document.querySelector("#btCurtirPost")
		let url = `/curtidas/deletar/${curtida_id}` 
		axios.delete(url)
			.then(respo => {
				if(respo.data.sucess){                
					Messenger.view(`${respo.data.msg}`, "sucesso",3000)                
					e.target.classList.remove("jaCurtida")                
					totalCurtidas--
					totalCurtidasHtml.innerHTML = totalCurtidas
					document.getElementById("totalCurtidas").value = totalCurtidas
					btCurtirPost.classList.add("enable")
					btCurtirPost.classList.remove("disable")
					btCurtirPost.children[1].classList.toggle("curtido")
				}  
				else{
					Messenger.view(`Vixi! ${respo.data.msg}`, "error") 
				}
			})        
	},
}
export {Curtir}
