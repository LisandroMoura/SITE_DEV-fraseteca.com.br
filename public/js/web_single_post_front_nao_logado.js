!function(e){var t={};function n(r){if(t[r])return t[r].exports;var a=t[r]={i:r,l:!1,exports:{}};return e[r].call(a.exports,a,a.exports,n),a.l=!0,a.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var a in e)n.d(r,a,function(t){return e[t]}.bind(null,a));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=292)}({1:function(e,t,n){"use strict";n.d(t,"a",function(){return r});var r={data:{executar:null},preLoad:function(){},preLoadPhp:function(){if(document.getElementById("mensagem")){var e=document.querySelector(".bt-fechar-msg");e&&e.addEventListener("click",r.fecharMensagem);var t=document.querySelector(".corpo-da-mensagem");t&&t.addEventListener("click",r.fecharMensagem),r.timerFechar(null)}},view:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"atencao",n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;this.limpar();var a="                        \n        <div class='corpo-da-mensagem ".concat(t,'\'>\n            <span class="corpo-da-mensagem--texto">').concat(e,"</span>\n            <a title='Fechar esta opção.' id=\"fechar-").concat(t,"\"\n                class='bt-fechar-msg'>\n                <i class='ico ico-close ").concat(t,'\'></i>\n            </a>\n            <div id="progress-bar"></div> \n        </div>'),o=document.createElement("div");o.id="mensagem",o.classList.add(t),o.innerHTML=a,document.querySelector("#app").appendChild(o),document.querySelector(".bt-fechar-msg").addEventListener("click",r.fecharMensagem);var c=document.querySelector(".corpo-da-mensagem");c&&c.addEventListener("click",r.fecharMensagem),r.timerFechar(n)},fecharMensagem:function(){var e=document.querySelector("#mensagem");e&&(e.classList.add("fechar"),r.data.executar&&clearTimeout(r.data.executar),r.data.executar=setTimeout(function(){document.querySelector("#app").removeChild(e)},1e3))},timerFechar:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:6e3,t="6s";null==e&&(e=6e3),1e4==e&&(t="10s"),3e3==e&&(t="3s"),r.progressBar(t),this.data.executar&&clearTimeout(this.data.executar),this.data.executar=setTimeout(function(){r.fecharMensagem()},e)},progressBar:function(e,t){if(document.querySelector("#mensagem")){var n=document.getElementById("progress-bar");if(n){n.className="progressbar";var r=document.createElement("div");r.className="inner",r.style.animationDuration=e,"function"==typeof t&&r.addEventListener("animationend",t),n.appendChild(r),r.style.animationPlayState="running"}}},limpar:function(){var e=document.querySelector("#mensagem");e&&e.parentElement.removeChild(e),this.data.executar&&clearTimeout(this.data.executar)}}},292:function(e,t,n){e.exports=n(293)},293:function(e,t,n){"use strict";n.r(t);var r=n(45),a=n(68);r.a.preLoad(),a.a.preLoad()},45:function(e,t,n){"use strict";n.d(t,"a",function(){return a});var r=n(1),a={preLoad:function(){document.querySelectorAll(".copiarFraseFavorita").forEach(function(e){e.onclick=function(e){e.stopPropagation(),e.preventDefault();var t=e.target.attributes.idData.nodeValue;a.copiarFraseFavorita(t)}})},copiarFraseFavorita:function(e){var t=document.createElement("input"),n=document.querySelector("#frase_copiar_"+e).innerHTML;document.body.appendChild(t),t.value=n,t.select();try{document.execCommand("copy");r.a.view("Frase copiada!","sucesso"),document.body.removeChild(t)}catch(e){r.a.view("Oops, não foi possível copiar.","sucesso")}}}},68:function(e,t,n){"use strict";n.d(t,"a",function(){return r});var r={preLoad:function(){document.querySelectorAll(".imprimir").forEach(function(e){e.onclick=function(e){e.stopPropagation(),e.preventDefault(),r.imprimir()}})},imprimir:function(){try{document.execCommand("print")}catch(e){alert("Oops, não foi possível posível.")}}}}});