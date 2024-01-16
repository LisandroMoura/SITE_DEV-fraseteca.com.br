/**
* First we will load all of this project's JavaScript dependencies which
* includes Vue and other libraries. It is a great starting point when
* building robust, powerful web applications using Vue and Laravel.
*/

//require('./bootstrap');
import Vue from "vue"
window.Vue = require("vue")

//import '../../public/fonts/fontastic/styles.css';

Vue.component("bt-confirma", require("./components/bt_confirma.vue").default)
Vue.component("retorno-msg", require("./components/retorno_msg.vue").default)

//Componentes
Vue.component("capa",       require("./components/capa.vue").default)
Vue.component("random",      require("./components/random_image_generate.vue").default)
Vue.component("nuvem-tag",  require("./components/nuvem_tag.vue").default)
//Vue.component('emoji', require('./components/emoji.vue').default);

import VuejsClipper from "vuejs-clipper"
Vue.use(VuejsClipper)

require("./mixins_backend_admin")
require("./mixins_validatorjs")

import { Messenger } from "../js/includes/Messenger"



const app = new Vue({
	el: "#app",  
	props: ["prop_frases","opcoes","toolbars"],     
	mixins: [mixin, mixin_validatorjs],
	data: {  
		//default       
        
		objConfirma: [{mostra:"nao", evento:"", pergunta:"", aviso:""}],
		objetoRetornoMSG:[{classe: "card fade-out", obj:""}], 
		//custom
		pagina:"frase",
		mostrar:false,
		mostrarThumb:false,
		lcomputador:false,
		lunsplash:false,
		lbiblioteca:false,
		mostraCapa:null,

		//atender a funcionalidade de Thumb para unsplash e computador
		lunsplashThumb:false,
		lcomputadorThumb:false,
        
		unsplashVar:"",
		altPreview:"",        
		msg:"",
		conta:0,
		errosDeValidacao:false,
		loading:"",
		tags:"",
        
		//campos
		idTabela:0,
		titulo:"",        
		frase:"",
		autor:"",
		status:"",
		tipo_imagem:"0",
		imgSrc:null,         
		capa:null,
		alt:"",

		//vuejs-clipper
		origemGaleria:true,
		src: "",
		result: "",
		area:0,
		pixel: "",
		mostraCropZone: false,

		// ● 24-ago-22 LM Projeto20220804 - SEO parametros para a Single de frase
		anunciosOn:"",        
		anuncios:"",
		analytics:"",
		analyticsOn:"",
		lazyOn:"",
		lazyOnOn:"",
		preloadImages:"",
		preloadImagesOn:"",
		
		preloadFonte:"",
		preloadFonteOn:"",
		tipoAnuncio:"",
		lazyAds:"",
		lazyAdsOn:"",
	

       
	},    
	mounted() {
		//default
		this.objetoRetornoMSG[0].obj    = this.$refs.retorno_msg             
		//custom   
		this.mostrar                    = false   
		this.mostraCapa                 = !this.$refs.imgSrc.dataset.src.includes("null") 
		this.idTabela                   = this.$refs.ref_idTabela.value           
		this.titulo                     = this.$refs.ref_titulo.value    
		this.frase                      = this.$refs.ref_frase.value 
		this.autor                      = this.$refs.ref_autor.value 
		// this.tipo_imagem                = this.$refs.ref_tipo_imagem.value
		this.tags                       = this.$refs.ref_tags.value
		this.alt                        = this.$refs.ref_alt.value                    
		this.imgSrc                     = this.$refs.imgSrc.src
		this.capa                       = this.$refs.ref_capa.value                        

		// ● 24-ago-22 LM Projeto20220804 - SEO parametros para a Single de frase
		this.anuncios                   = this.$refs.ref_anuncios.value == "false" ? false : true 
		this.anunciosOn 				= this.$refs.ref_anuncios.value == "true" ? "On" : "Off"     
		this.analytics                  = this.$refs.ref_analytics.value  
		this.analyticsOn 				= this.$refs.ref_analytics.value == true ? "On" : "Off"   
		this.lazyOn                  	= this.$refs.ref_lazyOn.value 
		this.lazyOnOn 					= this.$refs.ref_lazyOn.value == true ? "On" : "Off"
		this.preloadImages              = this.$refs.ref_preloadImages.value  
		this.preloadImagesOn 			= this.$refs.ref_preloadImages.value == true ? "On" : "Off"
		this.preloadFonte              	= this.$refs.ref_preloadFonte.value		
		this.preloadFonte              	= this.$refs.ref_preloadFonte.value  
		this.preloadFonteOn				= this.$refs.ref_preloadFonte.value == true ? "On" : "Off"
		
		this.lazyAds       				= this.$refs.ref_lazyAds.value 
		this.lazyAdsOn					= this.$refs.ref_lazyAds.value == true ? "On" : "Off"

		//trigger to dragSubject Ranger
		this.$refs.ranger.dragSubject$.subscribe(() => {
			// This happens whenever zooming, moving and rotating occur.
			this.vaiZoom()
		})
		Messenger.preLoadPhp()
	},
	updated() {    
		this.altPreview = this.convertToSlug(this.alt) + `-${this.idTabela}.jpg`    
		// ● 24-ago-22 LM Projeto20220804 - SEO parametros para a Single de frase
		if(this.anuncios == "true" || this.anuncios == true) {
			this.anunciosOn = "On" 
			this.$refs.ref_anuncios.value = true
		}
		else{
			this.anunciosOn = "Off"
			this.$refs.ref_anuncios.value = false
		}

		if(this.analytics == "true" || this.analytics == true) {
			this.analyticsOn = "On" 
			this.$refs.ref_analytics.value = true
		}
		else{
			this.analyticsOn = "Off"
			this.$refs.ref_analytics.value = false
		}

		if(this.lazyOn == "true" || this.lazyOn == true) {
			this.lazyOnOn = "On" 
			this.$refs.ref_lazyOn.value = true
		}
		else{
			this.lazyOnOn = "Off"
			this.$refs.ref_lazyOn.value = false
		}

		

		if(this.preloadImages == "true" || this.preloadImages == true) {
			this.preloadImagesOn = "On" 
			this.$refs.ref_preloadImages.value = true
		}
		else{
			this.preloadImagesOn = "Off"
			this.$refs.ref_preloadImages.value = false
		}

		

		if(this.preloadFonte == "true" || this.preloadFonte == true) {
			this.preloadFonteOn = "On" 
			this.$refs.ref_preloadFonte.value = true
		}
		else{
			this.preloadFonteOn = "Off"
			this.$refs.ref_preloadFonte.value = false
		}

		if(this.lazyAds == "true" || this.lazyAds == true) {
			this.lazyAdsOn = "On" 
			this.$refs.ref_lazyAds.value = true
		}
		else{
			this.lazyAdsOn = "Off"
			this.$refs.ref_lazyAds.value = false
		}
	},
	methods: { 
		//default       
		//vuejs-clipper
		convertToSlug(url){
			return url
				.toLowerCase()
				.replace(/ /g, "-")
				.replace(/[^\w-]+/g, "")
		},
		vaiZoom () {            
			let percentual = 0
			if(this.$refs.ranger.value !="NaN")
				percentual = this.$refs.ranger.value
			let zoom = 1 + (percentual/100)
			this.$refs.clipper.setWH$.next(zoom)
		},
		cortar(){
			this.getResult()            
		},
		getResult () {            
			const canvas = this.$refs.clipper.clip({maxWPixel: 1070})
			this.pixel = `${canvas.width} x ${canvas.height}`
			this.result = canvas.toDataURL("image/jpeg")
			this.$refs.imgSrc.src = this.result
			this.avatar_icone  = this.result

			this.capa  = this.result
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

		pesquisarTags: function(event){
			let termo = event.currentTarget.value+"," 
            
			if(this.bancoDeTags.indexOf(termo) != -1)
				this.campoTag = termo
			else
				this.campoTag = ""

		},
		getConfirm: function (formulario, event, perg, avis ) {                         
			event.preventDefault()
			this.objConfirma = [
				{mostra:"sim", evento:this.$refs[formulario], pergunta:perg, aviso:avis}
			]                     
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
		addNewFrase: function(event) {           
			this.frases.push({
				id:"0",
				frase:"",
				autor :"",
			})
		},        
		salvar(){
			if(this.idTabela>0) 
				this.$refs.formulario.setAttribute("action","/frase/"+this.idTabela)
			else 
				this.$refs.formulario.setAttribute("action","/frase")
                
			this.errosDeValidacao = this.validatorEnviarRevisao()
			if(this.errosDeValidacao)
				this.validatorJS("Atenção!!", "Reveja os campos do Cadastro", this.errosDeValidacao)            
		},
		validatorEnviarRevisao: function(){            
			let objetos = {}
			let temErros = false
			if (this.titulo == ""){
				objetos["titulo"]= "Título tem que ser informado"
				temErros=true
			}            
			if(temErros)
				return objetos  
			else this.$refs.formulario.submit()             
			return false
		},
		validaTamanho: function(event) {
			let conta = event.currentTarget.value.length            
			let limite = 0            
			this.$refs.ref_conta.innerHTML = conta            
			limite = this.$refs.ref_limite.innerHTML
			if(conta >= limite){               
				//event.currentTarget.setAttribute('class','red')               
				event.currentTarget.value = event.currentTarget.value.substr(0, limite)
				this.$refs.ref_conta.setAttribute("class","red")
				this.$refs.ref_limite.setAttribute("class","red")
			} else{                
				//event.currentTarget.setAttribute('class','')
				this.$refs.ref_conta.setAttribute("class","")
				this.$refs.ref_limite.setAttribute("class","")
			}
		},        
		validator: function(){            
			var self = this
			let msg = ""
			if (this.titulo == "")
				msg = "Campo título tem que ser informado OK? \n"
			if (this.lista_itens == "")
				msg+= " Precisa ter pelo menos uma frase. OK? \n"
            
			if(msg)
				return msg  
			return false
		},
		startConfirmarCapa(){      
			this.removeImage("")  
			this.loading = "loading"                                         
			this.$refs.pendenteLabel.innerHTML = ""
			this.$refs.pendenteAviso.innerHTML = ""
		},
		endConfirmarCapa(){
			this.mostraCapa = true            
			this.loading = ""
			this.$refs.imgSrc.setAttribute("class","avatar pendente")
			this.$refs.preview.setAttribute("class","preview-imagem container pendente")
			// this.$refs.pendenteLabel.innerHTML = "Quase lá!";
			// this.$refs.pendenteAviso.innerHTML = "Clique em Salvar para confirmar a alteração!";
		},
		removeImage: function(result){            
			this.capa  = "null"
			this.imgSrc = "null"            
			this.mostraCapa = false
			this.$refs.imgSrc.src = "null"
			this.avatar_icone  = "null"                        
		},  
		imageCreate: function(frase){
			const formData = new FormData()          
			formData.append("wantsJson","true")
			formData.append("id",this.idTabela)
			formData.append("frase",frase)
			formData.append("autor",this.autor)
			formData.append("tipo_imagem",this.tipo_imagem)

			//aki: inserir o campo tipoDeImagem

			axios.post("/frase/imagecreate",formData)
				.then(respo => {                         
					if(respo.data.sucesso){                    
						this.validatorJS(this.titulo_sucesso, "Imagem Gerada com sucesso :) Agora é só salvar", null, "sucesso")
						this.setaCapa("/" + respo.data.data.srcIgm)
						//self.$refs.imgSrc.src = "/" + respo.data.data.srcIgm
					}                
					else{
						this.validatorJS(this.titulo_erro, "Não deu! Imagem Trancada? tente destrancá-la antes de alterar a capa.", null, "erro")
					}                  
				})
		},
	}, 
})

import { Post } from "../jsback/Post"
Post.preLoad()
