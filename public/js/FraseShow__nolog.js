(()=>{var e={980:()=>{document.addEventListener("DOMContentLoaded",(function(){var e=document.querySelectorAll(".lazy-hidden"),t=document.querySelectorAll("img.lazy-hidden_"),a=document.querySelectorAll("img.avatar.photo_"),o=document.querySelectorAll(".lazy-background");imagensCollection=Array.from(e).concat(Array.from(t)).concat(Array.from(a)),bgsCollection=Array.from(o);var n,r=0,i=0;function s(e){var t=e.getBoundingClientRect(),a=window.pageXOffset||document.documentElement.scrollLeft,o=window.pageYOffset||document.documentElement.scrollTop;return{top:t.top+o,left:t.left+a}}function l(){n&&clearTimeout(n),n=setTimeout((function(){var e=window.pageYOffset;imagensCollection.forEach((function(t){t.classList.contains("aguardando")&&(s(t).top<window.innerHeight+e&&(t.src=t.dataset.src,t.dataset.srcset&&(t.srcset=t.dataset.srcset),t.classList.remove("aguardando"),i++))})),c=0,bgsCollection.forEach((function(t){t.classList.contains("aguardando")&&(s(t).top<window.innerHeight+e&&(t.style.backgroundImage="url('"+t.dataset.src+"')",t.classList.remove("aguardando"),i++))}))}),20),r==i&&(document.removeEventListener("scroll",l),window.removeEventListener("resize",l),window.removeEventListener("orientationChange",l))}imagensCollection.forEach((function(e){e.classList.add("aguardando"),r++})),bgsCollection.forEach((function(e){e.classList.add("aguardando"),r++})),document.addEventListener("scroll",l),window.addEventListener("resize",l),window.addEventListener("orientationChange",l);var d=document.querySelectorAll(".autoload"),u=Array.from(d);loadTimeout=setTimeout((function(){u.forEach((function(e){e.style.backgroundImage="url('"+e.dataset.src+"')"}))}))}))},905:()=>{var e,t,a;WebFontConfig={google:{families:["Montserrat:400,500,600"]}},e=document,t=e.createElement("script"),a=e.scripts[0],t.src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js",t.async=!0,a.parentNode.insertBefore(t,a)}},t={};function a(o){var n=t[o];if(void 0!==n)return n.exports;var r=t[o]={exports:{}};return e[o](r,r.exports,a),r.exports}(()=>{"use strict";var e={data:{executar:null},preLoad:function(){},preLoadPhp:function(){var t=arguments.length>0&&void 0!==arguments[0]&&arguments[0],a=document.getElementById("mensagem");if(a){var o=document.querySelector(".bt-fechar-msg");o&&o.addEventListener("click",e.fecharMensagem);var n=document.querySelector(".corpo-da-mensagem");n&&n.addEventListener("click",e.fecharMensagem),t||e.timerFechar(null)}},view:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,a=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"atencao",o=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;this.limpar();var n="                        \n        <div class='corpo-da-mensagem ".concat(a,'\'>\n            <span class="corpo-da-mensagem--texto">').concat(t,"</span>\n            <a title='Fechar esta opção.' id=\"fechar-").concat(a,"\"\n                class='bt-fechar-msg'>\n                <i class='ico ico-close ").concat(a,'\'></i>\n            </a>\n            <div id="progress-bar"></div> \n        </div>'),r=document.createElement("div");r.id="mensagem",r.classList.add(a),r.innerHTML=n;var c=document.querySelector("#app");c.appendChild(r);var i=document.querySelector(".bt-fechar-msg");i.addEventListener("click",e.fecharMensagem);var s=document.querySelector(".corpo-da-mensagem");s&&s.addEventListener("click",e.fecharMensagem),e.timerFechar(o)},fecharMensagem:function(){var t=document.querySelector("#mensagem");t&&(t.classList.add("fechar"),e.data.executar&&clearTimeout(e.data.executar),e.data.executar=setTimeout((function(){document.querySelector("#app").removeChild(t)}),1e3))},timerFechar:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:6e3,a="6s";null==t&&(t=6e3),1e4==t&&(a="10s"),3e3==t&&(a="3s"),e.progressBar(a),this.data.executar&&clearTimeout(this.data.executar),this.data.executar=setTimeout((function(){e.fecharMensagem()}),t)},progressBar:function(e,t){if(document.querySelector("#mensagem")){var a=document.getElementById("progress-bar");if(a){a.className="progressbar";var o=document.createElement("div");o.className="inner",o.style.animationDuration=e,"function"==typeof t&&o.addEventListener("animationend",t),a.appendChild(o),o.style.animationPlayState="running"}}},limpar:function(){var e=document.querySelector("#mensagem");e&&e.parentElement.removeChild(e),this.data.executar&&clearTimeout(this.data.executar)}};e.preLoad();var t={preLoad:function(){document.querySelectorAll(".copiarFraseFavorita").forEach((function(e){e.onclick=function(e){e.stopPropagation(),e.preventDefault();var a=e.target.attributes.idData.nodeValue;t.copiarFraseFavorita(a)}}))},copiarFraseFavorita:function(t){var a=document.createElement("input"),o=document.querySelector("#frase_"+t).innerHTML;document.body.appendChild(a),a.value=o,a.select();try{document.execCommand("copy"),e.view("Frase copiada!","sucesso"),document.body.removeChild(a)}catch(t){e.view("Oops, não foi possível copiar.","sucesso")}}},o={preLoad:function(){document.querySelectorAll(".imprimir").forEach((function(e){e.onclick=function(e){e.stopPropagation(),e.preventDefault(),o.imprimir()}}))},imprimir:function(){try{document.execCommand("print")}catch(e){alert("Oops, não foi possível posível.")}}},n=function(){document.querySelectorAll(".acc").forEach((function(e){e.onclick=function(e){e.stopPropagation(),e.preventDefault(),e.target.classList.toggle("ativo");var t=this.nextElementSibling;"[object HTMLParagraphElement]"!=Object.prototype.toString.call(t)&&(t=t.nextElementSibling),t.classList.toggle("ativo")}}))},r=function(){var e=document.getElementById("assunto"),t=document.getElementById("bt-g-recaptcha-submit"),a=document.getElementById("form01Contato"),o=document.getElementById("g-recaptcha-response");e&&e.addEventListener("change",(function(e){"notselected"!=e.target.value?(t.classList.add("ok"),t.classList.remove("nok")):(t.classList.remove("ok"),t.classList.add("nok"))})),t&&(t.onclick=function(e){e.stopPropagation(),e.preventDefault(),grecaptcha.ready((function(){grecaptcha.execute("6LeG8usfAAAAAAjTi90ueiXFpH5FLoCOdx5rUyXg",{action:"submit"}).then((function(e){a&&(o.value=e,a.submit())}))}))})},c={data:{executar:null},preLoad:function(){document.body.addEventListener("keydown",(function(e){27==((e=e||window.event).which||e.keyCode)&&c.closeAll()}))},view:function(){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"atencao";this.limpar();var t="\n            <div class='modal--wrapper ".concat(e,"'>\n                <a title='Fechar esta opção.' class='bt-fechar'></a>            \n            </div>"),a=document.createElement("div");a.id="modal",a.classList.add(e),a.innerHTML=t;var o=document.querySelector("#before");o&&o.appendChild(a);var n=document.querySelector("#modal");n.addEventListener("click",c.closeAll)},closeAll:function(){c.remove(".modal","ativado"),c.remove(".abreMenuUsuario_desk","ativado"),c.remove(".menu-usuario-perfil_desk","ativado"),c.remove(".abreMenuUsuario_mobile","ativado"),c.remove(".menu-usuario-perfil_mobile","ativado"),c.remove(".tool-salvar__criar_pasta","ativado"),c.remove(".tool.tool-salvar","ativado"),c.remove(".modal_salvar","ativado"),c.remove(".wrapper--compartilhar","ativado"),c.remove(".wrapper-modal-dialog","ativo"),c.limpar()},remove:function(e,t){var a=document.querySelector(e);a&&a.classList.remove(t),document.querySelectorAll(e).forEach((function(e){e.classList.remove(t)})),a&&(a.classList.contains("abreMenuUsuario_desk")||a.classList.contains("wrapper--compartilhar")||a.classList.contains("menu-usuario-perfil_desk")||a.parentElement.removeChild(a))},limpar:function(){var e=document.querySelector("#modal");e&&e.parentElement.removeChild(e)}},i={preLoad:function(){var e=document.querySelectorAll(".abreCompartilhar");e&&e.forEach((function(e){e.onclick=function(e){e.stopPropagation(),e.preventDefault();var t=document.querySelector(".wrapper--compartilhar");t&&(t.classList.toggle("ativado"),t.classList.contains("ativado")?c.view():c.closeAll())}})),document.querySelectorAll(".copiarLink").forEach((function(e){e.onclick=function(e){e.stopPropagation(),e.preventDefault(),i.copiarLink()}}))},copiarLink:function(){var t=document.querySelector("#urlamigavel");t.setAttribute("type","text"),t.select();try{var a=document.execCommand("copy")?"Link Copiado!":"com falhas";e.view(a,"sucesso",3e3)}catch(t){e.view("Vixi!, Seu navegador não suporta este recurso","error")}}};i.preLoad(),t.preLoad(),o.preLoad(),n(),r(),a(980),a(905)})()})();