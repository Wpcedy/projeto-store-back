<?php

use App\Http\Controllers\ClienteController;
use App\Http\Requests\ClienteRequest;
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
// Route::post('/cliente/{id}/editar', 'ClienteController@update');
// //Produto
// Route::post('/produto/new', 'ProdutoController@new');
// Route::post('/produto/{id}/editar', 'ProdutoController@update');
// //Pedido
// Route::post('/pedido/new', 'PedidoController@new');
// Route::post('/pedido/{id}/aprovar', 'PedidoController@aprovar');
// Route::post('/pedido/{id}/cancelar', 'PedidoController@cancelar');
