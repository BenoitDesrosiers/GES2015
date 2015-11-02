<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBenevolesTable extends Migration
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
			$table->string('prenom');
			$table->string('nom');
			$table->string('adresse');
			$table->integer('numTel');
			$table->integer('numCell')->nullable();
			$table->string('courriel')->nullable();
            $table->string('disponibilite')->nullable();
            $table->string('accreditation');
            $table->string('verification')->nullable();
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
        Schema::drop('sports');
    }
}
