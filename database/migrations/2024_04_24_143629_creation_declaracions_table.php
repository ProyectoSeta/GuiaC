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
        Schema::create('declaracions', function (Blueprint $table) {
            $table->increments('id_declaracion');
            $table->integer('id_sujeto')->unsigned();
            $table->foreign('id_sujeto')->references('id_sujeto')->on('sujeto_pasivos')->onDelete('cascade'); 
            $table->integer('year_declarado');
            $table->integer('mes_declarado');
            $table->integer('nro_guias_emitidas');
            $table->integer('total_ucd');
            $table->float('monto_total');
            $table->float('valor_ucd_dia');
            $table->string('referencia');
            $table->enum('nota',['Pago a tiempo','Pago a destiempo']);
            $table->date('fecha_emision');
            $table->enum('estado',['Verificando','Verificada','Negada']);
            $table->string('observacion');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('declaracions');
    }
};
