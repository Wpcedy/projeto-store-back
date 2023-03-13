<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidoRequest;
use App\Models\pedido as PedidoModel;
use App\Models\produto as ProdutoModel;
use App\Models\cliente as ClienteModel;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
  public function index(Request $request)
  {
    $dataForm = $request->all();

    $where = $this->filters($dataForm);

    if (isset($dataForm['ordercampo']) && isset($dataForm['ordertipo'])) {
      $pedidos = PedidoModel::where($where)->orderBy($dataForm['ordercampo'], $dataForm['ordertipo'])->get();
    } else {
      $pedidos = PedidoModel::where($where)->get();
    }

    foreach ($pedidos as $key => $value) {
      $cliente = ClienteModel::where([
        'id' => $value['cliente'],
      ])->get();
      $value['clienteNome'] = $cliente[0]['nome'];

      $date = new \DateTime($value['datapedido']);
      $value['datapedido'] = date_format($date,"d/m/Y");

      switch (strtoupper($value['status'])) {
        case PedidoModel::STATUS_ABERTO:
          $value['status'] = 'ABERTO';
          break;
        case PedidoModel::STATUS_APROVADO:
          $value['status'] = 'APROVADO';
          break;
        case PedidoModel::STATUS_CANCELADO:
          $value['status'] = 'CANCELADO';
          break;
      }
    }

    return response()->json($pedidos, 200);
  }

  public function get(Request $request)
  {
    $id = $request->route('id');

    $pedido = PedidoModel::where([
      'id' => $id,
    ])->get();

    $cliente = ClienteModel::where([
      'id' => $pedido[0]['cliente'],
    ])->get();
    $pedido[0]['clienteNome'] = $cliente[0]['nome'];

    $date = new \DateTime($pedido[0]['datapedido']);
    $pedido[0]['datapedido'] = date_format($date,"d/m/Y");
    $pedido[0]['produtos'] = json_decode($pedido[0]['produtos']);

    switch (strtoupper($pedido[0]['status'])) {
      case PedidoModel::STATUS_ABERTO:
        $pedido[0]['status'] = 'ABERTO';
        break;
      case PedidoModel::STATUS_APROVADO:
        $pedido[0]['status'] = 'APROVADO';
        break;
      case PedidoModel::STATUS_CANCELADO:
        $pedido[0]['status'] = 'CANCELADO';
        break;
    }

    return response()->json($pedido, 200);
  }

  public function new(PedidoRequest $request)
  {
    $dataForm = $request->all();
    $produtosSelecionados = $dataForm['produtos'];
    $ids = array_column($dataForm['produtos'], 'value');

    $produtos = ProdutoModel::whereIn('id', $ids)->get();

    $valor = 0;

    foreach ($produtos as $key => $produto) {
      if ($produto['nome'] == $produtosSelecionados[$key]['label']) {
        $valor += $produto['valor'];
        $produtosSelecionados[$key]['price'] = $produto['valor'];
      }
    }

    $data = $this->createProduto($dataForm['cliente'], $valor, json_encode($produtosSelecionados));

    return response()->json($data, 200);
  }

  public function aprovar(Request $request)
  {
    $id = $request->route('id');

    PedidoModel::where([
      'id' => $id
    ])->update([
      'status' => PedidoModel::STATUS_APROVADO,
    ]);

    return response()->json(['Pedido Aprovado com sucesso'], 200);
  }

  public function cancelar(Request $request)
  {
    $id = $request->route('id');

    PedidoModel::where([
      'id' => $id
    ])->update([
      'status' => PedidoModel::STATUS_CANCELADO,
    ]);

    return response()->json(['Pedido Cancelado com sucesso'], 200);
  }

  public function remover(Request $request)
  {
    $id = $request->route('id');

    PedidoModel::where([
      'id' => $id
    ])->delete();

    return response()->json(['Pedido Aprovado com sucesso'], 204);
  }

  protected function createProduto($clienteId, $valor, $produtos)
  {
    return PedidoModel::create([
      'produtos' => $produtos,
      'status' => PedidoModel::STATUS_ABERTO,
      'valorpedido' => $valor,
      'datapedido' => new \DateTime(),
      'cliente' => $clienteId,
    ]);
  }

  protected function filters(array $dataForm)
  {
    $where = [];

    if (isset($dataForm['status'])) {
      switch (strtoupper($dataForm['status'])) {
        case 'ABERTO':
          $where['status'] = PedidoModel::STATUS_ABERTO;
          break;
        case 'APROVADO':
          $where['status'] = PedidoModel::STATUS_APROVADO;
          break;
        case 'CANCELADO':
          $where['status'] = PedidoModel::STATUS_CANCELADO;
          break;
      }
    }
    if (isset($dataForm['valorpedido'])) {
      $where['valorpedido'] = $dataForm['valorpedido'];
    }
    if (isset($dataForm['cliente'])) {
      $where['cliente'] = $dataForm['cliente'];
    }

    return $where;
  }
}
