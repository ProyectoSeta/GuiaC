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
        Schema::create('asignacion_reservas', function (Blueprint $table) {
            $table->increments('id_asignacion');

            $table->integer('contribuyente')->unsigned();    ///////REGISTRADO / NO REGISTRADO
            $table->foreign('contribuyente')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade');

            $table->integer('id_sujeto')->unsigned()->nullable();
            $table->foreign('id_sujeto')->references('id_sujeto')->on('sujeto_pasivos')->onDelete('cascade');
            $table->integer('id_sujeto_notuser')->unsigned()->nullable();
            $table->foreign('id_sujeto_notuser')->references('id_sujeto_notuser')->on('sujeto_notusers')->onDelete('cascade');
           
            $table->integer('cantidad_guias');
            $table->string('motivo');
            $table->string('soporte')->nullable();

            $table->integer('estado')->unsigned(); /////////EN PROCESO - QR LISTO - RETIRADO
            $table->foreign('estado')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade');
            $table->dateTime('fecha_emision');
            $table->dateTime('fecha_entrega')->nullable();
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');

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
