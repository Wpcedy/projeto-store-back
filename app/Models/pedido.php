<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pedido extends Model
{
    const STATUS_ABERTO = 'A';
    const STATUS_APROVADO = 'P';
    const STATUS_CANCELADO = 'C';

    protected $fillable = [
        'produtos',
        'status',
        'valorpedido',
        'datapedido',
        'cliente',
    ];
}
