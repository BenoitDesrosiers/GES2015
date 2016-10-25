<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateAdressesTable créée par Émilio G! à partir du 161018.
 */
class CreateAdressesTable extends Migration
{
	/**
	 * Crée la table 'Adresses' dans la BDD.
	 */
	public function up()
	{
		Schema::create('Adresses', function (Blueprint $table) {
			$table->increments('id');
			$table->string('Adresse');
			$table->string('Description')->nullable();
			$table->unsignedInteger('ParticipantId');
			$table->foreign('ParticipantId')
				->references('id')
				->on('participants')
				->onDelete('cascade')
				->onUpdate('cascade');
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
		Schema::drop('Adresses');
	}
}