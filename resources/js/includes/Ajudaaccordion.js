// import {Messenger} from "./Messenger"
const Ajuda = {
	preLoad(){
		let accordions = document.querySelectorAll(".acc")
		accordions.forEach(item =>{
			item.onclick = function(e) {
				e.stopPropagation()
				e.preventDefault()       
				e.target.classList.toggle("ativo")
                
				let panel = this.nextElementSibling


				//if(Object.prototype.toString.call(panel)=="[object HTMLBRElement]")
				if(Object.prototype.toString.call(panel)!="[object HTMLParagraphElement]")                
					panel = panel.nextElementSibling

				panel.classList.toggle("ativo")
				// if (panel.style.maxHeight) {
				// 	panel.style.maxHeight = null                    
				// } else {
				// 	panel.style.maxHeight = panel.scrollHeight + "px"
				// }
			}
		})        
        
	},    
}
export {Ajuda}