window.compartilhar = {
    data: {  
        //custom
        labreCompartilhar:"",
    },
    methods:{ 
        copiarLink(){
            let testingCodeToCopy = document.querySelector('#urlamigavel')
            testingCodeToCopy.setAttribute('type', 'text')   
            testingCodeToCopy.select()

            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'com sucesso!' : 'com falhas';
                alert('Link copiado ' + msg);
            } catch (err) {
                alert('Oops, não foi possível copiar.');
            }
        }
    },             
    listners:{
        load(){            
            let self = this            
            /**
             * menu perfil, abertura e fechamento
             /****************************************************************** */
             let compartilhar = document.querySelectorAll(".abreCompartilhar")
             compartilhar.forEach(function(item){
                item.onclick = function(e) { 
                    e.stopPropagation();
                    
                    let wrapperCompartilhar = document.querySelector(".wrapper-compartilhar-lateral-hidden");    
                    if(self.labreCompartilhar=='ativado'){
                        self.labreCompartilhar = "";
                        wrapperCompartilhar.classList.remove('ativado');
                    }
                        
                    else {
                        self.labreCompartilhar = "ativado";
                        wrapperCompartilhar.classList.add('ativado');
                    }
                };
            });
            /**
             * copiarLink
             /****************************************************************** */
             let copiarLink = document.querySelectorAll(".copiarLink")
             copiarLink.forEach(function(item){
                 item.onclick = function(e) {
                     e.stopPropagation()  
                     e.preventDefault()
                     window.compartilhar.methods.copiarLink()
                 };
             });
        },
    },
}
window.compartilhar.listners.load()