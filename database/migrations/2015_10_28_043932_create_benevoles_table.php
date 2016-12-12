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
			$table->string('numTel');
			$table->string('numCell')->nullable();
			$table->string('courriel')->nullable();
            $table->string('accreditation');
            $table->string('sexe');
            $table->string('verification')->nullable();
            $table->date('naissance');
        
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
        Schema::drop('benevoles');
    }
}
