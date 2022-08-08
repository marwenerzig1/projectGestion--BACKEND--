<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraitementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {  
        Schema::create('traitement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_conge') ;  
            $table->foreign('id_conge')->references('id')->on('conges') ;
            $table->unsignedBigInteger('id_responsable') ;  
            $table->foreign('id_responsable')->references('id')->on('employe') ;
            $table->integer('etat')->default(0)->comment('0 - accepter, 1 - refuser'); 
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
        Schema::dropIfExists('traitement');
    }
}
