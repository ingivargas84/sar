<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $table = 'puestos';

    protected $fillable = [
        'nombre',
        'user_id',
        'estado'
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); //$puesto->user->name
    }
}
