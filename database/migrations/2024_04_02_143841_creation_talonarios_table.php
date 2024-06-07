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
        Schema::create('talonarios', function (Blueprint $table) {
            $table->increments('id_talonario');
            $table->integer('id_solicitud')->unsigned()->nullable();;
            $table->foreign('id_solicitud')->references('id_solicitud')->on('solicituds')->onDelete('cascade');

            $table->integer('id_reserva')->unsigned()->nullable();;
            $table->foreign('id_reserva')->references('id_reserva')->on('reservas')->onDelete('cascade');

            $table->integer('desde');
            $table->integer('hasta');
            $table->integer('clase')->unsigned();
            $table->foreign('clase')->references('id_tipo')->on('tipos')->onDelete('cascade');

            $table->integer('estado')->unsigned();
            $table->foreign('estado')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade');

            $table->date('fecha_enviado_imprenta');
            $table->date('fecha_recibido_imprenta')->nullable();
            $table->date('fecha_retiro')->nullable();
            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talonarios');
    }
};
