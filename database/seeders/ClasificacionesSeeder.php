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
        DB::table('clasificacions')->insert([
            'nombre' => 'Verificando',
        ]);
        DB::table('clasificacions')->insert([
            'nombre' => 'Verificado',
        ]);
        DB::table('clasificacions')->insert([
            'nombre' => 'Negado',
        ]);
        DB::table('clasificacions')->insert([
            'nombre' => 'Declaración de Libro',
        ]);
        DB::table('clasificacions')->insert([
            'nombre' => 'Declaración de Guías Extemporaneas',
        ]);
    
    }
}
