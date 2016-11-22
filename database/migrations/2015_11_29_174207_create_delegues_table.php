<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeleguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegues', function ($table) {
            $table->increments('id');
			$table->string('nom');
			$table->string('prenom');
			$table->unsignedInteger('region_id');
			$table->unsignedInteger('role_pour_delegue_id');
			$table->boolean('accreditation');
			$table->boolean('sexe');
			$table->date('date_naissance');
			$table->string('adresse')->nullable();
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
        Schema::drop('delegues');
    }
}
