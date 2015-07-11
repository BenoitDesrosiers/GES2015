<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultatsTournoisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('resultats_tournois', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('evenement_id');
			$table->unsignedInteger('participant1_id');
			$table->unsignedInteger('participant2_id');
			$table->float('resultat1')->nullable();
			$table->float('resultat2')->nullable();
			$table->float('points1')->nullable();
			$table->float('points2')->nullable();
			$table->unsignedInteger('gagnant_id')->nullable();
			$table->dateTime('date_heure')->nullable();
			$table->timestamps();
			
			$table->foreign('evenement_id')
					->references('id')
					->on('evenements')
					->onDelete('cascade')
					->onUpdate('cascade');
			$table->foreign('participant1_id')
					->references('id')
					->on('participants')
					->onDelete('restrict')
					->onUpdate('cascade');
			$table->foreign('participant2_id')
					->references('id')
					->on('participants')
					->onDelete('restrict')
					->onUpdate('cascade');
			$table->foreign('gagnant_id')
					->references('id')
					->on('participants')
					->onDelete('restrict')
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
		Schema::drop('resultats_tournois');
	}

}