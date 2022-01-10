<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaInsumo extends Model
{
    protected $table = 'categorias_insumos';

    protected $fillable = [
        'nombre',
        'user_id',
        'estado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
