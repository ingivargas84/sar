<?php

use Illuminate\Database\Seeder;
use App\CompraEstado;

class CompraEstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado = new CompraEstado();
        $estado->nombre = 'Activa';
        $estado->save();

        $estado = new CompraEstado();
        $estado->nombre = 'Utilizada';
        $estado->save();

        $estado = new CompraEstado();
        $estado->nombre = 'Anulada';
        $estado->save();
    }
}
