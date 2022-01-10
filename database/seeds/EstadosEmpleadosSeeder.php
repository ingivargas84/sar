<?php

use Illuminate\Database\Seeder;
use App\EstadoEmpleado;

class EstadosEmpleadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado = new EstadoEmpleado();
        $estado->estado = 'Activo';
        $estado->save();

        $estado = new EstadoEmpleado();
        $estado->estado = 'Inactivo';
        $estado->save();

        $estado = new EstadoEmpleado();
        $estado->estado = 'Vacaciones';
        $estado->save();

        $estado = new EstadoEmpleado();
        $estado->estado = 'Suspendido';
        $estado->save();
       

    }
}
