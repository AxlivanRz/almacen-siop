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
            'nombre_partida' => 'Papelería',
            'descripcion_partida' => 'Articulos de papelería',
            'abreviado' => 'PAP',
        ]);
        DB::table('partidas')->insert([
            'nombre_partida' => 'Tecnología',
            'descripcion_partida' => 'Articulos de tecnología',
            'abreviado' => 'TECN',
        ]);
        DB::table('unidad_medidas')->insert([
            'nombre_medida' => 'Pieza',
            'abreviado' => 'PZ',
        ]);
        DB::table('origen_recursos')->insert([
            'nombre_recurso' => 'SUB',
        ]);
        DB::table('proveedores')->insert([
            'razon_social' => 'Papelería el iris',
            'nombre_empresa' => 'El iris',
            'calle' => '5 de febrero',
            'colonia' => 'Sabinal',
            'codigo_postal' => '91275',
            'poblacion' => 'Perote',
            'estado' => 'Veracruz',
            'pais' => 'México',
            'telefono' => '2821075344',
            'email_proveedor' => 'iris@gmail.com',
        ]);
        DB::table('proveedores')->insert([
            'razon_social' => 'Centro de reparación',
            'nombre_empresa' => 'CAT',
            'calle' => 'Hidalgo',
            'colonia' => 'Centro',
            'codigo_postal' => '91270',
            'poblacion' => 'Perote',
            'estado' => 'Veracruz',
            'pais' => 'México',
            'telefono' => '2821075344',
            'email_proveedor' => 'cat@gmail.com',
        ]);
    }
}
