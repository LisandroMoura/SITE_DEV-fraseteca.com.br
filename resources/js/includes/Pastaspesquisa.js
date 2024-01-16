/* eslint-disable no-unused-vars */
/* eslint-disable no-undef */
require("./Axios")
const Pesquisa = { 
	props:{
		arrDataPesquisa:[],
		totalResult:0,
		ultimoTermoPesquisado:"",
		paginaAtual:1,
	},   
	preLoad(){
		let btPesquisar = document.getElementById("btPesquisar")        
		if(btPesquisar){
			btPesquisar.onclick = (e) =>{ 
				e.stopPropagation()               
				e.preventDefault()  
				Pesquisa.props.paginaAtual=1              
				Pesquisa.buscarDados()
			}
		}        
		let btAcrescentar = document.getElementById("acrescentar")
		if(btAcrescentar){
			btAcrescentar.onclick = (e) =>{ 
				e.stopPropagation()               
				e.preventDefault()
				//para cada item selecionado no li>radio
				Pesquisa.acrescentar()
			}
		}        
		let btSairPesquisa = document.getElementById("bt-sair-pesquisa")
		if(btSairPesquisa){
			btSairPesquisa.onclick = (e) =>{ 
				e.stopPropagation()               
				e.preventDefault()
				Pesquisa.sair()
			}
		}
		let radioPesquisa = document.querySelectorAll(".radio_resultados")
		radioPesquisa.forEach(element => {            
			element.onclick = (radio) => { 
				if (document.querySelectorAll("input.radio_resultados[type=\"checkbox\"]:checked").length>0)
					btAcrescentar.classList.remove("nok")
				else 
					btAcrescentar.classList.add("nok")
			}
		})
		let btCarregarMais = document.querySelector(".carregar-mais")
		if(btCarregarMais){
			btCarregarMais.onclick = (e) =>{
				e.stopPropagation()               
				e.preventDefault()
				Pesquisa.props.paginaAtual++
				Pesquisa.navegar(Pesquisa.props.paginaAtual)
			}
		}
	},
	
	navegar(paginaAtual){
		// let query = "" 
		// const formData = new FormData();            
		// formData.append('query',query);
		let input_pesquisar = document.getElementById("pesquisar") 
		//pendente> metodo correto
		axios.get("/api/pastas/pesquisar/" + input_pesquisar.value+"/?page="+paginaAtual)        
			.then(respo => {
				if(respo.data.isAvail){                                                        
					//Pesquisa.props.totalResult = respo.data.dados.total                                
					Pesquisa.resultadoDaNavegacao(respo.data.dados.data)
				}                
				// else{
				// }
			})
	},
	buscarDados(){
		// let query = "" 
		// const formData = new FormData();            
		// formData.append('query',query);
		let input_pesquisar = document.getElementById("pesquisar")
		//pendente> metodo correto        
		if (input_pesquisar.value.length>0){
			Pesquisa.props.ultimoTermoPesquisado = input_pesquisar.value
			axios.get("/api/pastas/pesquisar/" + input_pesquisar.value)
				.then(respo => {
					if(respo.data.isAvail){                                                        
						Pesquisa.props.totalResult = respo.data.dados.total                                
						Pesquisa.abrePesquisa(respo.data.dados.data,input_pesquisar.value)
					}                
					else{                    
						Pesquisa.show404(input_pesquisar.value)
					}
				})
		}        
	},
	clear(){
		let pesquisa = document.getElementById("jsuploadBefore")
		pesquisa.innerHTML = ""        
	},
	sair(){        
		let pesquisa = document.getElementById("jsuploadBefore")
		pesquisa.classList.remove("ativado")
		setTimeout(function (){
			pesquisa.innerHTML = ""
		}, 1000)       
	},
	show404(query){
		Pesquisa.clear()
		let html = ""
		let head = `
        <div id="pesquisa" class="search">
			<div class="wrapper-pesquisa jsupload">
				<header class="flex">
					<a id="bt-sair-pesquisa" class="bt-sair-pesquisa"><i class="ico ico-sair ico-exit"></i></a>
					<h2>Buscar Frases</h2>
				</header>
                <section class="pesquisa--section form">
                    <form id="form_pesquisa" action="#" method="post" class="pai">                    
                        <input type="text" name="pesquisar" id="pesquisar" placeholder="ex: frases para pensar" value="${query}" class="pesquisar w100 no-print">
                        <button type="submit" id="btPesquisar" class="botao-pesquisa">
							<i class="icone-pesquisa ico ico-buscar"></i>
						</button>
                    </form>
				</section>
				<div class="demarcador-marca no-print"></div>
				<section class="pesquisa--section dados">
                    `
		let footer= ` 
					<aside class="footer--content">
						<img src="/images/default/sos.svg" alt="Vamos buscar">
						<div><strong>Não encontramos nada sobre o termo ${query}!</strong></div>
						<div>Tente buscar outra palavra :)</div>
					</aside>                 
                </section>
            </div>
        </div>`
		let pesquisa = document.getElementById("jsuploadBefore")
		pesquisa.innerHTML = head + html + footer  
		Pesquisa.preLoad()      
	},
	abrePesquisa(arrFrases,query=""){
		Pesquisa.clear()        
		let saldo = 0
		let html = ""        
		let head = `        
        <div id="pesquisa" class="search">
			<div class="wrapper-pesquisa jsupload">
				<header class="flex">
					<a id="bt-sair-pesquisa" class="bt-sair-pesquisa"><i class="ico ico-sair ico-exit"></i></a>
					<h2>Buscar Frases</h2>
				</header>
                <section class="pesquisa--section form">
                    <form id="form_pesquisa" action="#" method="post" class="pai">                    
                        <input type="text" name="pesquisar" id="pesquisar" placeholder="pesquise frases..." value="${query}" class="pesquisar w100 	no-print">
                        <button type="submit" id="btPesquisar" class="botao-pesquisa">
							<i class="icone-pesquisa ico ico-buscar"></i>
						</button>
                    </form>
				</section>
				<div class="demarcador-marca no-print"></div>
				<section class="pesquisa--section dados">
                    <ul class="resultados">`
		let footer= "</ul>"        

		if(arrFrases.length>0) {
			saldo = Pesquisa.props.totalResult - arrFrases.length            
			if (saldo > 0) {
				footer+= `<a href="#" class="botao-padrao full carregar-mais">
                    <span class="txxt">
                    Carregar mais ${saldo} Frases</span></a><img class="loading" src="/images/default/bolinhas-v01.svg" width="25" height="9" alt="carregar mais">`       
				Pesquisa.props.totalResult = Pesquisa.props.totalResult - arrFrases.length
			}                
			footer+= "<button id=\"acrescentar\" class=\"botao-padrao full red nok\">Acrescentar</button>"
		}
		else 
			footer+= `<aside class="footer--content">
        	<img src="/images/default/termos-de-uso-v01.svg" alt="Vamos buscar">                                    
			<div><strong>busque frases em todo o site e as insira em sua biblioteca!</strong></div>
			<div>Você pode procurar por autor, assunto ou trecho da frase :)</div>
    	</aside>`
        
		footer+= `</section>				
            </div>
        </div>`
		arrFrases.forEach(element => {
			html+=Pesquisa.view(element,query, "normal")
		})

		let pesquisa = document.getElementById("jsuploadBefore")
		pesquisa.innerHTML = head + html + footer
		pesquisa.classList.add("ativado")
		Pesquisa.preLoad()
	},
	resultadoDaNavegacao(arrFrases){
		let ulResultado = document.querySelector(".resultados")
		let saldo = 0
		let input_pesquisar = document.getElementById("pesquisar")        
		if(ulResultado){
			arrFrases.forEach(element => {
				let li = document.createElement("li")
				li.innerHTML=Pesquisa.view(element,input_pesquisar.value,"navegacao")
				ulResultado.appendChild(li)
			})

			let btCarregarMais = document.querySelector(".carregar-mais")
			if(btCarregarMais){

				saldo = Pesquisa.props.totalResult - arrFrases.length                
				if (saldo > 0){
					Pesquisa.props.totalResult = Pesquisa.props.totalResult - arrFrases.length
					btCarregarMais.innerHTML=`<span class="txxt">Carregar mais ${saldo} Frases</span>` 
				}
				else{
					btCarregarMais.innerHTML="FIM" 
					let loading = document.querySelector("img.loading")
					if(loading)
						loading.classList.add("hide")
				}

				if (saldo==0)
					Pesquisa.props.totalResult = 0
			}
			Pesquisa.preLoad()      
		}
	},
	view(dados, query="", tipo="normal" ){
		let view =""
		let strAutor = ""
		let frase = dados.frase
		let autor = dados.autor

		let found = dados.frase.toUpperCase().search(query.toLocaleUpperCase())
		if (found){
			//converter quando a palavra for maiúscula
			frase = frase.replace(query.toUpperCase(), "<i>" + query.toLocaleLowerCase() + "</i>" ) 
			//converter quando a palavra for minúscula
			frase = frase.replace(query.toLocaleLowerCase(), "<i>" + query.toLocaleLowerCase() + "</i>" )
			//converter quando a palavra for captalize
			frase = frase.replace(query.replace(/^\w/, (c) => c.toUpperCase()), "<i>" + query.toLocaleLowerCase() + "</i>" )
		}

		if(autor){
			strAutor = `<div class="w-autor"><strong>${autor}</strong></div>`
		}	
		view =`
				<li>
					<div class="wrow">
						<div class="wcol-1">
							<input type="checkbox" class="radio_resultados" name="${dados.id}" id="${dados.id}" value="${dados.id}" data-frase="${Pesquisa.removeSpace(dados.frase)}" data-autor="${dados.autor}" data-capa="${dados.capa}">
						</div>
						<div class="wcol-2">
							<div>${frase}</div>
							${strAutor}
						</div>                                
					</div>
				</li>`  
		
		view +=""
		return view
	},
	removeSpace(dado){        
		dado = dado.replace("\n","")
		dado = dado.replace("\r","")
		dado = dado.replace(/(\r\n|\n|\r)/gm,"")
		return dado
	},
	sanitizeString(str){
		// eslint-disable-next-line no-useless-escape
		str = str.replace(/[^a-z0-9áéíóúñü \.,_-]/gim,"")
		return str.trim()
	},
	acrescentar(){   
		let arrData = []
		let iCont = 0
		let radioPesquisaSelecionados = document.querySelectorAll(".radio_resultados")
		radioPesquisaSelecionados.forEach(element => {
			//pendente> testar se esta checado             
			if (element.checked){
				arrData.push({
					id:iCont,
					new:true,
					ordem:0,
					frase_id:element.id,
					frase:element.getAttribute("data-frase"),
					mostraimg:"0",
					pasta_id:parseInt(0),
					autor:element.getAttribute("data-autor"),
					status:"0",
					capa:element.getAttribute("data-capa"),
					//0: normal, 1:add, 2:edit, 9:delete
					statusOnView:1
				})
				iCont++
			}
		})        
        
		let arrDataPesquisa = document.getElementById("arrDataPesquisa")
		let count         = 0        
		let header        = ""
		let html          = ""
		let footer        = ""
        
		//pendente> aki é montar todo o registro em JSON
		header += "{ \"dados\" :[["

		arrData.forEach(element => {
			count++                
			if(count < arrData.length)
				html += `{"id":${element.id},"pasta_id":1,"frase_id":${element.frase_id},"status":"0","frase":"${element.frase}","ordem":0,"autor":"${element.autor}","token":null,"mostraimg":"0","created_at":null,"updated_at":null,"aux_1":null,"aux_2":null,"capa":"${element.capa}","statusOnView":0},`
			else
				html += `{"id":${element.id},"pasta_id":1,"frase_id":${element.frase_id},"status":"0","frase":"${element.frase}","ordem":0,"autor":"${element.autor}","token":null,"mostraimg":"0","created_at":null,"updated_at":null,"aux_1":null,"aux_2":null,"capa":"${element.capa}","statusOnView":0}`            
		})
        
		footer = "]]}"        

		//gravar o JSON
		if(html){
			arrDataPesquisa.innerHTML = header + html + footer
		}

		//trigger no arFrases para carregar a pesquisa
		let carregaResultadoPesquisa = document.getElementById("carregaResultadoPesquisa")
		if(carregaResultadoPesquisa){
			carregaResultadoPesquisa.click()
		}

		Pesquisa.sair()

	},    
}
export {Pesquisa}
