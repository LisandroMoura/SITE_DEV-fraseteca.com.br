const Imprimir = {
	preLoad(){
		let imprimir = document.querySelectorAll(".imprimir")
		imprimir.forEach(function(item){
			item.onclick = function(e) {
				e.stopPropagation()
				e.preventDefault()                     
				Imprimir.imprimir()
			}
		})               
	},
	imprimir(){
		try {
			var successful = document.execCommand("print")
			var msg = successful ? "com sucesso!" : "com falhas"
            
		} catch (err) {
			alert("Oops, não foi possível posível.")
		}
	},
}
export {Imprimir}