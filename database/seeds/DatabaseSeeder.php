<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(UsersSeeder::class);
        $this->call(EstadosEmpleadosSeeder::class);
        $this->call(NegocioSeeder::class);
        $this->call(TiposRegistroSeeder::class);
        $this->call(CompraEstadoSeeder::class);
        $this->call(EstadosSeriesSeeder::class);
        $this->call(EstadosOrdenesSeeder::class);
        $this->call(EstadosOrdenesDetallesSeeder::class);
        //$this->call(TiposLocalidadesSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');        
    }
}
