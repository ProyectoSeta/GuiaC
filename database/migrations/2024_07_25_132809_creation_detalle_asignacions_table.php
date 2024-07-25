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
        Schema::create('detalle_asignacions', function (Blueprint $table) {
            $table->increments('id_detalle_asignacion');
            $table->integer('id_asignacion')->unsigned();
            $table->foreign('id_asignacion')->references('id_asignacion')->on('asignacion_reservas')->onDelete('cascade');
            
            $table->integer('id_cantera')->unsigned()->nullable();
            $table->foreign('id_cantera')->references('id_cantera')->on('canteras')->onDelete('cascade');
            $table->integer('id_cantera_notuser')->unsigned()->nullable();
            $table->foreign('id_cantera_notuser')->references('id_cantera_notuser')->on('canteras_notusers')->onDelete('cascade');

            $table->string('nro_guia')->unique();
            $table->string('razon_destinatario')->nullable();
            $table->string('rif_destinatario',15)->nullable();
            $table->string('tlf_destinatario',15)->nullable();
            $table->string('municipio_destino')->nullable();
            $table->string('parroquia_destino')->nullable();
            $table->string('destino')->nullable();

            $table->integer('id_mineral')->unsigned();
            $table->foreign('id_mineral')->references('id_mineral')->on('minerals')->onDelete('cascade'); 
            $table->enum('unidad_medida',['Toneladas','Metros cúbicos']);
            $table->float('cantidad')->nullable();

            $table->string('modelo_vehiculo')->nullable();
            $table->string('placa')->nullable();
            $table->string('nombre_conductor')->nullable();
            $table->string('ci_conductor',15)->nullable();
            $table->string('tlf_conductor',15)->nullable();
            $table->string('capacidad_vehiculo')->nullable();
            $table->string('hora_salida')->nullable();
           
            $table->enum('anulada',['No','Si']);
            $table->string('motivo')->nullable();

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
