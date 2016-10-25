<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTachesTable extends Migration
{

    public function up()
    {
         Schema::create('taches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('description')->nullable();
            $table->timestamps();
        });             
    }
    public function down()
    {
        //        
        Schema::drop('taches');  
    }
}
