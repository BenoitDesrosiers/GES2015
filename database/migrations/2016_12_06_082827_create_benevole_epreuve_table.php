<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Doctrine\DBAL\Statement;

class CreateBenevoleEpreuveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
    {
		DB::Statement('set foreign_key_checks = 0');
    	Schema::create('benevole_epreuve', function(Blueprint $table) {
    		$table->unsignedInteger('benevole_id');
    		$table->unsignedInteger('epreuve_id');
    		$table->foreign('benevole_id')
		    		->references('id')
		    		->on('benevoles')
		    		->onDelete('cascade')
		    		->onUpdate('cascade');
    		$table->foreign('epreuve_id')
		    		->references('id')
		    		->on('epreuve')
		    		->onDelete('cascade')
		    		->onUpdate('cascade');
    	});
    	DB::Statement('set foreign_key_checks = 1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('benevole_epreuve');
    }
}
