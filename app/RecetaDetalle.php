<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecetaDetalle extends Model
{
    protected $table = 'recetas_detalle';

    protected $fillable = [
        'insumo_id',
        'receta_id',
        'cantidad'
    ];

    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }

    public function insumo()
    {
        return $this->belongsTo(Insumo::class);
    }
}
