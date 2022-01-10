<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoRegistro extends Model
{
    protected $table = 'tipos_registro';

    protected $fillable = [
        'nombre'
    ];
}
