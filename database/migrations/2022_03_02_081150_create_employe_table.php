<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employe', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom') ;
            $table->string('prenom');
            $table->integer('cin'); 
            $table->integer('telephone'); 
            $table->string('adresse'); 
            $table->date('date_de_naissance'); 
            $table->string('status');
            $table->double('solde_conge');  
            $table->double('salaire');  
            $table->integer('etat')->default(0)->comment('0 - employe, 1 - responsable, 3 - responsable_RH'); 
            $table->string('login')->unique();
            $table->string('password')->unique();
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
        Schema::dropIfExists('employe');
    }
}
