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
        Schema::create('disponibilites', function($table)
		{
			$table->increments('id');
			$table->unsignedInteger('benevole_id');
            $table->string('title');
            $table->boolean('isAllDay');
			$table->datetime('start');
			$table->datetime('end');
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
