<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $table = 'insumos';

    protected $fillable = [
        'nombre',
        'unidad_id',
        'categoria_insumo_id',
        'medida_id',
        'cantidad_medida',
        'stock_minimo',
        'user_id',
        'estado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categoria_insumo()
    {
        return $this->belongsTo(CategoriaInsumo::class);
    }

    public function unidad_medida()
    {
        return $this->belongsTo(UnidadMedida::class);
    }
}
