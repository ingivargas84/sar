<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoOrden extends Model
{
    protected $table = 'estados_ordenes';

    protected $fillable = [
        'nombre'
    ];

    public function ordenes(){
        return $this->hasMany(Orden::class);
    }
}
