window.single_frase = {
    data: {                  
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
                        window.single_frase.methods.fraseFavorita(e,id)
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
                    window.single_frase.methods.callLogin(e,"","","")
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
                     window.single_frase.methods.copiarFraseFavorita(id)
                 };
             });             
        },
    },
}
window.single_frase.listners.load()