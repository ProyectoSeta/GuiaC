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
            $table->integer('id_cantera')->unsigned();
            $table->foreign('id_cantera')->references('id_cantera')->on('canteras')->onDelete('cascade');
            $table->integer('id_libro')->unsigned();
            $table->foreign('id_libro')->references('id_libro')->on('libros')->onDelete('cascade');
            $table->string('nro_guia')->unique();

            $table->integer('id_declaracion')->nullable()->unsigned();
            $table->foreign('id_declaracion')->references('id_declaracion')->on('declaracions')->onDelete('cascade');

            $table->date('fecha');
            
            $table->string('razon_destinatario');
            $table->string('ci_destinatario',15);
            $table->string('tlf_destinatario',15);
            $table->string('municipio_destino');
            $table->string('parroquia_destino');
            $table->string('destino');
            $table->string('nro_factura')->nullable();
            $table->date('fecha_facturacion')->nullable();
            $table->integer('id_mineral')->unsigned();
            $table->foreign('id_mineral')->references('id_mineral')->on('minerals')->onDelete('cascade'); 
            $table->enum('unidad_medida',['Toneladas','Metros cúbicos']);
            $table->float('cantidad_facturada')->nullable();
            $table->float('saldo_anterior')->nullable();
            $table->float('cantidad_despachada');
            $table->float('saldo_restante')->nullable();
            $table->string('modelo_vehiculo');
            $table->string('placa');
            $table->string('nombre_conductor');
            $table->string('ci_conductor',15);
            $table->string('tlf_conductor',15);
            $table->string('capacidad_vehiculo');
            $table->string('hora_salida');
           
            $table->enum('anulada',['No','Si']);
            $table->string('motivo')->nullable();

            $table->integer('estado')->nullable()->unsigned();
            $table->foreign('estado')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade'); ///////NULL, EXTEMPORANEA

            $table->integer('declaracion')->unsigned();
            $table->foreign('declaracion')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade'); /////SIN DECLARAR, DECLARADO

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
