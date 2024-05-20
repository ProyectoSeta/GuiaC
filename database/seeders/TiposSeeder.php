<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Declaración de Libro',
        ]);
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Declaración de Guías Extemporáneas',
        ]);
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Contribuyente',
        ]);
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Administrativo',
        ]);
    }
}
