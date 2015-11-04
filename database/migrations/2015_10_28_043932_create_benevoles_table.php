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
			$table->string('nom');
            $table->string('prenom');
			$table->string('adresse');
			$table->integer('numTel');
			$table->integer('numCell')->nullable();
			$table->string('courriel')->nullable();
            $table->unsignedInteger('disponibiliteId')->nullable();
            $table->string('accreditation');
            $table->string('verification')->nullable();
			$table->timestamps();

            $table->foreign('disponibiliteId')
					->references('id')
					->on('disponibilites')
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
        Schema::drop('benevoles');
    }
}
