<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateConditionsParticulieresTable créée par Émilio G! à partir du 161120.
 */
class CreateConditionsParticulieresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('conditions_particulieres', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nom')->unique();
			$table->string('description')->nullable();
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
		Schema::drop('conditions_particulieres');
    }
}
