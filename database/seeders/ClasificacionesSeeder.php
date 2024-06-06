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
            'nombre_clf' => 'Declarado',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Sin Declarar',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Extemporanea',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Verificando',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Verificado',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Negado',
        ]);

        
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Aprobacion de Solicitudes',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Actualización de Estado - Solicitudes',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Nuevos Usuarios',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Canteras registradas',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Declaraciones',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Sujetos Pasivos',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Talonarios',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Control de Canteras',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Usuarios',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'UCD',
        ]);


        DB::table('clasificacions')->insert([
            'nombre_clf' => 'En Proceso',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Por retirar',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Entregado',
        ]);


        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Por enviar',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Enviado',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Recibido',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Retirado',
        ]);

    
    }
}
