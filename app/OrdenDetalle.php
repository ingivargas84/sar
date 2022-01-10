<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenDetalle extends Model
{
    protected $table = 'ordenes_detalles';

    protected $fillable = [
        'orden_id',
        'producto_id',
        'cantidad',
        'precio',
        'subtotal',
        'comentario',
        'estado_id'
    ];

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function estado()
    {
        return $this->belongsTo(EstadoOrdenDetalle::class);
    }

    /*public function movimiento_insumo()
    {
        return $this->belongsTo(MovimientoInsumo::class);
    }*/
}
