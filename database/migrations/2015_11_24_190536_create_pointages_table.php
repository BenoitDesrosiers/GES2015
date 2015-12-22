<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
    {
        Schema::create('pointages',function($table)
        {
            $table->unsignedInteger('sport_id');
            $table->unsignedInteger('position');
            $table->unsignedInteger('valeur');
			$table->timestamps();
            
            $table->primary(['sport_id', 'position']);
            
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
    	Schema::drop('pointages');
    }
}
