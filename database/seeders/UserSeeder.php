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
            'nombre_usuario' => 'Admin',            
            'contrasena' => Hash::make('a123456'),
        ]);
        DB::table('rol_usuarios')->insert([
            'rol_id' => '3',
            'usuario_id' => '1',
        ]);
    }
}
