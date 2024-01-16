/* eslint-disable no-unused-vars */
import { CallConfirm } from "./Callconfirm"
import { Contador } from "./Contador.js"
const Perfil = {
	data: {
		labreMenu: "",
	},
	preLoad() {
		//trigger do callConfirm
		let btCallConfirm = document.querySelectorAll(".callConfirm")
		let callBack = document.querySelector(".callBack")
		let lbBtConfirma = "Confirmar"
		let lbBtCancela = "Cancelar"
		let titulo = "Excluir Conta?"
		let classBt = ""
		btCallConfirm.forEach(element => {
			element.onclick = function (e) {
				let pergunta = e.target.title || "Após excluído, o perfil não poderá ser restaurado"
				e.stopPropagation()
				e.preventDefault()

				if (e.target.attributes.length > 0) {
					if (e.target.attributes["data-label-botao"].nodeValue)
						lbBtConfirma = e.target.attributes["data-label-botao"].nodeValue
					if (e.target.attributes["data-titulo"].nodeValue)
						titulo = e.target.attributes["data-titulo"].nodeValue
					if (e.target.attributes["data-classbt"].nodeValue)
						classBt = e.target.attributes["data-classbt"].nodeValue
				}
				if (callBack)
					CallConfirm.openView(callBack, pergunta, "confirma info", titulo, null, "",lbBtConfirma, lbBtCancela,classBt)
				else
					CallConfirm.openView(null, pergunta, "confirma info", titulo, null, "",lbBtConfirma,lbBtCancela,classBt)
			}
		})
		// // validação dos campos Senhas
		let abrir_trocar_senha = document.querySelectorAll(".abrir_trocar_senha")
		if (abrir_trocar_senha) {
			abrir_trocar_senha.forEach(element => {
				element.onclick = () => {
					Perfil.show()
				}
			})
		}
		// calcula qtde De Caracteres digitado            
		let campoParaCalcular = document.getElementById("informacoes_biograficas")
		if (campoParaCalcular) {
			campoParaCalcular.oninput = (e) => {
				Contador.contaCaracteres(e)
			}
		}

		let  btSalvarPerfil = document.getElementById("btSalvarPerfil")
		if(btSalvarPerfil) {
			btSalvarPerfil.onclick = (e) => {
				e.stopPropagation()
				e.preventDefault()

				let process = Perfil.verificaSePrecisaClicarEmCortar()                
				if (process){
					let btCortar = document.getElementById("btCortar")  
					if(btCortar){
						let cortar = new Promise((resolve, reject) => {
							btCortar.click()
						})
					}                    
				}                 
				let salvarBT = new Promise((resolve, reject) => {
					Perfil.salvar()
				}) 

			}
		}

	},
	async salvar(){ 
        
		let formulario = document.getElementById("formulario")
		if(formulario){
			//validar alguma coisa, e submeter
			formulario.submit()
		}
	},
	verificaSePrecisaClicarEmCortar(){
		let imgPronta = document.getElementById("img-pronta")
		let cropjsZone = document.getElementById("cropjs-zone")

		if (!imgPronta || !cropjsZone) return false

		if(imgPronta.classList.contains("emedicao")) return true
		if(cropjsZone.classList.contains("emedicao")) return true
		return false
	},
	validaCampoSenha() {
		let passAtual = document.getElementById("password_atual")
		let passNew = document.getElementById("password_new")
		let passRepeat = document.getElementById("password_repeat")
		let btSalvarTrocaDeSenha = document.getElementById("btSalvarTrocaDeSenha")

		let validaOk = true
		if (!passAtual) return
		if (!passNew) return
		if (!passRepeat) return
		if (!btSalvarTrocaDeSenha) return

		if (passAtual.value == "") validaOk = false
		if (passNew.value == "") validaOk = false
		if (passRepeat.value == "") validaOk = false

		if (passAtual.value.length < 6) validaOk = false
		if (passNew.value.length < 6) validaOk = false
		if (passRepeat.value.length < 6) validaOk = false

		if (passNew.value != passRepeat.value) validaOk = false

		if (validaOk)
			btSalvarTrocaDeSenha.classList.remove("nok")
		else
			btSalvarTrocaDeSenha.classList.add("nok")
	},
	show() {
		Perfil.clear()
		let html = ""
		let footer = ""
		let head = ` 
		<div id="pesquisa" class="full-modal">
		<div class="wrapper-pesquisa jsupload">            
		<header class="flex">
		<a id="bt-sair-jsupload" class="bt-sair-pesquisa"><i class="ico ico-sair ico-exit"></i></a>           
		<h2>Alterando a sua senha</h2> </header>  `
		footer += `                
        </div></div>`
		html += `
        <section class="form--update--pass">  
			<div class="campos">          
                <div class="campo">
                    <input type="password" id="password_atual" class="input_trocar_senha validaSenha"  name="password_atual" placeholder="Senha atual">
                </div>
                <div class="campo">
                    <input type="password" id="password_new" class="input_trocar_senha validaSenha" name="password_new" placeholder="Nova senha">
                </div>
                <div class="campo">
                    <input type="password" id="password_repeat" class="input_trocar_senha validaSenha" name="password_repeat" placeholder="Confirmar nova senha">
                </div>
                <button type="submit" id="btSalvarTrocaDeSenha" class="botao-padrao red full save save-branco submit bt-center  nok" title="Salvar Nova Senha">            
                    <i class="icon-save save-branco icon save save-branco"></i>
                    <span>Salvar Nova Senha</span>
                </button>
			</div>
        </section>`
		let wrapper = document.getElementById("trocarSenhaBefore")
		wrapper.innerHTML = head + html + footer
		wrapper.classList.add("ativado")
		Perfil.triggers()
	},
	sair() {
		let pesquisa = document.getElementById("trocarSenhaBefore")
		pesquisa.classList.remove("ativado")
	},

	clear() {
		let pesquisa = document.getElementById("trocarSenhaBefore")
		pesquisa.innerHTML = ""
	},
	triggers() {
		let btSairPesquisa = document.getElementById("bt-sair-jsupload")
		if (btSairPesquisa) {
			btSairPesquisa.onclick = (e) => {
				e.stopPropagation()
				e.preventDefault()
				Perfil.sair()
			}
		}
		let arrCamposValidaSenha = document.querySelectorAll(".validaSenha")
		arrCamposValidaSenha.forEach(campo => {
			campo.oninput = (e) => {
				Perfil.validaCampoSenha(e)
			}
		})
	},

}
export { Perfil }