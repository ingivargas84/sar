<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $dates = ['fecha_nacimiento'];

    protected $fillable = [
        'nombres',
        'apellidos',
        'nit',
        'cui',
        'direccion',
        'telefono',
        'celular',
        'email',
        'fecha_nacimiento',
        'estado',
        'user_id',
    ];

    public function setFechaNacimientoAttribute($fecha_nacimiento)
    {
        $this->attributes['fecha_nacimiento'] = $fecha_nacimiento ? Carbon::parse($fecha_nacimiento) :null;
    }
}
