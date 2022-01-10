<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DestinoPedido extends Model
{
    protected $table = 'destinos_pedidos';

    protected $fillable = [
        'destino',
        'user_id',
        'estado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
