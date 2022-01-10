<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenMaestro extends Model
{
    protected $table = 'ordenes_maestro';

    protected $fillable = [
        'localidad_id',
        'estado_id'
    ];


    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }


    public function ordenes(){
        return $this->hasMany(orden::class);
    }
}
