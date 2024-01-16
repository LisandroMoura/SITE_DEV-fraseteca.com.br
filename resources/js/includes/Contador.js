const Contador = {
	data: {          
		aux:null,         
	},
	preLoad(){        
	},
	contaCaracteres(element){        
		let conta = document.getElementById(element.target.id+"_conta")
		if (conta){
			if(element.target.value.length <= element.target.getAttribute("maxlength"))
				conta.innerHTML = element.target.value.length
		}
	}
}
Contador.preLoad()
export {Contador}
