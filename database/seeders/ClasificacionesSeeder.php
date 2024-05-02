<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClasificacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clasificacions')->insert([
            'nombre' => 'Declarado',
        ]);
        DB::table('clasificacions')->insert([
            'nombre' => 'Sin Declarar',
        ]);
        DB::table('clasificacions')->insert([
            'nombre' => 'Extemporanea',
        ]);
    
    }
}
