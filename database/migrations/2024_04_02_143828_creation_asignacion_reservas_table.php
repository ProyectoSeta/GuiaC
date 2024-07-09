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
            $table->integer('id_cantera')->unsigned()->nullable();
            $table->foreign('id_cantera')->references('id_cantera')->on('canteras')->onDelete('cascade');

            $table->integer('id_sujeto_notuser')->unsigned()->nullable();
            $table->foreign('id_sujeto_notuser')->references('id_sujeto_notuser')->on('sujeto_notusers')->onDelete('cascade');
            $table->integer('id_cantera_notuser')->unsigned()->nullable();
            $table->foreign('id_cantera_notuser')->references('id_cantera_notuser')->on('canteras_notusers')->onDelete('cascade');

            $table->integer('cantidad_guias')->unsigned();
            $table->dateTime('fecha');
            $table->integer('total_ucd');
            $table->string('soporte');
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');

            // $table->string('banco_emisor');
            // $table->integer('nro_referencia');
            // $table->string('banco_receptor');
            // $table->date('fecha_emision_pago');
            // $table->float('monto_transferido');
            // $table->string('referencia')->nullable();
            // $table->float('monto_total');

            

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
