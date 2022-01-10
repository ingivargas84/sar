<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'categoria_menu_id',
        'precio',
        'user_id',
        'estado',
        'destino_pedido_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categoria_menu()
    {
        return $this->belongsTo(CategoriaMenu::class);
    }

    public function destino_pedido()
    {
        return $this->belongsTo(DestinoPedido::class);
    }

    public function ordenes_dealles()
    {
        return $this->belongsTo(OrdenDetalle::class);
    }

}
