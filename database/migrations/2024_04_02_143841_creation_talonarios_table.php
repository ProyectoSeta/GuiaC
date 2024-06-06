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
            $table->foreign('id_solicitud')->references('id_solicitud')->on('solicituds')->onDelete('cascade');
            $table->integer('id_cantera')->unsigned();
            $table->foreign('id_cantera')->references('id_cantera')->on('canteras')->onDelete('cascade');
            $table->integer('id_sujeto')->unsigned();
            $table->foreign('id_sujeto')->references('id_sujeto')->on('sujeto_pasivos')->onDelete('cascade');
            $table->enum('tipo_talonario',['50']);
            $table->integer('desde');
            $table->integer('hasta');
            $table->string('qr')->nullable();

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
