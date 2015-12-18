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
			$table->integer('benevole_id')
                    ->unsigned();
            $table->string('title');
            $table->boolean('isAllDay');
			$table->datetime('start');
			$table->datetime('end');
			$table->timestamps();

            $table->foreign('benevole_id')
					->references('id')
					->on('benevoles')
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
        Schema::drop('disponibilites');
    }
}
