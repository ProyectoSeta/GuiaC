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
        Schema::create('sujeto_pasivos', function (Blueprint $table) {
            $table->increments('id_sujeto');
            $table->integer('id_user')->unsigned();
            $table->enum('tipo_sujeto',['explotador','comprador']);
            $table->string('rif',15)->unique(); // ejemplo: J30845671
            $table->string('razon_social');
            $table->string('direccion');
            $table->string('tlf_movil',18);
            $table->string('tlf_fijo',18);
            $table->string('ci_repr',15); // ejemplo: E30524510 o v26854712
            $table->string('rif_repr',15);
            $table->string('name_repr');
            $table->string('tlf_repr',18);
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sujeto_pasivos');
    }
};
