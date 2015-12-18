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
        Schema::create('evenements', function($table)
		{
            $table->increments('id');
			$table->integer('restaurant_id')
                    ->unsigned();
            $table->string('title');
            $table->boolean('isAllDay');
			$table->datetime('start');
			$table->datetime('end');
			$table->timestamps();

            $table->foreign('restaurant_id')
					->references('numero')
					->on('restaurant')
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
