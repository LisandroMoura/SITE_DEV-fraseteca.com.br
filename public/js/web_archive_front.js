!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=303)}({0:function(e,t,n){"use strict";var r=n(12),o=n(25),a=Object.prototype.toString;function i(e){return"[object Array]"===a.call(e)}function s(e){return null!==e&&"object"==typeof e}function c(e){return"[object Function]"===a.call(e)}function u(e,t){if(null!=e)if("object"!=typeof e&&(e=[e]),i(e))for(var n=0,r=e.length;n<r;n++)t.call(null,e[n],n,e);else for(var o in e)Object.prototype.hasOwnProperty.call(e,o)&&t.call(null,e[o],o,e)}e.exports={isArray:i,isArrayBuffer:function(e){return"[object ArrayBuffer]"===a.call(e)},isBuffer:o,isFormData:function(e){return"undefined"!=typeof FormData&&e instanceof FormData},isArrayBufferView:function(e){return"undefined"!=typeof ArrayBuffer&&ArrayBuffer.isView?ArrayBuffer.isView(e):e&&e.buffer&&e.buffer instanceof ArrayBuffer},isString:function(e){return"string"==typeof e},isNumber:function(e){return"number"==typeof e},isObject:s,isUndefined:function(e){return void 0===e},isDate:function(e){return"[object Date]"===a.call(e)},isFile:function(e){return"[object File]"===a.call(e)},isBlob:function(e){return"[object Blob]"===a.call(e)},isFunction:c,isStream:function(e){return s(e)&&c(e.pipe)},isURLSearchParams:function(e){return"undefined"!=typeof URLSearchParams&&e instanceof URLSearchParams},isStandardBrowserEnv:function(){return("undefined"==typeof navigator||"ReactNative"!==navigator.product)&&"undefined"!=typeof window&&"undefined"!=typeof document},forEach:u,merge:function e(){var t={};function n(n,r){"object"==typeof t[r]&&"object"==typeof n?t[r]=e(t[r],n):t[r]=n}for(var r=0,o=arguments.length;r<o;r++)u(arguments[r],n);return t},extend:function(e,t,n){return u(t,function(t,o){e[o]=n&&"function"==typeof t?r(t,n):t}),e},trim:function(e){return e.replace(/^\s*/,"").replace(/\s*$/,"")}}},1:function(e,t,n){"use strict";n.d(t,"a",function(){return r});var r={data:{executar:null},preLoad:function(){},preLoadPhp:function(){if(document.getElementById("mensagem")){var e=document.querySelector(".bt-fechar-msg");e&&e.addEventListener("click",r.fecharMensagem);var t=document.querySelector(".corpo-da-mensagem");t&&t.addEventListener("click",r.fecharMensagem),r.timerFechar(null)}},view:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"atencao",n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;this.limpar();var o="                        \n        <div class='corpo-da-mensagem ".concat(t,'\'>\n            <span class="corpo-da-mensagem--texto">').concat(e,"</span>\n            <a title='Fechar esta opção.' id=\"fechar-").concat(t,"\"\n                class='bt-fechar-msg'>\n                <i class='ico ico-close ").concat(t,'\'></i>\n            </a>\n            <div id="progress-bar"></div> \n        </div>'),a=document.createElement("div");a.id="mensagem",a.classList.add(t),a.innerHTML=o,document.querySelector("#app").appendChild(a),document.querySelector(".bt-fechar-msg").addEventListener("click",r.fecharMensagem);var i=document.querySelector(".corpo-da-mensagem");i&&i.addEventListener("click",r.fecharMensagem),r.timerFechar(n)},fecharMensagem:function(){var e=document.querySelector("#mensagem");e&&(e.classList.add("fechar"),r.data.executar&&clearTimeout(r.data.executar),r.data.executar=setTimeout(function(){document.querySelector("#app").removeChild(e)},1e3))},timerFechar:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:6e3,t="6s";null==e&&(e=6e3),1e4==e&&(t="10s"),3e3==e&&(t="3s"),r.progressBar(t),this.data.executar&&clearTimeout(this.data.executar),this.data.executar=setTimeout(function(){r.fecharMensagem()},e)},progressBar:function(e,t){if(document.querySelector("#mensagem")){var n=document.getElementById("progress-bar");if(n){n.className="progressbar";var r=document.createElement("div");r.className="inner",r.style.animationDuration=e,"function"==typeof t&&r.addEventListener("animationend",t),n.appendChild(r),r.style.animationPlayState="running"}}},limpar:function(){var e=document.querySelector("#mensagem");e&&e.parentElement.removeChild(e),this.data.executar&&clearTimeout(this.data.executar)}}},11:function(e,t){var n,r,o=e.exports={};function a(){throw new Error("setTimeout has not been defined")}function i(){throw new Error("clearTimeout has not been defined")}function s(e){if(n===setTimeout)return setTimeout(e,0);if((n===a||!n)&&setTimeout)return n=setTimeout,setTimeout(e,0);try{return n(e,0)}catch(t){try{return n.call(null,e,0)}catch(t){return n.call(this,e,0)}}}!function(){try{n="function"==typeof setTimeout?setTimeout:a}catch(e){n=a}try{r="function"==typeof clearTimeout?clearTimeout:i}catch(e){r=i}}();var c,u=[],f=!1,l=-1;function d(){f&&c&&(f=!1,c.length?u=c.concat(u):l=-1,u.length&&p())}function p(){if(!f){var e=s(d);f=!0;for(var t=u.length;t;){for(c=u,u=[];++l<t;)c&&c[l].run();l=-1,t=u.length}c=null,f=!1,function(e){if(r===clearTimeout)return clearTimeout(e);if((r===i||!r)&&clearTimeout)return r=clearTimeout,clearTimeout(e);try{r(e)}catch(t){try{return r.call(null,e)}catch(t){return r.call(this,e)}}}(e)}}function m(e,t){this.fun=e,this.array=t}function h(){}o.nextTick=function(e){var t=new Array(arguments.length-1);if(arguments.length>1)for(var n=1;n<arguments.length;n++)t[n-1]=arguments[n];u.push(new m(e,t)),1!==u.length||f||s(p)},m.prototype.run=function(){this.fun.apply(null,this.array)},o.title="browser",o.browser=!0,o.env={},o.argv=[],o.version="",o.versions={},o.on=h,o.addListener=h,o.once=h,o.off=h,o.removeListener=h,o.removeAllListeners=h,o.emit=h,o.prependListener=h,o.prependOnceListener=h,o.listeners=function(e){return[]},o.binding=function(e){throw new Error("process.binding is not supported")},o.cwd=function(){return"/"},o.chdir=function(e){throw new Error("process.chdir is not supported")},o.umask=function(){return 0}},12:function(e,t,n){"use strict";e.exports=function(e,t){return function(){for(var n=new Array(arguments.length),r=0;r<n.length;r++)n[r]=arguments[r];return e.apply(t,n)}}},13:function(e,t,n){"use strict";var r=n(0),o=n(28),a=n(30),i=n(31),s=n(32),c=n(14),u="undefined"!=typeof window&&window.btoa&&window.btoa.bind(window)||n(33);e.exports=function(e){return new Promise(function(t,f){var l=e.data,d=e.headers;r.isFormData(l)&&delete d["Content-Type"];var p=new XMLHttpRequest,m="onreadystatechange",h=!1;if("undefined"==typeof window||!window.XDomainRequest||"withCredentials"in p||s(e.url)||(p=new window.XDomainRequest,m="onload",h=!0,p.onprogress=function(){},p.ontimeout=function(){}),e.auth){var v=e.auth.username||"",g=e.auth.password||"";d.Authorization="Basic "+u(v+":"+g)}if(p.open(e.method.toUpperCase(),a(e.url,e.params,e.paramsSerializer),!0),p.timeout=e.timeout,p[m]=function(){if(p&&(4===p.readyState||h)&&(0!==p.status||p.responseURL&&0===p.responseURL.indexOf("file:"))){var n="getAllResponseHeaders"in p?i(p.getAllResponseHeaders()):null,r={data:e.responseType&&"text"!==e.responseType?p.response:p.responseText,status:1223===p.status?204:p.status,statusText:1223===p.status?"No Content":p.statusText,headers:n,config:e,request:p};o(t,f,r),p=null}},p.onerror=function(){f(c("Network Error",e,null,p)),p=null},p.ontimeout=function(){f(c("timeout of "+e.timeout+"ms exceeded",e,"ECONNABORTED",p)),p=null},r.isStandardBrowserEnv()){var y=n(34),w=(e.withCredentials||s(e.url))&&e.xsrfCookieName?y.read(e.xsrfCookieName):void 0;w&&(d[e.xsrfHeaderName]=w)}if("setRequestHeader"in p&&r.forEach(d,function(e,t){void 0===l&&"content-type"===t.toLowerCase()?delete d[t]:p.setRequestHeader(t,e)}),e.withCredentials&&(p.withCredentials=!0),e.responseType)try{p.responseType=e.responseType}catch(t){if("json"!==e.responseType)throw t}"function"==typeof e.onDownloadProgress&&p.addEventListener("progress",e.onDownloadProgress),"function"==typeof e.onUploadProgress&&p.upload&&p.upload.addEventListener("progress",e.onUploadProgress),e.cancelToken&&e.cancelToken.promise.then(function(e){p&&(p.abort(),f(e),p=null)}),void 0===l&&(l=null),p.send(l)})}},14:function(e,t,n){"use strict";var r=n(29);e.exports=function(e,t,n,o,a){var i=new Error(e);return r(i,t,n,o,a)}},15:function(e,t,n){"use strict";e.exports=function(e){return!(!e||!e.__CANCEL__)}},16:function(e,t,n){"use strict";function r(e){this.message=e}r.prototype.toString=function(){return"Cancel"+(this.message?": "+this.message:"")},r.prototype.__CANCEL__=!0,e.exports=r},20:function(e,t,n){"use strict";n.d(t,"a",function(){return o});var r=n(8),o={data:{labreMenu:""},preLoad:function(){document.querySelectorAll(".abreMenuUsuario_desk").forEach(function(e){e.onclick=function(t){var n=document.querySelector(".menu-usuario-perfil_desk");n.classList.contains("ativado")?(n.classList.remove("ativado"),e.classList.remove("ativado")):(n.classList.add("ativado"),e.classList.add("ativado"),r.a.view())}}),document.querySelectorAll(".abreMenuUsuario_mobile").forEach(function(e){e.onclick=function(t){var n=document.querySelector(".menu-usuario-perfil_mobile");n.classList.contains("ativado")?(n.classList.remove("ativado"),e.classList.remove("ativado")):(n.classList.add("ativado"),e.classList.add("ativado"),r.a.view())}})}}},21:function(e,t,n){window.axios=n(23),window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";var r=document.head.querySelector('meta[name="csrf-token"]');r?window.axios.defaults.headers.common["X-CSRF-TOKEN"]=r.content:console.error("CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token")},23:function(e,t,n){e.exports=n(24)},24:function(e,t,n){"use strict";var r=n(0),o=n(12),a=n(26),i=n(7);function s(e){var t=new a(e),n=o(a.prototype.request,t);return r.extend(n,a.prototype,t),r.extend(n,t),n}var c=s(i);c.Axios=a,c.create=function(e){return s(r.merge(i,e))},c.Cancel=n(16),c.CancelToken=n(40),c.isCancel=n(15),c.all=function(e){return Promise.all(e)},c.spread=n(41),e.exports=c,e.exports.default=c},25:function(e,t){function n(e){return!!e.constructor&&"function"==typeof e.constructor.isBuffer&&e.constructor.isBuffer(e)}e.exports=function(e){return null!=e&&(n(e)||function(e){return"function"==typeof e.readFloatLE&&"function"==typeof e.slice&&n(e.slice(0,0))}(e)||!!e._isBuffer)}},26:function(e,t,n){"use strict";var r=n(7),o=n(0),a=n(35),i=n(36);function s(e){this.defaults=e,this.interceptors={request:new a,response:new a}}s.prototype.request=function(e){"string"==typeof e&&(e=o.merge({url:arguments[0]},arguments[1])),(e=o.merge(r,{method:"get"},this.defaults,e)).method=e.method.toLowerCase();var t=[i,void 0],n=Promise.resolve(e);for(this.interceptors.request.forEach(function(e){t.unshift(e.fulfilled,e.rejected)}),this.interceptors.response.forEach(function(e){t.push(e.fulfilled,e.rejected)});t.length;)n=n.then(t.shift(),t.shift());return n},o.forEach(["delete","get","head","options"],function(e){s.prototype[e]=function(t,n){return this.request(o.merge(n||{},{method:e,url:t}))}}),o.forEach(["post","put","patch"],function(e){s.prototype[e]=function(t,n,r){return this.request(o.merge(r||{},{method:e,url:t,data:n}))}}),e.exports=s},27:function(e,t,n){"use strict";var r=n(0);e.exports=function(e,t){r.forEach(e,function(n,r){r!==t&&r.toUpperCase()===t.toUpperCase()&&(e[t]=n,delete e[r])})}},28:function(e,t,n){"use strict";var r=n(14);e.exports=function(e,t,n){var o=n.config.validateStatus;n.status&&o&&!o(n.status)?t(r("Request failed with status code "+n.status,n.config,null,n.request,n)):e(n)}},29:function(e,t,n){"use strict";e.exports=function(e,t,n,r,o){return e.config=t,n&&(e.code=n),e.request=r,e.response=o,e}},30:function(e,t,n){"use strict";var r=n(0);function o(e){return encodeURIComponent(e).replace(/%40/gi,"@").replace(/%3A/gi,":").replace(/%24/g,"$").replace(/%2C/gi,",").replace(/%20/g,"+").replace(/%5B/gi,"[").replace(/%5D/gi,"]")}e.exports=function(e,t,n){if(!t)return e;var a;if(n)a=n(t);else if(r.isURLSearchParams(t))a=t.toString();else{var i=[];r.forEach(t,function(e,t){null!=e&&(r.isArray(e)?t+="[]":e=[e],r.forEach(e,function(e){r.isDate(e)?e=e.toISOString():r.isObject(e)&&(e=JSON.stringify(e)),i.push(o(t)+"="+o(e))}))}),a=i.join("&")}return a&&(e+=(-1===e.indexOf("?")?"?":"&")+a),e}},303:function(e,t,n){e.exports=n(348)},31:function(e,t,n){"use strict";var r=n(0),o=["age","authorization","content-length","content-type","etag","expires","from","host","if-modified-since","if-unmodified-since","last-modified","location","max-forwards","proxy-authorization","referer","retry-after","user-agent"];e.exports=function(e){var t,n,a,i={};return e?(r.forEach(e.split("\n"),function(e){if(a=e.indexOf(":"),t=r.trim(e.substr(0,a)).toLowerCase(),n=r.trim(e.substr(a+1)),t){if(i[t]&&o.indexOf(t)>=0)return;i[t]="set-cookie"===t?(i[t]?i[t]:[]).concat([n]):i[t]?i[t]+", "+n:n}}),i):i}},32:function(e,t,n){"use strict";var r=n(0);e.exports=r.isStandardBrowserEnv()?function(){var e,t=/(msie|trident)/i.test(navigator.userAgent),n=document.createElement("a");function o(e){var r=e;return t&&(n.setAttribute("href",r),r=n.href),n.setAttribute("href",r),{href:n.href,protocol:n.protocol?n.protocol.replace(/:$/,""):"",host:n.host,search:n.search?n.search.replace(/^\?/,""):"",hash:n.hash?n.hash.replace(/^#/,""):"",hostname:n.hostname,port:n.port,pathname:"/"===n.pathname.charAt(0)?n.pathname:"/"+n.pathname}}return e=o(window.location.href),function(t){var n=r.isString(t)?o(t):t;return n.protocol===e.protocol&&n.host===e.host}}():function(){return!0}},33:function(e,t,n){"use strict";var r="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";function o(){this.message="String contains an invalid character"}o.prototype=new Error,o.prototype.code=5,o.prototype.name="InvalidCharacterError",e.exports=function(e){for(var t,n,a=String(e),i="",s=0,c=r;a.charAt(0|s)||(c="=",s%1);i+=c.charAt(63&t>>8-s%1*8)){if((n=a.charCodeAt(s+=.75))>255)throw new o;t=t<<8|n}return i}},34:function(e,t,n){"use strict";var r=n(0);e.exports=r.isStandardBrowserEnv()?{write:function(e,t,n,o,a,i){var s=[];s.push(e+"="+encodeURIComponent(t)),r.isNumber(n)&&s.push("expires="+new Date(n).toGMTString()),r.isString(o)&&s.push("path="+o),r.isString(a)&&s.push("domain="+a),!0===i&&s.push("secure"),document.cookie=s.join("; ")},read:function(e){var t=document.cookie.match(new RegExp("(^|;\\s*)("+e+")=([^;]*)"));return t?decodeURIComponent(t[3]):null},remove:function(e){this.write(e,"",Date.now()-864e5)}}:{write:function(){},read:function(){return null},remove:function(){}}},348:function(e,t,n){"use strict";n.r(t);var r=n(20),o=n(1);n(21);var a={data:{labreMenu:""},preLoad:function(){var e=document.querySelector(".bt-seguir");e&&(e.onclick=function(t){t.stopPropagation(),t.preventDefault(),e.classList.contains("enable")?a.seguir(t):a.desSeguir(t)})},seguir:function(e){e.preventDefault(),e.stopPropagation();var t=document.getElementById("token_reverso").value,n=document.querySelector(".bt-seguir"),r=new FormData;r.append("token_reverso",t),r.append("action","seguir"),axios.post("/preferencias/seguir_tag",r).then(function(e){e.data.sucess?(o.a.view("".concat(e.data.msg),"sucesso"),n.classList.remove("enable"),n.classList.add("seguindo"),n.innerHTML='Seguindo<span class="ico ico-seguindo"></span>'):o.a.view("Vixi! ".concat(e.data.msg),"error")})},desSeguir:function(e){e.preventDefault(),e.stopPropagation();var t=document.getElementById("token_reverso").value,n=document.querySelector(".bt-seguir"),r=new FormData;r.append("token_reverso",t),r.append("action","deseguir"),axios.post("/preferencias/seguir_tag",r).then(function(e){e.data.sucess?(o.a.view("".concat(e.data.msg),"sucesso"),n.classList.add("enable"),n.classList.remove("seguindo"),n.innerHTML="Seguir"):o.a.view("Vixi! ".concat(e.data.msg),"error")})}};r.a.preLoad(),a.preLoad()},35:function(e,t,n){"use strict";var r=n(0);function o(){this.handlers=[]}o.prototype.use=function(e,t){return this.handlers.push({fulfilled:e,rejected:t}),this.handlers.length-1},o.prototype.eject=function(e){this.handlers[e]&&(this.handlers[e]=null)},o.prototype.forEach=function(e){r.forEach(this.handlers,function(t){null!==t&&e(t)})},e.exports=o},36:function(e,t,n){"use strict";var r=n(0),o=n(37),a=n(15),i=n(7),s=n(38),c=n(39);function u(e){e.cancelToken&&e.cancelToken.throwIfRequested()}e.exports=function(e){return u(e),e.baseURL&&!s(e.url)&&(e.url=c(e.baseURL,e.url)),e.headers=e.headers||{},e.data=o(e.data,e.headers,e.transformRequest),e.headers=r.merge(e.headers.common||{},e.headers[e.method]||{},e.headers||{}),r.forEach(["delete","get","head","post","put","patch","common"],function(t){delete e.headers[t]}),(e.adapter||i.adapter)(e).then(function(t){return u(e),t.data=o(t.data,t.headers,e.transformResponse),t},function(t){return a(t)||(u(e),t&&t.response&&(t.response.data=o(t.response.data,t.response.headers,e.transformResponse))),Promise.reject(t)})}},37:function(e,t,n){"use strict";var r=n(0);e.exports=function(e,t,n){return r.forEach(n,function(n){e=n(e,t)}),e}},38:function(e,t,n){"use strict";e.exports=function(e){return/^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(e)}},39:function(e,t,n){"use strict";e.exports=function(e,t){return t?e.replace(/\/+$/,"")+"/"+t.replace(/^\/+/,""):e}},40:function(e,t,n){"use strict";var r=n(16);function o(e){if("function"!=typeof e)throw new TypeError("executor must be a function.");var t;this.promise=new Promise(function(e){t=e});var n=this;e(function(e){n.reason||(n.reason=new r(e),t(n.reason))})}o.prototype.throwIfRequested=function(){if(this.reason)throw this.reason},o.source=function(){var e;return{token:new o(function(t){e=t}),cancel:e}},e.exports=o},41:function(e,t,n){"use strict";e.exports=function(e){return function(t){return e.apply(null,t)}}},7:function(e,t,n){"use strict";(function(t){var r=n(0),o=n(27),a={"Content-Type":"application/x-www-form-urlencoded"};function i(e,t){!r.isUndefined(e)&&r.isUndefined(e["Content-Type"])&&(e["Content-Type"]=t)}var s,c={adapter:("undefined"!=typeof XMLHttpRequest?s=n(13):void 0!==t&&(s=n(13)),s),transformRequest:[function(e,t){return o(t,"Content-Type"),r.isFormData(e)||r.isArrayBuffer(e)||r.isBuffer(e)||r.isStream(e)||r.isFile(e)||r.isBlob(e)?e:r.isArrayBufferView(e)?e.buffer:r.isURLSearchParams(e)?(i(t,"application/x-www-form-urlencoded;charset=utf-8"),e.toString()):r.isObject(e)?(i(t,"application/json;charset=utf-8"),JSON.stringify(e)):e}],transformResponse:[function(e){if("string"==typeof e)try{e=JSON.parse(e)}catch(e){}return e}],timeout:0,xsrfCookieName:"XSRF-TOKEN",xsrfHeaderName:"X-XSRF-TOKEN",maxContentLength:-1,validateStatus:function(e){return e>=200&&e<300}};c.headers={common:{Accept:"application/json, text/plain, */*"}},r.forEach(["delete","get","head"],function(e){c.headers[e]={}}),r.forEach(["post","put","patch"],function(e){c.headers[e]=r.merge(a)}),e.exports=c}).call(this,n(11))},8:function(e,t,n){"use strict";n.d(t,"a",function(){return r});var r={data:{executar:null},preLoad:function(){document.body.addEventListener("keydown",function(e){var t=(e=e||window.event).which||e.keyCode;e.ctrlKey&&e.ctrlKey;27==t&&r.closeAll()})},view:function(){arguments.length>0&&void 0!==arguments[0]&&arguments[0];var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"atencao";this.limpar();var t="\n            <div class='modal--wrapper ".concat(e,"'>\n                <a title='Fechar esta opção.' class='bt-fechar'></a>            \n            </div>"),n=document.createElement("div");n.id="modal",n.classList.add(e),n.innerHTML=t;var o=document.querySelector("#before");o&&o.appendChild(n),document.querySelector("#modal").addEventListener("click",r.closeAll)},closeAll:function(){r.remove(".modal","ativado"),r.remove(".abreMenuUsuario_desk","ativado"),r.remove(".menu-usuario-perfil_desk","ativado"),r.remove(".abreMenuUsuario_mobile","ativado"),r.remove(".menu-usuario-perfil_mobile","ativado"),r.remove(".tool-salvar__criar_pasta","ativado"),r.remove(".tool.tool-salvar","ativado"),r.remove(".modal_salvar","ativado"),r.limpar()},remove:function(e,t){var n=document.querySelector(e);n&&n.classList.remove(t),document.querySelectorAll(e).forEach(function(e){e.classList.remove(t)})},limpar:function(){var e=document.querySelector("#modal");e&&e.parentElement.removeChild(e)}}}});