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
        Schema::create('control_guias', function (Blueprint $table) {
            $table->increments('id_control');
            $table->string('nro_guia')->unique();
            $table->string('nro_control')->unique();
            $table->enum('tipo_guia',['Entrada','Salida']);
            $table->integer('id_sujeto')->unsigned();
            $table->enum('mnm',['Mineral no metalico']);
            $table->float('metros');
            $table->float('toneladas');
            $table->string('rif_destinatario',15);
            $table->string('razon_destinatario');
            $table->string('destino');
            $table->date('fecha');
            $table->string('factura');
            $table->enum('anulado',['No','Si']);
            $table->foreign('id_sujeto')->references('id_sujeto')->on('sujeto_pasivos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_guias');
    }
};
