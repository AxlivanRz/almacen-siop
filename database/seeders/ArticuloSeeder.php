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
            'descripcion_partida' => '2100.00',
            'abreviado' => 'PAP',
        ]);
        DB::table('partidas')->insert([
            'nombre_partida' => 'Limpieza',
            'descripcion_partida' => '2150.01',
            'abreviado' => 'LP',
        ]);
        DB::table('unidad_medidas')->insert([
            'nombre_medida' => 'Pieza',
            'abreviado' => 'PZ',
        ]);
        DB::table('origen_recursos')->insert([
            'nombre_recurso' => 'GC',
        ]);
        DB::table('origen_recursos')->insert([
            'nombre_recurso' => 'S16',
        ]);
        DB::table('origen_recursos')->insert([
            'nombre_recurso' => 'S17',
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
        DB::table('articulos')->insert([
            'clave_articulo' => '210.1',
            'nombre_articulo' => 'Papel Bond Blanco',
            'foto_articulo' => null,
            'ubicacion' => 'Anaquel 1',
            'observaciones' => 'Roca',
            'medida_id' => '1',
            'nombre_med' => 'Pieza',
            'partida_id' => '1',
        ]);
        DB::table('articulos')->insert([
            'clave_articulo' => '210.2',
            'nombre_articulo' => 'Papel Bond Cuadriculado',
            'foto_articulo' => null,
            'ubicacion' => 'Anaquel 1',
            'observaciones' => 'Roca',
            'medida_id' => '1',
            'nombre_med' => 'Pieza',
            'partida_id' => '1',
        ]);
        DB::table('articulos')->insert([
            'clave_articulo' => '211.1',
            'nombre_articulo' => 'Pinol 1LT',
            'foto_articulo' => null,
            'ubicacion' => 'Anaquel 5',
            'observaciones' => 'Etiquetada',
            'medida_id' => '1',
            'nombre_med' => 'Pieza',
            'partida_id' => '2',
        ]);
        DB::table('articulos')->insert([
            'clave_articulo' => '211.2',
            'nombre_articulo' => 'Ajax 1LT',
            'foto_articulo' => null,
            'ubicacion' => 'Anaquel 5',
            'observaciones' => 'Etiquetada',
            'medida_id' => '1',
            'nombre_med' => 'Pieza',
            'partida_id' => '2',
        ]);
    }
}
