<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MineralesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $minerales = [  'Caliza (EN BRUTO)',
                        'Piedra Caliza (¾ - 1)',
                        'Arrocillo de Caliza (3/8)',
                        'Polvillo de Caliza',
                        'Carbonato de Calcio',
                        'Ripio',
                        'Dolomita - Dolomita (EN BRUTO)',
                        'Piedra Blanca Dolomita',
                        'Cal Hidratada',
                        'Cal Agrícola',
                        'Concreto',
                        'Cemento',
                        'Arena de Río',
                        'Arena Lavada',
                        'Arena Cernida',
                        'Gravilla ¾',
                        'Ceramicos',
                        'Arcillas',
                        'Adoquines',
                        'Gravilla (¾ - 1)',
                        'Bloques',
                        'Piedra Integral',
                        'Gavión',
                        'Granzón'
                    ];

        foreach ($minerales as $mineral) {
            DB::table('minerals')->insert([
                'mineral' => $mineral,
            ]);
        }
        
    }
}
