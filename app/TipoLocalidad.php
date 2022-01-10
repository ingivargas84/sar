<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoLocalidad extends Model
{
    protected $table = 'tipos_localidad';

    protected $fillable = [
        'nombre',
        'user_id',
        'estado',
        'columnas',
        'filas'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function localidades()
    {
        return $this->hasMany(Localidad::class);
    }
}
