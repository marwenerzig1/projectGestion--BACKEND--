<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('days', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('day') ;
            $table->time('date_debut') ;
            $table->time('date_fin') ;
            $table->time('break_houres'); 
            $table->string('regular_houres')->nullable();  
            $table->time('date_finale'); 
            $table->integer('etat')->default(0)->comment('0 - work, 1 - weekend'); 
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
        Schema::dropIfExists('days');
    }
}
