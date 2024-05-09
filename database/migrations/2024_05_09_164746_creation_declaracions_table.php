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
            $table->integer('id_libro')->unsigned();
            $table->foreign('id_libro')->references('id_libro')->on('libros')->onDelete('cascade');
            $table->integer('year_declarado');
            $table->integer('mes_declarado');
            $table->integer('nro_guias_declaradas');
            $table->integer('total_ucd');
            $table->float('monto_total');
            $table->integer('id_ucd')->unsigned();
            $table->foreign('id_ucd')->references('id')->on('ucds')->onDelete('cascade');
            $table->string('referencia')->nullable();
            $table->date('fecha');

            $table->integer('estado')->unsigned();
            $table->foreign('estado')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade'); /////VERIFICANDO, VERIFICADO, NEGADO
             
            $table->integer('tipo')->unsigned();
            $table->foreign('tipo')->references('id_tipo')->on('tipos')->onDelete('cascade');  //////DECLARACIÓN DE LIBRO, DECLARACION DE GUÍAS EXTEMPORANEAS
            $table->string('observaciones',400)->nullable();

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
