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
        Schema::create('detalle_reservas', function (Blueprint $table) {
            $table->increments('correlativo');
            $table->enum('tipo_talonario',['50']);
            $table->integer('cantidad');
            $table->integer('id_reserva')->unsigned();
            $table->foreign('id_reserva')->references('id_reserva')->on('reservas')->onDelete('cascade');

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
