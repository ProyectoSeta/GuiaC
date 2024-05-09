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
            'nombre' => 'Declaración de Libro',
        ]);
        DB::table('tipos')->insert([
            'nombre' => 'Declaración de Guías Extemporáneas',
        ]);
    }
}
