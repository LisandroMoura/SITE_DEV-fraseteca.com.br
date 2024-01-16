
const Checkradiobox = {
	preLoad() {
		let menu = document.querySelectorAll(".click-checkbox")
		menu.forEach(item => {
			item.onclick = (e) => {
				e.preventDefault()
				e.stopPropagation()
				console.log("clicou")
				let atributo = e.target.attributes["data-object"].nodeValue
				if(atributo){
					console.log("atrib")
					let object = document.getElementById(atributo)    
					console.log("object" + object)
					if(object)
						object.click()
				}
				
			}
		})
	},
}
export { Checkradiobox }
