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
            $table->enum('tipo_talonario',['25','50']);
            $table->integer('cantidad');
            $table->string('monto'); 
            $table->integer('id_pago')->unsigned();
            $table->foreign('id_pago')->references('id_pago')->on('pagos')->onDelete('cascade');
            $table->enum('estado',['Verificando','Negada','En proceso','Retirar','Retirado']);  
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
