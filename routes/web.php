<?php

use Illuminate\Support\Facades\Route;

use function Symfony\Component\String\b;

Route::get("/", [\App\Http\Controllers\ShowFrontHome::class, "home"])->name('home');
Route::controller(\App\Http\Controllers\ShowFrontArchive::class)->group(function () {
    Route::get('tag/{tag}', 'tag')->name('tag.index');
    /* Route::get('tag/amp/{tag}', 'tag')->name('tag_amp.index'); */
    Route::get('sessao/{sessao}', 'categoria')->name('categoria.index');
    /* Route::get('sessao/amp/{sessao}', 'categoria')->name('categoria_amp.index'); */
});
Route::controller(\App\Http\Controllers\ShowFrontPage::class)->group(function () {
    Route::get('page/{page}', 'page')->name('page.index');
    Route::get('pages/{page}', 'page')->name('page.index');
    /* Route::get('page/amp/{page}', 'page')->name('page_amp.index'); */
    /* Route::get('pages/amp/{page}', 'page')->name('page_amp.index'); */
    Route::post('conato/validate', 'contatoValidate')->name('contato.validate');
});
Route::controller(\App\Http\Controllers\AuthFrontLogin::class)->group(function () {
    Route::get('/login', 'fazerLogin')->name('login');
    Route::post('/login', 'auth')->name('login');
    Route::get('/refazer', 'refazerLogin')->name('login.login_refazer');
    Route::get('/login/resetar_senha', 'resetarSenhaForm')->name('login.resetar_senha');
    Route::post('/login/resetar_senha', 'resetarSenhaEnviaLink')->name('login.resetar_senha_envia_link');
    Route::get('/login/resetar_senha_update/{email}/token/{token}', 'resetarSenhaUpdate')->name('login.resetar_senha_update');
    Route::put('/login/resetar_senha_update_confirm', 'resetarSenhaUpdateConfirm')->name('login.resetar_senha_update_confirm');
    Route::get('logout', 'logout')->name('logout');
});
Route::controller(\App\Http\Controllers\AuthFrontRegistrar::class)->group(function () {
    Route::get('/registrar/{back}', 'registrar')->name('registrar');
    Route::get('/envia_email_cadastro', 'enviaEmailCadastro')->name('envia.email.cadastro');
    Route::get('/confirma_email_enviado_cadastro', 'confirmaEmailEnviadoCadastro')->name('confirma.email.enviado.cadastro');
    Route::get('/falta_confirmar_email', 'faltaConfirmarEmail')->name('falta.confirmar.email');
    Route::get('/confirma_email/{id}', 'confirmaEmail')->name('confirma.email');
});
Route::resource('usuario', \App\Http\Controllers\ModelBackUsuario::class)->middleware('auth', 'verifica.email');
Route::controller(\App\Http\Controllers\ModelBackUsuario::class)->group(function () {
    Route::get('minhas-frases', 'minhasFrases')->name('usuario.minhasFrases')->middleware('auth', 'verifica.email');
    Route::get('/feed', 'feed')->name('usuario.feed')->middleware('auth', 'verifica.email');
    Route::post('/usuario/criar', 'criar')->name('usuario.criar');
    Route::post('preferencias/salvar', 'salvarPreferencias')->name('usuario.salvarPreferencias')->middleware('auth');
    Route::get('/preferencias', 'preferencias')->name('usuario.preferencias')->middleware('auth', 'verifica.email');
    Route::post('preferencias/seguir_perfil', 'seguirPerfil')->name('usuario.seguirPerfil')->middleware('auth');
    // ● 24-1go-222 LM: Projeto20220804 - Recriar pastas pendentes devido a erro da falta do arquivo avatar.svg
    Route::post('usuario/recriar_pasta', 'recriarPasta')->name('usuario.recriarPasta')->middleware('auth', 'security.isAdm');
    Route::post('preferencias/seguir_tag', 'seguirTag')->name('usuario.seguirTag')->middleware('auth');
    Route::post('notific/marcarcomolido', 'marcarComoLido')->name('usuario.marcarComoLido')->middleware('auth');
    Route::put('/usuario/suspender/{id}', 'suspender')->name('usuario.suspender')->middleware('auth', 'security.isAdm');
    Route::put('/usuario/reativar/{id}', 'reativar')->name('usuario.reativar')->middleware('auth', 'security.isAdm');
    Route::put('/usuario/deletar/{id}', 'deletar')->name('usuario.deletar')->middleware('auth', 'security.isAdm');
    Route::put('/usuario/excluir-perfil/{id}', 'excluirPerfil')->name('usuario.excluirPerfil')->middleware('auth');
    Route::put('/usuario/retirarLixeira/{id}', 'retirarLixeira')->name('usuario.retirarLixeira')->middleware('auth', 'security.isAdm');
    Route::delete('/usuario/delete/{token}', 'delete')->name('usuario.delete')->middleware('auth', 'security.isAdm');
    Route::get('perfil/{perfil}', "perfil")->name('perfil');
});
Route::resource('comments', \App\Http\Controllers\ModelBackComment::class);
Route::resource('curtida', \App\Http\Controllers\ModelBackCurtida::class);
Route::delete('curtidas/deletar/{id}', [\App\Http\Controllers\ModelBackCurtida::class, "deletar"])->name('curtida-deletar')->middleware('auth');
Route::controller(\App\Http\Controllers\ShowBackPainel::class)->group(function () {
    Route::get('/admin/painel', 'painel')->name('back.Painel')->middleware('auth', 'security.isAdm');
    Route::get('/admin/sitemap', 'sitemap')->name('admin.sitemap')->middleware('auth', 'security.isAdm');
    Route::put('/admin/sitemap', 'sitemapGerar')->name('admin.sitemap')->middleware('auth', 'security.isAdm');
    Route::put('/admin/sitemapfrases', 'sitemapFrasesGerar')->name('admin.sitemapfrases')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/frase/pesquisa/', 'frases_pesquisa')->name('frases_pesquisa')->middleware('auth', 'security.isAdm');
    Route::get('/admin/parametros', 'parametros')->name('admin.parametros')->middleware('auth', 'security.isAdm');
    Route::put('/admin/parametros_update/{id}', 'update')->name('admin.parametros_update')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/frases/{filtro}', 'gestao_frases')->name('admin.gestao_frases')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/frases/edit/{id}', 'gestao_frases_edit')->name('admin.gestao_frases_edit')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/posts/{filtro}', 'gestao_posts')->name('admin.gestao_posts')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/posts/edit/{id}', 'gestao_posts_edit')->name('admin.gestao_posts_edit')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/post/inserir/', 'posts_inserir')->name('post.inserir')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/post/pesquisa/', 'posts_pesquisa')->name('posts_pesquisa')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/categoria/{filtro}', 'gestao_categoria')->name('admin.gestao_categoria')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/categoria/edit/{id}', 'gestao_posts_edit')->name('admin.categoria_edit')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/categorias/inserir/', 'categoria_inserir')->name('categoria.inserir')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/categorias/pesquisa/', 'categoria_pesquisa')->name('categoria.pesquisa')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/aprovacao/{filtro}', 'gestao_aprovacao')->name('admin.gestao_aprovacao')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/aprovacao/pesquisa/', 'aprovacao_pesquisa')->name('aprovacao_pesquisa')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/banner/{filtro}', 'gestao_banner')->name('admin.gestao_banner')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/tag/{filtro}', 'gestao_tag')->name('admin.gestao_tag')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/tag/edit/{id}', 'gestao_posts_edit')->name('admin.tag_edit')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/tags/inserir/', 'tag_inserir')->name('tags.inserir')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/tags/pesquisa/', 'tag_pesquisa')->name('tags.pesquisa')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/conquistas/{filtro}', 'gestao_conquistas')->name('admin.gestao_conquitas')->middleware('auth', 'security.isAdm', 'security.isAdm');
    Route::get('admin/gestao/usuarios/{filtro}', 'gestao_usuarios')->name('admin.gestao_usuarios')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/usuarios/edit/{id}', 'gestao_usuarios_edit')->name('admin.gestao_usuarios_edit')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/usuario/inserir/', 'usuarios_inserir')->name('usuario.inserir')->middleware('auth', 'testa.situacao.usuario', 'security.isAdm');
    Route::get('admin/gestao/usuario/pesquisa/', 'usuarios_pesquisa')->name('usuarios_pesquisa')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/lista/pesquisa/', 'listas_pesquisa')->name('listas_pesquisa')->middleware('auth', 'security.isAdm');
    Route::post('admin/gestao/midias/upload/', 'upload')->name('midias.upload')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/midias/{filtro}', 'gestao_midias')->name('admin.gestao_midias')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/midias/edit/{id}', 'midias_editar')->name('admin.gestao_midias_edit')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/midia/pesquisa/', 'midias_pesquisa')->name('midias_pesquisa')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/midia/inserir/', 'midia_inserir')->name('midia.inserir')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/comments/{filtro}', 'gestao_comments')->name('admin.gestao_comments')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/comments/edit/{id}', 'comments_editar')->name('admin.gestao_comments_edit')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/comments/edit_frases/{id}', 'comments_frases_editar')->name('admin.comments_frases_editar')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/comment/pesquisa/', 'comments_pesquisa')->name('comments_pesquisa')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/comments-frases/{filtro}', 'gestao_comments_frases')->name('admin.gestao_comments_frases')->middleware('auth', 'security.isAdm');
});
Route::resource('pastas', \App\Http\Controllers\ModelBackPastaUsuario::class)->middleware('auth', 'security.isAdm');
Route::controller(\App\Http\Controllers\ModelBackPastaUsuario::class)->group(function () {
    Route::get('minhas-frases-delete', 'minhasFrases')->name('pastas.minhasFrases')->middleware('auth', 'verifica.email');
    Route::delete('pastas/deletar/{id}', 'deletar')->middleware('auth');
    Route::post('pastas/tornarPublica', 'tornarPublica')->name('pastas.tornarPublica')->middleware('auth');
});
Route::resource('pastausuarioitem', \App\Http\Controllers\ModelBackPastaUsuarioItem::class)->middleware('auth');
Route::controller(\App\Http\Controllers\ShowFrontPost::class)->group(function () {
    Route::get('/compartilhar', 'compartilhar')->name('compartilhar');
    Route::get('/{urlamigavel}', 'show')->name('web_single_post')->middleware('HtmlCompressor');
    /* Route::get('/amp/{urlamigavel}', 'show')->name('postsAmp')->middleware('HtmlCompressor'); */
});

Route::resource('frases', \App\Http\Controllers\ModelBackFrase::class)->middleware('auth', 'security.isAdm');
Route::controller(\App\Http\Controllers\ModelBackFrase::class)->group(function () {
    Route::get('admin/gestao/frase/inserir/', 'frasesInserir')->name('frase.inserir')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/frase/iniciarpipif/', 'iniciarPipif')->name('frase.iniciarPipif')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/frase/regerarauxiliarespipif/', 'regerarAuxiliaresPipif')->name('frase.regerarAuxiliaresPipif')->middleware('auth', 'security.isAdm');
    Route::post('api/pipiefricardo', 'ricardo')->name('frases.ricardo')->middleware('auth', 'security.isAdm');
    Route::post('admin/gestao/frase/pipif', 'postPipif')->name('post.pipif')->middleware('auth', 'security.isAdm');
    Route::post('admin/gestao/frase/download', 'postPipifgeraIMagemParaDownloadFromCopy')->name('post.postPipifgeraIMagemParaDownloadFromCopy')->middleware('auth', 'security.isAdm');
    Route::post('admin/gestao/frase/novopadrao', 'postPipifNovoPadraoImagens')->name('post.postPipifNovoPadraoImagens')->middleware('auth', 'security.isAdm');
    // Route::post('preferencias/seguir_tag', 'seguirTag')->name('usuario.seguirTag')->middleware('auth');
    Route::get('admin/gestao/frase/runpipif/', 'runPipif')->name('frase.runPipif')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/frase/zerarpipif/', 'zerarPipif')->name('frase.zerarPipif')->middleware('auth', 'security.isAdm');
    Route::post('/frase_up/save/', 'save')->name('frases.save')->middleware('auth', 'security.isAdm');
    Route::put('/frase/{id}', 'update')->name('frases.update')->middleware('auth', 'security.isAdm');
    Route::post('/frase', 'store')->name('frases.store')->middleware('auth', 'security.isAdm');
    Route::put('/frase/lixeira/{id}', 'lixeira')->name('frase.lixeira')->middleware('auth', 'security.isAdm');
    Route::put('/frase/retirarLixeira/{id}', 'retirarLixeira')->name('frase.retirarLixeira')->middleware('auth', 'security.isAdm');
    Route::get('/frases/edit/{id}/', 'edit')->name('frase.edit')->middleware('auth', 'security.isAdm');
    Route::post('/frase/imagecreate/', 'imageCreate')->name('frase.imagecreate')->middleware('auth', 'security.isAdm');
    Route::get('api/frases/listar_json/{query}', 'listarJson')->name('frases.listarJson');
});
Route::put('/admin/parametros_update/{id}', [\App\Http\Controllers\ModelBackParametroGlobal::class, 'update'])->name('admin.parametros_update')->middleware('auth', 'security.isAdm');
Route::resource('lista', \App\Http\Controllers\ModelBackLista::class)->middleware('auth', 'security.isAdm');
//
//Rotas do painel do usuário, referenet a gestão de listas
Route::get('admin/gestao/listas/{filtro}', [\App\Http\Controllers\ModelBackLista::class, 'gestaoListasAdmin'])->name('listas.gestaoListasAdmin')->middleware('auth', 'security.isAdm');
Route::get('/listas/inserir/', [\App\Http\Controllers\ModelBackLista::class, 'inserir'])->name('lista.inserir')->middleware('auth', 'security.isAdm');
Route::post('/listas/criar/', [\App\Http\Controllers\ModelBackLista::class, 'criar'])->name('lista.criar')->middleware('auth', 'security.isAdm');
Route::get('/listas/edit/{id}/', [\App\Http\Controllers\ModelBackLista::class, 'edit'])->name('lista.edit')->middleware('auth', 'security.isAdm');
Route::post('lista/storerevisao/', [\App\Http\Controllers\ModelBackLista::class, 'storerevisao'])->name('lista.store_revisao')->middleware('auth', 'testa.situacao.usuario');
Route::put('lista/revisao/{id}', [\App\Http\Controllers\ModelBackLista::class, 'revisao'])->name('lista.revisao')->middleware('auth');
Route::get('listas/pesquisa/', [\App\Http\Controllers\ModelBackLista::class, 'listaPesquisa'])->name('lista_pesquisa')->middleware('auth', 'security.isAdm');
Route::put('lista/lixeira/{id}', [\App\Http\Controllers\ModelBackLista::class, 'lixeira'])->name('lista.lixeira')->middleware('auth', 'security.isAdm');
Route::post('/lista/save/', [\App\Http\Controllers\ModelBackLista::class, 'save'])->name('lista.save')->middleware('auth', 'security.isAdm');


Route::get('/autor/{url}', [\App\Http\Controllers\ModelBackAutor::class, "showAutor"])->name('autor.show')->middleware('HtmlCompressor');
/* Route::get('/amp/autor/{url}', [\App\Http\Controllers\ModelBackAutor::class, "showAutor"])->name('autor.showamp')->middleware('HtmlCompressor'); */
Route::controller(\App\Http\Controllers\ModelBackAutor::class)->group(function () {
    Route::get('admin/gestao/autor/inserir/', 'autorInserir')->name('autor.inserir')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/autor/{filtro}', 'gestaoAutor')->name('admin.gestao_autor')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/autor/pesquisa/', 'autorPesquisa')->name('autor.pesquisa')->middleware('auth', 'security.isAdm');
    Route::post('admin/gestao/autor/criando_autor/', 'criandoAutor')->name('autor.criando_autor')->middleware('auth', 'security.isAdm');
});
Route::resource('autor', \App\Http\Controllers\ModelBackAutor::class);

Route::resource('post', \App\Http\Controllers\ModelBackPost::class)->middleware('auth', 'security.isAdm');
Route::controller(\App\Http\Controllers\ModelBackPost::class)->group(function () {
    Route::post('/post/criar', 'criar')->name('post.criar')->middleware('auth', 'security.isAdm');
    Route::put('/post/lixeira/{id}', 'lixeira')->name('post.lixeira')->middleware('auth', 'security.isAdm');
    Route::put('/post/retirarLixeira/{id}', 'retirarLixeira')->name('post.retirarLixeira')->middleware('auth', 'security.isAdm');
    Route::put('/post/piedpiper/{id}', 'piedpiper')->name('post.piedpiper')->middleware('auth', 'security.isAdm');
    Route::get('/posts/edit/{id}/', 'edit')->name('post.edit')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/post/bkpitens/{id}', 'bkpPostItens')->name('posts_bkp_itens')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/post/recuperaritens/{id}', 'recuperarPostItens')->name('posts_recuperar_itens')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/post/iniciaritens/{id}', 'iniciarPostItens')->name('posts_iniciar_itens')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/post/reiniciaritens/{id}', 'reiniciarPostItens')->name('posts_reiniciar_itens')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/post/regerarimgfrases/{id}', 'regerarImgfrases')->name('posts_regerar_imgfrases')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/post/checkpostwepb/{id}', 'checkPostWepb')->name('posts.checkview')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/post/cortarthumb/{id}', 'cortarThumb')->name('posts_cortarthumb')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/post/inserir/', 'posts_inserir')->name('post.inserir')->middleware('auth', 'security.isAdm');
    // Route::get('admin/gestao/post/pesquisa/' , 'posts_pesquisa')->name('posts_pesquisa')->middleware('auth','security.isAdm');
    Route::get('api/posts/listar_json/{query}', 'listarJson')->name('posts.listarJson');
});
Route::controller(\App\Http\Controllers\ShowBackMarlom::class)->group(function () {
    Route::get('/admin/marlon', 'marlon')->name('marlon')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/titulo/{id}/', 'titulos')->name('marlon.titulo')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/token/{id}/{depara}/', 'token')->name('marlon.token')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/duplicadas/{id}/', 'duplicadas')->name('marlon.duplicadas')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/duplicadasemuso/{id}/', 'duplicadasEmUso')->name('marlon.duplicadasemuso')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/deletarduplicadas/{id}/', 'deletarDuplicadas')->name('marlon.deletarduplicadas')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/limparlixeira/{id}/', 'limparlixeira')->name('marlon.limparlixeira')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/reverduplicadas/{id}/', 'reverDuplicadas')->name('marlon.reverduplicadas')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/pequenas/{id}/', 'pequenas')->name('marlon.pequenas')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/preanalise/{id}/', 'preAnalise')->name('marlon.preanalise')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/preanalisepost/{id}/', 'preAnalisePost')->name('marlon.preanalisepost')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/duplicadasnopost/{id}/', 'duplicadasNoPost')->name('marlon.duplicadasnopost')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/gerarimagens/{id}/', 'gerarImagens')->name('marlon.gerarimagens')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/caracteresruins/{id}/', 'caracteresRuins')->name('marlon.caracteresruins')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/getpalavroes/{id}/', 'getPalavroes')->name('marlon.getpalavroes')->middleware('auth', 'security.isAdm');
    Route::post('/admin/marlon/ajustarFrase', 'ajustarFraseDuplicada')->name('marlon.ajustarFraseDuplicada')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/martaImporta/{id}/', 'martaImporta')->name('marlon.martaimporta')->middleware('auth'); //posts
    Route::get('/admin/marlon/criartagfrases/{id}/', 'criartagfrases')->name('marlon.criartagfrases')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/ajustaralt/{id}/', 'ajustaralt')->name('marlon.ajustaralt')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/verificawebppendente/{id}/', 'verificaWebpPendente')->name('marlon.verificaWebpPendente')->middleware('auth', 'security.isAdm');
    Route::get('/admin/marlon/transformaemwebp/{id}/', 'transformaEmWebp')->name('marlon.transformaEmWebp')->middleware('auth', 'security.isAdm');
});
Route::resource('aprovacao', \App\Http\Controllers\ModelBackAprovacao::class)->middleware('auth', 'security.isAdm');
Route::controller(\App\Http\Controllers\ModelBackAprovacao::class)->group(function () {
    Route::post('admin/gestao/aprova/aprovar/', 'aprovar')->name('aprovacao.aprovar')->middleware('auth', 'security.isAdm');
    Route::post('admin/gestao/aprova/rejeitar/', 'rejeitar')->name('aprovacao.rejeitar')->middleware('auth', 'security.isAdm');
});
Route::resource('categoria', \App\Http\Controllers\ModelBackCategoria::class)->middleware('auth', 'security.isAdm');
Route::resource('tags', \App\Http\Controllers\ModelBackTag::class)->middleware('auth', 'security.isAdm');
Route::resource('conquista', \App\Http\Controllers\ModelBackConquista::class)->middleware('auth', 'security.isAdm');
Route::get('admin/gestao/conquista/inserir/', [\App\Http\Controllers\ModelBackConquista::class, 'inserir'])->name('conquista.inserir')->middleware('auth', 'security.isAdm');
Route::resource('midia', \App\Http\Controllers\ModelBackMidia::class)->middleware('auth', 'security.isAdm');
Route::controller(\App\Http\Controllers\ModelBackMidia::class)->group(function () {
    Route::post('admin/gestao/midias/upload/', 'upload')->name('midias.upload')->middleware('auth', 'security.isAdm');
    Route::get('admin/gestao/midias/download/{userId}/{fileId}', 'download')->name('midias.download')->middleware('auth', 'security.isAdm');
    Route::delete('admin/gestao/midias/remover/{userId}/{fileId}', 'remover')->name('midias.remover')->middleware('auth', 'security.isAdm');
    Route::get('api/midias/avatar/{query}', 'listarAvatar')->name('midia.avatar');
});
Route::controller(\App\Http\Controllers\ShowFrontPainel::class)->group(function () {
    Route::get('/usuario/alterar_senha/{id}', 'alterarSenha')->name('usuario.alterar_senha')->middleware('auth');
    Route::put('/usuario/alterar_senha_update/{id}', 'alterarSenhaUpdate')->name('usuario.alterar_senha_update')->middleware('auth');
});

Route::get('/frase/{id}', [\App\Http\Controllers\ShowFrontFrase::class, "show"])->name('frases')->middleware('HtmlCompressor');
/* Route::get('/amp/frase/{id}', [\App\Http\Controllers\ShowFrontFrase::class, "show"])->name('frasesA')->middleware('HtmlCompressor'); */
Route::get('/pesquisa/{termo}/', [\App\Http\Controllers\ShowFrontPesquisa::class, "pesquisa"])->name('pesquisa');
