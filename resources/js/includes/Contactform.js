const ContactForm = {
	data: {
		labreMenu:"",
	},
	preLoad(){
		let assunto             = document.getElementById("assunto")
		let publicar            = document.getElementById("bt-g-recaptcha-submit")
		let formulario          = document.getElementById("form01Contato")
		// Fraseteca2023Set03
		let recaptchaResponse   = document.getElementById("g-recaptcha-response")
		if(assunto){
			assunto.addEventListener ("change", e => {
				if(e.target.value !="notselected"){
					publicar.classList.add("ok")
					publicar.classList.remove("nok")
				}
				else{
					publicar.classList.remove("ok")
					publicar.classList.add("nok")
				}
			})
		}
		if(publicar){
			publicar.onclick = (e) => {
				e.stopPropagation()
				e.preventDefault()

				// if(formulario){
				// 	// Fraseteca2023Set03
				// 	formulario.submit()
				// }

				// Fraseteca2023Set03
				grecaptcha.ready(function() {
					grecaptcha.execute("asdasdasd", {action: "submit"}).then(function(token) {
						if(formulario){
							recaptchaResponse.value = token
							formulario.submit()
						}
					})
				})
			}
		}
	},
}
export {ContactForm}
