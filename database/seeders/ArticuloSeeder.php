<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('partidas')->insert([
            'nombre_partida' => 'partida',
            'descripcion_partida' => 'prueba',
            'abreviado' => 'pr',
        ]);
        DB::table('unidad_medidas')->insert([
            'nombre_medida' => 'Pieza',
            'abreviado' => 'PZ',
        ]);
       
    }
}
