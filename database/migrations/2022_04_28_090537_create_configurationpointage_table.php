<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationpointageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurationpointage', function (Blueprint $table) {
            $table->id();
            $table->double('lantitudeSociete') ;
            $table->double('longitudeSociete') ;
            $table->double('distanceInKM') ;
            $table->time('temps_denvoi') ;
            $table->integer('etat')->default(0)->comment('0 - desactive, 1 - active'); 
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
        Schema::dropIfExists('configurationpointage');
    }
}
