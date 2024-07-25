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
        Schema::create('qr_guias', function (Blueprint $table) {
            $table->increments('id_qr');
            $table->integer('key_correlativo_detalle')->unsigned();
            $table->foreign('key_correlativo_detalle')->references('correlativo')->on('detalle_talonarios')->onDelete('cascade');
            $table->integer('nro_guia')->unique();
            $table->string('qr');

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
