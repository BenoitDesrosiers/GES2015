<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpreuveTerrainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('epreuve_terrain', function (Blueprint $table) {
    		$table->unsignedInteger('epreuve_id');
    		$table->unsignedInteger('terrain_id');
    		$table->foreign('epreuve_id')
	    		->references('id')
	    		->on('epreuves')
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
    	Schema::drop('epreuve_terrain');
    }
}
