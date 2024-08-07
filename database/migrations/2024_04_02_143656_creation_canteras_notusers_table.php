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
        Schema::create('canteras_notusers', function (Blueprint $table) {
            $table->increments('id_cantera_notuser');
            $table->integer('id_sujeto_notuser')->unsigned();
            $table->foreign('id_sujeto_notuser')->references('id_sujeto_notuser')->on('sujeto_notusers')->onDelete('cascade');
            $table->string('nombre');
            $table->string('municipio_cantera');
            $table->string('parroquia_cantera');
            $table->string('lugar_aprovechamiento');
            
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
