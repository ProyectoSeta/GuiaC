<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detalle_talonario_reservas', function (Blueprint $table) {
            $table->increments('correlativo');
            $table->integer('id_talonario')->unsigned();
            $table->foreign('id_talonario')->references('id_talonario')->on('talonarios')->onDelete('cascade');

            $table->integer('id_asignacion')->unsigned();
            $table->foreign('id_asignacion')->references('id_asignacion')->on('asignacion_reservas')->onDelete('cascade');
            
            $table->integer('desde');
            $table->integer('hasta');
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
