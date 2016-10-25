<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBenevoleTerrainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('benevole_terrain', function(Blueprint $table) {
    		$table->unsignedInteger('benevole_id');
    		$table->unsignedInteger('terrain_id');
    		$table->foreign('benevole_id')
    		->references('id')
    		->on('benevoles')
    		->onDelete('cascade')
    		->onUpdate('cascade');
    		$table->foreign('terrain_id')
    		->references('id')
    		->on('terrains')
    		->onDelete('cascade')
    		->onUpdate('cascade');
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('benevole_terrain');
    }
}
