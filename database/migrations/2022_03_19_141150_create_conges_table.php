<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCongesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {       //
        Schema::create('conges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_employe') ;  
            $table->foreign('id_employe')->references('id')->on('employe') ;
            $table->date('date_debut') ;
            $table->date('date_fin') ;
            $table->integer('nombre_jours') ;
            $table->string('cause') ;
            $table->date('date_demande') ;
            $table->integer('etat')->default(0)->comment('0 - en_cours, 1 - accepter, 2 - refuser'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conges');
    }
}
