<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBenevolesSportsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('benevoles_sports', function(Blueprint $table) {
			$table->unsignedInteger('benevole_id');
			$table->unsignedInteger('sport_id');
			$table->foreign('benevole_id')
					->references('id')
					->on('benevoles')
					->onDelete('cascade')
					->onUpdate('cascade');
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
		Schema::drop('benevoles_sports');
	}
}