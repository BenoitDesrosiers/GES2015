<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sports', function($table)
		{
			$table->increments('id');
			$table->string('nom');
			$table->string('saison');
			$table->string('description_courte')->nullable();
			$table->string('url_logo')->nullable();
			$table->string('url_page_officielle')->nullable();
			$table->boolean('tournoi');
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
		Schema::drop('sports');
	}

}
