<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'cajas';

    protected $fillable = [
        'nombre',
        'user_id',
        'estado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class); //$caja->user->name
    }

    public function aperturas()
    {
        return $this->hasMany(AperturaCaja::class);
    }

    public function movimientos_cajas()
    {
        return $this->hasMany(MovimientoCaja::class);
    }
}
