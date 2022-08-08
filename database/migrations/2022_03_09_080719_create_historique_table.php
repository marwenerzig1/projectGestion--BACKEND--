<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   //  'id_pointage','latitude','longitude','temps'   
        Schema::create('historique', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_pointage') ;
            $table->foreign('id_pointage')->references('id')->on('pointage') ;
            $table->double('latitude') ;
            $table->double('longitude') ;
            $table->integer('etat')->default(1)->comment('0 - debut, 1 - au_milieu, 2 - fin'); 
            $table->time('temps') ;
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
        Schema::dropIfExists('historique');
    }
}
