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
        Schema::create('sujeto_notusers', function (Blueprint $table) {
            $table->increments('id_sujeto_notuser');
            $table->enum('rif_condicion',['G','J']);
            $table->string('rif_nro',12)->unique();
            $table->string('razon_social');
            $table->string('direccion');
            $table->string('tlf_movil',18);
            $table->enum('ci_condicion_repr',['V','E']); 
            $table->string('ci_nro_repr',10);// ejemplo: E30524510 o v26854712
            $table->string('name_repr');
            $table->string('tlf_repr',15);
            
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
