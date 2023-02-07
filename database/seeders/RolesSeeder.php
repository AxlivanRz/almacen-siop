<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rols')->insert([
            'nombre_rol' => 'AdminTI',
            'slug' => 'ti',
             
        ]);
        DB::table('rols')->insert([
            'nombre_rol' => 'Almacen',
            'slug' => 'admin',
             
        ]);
        DB::table('rols')->insert([
            'nombre_rol' => 'Vales',
            'slug' => 'user',
             
        ]);
        DB::table('rols')->insert([
            'nombre_rol' => 'Capturista',
            'slug' => 'alm',
             
        ]);
    }
}
