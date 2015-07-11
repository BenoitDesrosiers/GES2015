<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvenementParticipantTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('evenement_participant', function(Blueprint $table) {
			$table->unsignedInteger('participant_id');
			$table->unsignedInteger('evenement_id');
			$table->foreign('participant_id')
					->references('id')
					->on('participants')
					->onDelete('cascade')
					->onUpdate('cascade');
			$table->foreign('evenement_id')
					->references('id')
					->on('evenements')
					->onDelete('cascade')
					->onUpdate('cascade');
			$table->float('points');
			$table->boolean('finaliste');
			$table->unsignedInteger('position');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('evenement_participant');
	}

}
