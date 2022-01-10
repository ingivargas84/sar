<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoEmpleado extends Model
{
    protected $table = 'estados_empleados';
    protected $fillable = [
        'estado',
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }
}
