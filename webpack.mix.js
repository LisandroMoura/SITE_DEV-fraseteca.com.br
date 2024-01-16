const mix = require('laravel-mix');
const { env } = require('minimist')(process.argv.slice(2));

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 | 
 | Não esquecer de rodar:  npm run dev
 */

if (env) {
   require(`${__dirname}/webpack.mix.${env}.js`);
}



// mix
   
//    .js('resources/js/admin_painel.js',                      'public/js')
//    .js('resources/js/default.js',                           'public/js')   
//    .js('resources/js/gestao_posts_form.js',                 'public/js')
//    .js('resources/js/gestao_banner_form.js',                'public/js')
//    .js('resources/js/gestao_midia_form.js',                 'public/js')
//    .js('resources/js/upload.js',                            'public/js')
//    .js('resources/js/avatar.js',                            'public/js')
//    .js('resources/js/emoji.js',                             'public/js')
//    .js('resources/js/usuario_gestao_listas_form',           'public/js')   
//    .js('resources/js/padrao_admin_editar_midias',           'public/js')
//    .js('resources/js/padrao_admin_editar_cadsimples',       'public/js')
//    .js('resources/js/layout',                               'public/js')
//    .js('resources/js/login',                                'public/js')
//    .js('resources/js/login_reset_senha',                    'public/js')
//    .js('resources/js/usuario_alterar_senha',                'public/js')
//    .js('resources/js/back_end_usuario',                     'public/js')
//     .js('resources/js/back_end_usuario_minhas_listas',      'public/js')
//    .js('resources/js/back_end_usuario_editar_perfil',       'public/js')
//     .js('resources/js/back_end_usuario_minhas_listas_form', 'public/js')
//    .js('resources/js/back_end_favoritas.js',                'public/js')   

//    //webFront
//    .js('resources/js/web_single_post_front',                'public/js')   
//    .js('resources/js/single_frases_form',                   'public/js')
//    .js('resources/js/web_generic_front',                    'public/js')
//    .js('resources/js/web_single_frase_front',               'public/js')   
   
   

//    .js('resources/js/perfil',                               'public/js') 
//    .js('resources/js/single',                               'public/js')

//    //.sass('resources/sass/single.scss',                      'public/css')   
//    .sass('resources/sass/web_single_post_front.scss',       'public/css')
//    .sass('resources/sass/web_home_front.scss',              'public/css')
//    .sass('resources/sass/web_archive_front.scss',           'public/css')   
//    .sass('resources/sass/web_single_frase_front.scss',      'public/css')
//    .sass('resources/sass/app_amp.scss',                     'public/css')   
//    .sass('resources/sass/back_end_usuario.scss',            'public/css')   
//    .sass('resources/sass/login.scss',                       'public/css')
   
   
   
   
