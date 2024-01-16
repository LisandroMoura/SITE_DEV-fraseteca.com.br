const Messenger = {
	data: {          
		executar:null,         
	},
	preLoad(){
		//console.log()
	},
	preLoadPhp(debug = false){
		let validatorJs = document.getElementById("mensagem")
		if (validatorJs){            
			let btFechar = document.querySelector(".bt-fechar-msg")
			if(btFechar){
				btFechar.addEventListener("click", Messenger.fecharMensagem)
			}
			let corpoMensagem = document.querySelector(".corpo-da-mensagem")        
			if (corpoMensagem)
				corpoMensagem.addEventListener("click", Messenger.fecharMensagem)

			if(!debug) Messenger.timerFechar(null)
		}
	},
	view(texto = null, tipo="atencao", timer= null ){
		this.limpar()
		let htmlValidatorJS = `                        
        <div class='corpo-da-mensagem ${tipo}'>
            <span class="corpo-da-mensagem--texto">${texto}</span>
            <a title='Fechar esta opção.' id="fechar-${tipo}"
                class='bt-fechar-msg'>
                <i class='ico ico-close ${tipo}'></i>
            </a>
            <div id="progress-bar"></div> 
        </div>` 
        
		let validatorJs = document.createElement("div")
		validatorJs.id="mensagem"
		validatorJs.classList.add(tipo)            
                    
		validatorJs.innerHTML   = htmlValidatorJS         

		let app = document.querySelector("#app")            
		app.appendChild(validatorJs)
		let btFechar = document.querySelector(".bt-fechar-msg")
		btFechar.addEventListener("click", Messenger.fecharMensagem)

		let corpoMensagem = document.querySelector(".corpo-da-mensagem")        
		if (corpoMensagem)
			corpoMensagem.addEventListener("click", Messenger.fecharMensagem)

		Messenger.timerFechar(timer)

	},
	fecharMensagem(){
		let mensagem = document.querySelector("#mensagem")
		if(!mensagem) return 
		mensagem.classList.add("fechar")

		if(Messenger.data.executar)
			clearTimeout(Messenger.data.executar) 

		Messenger.data.executar = setTimeout(function (){
			let app = document.querySelector("#app")  
			app.removeChild(mensagem)
		}, 1000)
	},
	timerFechar(timer = 6000){
		let barTime = "6s"
		if (timer==null) timer = 6000
		if (timer==10000) barTime = "10s"
		if (timer==3000) barTime = "3s"
		Messenger.progressBar(barTime)              
		if(this.data.executar)
			clearTimeout(this.data.executar)
		this.data.executar = setTimeout(function (){
			Messenger.fecharMensagem() 
		}, timer)

	},
	progressBar(duration,callback){
		let mensagem = document.querySelector("#mensagem")
		if(!mensagem) return 

		let progressbar = document.getElementById("progress-bar")
		if(!progressbar) return 

		progressbar.className = "progressbar"
		let progressbarinner = document.createElement("div")

		progressbarinner.className = "inner"

		// Now we set the animation parameters
		progressbarinner.style.animationDuration = duration

		// Eventually couple a callback
		if (typeof(callback) === "function") {
			progressbarinner.addEventListener("animationend", callback)
		}

		// Append the progressbar to the main progressbardiv
		progressbar.appendChild(progressbarinner)

		// When everything is set up we start the animation
		progressbarinner.style.animationPlayState = "running"


	},
	limpar(){
		let mensagem = document.querySelector("#mensagem")            
		if(mensagem){
			mensagem.parentElement.removeChild(mensagem)                
		}
		if(this.data.executar)
			clearTimeout(this.data.executar)
	}
}

Messenger.preLoad()
export {Messenger}
