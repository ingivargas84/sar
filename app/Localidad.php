<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $table = 'localidades';

    protected $fillable = [
        'nombre',
        'tipo_localidad_id',
        'user_id',
        'estado',
        'ocupada'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*public function ordenes()
    {
        return $this->belongsToMany(Orden::class);
    }*/
    
    public function ordenes_maestro()
    {
        return $this->hasMany(OrdenMaestro::class);
    } 

    public function tipo_localidad()
    {
        return $this->belongsTo(TipoLocalidad::class);
    }

    public function ambiente()
    {
        return $this->belongsTo(TipoLocalidad::class);
    }
}
