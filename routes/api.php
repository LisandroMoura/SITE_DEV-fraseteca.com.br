<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('lista/listar_json/{id}' ,[\App\Http\Controllers\ModelBackLista::class, 'listarJson'])->name('lista.listarJson');

Route::get('/lista/listar_midias/{query}',[\App\Http\Controllers\ModelBackLista::class,'listarMidias'])->name('lista.listarMidias');
Route::get('/pastas/pesquisar/{query}' , [\App\Http\Controllers\ModelBackPastaUsuarioItem::class,"pesquisar"])->name('pasta_itens.pesquisar');
Route::post('/martaimportar' , [\App\Http\Controllers\ShowBackMarlom::class,"martaImporta"])->name('importarremessas');
