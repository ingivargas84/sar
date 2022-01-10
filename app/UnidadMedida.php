<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    protected $table = 'unidades_medida';

    protected $fillable = [
        'nombre',
        'abreviatura',
        'descripcion',
        'user_id',
        'estado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
