window.generic = {
    data: {  
        objConfirma: [{mostra:'nao', evento:'', pergunta:'', aviso:'', titulo:'', lbconfirma:'', lbcancela:''}],         
        objetoRetornoMSG:[{classe: 'card fade-out', obj:''}],   
        //custom
        labreMenu:"", 
        labreMenuPerfil:"", 
        labrePesquisa:"", 
    },
    // methods:{ 
    // },             
    listners:{
        load(){            
            let self = this
            /**
             * menu, abertura e fechamento
             /****************************************************************** */
            let menu = document.querySelectorAll(".abreMenu")
            menu.forEach(function(item){		
                item.onclick = function(e) { 
                    e.stopPropagation();
                    
                    let wrapperMenu = document.querySelector(".wrapper-menu-lateral-hidden");    
                    if(self.labreMenu=='ativado'){
                        self.labreMenu = "";
                        wrapperMenu.classList.remove('ativado');
                    }
                        
                    else {
                        self.labreMenu = "ativado";
                        wrapperMenu.classList.add('ativado');
                    }
                };
            });

            /**
             * pequisa, abertura e fechamento
             /****************************************************************** */            
            let pesquisa = document.querySelectorAll(".abrePesquisa")
            pesquisa.forEach(function(item){		
                item.onclick = function(e) { 
                    e.stopPropagation();
                    
                    let wrapperPesquisa = document.querySelector(".wrapper-pesquisa-lateral-hidden");    
                    if(self.labrePesquisa=='ativado'){
                        self.labrePesquisa = "";
                        wrapperPesquisa.classList.remove('ativado');
                    }
                        
                    else {
                        self.labrePesquisa = "ativado";
                        wrapperPesquisa.classList.add('ativado');
                    }
                };
            });
            /**
             * menu perfil, abertura e fechamento
             /****************************************************************** */
             let menuPerfil = document.querySelectorAll(".labreMenuPerfil")
             menuPerfil.forEach(function(item){		
                item.onclick = function(e) { 
                    e.stopPropagation();

                    let wrapperMenuPerfil = document.querySelector(".wrapper-labreMenuPerfil-hidden");    
                    let wrapperMenuPerfilMob = document.querySelector(".wrapper-labreMenuPerfil-hidden-mob");    
                    if(self.labreMenuPerfil=='ativado'){
                        self.labreMenuPerfil = "";
                        wrapperMenuPerfil.classList.remove('ativado');
                        wrapperMenuPerfilMob.classList.remove('ativado');
                    }
                        
                    else {
                        self.labreMenuPerfil = "ativado";
                        wrapperMenuPerfil.classList.add('ativado');
                        wrapperMenuPerfilMob.classList.add('ativado');
                    }

                    console.log(wrapperMenuPerfilMob)
                   
                   
                };
            }); 
        },
    },
}
window.generic.listners.load()