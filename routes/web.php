<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/ping', 'PingController@index')->name('ping');
//Cliente
Route::get('/cliente/lista', 'ClienteController@index')->name('lista.clientes');
Route::get('/cliente/{id}', 'ClienteController@get')->name('get.cliente');
Route::post('/cliente/new', 'ClienteController@new')->name('adicionar.cliente');
Route::post('/cliente/{id}/editar', 'ClienteController@update')->name('atualiza.cliente');
//Produto
Route::get('/produto/lista', 'ProdutoController@index')->name('lista.produtos');
Route::get('/produto/{id}', 'ProdutoController@get')->name('get.produto');
Route::post('/produto/new', 'ProdutoController@new')->name('adicionar.produto');
Route::post('/produto/{id}/editar', 'ProdutoController@update')->name('atualiza.produto');
//Pedido
Route::get('/pedido/lista', 'PedidoController@index')->name('lista.pedidos');
Route::get('/pedido/{id}', 'PedidoController@get')->name('get.pedido');
Route::post('/pedido/new', 'PedidoController@new')->name('adicionar.pedido');
Route::post('/pedido/{id}/aprovar', 'PedidoController@aprovar')->name('aprovar.pedido');
Route::post('/pedido/{id}/cancelar', 'PedidoController@cancelar')->name('cancelar.pedido');