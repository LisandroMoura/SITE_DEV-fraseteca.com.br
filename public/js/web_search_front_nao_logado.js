!function(e){var a={};function n(t){if(a[t])return a[t].exports;var c=a[t]={i:t,l:!1,exports:{}};return e[t].call(c.exports,c,c.exports,n),c.l=!0,c.exports}n.m=e,n.c=a,n.d=function(e,a,t){n.o(e,a)||Object.defineProperty(e,a,{enumerable:!0,get:t})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,a){if(1&a&&(e=n(e)),8&a)return e;if(4&a&&"object"==typeof e&&e&&e.__esModule)return e;var t=Object.create(null);if(n.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:e}),2&a&&"string"!=typeof e)for(var c in e)n.d(t,c,function(a){return e[a]}.bind(null,c));return t},n.n=function(e){var a=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(a,"a",a),a},n.o=function(e,a){return Object.prototype.hasOwnProperty.call(e,a)},n.p="/",n(n.s=314)}({1:function(e,a,n){"use strict";n.d(a,"a",function(){return t});var t={data:{executar:null},preLoad:function(){},preLoadPhp:function(){if(document.getElementById("mensagem")){var e=document.querySelector(".bt-fechar-msg");e&&e.addEventListener("click",t.fecharMensagem);var a=document.querySelector(".corpo-da-mensagem");a&&a.addEventListener("click",t.fecharMensagem),t.timerFechar(null)}},view:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,a=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"atencao",n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;this.limpar();var c="                        \n        <div class='corpo-da-mensagem ".concat(a,'\'>\n            <span class="corpo-da-mensagem--texto">').concat(e,"</span>\n            <a title='Fechar esta opção.' id=\"fechar-").concat(a,"\"\n                class='bt-fechar-msg'>\n                <i class='ico ico-close ").concat(a,'\'></i>\n            </a>\n            <div id="progress-bar"></div> \n        </div>'),r=document.createElement("div");r.id="mensagem",r.classList.add(a),r.innerHTML=c,document.querySelector("#app").appendChild(r),document.querySelector(".bt-fechar-msg").addEventListener("click",t.fecharMensagem);var o=document.querySelector(".corpo-da-mensagem");o&&o.addEventListener("click",t.fecharMensagem),t.timerFechar(n)},fecharMensagem:function(){var e=document.querySelector("#mensagem");e&&(e.classList.add("fechar"),t.data.executar&&clearTimeout(t.data.executar),t.data.executar=setTimeout(function(){document.querySelector("#app").removeChild(e)},1e3))},timerFechar:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:6e3,a="6s";null==e&&(e=6e3),1e4==e&&(a="10s"),3e3==e&&(a="3s"),t.progressBar(a),this.data.executar&&clearTimeout(this.data.executar),this.data.executar=setTimeout(function(){t.fecharMensagem()},e)},progressBar:function(e,a){if(document.querySelector("#mensagem")){var n=document.getElementById("progress-bar");if(n){n.className="progressbar";var t=document.createElement("div");t.className="inner",t.style.animationDuration=e,"function"==typeof a&&t.addEventListener("animationend",a),n.appendChild(t),t.style.animationPlayState="running"}}},limpar:function(){var e=document.querySelector("#mensagem");e&&e.parentElement.removeChild(e),this.data.executar&&clearTimeout(this.data.executar)}}},314:function(e,a,n){e.exports=n(315)},315:function(e,a,n){"use strict";n.r(a);var t=n(76),c=n(45);t.a.preLoad(),c.a.preLoad()},45:function(e,a,n){"use strict";n.d(a,"a",function(){return c});var t=n(1),c={preLoad:function(){document.querySelectorAll(".copiarFraseFavorita").forEach(function(e){e.onclick=function(e){e.stopPropagation(),e.preventDefault();var a=e.target.attributes.idData.nodeValue;c.copiarFraseFavorita(a)}})},copiarFraseFavorita:function(e){var a=document.createElement("input"),n=document.querySelector("#frase_copiar_"+e).innerHTML;document.body.appendChild(a),a.value=n,a.select();try{document.execCommand("copy");t.a.view("Frase copiada!","sucesso"),document.body.removeChild(a)}catch(e){t.a.view("Oops, não foi possível copiar.","sucesso")}}}},76:function(e,a,n){"use strict";n.d(a,"a",function(){return t});var t={data:{action:"",callback:"",callbackCancel:""},preLoad:function(){var e=document.querySelectorAll(".callLogin"),a=document.querySelector(".ref_call_login");e.forEach(function(e){e.onclick=function(e){var n=e.target.title||"Para salvar este conteúdo, você precisa ter cadastro e fazer login. Deseja fazer Login?";e.stopPropagation(),e.preventDefault(),t.openView(a,n,"confirma info","Que tal fazer login?")}})},openView:function(e){var a=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null,n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null,c=arguments.length>3&&void 0!==arguments[3]?arguments[3]:null,r=arguments.length>4&&void 0!==arguments[4]?arguments[4]:null,o=arguments.length>5&&void 0!==arguments[5]?arguments[5]:null;this.limpaTudo();var i='\n        <div class="modal-zone">\n            <div class="'.concat(n,'">\n                <div class="topo">\n                    <div>\n                        <i class="ico bt-confirma ico-atencao"></i> \n                        <span>\n                            ').concat(c,'\n                        </span>\n                    </div>\n                </div>\n                <div class="box texto">\n                    <span>\n                        ').concat(a,'\n                    </span>\n                </div>\n                <div class="box botoes">\n                    <div class="col">\n                        <a id="bt_confirmar_ok" class="pointer bt_confirmar true">\n                            <span>Confirma</span>\n                        </a>\n                    </div>\n                    <div class="col">\n                        <a id="bt_cancelar" class="pointer bt_cancelar false">\n                            <span>Cancela</span>\n                        </a>\n                    </div>\n                </div>\n            </div>\n        </div>\n        '),l=document.createElement("div");return l.id="confirma",l.classList.add("container"),l.classList.add("vue-js-component"),l.innerHTML='<div class="vue-js-modal">'+i+"</div>",document.querySelector("#app").appendChild(l),document.querySelector("#bt_cancelar").addEventListener("click",this.fecharConfirma),t.data.action=e,t.data.callback=r,t.data.callbackCancel=o,document.querySelector("#bt_confirmar_ok").addEventListener("click",t.itsOk),!0},limpaTudo:function(){var e=document.querySelector("#confirma");e&&e.parentElement.removeChild(e)},fecharConfirma:function(e){var a=document.querySelector("#confirma");a.classList.add("fechar");setTimeout(function(){document.querySelector("#app").removeChild(a),t.data.callbackCancel&&t.data.callbackCancel()},200)},itsOk:function(e){t.data.callback?t.data.callback.submit():t.data.action.click()}}}});