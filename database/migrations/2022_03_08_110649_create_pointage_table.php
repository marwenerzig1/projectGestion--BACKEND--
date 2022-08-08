<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {  
        Schema::create('pointage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_employe') ;
            $table->foreign('id_employe')->references('id')->on('employe') ;
            $table->date('date') ;
            $table->time('temps_dentree') ;
            $table->time('date_de_sortie')->nullable(); 
            $table->time('totale_heures')->nullable(); 
            $table->time('break_heures'); 
            $table->time('net_heures')->nullable(); 
            $table->time('regular_heures'); 
            $table->time('overtime')->nullable(); 
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
        Schema::dropIfExists('pointage');
    }
}
