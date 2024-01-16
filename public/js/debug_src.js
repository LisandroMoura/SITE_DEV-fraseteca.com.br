document.addEventListener("DOMContentLoaded", function() {	
    //lazy     
    var imagensDoCorpo  		= document.querySelectorAll("div.content-area.corpo img");    
	var imagensRecomendadas 	= document.querySelectorAll("img.lazy-hidden");
	var imagensComentarios	 	= document.querySelectorAll("img.avatar.photo");
	var imagensBackgrounds 		= document.querySelectorAll(".lazy");    
	
	imagensCollection
		=Array.from(imagensDoCorpo)
		.concat(Array.from(imagensRecomendadas))
		.concat(Array.from(imagensComentarios))
		;

	bgsCollection
		=Array.from(imagensBackgrounds)		
		;

	var imagensCont =0;
	var executados=0;		  		
	imagensCollection.forEach(function(img){		
		img.classList.add("aguardando");
		imagensCont++; 
	});
	//
	bgsCollection.forEach(function(div){		
		div.classList.add("aguardando");
		imagensCont++; 
    });	
    
    

	
	var lazyloadThrottleTimeout;

	function offset(el) {
		var rect = el.getBoundingClientRect(),
		scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
		scrollTop = window.pageYOffset || document.documentElement.scrollTop;
		return { top: rect.top + scrollTop, left: rect.left + scrollLeft }
	}

	function lazyload () {		
		if(lazyloadThrottleTimeout) {
			clearTimeout(lazyloadThrottleTimeout);
		}
        
		lazyloadThrottleTimeout = setTimeout(function() {		
			var scrollTop = window.pageYOffset;
			
			//Coleção de Imagens
			imagensCollection.forEach(function(img) {
				if(img.classList.contains("aguardando")){
					//teste se existem imagens a serem processadas
					let divOffset = offset(img);								
					if(divOffset.top < (window.innerHeight + scrollTop)){						
						img.src = img.dataset.src;
						img.classList.remove('aguardando');
						executados++;						
					}
				}			
			});
			c=0;
			//Coleção de BackGrounds
			bgsCollection.forEach(function(div) {
				if(div.classList.contains("aguardando")){	
					let divOffset = offset(div);								
							
					if(divOffset.top < (window.innerHeight + scrollTop)){						
						div.style.backgroundImage ="url('" + div.dataset.src+"')"; 
						div.classList.remove('aguardando');
						executados++;						
					}
				}			
			});			

		}, 20);

		if (imagensCont==executados){
			document.removeEventListener("scroll", lazyload);
			window.removeEventListener("resize", lazyload);
			window.removeEventListener("orientationChange", lazyload);			
		}
		
	}	
	//listners
	document.addEventListener("scroll", lazyload);
	window.addEventListener("resize", lazyload);
	window.addEventListener("orientationChange", lazyload);
	
	/**
	 * 
	 * Auto Load processo
	 */
	//autoload	
	let imagensAutoLoad = document.querySelectorAll(".autoload")

	//auto collection
	let autoloadCollection =Array.from(imagensAutoLoad)

	function autoLoad(){
        //Coleção de BackGrounds        
		loadTimeout = setTimeout(function() {	
			autoloadCollection.forEach(function(div) {				
				div.style.backgroundImage ="url('" + div.dataset.src+"')"; 				
			})				
		})
	}
	autoLoad()
    
});