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
        Schema::create('produccions', function (Blueprint $table) {
            $table->increments('id_produccion');
            $table->integer('id_cantera')->unsigned();
            $table->foreign('id_cantera')->references('id_cantera')->on('canteras')->onDelete('cascade');
            $table->integer('id_mineral')->unsigned();
            $table->foreign('id_mineral')->references('id_mineral')->on('minerals')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produccions');
    }
};
