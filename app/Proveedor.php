<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'nombre_comercial',
        'nombre_legal',
        'nit',
        'direccion',
        'telefono',
        'email',
        'contacto1',
        'contacto2',
        'estado',
        'user_id',
    ];
}
