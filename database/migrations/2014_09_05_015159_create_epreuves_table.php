<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpreuvesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('epreuves', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nom');
			$table->string('description')->nullable();
			$table->unsignedInteger('sport_id')->nullable();
			$table->timestamps();
			
			$table->foreign('sport_id')
					->references('id')
					->on('sports')
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
		Schema::drop('epreuves');
	}

}
