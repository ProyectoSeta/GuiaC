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
        Schema::create('detalle_solicituds', function (Blueprint $table) {
            $table->increments('id_detalle');
            $table->enum('tipo_talonario',['50']);
            $table->integer('cantidad');
            $table->integer('id_solicitud')->unsigned();
            $table->foreign('id_solicitud')->references('id_solicitud')->on('solicituds')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_solicituds');
    }
};
