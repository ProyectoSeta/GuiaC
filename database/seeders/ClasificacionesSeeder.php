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
            'nombre' => 'Aprobacion de Solicitudes',
        ]);
        DB::table('clasificacions')->insert([
            'nombre' => 'Actualización de Estado - Solicitudes',
        ]);
        DB::table('clasificacions')->insert([
            'nombre' => 'Nuevos Usuarios',
        ]);
        DB::table('clasificacions')->insert([
            'nombre' => 'Canteras registradas',
        ]);
        DB::table('clasificacions')->insert([
            'nombre' => 'Declaraciones',
        ]);
        DB::table('clasificacions')->insert([
            'nombre' => 'Sujetos Pasivos',
        ]);
        DB::table('clasificacions')->insert([
            'nombre' => 'Talonarios',
        ]);
        DB::table('clasificacions')->insert([
            'nombre' => 'Control de Canteras',
        ]);
        DB::table('clasificacions')->insert([
            'nombre' => 'Usuarios',
        ]);
        DB::table('clasificacions')->insert([
            'nombre' => 'UCD',
        ]);

    
    }
}
