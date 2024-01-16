const Accordion = {
	data: {          
		labreMenu:"",         
	},
	preLoad(){
		let btsAccordion = document.querySelectorAll(".bt-accordion")        
		btsAccordion.forEach(element => {            
			element.onclick = (e) => {
				e.stopPropagation()
				e.preventDefault()                                
				Accordion.change(element, e.target.attributes.data.nodeValue)                
			}            
		})
		let cargaInicial = document.querySelector(".bt-accordion.listas")
		if (cargaInicial)
			cargaInicial.click()
	},
	change(alvo,target){
		let btsAccordion = document.querySelectorAll(".bt-accordion")
		let accordion = document.querySelectorAll(".accordion--item")
		let accordionTarget = document.querySelector(".accordion--item."+target)
        
		btsAccordion.forEach(element => {
			element.classList.remove("ativa")
		})
        
		accordion.forEach(element => {
			element.classList.remove("ativa")
		})        
		alvo.classList.add("ativa")
		if(accordionTarget) accordionTarget.classList.add("ativa")
		return
	},
}
export {Accordion}
