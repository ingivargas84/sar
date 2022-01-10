<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoCaja extends Model
{
    protected $table = 'movimientos_cajas';

    protected $fillable = [
        'caja_id',
        'user_id',
        'descripcion',
        'ingreso',
        'salida',
        'saldo',
    ];

    public function caja(){
        return $this->belongsTo(Caja::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
