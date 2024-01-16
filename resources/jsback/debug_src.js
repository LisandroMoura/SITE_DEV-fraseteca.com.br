//require('./bootstrap');
window.Vue = require('vue');

//componetes
// Vue.component('retorno-msg', require('./components/retorno_msg.vue').default);
// Vue.component('bt-confirma', require('./components/bt_confirma.vue').default);

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

require('./mixins');
// require('./mixins_validatorjs');

const app = new Vue({
    el: '#app', 
    mixins:[mixin,mixin_validatorjs],         
    data: {  
       autor_nome:"",
       autor_email:"",  
       body:"",  
       pergunta:"",
       regLink:/^(\[url=)?(https?:\/\/)?(www\.|\S+?\.)(\S+?\.)?\S+$\s*/mg,
       reg:/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
       
       //parâmetros da barra de opções
       post_id:"",
       usuario_id:"",
       curtida_id:"",
       classeDisable:"",
       classeDisableCurtida:"",
       totalCurtidas:0,
       acaoCurtir:'store',
       labreCompartilhar:"",

    },    
    mounted() {                  
       this.objetoRetornoMSG[0].obj = this.$refs.retorno_msg;

       if(this.$refs.ref_autor_nome) {
          // comentários
           this.autor_nome              = this.$refs.ref_autor_nome.value;
           this.autor_email             = this.$refs.ref_autor_email.value;          
           this.post_id                 = this.$refs.ref_post_id.value;        
       }
       if(this.$refs.ref_curtida_id) {
         //perfil e opções
          this.curtida_id              = this.$refs.ref_curtida_id.value;                  
          this.ip                      = this.$refs.ref_ip.value;       
          this.totalCurtidas           = this.$refs.ref_totalCurtidas.value;
          if(this.curtida_id!=""){
            this.classeDisableCurtida = "disable";
            this.acaoCurtir="destroy";
         }
       }

       if(this.$refs.ref_usuario_id) {
        //perfil e opções
         this.usuario_id              = this.$refs.ref_usuario_id.value;            
      }
       
    },  
    methods: {  
      getConfirm: function (formulario, event, perg, avis, tit="" ) {                         
        event.preventDefault();            
        this.objConfirma = [
            {mostra:'sim', evento:this.$refs[formulario], pergunta:perg, aviso:avis, titulo:tit}
        ];                     
      },      
      limpaLinks(){
        let variavel="";
        let corpo = this.body; 
        if(this.regLink.test(corpo) == 1){          
          variavel = corpo.replace(/^(\[url=)?(https?:\/\/)?(www\.|\S+?\.)(\S+?\.)?\S+$\s*/mg, '');
          variavel = variavel.replace(/^\s*(\[\s*url\s*=\s*)?(https?:\/\/)?(www\.|\S+?\.)(\S+?\.)?\S+\s*$\s*/mg, '');
          variavel = variavel.replace(/^(\[url=)?(https?:\/\/)?(www\.|\S+?\.)(\S+?\.)?[^.\s]+$\s*/mg, '');
          this.body = variavel;
          return false;
        }
        else{
          return true;          
        }
      },
      isEmailValid: function() {
        return (this.autor_email == "")? "" : (this.reg.test(this.autor_email)) ? 'has-success' : 'has-error';
      },
      responder(value){
          let parent = document.querySelector("#parent_id")          
          parent.value = value
      },
      validaSubmit(e){          
          let msg="";
          if(autor_nome.value=='')
            msg="- Preencha seu nome para comentar.";

          if(autor_email.value==''){
            if(msg!="")    
                msg+= "<br> - " + "O email é obrigatório.";
              else
                msg= "O email é obrigatório.";
          }

          if(this.reg.test(this.autor_email) == false){
            if(msg!="")    
                msg+= "<br> - " + "Email inválido";
              else
                msg= "Email inválido";
          }
          if(body.value==''){
            if(msg!="")    
                msg+= "<br> - " + "Comentário obrigatório.";
              else
                msg= "- Comentário obrigatório.";
          }          
          if(pergunta.value =='' || pergunta.value.toLowerCase() !="sim"){
            if(msg!="")    
                msg+= "<br> - " + "Pergunta Anti-Spam incorreta.";
              else
                msg= "- Pergunta Anti-Spam incorreta.";
          }          

          if(this.limpaLinks() == 0){
            if(msg!="")    
                msg+= "<br> - " + "Não é permitido links.";
              else
                msg= "Não é permitido links.";
          }
          if(msg=="") 
            this.$refs.comentar.submit();            
              
          else{
            this.validatorJS(this.titulo_erro, `Verifique: <br> ${msg} `, null, "erro")                 
            //this.$toastr.e(`Verifique: <br> ${msg} `);
          }
            
      },     
      fraseFavorita(e, frase_id){          
          e.preventDefault();
          e.stopPropagation();          
          
          if (this.usuario_id !="" && frase_id !=""){    
              if (e.target.attributes.data.nodeValue =="go"){                
                const formData = new FormData();          
                formData.append('usuario_id',this.usuario_id);
                formData.append('frase_id',frase_id);
                axios.post('/frasesfavoritas',formData)
                .then(respo => {              
                    if(respo.data.message){                                                
                        this.validatorJS(this.titulo_sucesso, "Frase salva nos seus favoritos :)", null, "sucesso")
                        //this.$toastr.s(``);
                        let fraseMarcada = document.querySelector('.favorita-id-'+frase_id);
                        fraseMarcada.setAttribute("class", "frase-favoritas jacurtida icon icon-star item-tools mg0");                  
                        fraseMarcada.setAttribute("data", "jacurtida"); 
                        //fraseMarcada.innerHTML = "";
                        fraseMarcada.setAttribute("title", "Adicionada!!!"); 
                    }                
                    else{
                      this.validatorJS(this.titulo_erro, "Não foi possível salvar esta frase em seus favoritos", null, "erro")
                    }                  
                })
              }
               else {
                this.validatorJS(this.titulo_erro, "Esta frase ja está em seus favoritos", null, "erro")                 
              }                  
          }
      },
      callLogin(parametros){        
        //Para o futuro: jogar no input dentro do form callLogin os parametros que vamos passar
        let bt_login = this.$refs.ref_call_login
        bt_login.click()
      },

      favoritaStore(e){
        e.preventDefault();
        e.stopPropagation();                
        if (this.usuario_id !="" && this.post_id !=""){           
          const formData = new FormData();          
          formData.append('usuario_id',this.usuario_id);
          formData.append('post_id',this.post_id);
          axios.post('/favorita',formData)
          .then(respo => {              
              if(respo.data.sucess){
                this.validatorJS(this.titulo_sucesso, `${respo.data.msg}`, null, "sucesso")                
                this.classeDisable = "disable";
                  //desmarca o campo, aplicando a classe disable
              }                
              else{
                this.validatorJS(this.titulo_erro, `${respo.data.msg}`, null, "erro")                                   
              }                  
          })
        }
      },
      curtidaStore(e){
        e.preventDefault();
        e.stopPropagation();                
        const formData = new FormData();          
        formData.append('post_id',this.post_id);
        formData.append('usuario_id',this.usuario_id);        
        formData.append('ip',this.ip);        
        axios.post('/curtida',formData)
        .then(respo => {              
            if(respo.data.sucess){
                this.validatorJS(this.titulo_sucesso, `${respo.data.msg}`, null, "sucesso")                
                this.classeDisableCurtida = "disable";
                this.acaoCurtir='destroy';
                this.$refs.ref_curtida_id.value = respo.data.data.id;
                this.curtida_id= respo.data.data.id;
                this.$refs.ref_totalCurtidas.value++;                
                this.totalCurtidas++;                
            }                
            else{
                this.validatorJS(this.titulo_erro, `${respo.data.msg}`, null, "erro")                 
            }
        })
       
      },
      curtidaDelete(e){
        let url;
        e.preventDefault();
        e.stopPropagation();
        const formData = new FormData();              
        formData.append('id',this.curtida_id);    
        
        url = `/curtidas/deletar/${this.curtida_id}`;          
        axios.delete(url)
        .then(respo => {              
            if(respo.data.sucess){
                this.validatorJS(this.titulo_sucesso, `${respo.data.msg}`, null, "sucesso")                 
                this.classeDisableCurtida = "enable";
                this.acaoCurtir='store';
                this.$refs.ref_totalCurtidas.value--;                
                this.totalCurtidas--;
                
            }                
            else{
                this.validatorJS(this.titulo_erro, `${respo.data.msg}`, null, "erro")                 
            }
        })
       
      },
      abreCompartilhar(){if(this.labreCompartilhar=='ativado')this.labreCompartilhar = "";else this.labreCompartilhar = "ativado";},           
      copiarLink () {
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

        /* unselect the range */
        //testingCodeToCopy.setAttribute('type', 'hidden')
        //window.getSelection().removeAllRanges()
      },
      copiarFraseFavorita(frase){
        //colocar na área de transfrência todo o conteúdo copiado
        var tempInput = document.createElement("input"); 

         
         //tempInput.setAttribute('type', 'hidden');
        var CopiarFrase=document.querySelector('#frase_copiar_'+frase).innerHTML
         document.body.appendChild(tempInput);

         tempInput.value = CopiarFrase;                
         tempInput.select();               
         try {                    
             var successful = document.execCommand('copy');                    
             alert('A Frase copiada com sucesso! ');
             document.body.removeChild(tempInput);              
         } catch (err) {
             alert('Oops, não foi possível copiar.');
         }

    }, 
      imprimir(){
        try {
          var successful = document.execCommand('print');
          var msg = successful ? 'com sucesso!' : 'com falhas';
          
        } catch (err) {
          alert('Oops, não foi possível posível.');
        }
      },
    },
});
