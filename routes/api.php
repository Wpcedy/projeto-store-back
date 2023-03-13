<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PedidoController;
use App\Http\Requests\ClienteRequest;
use App\Http\Requests\ProdutoRequest;
use App\Http\Requests\PedidoRequest;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Cliente
Route::post('/cliente/new', function(ClienteRequest $request) {
  $controller = new ClienteController();
  return $controller->new($request);
});
Route::post('/cliente/{id}/editar', function(ClienteRequest $request) {
  $controller = new ClienteController();
  return $controller->update($request);
});
Route::post('/cliente/{id}/remover', function(Request $request) {
  $controller = new ClienteController();
  return $controller->remover($request);
});
// //Produto
Route::post('/produto/new', function(ProdutoRequest $request) {
  $controller = new ProdutoController();
  return $controller->new($request);
});
Route::post('/produto/{id}/editar', function(ProdutoRequest $request) {
  $controller = new ProdutoController();
  return $controller->update($request);
});
Route::post('/produto/{id}/remover', function(Request $request) {
  $controller = new ProdutoController();
  return $controller->remover($request);
});
// //Pedido
Route::post('/pedido/new', function(PedidoRequest $request) {
  $controller = new PedidoController();
  return $controller->new($request);
});
Route::post('/pedido/{id}/aprovar', function(Request $request) {
  $controller = new PedidoController();
  return $controller->aprovar($request);
});
Route::post('/pedido/{id}/cancelar', function(Request $request) {
  $controller = new PedidoController();
  return $controller->cancelar($request);
});
Route::post('/pedido/{id}/remover', function(Request $request) {
  $controller = new PedidoController();
  return $controller->remover($request);
});
