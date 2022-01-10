<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompraEstado extends Model
{
    protected $table = 'compra_estados';

    protected $fillable = [
        'nombre'
    ];
}
