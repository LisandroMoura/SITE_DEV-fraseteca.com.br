// use .vue()
const mix = require("laravel-mix")
mix
	.js("resources/js/criando_autores_vue","public/js").vue()
	.js("resources/js/lf20/web_single_post_front","public/lf20/js") 
	.sass("resources/sass/back_end_usuario.scss","public/css") 
	.sass("resources/sass/lf20/front/web_autor_front.scss", "public/lf20/css")