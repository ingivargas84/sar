<?php

use Illuminate\Database\Seeder;
use App\TipoLocalidad;

class TiposLocalidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo = new TipoLocalidad();
        $tipo->nombre = 'Mesas';
        $tipo->user_id = 1;
        $tipo->save();
    }
}
