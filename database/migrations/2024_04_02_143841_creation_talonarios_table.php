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
            $table->integer('id_solicitud')->unsigned();
            $table->integer('id_sujeto')->unsigned();
            $table->enum('tipo_talonario',['25','50']);
            $table->integer('desde');
            $table->integer('hasta');
            $table->date('fecha_emision');
            $table->date('fecha_recibido')->nullable();
            $table->date('fecha_retiro')->nullable();
            $table->foreign('id_solicitud')->references('id_solicitud')->on('solicituds')->onDelete('cascade');
            $table->foreign('id_sujeto')->references('id_sujeto')->on('sujeto_pasivos')->onDelete('cascade');
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
