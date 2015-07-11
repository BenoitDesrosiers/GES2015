<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyEpreuvesTable extends Migration {

	/**
	 * Run the migrations.
	 * 
	 * Ajout des gagnants de l'or, argent, bronze pour une épreuve. 
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('epreuves',function($table)
		{
			$table->unsignedInteger('or_id')->nullable();
			$table->unsignedInteger('argent_id')->nullable();
			$table->unsignedInteger('bronze_id')->nullable();
				
			$table->foreign('or_id')
				->references('id')
				->on('participants')
				->onDelete('cascade')
				->onUpdate('cascade');
			$table->foreign('argent_id')
				->references('id')
				->on('participants')
				->onDelete('cascade')
				->onUpdate('cascade');
			$table->foreign('bronze_id')
				->references('id')
				->on('participants')
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
		Schema::table('epreuves', function($t)
		{
		
			$t->dropColumn('or_id');
			$t->dropColumn('argent_id');
			$t->dropColumn('bronze_id');
		});	
	}

}
