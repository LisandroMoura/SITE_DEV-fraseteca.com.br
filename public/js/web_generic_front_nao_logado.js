!function(e){var n={};function a(t){if(n[t])return n[t].exports;var c=n[t]={i:t,l:!1,exports:{}};return e[t].call(c.exports,c,c.exports,a),c.l=!0,c.exports}a.m=e,a.c=n,a.d=function(e,n,t){a.o(e,n)||Object.defineProperty(e,n,{enumerable:!0,get:t})},a.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},a.t=function(e,n){if(1&n&&(e=a(e)),8&n)return e;if(4&n&&"object"==typeof e&&e&&e.__esModule)return e;var t=Object.create(null);if(a.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:e}),2&n&&"string"!=typeof e)for(var c in e)a.d(t,c,function(n){return e[n]}.bind(null,c));return t},a.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(n,"a",n),n},a.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},a.p="/",a(a.s=308)}({1:function(e,n,a){"use strict";a.d(n,"a",function(){return t});var t={data:{executar:null},preLoad:function(){},preLoadPhp:function(){if(document.getElementById("mensagem")){var e=document.querySelector(".bt-fechar-msg");e&&e.addEventListener("click",t.fecharMensagem);var n=document.querySelector(".corpo-da-mensagem");n&&n.addEventListener("click",t.fecharMensagem),t.timerFechar(null)}},view:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"atencao",a=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;this.limpar();var c="                        \n        <div class='corpo-da-mensagem ".concat(n,'\'>\n            <span class="corpo-da-mensagem--texto">').concat(e,"</span>\n            <a title='Fechar esta opção.' id=\"fechar-").concat(n,"\"\n                class='bt-fechar-msg'>\n                <i class='ico ico-close ").concat(n,'\'></i>\n            </a>\n            <div id="progress-bar"></div> \n        </div>'),r=document.createElement("div");r.id="mensagem",r.classList.add(n),r.innerHTML=c,document.querySelector("#app").appendChild(r),document.querySelector(".bt-fechar-msg").addEventListener("click",t.fecharMensagem);var o=document.querySelector(".corpo-da-mensagem");o&&o.addEventListener("click",t.fecharMensagem),t.timerFechar(a)},fecharMensagem:function(){var e=document.querySelector("#mensagem");e&&(e.classList.add("fechar"),t.data.executar&&clearTimeout(t.data.executar),t.data.executar=setTimeout(function(){document.querySelector("#app").removeChild(e)},1e3))},timerFechar:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:6e3,n="6s";null==e&&(e=6e3),1e4==e&&(n="10s"),3e3==e&&(n="3s"),t.progressBar(n),this.data.executar&&clearTimeout(this.data.executar),this.data.executar=setTimeout(function(){t.fecharMensagem()},e)},progressBar:function(e,n){if(document.querySelector("#mensagem")){var a=document.getElementById("progress-bar");if(a){a.className="progressbar";var t=document.createElement("div");t.className="inner",t.style.animationDuration=e,"function"==typeof n&&t.addEventListener("animationend",n),a.appendChild(t),t.style.animationPlayState="running"}}},limpar:function(){var e=document.querySelector("#mensagem");e&&e.parentElement.removeChild(e),this.data.executar&&clearTimeout(this.data.executar)}}},308:function(e,n,a){e.exports=a(309)},309:function(e,n,a){"use strict";a.r(n);var t=a(1);a(76).a.preLoad(),t.a.preLoadPhp()},76:function(e,n,a){"use strict";a.d(n,"a",function(){return t});var t={data:{action:"",callback:"",callbackCancel:""},preLoad:function(){var e=document.querySelectorAll(".callLogin"),n=document.querySelector(".ref_call_login");e.forEach(function(e){e.onclick=function(e){var a=e.target.title||"Para salvar este conteúdo, você precisa ter cadastro e fazer login. Deseja fazer Login?";e.stopPropagation(),e.preventDefault(),t.openView(n,a,"confirma info","Que tal fazer login?")}})},openView:function(e){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null,a=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null,c=arguments.length>3&&void 0!==arguments[3]?arguments[3]:null,r=arguments.length>4&&void 0!==arguments[4]?arguments[4]:null,o=arguments.length>5&&void 0!==arguments[5]?arguments[5]:null;this.limpaTudo();var i='\n        <div class="modal-zone">\n            <div class="'.concat(a,'">\n                <div class="topo">\n                    <div>\n                        <i class="ico bt-confirma ico-atencao"></i> \n                        <span>\n                            ').concat(c,'\n                        </span>\n                    </div>\n                </div>\n                <div class="box texto">\n                    <span>\n                        ').concat(n,'\n                    </span>\n                </div>\n                <div class="box botoes">\n                    <div class="col">\n                        <a id="bt_confirmar_ok" class="pointer bt_confirmar true">\n                            <span>Confirma</span>\n                        </a>\n                    </div>\n                    <div class="col">\n                        <a id="bt_cancelar" class="pointer bt_cancelar false">\n                            <span>Cancela</span>\n                        </a>\n                    </div>\n                </div>\n            </div>\n        </div>\n        '),l=document.createElement("div");return l.id="confirma",l.classList.add("container"),l.classList.add("vue-js-component"),l.innerHTML='<div class="vue-js-modal">'+i+"</div>",document.querySelector("#app").appendChild(l),document.querySelector("#bt_cancelar").addEventListener("click",this.fecharConfirma),t.data.action=e,t.data.callback=r,t.data.callbackCancel=o,document.querySelector("#bt_confirmar_ok").addEventListener("click",t.itsOk),!0},limpaTudo:function(){var e=document.querySelector("#confirma");e&&e.parentElement.removeChild(e)},fecharConfirma:function(e){var n=document.querySelector("#confirma");n.classList.add("fechar");setTimeout(function(){document.querySelector("#app").removeChild(n),t.data.callbackCancel&&t.data.callbackCancel()},200)},itsOk:function(e){t.data.callback?t.data.callback.submit():t.data.action.click()}}}});