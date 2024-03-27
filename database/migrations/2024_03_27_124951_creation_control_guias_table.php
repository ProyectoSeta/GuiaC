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
            $table->increments('correlativo');
            $table->integer('id_talonario')->unsigned();
            $table->foreign('id_talonario')->references('id_talonario')->on('talonarios')->onDelete('cascade');
            $table->integer('id_sujeto')->unsigned();
            $table->foreign('id_sujeto')->references('id_sujeto')->on('sujeto_pasivos')->onDelete('cascade'); 
            $table->string('nro_guia')->unique();
            $table->string('nro_control')->unique();
            $table->date('fecha');
            $table->enum('tipo_guia',['Entrada','Salida']);
            $table->integer('id_cantera')->unsigned();
            $table->foreign('id_cantera')->references('id_cantera')->on('canteras')->onDelete('cascade'); 
            $table->string('razon_destinatario');
            $table->string('ci_destinatario',15);
            $table->string('tlf_destinatario',15);
            $table->string('destino');
            $table->integer('id_mineral')->unsigned();
            $table->foreign('id_mineral')->references('id_mineral')->on('minerals')->onDelete('cascade'); 
            $table->enum('unidad_medida',['Toneladas','Metros cúbicos']);
            $table->float('cantidad');
            $table->string('modelo_vehiculo');
            $table->string('placa');
            $table->string('nombre_conductor');
            $table->string('ci_conductor',15);
            $table->string('tlf_conductor',15);
            $table->string('hora_salida');
            $table->string('hora_llegada');
            $table->string('nro_factura');
            $table->enum('anulada',['No','Si']);
            $table->string('motivo')->nullable();;

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
