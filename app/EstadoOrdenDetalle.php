<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoOrdenDetalle extends Model
{
    protected $table = 'estados_ordenes_detalles';

    protected $fillable = [
        'nombre'
    ];

    public function ordenes_detalles(){
        return $this->hasMany(OrdenDetalle::class);
    }
}
