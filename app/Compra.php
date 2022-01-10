<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Compra extends Model
{
    protected $table = 'compras';

    protected $fillable = [
        'serie',
        'numero_doc',
        'fecha_compra',
        'fecha_factura',
        'total',
        'compra_estado_id',
        'proveedor_id'
    ];

    public function compra_estado()
    {
        return $this->belongsTo(CompraEstado::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function compras_detalle(){
        return $this->hasMany(CompraDetalle::class);
    }
}
