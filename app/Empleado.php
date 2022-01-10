<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $dates = ['fecha_nacimiento', 'fecha_alta', 'fecha_baja'];

    protected $fillable = [
        'nombres',
        'apellidos',
        'nit',
        'emp_cui',
        'direccion',
        'telefono',
        'celular',
        'email',
        'fecha_alta',
        'fecha_baja',
        'fecha_nacimiento',
        'puesto_id',
        'estado_id',
        'user_id',
    ];

    public function puesto()
    {
        return $this->belongsTo(Puesto::class); //$empleado->puesto->nombre
    }

    public function estado()
    {
        return $this->belongsTo(EstadoEmpleado::class);
    }

    public function setFechaNacimientoAttribute($fecha_nacimiento)
    {
        $this->attributes['fecha_nacimiento'] = $fecha_nacimiento ? Carbon::parse($fecha_nacimiento) :null;
    }

    public function setFechaAltaAttribute($fecha_alta)
    {
        $this->attributes['fecha_alta'] = $fecha_alta ? Carbon::parse($fecha_alta) :null;
    }

    public function setFechaBajaAttribute($fecha_baja)
    {
        $this->attributes['fecha_baja'] = $fecha_baja ? Carbon::parse($fecha_baja) :null;
    }
}
