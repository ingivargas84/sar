<?php

use Illuminate\Database\Seeder;
use App\TipoRegistro;

class TiposRegistroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo = new TipoRegistro();
        $tipo->nombre = 'Con movimiento de inventario';
        $tipo->save();

        $tipo = new TipoRegistro();
        $tipo->nombre = 'Sin movimiento de inventario';
        $tipo->save();
    }
}
