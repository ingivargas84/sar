<?php

use Illuminate\Database\Seeder;
use App\EstadoOrden;

class EstadosOrdenesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado = new EstadoOrden();
        $estado->nombre = 'Activa';
        $estado->save();

        $estado = new EstadoOrden();
        $estado->nombre = 'Despachada';
        $estado->save();

        $estado = new EstadoOrden();
        $estado->nombre = 'Cobrada';
        $estado->save();

        $estado = new EstadoOrden();
        $estado->nombre = 'Anulada';
        $estado->save();
    }
}
