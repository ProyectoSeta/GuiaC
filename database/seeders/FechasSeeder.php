<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FechasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fechas')->insert([
            'nombre' => 'cierre_libro',
            'fecha' => '1',
        ]);
        DB::table('fechas')->insert([
            'nombre' => 'inicio_declaracion',
            'fecha' => '1',
        ]);
        DB::table('fechas')->insert([
            'nombre' => 'fin_declaracion',
            'fecha' => '10',
        ]);
    }
}
