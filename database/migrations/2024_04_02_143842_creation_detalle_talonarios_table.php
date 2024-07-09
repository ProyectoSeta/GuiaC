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
        Schema::create('detalle_talonarios', function (Blueprint $table) {
            $table->increments('correlativo');
            $table->integer('id_talonario')->unsigned();
            $table->foreign('id_talonario')->references('id_talonario')->on('talonarios')->onDelete('cascade');

            $table->integer('id_cantera')->unsigned();
            $table->foreign('id_cantera')->references('id_cantera')->on('canteras')->onDelete('cascade');
            $table->integer('id_sujeto')->unsigned();
            $table->foreign('id_sujeto')->references('id_sujeto')->on('sujeto_pasivos')->onDelete('cascade');

            $table->integer('id_cantera_notuser')->unsigned()->nullable();
            $table->foreign('id_cantera_notuser')->references('id_cantera_notuser')->on('canteras_notusers')->onDelete('cascade');
            $table->integer('id_sujeto_notuser')->unsigned()->nullable();
            $table->foreign('id_sujeto_notuser')->references('id_sujeto_notuser')->on('sujeto_notusers')->onDelete('cascade');

            $table->integer('desde');
            $table->integer('hasta');
            $table->string('qr')->nullable();
            $table->integer('clase')->unsigned(); ///////////////REGULAR - RESERVA
            $table->foreign('clase')->references('id_tipo')->on('tipos')->onDelete('cascade');

            
            $table->integer('asignacion_talonario')->unsigned()->nullable(); ////////EN RESERVA - ASIGNADO (SOLO PARA TALONARIOS REGULARES)
            $table->foreign('asignacion_talonario')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade');


            $table->integer('id_solicitud_reserva')->unsigned()->nullable();
            $table->foreign('id_solicitud_reserva')->references('id_asignacion')->on('asignacion_reservas')->onDelete('cascade');

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
