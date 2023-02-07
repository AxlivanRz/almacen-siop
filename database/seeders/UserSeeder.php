<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador',
            'primer_apellido' => 'pruebas',
            'segundo_apellido' => 'dos',
            'nombre_usuario' => 'Administrador',            
            'contrasena' => Hash::make('Admin1'),
        ]);
        DB::table('rol_usuarios')->insert([
            'rol_id' => '1',
            'usuario_id' => '1',
        ]);
        DB::table('users')->insert([
            'name' => 'Axel Iván',
            'primer_apellido' => 'Torres',
            'segundo_apellido' => 'Ruiz',
            'nombre_usuario' => 'ivanrz',            
            'contrasena' => Hash::make('Rz1511'),
        ]);
        DB::table('rol_usuarios')->insert([
            'rol_id' => '3',
            'usuario_id' => '2',
        ]);
        DB::table('ups')->insert([
            'nombre_ups' => 'Obras Públicas',
            'descripcion_ups' => '1',
            'iniciales' => 'OBP',
        ]);
        DB::table('areas')->insert([
            'nombre_area' => 'Desarrollo Urbano',
            'descripcion_area' => 'DESUB',
            'up_id' => '1',
            'encargado_area' => 'Lic. Juán',
        ]);
        DB::table('areas')->insert([
            'nombre_area' => 'Archivo de Obras',
            'descripcion_area' => 'ARCHOB',
            'up_id' => '1',
            'encargado_area' => 'Lic. Adriana',
        ]);
    }
}
