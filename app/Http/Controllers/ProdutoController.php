<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Models\produto as ProdutoModel;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
  public function index(Request $request)
  {
    $dataForm = $request->all();

    $where = $this->filters($dataForm);

    if (isset($dataForm['ordercampo']) && isset($dataForm['ordertipo'])) {
      $produtos = ProdutoModel::where($where)->orderBy($dataForm['ordercampo'], $dataForm['ordertipo'])->get();
    } else {
      $produtos = ProdutoModel::where($where)->get();
    }

    return response()->json($produtos, 200);
  }

  public function get(Request $request)
  {
    $id = $request->route('id');

    $produto = ProdutoModel::where([
      'id' => $id,
    ])->get();

    return response()->json($produto, 200);
  }

  public function new(ProdutoRequest $request)
  {
    $dataForm = $request->all();

    $data = $this->createProduto($dataForm);

    return response()->json($data, 200);
  }

  public function update(ProdutoRequest $request)
  {
    $id = $request->route('id');
    $dataForm = $request->all();

    ProdutoModel::where([
      'id' => $id
    ])->update([
      'nome' => $dataForm['nome'],
      'descricao' => $dataForm['descricao'],
      'valor' => $dataForm['valor'],
    ]);

    return response()->json(['Cliente atualizado com sucesso'], 200);
  }

  public function remover(Request $request)
  {
    $id = $request->route('id');

    ProdutoModel::where([
      'id' => $id
    ])->delete();

    return response()->json(['Pedido Aprovado com sucesso'], 204);
  }

  protected function createProduto(array $data)
  {
    return ProdutoModel::create([
      'nome' => $data['nome'],
      'descricao' => $data['descricao'],
      'valor' => $data['valor'],
    ]);
  }

  protected function filters(array $dataForm)
  {
    $where = [];

    if (isset($dataForm['nome'])) {
      $where['nome'] = $dataForm['nome'];
    }
    if (isset($dataForm['descricao'])) {
      $where['descricao'] = $dataForm['descricao'];
    }
    if (isset($dataForm['valor'])) {
      $where['valor'] = $dataForm['valor'];
    }

    return $where;
  }
}
