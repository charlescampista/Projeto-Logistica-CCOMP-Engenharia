<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@index')->name('index');
Route::get('/lancamentos', 'IndexController@lancamentos');
Route::post('/lancamentos/novo', 'IndexController@lancar');
Route::get('/configuracoes', 'IndexController@config');
Route::post('/configuracoes', 'IndexController@configPost');

Route::get('/notificacoes', 'IndexController@notificacoes');

Route::prefix('/notas')->group(function()
{
   Route::get('/', 'Notas\NotasController@index')->name('notasIndex');
   Route::post('/nova', 'Notas\NotasController@nova');
   Route::get('/buscar', 'Notas\NotasController@buscar');
   Route::get('/{nota}', 'Notas\NotasController@view');
});
Route::prefix('/veiculos')->group(function ()
{
   Route::get('/', 'Veiculos\VeiculosController@index')->name('veiculosIndex');
   ROute::get('/{veiculo}/', 'Veiculos\VeiculosController@view');
   Route::post('/novo', 'Veiculos\VeiculosController@novo');

   Route::post('/tipos/novo', 'Veiculos\VeiculosController@tipoNovo');
});
Route::prefix('/relatorios')->group(function ()
{
    Route::get('/tempos_medios/', 'RelatoriosController@temposMedios');
});