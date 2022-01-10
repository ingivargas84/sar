<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaMenu extends Model
{
    protected $table = 'categorias_menus';

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
