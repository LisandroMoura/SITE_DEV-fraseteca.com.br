/**
* First we will load all of this project's JavaScript dependencies which
* includes Vue and other libraries. It is a great starting point when
* building robust, powerful web applications using Vue and Laravel.
*/

import Vue from "vue"
window.Vue = require("vue")


//require('./bootstrap');

//import '../../public/fonts/fontastic/styles.css';

import _ from "lodash"

Vue.component("bt-confirma", require("./components/bt_confirma.vue").default)

Vue.component("retorno-msg", require("./components/retorno_msg.vue").default)

Vue.component("dispositivo", require("./components/upload_dispositivo.vue").default)
//Vue.component('avatar-galeria', require('./components/avatar_galeria.vue').default);
Vue.component("capa-unsplash", require("./components/capa_unsplash.vue").default)

//Mais um componente
Vue.component("frases-favoritas", require("./components/getFrasesFavoritas.vue").default)
Vue.component("emoji", require("./components/emoji.vue").default)

Vue.component("remessas",     require("./components/remessas.vue").default)

import VuejsClipper from "vuejs-clipper"
Vue.use(VuejsClipper)

// import '../sass/backend/uploaders.scss' ;     
require("./mixins_backend_admin")
require("./mixins_validatorjs")

import { Messenger } from "../js/includes/Messenger"
/**
  * Não esquecer de rodar bash:  npm run dev 
  */    
const app = new Vue({
	el: "#app",  
	props: ["info","opcoes"], 
	mixins:[mixin,mixin_validatorjs],     
	data: {
		//default
		objConfirma: [{mostra:"nao", evento:"", pergunta:"", aviso:"", vaction:""}],         
		objetoRetornoMSG:[{classe: "card fade-out", obj:""}],                          
		abreConfigClass:"",
		//custom
		mostrarComputador:false,
		mostrarGaleria:false,
		escolhido:"",
		mostrar:false,
		lcomputador:false,
		lunsplash:false,
		lbiblioteca:false,
		imgSrc:null, 
		thumb:null, 
		capa:null,
		mostraCapa:null,
		unsplashVar:"",
		msg:"",
		conta:0,
		errosDeValidacao:false,
		//resolver:"", 
		idDaLista:0,
		titulo:"",
		descricao_previa:"",
		deletados:[],
		loading:false,         
		//status:0,
		frases:[
			{ id :"", frase :"", frase_id:"", autor :"",id_lista:"",titulo:"",tipoImage:"",}
		],
		frases_old:[
			{ id :"", frase :"", frase_id:"", autor :"",id_lista:"",titulo:"",tipoImage:"",}
		],
		tokenTipoImagem:"",
		lista_itens:"",
		numberOfBoxesUsed:10,         
		numberOfAddBoxes:1,
		waiting:false,
		classwait:"teste",
		//vuejs-clipper
		origemGaleria:true,
		src: "",
		result: "",
		area:0,
		pixel: "",
		mostraCropZone: false,
		fazendoUpload:false,
		unsplashIdFotoAtual:"",
        
	},    
	mounted() {  
		//default
		let self = this
		this.objetoRetornoMSG[0].obj    = this.$refs.retorno_msg             
		//custom            
		this.mostrar                    = false   

		this.titulo                     = this.$refs.ref_titulo.value    
		//this.status                     = this.$refs.ref_status.value;             
		this.idDaLista                  = this.$refs.ref_idDaLista.value   
		//this.descricao_previa           = this.$refs.ref_descricao_previa.value;                 
		this.deletados                  = this.$refs.ref_deletados.value                   
		this.frases_old                 = this.$refs.ref_frases_old.value
		this.numberOfBoxesUsed          = this.$refs.ref_conteudo.value ? parseInt(this.$refs.ref_conteudo.value) : 10 
		this.mostraCropZone             = false    

		this.unsplashIdFotoAtual        = this.$refs.ref_unsplashIdFotoAtual.value 
		//this.$refs.lblAviso.innerHTML="ps: Clique Salvar para confirmar a alteração!"
		//trigger to dragSubject Ranger

		if (this.frases_old){
			//call the method             
			this.getOldFrases(this.frases_old)
		}
		else {
			//here: to review             
			axios.get("/api/lista/listar_json/"+self.idDaLista, {})
				.then(response => {
					self.frases = response.data    
					console.log(response.data)                 
					self.calcNumberFrases(self.numberOfBoxesUsed - self.frases.length)
				})
				.catch(error => {
					this.frases =error
				})            
		}

	},     
	methods: {         
		getOldFrases(frases_old){
			let lista_itens            
			lista_itens = frases_old.split("#lista_itens#")
			let index = 0  
			//zerar o primeiro box de frases que o sistema gera
			// reset thr first BOX of PHRases the system
			this.frases = [] 
			lista_itens.forEach(item => {                
				if(item!=""){
					let linha = item.split("#elemento#")
					if (linha){                       
						let arr = { id :linha[0], frase :linha[1] , frase_id:linha[2], autor :linha[3],id_lista:0,titulo:""}
						this.frases.push(arr)                        
					}
				}
				index++                
			})
			return ""            
		},
		//vuejs-clipper
		vaiZoom () {            
			let percentual = 0
			if(this.$refs.ranger.value !="NaN")
				percentual = this.$refs.ranger.value
			let zoom = 1 + (percentual/100)
			this.$refs.clipper.setWH$.next(zoom)
		},
		editarCrop(){
			this.mostraCropZone=!this.mostraCropZone
		},
		cortar(){
			this.getResult()
			if (this.idDaLista != "0") {
				setTimeout(function(){
					//save
					self.enviarParaRascunho("")
				},500)
			}
			else {
				this.mostraCropZone=false            
			}
		},
		getResult () {            
			const canvas = this.$refs.clipper.clip({wPixel: 1070})
			this.pixel = `${canvas.width} x ${canvas.height}`            
            
			this.result = canvas.toDataURL("image/jpeg")
			this.$refs.imgSrc.src = this.result
			this.avatar_icone  = this.result            
			this.setaThumb(this.result)
		},
		//vuejs-clipper
		clip () {
			this.getResult()
			const a = document.createElement("A")
			a.download = "result.jpg"
			a.href = this.result
			a.target = "_blank"
			a.click()
		},      
		getConfirm: function (formulario, event, perg, avis, action, lbconfirma, lbcancela ) {                         
			event.preventDefault()                
			this.objConfirma = [
				{mostra:"sim", evento:this.$refs[formulario], pergunta:perg, aviso:avis, vaction:action, lbconfirma:lbconfirma, lbcancela:lbcancela}
			]                     
		},
		openConfig: function (){            
			if (this.abreConfigClass=="")
				this.abreConfigClass = "ativo" 
			else
				this.abreConfigClass = ""
		},
		//custom
		setaCapa: function(result){            
			this.$refs.imgSrc.src = result
			this.capa  = result
			this.imgSrc = this.$refs.imgSrc.src
			//vuejs-clipper 
			this.src = result
		},
		setaThumb: function(result){
			this.$refs.ref_thumb.value = result
			this.thumb  = result  
		},

		setaFrase: function(frase, autor, idDaFrase, index){
			this.frases[index].frase_id = idDaFrase
			this.frases[index].frase = frase
			this.frases[index].autor = autor           
		},

		setaEmoji: function(emoji, index){   
			let tArea       = this.$refs.textareas[index]
			let startPos    = tArea.selectionStart
			let endPos      = tArea.selectionEnd
			let cursorPos   = startPos
			let tmpStr      = tArea.value
			let insert      = emoji.data 
			this.frases[index].frase = tmpStr.substring(0, startPos) + insert + tmpStr.substring(endPos, tmpStr.length)
			// move cursor:
			setTimeout(() => {
				cursorPos += insert.length
				tArea.selectionStart = tArea.selectionEnd = cursorPos
			}, 10)            
		},
		calcNumberFrases: function (nitems){                
			for (let index = 0; index < nitems; index++) {                
				this.addNewFrase("")
			}
		},
		showBoxaddFrase: function(event) {
			let box = document.querySelector(".add-boxes")
			box.classList.add("show")
		},
		hideBoxaddFrase: function(event) {
			let box = document.querySelector(".add-boxes")
			box.classList.remove("show")
		},
		addFrase: function(event) { 
			this.loading=true
			let loadTimer
			self = this
			loadTimer = setTimeout(function() {                
				const goExec = new Promise( (resolutionFunc) => {
					self.classwait = "show"  
					resolutionFunc("sucess")
				})
				goExec
					.then(self.calcNumberFrases(self.numberOfAddBoxes))
					.then(self.classwait = "")
					.then(self.loading=false)

			},20)
			//clearTimeout(loadTimer);
			/* */
		},
		addNewFrase: function(event) {   
			this.frases.push({
				id:"0",
				frase:"",
				autor :"",
			})
			this.$refs.ref_conteudo.value = this.frases.length
		},
		removeFrase: function(index) { 
			this.deletados = this.frases[index].id+";"            
			this.frases.splice(index, 1)

			this.$refs.ref_conteudo.value = this.frases.length
		}, 
		aprovar(){            
			this.$refs.formulario_aprova.setAttribute("action","/admin/gestao/aprova/aprovar")
			//this.$refs.resolver = "aprovar";
			this.$refs.formulario_aprova.submit()             
			return false
		},
		rejeitar(){
			this.$refs.formulario_aprova.setAttribute("action","/admin/gestao/aprova/rejeitar")
			//this.$refs.resolver = "rejeitar";
			this.$refs.formulario_aprova.submit()             
			return false
		},
		enviarParaRevisao(){
			if(this.idDaLista>0) {
				this.$refs.formulario.setAttribute("action","/lista/revisao/"+this.idDaLista)
			}                
			else {
				this.$refs.formulario.setAttribute("action","/lista/storerevisao")
			}
			this.getListaItens("revisao")
		},
		enviarParaRascunho(){
          
			if(this.idDaLista>0) 
				this.$refs.formulario.setAttribute("action","/lista/"+this.idDaLista)
			else 
				this.$refs.formulario.setAttribute("action","/lista")
			this.getListaItens("rascunho")
		},
		setTokenTipoImage: function(index,value){
            
			this.tokenTipoImagem=""
			this.frases[index].tipoImage=value

			let ncount = 0
			this.frases.forEach(element => {                   
				if(element.tipoImage != undefined) {                    
					this.tokenTipoImagem += (ncount +1)  + ";" + element.id + ";" +  element.tipoImage +"||"  
				}                
				ncount++                
			})            
		},
		getListaItens: function(event){

			
			let self = this
			self.lista_itens = ""
			this.frases.forEach(element => {                
				if(element.frase!="")
					self.lista_itens +=  element.id + "#elemento#" + element.frase + "#elemento#" + element.frase_id + "#elemento#" +  element.autor  + "#lista_itens#" 
			})
			self.$refs.lista_itens.innerHTML = self.lista_itens
            

			console.log(self.lista_itens)
			
			if (event=="savejson")  {
				this.errosDeValidacao = this.validatorJSON()
				if(this.errosDeValidacao){
					this.validatorJS("Atenção!!", "Reveja os campos do Cadastro", this.errosDeValidacao)
					return true
				}
				return false
			}
                
			if (event=="revisao") 
				this.errosDeValidacao = this.validatorEnviarRevisao()
			else
				this.errosDeValidacao = this.validator()
			if(this.errosDeValidacao){
				this.validatorJS("Atenção!!", "Reveja os campos do Cadastro", this.errosDeValidacao)
			}
		},
		validatorEnviarRevisao: function(){            
			let objetos = {}
			let temErros = false            
			let contagem = 0

			if (this.titulo == ""){
				objetos["titulo"]= "Título tem que ser informado"
				temErros=true
			}
                
			// if (this.lista_itens == ''){
			//     objetos["frase_0"]= 'Insira pelo menos uma frase'
			//     temErros=true            
			// }
                
			this.frases.forEach(element => {                
				if (element.frase!="")
					contagem++                                   
			})

			if (contagem < 10 ){
				objetos["frase_"+ (contagem-1)]= "A lista precisa ter, no mínimo, 10 Frases"
				temErros=true            
			}
            
			if(temErros)
				return objetos  
			else this.$refs.formulario.submit()             
			return false
		},

		validator: function(){                        
			let objetos = {}
			let temErros = false

			if (this.titulo == ""){
				objetos["titulo"]= "Você precisa escrever um título"
				temErros=true
			}
                
			// if (this.lista_itens == ''){
			//     objetos["frase_0"]= 'Insira pelo menos uma frase'
			//     temErros=true            
			// }
            
			if(temErros)
				return objetos  
			else this.$refs.formulario.submit()             
			return false
		},  
		validatorJSON: function(){                        
			let objetos = {}
			let temErros = false

			if (this.titulo == ""){
				objetos["titulo"]= "Você precisa escrever um título"
				temErros=true
			}
			if(temErros)
				return objetos              
			return false
		},       
		setaAvatar: function(result){    
			this.capa  = result
			this.imgSrc = result
			this.$refs.imgSrc.src = result
			this.avatar_icone  = result    
			//vuejs-clipper 
			this.src = result            

		},
		startConfirmarCapa(){      
			this.removeImage("")  
			this.loading = "loading"                                         
			this.$refs.pendenteLabel.innerHTML = ""
			this.$refs.pendenteAviso.innerHTML = ""
		},
		endConfirmarCapa(){
			self = this
			this.mostraCapa = true            
			this.loading = ""
			this.$refs.imgSrc.setAttribute("class","avatar pendente")
			this.$refs.preview.setAttribute("class","preview-imagem container pendente")    
			setTimeout(function(){
				self.getResult()
			},2000)    
            
		},
		removeImage: function(result){            
			this.capa  = "null"
			this.imgSrc = "null"            
			this.mostraCapa = false
			this.$refs.imgSrc.src = "null"
			this.avatar_icone  = "null"                        
		},
		//The save system with Ajax
		save(e){    
			e.preventDefault()
			e.stopPropagation()

			let self = this
			let id = 0

			self.mostraCropZone=false

			//return "true" - if found erros validation
			if (this.getListaItens("savejson"))
				return 

			const formData = this.getFormData()
			//Update Sistem            
			if (this.idDaLista != "0") {
				axios.post("/lista/save",formData)
					.then(respo => {
						if(respo.data.sucess){
							this.validatorJS(this.titulo_sucesso, `${respo.data.msg}`, null, "sucesso")
							this.$refs.ref_idDaLista.value = respo.data.data.registro.id
							this.idDaLista= respo.data.data.registro.id

							this.frases=[]
							this.frases = respo.data.listaitem
							id=respo.data.data.registro.id
							self.$refs.formulario.setAttribute("action","/lista/update/"+id)
							self.$refs.formulario.setAttribute("method","post")
							self.$refs.method.setAttribute("value","put")
                        
							//re-process the number of box in document
							this.calcNumberFrases(this.numberOfBoxesUsed - this.frases.length)
						}
						else{
							this.validatorJS(this.titulo_erro, `${respo.data.msg}`, null, "erro")
						}
					})
			} else {
				//create system
				//this.getResult()
				axios.post("/lista",formData)
					.then(respo => {
						if(respo.data.sucess){
							this.validatorJS(this.titulo_sucesso, `${respo.data.msg}`, null, "sucesso")
							this.$refs.ref_idDaLista.value = respo.data.data.registro.id
							this.idDaLista= respo.data.data.registro.id
							id=respo.data.data.registro.id
							self.$refs.formulario.setAttribute("action","/lista/update/"+id)
							self.$refs.formulario.setAttribute("method","post")
							self.$refs.method.setAttribute("value","put")
							this.frases=[]
							this.frases = respo.data.listaitem
						}
						else{
							this.validatorJS(this.titulo_erro, `${respo.data.msg}`, null, "erro")
						}
					})
			}
			//change form method to "PUT"
		},
		getFormData(){
			const formData = new FormData()
			formData.append("type","json")
			formData.append("id",this.idDaLista)
			formData.append("usuario_id",this.$refs.ref_usuario_id.value)            
			formData.append("titulo",document.querySelector("#titulo").value)
            
			//formData.append('descricao_previa',document.querySelector("#descricao_previa").value)
			// formData.append("capa",document.querySelector("#capa").value)        
			// formData.append("thumb",document.querySelector("#capa").value)
			// formData.append("midia_id",document.querySelector("#midia_id").value)
			formData.append("categoria_id",document.querySelector("#categoria_id").value)
			formData.append("frases_old",document.querySelector("#frases_old").value)
			formData.append("deletados",document.querySelector("#deletados").value)
			formData.append("status",document.querySelector("#status").value)
			formData.append("conteudo",document.querySelector("#conteudo").value)
			formData.append("lista_itens",document.querySelector("#lista_itens").value)
			// formData.append("result",document.querySelector("#result").value)        
			// formData.append("unsplashIdFotoAtual",document.querySelector("#unsplashIdFotoAtual").value)        
			if (document.querySelector("#file") ){                
				formData.append("file",document.querySelector("#file").files[0])
			}
			return formData
		},
	},
})