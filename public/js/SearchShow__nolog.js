(()=>{var e={980:()=>{document.addEventListener("DOMContentLoaded",(function(){var e=document.querySelectorAll(".lazy-hidden"),a=document.querySelectorAll("img.lazy-hidden_"),t=document.querySelectorAll("img.avatar.photo_"),o=document.querySelectorAll(".lazy-background");imagensCollection=Array.from(e).concat(Array.from(a)).concat(Array.from(t)),bgsCollection=Array.from(o);var n,r=0,i=0;function l(e){var a=e.getBoundingClientRect(),t=window.pageXOffset||document.documentElement.scrollLeft,o=window.pageYOffset||document.documentElement.scrollTop;return{top:a.top+o,left:a.left+t}}function d(){n&&clearTimeout(n),n=setTimeout((function(){var e=window.pageYOffset;imagensCollection.forEach((function(a){a.classList.contains("aguardando")&&(l(a).top<window.innerHeight+e&&(a.src=a.dataset.src,a.dataset.srcset&&(a.srcset=a.dataset.srcset),a.classList.remove("aguardando"),i++))})),c=0,bgsCollection.forEach((function(a){a.classList.contains("aguardando")&&(l(a).top<window.innerHeight+e&&(a.style.backgroundImage="url('"+a.dataset.src+"')",a.classList.remove("aguardando"),i++))}))}),20),r==i&&(document.removeEventListener("scroll",d),window.removeEventListener("resize",d),window.removeEventListener("orientationChange",d))}imagensCollection.forEach((function(e){e.classList.add("aguardando"),r++})),bgsCollection.forEach((function(e){e.classList.add("aguardando"),r++})),document.addEventListener("scroll",d),window.addEventListener("resize",d),window.addEventListener("orientationChange",d);var s=document.querySelectorAll(".autoload"),u=Array.from(s);loadTimeout=setTimeout((function(){u.forEach((function(e){e.style.backgroundImage="url('"+e.dataset.src+"')"}))}))}))},905:()=>{var e,a,t;WebFontConfig={google:{families:["Montserrat:400,500,600"]}},e=document,a=e.createElement("script"),t=e.scripts[0],a.src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js",a.async=!0,t.parentNode.insertBefore(a,t)}},a={};function t(o){var n=a[o];if(void 0!==n)return n.exports;var r=a[o]={exports:{}};return e[o](r,r.exports,t),r.exports}(()=>{"use strict";var e={data:{executar:null},preLoad:function(){document.body.addEventListener("keydown",(function(a){27==((a=a||window.event).which||a.keyCode)&&e.closeAll()}))},view:function(){var a=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"atencao";this.limpar();var t="\n            <div class='modal--wrapper ".concat(a,"'>\n                <a title='Fechar esta opção.' class='bt-fechar'></a>            \n            </div>"),o=document.createElement("div");o.id="modal",o.classList.add(a),o.innerHTML=t;var n=document.querySelector("#before");n&&n.appendChild(o);var r=document.querySelector("#modal");r.addEventListener("click",e.closeAll)},closeAll:function(){e.remove(".modal","ativado"),e.remove(".abreMenuUsuario_desk","ativado"),e.remove(".menu-usuario-perfil_desk","ativado"),e.remove(".abreMenuUsuario_mobile","ativado"),e.remove(".menu-usuario-perfil_mobile","ativado"),e.remove(".tool-salvar__criar_pasta","ativado"),e.remove(".tool.tool-salvar","ativado"),e.remove(".modal_salvar","ativado"),e.remove(".wrapper--compartilhar","ativado"),e.remove(".wrapper-modal-dialog","ativo"),e.limpar()},remove:function(e,a){var t=document.querySelector(e);t&&t.classList.remove(a),document.querySelectorAll(e).forEach((function(e){e.classList.remove(a)})),t&&(t.classList.contains("abreMenuUsuario_desk")||t.classList.contains("wrapper--compartilhar")||t.classList.contains("menu-usuario-perfil_desk")||t.parentElement.removeChild(t))},limpar:function(){var e=document.querySelector("#modal");e&&e.parentElement.removeChild(e)}},a={data:{action:"",callback:"",callbackCancel:""},preLoad:function(){var e=document.querySelectorAll(".callLogin"),t=document.querySelector(".ref_call_login");e.forEach((function(e){e.onclick=function(e){e.stopPropagation(),e.preventDefault();var o=e.target.title||"Para salvar este conteúdo, você precisa ter cadastro e fazer login. Deseja fazer Login?",n=e.target.getAttribute("data-header")||"Faça Login",r=e.target.getAttribute("data-lblBtconfirm")||"Faça login",c=e.target.getAttribute("data-lblBtcancel")||"Faça login";a.openView(t,o,n,r,c,null,null)}}))},openView:function(t){var o=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null,n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null,r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"Confirma",c=arguments.length>4&&void 0!==arguments[4]?arguments[4]:"Cancela",i=arguments.length>5&&void 0!==arguments[5]?arguments[5]:null,l=arguments.length>6&&void 0!==arguments[6]?arguments[6]:null;this.limpaTudo(),e.view();var d=' <div class="wrapper-modal-dialog ativo default ">',s="</div>",u="\n        <header>".concat(n,'\n            <a class="botao-fechar-dialog abreCompartilhar icone-fechar"><i class="ico ico-fechar"></i></a>\n        </header>\n        <div class="conteudo">\n            <div class="box texto">\n                <span>\n                    ').concat(o,'\n                </span>\n            </div>\n            <div class="box botoes">\n                <a id="bt_confirmar_ok" class="pointer bt_confirmar true">\n                    <span>').concat(r,'</span>\n                </a>\n                <a id="bt_cancelar" class="pointer bt_cancelar false">\n                    <span>').concat(c,"</span>\n                </a>\n            </div>\n        </div>\n        "),m=document.createElement("div");m.id="confirma",m.classList.add("container"),m.classList.add("vue-js-component"),m.innerHTML=d+u+s;var v=document.querySelector("#app");v.appendChild(m);var f=document.querySelector("#bt_cancelar");f.addEventListener("click",this.fecharConfirma);var p=document.querySelector(".icone-fechar");p.addEventListener("click",this.fecharConfirma),a.data.action=t,a.data.callback=i,a.data.callbackCancel=l;var g=document.querySelector("#bt_confirmar_ok");return g.addEventListener("click",a.itsOk),!0},limpaTudo:function(){var a=document.querySelector("#confirma");a&&a.parentElement.removeChild(a),e.closeAll()},fecharConfirma:function(){var t=document.querySelector("#confirma");t.classList.add("fechar"),e.closeAll();setTimeout((function(){document.querySelector("#app").removeChild(t),a.data.callbackCancel&&a.data.callbackCancel()}),200)},itsOk:function(){a.data.callback?a.data.callback.submit():a.data.action.click(),e.closeAll()}},o={data:{executar:null},preLoad:function(){},preLoadPhp:function(){var e=arguments.length>0&&void 0!==arguments[0]&&arguments[0],a=document.getElementById("mensagem");if(a){var t=document.querySelector(".bt-fechar-msg");t&&t.addEventListener("click",o.fecharMensagem);var n=document.querySelector(".corpo-da-mensagem");n&&n.addEventListener("click",o.fecharMensagem),e||o.timerFechar(null)}},view:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,a=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"atencao",t=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;this.limpar();var n="                        \n        <div class='corpo-da-mensagem ".concat(a,'\'>\n            <span class="corpo-da-mensagem--texto">').concat(e,"</span>\n            <a title='Fechar esta opção.' id=\"fechar-").concat(a,"\"\n                class='bt-fechar-msg'>\n                <i class='ico ico-close ").concat(a,'\'></i>\n            </a>\n            <div id="progress-bar"></div> \n        </div>'),r=document.createElement("div");r.id="mensagem",r.classList.add(a),r.innerHTML=n;var c=document.querySelector("#app");c.appendChild(r);var i=document.querySelector(".bt-fechar-msg");i.addEventListener("click",o.fecharMensagem);var l=document.querySelector(".corpo-da-mensagem");l&&l.addEventListener("click",o.fecharMensagem),o.timerFechar(t)},fecharMensagem:function(){var e=document.querySelector("#mensagem");e&&(e.classList.add("fechar"),o.data.executar&&clearTimeout(o.data.executar),o.data.executar=setTimeout((function(){document.querySelector("#app").removeChild(e)}),1e3))},timerFechar:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:6e3,a="6s";null==e&&(e=6e3),1e4==e&&(a="10s"),3e3==e&&(a="3s"),o.progressBar(a),this.data.executar&&clearTimeout(this.data.executar),this.data.executar=setTimeout((function(){o.fecharMensagem()}),e)},progressBar:function(e,a){if(document.querySelector("#mensagem")){var t=document.getElementById("progress-bar");if(t){t.className="progressbar";var o=document.createElement("div");o.className="inner",o.style.animationDuration=e,"function"==typeof a&&o.addEventListener("animationend",a),t.appendChild(o),o.style.animationPlayState="running"}}},limpar:function(){var e=document.querySelector("#mensagem");e&&e.parentElement.removeChild(e),this.data.executar&&clearTimeout(this.data.executar)}};o.preLoad();var n={preLoad:function(){document.querySelectorAll(".copiarFraseFavorita").forEach((function(e){e.onclick=function(e){e.stopPropagation(),e.preventDefault();var a=e.target.attributes.idData.nodeValue;n.copiarFraseFavorita(a)}}))},copiarFraseFavorita:function(e){var a=document.createElement("input"),t=document.querySelector("#frase_"+e).innerHTML;document.body.appendChild(a),a.value=t,a.select();try{document.execCommand("copy"),o.view("Frase copiada!","sucesso"),document.body.removeChild(a)}catch(e){o.view("Oops, não foi possível copiar.","sucesso")}}};a.preLoad(),n.preLoad(),t(980),t(905)})()})();