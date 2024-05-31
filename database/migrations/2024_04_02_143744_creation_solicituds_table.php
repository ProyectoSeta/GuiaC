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
        Schema::create('solicituds', function (Blueprint $table) {
            $table->increments('id_solicitud');
            $table->integer('id_sujeto')->unsigned();
            $table->foreign('id_sujeto')->references('id_sujeto')->on('sujeto_pasivos')->onDelete('cascade');
            $table->integer('id_cantera')->unsigned();
            $table->foreign('id_cantera')->references('id_cantera')->on('canteras')->onDelete('cascade');
            $table->integer('id_ucd')->unsigned();
            $table->foreign('id_ucd')->references('id')->on('ucds')->onDelete('cascade');
            $table->string('banco_emisor');
            $table->integer('nro_referencia');
            $table->string('banco_receptor');
            $table->date('fecha_emision_pago');
            $table->float('monto_transferido');
            $table->string('referencia')->nullable();;
            $table->integer('total_ucd');
            $table->float('monto_total');
            $table->dateTime('fecha');
            $table->enum('estado',['Verificando','Negada','En proceso','Retirar','Retirado']);  
            $table->string('observaciones')->nullable();

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicituds');
    }
};
