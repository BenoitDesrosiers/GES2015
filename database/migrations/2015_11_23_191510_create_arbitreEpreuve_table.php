<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArbitreEpreuveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arbitre_epreuve', function(Blueprint $table) {
			$table->unsignedInteger('arbitre_id');
			$table->unsignedInteger('epreuve_id');
			$table->foreign('arbitre_id')
					->references('id')
					->on('arbitres')
					->onDelete('cascade')
					->onUpdate('cascade');
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
    	Schema::drop('arbitre_epreuve');
    }
}
