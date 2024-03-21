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
        Schema::create('limite_guias', function (Blueprint $table) {
            $table->increments('cod');
            $table->integer('id_sujeto')->unsigned();
            $table->integer('total_guias_mes')->nullable();
            $table->string('mes_actual');
            $table->integer('total_guias_solicitadas_mes')->nullable();
            $table->foreign('id_sujeto')->references('id_sujeto')->on('sujeto_pasivos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('limite_guias');
    }
};
