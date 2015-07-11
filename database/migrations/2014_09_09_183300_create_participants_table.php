<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	        Schema::create('participants', function ($table) 
		{
			$table->increments('id');
			$table->string('nom');
			$table->string('prenom');
			$table->integer('numero');
			$table->unsignedInteger('region_id')->nullable();
			$table->integer('or')->nullable();
			$table->integer('argent')->nullable();
			$table->integer('bronze')->nullable();
			$table->float('points')->nullable();
			$table->boolean('equipe');
			$table->timestamps();
			
			$table->foreign('region_id')
					->references('id')
					->on('regions')
					->onDelete('cascade')
					->onUpdate('cascade');
			
		});

    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('participants');
    }
}