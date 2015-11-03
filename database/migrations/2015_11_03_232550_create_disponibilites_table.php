<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisponibilitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benevoles', function($table)
		{
			$table->increments('id');
			$table->string('commentaire')->nullable();
            $table->datetime('heure_debut');
            $table->datetime('heure_fin');
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
        Schema::drop('disponibilites');
    }
}
