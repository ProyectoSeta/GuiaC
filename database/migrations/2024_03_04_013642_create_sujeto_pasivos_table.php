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
            $table->enum('rif_condicion',['G','J']);
            $table->string('rif_nro',12)->unique();
            $table->enum('artesanal',['No','Si']);
            $table->string('razon_social');
            $table->string('direccion');
            $table->string('tlf_movil',18);
            $table->string('tlf_fijo',18)->nullable();;
            $table->enum('ci_condicion_repr',['V','E']); 
            $table->string('ci_nro_repr',10);// ejemplo: E30524510 o v26854712
            $table->enum('rif_condicion_repr',['V','E']); 
            $table->string('rif_nro_repr',10);
            $table->string('name_repr');
            $table->string('tlf_repr',15);
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->enum('estado',['Verificando','Verificado','Rechazado']);
            $table->string('observaciones')->nullable();
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
