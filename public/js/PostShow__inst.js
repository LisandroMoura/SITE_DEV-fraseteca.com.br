(()=>{var e={980:()=>{document.addEventListener("DOMContentLoaded",(function(){var e=document.querySelectorAll(".lazy-hidden"),t=document.querySelectorAll("img.lazy-hidden_"),a=document.querySelectorAll("img.avatar.photo_"),o=document.querySelectorAll(".lazy-background");imagensCollection=Array.from(e).concat(Array.from(t)).concat(Array.from(a)),bgsCollection=Array.from(o);var n,r=0,i=0;function s(e){var t=e.getBoundingClientRect(),a=window.pageXOffset||document.documentElement.scrollLeft,o=window.pageYOffset||document.documentElement.scrollTop;return{top:t.top+o,left:t.left+a}}function l(){n&&clearTimeout(n),n=setTimeout((function(){var e=window.pageYOffset;imagensCollection.forEach((function(t){t.classList.contains("aguardando")&&(s(t).top<window.innerHeight+e&&(t.src=t.dataset.src,t.dataset.srcset&&(t.srcset=t.dataset.srcset),t.classList.remove("aguardando"),i++))})),c=0,bgsCollection.forEach((function(t){t.classList.contains("aguardando")&&(s(t).top<window.innerHeight+e&&(t.style.backgroundImage="url('"+t.dataset.src+"')",t.classList.remove("aguardando"),i++))}))}),20),r==i&&(document.removeEventListener("scroll",l),window.removeEventListener("resize",l),window.removeEventListener("orientationChange",l))}imagensCollection.forEach((function(e){e.classList.add("aguardando"),r++})),bgsCollection.forEach((function(e){e.classList.add("aguardando"),r++})),document.addEventListener("scroll",l),window.addEventListener("resize",l),window.addEventListener("orientationChange",l);var d=document.querySelectorAll(".autoload"),u=Array.from(d);loadTimeout=setTimeout((function(){u.forEach((function(e){e.style.backgroundImage="url('"+e.dataset.src+"')"}))}))}))},905:()=>{var e,t,a;WebFontConfig={google:{families:["Montserrat:400,500,600"]}},e=document,t=e.createElement("script"),a=e.scripts[0],t.src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js",t.async=!0,a.parentNode.insertBefore(t,a)}},t={};function a(o){var n=t[o];if(void 0!==n)return n.exports;var r=t[o]={exports:{}};return e[o](r,r.exports,a),r.exports}(()=>{"use strict";var e={preLoad:function(){document.querySelectorAll(".imprimir").forEach((function(t){t.onclick=function(t){t.stopPropagation(),t.preventDefault(),e.imprimir()}}))},imprimir:function(){try{document.execCommand("print")}catch(e){alert("Oops, não foi possível posível.")}}},t=function(){document.querySelectorAll(".acc").forEach((function(e){e.onclick=function(e){e.stopPropagation(),e.preventDefault(),e.target.classList.toggle("ativo");var t=this.nextElementSibling;"[object HTMLParagraphElement]"!=Object.prototype.toString.call(t)&&(t=t.nextElementSibling),t.classList.toggle("ativo")}}))},o={data:{executar:null},preLoad:function(){document.body.addEventListener("keydown",(function(e){27==((e=e||window.event).which||e.keyCode)&&o.closeAll()}))},view:function(){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"atencao";this.limpar();var t="\n            <div class='modal--wrapper ".concat(e,"'>\n                <a title='Fechar esta opção.' class='bt-fechar'></a>            \n            </div>"),a=document.createElement("div");a.id="modal",a.classList.add(e),a.innerHTML=t;var n=document.querySelector("#before");n&&n.appendChild(a);var r=document.querySelector("#modal");r.addEventListener("click",o.closeAll)},closeAll:function(){o.remove(".modal","ativado"),o.remove(".abreMenuUsuario_desk","ativado"),o.remove(".menu-usuario-perfil_desk","ativado"),o.remove(".abreMenuUsuario_mobile","ativado"),o.remove(".menu-usuario-perfil_mobile","ativado"),o.remove(".tool-salvar__criar_pasta","ativado"),o.remove(".tool.tool-salvar","ativado"),o.remove(".modal_salvar","ativado"),o.remove(".wrapper--compartilhar","ativado"),o.remove(".wrapper-modal-dialog","ativo"),o.limpar()},remove:function(e,t){var a=document.querySelector(e);a&&a.classList.remove(t),document.querySelectorAll(e).forEach((function(e){e.classList.remove(t)})),a&&(a.classList.contains("abreMenuUsuario_desk")||a.classList.contains("wrapper--compartilhar")||a.classList.contains("menu-usuario-perfil_desk")||a.parentElement.removeChild(a))},limpar:function(){var e=document.querySelector("#modal");e&&e.parentElement.removeChild(e)}},n=function(){document.querySelectorAll(".abreMenuUsuario_desk").forEach((function(e){e.onclick=function(t){var a=document.querySelector(".menu-usuario-perfil_desk");a.classList.contains("ativado")?(a.classList.remove("ativado"),e.classList.remove("ativado")):(a.classList.add("ativado"),e.classList.add("ativado"),o.view())}}))},r=function(){var e=document.getElementById("assunto"),t=document.getElementById("bt-g-recaptcha-submit"),a=document.getElementById("form01Contato"),o=document.getElementById("g-recaptcha-response");e&&e.addEventListener("change",(function(e){"notselected"!=e.target.value?(t.classList.add("ok"),t.classList.remove("nok")):(t.classList.remove("ok"),t.classList.add("nok"))})),t&&(t.onclick=function(e){e.stopPropagation(),e.preventDefault(),grecaptcha.ready((function(){grecaptcha.execute("6LeG8usfAAAAAAjTi90ueiXFpH5FLoCOdx5rUyXg",{action:"submit"}).then((function(e){a&&(o.value=e,a.submit())}))}))})},c={data:{executar:null},preLoad:function(){},preLoadPhp:function(){var e=arguments.length>0&&void 0!==arguments[0]&&arguments[0],t=document.getElementById("mensagem");if(t){var a=document.querySelector(".bt-fechar-msg");a&&a.addEventListener("click",c.fecharMensagem);var o=document.querySelector(".corpo-da-mensagem");o&&o.addEventListener("click",c.fecharMensagem),e||c.timerFechar(null)}},view:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"atencao",a=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;this.limpar();var o="                        \n        <div class='corpo-da-mensagem ".concat(t,'\'>\n            <span class="corpo-da-mensagem--texto">').concat(e,"</span>\n            <a title='Fechar esta opção.' id=\"fechar-").concat(t,"\"\n                class='bt-fechar-msg'>\n                <i class='ico ico-close ").concat(t,'\'></i>\n            </a>\n            <div id="progress-bar"></div> \n        </div>'),n=document.createElement("div");n.id="mensagem",n.classList.add(t),n.innerHTML=o;var r=document.querySelector("#app");r.appendChild(n);var i=document.querySelector(".bt-fechar-msg");i.addEventListener("click",c.fecharMensagem);var s=document.querySelector(".corpo-da-mensagem");s&&s.addEventListener("click",c.fecharMensagem),c.timerFechar(a)},fecharMensagem:function(){var e=document.querySelector("#mensagem");e&&(e.classList.add("fechar"),c.data.executar&&clearTimeout(c.data.executar),c.data.executar=setTimeout((function(){document.querySelector("#app").removeChild(e)}),1e3))},timerFechar:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:6e3,t="6s";null==e&&(e=6e3),1e4==e&&(t="10s"),3e3==e&&(t="3s"),c.progressBar(t),this.data.executar&&clearTimeout(this.data.executar),this.data.executar=setTimeout((function(){c.fecharMensagem()}),e)},progressBar:function(e,t){if(document.querySelector("#mensagem")){var a=document.getElementById("progress-bar");if(a){a.className="progressbar";var o=document.createElement("div");o.className="inner",o.style.animationDuration=e,"function"==typeof t&&o.addEventListener("animationend",t),a.appendChild(o),o.style.animationPlayState="running"}}},limpar:function(){var e=document.querySelector("#mensagem");e&&e.parentElement.removeChild(e),this.data.executar&&clearTimeout(this.data.executar)}};c.preLoad(),e.preLoad(),t(),n(),r(),c.preLoadPhp(),a(980),a(905)})()})();