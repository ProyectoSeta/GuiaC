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
        Schema::create('emision_talonarios', function (Blueprint $table) {
            $table->increments('correlativo');
            $table->integer('id_solicitud')->unsigned();
            $table->foreign('id_solicitud')->references('id_solicitud')->on('solicituds')->onDelete('cascade');
            $table->enum('tipo_talonario',['50']);
            $table->integer('cantidad');

            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->date('fecha');
            
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
