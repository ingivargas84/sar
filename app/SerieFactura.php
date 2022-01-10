<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SerieFactura extends Model
{
    protected $table = 'series_facturas';
    
    protected $fillable=[
        'resolucion',
        'serie',     
        'fecha_resolucion',
        'fecha_vencimiento',
        'inicio',
        'fin',
        'estado',
        'user_id',
    ];
}
