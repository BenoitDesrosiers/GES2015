<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateTelephonesTable créée par Émilio G! à partir du 161018.
 */
class CreateTelephonesTable extends Migration
{
    /**
     * Crée la table 'Telephones' dans la BDD.
     */
    public function up()
    {
        Schema::create('Telephones', function (Blueprint $table) {
			$table->increments('id');
        	$table->string('numero');
			$table->string('description')->nullable();
			$table->unsignedInteger('participant_Id');
			$table->foreign('participant_Id')
				  ->references('id')
				  ->on('participants')
				  ->onDelete('cascade')
				  ->onUpdate('cascade');
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
		Schema::drop('telephones');
    }
}
