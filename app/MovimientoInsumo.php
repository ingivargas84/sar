<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoInsumo extends Model
{
    protected $table = 'movimientos_insumos';

    protected $fillable = [
        'insumo_id',
        'cantidad',
        'precio',
        'fecha_ingreso',
        'cantidad_convertida'
    ];

    public function insumo(){
        return $this->belongsTo(Insumo::class);
    }

    public function compras_detalle(){
        return $this->hasMany(CompraDetalle::class);
    }
}
