<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompraDetalle extends Model
{
    protected $table = 'compras_detalle';

    protected $fillable = [
        'insumo_id',
        'compra_id',
        'movimiento_insumo_id',
        'cantidad',
        'precio',
        'subtotal'
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function insumo()
    {
        return $this->belongsTo(Insumo::class);
    }

    public function movimiento_insumo()
    {
        return $this->belongsTo(MovimientoInsumo::class);
    }
}
