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

//Componentes
Vue.component("capa",       require("./components/capa.vue").default)
Vue.component("mobile",      require("./components/mobile.vue").default)
Vue.component("thumb",      require("./components/thumb.vue").default)
Vue.component("nuvem-tag",  require("./components/nuvem_tag.vue").default)
Vue.component("posts-rel",  require("./components/posts_rel.vue").default)

//componente antigo
Vue.component("editor",     require("./components/editor.vue").default)

Vue.component("posts_itens",     require("./components/posts_itens.vue").default)

//Vue.component('emoji', require('./components/emoji.vue').default);

import VuejsClipper from "vuejs-clipper"
Vue.use(VuejsClipper)

// import "../sass/back/includes/Uploaderadm.scss"      

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
		pagina:"post",
		mostrar:false,
		mostrarThumb:false,
		lcomputador:false,
		lunsplash:false,
		lbiblioteca:false,
		unsplashIdFotoAtual:"",
		unsplashIdFotoAtualThumb:"",
		//atender a funcionalidade de Thumb para unsplash e computador
		lunsplashThumb:false,
		lcomputadorThumb:false,

		imgSrc:null, 
		thumb:null, 
		capa:null,
		mostraCapa:null,
		unsplashVar:"",
		msg:"",
		conta:0,
		errosDeValidacao:false,
		idDoPost:0,
		titulo:"",        
		resumo:"",
		introducao:"",
		alt:"",        
		altPreview:"",        

		anunciosOn:"",        
		anuncios:"",
		analytics:"",
		analyticsOn:"",
		lazyOn:"",
		lazyOnOn:"",
		momentolazy:"",		
		preloadImages:"",
		preloadImagesOn:"",
		atrasoAmp:"",
		atrasoAmpOn:"",
		preloadFonte:"",
		preloadFonteOn:"",
		imagemforte:"",
		tipoAnuncio:"",
		lazyAds:"",
		lazyAdsOn:"",
		lazyImgInicial:"",
		lazyImgInicialOn:"",

		mostrarNaIndex:"",
		urlamigavel:"",
		tags:"",        
		corpo:"",
		itens:"",
		campoTag:"",
		bancoDeTags:"",
		status:"",
		loading:"",
		//vuejs-clipper
		origemGaleria:true,
		src: "",
		result: "",
		resultThumb: "",
		area:0,
		pixel: "",
		mostraCropZone: false,
		unsplash_src:"",

       
	},    
	mounted() {
		//default
		this.objetoRetornoMSG[0].obj    = this.$refs.retorno_msg             
		//custom   
		this.mostrar                    = false   
		this.mostraCapa                 = !this.$refs.imgSrc.dataset.src.includes("null") 
		this.imgSrc                     = this.$refs.imgSrc.src
		this.src                        = this.imgSrc
		this.capa                       = this.$refs.ref_capa.value        
		this.mobile                     = this.$refs.ref_mobile.value             
		this.thumb                      = this.$refs.ref_thumb.value             
		this.titulo                     = this.$refs.ref_titulo.value    
		
		this.anuncios                   = this.$refs.ref_anuncios.value == "false" ? false : true 
		this.anunciosOn 				= this.$refs.ref_anuncios.value == "true" ? "On" : "Off"     
		this.analytics                  = this.$refs.ref_analytics.value  
		this.analyticsOn 				= this.$refs.ref_analytics.value == true ? "On" : "Off"   
		this.lazyOn                  	= this.$refs.ref_lazyOn.value 
		this.lazyOnOn 					= this.$refs.ref_lazyOn.value == true ? "On" : "Off"
		this.preloadImages              = this.$refs.ref_preloadImages.value  
		this.preloadImagesOn 			= this.$refs.ref_preloadImages.value == true ? "On" : "Off"
		this.preloadFonte              	= this.$refs.ref_preloadFonte.value  
		this.atrasoAmp              	= this.$refs.ref_atrasoAmp.value  
		this.atrasoAmpOn 				= this.$refs.ref_atrasoAmp.value == true ? "On" : "Off"
		this.preloadFonte              	= this.$refs.ref_preloadFonte.value  
		this.preloadFonteOn				= this.$refs.ref_preloadFonte.value == true ? "On" : "Off"
		this.lazyImgInicial            	= this.$refs.ref_lazyImgInicial.value 
		this.lazyImgInicialOn			= this.$refs.ref_lazyImgInicial.value == true ? "On" : "Off"
		this.lazyAds       				= this.$refs.ref_lazyAds.value 
		this.lazyAdsOn					= this.$refs.ref_lazyAds.value == true ? "On" : "Off"

		this.alt                        = this.$refs.ref_alt.value            
		//this.altPreview                 = this.convertToSlug(this.$refs.ref_alt.value);    
		this.idDoPost                   = this.$refs.ref_idDoPost.value   
		this.resumo                     = this.$refs.ref_resumo.value 
		this.introducao                 = this.$refs.ref_introducao.value 
		this.mostrarNaIndex             = this.$refs.ref_mostrarNaIndex.value 
		this.urlamigavel                = this.$refs.ref_urlamigavel.value 
		this.tags                       = this.$refs.ref_tags.value        
		//this.corpo                      = this.$refs.ref_corpo.value; 
		//this.bancoDeTags                = this.$refs.ref_bancoDeTags.value;

		this.unsplashIdFotoAtual        = this.$refs.ref_unsplashIdFotoAtual.value 
		this.unsplashIdFotoAtualThumb   = this.$refs.ref_unsplashIdFotoAtualThumb.value 
        

		//trigger to dragSubject Ranger
		this.$refs.ranger.dragSubject$.subscribe(() => {
			// This happens whenever zooming, moving and rotating occur.
			this.vaiZoom()
		})

		Messenger.preLoadPhp()

            
	},
	updated() {     

		this.altPreview = this.convertToSlug(this.alt) + "-13478.jpg"   
		
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

		if(this.lazyImgInicial == "true" || this.lazyImgInicial == true) {
			this.lazyImgInicialOn = "On" 
			this.$refs.ref_lazyImgInicial.value = true
		}
		else{
			this.lazyImgInicialOn = "Off"
			this.$refs.ref_lazyImgInicial.value = false
		}

		if(this.preloadImages == "true" || this.preloadImages == true) {
			this.preloadImagesOn = "On" 
			this.$refs.ref_preloadImages.value = true
		}
		else{
			this.preloadImagesOn = "Off"
			this.$refs.ref_preloadImages.value = false
		}

		if(this.atrasoAmp == "true" || this.atrasoAmp == true) {
			this.atrasoAmpOn = "On" 
			this.$refs.ref_atrasoAmp.value = true
		}
		else{
			this.atrasoAmpOn = "Off"
			this.$refs.ref_atrasoAmp.value = false
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
			let self = this
			this.getResult()
			setTimeout(function(){
				//save
				self.enviarParaRascunho("")
			},500)
		},
		getResult () {            
			const canvas = this.$refs.clipper.clip({maxWPixel: 1070})
			this.pixel = `${canvas.width} x ${canvas.height}`
			this.result = canvas.toDataURL("image/jpeg")
			this.$refs.imgSrc.src = this.result
			this.avatar_icone  = this.result
			this.capa  = this.result
			this.unsplash_src= this.result
		},
		cortarMobile(){
			let self = this
			this.getResultMobile()
			setTimeout(function(){
				//save
				self.enviarParaRascunho("")
			},500)
		},
		cortarThumb(){
			let self = this
			this.getResultThumb()
			setTimeout(function(){
				//save
				self.enviarParaRascunho("")
			},500)
		},
		getResultMobile () { 
			const canvasMobile = this.$refs.clipper_mobile.clip({maxWPixel: 340})
			this.pixel = `${canvasMobile.width} x ${canvasMobile.height}`
			this.resultMobile = canvasMobile.toDataURL("image/jpeg")            
			this.$refs.ref_mobile.value = this.resultMobile
			this.mobile  = this.resultMobile                          
		},

		getResultThumb () { 
			const canvasThumb = this.$refs.clipper_thumb.clip({maxWPixel: 191})
			this.pixel = `${canvasThumb.width} x ${canvasThumb.height}`
			this.resultThumb = canvasThumb.toDataURL("image/jpeg")            
			this.$refs.ref_thumb.value = this.resultThumb
			this.thumb  = this.resultThumb                          
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
		setaMobile: function(result){
			this.$refs.ref_mobile.value = result
			this.mobile  = result  
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
		publicar(){            
			this.$refs.formulario.setAttribute("action","/post/publicar/"+this.idDoPost) 
			this.errosDeValidacao = this.validatorEnviarRevisao()
			if(this.errosDeValidacao)
				this.validatorJS("Atenção!!", "Reveja os campos do Cadastro", this.errosDeValidacao)            
		},
		enviarParaRascunho(){
			// this.status = '3';
			// this.$refs.ref_status.value = '3';
			if(this.idDoPost>0) 
				this.$refs.formulario.setAttribute("action","/post/"+this.idDoPost)
			else 
				this.$refs.formulario.setAttribute("action","/post")
                
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

	}, 
})