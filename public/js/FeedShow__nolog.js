(()=>{"use strict";var e={data:{executar:null},preLoad:function(){},preLoadPhp:function(){if(document.getElementById("mensagem")){var a=document.querySelector(".bt-fechar-msg");a&&a.addEventListener("click",e.fecharMensagem);var t=document.querySelector(".corpo-da-mensagem");t&&t.addEventListener("click",e.fecharMensagem),e.timerFechar(null)}},view:function(){var a=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"atencao",o=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;this.limpar();var n="                        \n        <div class='corpo-da-mensagem ".concat(t,'\'>\n            <span class="corpo-da-mensagem--texto">').concat(a,"</span>\n            <a title='Fechar esta opção.' id=\"fechar-").concat(t,"\"\n                class='bt-fechar-msg'>\n                <i class='ico ico-close ").concat(t,'\'></i>\n            </a>\n            <div id="progress-bar"></div> \n        </div>'),r=document.createElement("div");r.id="mensagem",r.classList.add(t),r.innerHTML=n;var c=document.querySelector("#app");c.appendChild(r);var i=document.querySelector(".bt-fechar-msg");i.addEventListener("click",e.fecharMensagem);var l=document.querySelector(".corpo-da-mensagem");l&&l.addEventListener("click",e.fecharMensagem),e.timerFechar(o)},fecharMensagem:function(){console.log("fechar msg");var a=document.querySelector("#mensagem");a&&(a.classList.add("fechar"),e.data.executar&&clearTimeout(e.data.executar),e.data.executar=setTimeout((function(){document.querySelector("#app").removeChild(a)}),1e3))},timerFechar:function(){var a=arguments.length>0&&void 0!==arguments[0]?arguments[0]:6e3,t="6s";null==a&&(a=6e3),1e4==a&&(t="10s"),3e3==a&&(t="3s"),e.progressBar(t),this.data.executar&&clearTimeout(this.data.executar),this.data.executar=setTimeout((function(){e.fecharMensagem()}),a)},progressBar:function(e,a){if(document.querySelector("#mensagem")){var t=document.getElementById("progress-bar");if(t){t.className="progressbar";var o=document.createElement("div");o.className="inner",o.style.animationDuration=e,"function"==typeof a&&o.addEventListener("animationend",a),t.appendChild(o),o.style.animationPlayState="running"}}},limpar:function(){var e=document.querySelector("#mensagem");e&&e.parentElement.removeChild(e),this.data.executar&&clearTimeout(this.data.executar)}};e.preLoad();var a={preLoad:function(){document.querySelectorAll(".copiarFraseFavorita").forEach((function(e){e.onclick=function(e){e.stopPropagation(),e.preventDefault();var t=e.target.attributes.idData.nodeValue;a.copiarFraseFavorita(t)}}))},copiarFraseFavorita:function(a){var t=document.createElement("input"),o=document.querySelector("#frase_copiar_"+a).innerHTML;document.body.appendChild(t),t.value=o,t.select();try{document.execCommand("copy");e.view("Frase copiada!","sucesso"),document.body.removeChild(t)}catch(a){e.view("Oops, não foi possível copiar.","sucesso")}}},t={preLoad:function(){document.querySelectorAll(".imprimir").forEach((function(e){e.onclick=function(e){e.stopPropagation(),e.preventDefault(),t.imprimir()}}))},imprimir:function(){try{document.execCommand("print")}catch(e){alert("Oops, não foi possível posível.")}}},o=function(){document.querySelectorAll(".acc").forEach((function(e){e.onclick=function(e){e.stopPropagation(),e.preventDefault(),e.target.classList.toggle("ativo");var a=this.nextElementSibling;console.log(a),"[object HTMLParagraphElement]"!=Object.prototype.toString.call(a)&&(a=a.nextElementSibling),a.classList.toggle("ativo")}}))},n=function(){var e=document.getElementById("assunto"),a=document.getElementById("bt-g-recaptcha-submit"),t=document.getElementById("form01Contato"),o=document.getElementById("g-recaptcha-response");e&&e.addEventListener("change",(function(e){"notselected"!=e.target.value?(a.classList.add("ok"),a.classList.remove("nok")):(a.classList.remove("ok"),a.classList.add("nok"))})),a&&(a.onclick=function(e){e.stopPropagation(),e.preventDefault(),grecaptcha.ready((function(){grecaptcha.execute("6LeG8usfAAAAAAjTi90ueiXFpH5FLoCOdx5rUyXg",{action:"submit"}).then((function(e){t&&(o.value=e,t.submit())}))}))})},r={data:{executar:null},preLoad:function(){document.body.addEventListener("keydown",(function(e){27==((e=e||window.event).which||e.keyCode)&&r.closeAll()}))},view:function(){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"atencao";this.limpar();var a="\n            <div class='modal--wrapper ".concat(e,"'>\n                <a title='Fechar esta opção.' class='bt-fechar'></a>            \n            </div>"),t=document.createElement("div");t.id="modal",t.classList.add(e),t.innerHTML=a;var o=document.querySelector("#before");o&&o.appendChild(t);var n=document.querySelector("#modal");n.addEventListener("click",r.closeAll)},closeAll:function(){r.remove(".modal","ativado"),r.remove(".abreMenuUsuario_desk","ativado"),r.remove(".menu-usuario-perfil_desk","ativado"),r.remove(".abreMenuUsuario_mobile","ativado"),r.remove(".menu-usuario-perfil_mobile","ativado"),r.remove(".tool-salvar__criar_pasta","ativado"),r.remove(".tool.tool-salvar","ativado"),r.remove(".modal_salvar","ativado"),r.remove(".wrapper--compartilhar","ativado"),r.limpar()},remove:function(e,a){var t=document.querySelector(e);t&&t.classList.remove(a),document.querySelectorAll(e).forEach((function(e){e.classList.remove(a)}))},limpar:function(){var e=document.querySelector("#modal");e&&e.parentElement.removeChild(e)}},c={preLoad:function(){var e=document.querySelectorAll(".abreCompartilhar");e&&e.forEach((function(e){e.onclick=function(e){e.stopPropagation(),e.preventDefault();var a=document.querySelector(".wrapper--compartilhar");a&&(a.classList.toggle("ativado"),a.classList.contains("ativado")?r.view():r.closeAll())}})),document.querySelectorAll(".copiarLink").forEach((function(e){e.onclick=function(e){e.stopPropagation(),e.preventDefault(),c.copiarLink()}}))},copiarLink:function(){var a=document.querySelector("#urlamigavel");a.setAttribute("type","text"),a.select();try{var t=document.execCommand("copy")?"Link Copiado!":"com falhas";e.view(t,"sucesso",3e3)}catch(a){e.view("Vixi!, Seu navegador não suporta este recurso","error")}}};c.preLoad(),a.preLoad(),t.preLoad(),o(),n()})();