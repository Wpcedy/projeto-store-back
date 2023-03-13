<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\cliente as ClienteModel;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
  public function index(Request $request)
  {
    $dataForm = $request->all();

    $where = $this->filters($dataForm);

    if (isset($dataForm['ordercampo']) && isset($dataForm['ordertipo'])) {
      $clientes = ClienteModel::where($where)->orderBy($dataForm['ordercampo'], $dataForm['ordertipo'])->get();
    } else {
      $clientes = ClienteModel::where($where)->get();
    }


    return response()->json($clientes, 200);
  }

  public function get(Request $request)
  {
    $id = $request->route('id');

    $cliente = ClienteModel::where([
      'id' => $id,
    ])->get();

    return response()->json($cliente, 200);
  }

  public function new(ClienteRequest $request)
  {
    $dataForm = $request->all();

    $data = $this->createCliente($dataForm);

    return response()->json($data, 200);
  }

  public function update(ClienteRequest $request)
  {
    $id = $request->route('id');
    $dataForm = $request->all();

    ClienteModel::where([
      'id' => $id
    ])->update([
      'nome' => $dataForm['nome'],
      'email' => $dataForm['email'],
      'telefone' => $dataForm['telefone'],
      'cpf' => $dataForm['cpf'],
      'endereco' => $dataForm['endereco'],
    ]);

    return response()->json(['Cliente atualizado com sucesso'], 200);
  }

  public function remover(Request $request)
  {
    $id = $request->route('id');

    ClienteModel::where([
      'id' => $id
    ])->delete();

    return response()->json(['Pedido Aprovado com sucesso'], 204);
  }

  protected function createCliente(array $data)
  {
    return ClienteModel::create([
      'nome' => $data['nome'],
      'email' => $data['email'],
      'telefone' => $data['telefone'],
      'cpf' => $data['cpf'],
      'endereco' => $data['endereco'],
    ]);
  }

  protected function filters(array $dataForm)
  {
    $where = [];

    if (isset($dataForm['nome'])) {
      $where['nome'] = $dataForm['nome'];
    }
    if (isset($dataForm['email'])) {
      $where['email'] = $dataForm['email'];
    }
    if (isset($dataForm['telefone'])) {
      $where['telefone'] = $dataForm['telefone'];
    }
    if (isset($dataForm['cpf'])) {
      $where['cpf'] = $dataForm['cpf'];
    }
    if (isset($dataForm['endereco'])) {
      $where['endereco'] = $dataForm['endereco'];
    }

    return $where;
  }
}
