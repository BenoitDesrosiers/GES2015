<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvenementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('evenements', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nom');
			$table->unsignedInteger('epreuve_id');
			$table->boolean('finale')->nullable();
			$table->integer('division')->nullable();
			$table->char('section',1)->nullable();
			$table->dateTime('date_heure')->nullable();
			$table->string('type')->nullable();
			$table->timestamps();

			$table->foreign('epreuve_id')
					->references('id')
					->on('epreuves')
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
		Schema::drop('evenements');
	}

}
