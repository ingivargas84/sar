<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompraCaja extends Model
{
    protected $table = 'compras_cajas';

    protected $fillable = [
        'caja_id',
        'user_id',
        'documento',
        'numero_doc',
        'descripcion',
        'total'
    ];

    public function caja(){
        return $this->belongsTo(Caja::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
