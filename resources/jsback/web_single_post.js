window.single_post = {
    data: {                  
        labreMenu:"", 
        labreMenuPerfil:"", 
        labrePesquisa:"", 
        //
        regLink:/^(\[url=)?(https?:\/\/)?(www\.|\S+?\.)(\S+?\.)?\S+$\s*/mg,
        reg:/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
     },         
    methods:{        
        fraseFavorita(e, frase_id){
            e.preventDefault();
            e.stopPropagation();
            let usuario_id = document.getElementById('usuario_id').value 
            if (usuario_id !="" && frase_id !=""){    
                let valid = window.validator;
                const formData = new FormData();
                formData.append('usuario_id',usuario_id);
                formData.append('frase_id',frase_id);
                axios.post('/frasesfavoritas',formData)
                .then(respo => {
                    if(respo.data.message){
                        window.validator.methods.validatorJS("Sucesso!", "Frase salva nos seus favoritos :)", null, "sucesso")
                        let fraseMarcada = document.querySelector('.favorita-id-'+frase_id);
                        fraseMarcada.setAttribute("class", "frase-favoritas jacurtida icon icon-star item-tools mg0");
                        fraseMarcada.setAttribute("data", "jacurtida");
                        fraseMarcada.setAttribute("title", "Adicionada!!!");
                    }                
                    else{
                        window.validator.methods.validatorJS("Vixi!", "Não foi possível salvar esta frase em seus favoritos", null, "erro")
                    }
                })            
            }
        },
        callLogin(e,perg, avis, tit){            
            let bt_login = document.querySelector(".ref_call_login")           
            perg = bt_login.attributes.datapergunta.nodeValue
            avis = bt_login.attributes.dataaviso.nodeValue
            tit  = bt_login.attributes.datatitulo.nodeValue
            window.confirma.methods.getConfirm(bt_login, perg, avis, tit);
        },
        copiarFraseFavorita(frase){
            //colocar na área de transfrência todo o conteúdo copiado
            let tempInput = document.createElement("input");

            
            //tempInput.setAttribute('type', 'hidden');
            let CopiarFrase=document.querySelector('#frase_copiar_'+frase).innerHTML
            document.body.appendChild(tempInput);

            tempInput.value = CopiarFrase;                
            tempInput.select();               
            try {                    
                var successful = document.execCommand('copy');                    
                alert('A Frase foi copiada com sucesso! ');
                document.body.removeChild(tempInput);              
            } catch (err) {
                alert('Oops, não foi possível copiar.');
            }

        },
        curtidaStore(e){
            let post_id = document.getElementById('post_id').value 
            let usuario_id = document.getElementById('usuario_id').value 
            let ip = document.getElementById('ip').value 
            let curtida_id = document.getElementById('curtida_id').value 
            let totalCurtidas = document.getElementById('totalCurtidas').value
            let totalCurtidasHtml = document.querySelector("#totalCurtidasHtml")
            let btCurtirPost = document.querySelector("#btCurtirPost")
            const formData = new FormData();          
            formData.append('post_id',post_id);
            formData.append('usuario_id',usuario_id);        
            formData.append('ip',ip);

            axios.post('/curtida',formData)
            .then(respo => {              
                if(respo.data.sucess){
                    window.validator.methods.validatorJS("Sucesso!", `${respo.data.msg}`, null, "sucesso")
                    e.target.classList.add('disable')
                    curtida_id = respo.data.data.id                    
                    totalCurtidas++
                    totalCurtidasHtml.innerHTML = totalCurtidas
                    document.getElementById('totalCurtidas').value = totalCurtidas
                    btCurtirPost.classList.add('disable')                }                
                else{
                    window.validator.methods.validatorJS("Vixi!",  `${respo.data.msg}`, null, "erro")
                }
            })
        },
        curtidaDelete(e){
            let curtida_id = document.getElementById('curtida_id').value 
            let totalCurtidas = document.getElementById('totalCurtidas').value
            let btCurtirPost = document.querySelector("#btCurtirPost")
            url = `/curtidas/deletar/${curtida_id}`;          
            axios.delete(url)
            .then(respo => {              
                if(respo.data.sucess){
                    window.validator.methods.validatorJS("Sucesso!", `${respo.data.msg}`, null, "sucesso")
                    totalCurtidas--
                    totalCurtidasHtml.innerHTML = totalCurtidas
                    document.getElementById('totalCurtidas').value = totalCurtidas
                    btCurtirPost.classList.remove('disable')
                }                
                else{
                    window.validator.methods.validatorJS("Vixi!",  `${respo.data.msg}`, null, "erro") 
                }
            })
            

        },
        favoritaStore(e){
            let post_id = document.getElementById('post_id').value 
            let usuario_id = document.getElementById('usuario_id').value 
            const formData = new FormData();          
            formData.append('post_id',post_id);
            formData.append('usuario_id',usuario_id);        
            
            let btfavoritaStore = document.querySelector("#favoritaStore")

            axios.post('/favorita',formData)
            .then(respo => {              
                if(respo.data.sucess){
                    window.validator.methods.validatorJS("Sucesso!", `${respo.data.msg}`, null, "sucesso")
                    btfavoritaStore.classList.add('disable')
                }                
                else{
                    window.validator.methods.validatorJS("Vixi!",  `${respo.data.msg}`, null, "erro")
                }                  
            })            
        },
        imprimir(){
            try {
                var successful = document.execCommand('print');
                var msg = successful ? 'com sucesso!' : 'com falhas';
                
            } catch (err) {
                alert('Oops, não foi possível posível.');
            }
        },
        limpaLinks(corpo){
            let variavel="";            
            if(RegExp(window.single_post.data.regLink).test(corpo) == 1){          
              variavel = corpo.replace(/^(\[url=)?(https?:\/\/)?(www\.|\S+?\.)(\S+?\.)?\S+$\s*/mg, '');
              variavel = variavel.replace(/^\s*(\[\s*url\s*=\s*)?(https?:\/\/)?(www\.|\S+?\.)(\S+?\.)?\S+\s*$\s*/mg, '');
              variavel = variavel.replace(/^(\[url=)?(https?:\/\/)?(www\.|\S+?\.)(\S+?\.)?[^.\s]+$\s*/mg, '');              
              return false;
            }
            else{
              return true;          
            }
        },
        validaSubmit(e){          
            let msg="";            
            let autor_nome = document.getElementById('autor_nome').value 
            let autor_email = document.getElementById('autor_email').value 
            let body = document.getElementById('body').value 
            let pergunta = document.getElementById('pergunta').value
            let form_comentar = document.getElementById('form_comentar')
            

            //autor_nome
            if(autor_nome=='')
              msg="- Preencha seu nome para comentar.";
  
            if(autor_email==''){
              if(msg!="")    
                  msg+= "<br> - " + "O email é obrigatório.";
                else
                  msg= "O email é obrigatório.";
            }

            console.log(autor_email )
  
            //RegExp(window.single_post.data.reg)
            if(RegExp(window.single_post.data.reg).test(autor_email) == false){
              if(msg!="")    
                  msg+= "<br> - " + "Email inválido";
                else
                  msg= "Email inválido";
            }
            if(body==''){
              if(msg!="")    
                  msg+= "<br> - " + "Comentário obrigatório.";
                else
                  msg= "- Comentário obrigatório.";
            }          
            if(pergunta =='' || pergunta.toLowerCase() !="sim"){
              if(msg!="")    
                  msg+= "<br> - " + "Pergunta Anti-Spam incorreta.";
                else
                  msg= "- Pergunta Anti-Spam incorreta.";
            }          
  
            if(this.limpaLinks(body) == 0){
              if(msg!="")    
                  msg+= "<br> - " + "Não é permitido links.";
                else
                  msg= "Não é permitido links.";
            }
            if(msg=="") 
              form_comentar.submit();            
                
            else{
              window.validator.methods.validatorJS("Vixi!",  `Verifique: <br> ${msg} `, null, "erro")
            }
        }
    },
    listners:{
        load(){            
            let self = this            
            /**
             * Frases favoritas do usuário
             /****************************************************************** */
            let fraseFavorita = document.querySelectorAll(".fraseFavorita")
            fraseFavorita.forEach(function(item){		
                item.onclick = function(e) { 
                    
                    if (e.target.attributes.data.nodeValue =="go"){                
                        e.stopPropagation()
                        let id=e.target.attributes.idData.nodeValue
                        window.single_post.methods.fraseFavorita(e,id)
                    }
                };
            });
            /**
             * Call login
             /****************************************************************** */
            let callLogin = document.querySelectorAll(".callLogin")
            callLogin.forEach(function(item){
                item.onclick = function(e) {
                    e.stopPropagation()  
                    e.preventDefault()
                    window.single_post.methods.callLogin(e,"","","")
                };
            });
            /**
             * Bt_copiar individual da frase
             /****************************************************************** */
             let copiarFraseFavorita = document.querySelectorAll(".copiarFraseFavorita")
             copiarFraseFavorita.forEach(function(item){
                 item.onclick = function(e) {
                     e.stopPropagation()
                     e.preventDefault()
                     let id=e.target.attributes.idData.nodeValue
                     window.single_post.methods.copiarFraseFavorita(id)
                 };
             });
             /**
             * imprimir
             /****************************************************************** */
             let imprimir = document.querySelectorAll(".imprimir")
             imprimir.forEach(function(item){
                 item.onclick = function(e) {
                     e.stopPropagation()
                     e.preventDefault()                     
                     window.single_post.methods.imprimir()
                 };
             });

             /**
             * btCurtirPost
             /****************************************************************** */
             let btCurtirPost = document.querySelector("#btCurtirPost")             
             btCurtirPost.onclick = function(e) {
                    e.stopPropagation()
                    e.preventDefault()
                    if(btCurtirPost.classList.contains("disable"))
                        window.single_post.methods.curtidaDelete(e)
                    else
                        window.single_post.methods.curtidaStore(e)
            }

            /**
             * favoritaStore
             /****************************************************************** */
             let favoritaStore = document.querySelectorAll(".favoritaStore")             
             favoritaStore.forEach(function(item){
                item.onclick = function(e) {
                    e.stopPropagation()
                    e.preventDefault()                    
                    if(!e.target.classList.contains("disable"))
                        window.single_post.methods.favoritaStore(e)                    
                }
             })

             /**
             * validaSubmit
             /****************************************************************** */
             let validaSubmit = document.querySelector("#validaSubmit")             
             validaSubmit.onclick = function(e) {
                e.stopPropagation()
                e.preventDefault()
                window.single_post.methods.validaSubmit(e)
            }
        },
    },
}
window.single_post.listners.load()