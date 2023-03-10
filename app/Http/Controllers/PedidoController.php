<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidoRequest;
use App\Models\Pedido as PedidoModel;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $dataForm = $request->all();

        $where = $this->filters($dataForm);

        $pedidos = PedidoModel::where($where)->orderBy($dataForm['ordercampo'], $dataForm['ordertipo'])->get();

        return response()->json($pedidos, 200);
    }

    public function get(Request $request)
    {
        $id = $request->route('id');

        $pedido = PedidoModel::where([
            'id' => $id,
        ])->get();

        return response()->json($pedido, 200);
    }

    public function new(PedidoRequest $request)
    {
        $dataForm = $request->all();
        $produtos = json_decode($dataForm['produtos'], true);

        $valor = 0;

        foreach ($produtos as $produto) {
            $valor += $produto['valor'];
        }

        $data = $this->createProduto($dataForm, $valor);

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

    protected function createProduto(array $data, $valor)
    {
        return PedidoModel::create([
            'produtos' => $data['produtos'],
            'status' => $data['status'],
            'valorpedido' => $valor,
            'datapedido' => new \DateTime(),
            'cliente' => $data['cliente'],
        ]);
    }

    protected function filters(array $dataForm)
    {
        $where = [];

        if (isset($dataForm['status'])) {
            switch (strtoupper($dataForm['status'])) {
                case 'ABERTO':
                    # code...
                    $where['status'] = PedidoModel::STATUS_ABERTO;
                    break;
                case 'APROVADO':
                    # code...
                    $where['status'] = PedidoModel::STATUS_APROVADO;
                    break;
                case 'CANCELADO':
                    # code...
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
