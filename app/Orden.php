<?php

namespace App;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = 'ordenes';

    protected $fillable = [
        'user_id',
        'total',
        'cliente_id',
        'estado_id',
        'orden_maestro_id'
    ];

    public function estado_orden()
    {
        return $this->belongsTo(EstadoOrden::class);
    }

    /*public function localidades()
    {
        return $this->belongsToMany(Localidad::class);
    }*/

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function ordenes_detalles(){
        return $this->hasMany(OrdenDetalle::class);
    }

    /*public function getLocalidadesName(): Collection
    {
        return $this->localidades->pluck('nombre');
    }*/
}
