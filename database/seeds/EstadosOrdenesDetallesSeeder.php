<?php

use Illuminate\Database\Seeder;
use App\EstadoOrdenDetalle;

class EstadosOrdenesDetallesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado = new EstadoOrdenDetalle();
        $estado->nombre = 'En Espera';
        $estado->save();

        $estado = new EstadoOrdenDetalle();
        $estado->nombre = 'Preparación';
        $estado->save();

        $estado = new EstadoOrdenDetalle();
        $estado->nombre = 'Preparada';
        $estado->save();
    }
}
