<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AperturaCaja extends Model
{
    protected $table = 'aperturas_cajas';

    protected $fillable = [
        'caja_id',
        'user_aperturo_id',
        'user_cajero_id',
        'user_cerro_id',
        'estado',
        'fecha_apertura',
        'fecha_cierre',
        'monto',
        'sobrante',
        'faltante',
        'efectivo'
    ];

    public function user_cajero()
    {
        return $this->belongsTo(User::class);
    }

    public function user_aperturo()
    {
        return $this->belongsTo(User::class);
    }

    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }
}
